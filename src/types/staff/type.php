<?php
function staff_init()
{
  register_post_type(
    'staff',
    array(
      'labels' => array(
        'name' => __('Staff'),
        'singular_name' => __('Staff')
      ),
      'public' => true,
      'has_archive' => true,
      'rewrite' => array('slug' => 'staff'),
      'show_in_rest' => true,
      'supports' => array('title', 'editor', 'thumbnail')
    )
  );
}
