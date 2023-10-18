<?php

echo $title;
include ("inc/api/inc/harness.php");
session_start();
//session_destroy();

if(isset($_SESSION["target_ads"])){
    //DO NOTHING IM NOT EVEN SURE WE NEED THIS DATA BUT WE WILL CAPTURE IT ANYWAY//
}else{
    //attempt to get the ip of the user//
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
}

//get full link of equipment//
$equipLink = $_SERVER["REQUEST_URI"];
//get last part of url which will contain the model of the equipment//
$equipBase = basename($equipLink);
//get current timestamp//
$date = time();


if (isset($_SESSION["target_ads"])) {
    //unbind the session data and add new viewable object here//

    //convert back to workable php array//
    $session = json_decode($_SESSION["target_ads"], true);

    $ip = $session["ip"];
    $eqipinf = $session["equipinfo"];

    //function to go through array object for duplicates//
    function in_array_r($item, $array)
    {
        return preg_match('/"' . preg_quote($item, '/') . '"/i', json_encode($array));
    }


    //check for dups//
    if (in_array_r($equipBase, $session)) {
        ///DONT ADD A THING///
    } else {
        $eqipInfo[] = array("equiplink" => $equipLink, "equipbase" => $equipBase, "capture_date" => $date, "image" => $image, "cat_one" => $cat_one, "cat_two" => $cat_two, "cat_three" => $cat_three,"sub_title" => $sub_title , "parent_cat" => $parent_cat, "equip_link" => $equip_link);
    }

    //go through array and break apart//
    for ($i = 0; $i < count($eqipinf); $i++) {
        if ($i < 1) {
            $a = $data->query("SELECT * FROM deere_equipment WHERE title ='1025r' AND active = 'true'") or die($data->error);
            if ($a->num_rows > 0) {
                //PAGE EXISTS//
                $b = $a->fetch_array();
                $image = $b["eq_image"];
                $parent_cat = $b["parent_cat"];
                $cat_one = $b["cat_one"];
                $cat_two = $b["cat_two"];
                $cat_three = $b["cat_three"];
                $equip_link = $b["site_link"];
                $sub_title = $b["sub_title"];


                //add new item and remove old shit//

                $eqipInfo[] = array("equiplink" => $eqipinf[$i]["equiplink"], "equipbase" => $eqipinf[$i]["equipbase"], "capture_date" => $eqipinf[$i]["capture_date"], "image" => $eqipinf[$i]["image"], "parent_cat" => $eqipinf[$i]["parent_cat"], "cat_one" => $eqipinf[$i]["cat_one"],
                    "cat_two" => $eqipinf[$i]["cat_two"], "cat_three" => $eqipinf[$i]["cat_three"], "equip_link" => $eqipinf[$i]["equip_link"]);


                $sql = "SELECT * FROM used_equipment WHERE model ='1025r' AND active = 'true'";
                if ($res = mysqli_query($data, $sql)) {
                    $num_rows = mysqli_num_rows($res);
//                    echo $num_rows;
                    if ($num_rows > 0) {
                        if ($num_rows > 1){
                        while ($row = mysqli_fetch_assoc($res)) {

                            $model = $row['model'];
                            $price = $row['ad_price'];
                            $obj = json_decode($price, true);
                            $ad_price = $obj->{'amount'};


                            $image = stripslashes($row["images"]);
                            $image = str_replace('(', '', $image);
                            $image = str_replace(')', '', $image);
                            $image = json_decode($image, true);
                            $imageOut = $image["image"][0]["filePointer"];
                            //echo $imageOut;

                            if ($imageOut != '') {
                                $imageOut = $imageOut;
                            } else {
                                $imageOut = 'img/No_Image_Available.jpg';
                            }

                            $link = str_replace(' ', '-', $row["category"]) . '/' . str_replace(' ', '-', $row["manufacturer"]) . '-' . str_replace(' ', '-', $row["model"]) . '-' . $row["id"];

                            $equipInfoo[] = array("model" => $model, "ad_price" => $ad_price, "image" => $imageOut, "link" => $link);
                            //var_dump($equipInfoo);

                        }

                        $htmlCars .= '<div class="container-fluid">
<h4 style="font-size: 1rem;">USED EQUIPMENT YOU MAY LIKE</h4>
<div id="myCarousel" class="carousel slide" data-ride="carousel" style="width: 250px;">

  <!--<ol class="carousel-indicators">
    <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
    <li data-target="#myCarousel" data-slide-to="1"></li> 
    <li data-target="#myCarousel" data-slide-to="2"></li>
  </ol>--!>';


                        $htmlCars .= '<div class="carousel-inner">';
                        $first = 0;
                        for ($j = 0; $j < count($equipInfoo); $j++) {
                            if ($first == 0) {
                                $htmlCars .= '<div class="carousel-item active">
      <a href="Used-Equipment/' . $equipInfoo[$j]["link"] . '"><img style="border: 1px solid #ddd; border-radius: 4px; padding: 5px; width: 250px; max-height: 180px;" src=' . $equipInfoo[$j]["image"] . '></a>
      <p style="text-align: center; font-size: medium; background: black; color: white;">' . $equipInfoo[$j]["model"] . '</p>
    </div>';
                            } else {
                                $htmlCars .= '<div class="carousel-item">
      <a href="Used-Equipment/' . $equipInfoo[$j]["link"] . '"><img style="border: 1px solid #ddd; border-radius: 4px; padding: 5px; width: 250px; max-height: 180px;" src=' . $equipInfoo[$j]["image"] . '></a>
      <p style="text-align: center; font-size: medium; background: black; color: white;">' . $equipInfoo[$j]["model"] . '</p>
    </div>';
                            }

                            $first++;
                        }

                        $htmlCars .= '<a class="carousel-control-prev" href="#myCarousel" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="carousel-control-next" href="#myCarousel" role="button" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>';

                        $htmlCars .= '</div></div></div>';

                        $html .= $htmlCars;

                    }else{
                            while ($row = mysqli_fetch_assoc($res)) {

                                $model = $row['model'];
                                $price = $row['ad_price'];
                                $obj = json_decode($price, true);
                                $ad_price = $obj->{'amount'};


                                $image = stripslashes($row["images"]);
                                $image = str_replace('(', '', $image);
                                $image = str_replace(')', '', $image);
                                $image = json_decode($image, true);
                                $imageOut = $image["image"][0]["filePointer"];
                                //echo $imageOut;

                                if ($imageOut != '') {
                                    $imageOut = $imageOut;
                                } else {
                                    $imageOut = 'img/No_Image_Available.jpg';
                                }

                                $link = str_replace(' ', '-', $row["category"]) . '/' . str_replace(' ', '-', $row["manufacturer"]) . '-' . str_replace(' ', '-', $row["model"]) . '-' . $row["id"];

                                $equipInfoo[] = array("model" => $model, "ad_price" => $ad_price, "image" => $imageOut, "link" => $link);
                                //var_dump($equipInfoo);

                            }

                            $htmlCars .= '<div class="container-fluid">
<h4 style="font-size: 1rem;">USED EQUIPMENT YOU MAY LIKE</h4>
<div id="myCarousel" class="carousel slide" data-ride="carousel" style="width: 250px;">

  <!--<ol class="carousel-indicators">
    <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
    <li data-target="#myCarousel" data-slide-to="1"></li> 
    <li data-target="#myCarousel" data-slide-to="2"></li>
  </ol>--!>';


                            $htmlCars .= '<div class="carousel-inner">';
                            $first = 0;
                            for ($j = 0; $j < count($equipInfoo); $j++) {
                                if ($first == 0) {
                                    $htmlCars .= '<div class="carousel-item active">
      <a href="Used-Equipment/' . $equipInfoo[$j]["link"] . '"><img style="border: 1px solid #ddd; border-radius: 4px; padding: 5px; width: 250px; max-height: 180px;" src=' . $equipInfoo[$j]["image"] . '></a>
      <p style="text-align: center; font-size: medium; background: black; color: white;">' . $equipInfoo[$j]["model"] . '</p>
    </div>';
                                } else {
                                    $htmlCars .= '<div class="carousel-item">
      <a href="Used-Equipment/' . $equipInfoo[$j]["link"] . '"><img style="border: 1px solid #ddd; border-radius: 4px; padding: 5px; width: 250px; max-height: 180px;" src=' . $equipInfoo[$j]["image"] . '></a>
      <p style="text-align: center; font-size: medium; background: black; color: white;">' . $equipInfoo[$j]["model"] . '</p>
    </div>';
                                }

                                $first++;
                            }

                            $htmlCars .= '</div></div></div>';

                            $html .= $htmlCars;


                        }
                    } else {
                        $sql = "SELECT * FROM used_equipment WHERE category LIKE '%$sub_title%' AND active = 'true'";
                        if ($res = mysqli_query($data, $sql)) {
                            $num_rowss = mysqli_num_rows($res);
                            if ($num_rowss > 0) {
                                while ($row = mysqli_fetch_assoc($res)) {
                                    $category = $row['category'];
                                    //echo $category;
                                    $model = $row['model'];
                                    $price = $row['ad_price'];
                                    $obj = json_decode($price, true);
                                    $ad_price = $obj->{'amount'};


                                    $image = stripslashes($row["images"]);
                                    $image = str_replace('(', '', $image);
                                    $image = str_replace(')', '', $image);
                                    $image = json_decode($image, true);
                                    $imageOut = $image["image"][0]["filePointer"];
                                    //echo $imageOut;

                                    if ($imageOut != '') {
                                        $imageOut = $imageOut;
                                    } else {
                                        $imageOut = 'img/No_Image_Available.jpg';
                                    }

                                    $link = str_replace(' ', '-', $row["category"]) . '/' . str_replace(' ', '-', $row["manufacturer"]) . '-' . str_replace(' ', '-', $row["model"]) . '-' . $row["id"];

                                    $equipInfoo[] = array("model" => $model, "ad_price" => $ad_price, "image" => $imageOut, "link" => $link);
                                }
                                $htmlCars .= '<div class="container-fluid">
<h4 style="text-align: center;">USED EQUIPMENT YOU MAY LIKE</h4>
<div id="myCarousel" class="carousel slide" data-ride="carousel" style="width: 30%; margin: 0px auto; margin-top: 40px; background-color:#000; color:#fff; ">

  <ol class="carousel-indicators">
    <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
    <li data-target="#myCarousel" data-slide-to="1"></li> 
    <li data-target="#myCarousel" data-slide-to="2"></li>
  </ol>';


                                $htmlCars .= '<div class="carousel-inner">';
                                $first = 0;
                                for ($j = 0; $j < count($equipInfoo); $j++) {
                                    if ($first == 0) {
                                        $htmlCars .= '<div class="item active">
      <a href="http://sydenstricker.bcssdevelop.com/Used-Equipment/' . $equipInfoo[$j]["link"] . '"><img style="width: 100%" src=' . $equipInfoo[$j]["image"] . '></a>
      <p style="text-align: center; font-size: medium;">' . $equipInfoo[$j]["model"] . '</p>
    </div>';
                                    } else {
                                        $htmlCars .= '<div class="item">
      <a href="http://sydenstricker.bcssdevelop.com/Used-Equipment/' . $equipInfoo[$j]["link"] . '"><img style="width: 100%" src=' . $equipInfoo[$j]["image"] . '></a>
      <p style="text-align: center; font-size: medium;">' . $equipInfoo[$j]["model"] . '</p>
    </div>';
                                    }

                                    $first++;
                                }

                                $htmlCars .= '</div>';


                                $htmlCars .= '<a class="carousel-control left" href="#myCarousel" data-slide="prev" style="top: 50%; color: #000; font-size: 40px;"> 
<i class="fa fa-chevron-left" aria-hidden="true" style="font-size: 30px; margin-left: -113px;"></i> 
</a> 
<a class="carousel-control right" href="#myCarousel" data-slide="next" style="top: 50%; color: #000; font-size: 40px;"> 
<i class="fa fa-chevron-right" aria-hidden="true" style="font-size: 30px; margin-right: -113px;"></i> 
</a>
</div></div>';

                                $html .= $htmlCars;
                            }
                            else

                            {
                                $htmlCars .= '<div class="container"><h2 style="text-align: left">EQUIPMENT YOU VISITED</h2><div id="myCarousel" class="carousel slide" data-ride="carousel" style="width: 45%; margin: 0px auto;">

  <ol class="carousel-indicators">
    <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
    <li data-target="#myCarousel" data-slide-to="1"></li>
    <li data-target="#myCarousel" data-slide-to="2"></li>
  </ol>';


                                $htmlCars .= '<div class="carousel-inner">';
                                $first = 0;
                                for($j=0; $j<count($eqipInfo); $j++){
                                    if($first == 0) {
                                        $htmlCars .= '<div class="item active">
      <a href="'.$eqipInfo[$j]["equiplink"].'"><img style="width: 100%" src="http://sydenstricker.bcssdevelop.com/' . $eqipInfo[$j]["image"] . '"></a>
      <p style="text-align: center; font-size: medium;">'.$eqipInfo[$j]["1025R"].'</p>
    </div>';
                                    }else{
                                        $htmlCars .= '<div class="item">
      <a href="'.$eqipInfo[$j]["equiplink"].'"><img style="width: 100%" src="http://sydenstricker.bcssdevelop.com/' . $eqipInfo[$j]["image"] . '"></a>
      <p style="text-align: center; font-size: medium;">'.$eqipInfo[$j]["1025R"].'</p>
    </div>';
                                    }

                                    $first++;
                                }

                                $htmlCars .= '</div>';


                                $htmlCars .='<a class="carousel-control left" href="#myCarousel" data-slide="prev" style="top: 50%; color: #000; font-size: 40px;"> 
<i class="fa fa-chevron-left" aria-hidden="true" style="font-size: 30px; margin-left: -113px;"></i> 
</a> 
<a class="carousel-control right" href="#myCarousel" data-slide="next" style="top: 50%; color: #000; font-size: 40px;"> 
<i class="fa fa-chevron-right" aria-hidden="true" style="font-size: 30px; margin-right: -113px;"></i> 
</a>
</div></div>';

                                $html .= $htmlCars;
                            }

                        }
                    }
                }
            }
        }
    }



    $eqipData = array("ip" => $ip, "equipinfo" => $eqipInfo);

    //encode to json string remove echo when done with development//
    $eqipData = json_encode($eqipData);

    //ready the session for the newness//
    unset ($_SESSION["target_ads"]);

    //create the sesson//
    $_SESSION["target_ads"] = $eqipData;
    //echo $eqipData and target_ads



} else {
    //set the data for the first time//
    $eqipInfo[] = array("equiplink" => $equipLink, "equipbase" => $equipBase, "capture_date" => $date , "image" => $image , "cat_one" => $cat_one, "cat_two" => $cat_two, "cat_two", $cat_three, "cat_three", $parent_cat, "parent_cat");
    $eqipData = array("ip" => $ip, "equipinfo" => $eqipInfo);

    //encode to json string//
    $eqipData = json_encode($eqipData);

    //create the sesson//
    $_SESSION["target_ads"] = $eqipData;

}



