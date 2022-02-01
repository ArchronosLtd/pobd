<?php

function saintmarks_feature_blocks_register($wp_customize)
{
  $wp_customize->add_section(
    'saintmarks_feautre_block_options',
    array(
      'title'         => __('Feature blocks', 'saint_marks'),
      'priority'      => 1,
      'panel'         => 'saintmarks_theme_options'
    )
  );

  $wp_customize->add_setting(
    'saintmarks_events_background',
    array(
      'default'           => '#fff',
      'type'           => 'theme_mod',
      'capability'     => 'edit_theme_options',
    )
  );

  $wp_customize->add_setting(
    'saintmarks_churchathome_background',
    array(
      'default'           => '/',
      'type'           => 'theme_mod',
      'capability'     => 'edit_theme_options',
    )
  );

  $wp_customize->add_setting(
    'saintmarks_sundays_background',
    array(
      'default'           => '/',
      'type'           => 'theme_mod',
      'capability'     => 'edit_theme_options',
    )
  );

  $wp_customize->add_control(
    new WP_Customize_Color_Control(
      $wp_customize,
      'saintmarks_events_background',
      array(
        'label'      => __('Events feature background colour', 'theme_name'),
        'section'    => 'saintmarks_feautre_block_options',
        'settings'   => 'saintmarks_events_background'
      )
    )
  );

  $wp_customize->add_control(
    new WP_Customize_Image_Control(
      $wp_customize,
      'saintmarks_churchathome_background',
      array(
        'label'      => __('Church at home feature background image', 'theme_name'),
        'section'    => 'saintmarks_feautre_block_options',
        'settings'   => 'saintmarks_churchathome_background'
      )
    )
  );

  $wp_customize->add_control(
    new WP_Customize_Image_Control(
      $wp_customize,
      'saintmarks_sundays_background',
      array(
        'label'      => __('Sundays feature background image', 'theme_name'),
        'section'    => 'saintmarks_feautre_block_options',
        'settings'   => 'saintmarks_sundays_background'
      )
    )
  );
}
add_action('customize_register', 'saintmarks_feature_blocks_register');
