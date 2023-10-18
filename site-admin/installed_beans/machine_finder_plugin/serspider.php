<?php

include('config.php');
$results = array();
$a = $data->query("SELECT * FROM pages WHERE active = 'true'");

while($b = $a->fetch_array()){
    $content = file_get_contents('http://www.agrivisionequipment.com/'.$b["page_name"]);
    $str = preg_replace('#<header(.*?)>(.*?)</header>#is', '', $content);
    $str = preg_replace('#<script(.*?)>(.*?)</script>#is', '', $str);
    $str = preg_replace('#<footer(.*?)>(.*?)</footer>#is', '', $str);
    $str = preg_replace('#<ol(.*?)>(.*?)</ol>#is', '', $str);
    $str = strip_tags($str);
    $str = trim(preg_replace('/\s\s+/', ' ', $str));
    $str = str_replace('Quick View','',$str);
    if($b["iseqcat"] == 'true'){
        $equipLink = 'New-Equipment/';
    }else{
        $equipLink = '';
    }
    $results[] = array("title"=>$b["page_title"],"text"=>$str,"tags"=>'',"url"=>'http://www.agrivisionequipment.com/'.$equipLink.''.$b["page_name"].'');
}



$c = $data->query("SELECT * FROM used_equipment WHERE active = 'true'");

while($d = $c->fetch_array()){

    $urlOuts = $d["manufacture"].'-'.$d["model"].'-'.$d["id"];
    $title = $d["manufacture"].'-'.$d["model"];

    $content = file_get_contents('http://localhost/caffeine_4.0/Used-Equipment'.$urlOuts);
    $str = preg_replace('#<header(.*?)>(.*?)</header>#is', '', $content);
    $str = preg_replace('#<script(.*?)>(.*?)</script>#is', '', $str);
    $str = preg_replace('#<footer(.*?)>(.*?)</footer>#is', '', $str);
    $str = preg_replace('#<ol(.*?)>(.*?)</ol>#is', '', $str);
    $str = strip_tags($str);
    $str = trim(preg_replace('/\s\s+/', ' ', $str));
    $str = str_replace('Quick View','',$str);
    $str = str_replace('Options',' Options ',$str);
    $str = str_replace('Serial',' Serial',$str);
    $str = str_replace('Stock',' Stock',$str);
    $results[] = array("title"=>' '.$title,"text"=>' '.$str,"tags"=>'',"url"=>'http://www.agrivisionequipment.com/Used-Equipment/'.$urlOuts.'');
}

$spiderOut["pages"] = $results;
$out = json_encode($spiderOut);
$writeOut = $out;
$file = fopen("tipuesearch_content.js","w");
fwrite($file,$writeOut);
fclose($file);

?>