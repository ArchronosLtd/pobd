<?php
 
class FeatureBlock extends WP_Widget {
 
    function __construct() {

      $widget_options = array (
        'classname' => 'arch_feature_block_widget',
        'description' => 'Show image with title.'
      );

      add_action('admin_enqueue_scripts', array($this, 'scripts'));
 
      parent::__construct(
          'arch_feature_block_widget',  // Base ID
          'Feature block',   // Name
          $widget_options
      );

      add_action( 'widgets_init', function() {
          register_widget( 'FeatureBlock' );
      });
    }
 
    public $args = array(
        'before_title'  => '<h4 class="widget-title">',
        'after_title'   => '</h4>',
        'before_widget' => '<div class="widget-wrap">',
        'after_widget'  => '</div></div>'
    );

    public function scripts() {
      wp_enqueue_script( 'media-upload' );
      wp_enqueue_media();
      wp_enqueue_script('our_admin', get_template_directory_uri() . '/src/scripts/widgets.js', array('jquery'));
    }
 
    public function widget( $args, $instance ) {    
      $image = wp_get_attachment_image_src(intval($instance['background_image']), 'feature-block-saintmarks', false, array('class' => 'p-1 w-100'));
      $image = $image[0];

      echo $args['before_widget'];

      echo '<div class="container feature-block" style="background-image: url(' . $image . ')">';
        echo '<div class="row h-100">';

          echo '<div class="col h-100 feature-content">';
            echo $args['before_title'] . '<a class="p-0" style="font-size: 100%;" href="' . $instance['link'] . '">' . apply_filters( 'widget_title', $instance['title'] ) . '</a>' . $args['after_title'];
          echo '</div>';

        echo '</div>';
      echo '</div>';

      echo $args['after_widget'];
    }
 
    public function form( $instance ) {
      $title = ! empty( $instance['title'] ) ? $instance['title'] : esc_html__( '', 'text_domain' );
      $image = ! empty( $instance['background_image'] ) ? $instance['background_image'] : esc_html__( '', 'text_domain' );
      $link = ! empty( $instance['link'] ) ? $instance['link'] : esc_html__( '', 'text_domain' );
      
      ?>
      <p>
        <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php echo esc_html__( 'Title:', 'text_domain' ); ?></label>
        <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
      </p>

      <p>
        <label for="<?php echo esc_attr( $this->get_field_id( 'link' ) ); ?>"><?php echo esc_html__( 'Title link:', 'text_domain' ); ?></label>
        <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'link' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'link' ) ); ?>" type="url" value="<?php echo esc_attr( $link ); ?>">
      </p>
      
      <p>
        <label for="<?php echo $this->get_field_id( 'image' ); ?>"><?php _e( 'Image:' ); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id( 'background_image' ); ?>" name="<?php echo $this->get_field_name( 'background_image' ); ?>" type="text" value="<?php echo $image; ?>" />
        <button class="upload_image_button button button-primary">Upload Image</button>
      </p>

      <script>registerMediaButtons()</script>
      
      <?php
 
    }
 
    public function update( $new_instance, $old_instance ) {
 
        $instance = array();

 
        $instance['title'] = ( !empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        $instance['background_image'] = ( !empty( $new_instance['background_image'] ) ) ? $new_instance['background_image'] : '';
        $instance['link'] = ( !empty( $new_instance['link'] ) ) ? strip_tags( $new_instance['link'] ) : '';
 
        return $instance;
    }
 
}
$featureBlock = new FeatureBlock();