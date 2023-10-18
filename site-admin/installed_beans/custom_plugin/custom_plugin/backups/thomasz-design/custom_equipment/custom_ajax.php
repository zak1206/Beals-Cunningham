<?php
$act = $_REQUEST["action"];
///V1.0///
if($act == 'quickview'){

    include('../../config.php');

    $prodId = $_REQUEST['equipid'];
    $equiptype = $_REQUEST["equiptype"];
    if($prodId != null){
        if($equiptype == 'deere') {
            $a = $data->query("SELECT * FROM deere_equipment WHERE id = '$prodId'");
        }
        if($equiptype == 'honda') {
            $a = $data->query("SELECT * FROM honda_equipment WHERE id = '$prodId'");
        }

        if($equiptype == 'stihl') {
            $a = $data->query("SELECT * FROM stihl_equipment WHERE id = '$prodId'");
        }
        if($equiptype == 'kuhn') {
            $a = $data->query("SELECT * FROM custom_equipment WHERE id = '$prodId'");
        }
        if($equiptype == 'woods') {
            $a = $data->query("SELECT * FROM woods_equipment WHERE id = '$prodId'");
        }
        if($equiptype == 'custom') {
            $a = $data->query("SELECT * FROM custom_equipment WHERE id = '$prodId'");
        }
        $obj = $a->fetch_array();
        $title = $obj["title"];
        $outTitleSub = $obj["sub_title"];

        $bullets = $obj["bullet_points"];


        $price = str_replace('*', '', $obj["price"]);

        $optLinks = json_decode($obj["opt_links"], true);


        for ($l = 0; $l <= count($optLinks); $l++) {
            if ($l == 0) {
            } else {
                if ($optLinks[$l]["LinkUrl"] != '') {
                    $optLinksOut .= '<a class="optlinks" href="' . $optLinks[$l]["LinkUrl"] . '">' . $optLinks[$l]["LinkText"] . ' <i class="fa fa-angle-right" aria-hidden="true"></i></a>';
                }
            }
        }


        if($equiptype == 'deere') {
            $image = 'img/' . $obj["eq_image"];
            $price = $price;
        }

        if($equiptype == 'honda') {
            $imgas = json_decode($obj["eq_image"],true);
            $image = 'img/Honda/' . $imgas[0];
            $price = number_format(trim($price, " \t\n\r\0\x0B\xC2\xA0"));
        }

        if($equiptype == 'stihl') {
            $imgas = json_decode($obj["eq_image"],true);
            $image = 'img/Stihl/' . $imgas[0];
            $price = number_format(trim($price, " \t\n\r\0\x0B\xC2\xA0"));
        }


        $features = $obj["features"];

        $bulletsOut = json_decode($bullets, true);

        $bullethtml .= '<ul>';

        foreach ($bulletsOut as $bull) {
            $bullethtml .= '<li>' . $bull . '</li>';
        }

        $bullethtml .= '</ul>';

        $html .= '<div class="row">';
        $html .= '<div class="col-md-8" style="padding:0"><img style="width:100%" src="' . $image . '"></div>';

        if ($price != null) {
            $priceOut = '<span>STARTING AT:<br><strong style="font-size: 24px">$' .$price. '</strong></span><br>';
        } else {
            $priceOut = '';
        }

        $html .= '<div class="col-md-4"><h1>' . str_replace('_',' ',$title) . '<br><span class="sub-h1">' . $outTitleSub . '</span></h1>' . $bullethtml . '<br>' . $priceOut . '<br>' . $optLinksOut . '<br><br><a href="'.$_POST["linkset"].'/'.$title.'" class="btn btn-default">View Details Page</a></div>';

        $html .= '<div class="clearfix"></div><br>';


        $html = '<div class="">' . $html . '</div>';

        $html .= '</div>';

        echo $html;
    }else{

        echo 'No Products Found';

    }
}