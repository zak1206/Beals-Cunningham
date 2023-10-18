<?php
header_remove("X-Powered-By");
ini_set('session.cookie_httponly', 1);
ini_set('session.use_only_cookies', 1);
session_start();
include('siteFunctions.php');
$info = new site();
$url = $_SERVER['REQUEST_URI'];
$url = rtrim($url, '/');


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
    <link rel="icon" href="img/JRE-favicon.png" type="image/vnd.microsoft.icon">
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

    <base href="https://www.jamesriverequipment.com/" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $title; ?></title>
    <meta name="description" content="<?php echo $site_description; ?>">
    <?php echo $keywordsOut; ?>

    <link rel="preload" as="style" href="https://getbootstrap.com/docs/4.0/dist/css/bootstrap.min.css?v2" onload="this.onload=null;this.rel='stylesheet'">
    <!--<link rel="preload" as="style" href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" onload="this.onload=null;this.rel='stylesheet'">-->
    <link rel="preload" as="style" href="https://cdnjs.cloudflare.com/ajax/libs/ion-rangeslider/2.3.0/css/ion.rangeSlider.min.css" onload="this.onload=null;this.rel='stylesheet'">
    <link href="https://fonts.googleapis.com/css?family=Kaushan+Script&display=swap" rel="preload" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <link href="https://fonts.googleapis.com/css?family=Roboto+Slab" rel="preload" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.2/animate.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">


    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/72a6e36693.js" crossorigin="anonymous"></script>
    <!-- James River CSS -->

    <link href="css/jamesriver.css?v=0.1" rel="stylesheet">

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
    <!-- <link rel="stylesheet" href="css/styles.css"> -->


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
    <style>
        .megasubmenu {
            padding: 1rem;
        }

        /* ============ desktop view ============ 
        @media all and (min-width: 992px) {
            .dropdown-menu .dropdown-toggle::after {
                transform: rotate(270deg);
                display: none;
            }

            .nav-link:hover {
                color: #367C2B;
            }

            .dropdown-toggle:hover::after {
                color: #FFDE00;
                display: inline-block;
            }

            .megasubmenu {
                left: 100%;
                top: 0;
                min-height: 100%;
                min-width: 500px;
            }

            .dropdown-menu>li:hover .megasubmenu {
                display: block;
            }
        }*/

        /* ============ desktop view .end// ============ */
        /* Always set the map height explicitly to define the size of the div
             * element that contains the map. */
        #map {
            height: 500px;
            /* width 100%; */
        }

        .hamburger-inner:after {
            color: black !important
        }

        ;
    </style>

    <!-- Geometry GTM Tag for James River Equipment============== -->
    <!-- Google Tag Manager -->
    <script>
        (function(w, d, s, l, i) {
            w[l] = w[l] || [];
            w[l].push({
                'gtm.start': new Date().getTime(),
                event: 'gtm.js'
            });
            var f = d.getElementsByTagName(s)[0],
                j = d.createElement(s),
                dl = l != 'dataLayer' ? '&l=' + l : '';
            j.async = true;
            j.src =
                'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
            f.parentNode.insertBefore(j, f);
        })(window, document, 'script', 'dataLayer', 'GTM-KB7HLBX');
    </script>
    <!-- End Google Tag Manager -->


    <!-- BealsCunningham GTM code for JamesRiverEquipment.com=============== -->
    <!-- Google Tag Manager -->
    <script>
        (function(w, d, s, l, i) {
            w[l] = w[l] || [];
            w[l].push({
                'gtm.start': new Date().getTime(),
                event: 'gtm.js'
            });
            var f = d.getElementsByTagName(s)[0],
                j = d.createElement(s),
                dl = l != 'dataLayer' ? '&l=' + l : '';
            j.async = true;
            j.src =
                'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
            f.parentNode.insertBefore(j, f);
        })(window, document, 'script', 'dataLayer', 'GTM-NPLVF7Z');
    </script>
    <!-- End Google Tag Manager -->

</head>

