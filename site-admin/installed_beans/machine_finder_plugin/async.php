<?php
include('functions.php');
$used = new machinefinderui();
$act = $_REQUEST["action"];



if($act == 'setorder'){
   $used->setorder($_POST["sortorder"]);
}

if($act == 'updateform'){
    $used->updateFormToken($_POST["formtoken"]);
}

if($act == 'getfetpan'){
    $used->getFeatureCats();
}

if($act == 'doworkfet'){
    $used->doWorkSet($_REQUEST["equipid"],$_REQUEST["isset"]);
}

if($act == 'getcatsnow'){
    $used->getCat($_REQUEST["cat"]);
}

if($act == 'updatecreds'){
   echo $used->credUpdateForm();
}

if($act == 'updatecredsfin'){
    $used->finishCredUpdate($_POST);
}

if($act == 'setupmf'){
    $process = $used->setupMachines($_POST);

    if($process == 'good'){
        echo 'good';
    }else{
        echo '<strong>WHOOPS!</strong> - There was a connection error. <br>Please check to make sure your API details are correct.';
    }
}

if($act == 'rerun'){
    $used->updateMacs();

    echo 'Finished Updating Equipment';
}

if($act == 'usage'){
    echo $used->getUsage();
}
?>