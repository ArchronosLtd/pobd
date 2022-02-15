<?php

define('SAINT_MARKS_DIR', __DIR__);
define('NEWSLETTER_LOG_LEVEL', 4);

include_once('src/metaboxes/meta_box.php');

require_once('src/types/sermon/meta-box.php');

require_once('src/extensions/em.php');
require_once('src/extensions/wordpress-menu.php');
require_once('src/extensions/topmenu-walker.php');
require_once('src/extensions/newsletter.php');
require_once('src/types/location/meta-box.php');
require_once('src/types/all/message-metabox.php');
require_once('src/widgets/events.php');
require_once('src/widgets/feature-block.php');
require_once('src/widgets/news.php');
// require_once('src/admin/users.php');
// require_once('src/extensions/wordpress-login.php');
// require_once('src/extensions/wordpress-profile.php');

// require_once('src/types/staff/type.php');

// require_once('src/admin/header.php');
// require_once('src/admin/box1_customizer.php');
// require_once('src/admin/box2_customizer.php');
// require_once('src/admin/feature-blocks.php');
require_once('src/admin/footer.php');

add_theme_support('post-thumbnails');
add_image_size('feature-block-saintmarks', 3000, 600);
add_image_size('post-saintmarks-header', 3000, 600);
add_image_size('post-saintmarks-mobile-header', 1000, 200);
add_image_size('post-saintmarks-news-reel', 600, 240);
add_image_size('event-saintmarks-thumbnail', 100, 100);

// Creates the link tag
function inc_manifest_link() {   
        echo '<link rel="manifest" href="'.get_template_directory_uri().'/manifest.json">';
}
add_action( 'wp_head', 'inc_manifest_link' );

function script_loader_tag($tag, $handle, $src) {
	if ($handle === 'popper' || $handle === 'bootstrap') {
		if (false === stripos($tag, 'async')) {
			$tag = str_replace(' src', ' async="async" src', $tag);
		}
		
		if (false === stripos($tag, 'defer')) {
			$tag = str_replace('<script ', '<script defer ', $tag);	
		}	
	}
	return $tag;
}
add_filter('script_loader_tag', 'script_loader_tag', 10, 3);

function my_excerpt_length($length)
{
    return 15;
}
add_filter('excerpt_length', 'my_excerpt_length');

add_action('wp_enqueue_scripts', 'wpdocs_dequeue_script', 100);
function wpdocs_dequeue_script()
{
    wp_dequeue_script('jquery-ui-widget');
    wp_dequeue_script('jquery-ui-position');
    wp_dequeue_script('jquery-ui-mouse');
    wp_dequeue_script('jquery-ui-sortable');
    wp_dequeue_script('jquery-ui-datepicker');
    wp_dequeue_script('jquery-ui-menu');
    wp_dequeue_script('jquery-ui-controlgroup');
    wp_dequeue_script('jquery-ui-checkboxradio');
    wp_dequeue_script('jquery-ui-button');
    wp_dequeue_script('events-manager');
    wp_dequeue_script('events-manager-pro');
    wp_dequeue_script('jquery-ui-core');
    wp_dequeue_script('jquery-ui-widget');
    wp_dequeue_script('jquery');
    wp_dequeue_script('wp-bootstrap-starter-bootstrapjs');
    wp_dequeue_script('wp-bootstrap-starter-popper');

    wp_dequeue_style('events-manager');

    if (get_post_type() == 'event' || get_post_type() == 'location') {
        wp_enqueue_script('events-manager');
        wp_enqueue_script('events-manager-pro');
        wp_enqueue_style('events-manager');
    }
}

// import parent themes
add_action('wp_enqueue_scripts', 'theme_enqueue_scripts', 500);
function theme_enqueue_scripts()
{
    wp_register_script('popper', ("https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"), false);
    wp_register_script('bootstrap', ("https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"), array('popper'), false);
    wp_register_script( 'youtube', 'https://www.youtube.com/iframe_api', array(), '1.0.0' );
    wp_register_script( 'livestream', get_template_directory_uri() . '/src/scripts/live-video.js', array('youtube'), '1.0.0' );
    wp_register_script( 'cookies', get_template_directory_uri() . '/src/scripts/cookie-banner.js', array('bootstrap'), '1.0.0' );
    wp_enqueue_script('bootstrap');
    wp_enqueue_script('saintmarks_dynamic_effects');
    wp_enqueue_script('cookies');

    $eventDetails = liveEvent();
    if($eventDetails['isLive'] && get_post_type() != 'event') {
        wp_enqueue_script( 'livestream' );
        wp_localize_script( 'livestream', 'event_vars', $eventDetails );
        wp_enqueue_script('saintmarks_message_modal');
    }

    if(get_post_type() == 'event') {
        $eventDetails = array(
            'isLive' => false,
            'event' => array(
                'event_attributes' => array(
                    'service_video' => get_post_meta(get_the_id(), 'service_video', true)
                )
            )
        );

        wp_enqueue_script( 'livestream' );
        wp_localize_script( 'livestream', 'event_vars', $eventDetails );
        wp_enqueue_script('saintmarks_message_modal');
    }
    
    wp_register_style('saintmarks', get_template_directory_uri() . '/style.css', array(), '1.0');
    wp_enqueue_style('saintmarks');

}

