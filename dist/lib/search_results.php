<?php
  $terms = $_GET["terms"];
  $result_array = [];

  require "../config/config.php";
  $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
  if($mysqli->errno){
    echo $mysqli->error;
    exit();
  }
  $mysqli->set_charset('utf8');
  // search recipes by ingredient
  $sql = "SELECT DISTINCT recipes.recipe_id,recipes.name,recipes.image_url FROM recipes " .
          "INNER JOIN recipe_ingredients USING(recipe_id) " .
          "WHERE name LIKE '%" . $terms . "%'";
  // loop through and add to where condition for each ingredient
  if(isset($_GET["ingredients"])){
    $ingredients = $_GET["ingredients"];
    $sql = $sql . " AND ingredient_id IN ('";
    for($i = 0; $i < count($ingredients) - 1; $i++) {
      $sql = $sql . $ingredients[$i] . "','";
    }
    $sql = $sql . $ingredients[count($ingredients) - 1] . "');";
  } else {
    $sql = $sql . ";";
  }

  $results = $mysqli->query($sql);
  if(!$results){
    echo $mysqli->error;
    exit();
  }
  $mysqli->close();

  while($row = $results->fetch_assoc()) {
    array_push($result_array, $row);
  }

  echo json_encode($result_array);
?>