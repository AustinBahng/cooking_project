<?php
  require "../config/config.php";
  if(isset($_POST["recipe_id"]) && !empty($_POST["recipe_id"])){
    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if($mysqli->errno){
      echo $mysqli->error;
      exit();
    }
    $mysqli->set_charset('utf8');
    $sql = "INSERT INTO user_recipes (user_id,recipe_id) VALUES (" . $_SESSION["user_id"] . "," . $_POST["recipe_id"] . ");";
    $results = $mysqli->query($sql);
    if(!$results){
      echo $mysqli->error;
      exit();
    }
    $mysqli->close();
  } else {
    echo "Missing Recipe ID";
  }
?>