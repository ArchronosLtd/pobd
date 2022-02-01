<?php
function save_extra_user_profile_fields($user_id)
{
  if (empty($_POST['_wpnonce']) || !wp_verify_nonce($_POST['_wpnonce'], 'update-user_' . $user_id)) {
    return;
  }

  if (!current_user_can('edit_user', $user_id)) {
    return false;
  }

  update_user_meta($user_id, 'address', $_POST['address']);
  update_user_meta($user_id, 'telephone', $_POST['telephone']);
  update_user_meta($user_id, 'contact', $_POST['contact']);
  update_user_meta($user_id, 'showInDirectory', $_POST['directory']);
}

function saintmarks_registration_form()
{
  if (!is_user_logged_in()) {
    if (get_option('users_can_register')) {
      $output = saintmarks_registration_form_output();
    } else {
      $output = 'nope!';
    }

    wp_enqueue_script('saintmarks_registration');
    wp_enqueue_style('saintmarks_registration');
    return $output;
  }
}
add_shortcode('register_form', 'saintmarks_registration_form');

function saintmarks_get_value($group, $potential, $default = '')
{
  return isset($group[$potential]) ? $group[$potential] : $default;
}

function saintmarks_registration_form_output()
{
  ob_start();
  $values = array();

  if (isset($_COOKIE['saintmarks_registration_errors'])) {
    $values = json_decode(stripslashes($_COOKIE['saintmarks_registration_values']), true);
  }
?>

  <?php if (isset($_COOKIE['saintmarks_registration_errors'])) : ?>
    <?php
    $errors = json_decode(stripslashes($_COOKIE['saintmarks_registration_errors']), true);
    ?>
    <div class="alert alert-danger" role="alert">
      <strong>Error:</strong> Please correct the following errors.
      <ol>
        <?php
        foreach ($errors as $value) : ?>
          <li><?php echo $value['message']; ?></li>
        <?php endforeach; ?>
      </ol>
    </div>
  <?php endif; ?>

  <form class="needs-validation" action="<?php echo site_url('/wp-login.php'); ?>" method="post" id="registration-form" novalidate>
    <div class="btn-group w-100">
      <a class="wizard-step btn btn-outline-primary active" href="#user-details" data-bs-target="#sign-up-wizard" data-bs-slide-to="0" class="active" aria-current="true" aria-label="User details">
        User details
      </a>
      <a class="wizard-step btn btn-outline-primary" href="#church-directory" data-bs-target="#sign-up-wizard" data-bs-slide-to="1" aria-label="User details">
        Church directory
      </a>
      <a class="wizard-step btn btn-outline-primary" href="#electoral-role" data-bs-target="#sign-up-wizard" data-bs-slide-to="2" aria-label="Electoral role">
        Electoral role
      </a>
    </div>

    <div id="sign-up-wizard" class="carousel slide" data-bs-pause="true">
      <div class="carousel-inner">
        <div class="carousel-item active">
          <div class="mb-3 px-3 pt-3">
            <label for="user_login" class="form-label">Username</label>
            <input required type="text" class="form-control" id="user_login" name="login" value="<?php echo saintmarks_get_value($values, 'login'); ?>" aria-describedby="username_help">
            <div id="username_help" class="form-text">We'll never share your username with anyone else.</div>
            <div id="username_help" class="form-text error-text">Please provide a valid username.</div>
          </div>

          <div class="mb-3 px-3">
            <label for="user_email" class="form-label">Email</label>
            <input required type="email" class="form-control" id="user_email" name="email" value="<?php echo saintmarks_get_value($values, 'email'); ?>" aria-describedby="useremail_help">
            <div id="useremail_help" class="form-text">We'll never share your email with anyone expect PCC members.</div>
            <div id="useremail_help" class="form-text error-text">Please provide a valid email.</div>
          </div>

          <div class="mb-3 px-3">
            <label for="user_first_name" class="form-label">First name</label>
            <input required type="text" class="form-control" id="user_first_name" name="first" value="<?php echo saintmarks_get_value($values, 'first'); ?>" aria-describedby="user_first_help">
            <div id="user_first_help" class="form-text">Please put what you would like to be called here.</div>
          </div>

          <div class="mb-3 px-3">
            <label for="user_last_name" class="form-label">Last name</label>
            <input required type="text" class="form-control" id="user_last_name" name="surname" value="<?php echo saintmarks_get_value($values, 'surname'); ?>" aria-describedby="user_last_help">
            <div id="user_last_help" class="form-text">Please put your surname here.</div>
          </div>

          <div class="mb-3 px-3">
            <label for="user_pword" class="form-label">Password</label>
            <input pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$" type="password" class="form-control" id="user_pword" name="password" aria-describedby="user_password_help">
            <div required id="user_password_help" class="form-text">Please enter a strong password containing lowercase, uppercase, a number and a symbol. Never, ever, share this with anyone at all.</div>
          </div>

          <div class="mb-3 px-3">
            <label for="user_pword_confirm" class="form-label">Confirm password</label>
            <input required pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$" type="password" class="form-control" id="user_pword_confirm" name="password_confirm" aria-describedby="user_password_confirm_help">
            <div id="user_password_confirm_help" class="form-text">Please renter your password to check you can remember it.</div>
          </div>

          <div class="wizard-actions p-3 text-end">
            <a id="to-slide-2" class="btn btn-primary" data-bs-target="#sign-up-wizard" data-bs-slide="next">Next <i class="fal fa-chevron-right"></i></a>
          </div>
        </div>
        <div class="carousel-item">
          <div class="alert alert-info" role="alert">
            This screen is optional.
          </div>

          <div class="mb-3 px-3 pt-3">
            <label for="fullname" class="form-label">Full name</label>
            <input required type="text" class="form-control" id="fullname" name="fullname" value="<?php echo saintmarks_get_value($values, 'fullname'); ?>" aria-describedby="fullname_help">
            <div id="fullname_help" class="form-text">What do you like to be called.</div>
          </div>

          <div class="mb-3 px-3">
            <label for="address" class="form-label">Address</label>
            <textarea required class="form-control" id="address" name="address" value="<?php echo saintmarks_get_value($values, 'address'); ?>" aria-describedby="address_help"></textarea>
            <div id="address_help" class="form-text">What is the best address to contact you at.</div>
          </div>

          <div class="mb-3 px-3">
            <label for="telephone" class="form-label">Telephone</label>
            <input required type="text" class="form-control" id="telephone" name="telephone" value="<?php echo saintmarks_get_value($values, 'telephone'); ?>" aria-describedby="telephone_help">
            <div id="telephone_help" class="form-text">What is the best telephone number to contact you on.</div>
          </div>

          <p class="px-3 mb-0">
            Please tell us the ways you would prefer to hear from us
          </p>

          <div class="mb-3 px-3">
            <div class="form-check">
              <input class="form-check-input" type="checkbox" name="contact[]" id="contact-phone" value="phone">
              <label class="form-check-label" for="contact-phone">
                by phone
              </label>
            </div>

            <div class="form-check">
              <input class="form-check-input" type="checkbox" name="contact[]" id="contact-post" value="post">
              <label class="form-check-label" for="contact-post">
                by post
              </label>
            </div>

            <div class="form-check">
              <input class="form-check-input" type="checkbox" name="contact[]" id="contact-email" value="email">
              <label class="form-check-label" for="contact-email">
                by email
              </label>
            </div>
          </div>

          <div class="mb-3 px-3">
            <div class="form-check">
              <input class="form-check-input" type="checkbox" name="informed" id="informed" value="1">
              <label class="form-check-label" for="informed">
                I consent to the parish informing me about news, events, activities and services at with the parish.
              </label>
            </div>

            <div class="form-check">
              <input class="form-check-input" type="checkbox" name="directory" id="directory" value="1">
              <label class="form-check-label" for="directory">
                I consent to the parish including my details in the church directory which is available to other church members.
              </label>
            </div>
          </div>

          <div class="wizard-actions p-3 text-end">
            <a id="to-slide-3" class="btn btn-primary" data-bs-target="#sign-up-wizard" data-bs-slide="next">Next <i class="fal fa-chevron-right"></i></a>
          </div>
        </div>
        <div class="carousel-item">
          <div class="alert alert-info" role="alert">
            This screen is optional. However if you choose to fill it out, all fields are required.
          </div>

          <div class="mb-3 px-3 pt-3">
            <label for="electoral_fullname" class="form-label">Full name</label>
            <input required type="text" class="form-control" id="electoral_fullname" name="electoral_fullname" value="<?php echo saintmarks_get_value($values, 'electoral_fullname'); ?>" aria-describedby="electoral_fullname_help">
            <div id="electoral_fullname_help" class="form-text">What do you like to be called.</div>
          </div>

          <div class="mb-3 px-3">
            <label for="electroal_title" class="form-label">Preferred title</label>
            <input required type="text" class="form-control" id="electroal_title" maxlength="10" name="electroal_title" value="<?php echo saintmarks_get_value($values, 'electroal_title'); ?>" aria-describedby="electroal_title_help">
            <div id="electroal_title_help" class="form-text">What do you like to be called.</div>
          </div>

          <div class="mb-3 px-3">
            <label for="electoral_address" class="form-label">Address</label>
            <textarea required class="form-control" id="electoral_address" name="electoral_address" value="<?php echo saintmarks_get_value($values, 'electoral_address'); ?>" aria-describedby="electoral_address_help"></textarea>
            <div id="electoral_address_help" class="form-text">What is the best address to contact you at.</div>
          </div>

          <div class="mb-3 px-3">
            <label for="electoral_postcode" class="form-label">Postcode</label>
            <input required type="text" class="form-control" id="electoral_postcode" pattern="([Gg][Ii][Rr] 0[Aa]{2})|((([A-Za-z][0-9]{1,2})|(([A-Za-z][A-Ha-hJ-Yj-y][0-9]{1,2})|(([A-Za-z][0-9][A-Za-z])|([A-Za-z][A-Ha-hJ-Yj-y][0-9][A-Za-z]?))))\s?[0-9][A-Za-z]{2})" maxlength="10" name="electoral_postcode" value="<?php echo saintmarks_get_value($values, 'electoral_postcode'); ?>" aria-describedby="electoral_postcode_help">
            <div id="electoral_postcode_help" class="form-text">What is your postcode.</div>
          </div>

          <div class="mb-3 px-3">
            <label for="electoral_email" class="form-label">Email</label>
            <input type="email" class="form-control" id="electoral_email" name="electoral_email" value="<?php echo saintmarks_get_value($values, 'electoral_email'); ?>" aria-describedby="electoral_email_help">
          </div>

          <p class="px-3 mb-0">
            I declare that
          </p>

          <div class="mb-3 px-3">
            <div class="form-check">
              <input class="form-check-input" type="radio" name="electoral_baptism" id="electoral_baptism-am" value="am_baptised">
              <label class="form-check-label" for="electoral_baptism-am">
                I am baptised, am a lay person, and am aged 16 or over
              </label>
            </div>

            <div class="form-check">
              <input class="form-check-input" type="radio" name="electoral_baptism" id="electoral_baptism-will" value="will_be_baptised">
              <label class="form-check-label" for="electoral_baptism-will">
                I am baptised, am a lay person, and become 16 on
                <input type="date" class="form-control supplementary py-0" id="age_sizteen_date" name="age_sizteen_date" disabled />
              </label>
            </div>
          </div>

          <p class="px-3 mb-0">
            I declare that
          </p>

          <div class="mb-3 px-3">
            <div class="form-check">
              <input class="form-check-input" type="radio" name="electrol_membership" id="electrol_membership_member_in_parish" value="member_in_parish">
              <label class="form-check-label" for="electrol_membership_member_in_parish">
                I am a member of the Church of England (or of a Church in communion with the Church of England) and am a resident in the parish
              </label>
            </div>

            <div class="form-check">
              <input class="form-check-input" data-bs-show="collapse" data-bs-target="#collapseNotInParish" type="radio" name="electrol_membership" id="electrol_membership_member_not_in_parish" value="member_not_in_parish">
              <label class="form-check-label" for="electrol_membership_member_not_in_parish">
                I am a member of the Church of England (or of a Church in communion with the Church of England), and am not resident in the parish
              </label>
            </div>

            <div class="form-check secondary">
              <input disabled class="form-check-input" type="radio" name="member_not_in_parish" id="habitually_attending" value="habitually_attending">
              <label class="form-check-label" for="habitually_attending">
                but have habitually attended public worship in the parish during the preceding six months
              </label>
            </div>

            <div class="form-check secondary">
              <input disabled class="form-check-input" type="radio" name="member_not_in_parish" id="prevented_attending" value="prevented_attending">
              <label class="form-check-label" for="prevented_attending">
                and would have habitually attended public worship in the parish in the preceding six months but was prevented from doing so because
                <input type="text" class="form-control supplementary py-0" id="prevented_reason" name="prevented_reason" disabled />
              </label>
            </div>

            <div class="form-check">
              <input class="form-check-input" type="radio" name="electrol_membership" id="electrol_membership_member_other" value="member_other">
              <label class="form-check-label" for="electrol_membership_member_other">
                I am a member in good standing of the Church which is not in communion with the Church of England but subscribes to the doctrine of the Holy Trinity, am also a member of the Church of England
              </label>
            </div>

            <div class="form-check secondary">
              <input disabled class="form-check-input" type="radio" name="member_not_in_parish" id="electrol_membership_member_other_habitually_attending" value="habitually_attending">
              <label class="form-check-label" for="electrol_membership_member_other_habitually_attending">
                but have habitually attended public worship in the parish during the preceding six months
              </label>
            </div>

            <div class="form-check secondary">
              <input disabled class="form-check-input" type="radio" name="member_not_in_parish" id="electrol_membership_member_other_prevented_attending" value="prevented_attending">
              <label class="form-check-label" for="electrol_membership_member_other_prevented_attending">
                and would have habitually attended public worship in the parish in the preceding six months but was prevented from doing so because
                <input type="text" class="form-control supplementary py-0" id="prevented_reason" name="prevented_reason" disabled />
              </label>
            </div>
          </div>

          <div class="wizard-actions p-3 text-end">
            <button type="submit" class="btn btn-primary" name="wp-submit">Register</button>
          </div>
        </div>
      </div>
    </div>

    <input type="hidden" name="saintmarks_csrf" value="<?php echo wp_create_nonce('saintmarks_registration_nonce'); ?>" />
  </form>

<?php
  return ob_get_clean();
}

