<?php
date_default_timezone_set('America/Chicago');
include('../../config.php');
$act = $_REQUEST["action"];

if($act == 'pullevent'){
    $a = $data->query("SELECT * FROM content_blocks WHERE id= '".$_REQUEST["id"]."'");
    $b = $a->fetch_array();

    $html .= '<h2>'.$b["title"].'</h2>';
    if($b["start_date"] != 0){
        $end = ' - '.date('m/d/y h:iA',$b["end_date"]);
    }else{
        $end = '';
    }
    $html .= '<small>Event Date: '.date('m/d/y h:iA',$b["start_date"]).''.$end.'</small><br><br>';
    $html .= str_replace('../','',$b["content"]);

    echo $html;

}