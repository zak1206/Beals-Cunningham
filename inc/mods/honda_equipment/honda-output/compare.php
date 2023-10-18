<?php
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);
//$act = $_REQUEST["action"];
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

///echo 'this is'.$_REQUEST["value"];



function getColumnCompare($passid, $equipid)
{
//    echo 'this is'.$equipid;
    include ("../../../config.php");
    $a = $data->query("SELECT specs from deere_equipment WHERE id = '$equipid'")or die($data->error);
    $b = $a->fetch_array();
    $jsonCompare = $b["specs"];

    $decoder = json_decode($jsonCompare, true);
//    echo '<pre>';
//    var_dump($decoder);
//    echo '</pre>';

    $decoder = $decoder["Page"]["specifications"]["RelatedModels"];

    for ($i = 0; $i < count($decoder); $i++) {
        $id = $decoder[$i]["ID"];

        if ($passid == $id) {
            $obj[] = '<strong>'.$decoder[$i]["Name"].'</strong><br><a class="remove-col" style="font-weight: 300" data-value="'.$decoder[$i]["ID"].'">Select a Different Model <span class="x"><i class="fa fa-times-circle"></i></span></a>';
            $comprsLine = $decoder[$i]["Specifications"];


            for ($j = 0; $j < count($comprsLine); $j++) {

                $obj[] = $comprsLine[$j]["Description"];

                foreach ($obj as $key => $value) {
                    if (is_null($value) || $value == '') {
                        $obj[$key] = "";
                    }
                }

            }
        }
    }

    return json_encode($obj);





}

echo getColumnCompare($_REQUEST['value'], $_REQUEST['equipid']);


?>