function fetchDefaultValue($test, $default)
{
  return isset($test) ? $test : $default;
}

function saintmarks_add_new_user()
{
  if (isset($_POST['login']) && wp_verify_nonce($_POST['saintmarks_csrf'], 'saintmarks_registration_nonce')) {
    $user_login = $_POST['login'];
    $user_email = $_POST['email'];
    $user_first = $_POST['first'];
    $user_last = $_POST['surname'];
    $user_pass = $_POST['password'];
    $user_pass_confirm = $_POST['password_confirm'];
    $user_confirm = $_POST['saintmarks_csrf'];

    if (username_exists($user_login)) {
      saintmarks_errors()->add('username_unavailable', __('Username already taken'));
    }

    if (!validate_username($user_login) || $user_login == '') {
      saintmarks_errors()->add('username_empty', __('Invalid username provided' . $user_login));
    }

    if (!is_email($user_email)) {
      saintmarks_errors()->add('invalid_email', __('Invalid email address provided'));
    }

    if (email_exists($user_email)) {
      saintmarks_errors()->add('invalid_email', __('Email address already registered'));
    }

    if ($user_pass == '') {
      saintmarks_errors()->add('password_missing', __('Password is missing'));
    }

    if ($user_pass != $user_pass_confirm) {
      saintmarks_errors()->add('password_mismatch', __('Passwords do not match'));
    }

    if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/', $user_pass)) {
      saintmarks_errors()->add('password_weak', __('Password is too weak, please make sure it follows the rules stated.'));
    }

    $errors = saintmarks_errors()->get_error_messages();

    var_dump($errors);

    if (empty($errors)) {
      $new_user_id = wp_insert_user(array(
        'user_login' => $user_login,
        'user_email' => $user_email,
        'user_first' => $user_first,
        'user_last' => $user_last,
        'user_pass' => $user_pass,
        'user_registered' => date('Y-m-d H:i:s'),
        'role' => 'pending'
      ));

      $directory_info = array(
        'name' => fetchDefaultValue($_POST['fullname'], ''),
        'address' => fetchDefaultValue($_POST['address'], ''),
        'telephone' => fetchDefaultValue($_POST['telephone'], ''),
        'contact' => fetchDefaultValue($_POST['contact'], ''),
        'consent' => array(
          'informed' => fetchDefaultValue($_POST['informed'], ''),
          'directory' => fetchDefaultValue($_POST['directory'], '')
        )
      );

      $electoral_roll_info = array(
        'name' => fetchDefaultValue($_POST['electoral_fullname'], ''),
        'title' => fetchDefaultValue($_POST['electroal_title'], ''),
        'address' => fetchDefaultValue($_POST['electoral_address'], ''),
        'postcode' => fetchDefaultValue($_POST['electoral_postcode'], ''),
        'email' => fetchDefaultValue($_POST['electoral_email'], ''),
        'age' => array(
          'baptised' => fetchDefaultValue($_POST['electoral_baptism'], ''),
          'date' => fetchDefaultValue($_POST['age_sizteen_date'], ''),
        ),
        'membership' => array(
          'status' => fetchDefaultValue($_POST['electrol_membership'], ''),
          'exception' => fetchDefaultValue($_POST['member_not_in_parish'], ''),
          'reason' => fetchDefaultValue($_POST['prevented_reason'], '')
        )
      );

      update_user_meta($user_id, 'directory', $directory_info);
      update_user_meta($user_id, 'electoral_role', $electoral_roll_info);

      if (is_numeric($new_user_id)) {
        wp_new_user_notification($new_user_id);
        wp_setcookie($user_login, $user_pass, true);
        wp_set_current_user($new_user_id, $user_login);
        do_action('wp_login', $user_login);

        wp_redirect(home_url());
        exit;
      }
    } else {
      if ($codes = saintmarks_errors()->get_error_codes()) {
        $data = saintmarks_errors();

        if (is_wp_error($data)) {
          $result = array();
          foreach ($data->errors as $code => $messages) {
            foreach ($messages as $message) {
              $result[] = array(
                'code'    => $code,
                'message' => $message
              );
            }
          }
          setcookie('saintmarks_registration_errors', stripslashes(json_encode($result)), time() + 5);
        }

        $result = array();
        foreach ($_POST as $key => $value) {
          $result[$key] = $value;
        }
        setcookie('saintmarks_registration_values', stripslashes(json_encode($result)), time() + 5);
      }

      wp_redirect(home_url() . '/users/register');
      exit;
    }
  }
}
add_action('init', 'saintmarks_add_new_user');

function saintmarks_errors()
{
  static $wp_error;

  return isset($wp_error) ? $wp_error : ($wp_error = new WP_Error(null, null, null));
}
