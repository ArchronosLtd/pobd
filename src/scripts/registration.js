function registrationOnLoad() {
  function validateEmail(email) {
    const re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(String(email).toLowerCase());
  }

  var list = document.getElementsByClassName("wizard-step");
  for (let item of list) {
    item.addEventListener('click', function(e) {
      let currentlyActive = document.getElementsByClassName('btn active')[0];
      currentlyActive.classList.remove('active');
      e.target.classList.add('active');
    });
  }

  document.getElementById('to-slide-2').addEventListener('click', function(e) {
    document.getElementsByClassName('btn active')[0].classList.remove('active');
    document.getElementsByClassName("wizard-step")[1].classList.add('active');
  });

  document.getElementById('to-slide-3').addEventListener('click', function(e) {
    document.getElementsByClassName('btn active')[0].classList.remove('active');
    document.getElementsByClassName("wizard-step")[2].classList.add('active');
  });

  function populateNames(e) {
    let firstName = document.getElementById('user_first_name').value;
    let surname = document.getElementById('user_last_name').value;

    document.getElementById('fullname').value = `${firstName} ${surname}`;
    document.getElementById('electoral_fullname').value = `${firstName} ${surname}`;
  }
  document.getElementById('user_first_name').addEventListener('change', populateNames)
  document.getElementById('user_last_name').addEventListener('change', populateNames)

  function populateAddress(e) {
    document.getElementById('electoral_address').value = document.getElementById('address').value;
  }
  document.getElementById('address').addEventListener('change', populateAddress)

  document.getElementById('user_email').addEventListener('change', function(e) {
    document.getElementById('electoral_email').value = document.getElementById('user_email').value;
  });

  function disableDate(e) {
    let will = document.getElementById('electoral_baptism-will');
    let sixteenDate = document.getElementById('age_sizteen_date');

    if(will.checked) {
      sixteenDate.disabled = false;
    } else {
      sixteenDate.disabled = true;
    }
  }
  document.getElementById('electoral_baptism-am').addEventListener('change', disableDate);
  document.getElementById('electoral_baptism-will').addEventListener('change', disableDate);

  function selectedNotInParish(e) {
    let inParish = document.getElementById('electrol_membership_member_in_parish');
    let notInParish = document.getElementById('electrol_membership_member_not_in_parish');
    let other = document.getElementById('electrol_membership_member_other');

    let habituallyAttending = document.getElementById('habitually_attending');
    let preventedAttending = document.getElementById('prevented_attending');

    let otherHabituallyAttending = document.getElementById('electrol_membership_member_other_habitually_attending');
    let otherPreventedAttending = document.getElementById('electrol_membership_member_other_prevented_attending');

    if(notInParish.checked) {
      habituallyAttending.disabled = false;
      preventedAttending.disabled = false;
    } else {
      habituallyAttending.disabled = true;
      preventedAttending.disabled = true;

      habituallyAttending.checked = false;
      preventedAttending.checked = false;
    }

    if(other.checked) {
      otherHabituallyAttending.disabled = false;
      otherPreventedAttending.disabled = false;
    } else {
      otherHabituallyAttending.disabled = true;
      otherPreventedAttending.disabled = true;

      otherHabituallyAttending.checked = false;
      otherPreventedAttending.checked = false;
    }
  }
  document.getElementById('electrol_membership_member_in_parish').addEventListener('change', selectedNotInParish);
  document.getElementById('electrol_membership_member_not_in_parish').addEventListener('change', selectedNotInParish);
  document.getElementById('electrol_membership_member_other').addEventListener('change', selectedNotInParish);

  document.getElementById('registration-form').addEventListener('submit', function(e) {
    let returnSlide = 0;
    function setReturnSlide(slide) {
      if(slide < returnSlide) {
        returnSLide = slide;
      }
    }
    let submit = true;

    let userLogin = document.getElementById('user_login');
    if(userLogin.value === '') {
      submit = false;
      userLogin.parentElement.classList.add('error');
      setReturnSlide(0);
    } else {
      userLogin.parentElement.classList.remove('error');
    }

    let userEmail = document.getElementById('user_email');
    if(userEmail.value === '') {
      submit = false;
      userEmail.parentElement.classList.add('error');
      setReturnSlide(0);
    } else {
      userEmail.parentElement.classList.remove('error');
    }

    if(!validateEmail(userEmail.value)) {
      submit = false;
      userEmail.parentElement.classList.add('error');
      setReturnSlide(0);
    } else {
      userEmail.parentElement.classList.remove('error');
    }

    let userFirstName = document.getElementById('user_first_name');
    if(userFirstName.value === '') {
      submit = false;
      userFirstName.parentElement.classList.add('error');
      setReturnSlide(0);
    } else {
      userFirstName.parentElement.classList.remove('error');
    }

    let userLastName = document.getElementById('user_last_name');
    if(userLastName.value === '') {
      submit = false;
      userLastName.parentElement.classList.add('error');
      setReturnSlide(0);
    } else {
      userLastName.parentElement.classList.remove('error');
    }

    let userPassword = document.getElementById('user_pword');
    let passwordError = false;
    if(userPassword.value === '') {
      submit = false;
      passwordError = true;
      userPassword.parentElement.classList.add('error');
      setReturnSlide(0);
    } else {
      userPassword.parentElement.classList.remove('error');
    }

    if(!/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/.test(userPassword.value)) {
      submit = false;
      userPassword.parentElement.classList.add('error');
      passwordError = true;
      setReturnSlide(0);
    } else {
      userPassword.parentElement.classList.remove('error');
    }

    let userPasswordConfirm = document.getElementById('user_pword_confirm');
    if(passwordError || userPassword.value !== userPasswordConfirm.value) {
      submit = false;
      userPassword.parentElement.classList.add('error');
      setReturnSlide(0);
    } else {
      userPassword.parentElement.classList.remove('error');
    }

    if(!submit) {
      e.preventDefault();
      document.getElementsByClassName('btn active')[0].classList.remove('active');
      document.getElementsByClassName("wizard-step")[returnSlide].classList.add('active');
      bootstrap.Carousel.getOrCreateInstance(document.getElementById('sign-up-wizard')).to(returnSlide);
    }

    return submit;
  });
}

window.addEventListener("load", registrationOnLoad, true);