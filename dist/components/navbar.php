<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" integrity="sha384-gfdkjb5BdAXd+lj+gudLWI+BXq4IuLW5IT+brZEZsLFm++aCMlF1V92rMkPaX4PP" crossorigin="anonymous">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
<link href="https://fonts.googleapis.com/css?family=Cinzel|Montserrat" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="css/main.css">

<nav class="navbar" id="navbar">
  <button class="navbar-toggler" onclick="dropdown()">
    <i class="fas fa-bars"></i>
  </button>
  <a class="navbar-brand" id="logo" href="#">Cookbook</a>
  <div id="overlay"></div>
  <div id="links">
    <div id="dropdown-header">Cookbook</div>
    <hr>
    <ul class="navbar-nav">
      <li class="nav-item">
        <a href="index.php" class="nav-link"><i class="fas fa-home"></i>Home</a>
      </li>
      <li class="nav-item">
        <a href="fridge.php" class="nav-link"><i class="fas fa-utensils"></i>Fridge</a>
      </li>
      <li class="nav-item">
        <a href="cookbook.php" class="nav-link"><i class="fas fa-book"></i>Cookbook</a>
      </li>
      <li class="nav-item">
        <a href="search.php" class="nav-link"><i class="fas fa-search"></i>Search</a>
      </li>
    </ul>
    <hr>
    <ul class="navbar-nav">
      <li class="nav-item">
        <a onclick="showLogin()" class="nav-link"><i class="fas fa-sign-in-alt"></i>Log In</a>
      </li>
    </ul>
  </div>
</nav>
<div id="nav-placeholder"></div>
<div id="content-placeholder"></div>
<div id="login-signup">
  <div id="login-form" class="form">
    <form>
      <div class="error-msg"></div>
      <div class="form-group">
        <label for="login-email">Email Address</label>
        <input type="email" class="form-control" id="login-email" name="email" placeholder="Email address">
        <div id="email-error" class="error-msg"></div>
      </div>
      <div class="form-group">
        <label for="login-password">Password</label>
        <input type="password" class="form-control" id="login-password" name="password" placeholder="Password">
        <div id="password-error" class="error-msg"></div>
      </div>
      <button type="button" class="btn btn-primary">Log In</button>
      <button type="button" id="signup-button" class="btn btn-primary">Sign Up</button>
    </form>
  </div>
  <div id="signup-form" class="form">
    <form>
      <div class="error-msg" id="signup-error"></div>
      <div class="form-group">
        <label for="fname">First Name</label>
        <input type="text" class="form-control" id="fname" placeholder="First name">
        <div id="fname-error" class="error-msg"></div>
      </div>
      <div class="form-group">
        <label for="lname">Last Name</label>
        <input type="text" class="form-control" id="lname" placeholder="Last name">
        <div id="lname-error" class="error-msg"></div>
      </div>
      <div class="form-group">
        <label for="signup-email">Email Address</label>
        <input type="email" class="form-control" id="signup-email" placeholder="Email address">
        <div id="signup-email-error" class="error-msg"></div>
      </div>
      <div class="form-group">
        <label for="signup-password">Password</label>
        <input type="password" class="form-control" id="signup-password" placeholder="Password">
        <div id="signup-password-error" class="error-msg"></div>
      </div>
      <div class="form-group">
        <label for="confirm-password">Confirm Password</label>
        <input type="password" class="form-control" id="confirm-password" placeholder="Confirm Password">
        <div id="confirm-password-error" class="error-msg"></div>
      </div>
      <button type="button" class="btn btn-primary">Sign Up</button>
      <button type="button" id="signup-back-button" class="btn btn-primary">Back</button>
    </form>
  </div>
</div>
<script>
  $('#login-signup').click(function(e) {
    if(e.target === this){
      $(this).hide();
    }
  });
  $('#signup-button').click(function() {
    $('#login-form').toggle();
    $('#signup-form').toggle();
  });
  $('#signup-back-button').click(function() {
    $('#signup-form').toggle();
    $('#login-form').toggle();
  })
  function showLogin(){
    hide();
    $('#signup-form').hide();
    $('#login-form').show();
    $('#login-signup').show();
  }
  function show(){
    $('#links').show();
    $('#links').animate({
      left: 0
    });
    $('#overlay').show();
  }
  function hide(){
    $('#links').animate({
      left: -220
    }, function() {
      $('#links').hide();
    });
    $('#overlay').hide();
  }
  function dropdown() {
    if($('#links').is(':hidden')){
      show();
    } else {
      hide();
    }
  }
  $('#overlay').click(function() {
    hide();
  });
  $('#dropdown-header').click(function() {
    hide();
  })
</script>
