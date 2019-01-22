<?php
  require "components/navbar.php";
  $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
  if($mysqli->errno){
    echo $mysqli->error;
    exit();
  }
  $mysqli->set_charset('utf8');
  $sql = "SELECT name,image_url,serving_size,owner,time FROM recipes " .
          "WHERE recipes.recipe_id=" . $_GET["recipe_id"] . ";";
  $results = $mysqli->query($sql);
  if(!$results){
    echo $mysqli->error;
    exit();
  }
  $row = $results->fetch_assoc();
  // get ingredients
  $sql = "SELECT quantity,ingredients.name FROM recipe_ingredients " .
          "INNER JOIN ingredients USING(ingredient_id) " .
          "WHERE recipe_id=" . $_GET["recipe_id"] . ";";
  $ingredient_results = $mysqli->query($sql);
  if(!$ingredient_results){
    echo $mysqli->error;
    exit();
  }
  // get instructions
  $sql = "SELECT step,instruction FROM instructions " .
          "WHERE recipe_id=" . $_GET["recipe_id"] . ";";
  $instruction_results = $mysqli->query($sql);
  if(!$instruction_results){
    echo $mysqli->error;
    exit();
  }
  // get name of owner
  $sql = "SELECT name FROM users WHERE user_id=" . $row["owner"] . ";";
  $temp_results = $mysqli->query($sql);
  if(!$temp_results){
    echo $mysqli->error;
    exit();
  }
  $temp_row = $temp_results->fetch_assoc();
  $owner_name = $temp_row["name"];
  // get number of upvotes
  $sql = "SELECT COUNT(DISTINCT user_id,recipe_id) as upvotes FROM user_upvotes " .
          "WHERE recipe_id=" . $_GET["recipe_id"] . ";";
  $temp_results = $mysqli->query($sql);
  if(!$temp_results){
    echo $mysqli->error;
    exit();
  }
  $temp_row = $temp_results->fetch_assoc();
  $num_upvotes = $temp_row["upvotes"];
  // check if logged in user is owner and if recipe is in cookbook
  $owner = false;
  $in_cookbook = false;
  if($_SESSION["logged_in"]){
    $sql = "SELECT owner FROM recipes WHERE recipe_id=" . $_GET["recipe_id"] . ";";
    $temp_results = $mysqli->query($sql);
    if(!$temp_results){
      echo $mysqli->error;
      exit();
    }
    $temp_row = $temp_results->fetch_assoc();
    if($temp_row["owner"] == $_SESSION["user_id"]){
      $owner = true;
      $in_cookbook = true;
    } else {
      $sql = "SELECT * FROM user_recipes " .
              "WHERE recipe_id=" . $_GET["recipe_id"] . 
              " AND user_id=" . $_SESSION["user_id"] . ";";
      $temp_results = $mysqli->query($sql);
      if(!$temp_results){
        echo $mysqli->error;
        exit();
      }
      $temp_row = $temp_results->fetch_assoc();
      if($temp_row){
        $in_cookbook = true;
      }
    }
    // check if logged in user has liked recipe
    $sql = "SELECT * FROM user_upvotes WHERE user_id=" . $_SESSION["user_id"] . 
            " AND recipe_id=" . $_GET["recipe_id"] . ";";
    $temp_results = $mysqli->query($sql);
    if(!$temp_results){
      echo $mysqli->error;
      exit();
    }
    $temp_row = $temp_results->fetch_assoc();
    $has_upvoted = ($temp_results->num_rows > 0) ? true : false;
  }
  $mysqli->close();
