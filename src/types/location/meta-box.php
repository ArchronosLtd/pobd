<?php
  $prefix = 'arch_';

  $fields = array(
    array( // Text Input
      'label'	=> 'Logo', // <label>
      'desc'	=> 'A description for the field.', // description
      'id'	=> $prefix.'location_logo', // field id and name
      'type'	=> 'image' // type of field
    )
  );
  
  $sample_box = new custom_add_meta_box( 'arch_location_logo', 'Location logo', $fields, 'location', 'side', 'low' );
