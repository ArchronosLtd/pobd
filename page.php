<?php get_header(); ?>

<div id="page-header" class="d-flex align-items-center justify-content-center">
  <?php echo the_post_thumbnail('original', array('class' => 'd-none d-md-block w-100')); ?>
  <?php echo the_post_thumbnail('post-saintmarks-mobile-header', array('class' => 'd-sm-block d-md-none w-100')); ?>
</div>

<div class="container">
  <div class="row">
    <div class="col-md-9">
      <h1><?php the_title(); ?></h1>
      <?php the_content(); ?>
    </div>

    <?php get_template_part('./src/includes/sidebar'); ?>
  </div>
</div>

<?php get_footer(); ?>