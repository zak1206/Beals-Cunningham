<?php
$url = "http://www.agrivisionequipment.com/".$_SERVER['REQUEST_URI'];

$serdat = mysqli_connect("localhost","searchadmin","BCss1957!@","site_search");

$a = $serdat->query("SELECT * FROM site_searh WHERE page_url = '$url'");

if($a->num_rows > 0) {
    $b = $a->fetch_array();
    $now = time(); // or your date as well
    $your_date = $b["last_spider"];
    $datediff = $now - $your_date;

    $days = round($datediff / (60 * 60 * 24));


    if ($days > 10) {
        $page = file_get_contents($url);
        preg_match("/<title>(.*)<\/title>/i", $homepage, $matches);

        $title = $matches[1];

        $str = preg_replace('#<header(.*?)>(.*?)</header>#is', '', $page);
        $str = preg_replace('#<script(.*?)>(.*?)</script>#is', '', $str);
        $str = preg_replace('#<footer(.*?)>(.*?)</footer>#is', '', $str);
        $str = preg_replace('#<ol(.*?)>(.*?)</ol>#is', '', $str);
        $str = strip_tags($str);
        $str = trim(preg_replace('/\s\s+/', ' ', $str));
        $str = str_replace('Quick View', '', $str);
        $serdat->query("UPDATE site_searh SET page_title = '".$serdat->real_escape_string($title)."', page_details = '".$serdat->real_escape_string($str)."', page_url = '".$serdat->real_escape_string($url)."', last_spider = '".time()."' WHERE id = '".$b["id"]."'");

    }
}else{
    $page = file_get_contents($url);
    preg_match("/<title>(.*)<\/title>/i", $homepage, $matches);

    $title = $matches[1];

    $str = preg_replace('#<header(.*?)>(.*?)</header>#is', '', $page);
    $str = preg_replace('#<script(.*?)>(.*?)</script>#is', '', $str);
    $str = preg_replace('#<footer(.*?)>(.*?)</footer>#is', '', $str);
    $str = preg_replace('#<ol(.*?)>(.*?)</ol>#is', '', $str);
    $str = strip_tags($str);
    $str = trim(preg_replace('/\s\s+/', ' ', $str));
    $str = str_replace('Quick View', '', $str);
    $serdat->query("INSERT INTO site_searh SET page_title = '".$serdat->real_escape_string($title)."', page_details = '".$serdat->real_escape_string($str)."', page_url = '".$serdat->real_escape_string($url)."', last_spider = '".time()."'");
}

