<?php

///GET SITE SETTINGS//
    $data = mysqli_connect("localhost","stellar_equip","BCss1957!@","admin_stellar");
    $data->set_charset("utf8");

    $a = $data->query("SELECT timezone, error_reporting FROM site_settings WHERE id = '1'")or die($data->error);
    $b = $a->fetch_array();

    if($b["timezone"] != ''){
        $setTime = $b["timezone"];
    }else{
        $setTime = 'America/Chicago';
    }

    date_default_timezone_set(''.$setTime.'');

    if($b["error_reporting"] != 'yes'){
        error_reporting(0);
    }else{
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
    }



    ?>