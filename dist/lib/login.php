<?php
  require '../config/config.php';
  $error = "";
  if(isset($_POST["email"]) && isset($_POST["password"])){
    // DB Connection
    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if($mysqli->errno){
      echo $mysqli->error;
      exit();
    }
    if(empty($_POST["email"])){
      $error = "Email cannot be empty";
    } elseif(empty($_POST["password"])){
      $error = "Password cannot be empty";
    } else{
      $sql = "SELECT user_id, password FROM users WHERE email='" . $_POST["email"] . "';";
      $results = $mysqli->query($sql);
      if(!$results){
        echo $mysqli->error;
        exit();
      }
      $mysqli->close();
      
      $row = $results->fetch_assoc();
      if($row){
        $hash = hash("sha256", $_POST["password"]);
        if($row["password"] == $hash){
          $_SESSION["logged_in"] = true;
          $_SESSION["user_id"] = $row["user_id"];
          exit();
        } else {
          $error = "2";
        }
      } else {
        $error = "1";
      }
    }
  }
  echo $error;
?>