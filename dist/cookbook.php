<?php
  require "components/navbar.php";
  if(isset($_SESSION["logged_in"]) && $_SESSION["logged_in"]){
    $_SESSION["user_id"] = 1;
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
      location.href = 'add_recipe.php';
    } else{
      location.href = 'recipe.php?recipe_id=' + $(this).attr('value');
    }
  })
</script>