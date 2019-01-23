<?php
  require '../config/config.php';
  if($_SESSION["logged_in"]){
    // DB Connection
    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if($mysqli->errno){
      echo $mysqli->error;
      exit();
    }
    if(!isset($_POST["index"]) || empty($_POST["index"])){
      echo "Ingredient ID name cannot be empty";
    } else{
      // check if ingredient exists in db
      $sql = "DELETE FROM users_fridge WHERE users_fridge.index=" . $_POST["index"] .";";
      $results = $mysqli->query($sql);
      if(!$results){
          echo $mysqli->error;
          exit();
      }
      
      $mysqli->close();
    }
  } else {
    echo "Login Required";
  }
?>