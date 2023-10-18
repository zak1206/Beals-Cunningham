<?php
$serWord = $_POST["serterm"];

include('inc/config.php');



$output .= '<ul class="list">';


//include('inc/config.php');


$a = $data->query("SELECT * FROM search_table")or die($data->error);

while($b = $a->fetch_array()){

    $text = substr($b["page_content"], 0, 150).'...';
    $text = ltrim($text);

    $dataSet[] = array("text"=>$text,"title"=>$b["page_title"],"url"=>$_SERVER['SERVER_NAME'].$b["url"],"pagename"=>$b["pagename"]);
}

$dataSet["pages"] = $dataSet;


function findwords($words, $search) {
    $words_array = explode(" ", trim($words));
    //$word_length = count($words_array);

    $search_array = explode(" ", $search);
    $search_length = count($search_array);

    $mix_array = array_intersect($words_array, $search_array);
    $mix_length = count($mix_array);

    if ($mix_length == $search_length) {
        return true;
    } else {
        return false;
    }
}


$trueSearch = $serWord;

$serWord = explode(' ',$serWord);

foreach($serWord as $serWord){

    for($i=0; $i <= count($dataSet["pages"]); $i++){
        //stripos

        if(strpos(strtolower($dataSet["pages"][$i]["text"]), strtolower($serWord) ) !== false) {

            if(strlen($dataSet["pages"][$i]["text"]) > 250){
                $theText = substr($dataSet["pages"][$i]["text"], 0, 250).'...';
            }else{
                $theText = $dataSet["pages"][$i]["text"];
            }

            $textOut =  preg_replace("/\w*?$serWord\w*/i", "<b>$0</b>", $theText);
            $textOut = str_replace(' Back To Used Equipment','',$textOut);
            $textOut = str_replace('caffeine 4.0','',$textOut);
            $textOut = str_replace('Modal title ...','',$textOut);
            $textOut = str_replace('Back To Used Equipment','',$textOut);
            $textOut = str_replace('×  Close','',$textOut);
            $url = str_replace('http://localhost/','http://bcssdevelopment.com/',$dataSet["pages"][$i]["url"]);


            $output .= '<li style="padding: 10px; margin: 2px;"><p class="name"><a style="font-size: 20px; color:#333; text-decoration: none" href="'.$url.'">'.$dataSet["pages"][$i]["title"].'</a><br><a href="'.$url.'">'.$dataSet["pages"][$i]["url"].'</a> <br><small>'.$textOut.'</small></p></li>';
            $countRez[] = array('1');
        }
    }

}

$output .= '</ul>';

$output .= '<ul class="pagination"></ul><hr>';

$c = $data->query("SELECT * FROM deere_equipment WHERE title LIKE '%$serWord%' OR sub_title LIKE '%$serWord%' OR  parent_cat LIKE '%$serWord%' OR cat_one LIKE '%$serWord%'")or die($data->error);

$output .= '<h2>New Equipment Results</h2>';
$output .= '<span style="font-style:italic">'.$c->num_rows. ' results returned.</span>';
$output .= '<div class="container"><div class="row"><ul class="new-list">';


while($d = $c->fetch_array()) {



    $imgdecode = json_decode($d["eq_image"]);
    if(count($imgdecode) > 0) {
        $schemaimg = 'img/equip_images/' . $imgdecode[0];
    } else {

        $imgpath = trim($d["eq_image"], '"');
        $imggallery = '<img src="img/equip_images/'.$imgpath.'" class="img-responsive"/>';
        $schemaimg = 'img/equip_images/'.$imgdecode[0];
    }
    $output .= '<li class="new-items"><div class="row"><div class="col-md-3"><img src="'.$schemaimg.'" class="img-responsive"/></div><div class="col-md-6"><h3>'.$d["title"].'</h3>'.$d["bullet_points"].'</div><div class="col-md-3"><a class="btn btn-success text-center" href="'.$d["title"].'">See Details</a></div></div></li>';


}
$output .= '</ul><input name="searchval" id="searchval" type="hidden" value="'.$trueSearch.'"/></div></div><hr>';

$output .= '<h2>Used Equipment Results</h2>';

if($output != null){
    echo '<h1>Search Results For: '.$trueSearch.'</h1>';
    echo '<span style="font-style:italic">'.count($countRez). ' results returned.</span>';
;    echo $output;
}else{
    echo '<div>No Search Results For <strong>'.$serWord.'</strong> Could Be Found...</div>';
}

?>