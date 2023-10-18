<?php
include "config.php";
$c = $data->query("SELECT * FROM sliders WHERE id= '1'");
$d = $c->fetch_assoc();

$orderjson = json_decode($d["order_json"], true);

echo '<pre>';
var_dump($orderjson);
echo '</pre>';

foreach($orderjson as $item) {
    $a = $data->query("SELECT * FROM slides WHERE active = 'true' AND id = '".$item."'");
    $b = $a->fetch_array();
     $listitemsord .= '<li id="item-'.$b["id"].'" class="ui-state-default" data-id="'.$b["id"].'" data-slideid="'.$b["slider_id"].'">
                                <div class="row">
                                    <div class="col-md-4"><span style="float:left;"class="ui-icon ui-icon-arrowthick-2-n-s"></span><img class="thumbnail" src="'.$response[$i]["img"].'" alt="#" class="img-responsive" /></div>
                                    <div class="col-md-8 slide-info">
                                    <div class="row">
                                        <div class="col-md-6"> <h6 class="slide-name">'.$b["slide_name"].'</h6></div>
                                        <div class="col-md-6">  <a onclick="editIndSlider(\''.$b["id"].'\')" class="btn btn-sml btn-default"><i class="fa fa-edit"></i></a> <a  onclick="confirmDel(\''.$response[$i]["id"].'\')" class="btn btn-sml btn-default"><i class="fa fa-trash"></i></a></div>
                                    </div>
                                  
                                    </div>
                                </div>
                             </li>';
}

return $listitemsord;

