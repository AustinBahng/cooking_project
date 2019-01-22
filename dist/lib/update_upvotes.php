<?php
  require '../config/config.php';
  if($_SESSION["logged_in"]){
    // DB Connection
    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if($mysqli->errno){
      echo $mysqli->error;
      exit();
    }
    // if increment is true, then add new entry to user_upvotes table
    if($_POST["increment"] == "true"){
      $sql = "INSERT INTO user_upvotes (user_id,recipe_id) VALUES (" . $_SESSION["user_id"] . "," . $_POST["recipe_id"] . ");";
      $results = $mysqli->query($sql);
      if(!$results){
        echo $mysqli->error;
        exit();
      }
    } else { // otherwise, delete the entry from user_upvotes
      $sql = "DELETE FROM user_upvotes WHERE user_id=" . $_SESSION["user_id"] . 
              " AND recipe_id=" . $_POST["recipe_id"] . ";";
      $results = $mysqli->query($sql);
      if(!$results){
        echo $mysqli->error;
        exit();
      }
    }
  }
?> 