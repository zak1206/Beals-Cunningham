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
if(!(empty($pageDetails))){
///OUTPUT THE PAGE DATA//
}else{
header('HTTP/1.0 404 Not Found');
include('404.html');
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
    $pagename = $page;
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

    <base href="http://192.168.100.53/Caff5.0/" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $title; ?></title>
    <meta name="description" content="<?php echo $site_description; ?>">
    <?php echo $keywordsOut; ?>

    <link rel="stylesheet" href="https://getbootstrap.com/docs/4.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.6/css/all.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ion-rangeslider/2.3.0/css/ion.rangeSlider.min.css"/>
    <!--<link rel="stylesheet" href="css/lightslider.css">
    <link rel="stylesheet" href="css/jquery.flipster.css">
    <link rel="stylesheet" href="css/jquery.paginate.css">-->
    <link href="https://fonts.googleapis.com/css?family=Kaushan+Script&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto+Slab" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/Glide.js/3.0.1/css/glide.core.css">
    <?php
    ///CORE CAFFEINE ELEMENTS DO NOT REMOVE THIS///
    $dependenciescss = $info->loadBeanDepscss();
    for($i=0;$i<count($dependenciescss);$i++) {
    echo '<link rel="stylesheet" href="'.$dependenciescss[$i]["file"] .'">' . PHP_EOL ;
    }
    ?>
	<link rel="stylesheet" href="css/styles.css">


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

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#"><img style="max-width: 200px" src="img/caffeine_logo.png"></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
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
