<?php
  require "components/navbar.php";
  if(isset($_SESSION["logged_in"]) && $_SESSION["logged_in"]){
    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if($mysqli->errno){
      echo $mysqli->error;
      exit();
    }
    $mysqli->set_charset('utf8');
    $sql = "SELECT users_fridge.index,users_fridge.ingredient_id,ingredients.name,quantity,expiring FROM users_fridge " .
            "INNER JOIN ingredients USING(ingredient_id)" .
            "INNER JOIN users USING(user_id) " .
            "WHERE users_fridge.user_id = " . $_SESSION["user_id"] . ";";
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
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>My Fridge</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" type="text/css" media="screen" href="css/main.css" />
</head>
<body>
  <div class="container-fluid" id="content">
    <?php if(isset($_SESSION["logged_in"]) && $_SESSION["logged_in"]){ ?>
    <div class="row">
      <div class="col-12 column">
        <h1>My Fridge</h1>
        <div id="my-fridge">
          <table class="table table-striped">
            <thead>
              <tr>
                <th scope="col">Item</th>
                <th scope="col">Quantity</th>
                <th scope="col">Expiring</th>
              </tr>
            </thead>
              <tbody>
                <?php while($row = $results->fetch_assoc()) : ?>
                  <tr value="<?php echo $row["index"]; ?>">
                    <th scope="row"><?php echo $row["name"]; ?></th>
                    <td><span id="quantity"><?php echo $row["quantity"]; ?></span> <span id="measurement-unit"></span></td>
                    <td><?php echo $row["expiring"]; ?><button class="remove-ingredient btn">Remove</button></td>
                  </tr>
                <?php endwhile; ?>
              </tbody>
              <tfoot>
                <tr id="add-row">
                  <td><input type="text" class="form-control" id="add-name" placeholder="Name"/></td>
                  <td id="add-quantity-row">
                    <input type="text" class="form-control" id="add-quantity" placeholder="Qty."/>
                  </td>
                  <td><input type="date" class="form-control" id="add-expiring" placeholder="Exp."/></td>
                </tr>
                <tr>
                  <td colspan="5">
                    <input type="button" class="btn btn-lg btn-block " id="add-item-button" value="Add Item" />
                  </td>
                </tr>
              </tfoot>
          </table>
        </div>
      </div>
    </div> <!-- end of row -->
    <?php } else{
      require "components/login-notice.html";
    } ?>
  </div> <!-- end of container -->
</body>
<?php require "components/footer.php"; ?>
<script src="js/fridge.js"></script>
</html>