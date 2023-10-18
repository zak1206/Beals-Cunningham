<?php


error_reporting(0);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include('../../inc/harness.php');
$a = $data->query("SELECT * FROM beans WHERE bean_name = 'Machine Finder Feed'");
$b = $a->fetch_array();
$creds = json_decode($b["settings"],true);


$url = $creds["url"];
$dataset = array('key' => $creds["key"], 'password' => $creds["pass"]);

// use key 'http' even if you send the request to https://...
$options = array(
    'http' => array(
        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
        'method'  => 'POST',
        'content' => http_build_query($dataset),
    ),
);
$context  = stream_context_create($options);
$result = file_get_contents($url, false, $context);
$result = new SimpleXmlElement($result);

$xml = json_encode($result);
$xml = json_decode($xml,true);
$machines = $xml["machine"];

for ($x = 0; $x <= count($machines); $x++) {
    if(in_array("land_area", $machines[$x]['meters']["meter"])) {
        if(is_array($machines[$x]['meters']["meter"]["value"])){

        }else{
            $stockNum = $machines[$x]["stockNumber"];
            $acres = $machines[$x]['meters']["meter"]["value"];

            $full .= $stockNum.' - '.$acres;

            $data->query("UPDATE used_equipment SET acres = '$acres' WHERE stockNumber = '$stockNum'");
        }

    }else {
        //$acres .= '';
    }
}

echo $full;




//echo '<pre>';
//var_dump($machines);
//echo '</pre>';
//die();
