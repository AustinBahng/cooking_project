<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" integrity="sha384-gfdkjb5BdAXd+lj+gudLWI+BXq4IuLW5IT+brZEZsLFm++aCMlF1V92rMkPaX4PP" crossorigin="anonymous">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
<link rel="stylesheet" type="text/css" href="css/main.css">

<nav class="navbar" id="navbar">
    <button class="navbar-toggler" onclick="dropdown()">
        <i class="fas fa-bars"></i>
    </button>
    <!-- <div id="logo-wrapper"> -->
        <a class="navbar-brand" id="logo" href="#">Logo</a>
    <!-- </div> -->
    <div id="overlay"></div>
    <div id="links">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a href="#" class="nav-link">Home</a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">Fridge</a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">Cookbook</a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">Search</a>
            </li>
        </ul>
    </div>
</nav>

<script>
    function show(){
        $('#links').show();
        $('#links').animate({
            left: 0
        });
        if(window.innerWidth < 992){
            $('#overlay').show();
        } else {
            $('#content').animate({
                left: 200,
                width: '-=200'
            });
        }
    }
    function hide(){
        $('#links').animate({
            left: -200
        }, function() {
            $('#links').hide();
        });
        if(window.innerWidth < 992){
            $('#overlay').hide();
        } else {
            $('#content').animate({
                left: 0,
                width: '+=200'
            });
        }
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
    })
</script>
