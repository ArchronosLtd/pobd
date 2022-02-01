<?php

function mytheme_customize_register($wp_customize)
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
    'saintmarks_frontpage_options',
    array(
      'title'         => __('Front page options', 'saint_marks'),
      'priority'      => 1,
      'panel'         => 'saintmarks_theme_options'
    )
  );

  $wp_customize->add_section(
    'saintmarks_box1_options',
    array(
      'title'         => __('Box 1 options', 'saint_marks'),
      'priority'      => 1,
      'panel'         => 'saintmarks_theme_options'
    )
  );

  $wp_customize->add_setting(
    'saintmarks_initial_title',
    array(
      'default'           => __('Welcome', 'saint_marks'),
      'type'           => 'theme_mod',
      'capability'     => 'edit_theme_options',
    )
  );

  $wp_customize->add_setting(
    'saintmarks_initial_content',
    array(
      'default'           => __('Lorem ipsum', 'saint_marks'),
      'type'           => 'theme_mod',
      'capability'     => 'edit_theme_options',
    )
  );

  $wp_customize->add_setting(
    'saintmarks_initial_cta',
    array(
      'default'           => true,
      'type'           => 'theme_mod',
      'capability'     => 'edit_theme_options',
    )
  );

  $wp_customize->add_setting(
    'saintmarks_initial_cta_text',
    array(
      'default'           => 'Visitor information',
      'type'           => 'theme_mod',
      'capability'     => 'edit_theme_options',
    )
  );

  $wp_customize->add_setting(
    'saintmarks_initial_cta_url',
    array(
      'default'           => '/',
      'type'           => 'theme_mod',
      'capability'     => 'edit_theme_options',
    )
  );

  $wp_customize->add_control(
    'saintmarks_initial_title',
    array(
      'type'        => 'text',
      'priority'    => 10,
      'section'     => 'saintmarks_box1_options',
      'label'       => 'Initial section title',
      'description' => 'The title of the area first in the DOM',
    )
  );

  $wp_customize->add_control(
    'saintmarks_initial_content',
    array(
      'type'        => 'text',
      'priority'    => 10,
      'section'     => 'saintmarks_box1_options',
      'label'       => 'Initial section paragraph',
      'description' => 'The content of the area first in the DOM',
    )
  );

  $wp_customize->add_control(
    'saintmarks_initial_cta_text',
    array(
      'type'        => 'text',
      'priority'    => 10,
      'section'     => 'saintmarks_box1_options',
      'label'       => 'CTA Text',
      'description' => 'The content of the area first in the DOM',
    )
  );

  $wp_customize->add_control(
    'saintmarks_initial_cta_url',
    array(
      'type'        => 'text',
      'priority'    => 10,
      'section'     => 'saintmarks_box1_options',
      'label'       => 'CTA location',
      'description' => 'Where will CTA go',
    )
  );

  $wp_customize->add_control(
    'saintmarks_initial_cta',
    array(
      'type'        => 'checkbox',
      'priority'    => 10,
      'section'     => 'saintmarks_box1_options',
      'label'       => 'Show CTA',
      'description' => 'Decides whether or not to show the CTA',
    )
  );
}
add_action('customize_register', 'mytheme_customize_register');
