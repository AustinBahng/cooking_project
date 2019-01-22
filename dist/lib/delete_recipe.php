<?php
  require "../config/config.php";
  // ensure logged in user is owner
  if($_SESSION["logged_in"]){
    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if($mysqli->errno){
      echo $mysqli->error;
      exit();
    }
    $sql = "SELECT owner FROM recipes WHERE recipe_id=" . $_POST["recipe_id"] . ";";
    $temp_results = $mysqli->query($sql);
    if(!$temp_results){
      echo $mysqli->error;
      exit();
    }
    $temp_row = $temp_results->fetch_assoc();
    if($temp_row["owner"] == $_SESSION["user_id"]){
      if(isset($_POST["recipe_id"]) && !empty($_POST["recipe_id"])){
        $recipe_id = $_POST["recipe_id"];
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
        // delete from user_upvotes
        $sql = "DELETE FROM user_upvotes WHERE recipe_id=" . $recipe_id . ";";
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
    } else {
      echo "Only Owner Can Delete Recipe";
    }
  } else {
    echo "Login Required";
  }
?>