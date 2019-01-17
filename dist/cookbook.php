<?php
  require "components/navbar.php";
  if(isset($_SESSION["logged_in"]) && $_SESSION["logged_in"]){
    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if($mysqli->errno){
      echo $mysqli->error;
      exit();
    }
    $mysqli->set_charset('utf8');
    $sql = "SELECT recipes.recipe_id,name,image_url FROM user_recipes " .
            "INNER JOIN recipes USING(recipe_id) " .
            "WHERE user_recipes.user_id=" . $_SESSION["user_id"] . ";";
    $results = $mysqli->query($sql);
    if(!$results){
      echo $mysqli->error;
      exit();
    }
    $mysqli->close();
  }
?>
<html>
  <head>
  <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>My Cookbook</title>
  </head>
  <body>
    <div id="create_recipe_wrapper">
      <div id="create_recipe_overlay">
        <div id="create_recipe_title">
          <h1>Create Recipe</h1>
        </div>
        <form id="signup-form" method="POST">
          <div class="error-msg" id="error"></div>
          <div class="form-group">
            <label for="name">Recipe Name </label>
            <input type="text" class="form-control" id="name" placeholder="Recipe name">
            <div id="name-error" class="error-msg"></div>
          </div>
          <div class="form-group">
            <label for="url">Image URL</label>
            <input type="text" class="form-control" id="url" placeholder="Image URL">
            <div id="url-error" class="error-msg"></div>
          </div>
          <div class="form-group">
            <label for="serving-size">Serving Size</label>
            <input type="text" class="form-control" id="serving-size" placeholder="Serving size">
            <div id="serving-size-error" class="error-msg"></div>
          </div>
          <table class="table table-striped" id="ingredients">
            <thead>
              <tr>
                <th scope="col">Ingredient</th>
                <th scope="col">Quantity</th>
              </tr>
            </thead>
            <tbody></tbody>
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
          <table class="table table-striped" id="preparations">
            <thead>
              <tr>
                <th scope="col">Preparation</th>
              </tr>
            </thead>
            <tbody></tbody>
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
          <button type="submit" class="btn btn-primary">Create</button>
        </form>
      </div>
    </div>

    <div id="content" class="cookbook container-fluid">
      <?php if(isset($_SESSION["logged_in"]) && $_SESSION["logged_in"]){ ?>
      <div class="row">
        <div class="col-12 column">
          <h1>My Cookbook</h1>
          <div class="recipe-preview" id="add-recipe">
            <div class="img-wrapper"><i class="fas fa-plus fa-10x"></i></div>
            <div class="recipe-label">Add Recipe</div>
          </div>
          <?php while($row = $results->fetch_assoc()) : ?>
            <div class="recipe-preview" value="<?php echo $row["recipe_id"]; ?>">
              <div class="img-wrapper">
                <img src="<?php echo $row["image_url"]; ?>" />
              </div>
              <div class="recipe-label"><?php echo $row["name"]; ?></div>
            </div>
          <?php endwhile; ?>
        </div>
      </div>
      <?php } else { 
        require "components/login-notice.html";
      } ?>
    </div>
  </body>
  <?php require 'components/footer.php'; ?>
</html>
<script>
  $('.recipe-preview').click(function() {
    if($(this).attr('id') === 'add-recipe'){
      // location.href = 'add_recipe.php';
    } else{
      location.href = 'recipe.php?recipe_id=' + $(this).attr('value');
    }
  })
</script>