?>

<?php
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

error_reporting(E_ERROR | E_PARSE);


$arrContextOptions=array(
    "ssl"=>array(
        "verify_peer"=>false,
        "verify_peer_name"=>false,
    ),
);

//$response = file_get_contents("https://www.deere.com/en/tractors/compact-tractors/1-series-sub-compact-tractors/1025r/index.json", false, stream_context_create($arrContextOptions));
//$response = file_get_contents("https://www.deere.com/en/articulated-dump-trucks/260e/index.json", false, stream_context_create($arrContextOptions));
//$response = file_get_contents("https://www.deere.com/en/mowers/zero-turn-mowers/z300-series/z335e-ztrak-mower/index.json", false, stream_context_create($arrContextOptions));
include ("inc/api/inc/harness.php");
$a = $data->query("SELECT * from deere_equipment WHERE id = '90'");
$b = $a->fetch_array();


$data = json_decode($response, true);

//echo '<pre>';
//var_dump($data["Page"]["reviews-ratings"]["Product"]);
//echo '</pre>';

$id = $b["id"];

$productsummary = $b["bullet_points"];
$productprice = $b["price"];
$urlbase = "https://www.deere.com";
// Get Image Stuff
$imgdecode = json_decode($b["eq_image"]);




if($imgdecode[1] != '') {
    $schemaimg = 'http://deere-view.bcssdevelop.com/inc/api/equip_imgs/' . $imgdecode[0];
    $imggallery = '<ul id="lightSlider">';

    for ($o = 0; $o < count($imgdecode); $o++) {


        $imgpath = $imgdecode[$o];
        $imgthumb = $imgdecode[$o];
        $imggallery .= '<li data-thumb="inc/api/equip_imgs/' . $imgpath . '" ><img src="inc/api/equip_imgs/' . $imgpath . '" class="img-responsive"/></li>';
    }




    $imggallery .= '</ul>';

} else {

    $imgpath = trim($b["eq_image"], '"');
    $imggallery = '<img src="inc/api/equip_imgs/'.$imgpath.'" class="img-responsive"/>';

    $schemaimg = 'http://deere-view.bcssdevelop.com/inc/api/equip_imgs/'.$imgpath;


}

$title = $b["title"];
$subtitle =$b["sub_title"];
$mainimg = $b["eq_image"][0];

if($b["price"] != '') {
    $pricepresent = '<span class="startingat">Starting At:</span><span class="equipprice">'.$b["price"].'</span><span class="usd">USD</span>';
} else {
    $pricepresent = '';
}

$features = $b["features"];

$featuredata = json_decode($features, true);

$featurelist = '';

for ($i = 0; $i < count($featuredata["Page"]["expandcollapse"]["Section"]["SectionData"]["Data"]); $i++) {
    $featuredetails = $featuredata["Page"]["expandcollapse"]["Section"]["SectionData"]["Data"][$i]["Description"];
    $featuretitle = $featuredata["Page"]["expandcollapse"]["Section"]["SectionData"]["Data"][$i]["TitleQuestion"];



    $featurelist .= '<div class="panel panel-default">
                   <div class="panel-heading">
                       <h4 class="panel-title">
                           <a data-toggle="collapse" data-parent="#accordion" href="#collapse'.$i.'" style="text-decoration: none; color: black; font-size: 18px; font-weight: 400;"><i style="color: #377C2E;"class="fas fa-plus"></i>
                               '.$featuretitle.'</a>
                       </h4>
                   </div>
                   <div id="collapse'.$i.'" class="panel-collapse collapse">
                       <div class="panel-body"> '.$featuredetails.'</div>
                   </div>
               </div>';



}

