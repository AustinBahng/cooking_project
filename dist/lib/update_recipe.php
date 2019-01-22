<?php
  require '../config/config.php';
  if($_SESSION["logged_in"]){
    // DB Connection
    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if($mysqli->errno){
      echo $mysqli->error;
      exit();
    }
    $recipe_id = $_POST["recipe_id"];
    // ensure logged in user is owner
    $sql = "SELECT owner FROM recipes WHERE recipe_id=" . $recipe_id . ";";
    $temp_results = $mysqli->query($sql);
    if(!$temp_results){
      echo $mysqli->error;
      exit();
    }
    $temp_row = $temp_results->fetch_assoc();
    if($temp_row["owner"] == $_SESSION["user_id"]){
      // post updated recipe
      if(!isset($_POST["name"]) || empty($_POST["name"])){
        echo "Name cannot be empty";
      } else{
        // add recipe to db
        $sql = "UPDATE recipes SET name='" . $_POST["name"] . "', image_url='" . $_POST["url"] . "', serving_size='" .
                $_POST["serving_size"] . "', time='" . $_POST["cooking_time"] . "' WHERE recipe_id=" . $recipe_id . ";";
        $results = $mysqli->query($sql);
        if(!$results){
          echo $mysqli->error;
          exit();
        }
        // add ingredients to db
        if(isset($_POST["ingredient"])){
          $ingredients = $_POST["ingredient"];
          for($i = 0; $i < count($ingredients); $i++){
            $sql = "INSERT INTO ingredients (name) VALUES ('" . $ingredients[$i] . "');";
            $results = $mysqli->query($sql);
          }
        }
        // add quantity to db
        if(isset($_POST["quantity"])){
          // delete old list of recipe ingredients quantities
          $sql = "DELETE FROM recipe_ingredients WHERE recipe_id=" . $recipe_id . ";";
          $results = $mysqli->query($sql);
          if(!$results){
              echo $mysqli->error;
              exit();
          }
          // add new list
          $ingredients = $_POST["ingredient"];
          $quantity = $_POST["quantity"];
          for($i = 0; $i < count($ingredients); $i++){
            // get ingredient id
            $sql = "SELECT ingredient_id FROM ingredients WHERE name='" . $ingredients[$i] . "';";
            $results = $mysqli->query($sql);
            if(!$results){
              echo $mysqli->error;
              exit();
            }
            $row = $results->fetch_assoc();
            $ingredient_id = $row["ingredient_id"];
            // add the quantity
            $sql = "INSERT INTO recipe_ingredients (recipe_id,ingredient_id,quantity) VALUES (" .
                    $recipe_id . "," . $ingredient_id . ",'" . $quantity[$i] . "');";
            $results = $mysqli->query($sql);
            if(!$results){
              echo $mysqli->error;
              exit();
            }
          }
        }
        // add instructions to db
        if(isset($_POST["preparation"])){
          // delete old list of instructions
          $sql = "DELETE FROM instructions WHERE recipe_id=" . $recipe_id . ";";
          $results = $mysqli->query($sql);
          if(!$results){
              echo $mysqli->error;
              exit();
          }
          // add new list
          $preparation = $_POST["preparation"];
          for($i = 0; $i < count($preparation); $i++){
            $sql = "INSERT INTO instructions (recipe_id,step,instruction) VALUES (" .
                    $recipe_id . "," . ($i + 1) . ",'" . $preparation[$i] . "');";
            $results = $mysqli->query($sql);
            if(!$results){
              echo $mysqli->error;
              exit();
            }
          }
        }
        $mysqli->close();
      }
    } else {
      echo "Only Owner Can Edit Recipe";
    }
  } else {
    echo "Login Required";
  }
?> 