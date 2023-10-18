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
    <link rel="icon" href="../img/VP-Tab-Icon.ico" type="image/vnd.microsoft.icon">
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

    <base href="http://valleyplains.bcssdevelop.com/" />
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
    <!-- Valley Plains CSS -->
    <link href="css/valleyplains.css" rel="stylesheet">

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
    <style>
        .megasubmenu {
            padding: 1rem;
        }

        /* ============ desktop view ============ */
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
        }

        /* ============ desktop view .end// ============ */
        /* Always set the map height explicitly to define the size of the div
             * element that contains the map. */
        #map {
            height: 500px;
            /* width 100%; */
        }
    </style>
</head>

<body>

    <?php include('usedglobfiliter.php'); ?>
    <div id="main">
        <?php
        $savers = $info->getSaves();
        ?>

        <!--[if lt IE 8]>
<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
<![endif]-->

        <!-- Navigation -->
        <div class="container-fluid p-0 navigation-container">
            <div class="row no-gutter">
                <div class="col-sm-6 col-md-4 col-lg-3 my-auto">
                    <a class="navbar-brand homepage-logo-link" href="http://valleyplains.bcssdevelop.com/">
                        <img src="img/Homepage/header-logo.png" class="img-responsive homepage-logo" alt="Valley Plains Logo" />
                    </a>
                </div>
                <div class="col-sm-6 col-md-8 col-lg-9 toggle-desktop" align="right" style="padding:0;">
                    <div class="row" style="height: 100%;">
                        <div class="col-lg-2 col-md-1"></div>
                        <div class="col-lg-6 col-md-6 my-auto">
                            <div class="search-container">
                                <label style="margin-right: 8px; font-size: 18px; font-weight: 200;">FIND YOUR VALLEY PLAINS LOCATION</label>
                                <br class="location-finder-breaker">
                                <input type="text" name="locationzip" id="locationzip" value="" placeholder="Zip Code" class="location-input-field">
                                <button data-toggle="modal" data-target="#exampleModalzip" class="btn btn-blue zip-code-submit-btn" type="submit" onclick="getMylatlong()"><span style="font-size: 18px;">SUBMIT</span></button>
                                <br class="desktop-toggle mobile-toggle">
                                <!-- Zip Code Modal -->
                                <div class="modal animated animate__fadeInDown" id="exampleModalzip" data-aos="flip-up" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="false" style="text-align: left; border-radius: 25px; z-index: 1041;">
                                    <div class="modal-dialog" role="document">
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
                                                <p class="text-center"><a href="locations" class="btn btn-blue">See All Locations</a></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-5" style="padding: 0; margin: 0; height: 100%;">
                            <div class="row" style="width: 100%; height: 100%;">
                                <div class="col-md-6" style="padding:0;">
                                    <a href="locations"><img src="../img/Homepage/footer-map.png" class="img-responsive" alt="Valley Plains Locations" style="height: 100%;"></a>
                                </div>
                                <div class="col-md-6" style="background-color: #387D3C">
                                    <div style="margin-top: 40px;">
                                        <div class="row" style="text-align:center; margin: auto;">
                                            <div class="col-md-12">
                                                <img src="../img/Homepage/header-vpe-login (1).png" alt="VPE Access" class="img-responsive" style="max-width:110px;">
                                            </div>
                                            <div class="col-md-12">
                                                <a href="https://vp-access.com/" target="_blank" class="btn btn-light-green homepage-login-btn">
                                                    LOG IN
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-none d-xs-none d-sm-none d-md-none d-lg-block d-xl-block col-sm-12 col-md-12 col-lg-12 my-auto" style="background-color: white; margin:0; padding:0;">
                <nav class="navbar navbar-expand-lg">
                    <div class="collapse navbar-collapse" id="navbarNav">{nav}main{/nav}</div>
                    <div class="social-icons-div" style="float:right; margin-right: 20px;">
                        <div class="social-icons"><a href="https://www.facebook.com/valleyplainsequipment" target="_blank" class="social-media-icon-link">
                                <img src="../img/Homepage/Facebook.png" alt="Facebook"></a>
                            <a href="https://twitter.com/valleyplains" target="_blank" class="social-media-icon-link">

                                <img src="../img/Homepage/Twitter.png" alt="Twitter">
                            </a>
                            <a href="https://www.youtube.com/user/JamestownImp/featured" target="_blank" class="social-media-icon-link">

                                <img src="../img/Homepage/Youtube.png" alt="Youtube">
                            </a>
                            <a href="https://www.instagram.com/valley_plains_equipment/" target="_blank" class="social-media-icon-link">
                                <img src="../img/Homepage/Instagram.png" alt="Instagram">
                            </a>
                        </div>
                    </div>
                </nav>

            </div>
            <div class="d-block d-xs-block d-sm-block d-md-block d-lg-none d-xl-none col-sm-12 col-md-12 col-lg-12 my-auto" style="background-color: #71ba71;">
                <nav class="navbar navbar-expand-lg" style="padding: 0rem 1.25rem;">
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="d-none"></span>
                        <span class="d-none"></span>
                        <span class="d-none"></span>
                        <div class="menu-btn" style="float: right;">
                            <div class="menu-btn__burger"></div>
                        </div>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">{nav}MobileNav{/nav}</div>
                </nav>
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