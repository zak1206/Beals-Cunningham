<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
if (file_exists('../../inc/harness.php')) {
    include('../../inc/harness.php');
} else {
    include('inc/harness.php');
}

$nb = $data->query("SELECT settings FROM beans WHERE bean_id = 'MF-v3'");
$df = $nb->fetch_array();

//var_dump($df);

$creddata = json_decode($df["settings"], true);


$url = 'https://www.machinefinder.com/dealer_families/1500/machine_feed.xml';
$key = 'db470a30-11ca-0137-82c7-005056874696';
$password = 'password';

$dataset = array('key' => $key, 'password' => $password);

// use key 'http' even if you send the request to https://...
$options = array(
    'http' => array(
        'header' => "Content-type: application/x-www-form-urlencoded\r\n",
        'method' => 'POST',
        'content' => http_build_query($dataset),
    ),
);


$context = stream_context_create($options);
$result = file_get_contents($url, false, $context);
if ($result == false) {
    return 'CONNECT ERROR';
    die();
}
$result = new SimpleXmlElement($result);



$xml = json_encode($result);
$xml = json_decode($xml, true);

$machines = $xml["machine"];
echo '<pre>';
var_dump($machines);
echo '</pre>';

die();
