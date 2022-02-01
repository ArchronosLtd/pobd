<?php

function saintmarks_footer_register($wp_customize)
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
    'saintmarks_footer_options',
    array(
      'title'         => __('Footer options', 'saint_marks'),
      'priority'      => 1,
      'panel'         => 'saintmarks_theme_options'
    )
  );

  $wp_customize->add_setting(
    'saintmarks_copyright',
    array(
      'default'           => '',
      'type'           => 'theme_mod',
      'capability'     => 'edit_theme_options',
    )
  );

  $wp_customize->add_setting(
    'saintmarks_designed_by',
    array(
      'type'           => 'theme_mod',
      'capability'     => 'edit_theme_options',
    )
  );

  $wp_customize->add_setting(
    'saintmarks_charity_number',
    array(
      'type'           => 'theme_mod',
      'capability'     => 'edit_theme_options',
    )
  );

  $wp_customize->add_control(
    'saintmarks_copyright',
    array(
      'type'        => 'text',
      'priority'    => 10,
      'section'     => 'saintmarks_footer_options',
      'label'       => 'Copyright text',
      'description' => 'Copyright text displayed in the footer',
    )
  );

  $wp_customize->add_control(
    'saintmarks_designed_by',
    array(
      'type'        => 'text',
      'priority'    => 10,
      'section'     => 'saintmarks_footer_options',
      'label'       => 'Designed by text',
      'description' => 'Designed by text displayed in the footer',
    )
  );

  $wp_customize->add_control(
    'saintmarks_charity_number',
    array(
      'type'        => 'text',
      'priority'    => 10,
      'section'     => 'saintmarks_footer_options',
      'label'       => 'Charity number',
      'description' => 'Registered charity number',
    )
  );
}
add_action('customize_register', 'saintmarks_footer_register');
