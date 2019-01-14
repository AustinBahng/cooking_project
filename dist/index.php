<?php
  require "components/navbar.php";
  $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
  if($mysqli->errno){
    echo $mysqli->error;
    exit();
  }
  $mysqli->set_charset('utf8');
  // get random recipes to be featured
  $sql = "SELECT recipe_id,name,image_url FROM recipes ORDER BY RAND() LIMIT 10;";
  $featured_results = $mysqli->query($sql);
  if(!$featured_results){
    echo $mysqli->error;
    exit();
  }
  // get popular recipes
  $sql = "SELECT recipe_id,name,image_url FROM recipes ORDER BY RAND() LIMIT 10;";
  $popular_results = $mysqli->query($sql);
  if(!$featured_results){
    echo $mysqli->error;
    exit();
  }
  $mysqli->close();
?>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Cookbook</title>
  </head>
  <body>
    <?php // require "components/navbar.php"; ?>
    <div class="container-fluid" id="content">
      <div class="row">
        <div class="col-12 column">
          <h1 class="preview-title">Featured Recipes</h1>
            <div id="featured-recipes" class="preview-list">
              <button class="scroll-button scroll-left"><i class="fas fa-chevron-left fa-2x"></i></button>
              <div class="horizontal-scroll">
                <?php while($row = $featured_results->fetch_assoc()) : ?>
                  <div class="recipe-preview" value="<?php echo $row["recipe_id"]; ?>">
                    <div class="img-wrapper">
                      <img src="<?php echo $row["image_url"]; ?>" />
                    </div>
                    <div class="recipe-label"><?php echo $row["name"]; ?></div>
                  </div>
                <?php endwhile; ?>
              </div>
              <button class="scroll-button scroll-right"><i class="fas fa-chevron-right fa-2x"></i></button>
            </div>  <!-- end of featured recipes -->
        </div>
      </div>
      <div class="row">
        <div class="col-12 column">
          <h1 class="preview-title">Featured Recipes</h1>
            <div id="popular-recipes" class="preview-list">
              <button class="scroll-button scroll-left"><i class="fas fa-chevron-left fa-2x"></i></button>
              <div class="horizontal-scroll">
                <?php while($row = $popular_results->fetch_assoc()) : ?>
                  <div class="recipe-preview" value="<?php echo $row["recipe_id"]; ?>">
                    <div class="img-wrapper">
                      <img src="<?php echo $row["image_url"]; ?>" />
                    </div>
                    <div class="recipe-label"><?php echo $row["name"]; ?></div>
                  </div>
                <?php endwhile; ?>
              </div>
              <button class="scroll-button scroll-right"><i class="fas fa-chevron-right fa-2x"></i></button>
            </div>  <!-- end of featured recipes -->
        </div>
      </div>
    </div> <!-- end of content -->
  </body>
  <?php require "components/footer.php"; ?>
  <script>
    bindScrollButtons('#featured-recipes');
    bindScrollButtons('#popular-recipes');

    $('.recipe-preview').click(function() {
      location.href = 'recipe.php?recipe_id=' + $(this).attr('value');
    })

    function bindScrollButtons(div_id){
      $(div_id).find('.scroll-right').click(function() {
        $(div_id).find('.horizontal-scroll').animate({
          scrollLeft: '+=763'
        });
      });
      $(div_id).find('.scroll-left').click(function() {
        $(div_id).find('.horizontal-scroll').animate({
          scrollLeft: '-=763'
        });
      });
      $(div_id).hover(function() {
        if(window.innerWidth >= 992){
          $(div_id).find('.scroll-button').show();
        }
      });
      $(div_id).mouseleave(function() {
        if(window.innerWidth >= 992){
          $(div_id).find('.scroll-button').hide();
        }
      });
    }
  </script>
</html>
