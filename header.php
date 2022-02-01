<?php
global $EM_Event;
$liveEvent = liveEvent();
$event = $liveEvent['event'];
$isLive = $liveEvent['isLive'];

$sticky = get_option('sticky_posts');
$args = array(
  'posts_per_page' => 10,
  'post__in' => $sticky
);
$sticky_query = new WP_Query($args);
?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link media="print" onload="this.onload=null;this.removeAttribute('media');" href="https://fonts.googleapis.com/css2?family=Montserrat:wght@200;400&display=swap" rel="stylesheet">

  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <link rel="profile" href="http://gmpg.org/xfn/11">
  <?php wp_head(); ?>

  <title><?php echo get_the_title() . ' - ' . get_bloginfo('description') . ' ' . get_bloginfo('name') ?></title>

  <link rel="stylesheet" onload="this.onload=null;this.removeAttribute('media');" href="https://pro.fontawesome.com/releases/v5.15.3/css/all.css" integrity="sha384-iKbFRxucmOHIcpWdX9NTZ5WETOPm0Goy0WmfyNcl52qSYtc2Buk0NCe6jU1sWWNB" crossorigin="anonymous">

  <!-- Global site tag (gtag.js) - Google Analytics -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=G-YBGPTFSQWM"></script>
  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'G-YBGPTFSQWM');
  </script>
</head>