<body>
    <!-- Geometry GTM Tag for James River Equipment============== -->
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-KB7HLBX" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->

    <!-- BealsCunningham GTM code for JamesRiverEquipment.com=============== -->
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-NPLVF7Z" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->

    <?php /*include('usedglobfiliter.php');*/ ?>
    <div id="main">
        <?php
        $savers = $info->getSaves();
        ?>

        <!--[if lt IE 8]>
      <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
      <![endif]-->

        <!-- Navigation -->
        <div class="container-fluid">
            <div class="row no-gutter">
                <div class="col-md-4 my-auto">
                    <a class="navbar-brand" href="https://www.jamesriverequipment.com/">
                        <img class="navbar-logo" src="img/JamesRiverLogo.png" alt="James River Logo" />
                    </a>
                </div>
                <div class="col-md-6 my-auto toggle-nav-desktop" align="right">
                    <div class="search-container" style="margin-top:10px; display: inline;">
                        <label class="text-grey wt-600" style="margin-right: 10px; font-size: 19px; font-family: Bebas Neue, cursive">FIND YOUR JAMES RIVER</label>
                        <input type="text" name="locationzip" type="text" id="locationzip" value="" placeholder="Zip Code" style="padding: 5px 4px 6px 28px; display: inline; border: 1px solid #e9ecee; margin-right: -4px; width: 120px;" />
                        <button data-cafftrak='zip-code' data-toggle="modal" data-target="#exampleModalzip" class="btn btn-blue-sm" type="submit" onclick="getMylatlong()" style="padding-top: 6px; padding-bottom: 6px; border-top-left-radius: 0px; border-bottom-left-radius: 0px; font-size: 16px;">SUBMIT</button>
                        <!-- Zip Code Modal -->
                        <div class="modal animated animate__fadeInDown" id="exampleModalzip" data-aos="flip-up" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="false" style="text-align: left; border-radius: 25px; z-index: 1041; max-width: 1400px; margin: 0 auto;">
                            <div class="modal-dialog" role="document" style="float: right; width: 400px; top:87px">
                                <div class="modal-content">
                                    <div class="modal-body">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                        <div id="location-finder" class="initiallyHidden">
                                            <ul id="locationLocatorDetail">
                                                <div id="location-detail"></div>
                                            </ul>
                                        </div>
                                        <p class="text-center"><a href="locations" class="btn btn-blue-sm">See All Locations</a></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-2 my-auto toggle-nav-desktop" align="right">
                    <a href="mailto:info@jamesriverequipment.com"><img class="nav-icon" src="img/nav-email.jpg" alt="Email Us" /></a>
                    <a href="mydealer"><button data-cafftrak='my-account' class="btn btn-blue-sm" target="_blank" style="border-radius: 0;">MY ACCOUNT</button></a>
                </div>
                <div class="col-md-6 my-auto toggle-nav-desktop d-none" align="right">
                    <!-- <div class="row my-auto toggle-nav-desktop"> 
                        <div class="col-md-12 my-auto" align="right" style="padding-right: 0;">-->

                    <div class="search-container" style="margin-top:10px; display: inline;">
                        <label class="text-grey wt-600" style="margin-right: 10px; font-size: 19px; font-family: Bebas Neue, cursive">FIND YOUR JAMES RIVER</label>
                        <input type="text" name="locationzip" type="text" id="locationzip" value="" placeholder="Zip Code" style="padding: 5px 4px 6px 28px; display: inline; border: 1px solid #e9ecee; margin-right: -4px; width: 120px;" />
                        <button id="zipcodeEntered" data-toggle="modal" data-target="#exampleModalzip" class="btn btn-blue-sm" type="submit" onclick="getMylatlong()" style="padding-top: 6px; padding-bottom: 6px; border-top-left-radius: 0px; border-bottom-left-radius: 0px; font-size: 16px;">SUBMIT</button>
                        <br class="desktop-toggle mobile-toggle" />
                        <!-- Zip Code Modal -->
                        <div class="modal animated animate__fadeInDown" id="exampleModalzip" data-aos="flip-up" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="false" style="text-align: left; border-radius: 25px; z-index: 1041; max-width: 1400px; margin: 0 auto;">
                            <div class="modal-dialog" role="document" style="float: right; width: 400px; top:87px">
                                <div class="modal-content">
                                    <div class="modal-body">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                        <div id="location-finder" class="initiallyHidden">
                                            <ul id="locationLocatorDetail">
                                                <div id="location-detail"></div>
                                            </ul>
                                        </div>
                                        <p class="text-center"><a href="locations" class="btn btn-blue-sm">See All Locations</a></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- </div> -->
                        <!-- <img class="nav-icon" src="img/nav-location.jpg" alt="Locate Us" /> -->
                        <!-- </div> -->
                        <!--<a href="mailto:info@jamesriverequipment.com"><img class="nav-icon" src="img/nav-email.jpg" alt="Email Us" /></a> -->
                        <a href="mydealer"><button class="btn btn-blue-sm" target="_blank" style="border-radius: 0;">MY ACCOUNT</button></a>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 toggle-nav-desktop">
                    <div class="row nav-background">
                        <div class="col-lg-9 col-md-9 my-auto">
                            <nav class="navbar navbar-expand-lg">
                                <div class="collapse navbar-collapse" id="navbarNav">{nav}main{/nav}</div>
                            </nav>
                        </div>
                        <div class="col-lg-3 col-md-3 my-auto toggle-nav-desktop" align="right">
                            <div class="input-group">
                                <!-- <input type="text" class="form-control search-inv-input" placeholder="Search" aria-label="Search" aria-describedby="search" style="background-color: lightgrey; border-radius: 0; padding-left:5px;"> -->
                                <form id="site-search" name="site-search" action="Search-Results" method="post">
                                    <div class="top-nav-static" style="display: inline-block;">
                                        <input class="form-control" style="background-color: lightgrey; border-radius: 0; padding-left:5px;" type="text" name="serterm" id="serterm" pattern=".{3,}" title="At least 3 characters" required autocomplete="off" placeholder="Search Site...">
                                    </div>
                                    <div class="input-group-append" style="display: inline-block;">
                                        <button data-cafftrak='searchesss' type="submit" style="border:none; background: none;"><span class="input-group-text" id="search" style="background-color: #005a9b; padding: -2px;">
                                                <i class="fas fa-search" style="color: white;"></i>
                                            </span></button>
                                    </div>
                                    <div style="clear: both;"></div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 toggle-nav-mobile">
                    <div class="row nav-background">
                        <div class="col-lg-12 col-md-12 my-auto">
                            <nav class="navbar navbar-expand-lg">
                                <button class="hamburger hamburger--spin-r collapsed" style="display: inline;" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                                    <span class="hamburger-box">
                                        <span class="hamburger-inner"></span>
                                    </span>
                                </button>
                                <div class="collapse navbar-collapse" id="navbarNav">{nav}main{/nav}
                                    <div class="input-group">
                                        <!-- <input type="text" class="form-control" placeholder="Search Inventory" aria-label="Search" aria-describedby="search" style="background-color: lightgrey; border-radius: 0; padding-left:5px;">
                                        <div class="input-group-append">
                                            <span class="input-group-text" id="search" style="background-color: #005a9b; padding: -2px;">
                                                <i class="fas fa-search" style="color: white;"></i>
                                            </span>
                                        </div> -->

                                        <form id="site-search" name="site-search" action="Search-Results" method="post">
                                            <div class="top-nav-static" style="display: inline-block;">
                                                <input class="form-control" style="background-color: lightgrey; border-radius: 0; padding-left:5px;" type="text" name="serterm" id="serterm" pattern=".{3,}" title="At least 3 characters" required autocomplete="off" placeholder="Search Site...">
                                            </div>
                                            <div class="input-group-append" style="display: inline-block;">
                                                <button type="submit" style="border:none; background: none;"><span class="input-group-text" id="search" style="background-color: #005a9b; padding: -2px;">
                                                        <i class="fas fa-search" style="color: white;"></i>
                                                    </span></button>
                                            </div>
                                            <div style="clear: both;"></div>
                                        </form>
                                    </div>
                                </div>

                            </nav>
                        </div>

                    </div>
                </div>

            </div>

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

                        $nc = strtok($nc, '?');
                        $chr_pos = strpos($_SERVER["REQUEST_URI"], $nc);
                        $final_chain = substr($_SERVER["REQUEST_URI"], 0, $chr_pos);
                        if ($p == $theCount) {
                            echo '<li class="breadcrumb-item" style="text-transform: capitalize">' . str_replace('_', ' ', $nc) . '</li>';
                        } else {
                            echo '<li class="breadcrumb-item" style="text-transform: capitalize"><a href="' . $final_chain . '' . $nc . '">' . str_replace('_', ' ', $nc) . '</a></li>';
                        }

                        $p++;
                    }
                    ?>
                </ol>
            </nav>
        <?php } ?>

        <?php include('mods/chameleon/tracker.php'); ?>