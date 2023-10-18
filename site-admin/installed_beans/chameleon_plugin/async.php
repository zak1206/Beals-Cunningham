<?php
include('functions.php');
$chamel = new chameleon();
$act = $_REQUEST["action"];

if($act == 'getslideform'){
    $return = $chamel->getSlideForm();

    echo $return;
}

if($act == 'processbuild'){
    $chamel->processBuild($_POST);
}

if($act == 'processbuildbox'){
    $chamel->processBuildBox($_POST);
}

if($act == 'getslidetab'){
    echo $chamel->getSlideTable();
}

if($act == 'getcamptab'){
    echo $chamel->getCampTable();
}

if($act == 'getboxform'){
    echo $chamel->getBoxForm();
}

if($act == 'startCampaign'){
    echo $chamel->startCampaign();
}

if($act == 'startcampaign'){
    echo $chamel->saveIntCamp($_POST);
}

if($act == 'deleteobject'){
    $onjid = $_REQUEST["onjid"];
    $chamel->deleteObject($onjid);
}

if($act == 'deletecampaign'){
    $onjid = $_REQUEST["onjid"];
    $chamel->deleteCampaign($onjid);
}