<?php
 
class FutureEvents extends WP_Widget {
 
    function __construct() {

      $widget_options = array (
        'classname' => 'arch_future_events_widget',
        'description' => 'Show future events in a list.'
       );
 
      parent::__construct(
          'arch_future_events_widget',  // Base ID
          'Future events',   // Name
          $widget_options
      );

      add_action( 'widgets_init', function() {
          register_widget( 'FutureEvents' );
      });
    }
 
    public $args = array(
        'before_title'  => '<h4 class="widget-title">',
        'after_title'   => '</h4>',
        'before_widget' => '<div class="widget-wrap">',
        'after_widget'  => '</div></div>'
    );
 
    public function widget( $args, $instance ) {
        global $EM_Event;
        $emEvents = EM_Events::get(array('limit' => $instance['number_of_events']));
        $showIcon = $instance['show_location_icon'] == '1' ? true : false;
        
        echo $args['before_widget'];

        echo '<div class="container next-events">';
          echo '<div class="row">';
            echo '<div class="col px-0">';

 
        if ( ! empty( $instance['title'] ) ) {
            echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
        }

          echo '</div>';
        echo '</div>';

        if (count($emEvents) == 0) {
          echo '<div class="row row-span-' . $instance['row_span'] . '">';
            echo '<div class="col px-0">';
              echo '<p>No upcoming events to show.</p>';
            echo '</div>';
          echo '</div>';
        } else {
          echo '<div class="events-scroller row row-span-' . $instance['row_span'] . '">';
            echo '<div class="events-wrapper">';
              foreach ($emEvents as $event) {
                $location = em_get_location($event->location_id); 
                $metaData = get_post_meta($location->post_id, 'arch_location_logo', true);
                $attachment = intval($metaData);
                $image = wp_get_attachment_image_src($attachment, 'event-saintmarks-thumbnail', false, array('class' => 'p-1 w-100'));
                $startDate = new DateTime ($event->event_start_date . ' ' . $event->start_time);
                $endDate = new DateTime ($event->event_end_date . ' ' . $event->end_time);

                echo '<a href="' . get_the_permalink($event->post_id) .'" class="row event" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Event at ' . $location->name .'">';
                  echo '<div class="col date h-100 px-0">';
                    echo '<span class="day">' . $startDate->format('d') . '</span>';
                    echo '<span class="month">' . $startDate->format('M') . '</span>';
                  echo '</div>';

                  if ($image && $showIcon) {
                    echo '<div class="col thumbnail h-100 d-flex align-items-center justify-content-center p-1">';
                      echo '<img src="' . wp_get_attachment_image_src($attachment, 'event-saintmarks-thumbnail', false, array('class' => 'p-1 w-100'))[0] . '" class="p-1 w-100" />';
                    echo '</div>';
                  }
                  
                  if (has_post_thumbnail($event->post_id)) {
                    echo '<div class="col thumbnail h-100 d-flex align-items-center justify-content-center">';
                      echo get_the_post_thumbnail($event->post_id, 'event-saintmarks-thumbnail');
                    echo '</div>';
                  }

                  echo '<div class="col details h-100 text-truncate">';
                    echo '<h2 class="py-0 my-0">' . $event->event_name . '</h2>';
                    echo '<span>' . $startDate->format('H:i') . ' - ' . $endDate->format('H:i') . '</span>';
                  echo '</div>';
                echo '</a>';
              }
            echo '</div>';
          echo '</div>';
        }

        echo '</div>';
 
        echo $args['after_widget'];
 
    }
 
    public function form( $instance ) {
      $title = ! empty( $instance['title'] ) ? $instance['title'] : esc_html__( '', 'text_domain' );
      $number_of_events = ! empty( $instance['number_of_events'] ) ? $instance['number_of_events'] : esc_html__( '3', 'text_domain' );
      $row_span = ! empty( $instance['row_span'] ) ? $instance['row_span'] : esc_html__( '1', 'text_domain' );
      $show_location_icon = ! empty( $instance['show_location_icon'] ) && $instance['show_location_icon'] == '1' ? true : false;
      
      ?>
      <p>
        <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php echo esc_html__( 'Title:', 'text_domain' ); ?></label>
        <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
      </p>
      
      <p>
        <label for="<?php echo esc_attr( $this->get_field_id( 'number_of_events' ) ); ?>"><?php echo esc_html__( 'Number of events to show:', 'text_domain' ); ?></label>
        <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'number_of_events' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'number_of_events' ) ); ?>" type="number" value="<?php echo esc_attr( $number_of_events ); ?>">
      </p>

      <p>
        <label for="<?php echo esc_attr( $this->get_field_id( 'row_span' ) ); ?>"><?php echo esc_html__( 'Rows to span:', 'text_domain' ); ?></label>
        <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'row_span' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'row_span' ) ); ?>" type="number" value="<?php echo esc_attr( $row_span ); ?>">
      </p>

      <p>
        <label for="<?php echo esc_attr( $this->get_field_id( 'show_location_icon' ) ); ?>">Show location icon:</label>

        <label class="switch">
        <input <?php echo $show_location_icon ? 'checked' : ''; ?> id="<?php echo esc_attr( $this->get_field_id( 'show_location_icon' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'show_location_icon' ) ); ?>" type="checkbox" value="1">
          <span class="slider round"></span>
        </label>
      </p>


      <style>
          /* The switch - the box around the slider */
          .switch {
            position: relative;
            display: inline-block;
            width: 60px;
            height: 34px;
          }

          /* Hide default HTML checkbox */
          .switch input {
            opacity: 0;
            width: 0;
            height: 0;
          }

          /* The slider */
          .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            -webkit-transition: .4s;
            transition: .4s;
          }

          .slider:before {
            position: absolute;
            content: "";
            height: 26px;
            width: 26px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            -webkit-transition: .4s;
            transition: .4s;
          }

          input:checked + .slider {
            background-color: #2196F3;
          }

          input:focus + .slider {
            box-shadow: 0 0 1px #2196F3;
          }

          input:checked + .slider:before {
            -webkit-transform: translateX(26px);
            -ms-transform: translateX(26px);
            transform: translateX(26px);
          }

          /* Rounded sliders */
          .slider.round {
            border-radius: 34px;
          }

          .slider.round:before {
            border-radius: 50%;
          }
        </style>

        <?php
 
    }
 
    public function update( $new_instance, $old_instance ) {
 
        $instance = array();

 
        $instance['title'] = ( !empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        $instance['show_location_icon'] = ( !empty( $new_instance['show_location_icon'] ) ) ? $new_instance['show_location_icon'] : '0';
        $instance['number_of_events'] = ( !empty( $new_instance['number_of_events'] ) ) ? $new_instance['number_of_events'] : '0';
        $instance['row_span'] = ( !empty( $new_instance['row_span'] ) ) ? $new_instance['row_span'] : '1';
 
        return $instance;
    }
 
}
$futureEvents = new FutureEvents();