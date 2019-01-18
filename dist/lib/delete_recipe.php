<?php
  require "../config/config.php";
  if(isset($_GET["recipe_id"]) && !empty($_GET["recipe_id"])){
    $recipe_id = $_GET["recipe_id"];
    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if($mysqli->errno){
      echo $mysqli->error;
      exit();
    }
    $mysqli->set_charset('utf8');
    // delete from recipe ingredients
    $sql = "DELETE FROM recipe_ingredients WHERE recipe_id=" . $recipe_id . ";";
    $results = $mysqli->query($sql);
    if(!$results){
      echo $mysqli->error;
      exit();
    }
    // delete from instructions
    $sql = "DELETE FROM instructions WHERE recipe_id=" . $recipe_id . ";";
    $results = $mysqli->query($sql);
    if(!$results){
      echo $mysqli->error;
      exit();
    }
    // delete from user recipes
    $sql = "DELETE FROM user_recipes WHERE recipe_id=" . $recipe_id . ";";
    $results = $mysqli->query($sql);
    if(!$results){
      echo $mysqli->error;
      exit();
    }
    // delete from recipes
    $sql = "DELETE FROM recipes WHERE recipe_id=" . $recipe_id . ";";
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