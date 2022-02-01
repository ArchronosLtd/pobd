<?php

function sermon_init()
{
  add_action('add_meta_boxes', 'add_sermon_meta_box');
  add_action('save_post', 'save_service_video', 10, 2);
  add_action('save_post', 'save_service_sheets', 10, 2);
}

function add_sermon_meta_box()
{
  add_meta_box(
    'arch_sermon_url', // Unique ID
    'Service video', // Box title
    'service_video_html', // Content callback, must be of type callable
    ['event'],
    'normal',
    'high'
  );

  add_meta_box(
    'arch_service_sheets', // Unique ID
    'Service sheets', // Box title
    'service_sheets_html', // Content callback, must be of type callable
    ['event'],
    'normal',
    'high'
  );
}

function save_service_video($post_id)
{
  if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
    return;

  $is_valid_nonce = (isset($_POST['service_video_nonce']) && wp_verify_nonce($_POST['service_video_nonce'], basename(__FILE__))) ? 'true' : 'false';
  if (!$is_valid_nonce) {
    return;
  }

  if (isset($_POST['service_video']) && $_POST['service_video'] != "") {
    update_post_meta($post_id, 'service_video', $_POST['service_video']);
  } else {
    update_post_meta($post_id, 'service_video', '');
  }

  // get_post_meta( $post_id, 'service_video', true );
}

function save_service_sheets($post_id)
{
  if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
    return;

  $is_valid_nonce = (isset($_POST['service_sheet_nonce']) && wp_verify_nonce($_POST['service_sheet_nonce'], basename(__FILE__))) ? 'true' : 'false';
  if (!$is_valid_nonce) {
    return;
  }

  if (isset($_POST['service_sheet']) && $_POST['service_sheet'] != "") {
    update_post_meta($post_id, 'service_sheet', $_POST['service_sheet']);
  } else {
    update_post_meta($post_id, 'service_sheet', '');
  }

  if (isset($_POST['childrens_sheet']) && $_POST['childrens_sheet'] != "") {
    update_post_meta($post_id, 'childrens_sheet', $_POST['childrens_sheet']);
  } else {
    update_post_meta($post_id, 'childrens_sheet', '');
  }

  // get_post_meta( $post_id, 'service_sheet', true );
  // get_post_meta( $post_id, 'childrens_sheet', true );
}

function service_video_html($post)
{ ?>
  <?php wp_nonce_field(basename(__FILE__), 'service_video_nonce'); ?>

  <div>
    <label for="service-sheet"><?php _e('YouTube URL'); ?></label>
    <input class="widefat" type="text" name="service_video" id="service_video" value="<?php echo get_post_meta($post->ID, 'service_video', true); ?>" />
  </div>
<?php
}

function service_sheets_html($post)
{ ?>

  <?php wp_nonce_field(basename(__FILE__), 'service_sheet_nonce'); ?>

  <div>
    <label for="service_sheet"><?php _e('Service sheet'); ?></label>
    <input class="widefat" type="text" name="service_sheet" id="service_sheet" value="<?php echo get_post_meta($post->ID, 'service_sheet', true); ?>" />
  </div>

  <div>
    <label for="childrens_sheet"><?php _e('Children\'s sheet'); ?></label>
    <input class="widefat" type="text" name="childrens_sheet" id="childrens_sheet" value="<?php echo get_post_meta($post->ID, 'childrens_sheet', true); ?>" />
  </div>

<?php
}
