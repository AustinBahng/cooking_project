<?php
  require "config/config.php";
  // if($_SESSION["logged_in"]){
    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if($mysqli->errno){
      echo $mysqli->error;
      exit();
    }
    $_SESSION["user_id"] = 1;
    $mysqli->set_charset('utf8');
    $sql = "SELECT users_fridge.ingredient_id,ingredients.name,quantity,expiring FROM users_fridge " .
            "INNER JOIN ingredients USING(ingredient_id)" .
            "INNER JOIN users USING(user_id) " .
            "WHERE users_fridge.user_id = " . $_SESSION["user_id"] . ";";
    $fridge_results = $mysqli->query($sql);
    if(!$fridge_results){
      echo $mysqli->error;
      exit();
    }
    $mysqli->close();
  // }
?>
<!doctype html>
<html>
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Search</title>
  </head>
  <body>
    <?php require 'components/navbar.php'; ?>
    <div class="container-fluid" id="content">
      <div class="row">
        <div class="col-12 column">
          <div id="search">
            <h1>Search Recipes</h1>
            <div id="search-form">
              <form>
                <input type="text" placeholder="Search recipes..." name="reciple-search" id="search-terms">
                <button id="search-button"><i class="fa fa-search"></i></button>
                <h3>Select items from my fridge</h3>
                <div id="fridge-search-options" class="container-fluid">
                  <div class="row">
                    <?php while($row = $fridge_results->fetch_assoc()) : ?>
                    <div class="form-check col-6 col-sm-4 col-md-2">
                      <input class="form-check-input" type="checkbox" value="<?php echo $row["ingredient_id"]; ?>" id="<?php echo $row["name"]; ?>">
                      <label class="form-check-label" for="<?php echo $row["name"]; ?>"><?php echo $row["name"]; ?></label>
                    </div>
                    <?php endwhile; ?>
                  </div>
                </div>
              </form>
            </div>
          </div> <!-- end of search -->
        </div>
      </div>
      <div class="row" id="search-results">
        <div class="col-12 column">
          <h1>Results</h1>
          <div id="results"></div>
        </div>
      </div>
    </div> <!-- end of content -->
  </body>
  <script>
    $('.recipe-preview').click(function() {
      location.href = 'recipe.php';
    })
    // change this to use ajax to search backend database
    $('#search-button').click(function(event) {
      event.preventDefault();
      // clear results first
      $('#results').html('');
      
      let xml = new XMLHttpRequest();
      xml.onreadystatechange = function() {
        if(this.readyState == 4 && this.status == 200){
          console.log(this.responseText);
          let results = JSON.parse(this.responseText);
          for(let i = 0; i < results.length; i++){
            let preview = '<div class="recipe-preview" value="' + results[i]['recipe_id'] + '"><div class="img-wrapper">' +
                            '<img src="' + results[i]['image_url'] + '" /></div><div class="recipe-label">' + 
                            results[i]['name'] + '</div></div>';
            $('#results').append(preview);
          }
          // bind search results    
          $('.recipe-preview').click(function() {
            location.href = 'recipe.php?recipe_id=' + $(this).attr('value');
          });
          $('#search-results').show();
        }
      };
      let url = 'lib/search_results.php?terms=' + $('#search-terms').val();
      let ingredients = new Array();
      $('input:checked').each(function() {
          url += '&ingredients[]=' + $(this).val();
      })
      xml.open('GET', url, true);
      xml.send();
    });
  </script>
</html>