$featureoutput = '<div class="panel-group" id="accordion">'.$featurelist.'</div>';



// Specifications

$arrContextOptions=array(
    "ssl"=>array(
        "verify_peer"=>false,
        "verify_peer_name"=>false,
    ),
);
$specs = $b["specs"];

$specdata = json_decode($specs, true);

//$specname = $specdata["Page"]["specifications"]["Category"][0]["Specs"][0]["Name"];;
//$specmodel = $specvalue = $specdata["Page"]["specifications"]["Category"][0]["Specs"][0]["CurrentModelDescription"];


//$relatedmods = $specdata["Page"]["specifications"]["RelatedModels"][0]["Model"];
$relatedmods = $specdata["Page"]["specifications"]["RelatedModels"];




echo '<pre>';
//var_dump($relatedmods);

echo '</pre>';

$specz = $specdata["Page"]["specifications"]["Category"];
$spechtml .= '<table id="specs-table" class="table table-striped">';
for($i = 0; $i < count($specz); $i++){
    //$html .= '<div style="background: #efefef; padding: 20px; margin: 20px"><strong>'.$specz[$i]["Name"].'</strong><br>';

    if($i == 0){
        $spechtml .= '<tr class="rowdata"><th style="width: 25%;"><strong>'.$specz[$i]["Name"].'</strong></th><th style="width: 25%;" class="first-compare">Current Model <br>'.$title.'</th></tr>';
    }else{
        if($specz[$i]["Name"] == "Additional information") {

        } else {
            $spechtml .= '<tr class="table_head"><th style="width: 25%;"><strong>' . $specz[$i]["Name"] . '</strong></th><th style="width: 25%;" class="first-compare"></th></tr>';
        }
    }

    $specks = $specz[$i]["Specs"];
    if(!empty($specks)) {
        for ($j = 0; $j < count($specks); $j++) {

            if($specz[$i]["Name"] == "Additional information") {

            }else {
                $spechtml .= '<tr class="rowdata"><td style="width: 25%;">' . $specks[$j]["Name"] . '</td><td style="width: 25%;">' . $specks[$j]["CurrentModelDescription"] . '</td></tr>';
            }
        }
    }



}

$spechtml .= '</table>';



if(is_null($getoptid  = $specdata["Page"]["specifications"]["RelatedModels"][0]["ID"])) {
    $ifspecs = 'display: none';
} else {
    $ifspecs = 'display: block';
}

        $specoptions = '<select id="comp-options" name="comp-options"  data-equipid="'.$b["id"].'"><option disabled selected>Select Models To Compare</option>';

        for ($k = 0; $k < count($relatedmods); $k ++ ) {
                $getoptions = $specdata["Page"]["specifications"]["RelatedModels"][$k]["Name"];
                $getoptid  = $specdata["Page"]["specifications"]["RelatedModels"][$k]["ID"];



               $specoptions .= '<option value="'.$specdata["Page"]["specifications"]["RelatedModels"][$k]["ID"].'" data-equipid="'.$b["id"].'">'.$getoptions.'</option>';
               }

               $specoptions .=  '</select></div></div></div>';


// Rating Stuff
$reviewdata = $b["review_rating_data"];
$ratingstuff = json_decode($reviewdata, true);



$rating = $ratingstuff["Product"]["Rating"];
$numratings = $ratingstuff["Product"]["ReviewCount"];
$ratingdata = $ratingstuff["Review"];



