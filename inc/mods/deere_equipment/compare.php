<?php
//error_reporting(0);

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$eqname = $_REQUEST["eqname"];

include('../../../inc/config.php');
$a = $data->query("SELECT equip_link FROM deere_equipment WHERE title = '$eqname'")or die($data->error);
$b = $a->fetch_array();

$specFrag = str_replace('index.json','',$b["equip_link"]).'fragment-specifications.json';


$arrContextOptions = array(
    "ssl" => array(
        "verify_peer" => false,
        "verify_peer_name" => false,
    ),
);

$theCompare = file_get_contents($specFrag, false, stream_context_create($arrContextOptions));


$decoder = json_decode($theCompare, true);


$decoder = $decoder["Page"]["specifications"]["RelatedModels"][$_REQUEST["equipid"]];


        $obj[] = '<strong>'.$decoder["Name"].'</strong><br><a class="remove-col" style="font-weight: 300; cursor: pointer" data-value="'.$_REQUEST["equipid"].'">Select a Different Model <span class="x"><i class="fa fa-times-circle"></i></span></a>';
        $comprsLine = $decoder["Specifications"];

        $k = 0;
        for ($j = 0; $j < count($comprsLine); $j++) {

            $obj[] = $comprsLine[$j]["Description"];

            foreach ($obj as $key => $value) {
                if (is_null($value) || $value == '') {

                    $obj[$key] = "";
                }
            }
            $k = 0;
        }


echo json_encode($obj);


