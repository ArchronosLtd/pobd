<footer>
  <div class="container">
    <div class="row">
      <?php if ( is_active_sidebar( 'arch-footer-widgets' ) ) : ?>
        <div id="footer-widget-area" class="chw-widget-area widget-area row" role="complementary">
          <?php dynamic_sidebar( 'arch-footer-widgets' ); ?>
        </div> 
      <?php endif; ?>
    </div>
  </div>
</footer>

<section id="colophon">
  <div class="container">
    <div class="row">
      <div class="col">
        <?php echo get_theme_mod('saintmarks_copyright'); ?>
      </div>

      <div class="col text-md-center">
        <?php echo get_theme_mod('saintmarks_designed_by'); ?>
      </div>

      <div class="col text-md-end">
        <?php echo get_theme_mod('saintmarks_charity_number'); ?>
      </div>
    </div>
  </div>
</section>

<?php $message = get_post_meta( get_the_id(), 'post_message', true ); ?>

<?php if(isset($message) && $message != ''): ?>
<div class="modal fade" id="message-modal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><?php echo get_post_type(); ?> message</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <?php echo get_post_meta( get_the_id(), 'post_message', true ); ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<?php endif; ?>

<?php wp_footer(); ?>

<div id="cookie-overlay"></div>

<div id="cookie-banner" class="p-3">
  <div class="container-fluid">
    <div class="row">
      <div class="col">
        <p>
          This website uses cookies, inline with our <a href="<?php echo get_privacy_policy_url(); ?>">privacy policy</a> to ensure that you, our users, get the best out of this website.
        </p>

        <p>
          Please don't hesitate to contact us, if you have any questions.
        </p>
      </div>

      <div class="col-sm-2">
        <button class="btn btn-primary">I understand</button>
      </div>
    </div>
  </div>
</div>