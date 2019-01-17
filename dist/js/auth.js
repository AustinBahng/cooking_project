function validateLogin() {
  let email = false;
  let password = false;
  if ($("#login-email").val() === null || $("#login-email").val() === "") {
    $("#email-error").html("Email cannot be empty");
    email = false;
  } else {
    $("#email-error").html("");
    email = true;
  }
  if (
    $("#login-password").val() === null ||
    $("#login-password").val() === ""
  ) {
    $("#password-error").html("Password cannot be empty");
    password = false;
  } else {
    $("#password-error").html("");
    password = true;
  }
  return password && email;
}

function validateSignup() {
  let error = false;
  if ($("#fname").val() === null || $("#fname").val() === "") {
    $("#fname-error").html("First name cannot be empty");
    error = true;
  } else {
    $("#fname-error").html("");
  }
  if ($("#lname").val() === null || $("#lname").val() === "") {
    $("#lname-error").html("Last name cannot be empty");
    error = true;
  } else {
    $("#lname-error").html("");
  }
  if ($("#signup-email").val() === null || $("#signup-email").val() === "") {
    $("#signup-email-error").html("Email cannot be empty");
    error = true;
  } else {
    $("#signup-email-error").html("");
  }
  if (
    $("#signup-password").val() === null ||
    $("#signup-password").val() === ""
  ) {
    $("#signup-password-error").html("Password cannot be empty");
    error = true;
  } else {
    $("#signup-password-error").html("");
  }
  if ($("#confirm-password").val() !== $("#signup-password").val()) {
    $("#confirm-password-error").html("Passwords must match");
    error = true;
  } else {
    $("#confirm-password-error").html("");
  }
  return !error;
}

$("#login-submit").click(function() {
  if (!validateLogin()) {
    return;
  }
  let url = "lib/login.php";
  let postRequest = $.post(url, {
    email: $("#login-email").val(),
    password: $("#login-password").val()
  });

  postRequest.done(function(error) {
    $("#login-form .error-msg").html("");
    if (error) {
      if (error == 1) {
        $("#email-error").html("Invalid Email");
      } else if (error == 2) {
        $("#password-error").html("Invalid Password");
      } else {
        console.log(error);
      }
    } else {
      location.reload();
    }
  });
});

$("#signup-submit").click(function() {
  console.log("click");
});
function logout() {
  if (confirm("Are you sure you want log out?")) {
    window.location.href = "lib/logout.php";
  }
}
