<?php

function saintmarks_box2_cusomizer($wp_customize)
{

  $wp_customize->add_section(
    'saintmarks_box2_options',
    array(
      'title'         => __('Box 2 options', 'saint_marks'),
      'priority'      => 1,
      'panel'         => 'saintmarks_theme_options'
    )
  );

  $wp_customize->add_setting(
    'saintmarks_2col_title',
    array(
      'default'           => __('Sunday services', 'saint_marks'),
      'type'           => 'theme_mod',
      'capability'     => 'edit_theme_options',
    )
  );

  $wp_customize->add_setting(
    'saintmarks_2col_content',
    array(
      'default'           => __('Lorem ipsum', 'saint_marks'),
      'type'           => 'theme_mod',
      'capability'     => 'edit_theme_options',
    )
  );

  $wp_customize->add_setting(
    'saintmarks_2col_content2',
    array(
      'default'           => __('Lorem ipsum', 'saint_marks'),
      'type'           => 'theme_mod',
      'capability'     => 'edit_theme_options',
    )
  );

  $wp_customize->add_setting(
    'saintmarks_2col_cta',
    array(
      'default'           => true,
      'type'           => 'theme_mod',
      'capability'     => 'edit_theme_options',
    )
  );

  $wp_customize->add_setting(
    'saintmarks_2col_cta_text',
    array(
      'default'           => 'Visitor information',
      'type'           => 'theme_mod',
      'capability'     => 'edit_theme_options',
    )
  );

  $wp_customize->add_setting(
    'saintmarks_2col_cta_url',
    array(
      'default'           => '/',
      'type'           => 'theme_mod',
      'capability'     => 'edit_theme_options',
    )
  );

  $wp_customize->add_control(
    'saintmarks_2col_title',
    array(
      'type'        => 'text',
      'priority'    => 10,
      'section'     => 'saintmarks_box2_options',
      'label'       => '2col section title',
      'description' => 'The title of the area first in the DOM',
    )
  );

  $wp_customize->add_control(
    'saintmarks_2col_content',
    array(
      'type'        => 'text',
      'priority'    => 10,
      'section'     => 'saintmarks_box2_options',
      'label'       => '2col section paragraph 1',
      'description' => 'The content of the area first in the DOM',
    )
  );

  $wp_customize->add_control(
    'saintmarks_2col_content2',
    array(
      'type'        => 'text',
      'priority'    => 10,
      'section'     => 'saintmarks_box2_options',
      'label'       => '2col section paragraph 2',
      'description' => 'The content of the area first in the DOM',
    )
  );

  $wp_customize->add_control(
    'saintmarks_2col_cta_text',
    array(
      'type'        => 'text',
      'priority'    => 10,
      'section'     => 'saintmarks_box2_options',
      'label'       => 'CTA Text',
      'description' => 'The content of the area first in the DOM',
    )
  );

  $wp_customize->add_control(
    'saintmarks_2col_cta_url',
    array(
      'type'        => 'text',
      'priority'    => 10,
      'section'     => 'saintmarks_box2_options',
      'label'       => 'CTA location',
      'description' => 'Where will CTA go',
    )
  );

  $wp_customize->add_control(
    'saintmarks_2col_cta',
    array(
      'type'        => 'checkbox',
      'priority'    => 10,
      'section'     => 'saintmarks_box2_options',
      'label'       => 'Show CTA',
      'description' => 'Decides whether or not to show the CTA',
    )
  );
}
add_action('customize_register', 'saintmarks_box2_cusomizer');
