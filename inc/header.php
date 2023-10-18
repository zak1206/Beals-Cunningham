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



    $title = $pageDetails[0]["page_title"];
    $pageDesc = $info->getPageDesc($pagename);

    $cores = $info->coreItems();
    if ($title != '') {
        $title = $pageDetails[0]["page_title"];
    } else {
        $title = $pagename;
    }


    if ($pageDesc != '') {
        $site_description = $pageDesc;
    } else {
        $site_description = $pageDetails[0]["page_desc"];
    }

    if ($cores["site_keywords"] != '' && $pagename == 'Home') {
        $keywordsOut = '<meta name="keywords" content="' . $cores["site_keywords"] . '">';
    }
    ?>

    <base href="http://rowtonengineering.com/stellar/" />
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
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.2/animate.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <link rel="stylesheet" type="text/css" href="./slick/slick.css">
    <link rel="stylesheet" type="text/css" href="./slick/slick-theme.css">
    <link href="css/bootstrap-datepicker.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">

    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />


    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/72a6e36693.js" crossorigin="anonymous"></script>
    <!-- Stellar CSS -->
    <link href="css/stellar.css" rel="stylesheet">

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
    <div id="main" style="background-color: white;">
        <?php
        $savers = $info->getSaves();
        ?>

        <!--[if lt IE 8]>
