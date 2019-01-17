$("#login-signup").click(function(e) {
  if (e.target === this) {
    $(this).hide();
  }
});
$("#signup-button").click(function() {
  $("#login-form").toggle();
  $("#signup-form").toggle();
  $("#fname").focus();
});
$("#signup-back-button").click(function() {
  $("#signup-form").toggle();
  $("#login-form").toggle();
  $("#login-email").focus();
});
function showLogin() {
  hide();
  $("#signup-form").hide();
  $("#login-form").show();
  $("#login-signup").show();
  $("#login-email").focus();
}
function show() {
  $("#links").show();
  $("#links").animate({
    left: 0
  });
  $("#overlay").show();
}
function hide() {
  $("#links").animate(
    {
      left: -220
    },
    function() {
      $("#links").hide();
    }
  );
  $("#overlay").hide();
}
function dropdown() {
  if ($("#links").is(":hidden")) {
    show();
  } else {
    hide();
  }
}
$("#overlay").click(function() {
  hide();
});
$("#dropdown-header").click(function() {
  hide();
});

$("#login-form :input").keyup(function(e) {
  if (e.keyCode === 13) {
    $("#login-submit").click();
  }
});
$("#signup-form :input").keyup(function(e) {
  if (e.keyCode === 13) {
    $("#signup-submit").click();
  }
});