function front_end_scripts()
{
    wp_register_script('saintmarks_registration', get_template_directory_uri() . '/src/scripts/registration.js', array(), true);
    wp_register_style('saintmarks_registration', get_template_directory_uri() . '/registration.css', array(), '1.0', 'screen');

    wp_register_script('saintmarks_dynamic_effects', get_template_directory_uri() . '/src/scripts/dynamisim.js', array('bootstrap'), true);
    wp_register_script('saintmarks_message_modal', get_template_directory_uri() . '/src/scripts/message-modal.js', array('bootstrap'), true);
}
add_action('wp_enqueue_scripts', 'front_end_scripts');


add_action('admin_enqueue_scripts', 'theme_enqueue_admin_scripts', 500);
function theme_enqueue_admin_scripts($hook)
{
    wp_register_script('tinyMCE', 'https://cdn.ckeditor.com/4.17.1/standard/ckeditor.js');
    wp_register_script('tinyMCELoad', get_template_directory_uri() . '/src/scripts/tiny-mce-init.js', array('tinyMCE'), true);
    wp_enqueue_script('events-manager');
    wp_enqueue_script('tinyMCELoad');
}

// register menus
function wpb_custom_new_menu()
{
    // register_nav_menu('user', __('User navigation'));
    register_nav_menu('main', __('Main navigation'));
    register_nav_menu('topmenu', __('Top bar'));
    // register_nav_menu('policies', __('Policies menu'));
}
add_action('init', 'wpb_custom_new_menu');

function saintmarks_pending_role()
{
    $roles_set = get_option('saintmarks_roles_set');
    if (!$roles_set) {
        add_role('pending', 'Pending', array(
            'read' => true, // True allows that capability, False specifically removes it.
        ));
        add_role('congregation', 'Congregation member', array(
            'read' => true, // True allows that capability, False specifically removes it.
        ));
        update_option('saintmarks_roles_set', true);
    }
}
add_action('after_setup_theme', 'saintmarks_pending_role');

function saintmarks_user_menu($args = '')
{
    if (is_user_logged_in()) {
        if ('user' == $args['theme_location']) { // Change user to theme specific name
            $args['menu'] = 'logged-in';
        }
    } else {
        if ('user' == $args['theme_location']) { // Change user to theme specific name
            $args['menu'] = 'logged-out';
        }
    }
    return $args;
}
add_filter('wp_nav_menu_args', 'saintmarks_user_menu');

function create_posttypes()
{
    // sermon
    sermon_init();
    post_message_init();
    
    // staff
    // staff_init();
}
// Hooking up our function to theme setup
add_action('init', 'create_posttypes');

add_action('after_setup_theme', 'remove_admin_bar');
function remove_admin_bar()
{
    if (current_user_can('pending')) {
        show_admin_bar(false);
    }
}

function liveEvent() 
{
    global $EM_Event;
    $emEvent = EM_Events::get(array('category' => 'live', 'scope' => 'future'));

    $isLive = false;
    $event = null;
    if (count($emEvent) > 0) {
        $event = $emEvent[0];

        $now = new DateTime();
        $now->setTimezone(new DateTimeZone('Europe/London'));

        $start = new DateTime($event->event_start_date . ' ' . $event->event_start_time, new DateTimeZone('Europe/London'));
        $start = $start->sub(new DateInterval('PT30M'));
        $end = new DateTime($event->event_end_date . ' ' . $event->event_end_time, new DateTimeZone('Europe/London'));

        $isLive = $start < $now && $now  < $end;
    }

    return array(
        'isLive' => $isLive,
        'event' => $event
    );
}

function wpb_widgets_init() {
    register_sidebar( array(
        'name'          => 'Sidebar Widget Area',
        'id'            => 'sidebar-widget',
        'before_widget' => '<div class="row"><div class="col px-0">',
        'after_widget'  => '</div></div>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ) );

    register_sidebar( array(
        'name'          => 'Front Page Widget Area',
        'id'            => 'arch-front-page-widgets',
        'before_widget' => '<div class="col px-0">',
        'after_widget'  => '</div>',
        'before_title'  => '<h2 class="widget-title px-3">',
        'after_title'   => '</h2>',
    ) );
 
    register_sidebar( array(
        'name'          => 'Footer Widget Area',
        'id'            => 'arch-footer-widgets',
        'before_widget' => '<div class="col">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title px-3">',
        'after_title'   => '</h3>',
    ) );
}
add_action( 'widgets_init', 'wpb_widgets_init' );

function tg_include_custom_post_types_in_search_results( $query ) {
    if ( $query->is_main_query() && $query->is_search() && ! is_admin() ) {
        $query->set( 'post_type', array( 'post', 'page', 'location', 'event' ) );
    }
}
add_action( 'pre_get_posts', 'tg_include_custom_post_types_in_search_results' );