<?php

session_start();
include('siteFunctions.php');
$info = new site();
$url = $_SERVER['REQUEST_URI'];


$page = substr($url, strrpos($url, '/') + 1);


//URL PAR PATCH///
$trueParems = explode('?', $page);
if ($trueParems[0] != null) {
    $page = $trueParems[0];
} else {
    $page = $page;
}
$url = explode('?', $url);
$url = $url[0];
$parameters = $url[1];
//$_SERVER['REQUEST_URI'] = $url;
if (isset($page) && $page != 'index.php' && $page != '' && $url != '/') {
    $page =  $page;
    //$page = substr($url, strrpos($page, '/') + 1);
} else {
    $page = 'Home';
}




$pageDetails = $info->getpageDetails($page);

$dependants = json_decode($pageDetails[0]["dependants"], true);



if (!(empty($pageDetails))) {
    ///OUTPUT THE PAGE DATA//
} else {
    header('Location: Home');
    //include('404.html');
    exit();
    echo $_SERVER['REQUEST_URI'];
}

//echo "THis is ".$_REQUEST["parems"];


//echo $_SERVER['REQUEST_URI'];
///DO NOT REMOVE SITE TRACKER CODE BELOW - BECAUSE IT HELP THE DASHBOARD WORK ;)///
//include('site_tracker.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">

    <?php
    ///CORE CAFFEINE TITLE & SITE DESCRIPTION GRAB DO NOT REMOVE///
    $pagename = $pageDetails[0]["title"];
    if ($pagename == 'index.php') {
        $pagename = 'Home';
    } else {
        $pagename = $page;
    }

    $title = $info->getPageTitle($pagename);
    $pageDesc = $info->getPageDesc($pagename);
    $cores = $info->coreItems();
    if ($title != '') {
        $title = $title;
    } else {
        $title = $pagename;
    }

    if ($pageDesc != '') {
        $site_description = $pageDesc;
    } else {
        if ($cores["site_description"] != '') {
            $site_description = $cores["site_description"];
        } else {
            $site_description = '';
        }
    }

    if ($cores["site_keywords"] != '' && $pagename == 'Home') {
        $keywordsOut = '<meta name="keywords" content="' . $cores["site_keywords"] . '">';
    }
    ?>

    <base href="http://72.47.192.199/plesk-site-preview/legacyequipment.com/https/72.47.192.199/" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $title; ?></title>
    <meta name="description" content="<?php echo $site_description; ?>">
    <?php echo $keywordsOut; ?>

    <link rel="preload" as="style" href="https://getbootstrap.com/docs/4.0/dist/css/bootstrap.min.css" onload="this.onload=null;this.rel='stylesheet'">
    <!--<link rel="preload" as="style" href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" onload="this.onload=null;this.rel='stylesheet'">-->
    <link rel="preload" as="style" href="https://cdnjs.cloudflare.com/ajax/libs/ion-rangeslider/2.3.0/css/ion.rangeSlider.min.css" onload="this.onload=null;this.rel='stylesheet'">
    <link href="https://fonts.googleapis.com/css?family=Kaushan+Script&display=swap" rel="preload" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <link href="https://fonts.googleapis.com/css?family=Roboto+Slab" rel="preload" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.2/animate.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">

    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/72a6e36693.js" crossorigin="anonymous"></script>
    <!-- Legacy CSS -->
    <link href="css/legacy.css" rel="stylesheet">

    <?php
    ///CORE CAFFEINE ELEMENTS DO NOT REMOVE THIS///
    $dependenciescss = $info->loadBeanDepscss();
    for ($i = 0; $i < count($dependenciescss); $i++) {
        echo '<link rel="stylesheet" href="' . $dependenciescss[$i]["file"] . '">' . PHP_EOL;
    }
    ?>



    <?php
    $depCss = $dependants["css"];

    foreach ($depCss as $cssKey) {
        echo '<link rel="stylesheet" href="' . $cssKey . '">' . PHP_EOL;
    }
    ?>
    <link rel="stylesheet" href="css/styles.css">


    <?php
    ///HAD TO DO THIS BECAUSE SOME SERVERS HATE ME AND HAVE INSTALLED MOD_SECURITY ON THEIR APACHE///
    include('htmlshivrequest.php');
    ?>


    <?php
    ///CAFFEINE GOOGLE ANALYTICS OUTPUT FUNCTION DO NOT REMOVE///
    if ($cores["google_analytics"] != '') {
        echo $cores["google_analytics"];
    }
    ?>
</head>

<body>

    <?php
    $savers = $info->getSaves();
    ?>

    <!--[if lt IE 8]>
