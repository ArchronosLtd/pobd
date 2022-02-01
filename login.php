<?php
/* Template Name: Login template */

$login = (isset($_GET['login'])) ? $_GET['login'] : 0;
?>

<?php get_header(); ?>

<div id="page-header" class="d-flex align-items-center justify-content-center">
  <?php echo the_post_thumbnail('original', array('class' => 'd-none d-md-block w-100')); ?>
  <?php echo the_post_thumbnail('post-saintmarks-mobile-header', array('class' => 'd-sm-block d-md-none w-100')); ?>
</div>

<div class="container">
  <?php if ($login !== 0) : ?>
    <div class="row">
      <div class="col">
        <?php if ($login === "failed") : ?>
          <div class="alert alert-danger" role="alert">
            <strong>ERROR:</strong> Invalid username and/or password.
          </div>
        <?php elseif ($login === "empty") : ?>
          <div class="alert alert-danger" role="alert">
            <strong>ERROR:</strong> Username and/or password is empty.
          </div>
        <?php elseif ($login === "false") : ?>
          <div class="alert alert-warning" role="alert">
            <strong>INFO:</strong> You are logged out.
          </div>
        <?php endif; ?>
      </div>
    </div>
  <?php endif; ?>

  <div class="row">
    <div class="col-md-7">
      <h1>Login</h1>

      <form action="<?php echo site_url('/wp-login.php'); ?>" method="post">
        <div class="mb-3">
          <label for="user_login" class="form-label">Username</label>
          <input type="text" class="form-control" id="user_login" name="log" aria-describedby="username_help">
          <div id="username_help" class="form-text">We'll never share your username with anyone else.</div>
        </div>
        <div class="mb-3">
          <label for="user_pass" class="form-label">Password</label>
          <input type="password" class="form-control" id="user_pass" name="pwd">
        </div>
        <div class="mb-3 form-check">
          <input type="checkbox" class="form-check-input" id="rememberme" name="rememberme">
          <label class="form-check-label" for="Remember me">Remember me</label>
        </div>

        <input type="hidden" value="<?php echo esc_attr($redirect_to); ?>" name="redirect_to">

        <button type="submit" class="btn btn-outline-primary" name="wp-submit">Submit</button>
      </form>
    </div>
  </div>
</div>

<?php get_footer(); ?>