if (is_null($ratingdata)) {
    $ratingGET = 'NULL';
} else {
    if(!empty($ratingstuff["Review"][0])) {


        $ratingGET .= '<h2>Reviews</h2><section id="review-overall">
                            <div class="row">
                                <div class="col-md-6">
                                <div class="rate-input max-width text-xs-center text-md-left reviews-summary" itemtype="http://schema.org/AggregateRating" itemscope="itemscope" itemprop="aggregateRating"><span class="large-value align" itemprop="ratingValue">'.floatval(number_format($ratingstuff["Product"]["Rating"], 2)).'</span><div class="input large jq-ry-container" data-read-only="true" data-value="'.$ratingstuff["Product"]["Rating"].'" readonly="readonly" style="width: 136px;"><div class="jq-ry-group-wrapper"><div class="jq-ry-normal-group jq-ry-group"><!--?xml version="1.0" encoding="utf-8"?--><svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 12.705 512 486.59" x="0px" y="0px" xml:space="preserve" width="24px" height="24px" fill="#c2c2c2"><polygon points="256.814,12.705 317.205,198.566 512.631,198.566 354.529,313.435 414.918,499.295 256.814,384.427 98.713,499.295 159.102,313.435 1,198.566 196.426,198.566 "></polygon></svg><!--?xml version="1.0" encoding="utf-8"?--><svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 12.705 512 486.59" x="0px" y="0px" xml:space="preserve" width="24px" height="24px" fill="#c2c2c2" style="margin-left: 4px;"><polygon points="256.814,12.705 317.205,198.566 512.631,198.566 354.529,313.435 414.918,499.295 256.814,384.427 98.713,499.295 159.102,313.435 1,198.566 196.426,198.566 "></polygon></svg><!--?xml version="1.0" encoding="utf-8"?--><svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 12.705 512 486.59" x="0px" y="0px" xml:space="preserve" width="24px" height="24px" fill="#c2c2c2" style="margin-left: 4px;"><polygon points="256.814,12.705 317.205,198.566 512.631,198.566 354.529,313.435 414.918,499.295 256.814,384.427 98.713,499.295 159.102,313.435 1,198.566 196.426,198.566 "></polygon></svg><!--?xml version="1.0" encoding="utf-8"?--><svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 12.705 512 486.59" x="0px" y="0px" xml:space="preserve" width="24px" height="24px" fill="#c2c2c2" style="margin-left: 4px;"><polygon points="256.814,12.705 317.205,198.566 512.631,198.566 354.529,313.435 414.918,499.295 256.814,384.427 98.713,499.295 159.102,313.435 1,198.566 196.426,198.566 "></polygon></svg><!--?xml version="1.0" encoding="utf-8"?--><svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 12.705 512 486.59" x="0px" y="0px" xml:space="preserve" width="24px" height="24px" fill="#c2c2c2" style="margin-left: 4px;"><polygon points="256.814,12.705 317.205,198.566 512.631,198.566 354.529,313.435 414.918,499.295 256.814,384.427 98.713,499.295 159.102,313.435 1,198.566 196.426,198.566 "></polygon></svg></div><div class="jq-ry-rated-group jq-ry-group"><!--?xml version="1.0" encoding="utf-8"?--><svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 12.705 512 486.59" x="0px" y="0px" xml:space="preserve" width="24px" height="24px" fill="rgb(54, 124, 43)"><polygon points="256.814,12.705 317.205,198.566 512.631,198.566 354.529,313.435 414.918,499.295 256.814,384.427 98.713,499.295 159.102,313.435 1,198.566 196.426,198.566 "></polygon></svg><!--?xml version="1.0" encoding="utf-8"?--><svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 12.705 512 486.59" x="0px" y="0px" xml:space="preserve" width="24px" height="24px" fill="rgb(54, 124, 43)" style="margin-left: 4px;"><polygon points="256.814,12.705 317.205,198.566 512.631,198.566 354.529,313.435 414.918,499.295 256.814,384.427 98.713,499.295 159.102,313.435 1,198.566 196.426,198.566 "></polygon></svg><!--?xml version="1.0" encoding="utf-8"?--><svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 12.705 512 486.59" x="0px" y="0px" xml:space="preserve" width="24px" height="24px" fill="rgb(54, 124, 43)" style="margin-left: 4px;"><polygon points="256.814,12.705 317.205,198.566 512.631,198.566 354.529,313.435 414.918,499.295 256.814,384.427 98.713,499.295 159.102,313.435 1,198.566 196.426,198.566 "></polygon></svg><!--?xml version="1.0" encoding="utf-8"?--><svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 12.705 512 486.59" x="0px" y="0px" xml:space="preserve" width="24px" height="24px" fill="rgb(54, 124, 43)" style="margin-left: 4px;"><polygon points="256.814,12.705 317.205,198.566 512.631,198.566 354.529,313.435 414.918,499.295 256.814,384.427 98.713,499.295 159.102,313.435 1,198.566 196.426,198.566 "></polygon></svg><!--?xml version="1.0" encoding="utf-8"?--><svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 12.705 512 486.59" x="0px" y="0px" xml:space="preserve" width="24px" height="24px" fill="rgb(54, 124, 43)" style="margin-left: 4px;"><polygon points="256.814,12.705 317.205,198.566 512.631,198.566 354.529,313.435 414.918,499.295 256.814,384.427 98.713,499.295 159.102,313.435 1,198.566 196.426,198.566 "></polygon></svg></div></div></div><br><meta itemprop="bestRating" content="5">
                  <meta itemprop="reviewCount" content="25"><span class="align">'.$ratingstuff["Product"]["ReviewCount"].' reviews</span><div class="snapshot hide">
                     <h4>Rating Snapshot</h4>
                     <div class="g-rating-bar inline" data-total="'.$ratingstuff["Product"]["ReviewCount"].'" data-value="'.$ratingstuff["Product"]["ReviewCount5"].'"><label>5</label><div class="bar">
                           <div class="bg" style="width: 48%;"></div><span class="value">'.$ratingstuff["Product"]["ReviewCount5"].'</span></div>
                     </div>
                     <div class="g-rating-bar inline" data-total="'.$ratingstuff["Product"]["ReviewCount"].'" data-value="'.$ratingstuff["Product"]["ReviewCount4"].'"><label>4</label><div class="bar">
                           <div class="bg" style="width: 32%;"></div><span class="value">'.$ratingstuff["Product"]["ReviewCount4"].'</span></div>
                     </div>
                     <div class="g-rating-bar inline" data-total="'.$ratingstuff["Product"]["ReviewCount"].'" data-value="'.$ratingstuff["Product"]["ReviewCount3"].'"><label>3</label><div class="bar">
                           <div class="bg"></div><span class="value">'.$ratingstuff["Product"]["ReviewCount3"].'</span></div>
                     </div>
                     <div class="g-rating-bar inline" data-total="'.$ratingstuff["Product"]["ReviewCount"].'" data-value="'.$ratingstuff["Product"]["ReviewCount2"].'"><label>2</label><div class="bar">
                           <div class="bg" style="width: 4%;"></div><span class="value">'.$ratingstuff["Product"]["ReviewCount3"].'</span></div>
                     </div>
                     <div class="g-rating-bar inline" data-total="'.$ratingstuff["Product"]["ReviewCount"].'" data-value="'.$ratingstuff["Product"]["ReviewCount1"].'"><label>1</label><div class="bar">
                           <div class="bg" style="width: 16%;"></div><span class="value">'.$ratingstuff["Product"]["ReviewCount1"].'</span></div>
                     </div>
                  </div>
               </div>
                                
</div>
                                <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-4 overall-ratings">
                                     <div class="g-rating-bar clearfix rating-item" data-total="5" data-value="'.floatval(number_format( $ratingstuff["Product"]["ValueRating"], 2)) . '" data-segments="5"><label>VALUE</label><span class="value">'.floatval(number_format( $ratingstuff["Product"]["ValueRating"], 2)) . '</span><div class="bar">
                                        <div class="bg"></div>
                                        <div class="segments"><div class="segment" style="width:20%"></div><div class="segment" style="width:20%"></div><div class="segment" style="width:20%"></div><div class="segment" style="width:20%"></div><div class="segment" style="width:20%"></div></div></div>
                                    </div>
                                    </div>
                                    <div class="col-md-4 overall-ratings"><div class="g-rating-bar clearfix rating-item" data-total="5" data-value="' . floatval(number_format($ratingstuff["Product"]["QualityRating"],2)) . '" data-segments="5"><label>QUALITY</label><span class="value">' . floatval(number_format($ratingstuff["Product"]["QualityRating"],2)) . '</span><div class="bar">
                                        <div class="bg"></div>
                                        <div class="segments"><div class="segment" style="width:20%"></div><div class="segment" style="width:20%"></div><div class="segment" style="width:20%"></div><div class="segment" style="width:20%"></div><div class="segment" style="width:20%"></div></div></div>
                                    </div></div>
                                    <div class="col-md-4 overall-ratings">
                                    <div class="g-rating-bar clearfix rating-item" data-total="5" data-value="' . floatval(number_format($ratingstuff["Product"]["EaseOfUseRating"],2)) . '" data-segments="5"><label>EASE OF USE</label><span class="value">' . floatval(number_format($ratingstuff["Product"]["EaseOfUseRating"],2)) . '</span><div class="bar">
                                        <div class="bg"></div>
                                        <div class="segments"><div class="segment" style="width:20%"></div><div class="segment" style="width:20%"></div><div class="segment" style="width:20%"></div><div class="segment" style="width:20%"></div><div class="segment" style="width:20%"></div></div></div>
                                    </div>
                                    </div>
                                    </div>
                                </div>
                            </div>
                        </section>
<section id="review-top">
            <div class="col-md-12 review-nav">
                <ul class="filterlist">
                    <li style="color: #9b9b9b; font-weight: bold; text-transform: uppercase; margin-right: 20px;">Filter</li>
                    <li><a href="#star-rating-filter">Star Rating <i class="fas fa-chevron-down"></i></a>
                    </li>
                    <li><a href="#value-rating-filter">Value <i class="fas fa-chevron-down"></i></a></li>
                    <li><a href="#quality-rating-filter">Quality <i class="fas fa-chevron-down"></i></a></li>
                </ul>
            </div>
        </section>
        <section id="reviewdata">';

        for ($m = 0; $m < count($ratingdata); $m++) {

            $originaldate = $ratingdata[$m]["SubmissionTime"];
//    $newDate = date("m-d-Y", strtotime($originaldate));
//

            $ratingGET .= '<section><div class="container rating"  style="margin-bottom: 50px;">
                        <div class="row" style="padding-left: 15px;">
                        <div class="col-md-8 rating-card">
                            <span class="rating-date">' . $newDate . '</span>
                            <h2 class="rating-title">' . $ratingdata[$m]["Title"] . '</h2>
                            <div class="input jq-ry-container" data-read-only="true" data-value="' . $ratingdata[$m]["Rating"] . '" readonly="readonly" style="width: 96px;"><div class="jq-ry-group-wrapper"><div class="jq-ry-normal-group jq-ry-group"><!--?xml version="1.0" encoding="utf-8"?--><svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 12.705 512 486.59" x="0px" y="0px" xml:space="preserve" width="16px" height="16px" fill="#c2c2c2"><polygon points="256.814,12.705 317.205,198.566 512.631,198.566 354.529,313.435 414.918,499.295 256.814,384.427 98.713,499.295 159.102,313.435 1,198.566 196.426,198.566 "></polygon></svg><!--?xml version="1.0" encoding="utf-8"?--><svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 12.705 512 486.59" x="0px" y="0px" xml:space="preserve" width="16px" height="16px" fill="#c2c2c2" style="margin-left: 4px;"><polygon points="256.814,12.705 317.205,198.566 512.631,198.566 354.529,313.435 414.918,499.295 256.814,384.427 98.713,499.295 159.102,313.435 1,198.566 196.426,198.566 "></polygon></svg><!--?xml version="1.0" encoding="utf-8"?--><svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 12.705 512 486.59" x="0px" y="0px" xml:space="preserve" width="16px" height="16px" fill="#c2c2c2" style="margin-left: 4px;"><polygon points="256.814,12.705 317.205,198.566 512.631,198.566 354.529,313.435 414.918,499.295 256.814,384.427 98.713,499.295 159.102,313.435 1,198.566 196.426,198.566 "></polygon></svg><!--?xml version="1.0" encoding="utf-8"?--><svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 12.705 512 486.59" x="0px" y="0px" xml:space="preserve" width="16px" height="16px" fill="#c2c2c2" style="margin-left: 4px;"><polygon points="256.814,12.705 317.205,198.566 512.631,198.566 354.529,313.435 414.918,499.295 256.814,384.427 98.713,499.295 159.102,313.435 1,198.566 196.426,198.566 "></polygon></svg><!--?xml version="1.0" encoding="utf-8"?--><svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 12.705 512 486.59" x="0px" y="0px" xml:space="preserve" width="16px" height="16px" fill="#c2c2c2" style="margin-left: 4px;"><polygon points="256.814,12.705 317.205,198.566 512.631,198.566 354.529,313.435 414.918,499.295 256.814,384.427 98.713,499.295 159.102,313.435 1,198.566 196.426,198.566 "></polygon></svg></div><div class="jq-ry-rated-group jq-ry-group"><!--?xml version="1.0" encoding="utf-8"?--><svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 12.705 512 486.59" x="0px" y="0px" xml:space="preserve" width="16px" height="16px" fill="rgb(54, 124, 43)"><polygon points="256.814,12.705 317.205,198.566 512.631,198.566 354.529,313.435 414.918,499.295 256.814,384.427 98.713,499.295 159.102,313.435 1,198.566 196.426,198.566 "></polygon></svg><!--?xml version="1.0" encoding="utf-8"?--><svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 12.705 512 486.59" x="0px" y="0px" xml:space="preserve" width="16px" height="16px" fill="rgb(54, 124, 43)" style="margin-left: 4px;"><polygon points="256.814,12.705 317.205,198.566 512.631,198.566 354.529,313.435 414.918,499.295 256.814,384.427 98.713,499.295 159.102,313.435 1,198.566 196.426,198.566 "></polygon></svg><!--?xml version="1.0" encoding="utf-8"?--><svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 12.705 512 486.59" x="0px" y="0px" xml:space="preserve" width="16px" height="16px" fill="rgb(54, 124, 43)" style="margin-left: 4px;"><polygon points="256.814,12.705 317.205,198.566 512.631,198.566 354.529,313.435 414.918,499.295 256.814,384.427 98.713,499.295 159.102,313.435 1,198.566 196.426,198.566 "></polygon></svg><!--?xml version="1.0" encoding="utf-8"?--><svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 12.705 512 486.59" x="0px" y="0px" xml:space="preserve" width="16px" height="16px" fill="rgb(54, 124, 43)" style="margin-left: 4px;"><polygon points="256.814,12.705 317.205,198.566 512.631,198.566 354.529,313.435 414.918,499.295 256.814,384.427 98.713,499.295 159.102,313.435 1,198.566 196.426,198.566 "></polygon></svg><!--?xml version="1.0" encoding="utf-8"?--><svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 12.705 512 486.59" x="0px" y="0px" xml:space="preserve" width="16px" height="16px" fill="rgb(54, 124, 43)" style="margin-left: 4px;"></svg></div></div></div>
                            <span class="rating-text">' . $ratingdata[$m]["Rating"] . '/5</span>
                            <p class="rating-text">' . $ratingdata[$m]["ReviewText"] . '</p>
                            <h3>Pros</h3>
                                <p class="pro-text">' . $ratingdata[$m]["ProsText"] . '</p>
                            <h3>Cons</h3>
                                <p class="con-text">' . $ratingdata[$m]["ConsText"] . '</p>
                        </div>
                        
                        <div class="col-md-4 review-card-summary">
                            <strong>' . $ratingdata[$m]["AuthorName"] . '</strong>
                            <p class="from-rating">From: ' . $ratingdata[$m]["ReviewerLocation"] . '</p>
                            <p class="length-rating">Length of Ownership: ' . $ratingdata[$m]["LengthOfOwnership"] . '</p>
                            <p class="usage-rating">Usage Frequency: ' . $ratingdata[$m]["UsageFrequency"] . '</p>
                            <p class="expert-rating">Level of Expertise: ' . $ratingdata[$m]["LevelOfExpertise"] . '</p>
                            
                            <div class="g-rating-bar clearfix rating-item" data-total="5" data-value="' . $ratingdata[$m]["ValueRating"] . '" data-segments="5"><label>VALUE</label><span class="value">' . $ratingdata[$m]["ValueRating"] . '</span><div class="bar">
                                <div class="bg"></div>
                                <div class="segments"><div class="segment" style="width:20%"></div><div class="segment" style="width:20%"></div><div class="segment" style="width:20%"></div><div class="segment" style="width:20%"></div><div class="segment" style="width:20%"></div></div></div>
                            </div>
                                          
                            <div class="g-rating-bar clearfix rating-item" data-total="5" data-value="2" data-segments="5"><label>QUALITY</label><span class="value">2</span><div class="bar">
                                <div class="bg"></div>
                                <div class="segments"><div class="segment" style="width:20%"></div><div class="segment" style="width:20%"></div><div class="segment" style="width:20%"></div><div class="segment" style="width:20%"></div><div class="segment" style="width:20%"></div></div></div>
                            </div>
                                        
                            <div class="g-rating-bar clearfix rating-item" data-total="5" data-value="5" data-segments="5"><label>EASE OF USE</label><span class="value">5</span><div class="bar">
                                <div class="bg"></div>
                                <div class="segments"><div class="segment" style="width:20%"></div><div class="segment" style="width:20%"></div><div class="segment" style="width:20%"></div><div class="segment" style="width:20%"></div><div class="segment" style="width:20%"></div></div></div>
                            </div>  
                        </div>
                        
                      </div>
                   </div></section>';

        }

        $ratingGET .= '</section>';

    } else {
        $ratingGET .= '<h2>Reviews</h2><section id="review-overall">
                            <div class="row">
                                <div class="col-md-6">
                                <div class="rate-input max-width text-xs-center text-md-left reviews-summary" itemtype="http://schema.org/AggregateRating" itemscope="itemscope" itemprop="aggregateRating"><span class="large-value align" itemprop="ratingValue">'.$ratingstuff["Product"]["Rating"].'</span><div class="input large jq-ry-container" data-read-only="true" data-value="'.$ratingstuff["Product"]["Rating"].'" readonly="readonly" style="width: 136px;"><div class="jq-ry-group-wrapper"><div class="jq-ry-normal-group jq-ry-group"><!--?xml version="1.0" encoding="utf-8"?--><svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 12.705 512 486.59" x="0px" y="0px" xml:space="preserve" width="24px" height="24px" fill="#c2c2c2"><polygon points="256.814,12.705 317.205,198.566 512.631,198.566 354.529,313.435 414.918,499.295 256.814,384.427 98.713,499.295 159.102,313.435 1,198.566 196.426,198.566 "></polygon></svg><!--?xml version="1.0" encoding="utf-8"?--><svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 12.705 512 486.59" x="0px" y="0px" xml:space="preserve" width="24px" height="24px" fill="#c2c2c2" style="margin-left: 4px;"><polygon points="256.814,12.705 317.205,198.566 512.631,198.566 354.529,313.435 414.918,499.295 256.814,384.427 98.713,499.295 159.102,313.435 1,198.566 196.426,198.566 "></polygon></svg><!--?xml version="1.0" encoding="utf-8"?--><svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 12.705 512 486.59" x="0px" y="0px" xml:space="preserve" width="24px" height="24px" fill="#c2c2c2" style="margin-left: 4px;"><polygon points="256.814,12.705 317.205,198.566 512.631,198.566 354.529,313.435 414.918,499.295 256.814,384.427 98.713,499.295 159.102,313.435 1,198.566 196.426,198.566 "></polygon></svg><!--?xml version="1.0" encoding="utf-8"?--><svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 12.705 512 486.59" x="0px" y="0px" xml:space="preserve" width="24px" height="24px" fill="#c2c2c2" style="margin-left: 4px;"><polygon points="256.814,12.705 317.205,198.566 512.631,198.566 354.529,313.435 414.918,499.295 256.814,384.427 98.713,499.295 159.102,313.435 1,198.566 196.426,198.566 "></polygon></svg><!--?xml version="1.0" encoding="utf-8"?--><svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 12.705 512 486.59" x="0px" y="0px" xml:space="preserve" width="24px" height="24px" fill="#c2c2c2" style="margin-left: 4px;"><polygon points="256.814,12.705 317.205,198.566 512.631,198.566 354.529,313.435 414.918,499.295 256.814,384.427 98.713,499.295 159.102,313.435 1,198.566 196.426,198.566 "></polygon></svg></div><div class="jq-ry-rated-group jq-ry-group"><!--?xml version="1.0" encoding="utf-8"?--><svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 12.705 512 486.59" x="0px" y="0px" xml:space="preserve" width="24px" height="24px" fill="rgb(54, 124, 43)"><polygon points="256.814,12.705 317.205,198.566 512.631,198.566 354.529,313.435 414.918,499.295 256.814,384.427 98.713,499.295 159.102,313.435 1,198.566 196.426,198.566 "></polygon></svg><!--?xml version="1.0" encoding="utf-8"?--><svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 12.705 512 486.59" x="0px" y="0px" xml:space="preserve" width="24px" height="24px" fill="rgb(54, 124, 43)" style="margin-left: 4px;"><polygon points="256.814,12.705 317.205,198.566 512.631,198.566 354.529,313.435 414.918,499.295 256.814,384.427 98.713,499.295 159.102,313.435 1,198.566 196.426,198.566 "></polygon></svg><!--?xml version="1.0" encoding="utf-8"?--><svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 12.705 512 486.59" x="0px" y="0px" xml:space="preserve" width="24px" height="24px" fill="rgb(54, 124, 43)" style="margin-left: 4px;"><polygon points="256.814,12.705 317.205,198.566 512.631,198.566 354.529,313.435 414.918,499.295 256.814,384.427 98.713,499.295 159.102,313.435 1,198.566 196.426,198.566 "></polygon></svg><!--?xml version="1.0" encoding="utf-8"?--><svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 12.705 512 486.59" x="0px" y="0px" xml:space="preserve" width="24px" height="24px" fill="rgb(54, 124, 43)" style="margin-left: 4px;"><polygon points="256.814,12.705 317.205,198.566 512.631,198.566 354.529,313.435 414.918,499.295 256.814,384.427 98.713,499.295 159.102,313.435 1,198.566 196.426,198.566 "></polygon></svg><!--?xml version="1.0" encoding="utf-8"?--><svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 12.705 512 486.59" x="0px" y="0px" xml:space="preserve" width="24px" height="24px" fill="rgb(54, 124, 43)" style="margin-left: 4px;"><polygon points="256.814,12.705 317.205,198.566 512.631,198.566 354.529,313.435 414.918,499.295 256.814,384.427 98.713,499.295 159.102,313.435 1,198.566 196.426,198.566 "></polygon></svg></div></div></div><br><meta itemprop="bestRating" content="5">
                  <meta itemprop="reviewCount" content="25"><span class="align">'.$ratingstuff["Product"]["ReviewCount"].' reviews</span><div class="snapshot hide">
                     <h4>Rating Snapshot</h4>
                     <div class="g-rating-bar inline" data-total="25" data-value="12"><label>5</label><div class="bar">
                           <div class="bg" style="width: 48%;"></div><span class="value">12</span></div>
                     </div>
                     <div class="g-rating-bar inline" data-total="25" data-value="8"><label>4</label><div class="bar">
                           <div class="bg" style="width: 32%;"></div><span class="value">8</span></div>
                     </div>
                     <div class="g-rating-bar inline" data-total="25" data-value="0"><label>3</label><div class="bar">
                           <div class="bg"></div><span class="value">0</span></div>
                     </div>
                     <div class="g-rating-bar inline" data-total="25" data-value="1"><label>2</label><div class="bar">
                           <div class="bg" style="width: 4%;"></div><span class="value">1</span></div>
                     </div>
                     <div class="g-rating-bar inline" data-total="25" data-value="4"><label>1</label><div class="bar">
                           <div class="bg" style="width: 16%;"></div><span class="value">4</span></div>
                     </div>
                  </div>
               </div>
                                
</div>
                                <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-4 overall-ratings">
                                     <div class="g-rating-bar clearfix rating-item" data-total="5" data-value="' . $ratingstuff["Product"]["ValueRating"] . '" data-segments="5"><label>VALUE</label><span class="value">' . $ratingstuff["Product"]["ValueRating"] . '</span><div class="bar">
                                        <div class="bg"></div>
                                        <div class="segments"><div class="segment" style="width:20%"></div><div class="segment" style="width:20%"></div><div class="segment" style="width:20%"></div><div class="segment" style="width:20%"></div><div class="segment" style="width:20%"></div></div></div>
                                    </div>
                                    </div>
                                    <div class="col-md-4 overall-ratings"><div class="g-rating-bar clearfix rating-item" data-total="5" data-value="' . $ratingstuff["Product"]["QualityRating"] . '" data-segments="5"><label>QUALITY</label><span class="value">' . $ratingstuff["Product"]["QualityRating"] . '</span><div class="bar">
                                        <div class="bg"></div>
                                        <div class="segments"><div class="segment" style="width:20%"></div><div class="segment" style="width:20%"></div><div class="segment" style="width:20%"></div><div class="segment" style="width:20%"></div><div class="segment" style="width:20%"></div></div></div>
                                    </div></div>
                                    <div class="col-md-4 overall-ratings">
                                    <div class="g-rating-bar clearfix rating-item" data-total="5" data-value="' .$ratingstuff["Product"]["EaseOfUseRating"] . '" data-segments="5"><label>EASE OF USE</label><span class="value">' . $ratingstuff["Product"]["EaseOfUseRating"] . '</span><div class="bar">
                                        <div class="bg"></div>
                                        <div class="segments"><div class="segment" style="width:20%"></div><div class="segment" style="width:20%"></div><div class="segment" style="width:20%"></div><div class="segment" style="width:20%"></div><div class="segment" style="width:20%"></div></div></div>
                                    </div>
                                    </div>
                                    </div>
                                </div>
                            </div>
                        </section><section id="review-top">
            <div class="col-md-12 review-nav">
                <ul class="filterlist">
                    <li style="color: #9b9b9b; font-weight: bold; text-transform: uppercase; margin-right: 20px;">Filter</li>
                    <li><a href="#star-rating-filter">Star Rating <i class="fas fa-chevron-down"></i></a>
                    </li>
                    <li><a href="#value-rating-filter">Value <i class="fas fa-chevron-down"></i></a></li>
                    <li><a href="#quality-rating-filter">Quality <i class="fas fa-chevron-down"></i></a></li>
                </ul>
            </div>
        </section>
        <section id="reviewdata">';



        $originaldate = $ratingdata["SubmissionTime"];
//    $newDate = date("m-d-Y", strtotime($originaldate));
//

        $ratingGET .= '<section><div class="container rating"  style="margin-bottom: 50px;">
                        <div class="row">
                        <div class="col-md-8 rating-card">
                            <span class="rating-date">' . $newDate . '</span>
                            <h2 class="rating-title">' . $ratingdata["Title"] . '</h2>
                            <div class="input jq-ry-container" data-read-only="true" data-value="' . $ratingdata["Rating"] . '" readonly="readonly" style="width: 96px;"><div class="jq-ry-group-wrapper"><div class="jq-ry-normal-group jq-ry-group"><!--?xml version="1.0" encoding="utf-8"?--><svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 12.705 512 486.59" x="0px" y="0px" xml:space="preserve" width="16px" height="16px" fill="#c2c2c2"><polygon points="256.814,12.705 317.205,198.566 512.631,198.566 354.529,313.435 414.918,499.295 256.814,384.427 98.713,499.295 159.102,313.435 1,198.566 196.426,198.566 "></polygon></svg><!--?xml version="1.0" encoding="utf-8"?--><svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 12.705 512 486.59" x="0px" y="0px" xml:space="preserve" width="16px" height="16px" fill="#c2c2c2" style="margin-left: 4px;"><polygon points="256.814,12.705 317.205,198.566 512.631,198.566 354.529,313.435 414.918,499.295 256.814,384.427 98.713,499.295 159.102,313.435 1,198.566 196.426,198.566 "></polygon></svg><!--?xml version="1.0" encoding="utf-8"?--><svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 12.705 512 486.59" x="0px" y="0px" xml:space="preserve" width="16px" height="16px" fill="#c2c2c2" style="margin-left: 4px;"><polygon points="256.814,12.705 317.205,198.566 512.631,198.566 354.529,313.435 414.918,499.295 256.814,384.427 98.713,499.295 159.102,313.435 1,198.566 196.426,198.566 "></polygon></svg><!--?xml version="1.0" encoding="utf-8"?--><svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 12.705 512 486.59" x="0px" y="0px" xml:space="preserve" width="16px" height="16px" fill="#c2c2c2" style="margin-left: 4px;"><polygon points="256.814,12.705 317.205,198.566 512.631,198.566 354.529,313.435 414.918,499.295 256.814,384.427 98.713,499.295 159.102,313.435 1,198.566 196.426,198.566 "></polygon></svg><!--?xml version="1.0" encoding="utf-8"?--><svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 12.705 512 486.59" x="0px" y="0px" xml:space="preserve" width="16px" height="16px" fill="#c2c2c2" style="margin-left: 4px;"><polygon points="256.814,12.705 317.205,198.566 512.631,198.566 354.529,313.435 414.918,499.295 256.814,384.427 98.713,499.295 159.102,313.435 1,198.566 196.426,198.566 "></polygon></svg></div><div class="jq-ry-rated-group jq-ry-group"><!--?xml version="1.0" encoding="utf-8"?--><svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 12.705 512 486.59" x="0px" y="0px" xml:space="preserve" width="16px" height="16px" fill="rgb(54, 124, 43)"><polygon points="256.814,12.705 317.205,198.566 512.631,198.566 354.529,313.435 414.918,499.295 256.814,384.427 98.713,499.295 159.102,313.435 1,198.566 196.426,198.566 "></polygon></svg><!--?xml version="1.0" encoding="utf-8"?--><svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 12.705 512 486.59" x="0px" y="0px" xml:space="preserve" width="16px" height="16px" fill="rgb(54, 124, 43)" style="margin-left: 4px;"><polygon points="256.814,12.705 317.205,198.566 512.631,198.566 354.529,313.435 414.918,499.295 256.814,384.427 98.713,499.295 159.102,313.435 1,198.566 196.426,198.566 "></polygon></svg><!--?xml version="1.0" encoding="utf-8"?--><svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 12.705 512 486.59" x="0px" y="0px" xml:space="preserve" width="16px" height="16px" fill="rgb(54, 124, 43)" style="margin-left: 4px;"><polygon points="256.814,12.705 317.205,198.566 512.631,198.566 354.529,313.435 414.918,499.295 256.814,384.427 98.713,499.295 159.102,313.435 1,198.566 196.426,198.566 "></polygon></svg><!--?xml version="1.0" encoding="utf-8"?--><svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 12.705 512 486.59" x="0px" y="0px" xml:space="preserve" width="16px" height="16px" fill="rgb(54, 124, 43)" style="margin-left: 4px;"><polygon points="256.814,12.705 317.205,198.566 512.631,198.566 354.529,313.435 414.918,499.295 256.814,384.427 98.713,499.295 159.102,313.435 1,198.566 196.426,198.566 "></polygon></svg><!--?xml version="1.0" encoding="utf-8"?--><svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 12.705 512 486.59" x="0px" y="0px" xml:space="preserve" width="16px" height="16px" fill="rgb(54, 124, 43)" style="margin-left: 4px;"></svg></div></div></div>
                            <span class="rating-text">' . $ratingdata["Rating"] . '/5</span>
                            <p class="rating-text">' . $ratingdata["ReviewText"] . '</p>
                            <h3>Pros</h3>
                                <p class="pro-text">' . $ratingdata["ProsText"] . '</p>
                            <h3>Cons</h3>
                                <p class="con-text">' . $ratingdata["ConsText"] . '</p>
                        </div>
                        
                        <div class="col-md-4 review-card-summary">
                            <strong>' . $ratingdata["AuthorName"] . '</strong>
                            <p class="from-rating">From: ' . $ratingdata["ReviewerLocation"] . '</p>
                            <p class="length-rating">Length of Ownership: ' . $ratingdata["LengthOfOwnership"] . '</p>
                            <p class="usage-rating">Usage Frequency: ' . $ratingdata["UsageFrequency"] . '</p>
                            <p class="expert-rating">Level of Expertise: ' . $ratingdata["LevelOfExpertise"] . '</p>
                            
                            <div class="g-rating-bar clearfix rating-item" data-total="5" data-value="' . $ratingdata["ValueRating"] . '" data-segments="5"><label>VALUE</label><span class="value">' . $ratingdata["ValueRating"] . '</span><div class="bar">
                                <div class="bg"></div>
                                <div class="segments"><div class="segment" style="width:20%"></div><div class="segment" style="width:20%"></div><div class="segment" style="width:20%"></div><div class="segment" style="width:20%"></div><div class="segment" style="width:20%"></div></div></div>
                            </div>
                                          
                            <div class="g-rating-bar clearfix rating-item" data-total="5" data-value="2" data-segments="5"><label>QUALITY</label><span class="value">2</span><div class="bar">
                                <div class="bg"></div>
                                <div class="segments"><div class="segment" style="width:20%"></div><div class="segment" style="width:20%"></div><div class="segment" style="width:20%"></div><div class="segment" style="width:20%"></div><div class="segment" style="width:20%"></div></div></div>
                            </div>
                                        
                            <div class="g-rating-bar clearfix rating-item" data-total="5" data-value="5" data-segments="5"><label>EASE OF USE</label><span class="value">5</span><div class="bar">
                                <div class="bg"></div>
                                <div class="segments"><div class="segment" style="width:20%"></div><div class="segment" style="width:20%"></div><div class="segment" style="width:20%"></div><div class="segment" style="width:20%"></div><div class="segment" style="width:20%"></div></div></div>
                            </div>  
                        </div>
                        
                      </div>
                   </div></section>';


        $ratingGET .= '</section>';
    }

}



