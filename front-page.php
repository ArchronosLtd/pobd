<?php get_header(); ?>

<div class="container test">
  <div class="row">
    <div class="col">
      <?php the_content(  ); ?>
    </div>
  </div>

  <?php if ( is_active_sidebar( 'arch-front-page-widgets' ) ) : ?>
    <div id="frontpage-widget-area" class="chw-widget-area widget-area row" role="complementary">
      <?php dynamic_sidebar( 'arch-front-page-widgets' ); ?>
    </div> 
  <?php endif; ?>

  <script>
    window.addEventListener('load', function() {
      var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
      var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
      });
    });
  </script>
</div>

<?php get_footer(); ?>