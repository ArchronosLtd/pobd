<?php
function saintmarks_profile_form_output()
{
  ob_start();
?>

  

<?php
  return ob_get_clean();
}

function saintmarks_profile_form()
{
  var_dump(is_user_logged_in());
  if (is_user_logged_in()) {


    // wp_enqueue_script('saintmarks_registration');
    // wp_enqueue_style('saintmarks_registration');
    return saintmarks_profile_form_output();
  }
}
add_shortcode('profile_form', 'saintmarks_profile_form_output');
