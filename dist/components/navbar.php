<?php
  require "config/config.php";
?>  
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
  <a class="navbar-brand" id="logo" href="#"><img class="logo" src="img/logo.png" /></a>
  <div id="icons">
    <ul>
      <li>
        <a href="index.php"><i class="fas fa-home"></i></a>
      </li>
      <li>
        <a href="fridge.php"><i class="fas fa-utensils"></i></a>
      </li>
      <li>
        <a href="cookbook.php"><i class="fas fa-book"></i></a>
      </li>
      <li>
        <a href="search.php"><i class="fas fa-search"></i></a>
      </li>
    </ul>
  </div>
  <div id="overlay"></div>
  <div id="links">
    <div id="dropdown-header"><img class="logo" src="img/logo.png" /></div>
    <hr>
    <?php 
      if($_SESSION["logged_in"]){ 
        // get user name
        $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        if($mysqli->errno){
          echo $mysqli->error;
          exit();
        }
        $mysqli->set_charset('utf8');
        $sql = "SELECT name FROM users " .
          "WHERE user_id=" . $_SESSION["user_id"] . ";";
        $results = $mysqli->query($sql);
        if(!$results){
          echo $mysqli->error;
          exit();
        }
        $row = $results->fetch_assoc();
    ?>
      <div id="logged-in-user"><i class="fas fa-user"></i><span id="user-name"><?php echo $row["name"]; ?></span></div>
      <hr>
    <?php } ?>
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
        <?php 
          if($_SESSION["logged_in"]){ ?>
          <a onclick="logout()" class="nav-link" id="logout-link"><i class="fas fa-sign-in-alt fa-flip-horizontal"></i>Log Out</a>
        <?php } else{ ?>
          <a onclick="showLogin()" class="nav-link"><i class="fas fa-sign-in-alt"></i>Log In</a>
        <?php } ?>
      </li>
    </ul>
  </div>
</nav>
<div id="nav-placeholder"></div>
<div id="content-placeholder"></div>
<div id="login-signup">
  <div id="login-form" class="form">
    <form>
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
      <button type="button" id="login-submit" class="btn btn-primary">Log In</button>
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
      <button type="button" id="signup-submit" class="btn btn-primary">Sign Up</button>
      <button type="button" id="signup-back-button" class="btn btn-primary">Back</button>
    </form>
  </div>
</div>
<script src="js/navbar.js"></script>
<script src="js/auth.js"></script>