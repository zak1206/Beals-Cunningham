<?php
//GET CLIENTS PAGE VIEW//
$url = $_SERVER["REQUEST_URI"];
$sitePage = substr($url, strrpos($url, '/') + 1);



//GET CLIENTS IP//
$client  = @$_SERVER['HTTP_CLIENT_IP'];
$forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
$remote  = $_SERVER['REMOTE_ADDR'];

if(filter_var($client, FILTER_VALIDATE_IP))
{
    $ip = $client;
}
elseif(filter_var($forward, FILTER_VALIDATE_IP))
{
    $ip = $forward;
}
else
{
    $ip = $remote;
}

$usersIp = $ip;
$user_agent = $_SERVER['HTTP_USER_AGENT'];

function getOS() {

    global $user_agent;

    $os_platform  = "Unknown OS Platform";

    $os_array     = array(
        '/windows nt 10/i'      =>  'Windows 10',
        '/windows nt 6.3/i'     =>  'Windows 8.1',
        '/windows nt 6.2/i'     =>  'Windows 8',
        '/windows nt 6.1/i'     =>  'Windows 7',
        '/windows nt 6.0/i'     =>  'Windows Vista',
        '/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
        '/windows nt 5.1/i'     =>  'Windows XP',
        '/windows xp/i'         =>  'Windows XP',
        '/windows nt 5.0/i'     =>  'Windows 2000',
        '/windows me/i'         =>  'Windows ME',
        '/win98/i'              =>  'Windows 98',
        '/win95/i'              =>  'Windows 95',
        '/win16/i'              =>  'Windows 3.11',
        '/macintosh|mac os x/i' =>  'Mac OS X',
        '/mac_powerpc/i'        =>  'Mac OS 9',
        '/linux/i'              =>  'Linux',
        '/ubuntu/i'             =>  'Ubuntu',
        '/iphone/i'             =>  'iPhone',
        '/ipod/i'               =>  'iPod',
        '/ipad/i'               =>  'iPad',
        '/android/i'            =>  'Android',
        '/blackberry/i'         =>  'BlackBerry',
        '/webos/i'              =>  'Mobile'
    );

    foreach ($os_array as $regex => $value)
        if (preg_match($regex, $user_agent))
            $os_platform = $value;

    return $os_platform;
}

function getBrowser() {

    global $user_agent;

    $browser        = "Unknown Browser";

    $browser_array = array(
        '/msie/i'      => 'Internet Explorer',
        '/firefox/i'   => 'Firefox',
        '/safari/i'    => 'Safari',
        '/chrome/i'    => 'Chrome',
        '/edge/i'      => 'Edge',
        '/opera/i'     => 'Opera',
        '/netscape/i'  => 'Netscape',
        '/maxthon/i'   => 'Maxthon',
        '/konqueror/i' => 'Konqueror',
        '/mobile/i'    => 'Handheld Browser'
    );

    foreach ($browser_array as $regex => $value)
        if (preg_match($regex, $user_agent))
            $browser = $value;

    return $browser;
}





$user_os        = getOS();
$user_browser   = getBrowser();


//$device_details = "<strong>Browser: </strong>".$user_browser."<br /><strong>Operating System: </strong>".$user_os."";

///print_r($device_details);

///echo("<br /><br /><br />".$_SERVER['HTTP_USER_AGENT']."");
session_start();
if(isset($_SESSION["usersinfo"])){

    include('config.php');
    $a = $data->query("SELECT * FROM capture_visits WHERE user_ip = '$ip' AND page = '$sitePage' AND DATE(FROM_UNIXTIME(visit_date))=CURDATE()");
    if($a->num_rows == 0){
        $userData = json_decode($_SESSION["usersinfo"],true);

        $city = $userData["city"];
        $state = $userData["state"];
        $country = $userData["city"];
        $lat = $userData["lat"];
        $long = $userData["long"];

        $c = $data->query("SELECT * FROM capture_visits WHERE user_ip = '$ip'");
        if($c->num_rows == 0){
            $viewtyp = 'New';
        }else{
            $viewtyp = 'Old';
        }

        $readDate = date('m/d/Y',time());

        $data->query("INSERT INTO capture_visits SET user_ip = '$ip', browser = '".$data->real_escape_string($user_browser)."', platform = '".$data->real_escape_string($user_os)."', visit_date = '".time()."', page = '".$data->real_escape_string($sitePage)."', country = '".$data->real_escape_string($country)."', state = '".$data->real_escape_string($state)."', read_type = '$viewtyp', read_date = '$readDate'")or die($data->error);
    }

}else{
    // echo 'NOT SET';
    $xml = simplexml_load_file("http://www.geoplugin.net/xml.gp?ip=".$ip);
    $country = $xml->geoplugin_countryName ;

    foreach ($xml as $key => $val)
    {
        //echo $key , "= " , $value ,  " \n" ;

        if($key == 'geoplugin_city'){
            $city = $val;
        }

        if($key == 'geoplugin_regionName'){
            $state = $val;
        }

        if($key == 'geoplugin_countryName'){
            $country = $val;
        }

        if($key == 'geoplugin_latitude'){
            $lat = $val;
        }

        if($key == 'geoplugin_longitude'){
            $long = $val;
        }
    }
    $userDetails = array('ip'=>$ip, "browser"=>$user_browser, "os"=>$user_os, "city"=>$city, "state"=>$state, "country"=>$country, "lat"=>$lat, "long"=>$long);

    $_SESSION["usersinfo"] = json_encode($userDetails);
    include('config.php');
    $a = $data->query("SELECT * FROM capture_visits WHERE user_ip = '$ip' AND page = '$sitePage' AND DATE(FROM_UNIXTIME(visit_date))=CURDATE()");
    if($a->num_rows == 0){
        $c = $data->query("SELECT * FROM capture_visits WHERE user_ip = '$ip'");
        if($c->num_rows == 0){
            $viewtyp = 'New';
        }else{
            $viewtyp = 'Old';
        }

        $readDate = date('m/d/Y',time());
        $data->query("INSERT INTO capture_visits SET user_ip = '$ip', browser = '".$data->real_escape_string($user_browser)."', platform = '".$data->real_escape_string($user_os)."', visit_date = '".time()."', page = '".$data->real_escape_string($sitePage)."', country = '".$data->real_escape_string($country)."', state = '".$data->real_escape_string($state)."', read_type = '$viewtyp', read_date = '$readDate'");
    }
}

//echo $ip.' | '.$user_browser.' | '.$user_os.' | '.time().' | '.$sitePage.' | '.$city. ' | '.$state. ' | '.$country. ' | '.$lat. ' | '.$long;
