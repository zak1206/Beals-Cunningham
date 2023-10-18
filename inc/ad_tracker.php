<?php
///session_start();
//session_destroy();

if(isset($_SESSION["target_ads"])){
    //DO NOTHING IM NOT EVEN SURE WE NEED THIS DATA BUT WE WILL CAPTURE IT ANYWAY//
}else{
    //attempt to get the ip of the user//
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
}

//get full link of equipment//
$equipLink = $_SERVER["REQUEST_URI"];
//get last part of url which will contain the model of the equipment//
$equipBase = basename($equipLink);
//get current timestamp//
$date = time();

if(isset($_SESSION["target_ads"])){
    //unbind the session data and add new viewable object here//

    //convert back to workable php array//
    $session = json_decode($_SESSION["target_ads"],true);

    $ip = $session["ip"];
    $eqipinf = $session["equipinfo"];

    //function to go through array object for duplicates//
    function in_array_r_add($item , $array){
        return preg_match('/"'.preg_quote($item, '/').'"/i' , json_encode($array));
    }


    //check for dups//
    if(in_array_r_add($equipBase,$session)){
        ///DONT ADD A THING///
    }else{
        $eqipInfo[] = array("equiplink"=>$equipLink, "equipbase"=>$equipBase, "capture_date"=>$date);
    }

    //go through array and break apart//
    for($i=0; $i < count($eqipinf); $i++){
        if($i < 4){
            //add new item and remove old shit//

                $eqipInfo[] = array("equiplink"=>$eqipinf[$i]["equiplink"], "equipbase"=>$eqipinf[$i]["equipbase"], "capture_date"=>$eqipinf[$i]["capture_date"]);
        }
    }


    $eqipData = array("ip"=>$ip,"equipinfo"=>$eqipInfo);

    //encode to json string remove echo when done with development//
    echo $eqipData = json_encode($eqipData);

    //ready the session for the newness//
    unset ($_SESSION["target_ads"]);

    //create the sesson//
    $_SESSION["target_ads"] = $eqipData;
}else{
    //set the data for the first time//
    $eqipInfo[] = array("equiplink"=>$equipLink, "equipbase"=>$equipBase, "capture_date"=>$date);
    $eqipData = array("ip"=>$ip,"equipinfo"=>$eqipInfo);

    //encode to json string//
    $eqipData = json_encode($eqipData);

    //create the sesson//
    $_SESSION["target_ads"] = $eqipData;
}

?>