<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
<![endif]-->

    <!-- Navigation -->
    <div class="container-fluid p-0 navigation-container">
        <div class="row">
            <div class="col-md-12 col-lg-4">
                <a class="navbar-brand" href="Home">
                    <img src="img/logo.png" class="img-responsive" alt="Legacy Logo" />
                </a>
            </div>
            <div class="col-md-12 col-lg-8 toggle-desktop" align="right">
                <div class="navbar-links-container">
                    <div class="navbar-social">
                        <a href="https://www.facebook.com/LegacyEquipment/" target="_blank"><i class="fab fa-facebook-square"></i></a>
                        <a href="https://twitter.com/legacyequipment" target="_blank"><i class="fab fa-twitter-square"></i></a>
                        <a href="https://instagram.com/legacyequipment?igshid=1xr140xig71l" target="_blank"><i class="fab fa-instagram-square"></i></a>
                    </div>
                    <div class="navbar-links">
                        <a href="Careers" class="nav-link" style="color: black;">
                            <p><b>Careers</b></p>
                        </a>
                        <a href="Parts" class="nav-link" style="color: black;">
                            <p><b>Buy Parts Now</b></p>
                        </a>
                        <a href="https://legacyequipment.dealercustomerportal.com/">
                            <button class="btn btn-green" style="margin-top: -16px; margin-bottom: -10px;">
                                <svg version="1.0" xmlns="http://www.w3.org/2000/svg" width="11.000000pt" height="18.000000pt" viewBox="0 0 21.000000 35.000000" preserveAspectRatio="xMidYMid meet" style="margin-top: -6px; margin-bottom: -4px;">
                                    <g transform="translate(0.000000,35.000000) scale(0.100000,-0.100000)" fill="white" stroke="none">
                                        <path d="M10 141 l0 -141 100 0 100 0 0 30 0 30 -65 0 -64 0 -3 108 -3 107 -32 3 -33 3 0 -140z" />
                                        <path d="M122 213 c3 -25 7 -28 43 -28 36 0 40 3 43 28 3 26 2 27 -43 27 -45 0 -46 -1 -43 -27z" />
                                        <path d="M127 154 c-4 -4 -7 -18 -7 -31 0 -21 4 -23 46 -23 44 0 45 1 42 28 -3 23 -8 27 -38 30 -20 2 -39 0 -43 -4z" />
                                    </g>
                                </svg> Customer Portal
                            </button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <nav class="navbar navbar-expand-lg">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <!--<span class="navbar-toggler-icon" style="display: none;"></span>-->
                <span></span>
                <span></span>
                <span></span>
                <span></span>
            </button>
            <div class="navbar-social toggle-mobile">
                <a href="https://www.facebook.com/LegacyEquipment/"><i class="fab fa-facebook-square"></i></a>
                <a href="https://twitter.com/legacyequipment"><i class="fab fa-twitter-square"></i></a>
                <a href="https://instagram.com/legacyequipment?igshid=1xr140xig71l"><i class="fab fa-instagram-square"></i></a>
            </div>
            <div class="collapse navbar-collapse" id="navbarNav" style="color: white; font-weight: bold;">
                {nav}main{/nav}
            </div>
        </nav>
    </div>

    <?php
    if ($page == 'Home') {
    } else {
        $breakDown = $_SERVER["REQUEST_URI"];
        $url_without_last_part = substr($breakDown, 0, strrpos($breakDown, "/"));
        $breakDown = explode('/', $breakDown);
    ?>

        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">

                <?php
                $theCount = count($breakDown);
                $p = 1;
                foreach ($breakDown as $nc) {

                    $chr_pos = strpos($_SERVER["REQUEST_URI"], $nc);
                    $final_chain = substr($_SERVER["REQUEST_URI"], 0, $chr_pos);
                    if ($p == $theCount) {
                        echo '<li class="breadcrumb-item">' . str_replace('_', ' ', $nc) . '</li>';
                    } else {
                        echo '<li class="breadcrumb-item"><a href="' . $final_chain . '' . $nc . '">' . str_replace('_', ' ', $nc) . '</a></li>';
                    }

                    $p++;
                }
                ?>
            </ol>
        </nav>
    <?php } ?>

    <?php include('mods/chameleon/tracker.php'); ?>

    <script>
        /**
         * forEach implementation for Objects/NodeLists/Arrays, automatic type loops and context options
         *
         * @private
         * @author Todd Motto
         * @link https://github.com/toddmotto/foreach
         * @param {Array|Object|NodeList} collection - Collection of items to iterate, could be an Array, Object or NodeList
         * @callback requestCallback      callback   - Callback function for each iteration.
         * @param {Array|Object|NodeList} scope=null - Object/NodeList/Array that forEach is iterating over, to use as the this value when executing callback.
         * @returns {}
         */
        var forEach = function(t, o, r) {
            if ("[object Object]" === Object.prototype.toString.call(t))
                for (var c in t) Object.prototype.hasOwnProperty.call(t, c) && o.call(r, t[c], c, t);
            else
                for (var e = 0, l = t.length; l > e; e++) o.call(r, t[e], e, t)
        };

        var hamburgers = document.querySelectorAll(".navbar-toggler");
        if (hamburgers.length > 0) {
            forEach(hamburgers, function(hamburger) {
                hamburger.addEventListener("click", function() {
                    this.classList.toggle("is-active");
                }, false);
            });
        }
    </script>