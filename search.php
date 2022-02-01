<?php get_header(); ?>

<?php if (get_post_type() != 'event' || get_post_meta($EM_Event->post_id, 'service_video', true) == '') : ?>
  <div id="post-header" class="d-flex align-items-center justify-content-center">
    <?php echo the_post_thumbnail('original', array('class' => 'd-none d-md-block w-100')); ?>
    <?php echo the_post_thumbnail('post-saintmarks-mobile-header', array('class' => 'd-sm-block d-md-none w-100')); ?>
  </div>
<?php endif; ?>

<div class="container">
  <div class="row">
    <div class="col-md-9">
      <div class="container px-0">
        <?php
          $s=get_search_query();
          $args = array(
            's' =>$s
          );
        
          // The Query
          $the_query = new WP_Query( $args );
          if ( $the_query->have_posts() ) {
        ?>
        
          <div class="row">
            <div class="col">
              <?php _e("<h2>Search Results for: ".get_query_var('s')."</h2>"); ?>
            </div>
          </div>

          <div class="row">
            <?php 
              while ( $the_query->have_posts() ) {
                $the_query->the_post();
            ?>
        
            <div class="news-item col-md-4 d-flex">
              <a href="<?php the_permalink(); ?>" class="feature-image d-flex align-items-center justify-content-center">
                <?php echo the_post_thumbnail('post-saintmarks-news-reel', array('class' => 'w-100 h-auto')); ?>
              </a>
              
              <a href="<?php the_permalink(); ?>" class="details excerpt justify-content-center">
                <h2><?php the_title(); ?></h2>
            
                <?php the_excerpt(); ?>
              </a>
            </div>
          
            <?php
              }
            ?>
          </div>
        <?php
          } else {
        ?>
          <div class="row">
            <div class="col">
              <?php _e("<h2>Nothing found</h2>"); ?>
            </div>
          </div>

          <div class="row">
            <div class="col">
              <div class="alert alert-info">
                Sorry, but nothing matched your search criteria. Please try again with some different keywords.
              </div>
            </div>
          </div>
        <?php } ?>
      </div>
    </div>

    <?php get_template_part('./src/includes/sidebar'); ?>
  </div>
</div>

<?php get_footer(); ?>