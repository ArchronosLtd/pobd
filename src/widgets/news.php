<?php
 
class NewsScroller extends WP_Widget {
 
    function __construct() {

      $widget_options = array (
        'classname' => 'arch_news_scroller_widget',
        'description' => 'Show image with title.'
      );
 
      parent::__construct(
          'arch_news_scroller_widget',  // Base ID
          'News scroller',   // Name
          $widget_options
      );

      add_action( 'widgets_init', function() {
          register_widget( 'NewsScroller' );
      });
    }
 
    public $args = array(
        'before_title'  => '<h4 class="widget-title">',
        'after_title'   => '</h4>',
        'before_widget' => '<div class="widget-wrap">',
        'after_widget'  => '</div></div>'
    );
 
    public function widget( $args, $instance ) {    
      $image = wp_get_attachment_image_src(intval($instance['background_image']), 'feature-block-saintmarks', false, array('class' => 'p-1 w-100'));
      $image = $image[0];

      $indentClass = '';
      if($instance['indent_title']) {
        $indentClass = ' px-2';
      }

      echo $args['before_widget'];

      echo '<div class="container px-0">';
        echo '<div class="row news">';
          echo '<div class="col">';
            echo '<h1 class="mt-0' . $indentClass . '">' . $instance['title'] . '</h1>';
    
            $query = new WP_Query(array(
              'posts_per_page' => intval($instance['news_items']), /* how many post you want to display */
              'offset' => 0,
              'orderby' => 'post_date',
              'order' => 'DESC',
              'post_type' => 'post', /* your post type name */
              'post_status' => 'publish'
            ));

            echo '<div id="news-wrapper">';
              echo '<div style="width: ' . (($query->post_count * 318.8) - 18) . 'px">';
                while ($query->have_posts()) {
                  $query->the_post();

                  $link = get_the_permalink();
                  
                  echo '<div class="news-item">';
                    echo '<a href="' . $link . '" class="feature-image d-flex align-items-center justify-content-center">';
                      if(has_post_thumbnail()) {
                        echo the_post_thumbnail('post-saintmarks-news-reel', array(
                          'class' => 'w-100 h-auto'
                        ));
                      }
                      else {
                        echo '<img src="https://unsplash.it/640/425?random" />';
                      }
                    echo '</a>';
                  
                    echo '<a href="' . $link . '" class="details excerpt d-block justify-content-center">';
                      echo '<h2>' . get_the_title() . '</h2>';
                
                      the_excerpt();
                    echo '</a>';
                  echo '</div>';
                }
              echo '</div>';
            echo '</div>';
          echo '</div>';
        echo '</div>';
      echo '</div>';

      echo $args['after_widget'];
    }
 
    public function form( $instance ) {
      $title = ! empty( $instance['title'] ) ? $instance['title'] : esc_html__( '', 'text_domain' );
      $news_items = ! empty( $instance['news_items'] ) ? $instance['news_items'] : esc_html__( '', 'text_domain' );
      $indent_title = ! empty( $instance['indent_title'] ) && $instance['indent_title'] == '1' ? true : false;
      
      ?>

      <p>
        <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php echo esc_html__( 'Title:', 'text_domain' ); ?></label>
        <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
      </p>

      <p>
        <label for="<?php echo esc_attr( $this->get_field_id( 'news_items' ) ); ?>"><?php echo esc_html__( 'Number of items to display:', 'text_domain' ); ?></label>
        <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'news_items' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'news_items' ) ); ?>" type="number" value="<?php echo esc_attr( $news_items ); ?>">
      </p>

      <p>
        <label for="<?php echo esc_attr( $this->get_field_id( 'indent_title' ) ); ?>">Indent title:</label>

        <label class="switch">
        <input <?php echo $indent_title ? 'checked' : ''; ?> id="<?php echo esc_attr( $this->get_field_id( 'indent_title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'indent_title' ) ); ?>" type="checkbox" value="1">
          <span class="slider round"></span>
        </label>
      </p>
      
      <?php
 
    }
 
    public function update( $new_instance, $old_instance ) {
 
        $instance = array();

 
        $instance['title'] = ( !empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        $instance['news_items'] = ( !empty( $new_instance['news_items'] ) ) ? strip_tags( $new_instance['news_items'] ) : '10';
        $instance['indent_title'] = ( !empty( $new_instance['indent_title'] ) ) ? $new_instance['indent_title'] : '0';
 
        return $instance;
    }
 
}
$newsScroller = new NewsScroller();