//OFFERS START//


//    echo $offersLinkNow . '<br>';
$jsonOffer = $b["offers_link"];
$objOffers = json_decode($jsonOffer, true);


//    echo $objOffers . '<br>';
//
if (is_array($objOffers) && $objOffers["Page"]["special-offers"]["ESIFragments"] != null) {
    if (strpos($objOffers["Page"]["special-offers"]["ESIFragments"], 'https://www.deere.com') !== false) {
        $jsonOfferOut = file_get_contents($objOffers["Page"]["special-offers"]["ESIFragments"], false, stream_context_create($arrContextOptions));
    } else {
        $jsonOfferOut = file_get_contents('https://www.deere.com' . $objOffers["Page"]["special-offers"]["ESIFragments"], false, stream_context_create($arrContextOptions));
    }

    //var_dump($objOffers["Page"]["special-offers"]["ESIFragments"]);
    $content = str_replace('srcset="', 'srcset="https://deere.com', $jsonOfferOut);
    $content = str_replace('img', 'img style="width:100%"', $content);
    $offerZ = $content . '<div class="clearfix"></div>';


    if (strpos($offerZ, 'EXPIRED') !== false) {

    } else {
        $offerZZ .= $offerZ . '<div class="clearfix"></div>';
    }
} else {
    $offerZZ .= '';
}




