<?php
  require '../config/config.php';
  if($_SESSION["logged_in"]){
    // DB Connection
    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if($mysqli->errno){
      echo $mysqli->error;
      exit();
    }

    if(!isset($_POST["name"]) || empty($_POST["name"])){
      echo "Name cannot be empty";
    } else{
      // add recipe to db
      $sql = "INSERT INTO recipes (name,image_url,serving_size,owner,time) VALUES ('" . $_POST["name"] . "','" .
              $_POST["url"] . "','" . $_POST["serving_size"] . "'," . $_SESSION["user_id"] .", '" . $_POST["cooking_time"] ."');";
      $results = $mysqli->query($sql);
      if(!$results){
        echo $mysqli->error;
        exit();
      }
      // get recipe_id
      $sql = "SELECT recipe_id FROM recipes ORDER BY recipe_id DESC LIMIT 1";
      $results = $mysqli->query($sql);
      if(!$results){
        echo $mysqli->error;
        exit();
      }
      $row = $results->fetch_assoc();
      $recipe_id = $row["recipe_id"];
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
      // add link to user_recipe
      $sql = "INSERT INTO user_recipes (user_id,recipe_id) VALUES (" . $_SESSION["user_id"] . "," .
              $recipe_id . ");"; 
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