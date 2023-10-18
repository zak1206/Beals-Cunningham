<?php

session_start();
include('siteFunctions.php');
$info = new site();
$url = $_SERVER['REQUEST_URI'];


$page = substr($url, strrpos($url, '/') + 1);


//URL PAR PATCH///
$trueParems = explode('?',$page);
if($trueParems[0] != null){
    $page = $trueParems[0];
}else{
    $page = $page;
}
$url = explode('?',$url);
$url = $url[0];
$parameters = $url[1];
//$_SERVER['REQUEST_URI'] = $url;
if(isset($page) && $page != 'index.php' && $page != '' && $url != '/'){
    $page =  $page;
    //$page = substr($url, strrpos($page, '/') + 1);
}else{
    $page = 'Home';
}




 $pageDetails = $info->getpageDetails($page);

$dependants = json_decode($pageDetails[0]["dependants"],true);



if(!(empty($pageDetails))){
///OUTPUT THE PAGE DATA//
}else{
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
    if($pagename == 'index.php'){
        $pagename = 'Home';
    }else{
        $pagename = $page;
    }

    $title = $info->getPageTitle($pagename);
    $pageDesc = $info->getPageDesc($pagename);
    $cores = $info->coreItems();
    if($title != ''){
    $title = $title;
    }else{
    $title = $pagename;
    }

    if($pageDesc != ''){
    $site_description = $pageDesc;
    }else {
    if ($cores["site_description"] != '') {
    $site_description = $cores["site_description"];
    } else {
    $site_description = '';
    }
    }

    if($cores["site_keywords"] != '' && $pagename == 'Home'){
    $keywordsOut = '<meta name="keywords" content="'.$cores["site_keywords"].'">';
    }
    ?>

    <base href="http://legacy.bcssdevelop.com/" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $title; ?></title>
    <meta name="description" content="<?php echo $site_description; ?>">
    <?php echo $keywordsOut; ?>

    <link rel="preload" as="style" href="https://getbootstrap.com/docs/4.0/dist/css/bootstrap.min.css" onload="this.onload=null;this.rel='stylesheet'">
    <link rel="preload" as="style" href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" onload="this.onload=null;this.rel='stylesheet'">
    <link rel="preload" as="style" href="https://cdnjs.cloudflare.com/ajax/libs/ion-rangeslider/2.3.0/css/ion.rangeSlider.min.css" onload="this.onload=null;this.rel='stylesheet'">
    <link href="https://fonts.googleapis.com/css?family=Kaushan+Script&display=swap" rel="preload" as="style"onload="this.onload=null;this.rel='stylesheet'">
    <link href="https://fonts.googleapis.com/css?family=Roboto+Slab" rel="preload" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.2/animate.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">


    <?php
    ///CORE CAFFEINE ELEMENTS DO NOT REMOVE THIS///
    $dependenciescss = $info->loadBeanDepscss();
    for($i=0;$i<count($dependenciescss);$i++) {
        echo '<link rel="stylesheet" href="'.$dependenciescss[$i]["file"] .'">' . PHP_EOL;
    }
    ?>



    <?php
    $depCss = $dependants["css"];

    foreach($depCss as $cssKey){
        echo '<link rel="stylesheet" href="'.$cssKey.'">' . PHP_EOL ;
    }
    ?>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/custom.css">


    <?php
    ///HAD TO DO THIS BECAUSE SOME SERVERS HATE ME AND HAVE INSTALLED MOD_SECURITY ON THEIR APACHE///
    include('htmlshivrequest.php');
    ?>


    <?php
    ///CAFFEINE GOOGLE ANALYTICS OUTPUT FUNCTION DO NOT REMOVE///
    if($cores["google_analytics"] != ''){
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
<!--<div class="top-header-row row" style="background: #343A40;">
    <div class="col-md-4"> <a class="navbar-brand" href="#"><img style="max-width: 350px" src="img/blanchard_logo-og.png" alt="Blanchard Equipment Logo"></a></div>
    <div class="col-md-8"><div style="display:block;float:right"><a href="https://blanchardequipment.com/customer-portal-login"> <img src="../img/BE-Cust-Portal-2.png" alt="Blanchard Customer Portal Button" style="width: 45%;"></a><a href="https://blanchard.dealercustomerportal.com/Customers/Order-Parts"> <img src="../img/BE-Buy-Part-Now-3.png" style="width: 45%;" alt="Blanchard But Parts Now Button"></a><!--<a style="float: right; margin-top: 30px; font-size:20px" href="javascript:void()" id="cart"><i class="fa fa-shopping-cart"></i> Cart <span class="badge sav-nums"></span></a>--></div></div>
    <div class="col-md-12" style="float: right;">
        <p style="float:right; display: inline-block; border-left: 1px solid #fff; padding: 10px; color: #fff; line-height: 1px;"><a href="tel:877-626-3900"><i class="fas fa-phone fa-xs" style="color:#fff; margin-top: -24px;"></i></a></p>
        <p style="float:right; display: inline-block; border-left: 1px solid #fff; padding: 10px; color: #fff; line-height: 1px;"><a href="mailto:augusta@blanchardequipment.com,online@blanchardequipment.com"><i class="fas fa-envelope fa-xs" style="color:#fff; margin-top: -24px;"></i></a></p>
        <p style="float:right; display: inline-block; border-left: 1px solid #fff; padding: 10px; color: #fff; line-height: 5px;"><a href="locations" style="color:#ffffff;">Locations</a></p>
        <p style="float:right; display: inline-block; padding: 10px; color: #fff; line-height: 5px;"><a href="online-equipment-sales" style="color:#ffffff;">Online Equipment Sales</a><br></p>
    </div>
</div>-->
<nav class="navbar navbar-expand-lg navbar-light bg-dark">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        navmain/nav
    </div>
</nav>

<form id="site-search" name="site-search" action="Search-Results" method="post" style="display: none">
    <div class=""><input style="width: 100%;padding: 10px;background: #333;border: none;color: #a7a7a7;font-size: 30px;text-align: center; outline: none;" type="text" name="serterm" id="serterm" pattern=".{3,}" title="At least 3 characters" required autocomplete="off" placeholder="Search Site..."></div>
    <div style="clear: both;"></div>
</form>

<?php
    if($page == 'Home'){

    }else{
        $breakDown = $_SERVER["REQUEST_URI"];
        $url_without_last_part = substr($breakDown, 0, strrpos($breakDown, "/"));
        $breakDown = explode('/',$breakDown);
    ?>

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">

        <?php
            $theCount = count($breakDown);
            $p=1;
                foreach($breakDown as $nc){

                    $chr_pos=strpos($_SERVER["REQUEST_URI"],$nc);
                    $final_chain=substr($_SERVER["REQUEST_URI"],0,$chr_pos);
                    if($p==$theCount){
                        echo '<li class="breadcrumb-item">'.str_replace('_',' ',$nc).'</li>';
        }else{
        echo '<li class="breadcrumb-item"><a href="'.$final_chain.''.$nc.'">'.str_replace('_',' ',$nc).'</a></li>';
        }

        $p++;
        }
        ?>
    </ol>
</nav>
<?php } ?>

<?php include('mods/chameleon/tracker.php'); ?>
