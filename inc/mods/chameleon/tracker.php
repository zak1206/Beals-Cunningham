<?php
session_start();
$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$lastPage = basename($actual_link);

$arss[] = $lastPage;

if(isset($_SESSION["page_track"])){
    //SESSION ALREADY STARTED//
    $preArs = json_decode($_SESSION["page_track"],true);
    $limits = 0;


    foreach($preArs as $dnkey){
        if($limits < 40) {
            $ars[] = $dnkey;
        }
        $limits++;
    }

    $ars = array_merge($ars,$arss);
    $ars = array_unique($ars);
    $_SESSION["page_track"] = json_encode($ars);

}else{
    ///START SESSION//
    $_SESSION["page_track"] = json_encode($arss);

}

$arss = array_unique($ars);