if ($offerZZ != null) {
    $offerZZa .= '<div class="col-md-12" style="background: #fff">';

    $offerZZa .= '<h2 class="offers-header">Offers and Discounts</h2>';


    $offerZZa .= '<div class="offers-holder">';
    $offerZZa .= $offerZZ;
    $offerZZa .= '</div>';


    $disclaimer = $objOffers["Page"]["disclaimer"]["DisclaimerContainer"]["Description"];
    $offerZZa .= '<span style="font-size:9px; padding-left: 15px; padding-right: 15px;">'.$disclaimer.'</span>';
    $offerZZa .= '</div>';
    ///Store offers in db///



    $offershtml .= $offerZZa;

}


////START ACCESSORIES//



$jsonAssOut = $b["accessories"];
$assAvail = json_decode($jsonAssOut, true);



if(is_null($assAvail["Page"]["expandcollapse"]["Section"]["SectionData"])) {
    $accoutput = '';


} else {

    $accoutput .= '<section id="accsatts" style=" background: #eff0f0;
    padding: 50px 20px;">
            <h3>Accessories and Attachments</h3>';

    $accoutput .= '<div class="panel-group" id="accordion-acc">';

    for ($x = 0; $x < count($assAvail["Page"]["expandcollapse"]["Section"]["SectionData"]); $x++) {

        $accoutput .= '<h4 class="acc-sec-title">' . $assAvail["Page"]["expandcollapse"]["Section"]["SectionData"][$x]["SubTitle"] . '</h4>';

        if (!empty($assAvail["Page"]["expandcollapse"]["Section"]["SectionData"][$x]["Data"][0])) {
            for ($y = 0; $y < count($assAvail["Page"]["expandcollapse"]["Section"]["SectionData"][$x]["Data"]); $y++) {
                if(is_null($assAvail["Page"]["expandcollapse"]["Section"]["SectionData"][$x]["Data"][$y]["Description"])) {
                    $showaccicon = '';
                    $accoutput .= '<div class="heading" style="border-bottom: 1px solid #ccc;">
                       <h4 class="panel-title" style="text-decoration: none; color: black; font-size: 18px; font-weight: 400;">' . $assAvail["Page"]["expandcollapse"]["Section"]["SectionData"][$x]["Data"][$y]["TitleQuestion"] . '</h4>
                   </div>';
                } else {
                    $showaccicon = '<i style="color: #377C2E;"class="fas fa-plus"></i>';

                    $accoutput .= '<div class="panel panel-default">
                   <div class="panel-heading">
                       <h4 class="panel-title">
                           <a class="acc-title" data-toggle="collapse" data-parent="#accordion" href="#acccollapse" style="text-decoration: none; color: black; font-size: 18px; font-weight: 400;">'.$showaccicon.'
                               ' . $assAvail["Page"]["expandcollapse"]["Section"]["SectionData"][$x]["Data"][$y]["TitleQuestion"] . '</a>
                       </h4>
                   </div>             
                   <div id="acccollapse" class="panel-collapse collapse acc-collapse">
                       <div class="panel-body">' . $assAvail["Page"]["expandcollapse"]["Section"]["SectionData"][$x]["Data"][$y]["Description"] . '</div>
                   </div>
               </div>';
                }


            }
        } else {


            $accoutput .= '<div class="panel panel-default">
                   <div class="panel-heading">
                       <h4 class="panel-title">
                           <a class="acc-title" data-toggle="collapse" data-parent="#accordion-acc" href="#acccollapse" style="text-decoration: none; color: black; font-size: 18px; font-weight: 400;"><i style="color: #377C2E;"class="fas fa-plus"></i>
                               ' . $assAvail["Page"]["expandcollapse"]["Section"]["SectionData"][$x]["Data"]["TitleQuestion"] . '</a>
                       </h4>
                   </div>
                   <div id="acccollapse" class="panel-collapse collapse acc-collapse">
                       <div class="panel-body">' . $assAvail["Page"]["expandcollapse"]["Section"]["SectionData"][$x]["Data"]["Description"] . '</div>
                   </div>
               </div>';
        }
    }


    $accoutput .= '</div>';

    $accoutput .= '</section>';

}

