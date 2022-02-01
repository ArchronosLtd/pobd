<?php

function saintmarks_header_register($wp_customize)
{
  $wp_customize->add_panel(
    'saintmarks_theme_options',
    array(
      //'priority'       => 100,
      'title'            => __('Theme Options', 'saint_marks'),
      'description'      => __('Basic theme modifications', 'saint_marks'),
    )
  );

  $wp_customize->add_section(
    'saintmarks_header_options',
    array(
      'title'         => __('Header options', 'saint_marks'),
      'priority'      => 1,
      'panel'         => 'saintmarks_theme_options'
    )
  );

  $wp_customize->add_setting(
    'saintmarks_static_banner_image',
    array(
      'default'           => '',
      'type'           => 'theme_mod',
      'capability'     => 'edit_theme_options',
    )
  );

  $wp_customize->add_control(
    new WP_Customize_Image_Control(
      $wp_customize,
      'saintmarks_static_banner_image',
      array(
        'label'      => __('Main banner image', 'theme_name'),
        'section'    => 'saintmarks_header_options',
        'settings'   => 'saintmarks_static_banner_image'
      )
    )
  );
}
add_action('customize_register', 'saintmarks_header_register');
