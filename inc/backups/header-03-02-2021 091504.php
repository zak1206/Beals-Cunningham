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
    <!--<link rel="preload" as="style" href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" onload="this.onload=null;this.rel='stylesheet'">-->
    <link rel="preload" as="style" href="https://cdnjs.cloudflare.com/ajax/libs/ion-rangeslider/2.3.0/css/ion.rangeSlider.min.css" onload="this.onload=null;this.rel='stylesheet'">
    <link href="https://fonts.googleapis.com/css?family=Kaushan+Script&display=swap" rel="preload" as="style"onload="this.onload=null;this.rel='stylesheet'">
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

<!-- Navigation -->
<div class="container-fluid">
	<div class="top-header-row row">
      	<div class="col-md-12" style="display: inline-block; text-align: right;">
			<a class="navbar-brand" href="#" style="float: left; width: 300px;">
        		<img src="../img/logo.png" class="img-responsive" alt="Legacy Logo"/>
        	</a>
			<div style="display: none;"><br/><br/><br/><br/></div>
      		<div class="navbar-social" style="font-size: 32px; display: inline-block; margin-top: 14px;">
        		<a href="https://facebook.com/"><i class="fab fa-facebook-square"></i></a>
            	<a href="https://twitter.com/"><i class="fab fa-twitter-square"></i></a>
            	<a href="https://instagram.com/"><i class="fab fa-instagram-square"></i></a>
        	</div>
        	<a href="#" class="nav-link" style="display: inline-block;"><p style="">Careers</p></a>
        	<a href="#" class="nav-link" style="display: inline-block;"><p style="">Buy Parts Now</p></a>
        	<button class="btn btn-green" style="display: inline-block;">Customer Portal</button>
		</div>
	</div>
</div>
<nav class="navbar navbar-expand-lg" style="background-color: #367C2B;">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav" style="color: white; font-weight: bold;">
        {nav}main{/nav}
    </div>
</nav>

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
