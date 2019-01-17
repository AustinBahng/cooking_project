<?php
  require '../config/config.php';
  // DB Connection
  $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
  if($mysqli->errno){
    echo $mysqli->error;
    exit();
  }

  if(!isset($_POST["name"]) || empty($_POST["name"])){
    echo "Name cannot be empty";
  } elseif(!isset($_POST["password"]) || empty($_POST["password"])){
    echo "Password cannot be empty";
  } elseif(!isset($_POST["email"]) || empty($_POST["email"])){
    echo "Email cannot be empty";
  } else{
    // check if email already exists in db
    $sql = "SELECT * FROM users WHERE email='" . $_POST["email"] . "';";
    $results = $mysqli->query($sql);
    if(!$results){
      echo $mysqli->error;
      exit();
    }
    if($results->num_rows != 0){
      echo "Email is already in use";
      exit();
    }
    // create new user in db
    $hash = hash("sha256", $_POST["password"]);
    $sql = "INSERT INTO users (email,password,name) VALUES ('"
            . $_POST["email"] . "','"
            . $hash . "','"
            . $_POST["name"] . "');";
    $results = $mysqli->query($sql);
    if(!$results){
      echo $mysqli->error;
      exit();
    }
    // get assigned user id and set session
    $sql = "SELECT user_id FROM users WHERE email='" . $_POST["email"] . "';";
    $results = $mysqli->query($sql);
    if(!$results){
      echo $mysqli->error;
      exit();
    }
    $row = $results->fetch_assoc();
    $_SESSION["logged_in"] = true;
    $_SESSION["user_id"] = $row["user_id"];
    $mysqli->close();
  }
?>