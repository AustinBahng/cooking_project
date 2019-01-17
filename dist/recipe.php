<?php
  require "components/navbar.php";
    // if($_SESSION["logged_in"]){
        $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        if($mysqli->errno){
            echo $mysqli->error;
            exit();
        }
        $mysqli->set_charset('utf8');
        $sql = "SELECT name,image_url,serving_size FROM recipes " .
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
        $mysqli->close();
    // }
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
        <div id="content" class="container-fluid">
            <div class="row" id="recipe-header">
                <div class="column col-12 col-lg-9 " >
                    <h1><?php echo $row["name"]; ?></h1>
                    <div id="author-button-wrapper">
                        <div id="author">By Austin Bahng</div>
                        <div class="rating-wrapper">
                            <i class="fas fa-thumbs-up rating-icon"></i>
                            <span class="rating-number">2,534</span>
                        </div>
                        <button id="rating-button">Like</button>
                    </div>
                    <div id="recipe-info-wrapper">
                        <div id="time" class="recipe-info">
                            <span class="header">Time</span>
                            <span class="value">30 Minutes</span>
                        </div>
                        <div id="yield" class="recipe-info">
                            <span class="header">Yield</span>
                            <span class="value"><?php echo $row["serving_size"]; ?></span>
                        </div>
                    </div>
                    <div id="buttons">
                        <button class="btn" id="add-button">Add To Cookbook</button>
                        <button class="btn" id="edit-button">Edit</button>
                        <button class="btn" id="delete-button">Delete</button>
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