<body <?php body_class(); ?>>

  <?php
  // WordPress 5.2 wp_body_open implementation
  if (function_exists('wp_body_open')) {
    wp_body_open();
  } else {
    do_action('wp_body_open');
  }
  ?>

  <div id="page" class="site">
    <a class="skip-link screen-reader-text" href="#content" hidden><?php esc_html_e('Skip to content', 'wp-bootstrap-starter'); ?></a>
    <div id="top-menu">
    <div class="container">
      <div class="row px-2">
        <?php
          wp_nav_menu(array(
            'theme_location'  => 'topmenu',
            'container'       => 'div',
            'container_class' => 'col-md-4 offset-md-8 d-flex justify-content-end my-2',
            'menu_id'         => false,
            'menu_class'      => ' btn-group btn-group-lg',
            'depth'           => 2,
            'fallback_cb'     => 'archronos_top_menu_walker::fallback',
            'walker'          => new archronos_top_menu_walker()
          )); 
        ?>
      </div>
    </div>
    </div>
    <header id="masthead" class="site-header navbar-static-top" role="banner">
      <div class="container">
        <!-- <?php
        wp_nav_menu(array(
          'theme_location' => 'user',
          'container_class' => 'user-menu'
        ));
        ?> -->

        <div class="row" id="logo-wrapper">
          <div class="col">
            <a href="<?php echo esc_url(home_url('/')); ?>">
              <img id="logo" src="<?php echo get_template_directory_uri(); ?>/src/images/logo.png" alt="<?php echo esc_attr(get_bloginfo('name')); ?>">
              <h1><span><?php echo get_bloginfo('description') ?></span><?php echo get_bloginfo('name') ?></h1>
            </a>
          </div>
        </div>

        <div class="row">
          <div class="col-xs-12 d-lg-none">
            <button id="menu-toggle" class="btn btn-outline-primary float-start" type="button" data-bs-toggle="collapse" data-bs-target="#main-nav" aria-controls="" aria-expanded="false" aria-label="Toggle navigation">
              <i class="fal fa-bars"></i>
            </button>
          </div>
        </div>
    </header><!-- #masthead -->

    <nav class="navbar navbar-expand-lg px-10 py-0">
      <?php
      wp_nav_menu(array(
        'theme_location'  => 'main',
        'container'       => 'div',
        'container_id'    => 'main-nav',
        'container_class' => 'collapse navbar-collapse justify-content-end pl-sm-5',
        'menu_id'         => false,
        'menu_class'      => 'container navbar-nav',
        'depth'           => 3,
        'fallback_cb'     => 'wp_bootstrap_navwalker::fallback',
        'walker'          => new bootstrap_5_wp_nav_menu_walker()
      ));
      ?>
    </nav>

    <?php if (is_front_page()) : ?>
      <div id="page-sub-header" class="pt-0">
        <div id="homepage-carousel" class="carousel slide carousel-fade h-100" data-bs-interval="5000" data-bs-ride="carousel">
          <div class="carousel-inner bg-secondary h-100">
            <?php if ($isLive && get_post_type() != 'event') : ?>
              <div class="carousel-item h-100 active">
                <div class="d-flex align-items-center justify-content-center h-100">
                  <div class="banner-badge live">LIVE</div>
                  <div class="w-100 h-100" id="player"></div>
                  <div class="player-controls">
                    <div class="btn-group" role="group" aria-label="Player controls">
                      <button type="button" class="btn btn-primary" id="play"><i class="fad fa-play"></i></button>
                      <button type="button" class="btn btn-primary hidden" id="pause"><i class="fad fa-pause"></i></button>
                      <button type="button" class="btn btn-primary hidden" id="mute"><i class="fad fa-volume-mute"></i><i class="fad fa-volume hidden"></i></button>
                      <button type="button" class="btn btn-primary hidden" id="fullscreen"><i class="fad fa-expand-arrows"></i></button>
                    </div>
                  </div>
                </div>
              </div>
            <?php endif; ?>


            <?php if (!$isLive && isset($sticky[0])) : ?>
              <?php
              $isFirst = true;
              while ($sticky_query->have_posts()) :
                $sticky_query->the_post();
              ?>
                <div class="carousel-item h-100 d-flex align-items-center justify-content-center <?php echo $isFirst ? 'active' : ''; ?>">
                  <?php echo the_post_thumbnail('original', array('class' => 'd-none d-md-block w-100')); ?>
                  <?php echo the_post_thumbnail('post-saintmarks-mobile-header', array('class' => 'd-sm-block d-md-none w-100')); ?>
                  <div class="carousel-caption d-xs-block w-100">
                    <div class="container">
                      <a class="float-md-start d-sm-block d-md-inline" href="<?php echo get_post_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
                      <a class="float-end btn btn-outline-info d-none d-md-block" href="<?php echo get_post_permalink(); ?>" title="Read more">Read more <i class="fal fa-chevron-right"></i></a>
                    </div>
                  </div>
                </div>
              <?php $isFirst = false;
              endwhile; ?>
            <?php elseif (!$isLive) : ?>
              <div class="carousel-item h-100 d-flex align-items-center justify-content-center active">
                <?php the_post_thumbnail('original', array('class' => 'd-none d-md-block w-100')); ?>
                <?php the_post_thumbnail('post-saintmarks-mobile-header', array('class' => 'd-sm-block d-md-none w-100')); ?>
              </div>
            <?php endif; ?>
            <?php wp_reset_postdata(); ?>
          </div>

          <?php if (!$isLive && isset($sticky[0])) : ?>
            <button class="d-none d-md-block carousel-control-prev" type="button" data-bs-target="#homepage-carousel" data-bs-slide="prev">
              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Previous</span>
            </button>
            <button class="d-none d-md-block carousel-control-next" type="button" data-bs-target="#homepage-carousel" data-bs-slide="next">
              <span class="carousel-control-next-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Next</span>
            </button>
          <?php endif; ?>
        </div>
      </div>
    <?php endif; ?>

    <?php if (get_post_type() == 'event' && get_post_meta($EM_Event->post_id, 'service_video', true)) : ?>
      <div id="page-sub-header" class="pt-0">
        <div id="homepage-carousel" class="carousel slide carousel-fade h-100" data-bs-interval="5000" data-bs-ride="carousel">
          <div class="carousel-inner bg-secondary h-100">
            <div class="carousel-item h-100 active">
              <div class="d-flex align-items-center justify-content-center h-100">
                <div class="w-100 h-100" id="player"></div>
                <div class="player-controls">
                  <div class="btn-group" role="group" aria-label="Player controls">
                    <button type="button" class="btn btn-primary" id="play"><i class="fad fa-play"></i></button>
                    <button type="button" class="btn btn-primary hidden" id="pause"><i class="fad fa-pause"></i></button>
                    <button type="button" class="btn btn-primary hidden" id="mute"><i class="fad fa-volume-mute"></i><i class="fad fa-volume hidden"></i></button>
                    <button type="button" class="btn btn-primary hidden" id="fullscreen"><i class="fad fa-expand-arrows"></i></button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    <?php endif; ?>

    