?>
<!doctype html>
<html>
  <head>
    <title><?php echo $row["name"]; ?></title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />      
  </head>
  <body>  
    <div id="edit_recipe_wrapper" class="overlay-wrapper">
      <div id="edit_recipe_overlay" class="popup-wrapper">
        <div id="edit_recipe_title" class="popup-title">
          <h1>Edit Recipe</h1>
        </div>
        <form id="edit-recipe-form">
          <div class="error-msg" id="error"></div>
          <div class="form-group">
            <label for="name">Recipe Name </label>
            <input type="text" class="form-control" id="edit-name" placeholder="Recipe name" value="<?php echo $row["name"]; ?>">
            <div id="name-error" class="error-msg"></div>
          </div>
          <div class="form-group">
            <label for="url">Image URL</label>
            <input type="text" class="form-control" id="edit-url" placeholder="Image URL" value="<?php echo $row["image_url"]; ?>">
            <div id="url-error" class="error-msg"></div>
          </div>
          <div class="form-group">
            <label for="cooking-time">Cooking Time</label>
            <input type="text" class="form-control" id="edit-cooking-time" placeholder="Cooking time" value="<?php echo $row["time"]; ?>">
            <div id="cooking-time-error" class="error-msg"></div>
          </div>
          <div class="form-group">
            <label for="serving-size">Serving Size</label>
            <input type="text" class="form-control" id="edit-serving-size" placeholder="Serving size" value="<?php echo $row["serving_size"]; ?>">
            <div id="serving-size-error" class="error-msg"></div>
          </div>
          <table class="table table-striped" id="edit-form-ingredients">
            <thead>
              <tr>
                <th scope="col">Ingredient</th>
                <th scope="col">Quantity</th>
              </tr>
            </thead>
            <tbody>
              <?php 
                while($temp_row = $ingredient_results->fetch_assoc()) : 
              ?>
                <tr class="ingredient">
                  <th scope="row"><?php echo $temp_row["name"]; ?></th>
                  <td><span><?php echo $temp_row["quantity"]; ?></span><i class="fas fa-times-circle"></i></td>
                </tr>
              <?php 
                endwhile; 
                $ingredient_results->data_seek(0);
              ?>
            </tbody>
            <tfoot>
              <tr id="add-ingredient-row">
                <td><input type="text" class="form-control" id="add-name" placeholder="Ingredient"/></td>
                <td><input type="text" class="form-control" id="add-quantity" placeholder="Quantity"/></td>
              </tr>
              <tr>
                <td colspan="5">
                  <input type="button" class="btn btn-lg btn-block add-button" id="add-ingredient-button" value="Add Ingredient" />
                </td>
              </tr>
            </tfoot>
          </table>
          <table class="table table-striped" id="edit-preparations">
            <thead>
              <tr>
                <th scope="col">Preparation</th>
              </tr>
            </thead>
            <tbody>
              <?php 
                while($temp_row = $instruction_results->fetch_assoc()) : 
              ?>
                <tr class="preparation">
                  <td scope="row"><div><?php echo $temp_row["instruction"]; ?></div><i class="fas fa-times-circle"></i></td>
                </tr>
              <?php 
                endwhile; 
                $instruction_results->data_seek(0);
              ?>
            </tbody>
            <tfoot>
              <tr id="add-preparation-row">
                <td><input type="text" class="form-control" id="add-preparation" placeholder="Instructions"/></td>
              </tr>
              <tr>
                <td colspan="5">
                  <input type="button" class="btn btn-lg btn-block add-button" id="add-preparation-button" value="Add Preparation Step" />
                </td>
              </tr>
            </tfoot>
          </table>
          <button id="update-recipe-submit-button" class="btn btn-primary">Update</button>
        </form>
      </div>
    </div>

    <div id="content" class="container-fluid">
      <div class="row" id="recipe-header">
        <div class="column col-12 col-lg-9 " >
          <h1><?php echo $row["name"]; ?></h1>
          <div id="author-button-wrapper">
            <div id="author">By <?php echo $owner_name; ?></div>
            <div class="rating-wrapper">
              <i class="fas fa-thumbs-up rating-icon"></i>
              <span class="rating-number"><?php echo $num_upvotes; ?></span>
            </div>
            <?php 
              if($_SESSION["logged_in"]){ 
                if($has_upvoted){

            ?>
              <button id="rating-button" class="upvoted">Unlike</button>
            <?php
                } else {
            ?>
            <button id="rating-button">Like</button>
            <?php 
                }
              } 
            ?>
          </div>
          <div id="recipe-info-wrapper">
            <div id="time" class="recipe-info">
              <span class="header">Time</span>
              <span class="value"><?php echo $row["time"]; ?></span>
            </div>
            <div id="yield" class="recipe-info">
              <span class="header">Yield</span>
              <span class="value"><?php echo $row["serving_size"]; ?></span>
            </div>
          </div>
          <div id="buttons">
            <?php 
              if($_SESSION["logged_in"]) { 
                if(!$in_cookbook){
            ?>
            <button class="btn" id="add-button">Add To Cookbook</button>
            <?php
                } else {
            ?>
            <button class="btn" id="add-button" disabled>Added To Cookbook</button>
            <?php
                }
                if($owner) { 
            ?>
            <button class="btn" id="edit-button">Edit</button>
            <button class="btn" id="delete-button">Delete</button>
            <?php }} ?>
          </div>
        </div>
        <div class="column col-12 col-lg-3">
          <div id="recipe-image-wrapper">
            <img id="recipe-image" src="<?php echo $row["image_url"]; ?>" />
          </div>
        </div>
      </div>
      <div class="row">
        <div class="column col-12 col-md-4">
          <div id="ingredients">
            <h4>Ingredients</h4>
            <ul id="ingredient-list" class="list-group">
              <?php while($row = $ingredient_results->fetch_assoc()) : ?>
                <li class="ingredient-single list-group-item"><?php echo $row["quantity"] . " " . $row["name"]; ?></li>
              <?php endwhile; ?>
            </ul>
          </div>
        </div>
        <div class="column col-12 col-md-8">
          <div id="instruction">
            <h4>Preparation</h4>
            <div id="instruction-table-wrapper">
              <table class="table table-striped">
                <tbody>
                  <?php while($row = $instruction_results->fetch_assoc()) : ?>
                    <tr>
                      <th scope="row"><?php echo $row["step"]; ?></th>
                      <td><?php echo $row["instruction"]; ?></td>
                    </tr>
                  <?php endwhile; ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </body>
  <?php require "components/footer.php"; ?>
  <script src="js/recipe.js"></script>
</html>