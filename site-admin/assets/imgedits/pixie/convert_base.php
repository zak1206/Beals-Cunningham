<?php
error_reporting(0);
function generateImage($img,$dirs)

{
    if($dirs != null){
        $dirs = $dirs.'/';
    }else{
        $dirs = '';
    }

    $folderPath = "../../../../img/$dirs";



    $image_parts = explode(";base64,", $img);

    $image_type_aux = explode("image/", $image_parts[0]);

    $image_type = $image_type_aux[1];

    $image_base64 = base64_decode($image_parts[1]);

    $file = $folderPath . uniqid() . '.png';



    file_put_contents($file, $image_base64);

}

//var_dump($_POST);

$json_str = file_get_contents('php://input');

$dirs = str_replace('~','/',$_REQUEST["dirs"]);

generateImage($json_str,$dirs);

?>