<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
<![endif]-->

        <!-- Navigation -->
        <div class="container-fluid p-0 navigation">
            <div class="row text-white my-auto" style="background-color: #367C2B;">
                <div class="col-md-12 my-auto desktop">
                    <div class="green-nav-container d-flex justify-content-end my-auto">
                        <i class="fas fa-phone-alt" style="font-size: 20px; margin-top: 4px;"></i>
                        <p class="proxima-nova light desktop" style="margin-top: 4px; font-size: 16px;"><a href="tel:1-800-555-5555"><i> 1-800-555-5555</i></a></p>
                        <a href="mailto:Info@StellarEquipment.com"><i class="fas fa-envelope" style="margin-left: 20px; font-size: 20px; margin-top: 4px;"></i>
                            <span class="proxima-nova light desktop" style="margin-top: 4px; font-size: 16px; display: inline;"><i> Info@StellarEquipment.com</i></span>
                        </a>

                        <!-- FIND A STORE START================================== -->
                        <p class="proxima-nova light desktop" data-toggle="modal" data-target="#exampleModalzip" type="submit" style="-webkit-appearance:none;"><i class="fas fa-map-marker-alt" style="margin-left: 20px; font-size: 20px; margin-top: 4px;"></i>
                            <span style="margin-top: 4px; font-size: 16px;"><i> Find a Store</i></span>
                        </p>
                        <div class="modal animated animate__fadeInDown" id="exampleModalzip" data-aos="flip-up" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="false" style="text-align: left; border-radius: 25px; z-index: 1041; max-width: 1400px; margin: 0 auto;">
                            <div class="modal-dialog" role="document" style="float: right; width: 240px; top:15px">
                                <div class="modal-content">
                                    <div class="modal-body" style="padding:10px 15px;">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="font-size: 18px;">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                        <div id="location-finder">
                                            <input type="text" name="locationzip" placeholder="Enter Zip Code" type="text" id="locationzip" value="" style="padding: 5px 5px 5px 10px; display: inline; border: 1px solid #e9ecee; margin-right: -4px;" />
                                            <button class="btn btn-green" type="submit" onclick="getMylatlong()" style="margin-top:10px; margin-left:0;">SUBMIT</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- FIND A STORE END================================== -->
                        <a class="desktop" href="https://www.facebook.com/bealscunningham" target="_blank" style="margin-left: 20px;"><i class="fab fa-facebook-f" style="font-size: 26px;"></i></a>
                        <a class="desktop" href="https://www.instagram.com/beals_cunningham/" target="_blank" style="margin-left: 6px;"><i class="fab fa-instagram" style="font-size: 26px;"></i></a>
                        <a class="desktop" href="https://twitter.com/bealscunningham" target="_blank" style="margin-left: 6px;"><i class="fab fa-twitter" style="font-size: 26px;"></i></a>
                        <a class="desktop" href="https://www.youtube.com/" target="_blank" style="margin-left: 6px; margin-right: 6%;"><i class="fab fa-youtube" style="font-size: 26px;"></i></a>
                    </div>
                </div>
                <div class="col-md-12 mobile" align="center">
                    <div class="row justify-content-center">
                        <div class="col-2" align="center">
                            <a href="tel:1-800-555-5555"><i class="fas fa-phone-alt" style="font-size: 26px;"></i></a>
                        </div>
                        <div class="col-2" align="center">
                            <a href="mailto:Info@StellarEquipment.com"><i class="fas fa-envelope" style="font-size: 26px;"></i></a>
                        </div>
                        <div class="col-2" align="center">
                            <a href="locations"><i class="fas fa-map-marker-alt" style="font-size: 26px;"></i></a>
                        </div>
                        <div class="col-2" align="center">
                            <a href="#" class="search-toggle" onclick="event.preventDefault();"><i class="fas fa-search" style="font-size: 26px;"></i></a>
                        </div>
                        <div class="col-2" align="center">
                            <a href="checkout"><i class="fas fa-shopping-cart" style="font-size: 26px;"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row main-nav">
                <div class="col-12 col-xl-2 my-auto">
                    <a class="navbar-brand" href="home">
                        <img class="navbar-logo img-responsive" src="img/Stellar-Logo-White.png" alt="Stellar Equipment Logo" style="max-width:235px;" />
                    </a>
                    <button class="hamburger hamburger--emphatic mobile" style="opacity: 1;float: right;
    padding-top: 30px;" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="hamburger-box">
                            <span class="hamburger-inner"></span>
                        </span>
                    </button>
                </div>
                <div class="col-sm-9 col-md-10 justify-content-end d-none d-xl-flex my-auto" style="color: white;">
                    <nav class="navbar navbar-expand-xl" style="padding: 0rem 1.25rem;">
                        <div class="collapse navbar-collapse desktop">{nav}main{/nav}
                            <!--cart start-->
                            <div class="cart-dropdown dropdown">
                                <div data-toggle="dropdown" style="background-color: transparent; border: none;">
                                    <img src="img/shopping-cart.png" style="width: 24px;"> <span class="cartcount badge badge-pill badge-dark" style="background-color: #367C2B; color: white;"><?php echo GetTotalCartCount(json_decode($_COOKIE['cartData'], true)); ?></span>
                                    <?php
                                    function GetTotalCartCount($cartData)
                                    {
                                        $count = 0;
                                        foreach ($cartData[0]['cartItems'] as $item) {
                                            $count = $count + $item['qty'];
                                        }

                                        return $count;
                                    }
                                    ?>
                                </div>
                                <div class="cart-dropdown-menu dropdown-menu pb-0" onload="UpdateCartHeader()" style="min-width: 400px;">
                                    <?php include('shopping_cart.php'); ?>
                                </div>
                            </div>
                            <!--cart end-->
                            <a href="#" class="search-toggle" onclick="event.preventDefault();"><img src="img/search.png" style="width: 24px;"></a>
                        </div>
                    </nav>
                </div>
                <div class="col-md-12 mobile">
                    <div class="collapse navbar-collapse" id="navbarNav" style="color: white;">
                        {nav}main{/nav}
                    </div>
                </div>
                <!-- search -->
                <form id="site-search" name="site-search" action="Search-Results" method="post" style="display: none; width: 100%;">
                    <div class="top-nav-static" style="width: 100%;">
                        <input style="width:100%; padding: 10px;background: #333;border: none;color: #a7a7a7;font-size: 30px;text-align: center; outline: none;" type="text" name="serterm" id="serterm" pattern=".{3,}" title="At least 3 characters" required autocomplete="off" placeholder="Search Site...">
                    </div>
                    <div style="clear: both;"></div>
                </form>
            </div>

        </div>

        <?php
        if ($page == 'Home') {
        } else {
            $breakDown = $_SERVER["REQUEST_URI"];
            $url_without_last_part = substr($breakDown, 0, strrpos($breakDown, "/"));
            $breakDown = explode('/', $breakDown);
        ?>

            <nav class="d-none" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <?php

                    $theCount = count($breakDown);
                    $p = 1;
                    foreach ($breakDown as $nc) {

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

        <script>
            function showCartDropdown() {
                var cart = document.querySelector(".cart-dropdown-menu");
                cart.classList.remove("invisible");
            }


            //Update Cart In Navigation
            function UpdateCartHeader() {
                $.ajax({
                    type: "POST",
                    url: "inc/mods/custom_equipment/cart/shopping_cart.php",
                    dataType: 'json',
                    success: function(obj) {
                        $(".cart-dropdown").html(obj.html);
                        $('.cartcount').val(obj.count);
                        location.reload();
                    }
                })
            }
            UpdateCartHeader();
        </script>