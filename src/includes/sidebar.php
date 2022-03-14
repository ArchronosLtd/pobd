<?php
  $eventDetails = liveEvent();
?>

<div class="col-md-3">
  <div class="container px-0">
    <?php if (get_post_type() == 'event') : ?>
      <div class="row">
        <div class="col px-0">
          <?php 
            $sheet = get_post_meta(get_the_id(), 'service_sheet', true);
            if(isset($sheet) && $sheet != ''): 
          ?>
            <p><i class="fad fa-camera-movie"></i> <a href="<?php echo get_post_meta(get_the_id(), 'service_sheet', true); ?>">Service sheets</a></p>
          <?php endif; ?>

          <?php 
            $sheet = get_post_meta(get_the_id(), 'childrens_sheet', true);
            if(isset($sheet) && $sheet != ''): 
          ?>
            <p><i class="fad fa-child"></i> <a href="<?php echo get_post_meta(get_the_id(), 'childrens_sheet', true); ?>">Children's sheet</a></p>
          <?php endif; ?>
        </div>
      </div>
    <?php endif; ?>

    <?php if ( is_active_sidebar( 'sidebar-widget' ) ) : ?>
      <div id="sidebar-widget-area" class="chw-widget-area widget-area" role="complementary">
        <?php dynamic_sidebar( 'sidebar-widget' ); ?>
      </div> 
    <?php endif; ?>
  </div>
</div>