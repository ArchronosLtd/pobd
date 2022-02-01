<?php
  $eventDetails = liveEvent();
?>

<div class="col-md-3">
  <div class="container px-0">
    <!-- <?php if($eventDetails['isLive']): ?>
      <div class="row">
        <div class="col">
          <h2>Live now</h2>
        </div>
      </div>
      <div class="row">
        <div lacc="col">
          <div class="sidebar-player"></div>
        </div>
      </div>
    <?php endif; ?> -->

    <?php if ( is_active_sidebar( 'sidebar-widget' ) ) : ?>
      <div id="sidebar-widget-area" class="chw-widget-area widget-area" role="complementary">
        <?php dynamic_sidebar( 'sidebar-widget' ); ?>
      </div> 
    <?php endif; ?>
  </div>
</div>