if(!empty($accoutput)) {
    $ifacc = 'display: block';
} else {
    $ifacc = 'display: none';
}


if(!empty($offershtml)) {
     $ifoffers = 'display: block';
} else {
    $ifoffers = 'display: none';
}




$ratingOut = $b["rating_data"];





if(!empty($ratingGET)) {
    $ifreviews = 'display: block';
} else {
    $ifreviews = 'display: none';
}

$dealername = 'SunSouth Equipment';
 $manufacturer = 'John Deere';





$output = '<!-- JSON-LD markup generated by Google Structured Data Markup Helper. -->
<div class="row" style="margin-bottom: 10px; padding-left: 15px;">
            <div class="col-md-8 col-sm-12">
                <!--<img src="<?php echo $urlbase.$mainimg;?>" class="img-responsive" alt="product img"/>-->
                '.$imggallery.'
          </div>
            <div class="col-md-4 col-sm-12">
                
                <h1 class="model"><span class="brand">John Deere</span> '.$title.'<br></h1>
                <h2 class="submodel">'.$subtitle.'<br></h2>
                <div class="rating-top" style="'.$ifreviews.'"><div class="input jq-ry-container" data-read-only="true" data-value="'.$rating.'" readonly="readonly" style="width: 96px;"><div class="jq-ry-group-wrapper"><div class="jq-ry-normal-group jq-ry-group"><!--?xml version="1.0" encoding="utf-8"?--><svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 12.705 512 486.59" x="0px" y="0px" xml:space="preserve" width="16px" height="16px" fill="#c2c2c2"><polygon points="256.814,12.705 317.205,198.566 512.631,198.566 354.529,313.435 414.918,499.295 256.814,384.427 98.713,499.295 159.102,313.435 1,198.566 196.426,198.566 "></polygon></svg><!--?xml version="1.0" encoding="utf-8"?--><svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 12.705 512 486.59" x="0px" y="0px" xml:space="preserve" width="16px" height="16px" fill="#c2c2c2" style="margin-left: 4px;"><polygon points="256.814,12.705 317.205,198.566 512.631,198.566 354.529,313.435 414.918,499.295 256.814,384.427 98.713,499.295 159.102,313.435 1,198.566 196.426,198.566 "></polygon></svg><!--?xml version="1.0" encoding="utf-8"?--><svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 12.705 512 486.59" x="0px" y="0px" xml:space="preserve" width="16px" height="16px" fill="#c2c2c2" style="margin-left: 4px;"><polygon points="256.814,12.705 317.205,198.566 512.631,198.566 354.529,313.435 414.918,499.295 256.814,384.427 98.713,499.295 159.102,313.435 1,198.566 196.426,198.566 "></polygon></svg><!--?xml version="1.0" encoding="utf-8"?--><svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 12.705 512 486.59" x="0px" y="0px" xml:space="preserve" width="16px" height="16px" fill="#c2c2c2" style="margin-left: 4px;"><polygon points="256.814,12.705 317.205,198.566 512.631,198.566 354.529,313.435 414.918,499.295 256.814,384.427 98.713,499.295 159.102,313.435 1,198.566 196.426,198.566 "></polygon></svg><!--?xml version="1.0" encoding="utf-8"?--><svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 12.705 512 486.59" x="0px" y="0px" xml:space="preserve" width="16px" height="16px" fill="#c2c2c2" style="margin-left: 4px;"><polygon points="256.814,12.705 317.205,198.566 512.631,198.566 354.529,313.435 414.918,499.295 256.814,384.427 98.713,499.295 159.102,313.435 1,198.566 196.426,198.566 "></polygon></svg></div><div class="jq-ry-rated-group jq-ry-group"><!--?xml version="1.0" encoding="utf-8"?--><svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 12.705 512 486.59" x="0px" y="0px" xml:space="preserve" width="16px" height="16px" fill="rgb(54, 124, 43)"><polygon points="256.814,12.705 317.205,198.566 512.631,198.566 354.529,313.435 414.918,499.295 256.814,384.427 98.713,499.295 159.102,313.435 1,198.566 196.426,198.566 "></polygon></svg><!--?xml version="1.0" encoding="utf-8"?--><svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 12.705 512 486.59" x="0px" y="0px" xml:space="preserve" width="16px" height="16px" fill="rgb(54, 124, 43)" style="margin-left: 4px;"><polygon points="256.814,12.705 317.205,198.566 512.631,198.566 354.529,313.435 414.918,499.295 256.814,384.427 98.713,499.295 159.102,313.435 1,198.566 196.426,198.566 "></polygon></svg><!--?xml version="1.0" encoding="utf-8"?--><svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 12.705 512 486.59" x="0px" y="0px" xml:space="preserve" width="16px" height="16px" fill="rgb(54, 124, 43)" style="margin-left: 4px;"><polygon points="256.814,12.705 317.205,198.566 512.631,198.566 354.529,313.435 414.918,499.295 256.814,384.427 98.713,499.295 159.102,313.435 1,198.566 196.426,198.566 "></polygon></svg><!--?xml version="1.0" encoding="utf-8"?--><svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 12.705 512 486.59" x="0px" y="0px" xml:space="preserve" width="16px" height="16px" fill="rgb(54, 124, 43)" style="margin-left: 4px;"><polygon points="256.814,12.705 317.205,198.566 512.631,198.566 354.529,313.435 414.918,499.295 256.814,384.427 98.713,499.295 159.102,313.435 1,198.566 196.426,198.566 "></polygon></svg><!--?xml version="1.0" encoding="utf-8"?--><svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 12.705 512 486.59" x="0px" y="0px" xml:space="preserve" width="16px" height="16px" fill="rgb(54, 124, 43)" style="margin-left: 4px;"></svg></div></div></div>
                <span class="number-reviews">'.$numratings.'</span>
                <div class="new-write-review-button" style="display: none;"><a class="cta button3 btn-write-review new-write-review-button-link" href="#" aria-label=" - 1023E" data-linkid="cta-3 :  : write-a-review" data-linktype="internal-defer">Write a Review<i style="padding-left: 10px;" class="fas fa-angle-right"></i></a></div>
                </div><div class="clearfix"></div>'.$productsummary.'
                '.$pricepresent.'<br>'.$html.'
            </div>
            <div class="clearfix"></div>
            <br><br><div class="seo-text col-md-8"><h2 style="text-align: center; font-size:1.5rem;">The '.$dealername.' <span style="font-family: \'Kaushan Script\', cursive; font-size: 2.5rem;">Promise</span></h2><p>'.$dealername.' is proud to offer the '.$manufacturer.' '.$title.' at a competitive price and back it with reliable and affordable service throughout its lifespan of service.  From initial purchasing consultations to make sure that the '.$manufacturer.' '.$title.' is the best product for your needs to financing, purchasing and final delivery, '.$dealername.' will work to provide you with the highest level of customer service and product support. Once you put it in service, you can always rely on '.$dealername.' to provide ongoing warranty and aftermarket parts and service to keep your property and your new '.$title.' as productive as possible. </p></div>
        </div>';

    if($b["videos"] != '') {
        $ifvideos = "display: block";
    } else {
        $ifvideos = 'display: none;';
    }



