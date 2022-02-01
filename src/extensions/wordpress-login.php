<?php

function redirect_registration_page()
{
  $registration_page  = home_url('/users/register/');
  $page_viewed = basename($_SERVER['REQUEST_URI']);

  if ($page_viewed == "wp-login.php?action=register" && $_SERVER['REQUEST_METHOD'] == 'GET') {
    // wp_redirect($registration_page);
    echo 'redirect';
    exit;
  }
}
add_action('init', 'redirect_registration_page');

function redirect_login_page()
{
  $login_page  = home_url('/users/login/');
  $page_viewed = basename($_SERVER['REQUEST_URI']);

  if ($page_viewed == "wp-login.php" && $_SERVER['REQUEST_METHOD'] == 'GET') {
    wp_redirect($login_page);
    exit;
  }
}
add_action('init', 'redirect_login_page');

function login_failed()
{
  $login_page  = home_url('/users/login/');
  wp_redirect($login_page . '?login=failed');
  exit;
}
add_action('wp_login_failed', 'login_failed');

function verify_username_password($user, $username, $password)
{
  $login_page  = home_url('/login/');
  if (!isset($_POST['first']) && ($username == "" || $password == "")) {
    wp_redirect($login_page . "?login=empty");
    exit;
  }
}
add_filter('authenticate', 'verify_username_password', 1, 3);

function logout_page()
{
  $login_page  = home_url('/users/login/');
  wp_redirect($login_page . "?login=false");
  exit;
}
add_action('wp_logout', 'logout_page');
