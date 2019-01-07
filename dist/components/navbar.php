<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" integrity="sha384-gfdkjb5BdAXd+lj+gudLWI+BXq4IuLW5IT+brZEZsLFm++aCMlF1V92rMkPaX4PP" crossorigin="anonymous">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
<link href="https://fonts.googleapis.com/css?family=Cinzel|Montserrat" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="css/main.css">

<nav class="navbar" id="navbar">
    <button class="navbar-toggler" onclick="dropdown()">
        <i class="fas fa-bars"></i>
    </button>
    <a class="navbar-brand" id="logo" href="#">Cookbook</a>
    <div id="overlay"></div>
    <div id="links">
        <div id="dropdown-header">Cookbook</div>
        <hr>
        <ul class="navbar-nav">
            <li class="nav-item">
                <a href="index.php" class="nav-link"><i class="fas fa-home"></i>Home</a>
            </li>
            <li class="nav-item">
                <a href="fridge.php" class="nav-link"><i class="fas fa-utensils"></i>Fridge</a>
            </li>
            <li class="nav-item">
                <a href="cookbook.php" class="nav-link"><i class="fas fa-book"></i>Cookbook</a>
            </li>
            <li class="nav-item">
                <a href="search.php" class="nav-link"><i class="fas fa-search"></i>Search</a>
            </li>
        </ul>
    </div>
</nav>
<div id="nav-placeholder"></div>
<div id="content-placeholder"></div>
<script>
    function show(){
        $('#links').show();
        $('#links').animate({
            left: 0
        });
        $('#overlay').show();
    }
    function hide(){
        $('#links').animate({
            left: -220
        }, function() {
            $('#links').hide();
        });
        $('#overlay').hide();
    }
    function dropdown() {
        if($('#links').is(':hidden')){
            show();
        } else {
            hide();
        }
    }
    $('#overlay').click(function() {
        hide();
    });
    $('#dropdown-header').click(function() {
        hide();
    })
</script>