$output .= '<section id="new-equip-tabs">
        <div class="row"  style="margin-bottom: 10px; padding-left: 15px;">
            <ul id="new-navbar" class="nav nav-tabs">
                <li class="nav-item">
                    <a class="nav-link" href="#features">Features</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#specs">Specifications</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#offers-discounts" style="'.$ifoffers.'">Offers & Discounts</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#accsatts" style="'.$ifacc.'">Accessories & Attachments</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#reviewdata" style="'.$ifreviews.'">Reviews</a>
                </li>
                 <li class="nav-item">
                    <a class="nav-link" href="#videos" style="'.$ifvideos.'">Videos</a>
                </li>
            </ul>
        </div>
        </section>';

$output .= '
       <section id="features">
           <div class="container-fluid">
               <h3>Features</h3>
           <div class="row"  style="margin-bottom: 10px; padding-left: 15px;">
               <br><br>
           '.$featureoutput.'

           </div>
           </div>
       </section>';



$output .= '<section id="specs" style="padding-left:15px;">
            <h2>Specifications</h2><br>
            <div class="selection-option" style="'.$ifspecs.'" >
            <p>Compare the specifications of up to 4 models</p>
           <div class="row"  style="margin-bottom: 10px;">
           <div class="col-md-3">
           '.$specoptions.'
           '.$spechtml.'
        </section>';

$output .= '<section id="offers-discounts">
        '.$offershtml.'
        </section>';

$output .= $accoutput;

$output .= '<section id="videos"  style="margin-bottom: 10px;">'.$b["videos"].'</section>';


$output .= $ratingGET;

$output .= '<input type="hidden" id="product" name="product" value="'.$title.'"/>
            <input type="hidden" id="brand" name="brand" value="John Deere"/>
             <input type="hidden" id="schemaimg" name="schemaimg" value="'.$schemaimg.'"/>   
            <input type="hidden" id="description" name="description" value="'.$dealername.' is proud to offer the '.$manufacturer.' '.$title.' at a competitive price and back it with reliable and affordable service throughout its lifespan of service.  From initial purchasing consultations to make sure that the '.$manufacturer.' '.$title.' is the best product for your needs to financing, purchasing and final delivery, '.$dealername.' will work to provide you with the highest level of customer service and product support. Once you put it in service, you can always rely on '.$dealername.' to provide ongoing warranty and aftermarket parts and service to keep your property and your new '.$title.' as productive as possible."/>
             <input type="hidden" id="price" name="price" value="'.$productprice.'"/>
             <input type="hidden" id="ratingval" name="ratingval" value="'.$rating.'"/>
              <input type="hidden" id="ratingcount" name="ratingcount" value="'.$numratings.'"/>
';


//$output .= '<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script><script>$(document).ready(function(){
//       var el = document.createElement(\'script\');
//       el.type = \'application/ld+json\';
//       el.text = JSON.stringify({ "@context" : "http://schema.org",
//  "@type" : "Product",
//  "name" : "E100",
//  "image" : "http://deere-view.bcssdevelop.com/inc/api/equip_imgs/E100_SEOVAL.jpg",
//  "description" : "SunSouth Equipment is proud to offer the John Deere E100 at a competitive price and back it with reliable and affordable service throughout its lifespan of service.  From initial purchasing consultations to make sure that the John Deere E100 is the best product for your needs to financing, purchasing and final delivery, SunSouth Equipment will work to provide you with the highest level of customer service and product support. Once you put it in service, you can always rely on SunSouth Equipment to provide ongoing warranty and aftermarket parts and service to keep your property and your new E100 as productive as possible.",
//  "brand" : {
//    "@type" : "Brand",
//    "name" : "John Deere"
//  },
//  "offers" : {
//    "@type" : "Offer",
//    "price" : "1,599.00"
//  },
//  "aggregateRating" : {
//    "@type" : "AggregateRating",
//    "ratingValue" : "2.85",
//    "ratingCount" : "13" }});
//
//document.querySelector(\'head\').appendChild(el);
//});</script>';








?>



<!doctype html>
<html lang="en" xmlns="http://www.w3.org/1999/html">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.8.2/css/all.min.css">
    <link rel="stylesheet" href="css/lightslider.css">
    <link rel="stylesheet" href="css/jquery.paginate.css">
    <link href="https://fonts.googleapis.com/css?family=Kaushan+Script&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/main.css">
    <title>New Equipment</title>
</head>
<body>
    <div class="container-fluid" style="padding-left: 0px; padding-right: 0px;">


    <?php

echo $output
    ?>

    </div>
<footer>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/lightslider.js"></script>
    <script src="js/new-output.js"></script>
    <script src="js/jquery.paginate.js"></script>
    <script src="js/owl_carousel_min.js"></script>
    <script src="js/jquery.jcarousel.js"></script>
    <script src="js/jcarousel.responsive.js"></script>


</footer>
    <script>
        $(function(){
            $('.myCarousel').carousel()
        });
    </script>
</body>
</html>