<?php

function post_message_init() {
  add_action('add_meta_boxes', 'add_post_message_meta_box');
  add_action('save_post', 'save_post_message', 10, 2);
}

function add_post_message_meta_box() {
    add_meta_box(
      'arch_post_message', // Unique ID
      'Service message', // Box title
      'sermon_mesage_html', // Content callback, must be of type callable
      ['event'],
      'advanced',
      'low'
    );
}

function save_post_message($post_id)
{
  if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
    return;

  $is_valid_nonce = (isset($_POST['post_message_nonce']) && wp_verify_nonce($_POST['post_message_nonce'], basename(__FILE__))) ? 'true' : 'false';
  if (!$is_valid_nonce) {
    return;
  }

  if (isset($_POST['post_message']) && $_POST['post_message'] != "") {
    update_post_meta($post_id, 'post_message', $_POST['post_message']);
  } else {
    update_post_meta($post_id, 'post_message', '');
  }

  // get_post_meta( $post_id, 'post_message', true );
}

function sermon_mesage_html($post)
{ ?>
  <?php wp_nonce_field(basename(__FILE__), 'post_message_nonce'); ?>

  <div>
    <label for="post_message"><?php _e('Message'); ?></label>
    <textarea class="form-control widefat tinyMCE" id="post_message" name="post_message" rows="3"><?php echo get_post_meta($post->ID, 'post_message', true); ?></textarea>
  </div>
<?php
}
