<?php
error_reporting(0);

function processNavs($ars,$ulset){
    include('inc/harness.php');
$nav .= '<ul class="'.$ulset.'">';
for($i=0; $i<count($ars); $i++){
    if(count($ars[$i]) > 1){
        $a = $data->query("SELECT * FROM pre_nav WHERE id = '".$ars[$i]["id"]."'");
        $b = $a->fetch_array();
        $nav .= '<li class="'.$b["li_class"].'"><a href="'.$b["nav_link"].'" class="'.$b["nav_class"].'" '.$b["nav_data_attr"].'>'.$b["nav_read"].'</a>';
        $nav .= processNavs($ars[$i]["children"],$b["ul_class"]);
        $nav .= '</li>';
    }else{
        $a = $data->query("SELECT * FROM pre_nav WHERE id = '".$ars[$i]["id"]."'");
        $b = $a->fetch_array();
         $nav .= '<li class="'.$b["li_class"].'"><a href="'.$b["nav_link"].'" class="'.$b["nav_class"].'" '.$b["nav_data_attr"].'>'.$b["nav_read"].'</a></li>';
    }

}

$nav .= '</ul>';

return $nav;
}

$ars = json_decode('[{"id":"1"},{"id":"2"},{"id":"3"}]',true);


//echo '<pre>';
//var_dump($ars);
//echo '</pre>';

?>
<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <style>
        .dropdown-submenu {
            position: relative;
        }

        .dropdown-submenu a::after {
            transform: rotate(-90deg);
            position: absolute;
            right: 6px;
            top: .8em;
        }

        .dropdown-submenu .dropdown-menu {
            top: 0;
            left: 100%;
            margin-left: .1rem;
            margin-right: .1rem;
        }
    </style>

    <title>Hello, world!</title>
</head>
<body>



<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#">Navbar</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <?php echo processNavs($ars,'navbar-nav mr-auto'); ?>
    </div>
</nav>



<h1>Hello, world!</h1>

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script>
    $('.dropdown-menu a.dropdown-toggle').on('click', function(e) {
        if (!$(this).next().hasClass('show')) {
            $(this).parents('.dropdown-menu').first().find('.show').removeClass("show");
        }
        var $subMenu = $(this).next(".dropdown-menu");
        $subMenu.toggleClass('show');


        $(this).parents('li.nav-item.dropdown.show').on('hidden.bs.dropdown', function(e) {
            $('.dropdown-submenu .show').removeClass("show");
        });


        return false;
    });
</script>
</body>
</html>
