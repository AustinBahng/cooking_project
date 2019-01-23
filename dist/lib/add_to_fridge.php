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
      echo "Item name cannot be empty";
    } else{
      // check if ingredient exists in db
      $sql = "SELECT ingredient_id FROM ingredients WHERE name = '" . $_POST["name"] ."';";
      $results = $mysqli->query($sql);
      if(!$results){
        echo $mysqli->error;
        exit();
      }
      $ingredient_id = 0;
      // if no results, insert ingredient to db
      if($results->num_rows == 0){
        $sql = "INSERT INTO ingredients (name) VALUES ('" . $_POST["name"] . "');";
        $results = $mysqli->query($sql);
        if(!$results){
          echo "error 1";
          exit();
        }
        // get ingredient id of inserted row
        $sql = "SELECT ingredient_id FROM ingredients WHERE name = '" . $_POST["name"] ."';";
        $results = $mysqli->query($sql);
        if(!$results){
          echo $mysqli->error;
          exit();
        }
      }
      $row = $results->fetch_assoc();
      $ingredient_id = $row["ingredient_id"];
      // insert into users fridge
      $quantity = "";
      $expiring = "";
      if(isset($_POST["quantity"]) || !empty($_POST["quantity"])){
        $quantity = $_POST["quantity"];
      } 
      if(isset($_POST["expiring"]) || !empty($_POST["expiring"])){
        $expiring = $_POST["expiring"];
      } 
      $sql = "INSERT INTO users_fridge (user_id,ingredient_id,quantity,expiring) VALUES ('"
              . $_SESSION["user_id"] . "','"
              . $ingredient_id . "','"
              . $quantity . "','"
              . $expiring . "');";
      $results = $mysqli->query($sql);
      if(!$results){
        echo $mysqli->error;
        exit();
      }
      echo $mysqli->insert_id;
      $mysqli->close();
    }
  } else {
    echo "Login Required";
  }
?>