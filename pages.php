<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
class deere_equipment
{
    function page($page)
    {


        include('inc/config.php');

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
        $equipLink = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

//get last part of url which will contain the model of the equipment//
        $equipBase = basename($equipLink);

//get current timestamp//
        $date = time();


        if (isset($_SESSION["target_ads"])) {


            //unbind the session data and add new viewable object here//

            //convert back to workable php array//
            $session = json_decode($_SESSION["target_ads"], true);

           // var_dump($session);

            $ip = $session["ip"];

           // $eqipinf = $session["equipinfo"];
           // var_dump($eqipinf);
//function to go through array object for duplicates//
            function in_array_r_deere($item, $array)
            {
                return preg_match('/"' . preg_quote($item, '/') . '"/i', json_encode($array));
            }


            //check for dups//
            if (in_array_r_deere($equipBase, $session)) {
                ///DONT ADD A THING///
            } else {
                $eqipInfor[] = array("equiplink" => $equipLink, "equipbase" => $equipBase, "capture_date" => $date, "image" => $image, "cat_one" => $cat_one, "cat_two" => $cat_two, "cat_three" => $cat_three,"sub_title" => $sub_title , "parent_cat" => $parent_cat, "equip_link" => $equip_link);
            }

          //  var_dump($eqipInfor);

           // echo $equipBase;


            //go through array and break apart//
            for ($i = 0; $i < count($eqipInfor); $i++) {
                if ($i < 10) {
                    $a = $data->query("SELECT * FROM deere_equipment WHERE title ='$equipBase' AND active = 'true'") or die($data->error);
                    if ($a->num_rows > 0) {
                        //PAGE EXISTS//
                        $b = $a->fetch_array();

                        $image = str_replace('"', '', $b["eq_image"]);
                        $parent_cat = $b["parent_cat"];
                        $cat_one = $b["cat_one"];
                        $cat_two = $b["cat_two"];
                        $cat_three = $b["cat_three"];
                        $equip_link = $b["site_link"];
                        $sub_title = $b["sub_title"];
                        //echo "This is ".$image;

                        //add new item and remove old shit//

                        $eqipInfo[] = array("equiplink" => $eqipInfor[$i]["equiplink"], "equipbase" => $eqipInfor[$i]["equipbase"], "capture_date" => $eqipInfor[$i]["capture_date"], "image" => $image, "parent_cat" => $eqipInfor[$i]["parent_cat"], "cat_one" => $eqipinf[$i]["cat_one"],
                            "cat_two" => $eqipInfor[$i]["cat_two"], "cat_three" => $eqipInfor[$i]["cat_three"], "equip_link" => $eqipInfor[$i]["equip_link"]);

                        //  var_dump($eqipInfo);

//                        echo $equipBase;


//                        $c = $data->query("SELECT * FROM used_equipment WHERE model = '$equipBase' AND active = 'true'");
//
//                        $count = $c->num_rows;
//                        //echo $count;
//
//                        if ($count == 0) {
//                            $usedCar = '';
//                        } else
//                            if ($count == 1) {
//                                $d = $c->fetch_array();
//
//                                $link = str_replace(' ', '-', $d["category"]) . '/' . str_replace(' ', '-', $d["manufacturer"]) . '-' . str_replace(' ', '-', $d["model"]) . '-' . $d["id"];
//
//                                $image = stripslashes($d["images"]);
//                                $image = str_replace('(', '', $image);
//                                $image = str_replace(')', '', $image);
//                                $image = json_decode($image, true);
//                                $imageOut = $image["image"][0]["filePointer"];
//                                //echo $imageOut;
//                                $price = $d['ad_price'];
//                                $obj = json_decode($price, true);
//
//                                // var_dump($obj);
//                                $price = $d['ad_price'];
//                                $ad_price = $obj['amount'];
//
//                                if ($imageOut != '') {
//                                    $imageOut = $imageOut;
//                                } else {
//                                    $imageOut = 'img/No_Image_Available.jpg';
//                                }
//
//                                $usedCar = '<h4 style="font-size: 1rem; color: #336633; font-weight: bold;">USED EQUIPMENT YOU MAY LIKE</h4>';
//                                $usedCar .= '<div><a href="Used-Equipment/' . $link . '"><img style="width: 250px; max-height: 180px;" src=' . $imageOut . '></a><p style="text-align: center; font-size: medium; background:  #333; color: white; width: 250px;">' . $d['modelYear'] . ' ' . $d["model"] . ' - $' . number_format($ad_price, 2, ".", ",") . '</p></div>';
//
//                            } else {
//
//                                $usedCar = '<h4 style="font-size: 1rem; color: #336633; font-weight: bold;">USED EQUIPMENT YOU MAY LIKE</h4><div class="flipster"><ul class="flip-items">';
//
//
//                                // echo 'true';
//                                while ($d = $c->fetch_array()) {
//
//                                    $model = $d['model'];
//                                    $price = $d['ad_price'];
//                                    $year = $d['modelYear'];
//                                    $obj = json_decode($price, true);
//
//                                    // var_dump($obj);
//                                    $ad_price = $obj['amount'];
//
//
//                                    $image = stripslashes($d["images"]);
//                                    $image = str_replace('(', '', $image);
//                                    $image = str_replace(')', '', $image);
//                                    $image = json_decode($image, true);
//                                    $imageOut = $image["image"][0]["filePointer"];
//                                    //echo $imageOut;
//
//                                    if ($imageOut != '') {
//                                        $imageOut = $imageOut;
//                                    } else {
//                                        $imageOut = 'img/No_Image_Available.jpg';
//                                    }
//
//                                    $link = str_replace(' ', '-', $d["category"]) . '/' . str_replace(' ', '-', $d["manufacturer"]) . '-' . str_replace(' ', '-', $d["model"]) . '-' . $d["id"];
//
//                                    $usedCar .= '<li><a href="Used-Equipment/' . $link . '"><img style="width: 250px; max-height: 180px;" src=' . $imageOut . '></a><p style="text-align: center; font-size: medium; background:  #333; color: white;">' . $year . ' ' . $d["model"] . ' - $' . number_format($ad_price, 2, ".", ",") . '</p></li>';
//
//                                }
//
//                                $usedCar .= '</ul></div>';
//
//                            }
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
            //var_dump($eqipData);


        } else {

            //echo 'false';
            //set the data for the first time//
            $eqipInfo[] = array("equiplink" => $equipLink, "equipbase" => $equipBase, "capture_date" => $date , "image" => $image , "cat_one" => $cat_one, "cat_two" => $cat_two, "cat_two", $cat_three, "cat_three", $parent_cat, "parent_cat");
            $eqipData = array("ip" => $ip, "equipinfo" => $eqipInfo);

            //encode to json string//
            $eqipData = json_encode($eqipData);

            //create the sesson//
            $_SESSION["target_ads"] = $eqipData;



        }

///////////ABOVE TARGET ADS////////



        $a = $data->query("SELECT * FROM deere_equipment WHERE title = '$page'");
        if ($a->num_rows > 0) {
            //ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

            error_reporting(E_ERROR | E_PARSE);


            $arrContextOptions = array(
                "ssl"=>array(
                    "verify_peer"=>false,
                    "verify_peer_name"=>false,
                ),
            );

//$response = file_get_contents("https://www.deere.com/en/tractors/compact-tractors/1-series-sub-compact-tractors/1025r/index.json", false, stream_context_create($arrContextOptions));
//$response = file_get_contents("https://www.deere.com/en/articulated-dump-trucks/260e/index.json", false, stream_context_create($arrContextOptions));
//$response = file_get_contents("https://www.deere.com/en/mowers/zero-turn-mowers/z300-series/z335e-ztrak-mower/index.json", false, stream_context_create($arrContextOptions));

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
                $schemaimg = 'img/equip_images/' . $imgdecode[0];
                $imggallery = '<ul id="lightSlider">';

                for ($o = 0; $o < count($imgdecode); $o++) {


                    $imgpath = $imgdecode[$o];
                    $imgthumb = $imgdecode[$o];
                    $imggallery .= '<li data-thumb="img/equip_images/' . $imgpath . '" ><img src="img/equip_images/' . $imgpath . '" class="img-responsive fadeIn"/></li>';
                }




                $imggallery .= '</ul>';

            } else {

                $imgpath = $imgdecode[0];
                $imggallery = '<img src="img/equip_images/'.$imgpath.'" class="img-responsive"/>';

                $schemaimg = 'img/equip_images/'.$imgpath;


            }

            $title = $b["title"];
            $subtitle =$b["sub_title"];
            $mainimg = $b["eq_image"][0];
            $ctatext = $b["cta_text"];

            $features = $b["features"];

            $featuredata = json_decode($features, true);

            $featurelist = '';

            for ($i = 0; $i < count($featuredata["Page"]["expandcollapse"]["Section"]["SectionData"]["Data"]); $i++) {
                $featuredetails = $featuredata["Page"]["expandcollapse"]["Section"]["SectionData"]["Data"][$i]["Description"];
                $featuretitle = $featuredata["Page"]["expandcollapse"]["Section"]["SectionData"]["Data"][$i]["TitleQuestion"];



                $featurelist .= '<div class="panel panel-default">
                   <div class="panel-heading">
                       <h4 class="panel-title">
                           <a data-toggle="collapse" data-parent="#accordion" href="#collapse'.$i.'" style="text-decoration: none; color: black; font-size: 18px; font-weight: 400;"><i style="color: #377C2E;"class="fa fa-plus"></i>
                               '.$featuretitle.'</a>
                       </h4>
                   </div>
                   <div id="collapse'.$i.'" class="panel-collapse collapse">
                       <div class="panel-body"> '.str_replace('http', 'https',$featuredetails).'</div>
                   </div>
               </div>';



            }

            $featureoutput = '<div class="panel-group" id="accordion" style="width: 100%;">'.$featurelist.'</div>';



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



//
//            echo '<pre>';
////var_dump($relatedmods);
//
//            echo '</pre>';

            $specz = $specdata["Page"]["specifications"]["Category"];
            $spechtml .= '<div class="table-responsive"><table id="specs-table" class="table table-striped">';
            for($i = 0; $i < count($specz); $i++){
                //$html .= '<div style="background: #efefef; padding: 20px; margin: 20px"><strong>'.$specz[$i]["Name"].'</strong><br>';

                if($i == 0){
                    $spechtml .= '<tr class="rowdata"><th style="border:solid thin #b3afaf"><strong>'.$specz[$i]["Name"].'</strong></th><th style="border:solid thin #b3afaf" class="first-compare"> '.$title.'<br><span style="font-weight: 300">Current Model</span></th></tr>';
                }else{
                    if($specz[$i]["Name"] == "Additional information") {

                    } else {
                        $spechtml .= '<tr class="table_head"><th style=""><strong>' . $specz[$i]["Name"] . '</strong></th><th style="" class="first-compare"></th></tr>';
                    }
                }

                $specks = $specz[$i]["Specs"];
                if(!empty($specks)) {
                    for ($j = 0; $j < count($specks); $j++) {

                        if($specz[$i]["Name"] == "Additional information") {

                        }else {
                            $spechtml .= '<tr class="rowdata"><td style="border:solid thin #b3afaf"><strong>' . $specks[$j]["Name"] . '</strong></td><td style="border:solid thin #b3afaf">' . $specks[$j]["CurrentModelDescription"] . '</td></tr>';
                        }
                    }
                }



            }

            $spechtml .= '</table></div>';



            if(is_null($getoptid  = $specdata["Page"]["specifications"]["RelatedModels"][0]["ID"])) {
                $ifspecs = 'display: none';
            } else {
                $ifspecs = 'display: block';
            }

            $specoptions = '<select class="form-control" id="comp-options" name="comp-options"  data-equipid="'.$b["id"].'"><option disabled selected>Select Models To Compare</option>';

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
            $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";



            if (is_null($ratingdata)) {
                $ratingGET = '';
            } else {
                if(!empty($ratingstuff["Review"][0])) {


                    $ratingGET .= '<h2>Reviews</h2><section id="review-overall">
                            <div class="row">
                                <div class="col-md-6">
                                <div class="rate-input max-width text-xs-center text-md-left reviews-summary" itemtype="http://schema.org/AggregateRating" itemscope="itemscope" itemprop="aggregateRating"><span class="large-value align" itemprop="ratingValue">'.floatval(number_format($ratingstuff["Product"]["Rating"], 2)).'</span><div class="input large jq-ry-container" data-read-only="true" data-value="'.$ratingstuff["Product"]["Rating"].'" readonly="readonly" style="width: 136px;"><div class="jq-ry-group-wrapper"><div class="jq-ry-normal-group jq-ry-group"><!--?xml version="1.0" encoding="utf-8"?--><svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 12.705 512 486.59" x="0px" y="0px" xml:space="preserve" width="24px" height="24px" fill="#c2c2c2"><polygon points="256.814,12.705 317.205,198.566 512.631,198.566 354.529,313.435 414.918,499.295 256.814,384.427 98.713,499.295 159.102,313.435 1,198.566 196.426,198.566 "></polygon></svg><!--?xml version="1.0" encoding="utf-8"?--><svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 12.705 512 486.59" x="0px" y="0px" xml:space="preserve" width="24px" height="24px" fill="#c2c2c2" style="margin-left: 4px;"><polygon points="256.814,12.705 317.205,198.566 512.631,198.566 354.529,313.435 414.918,499.295 256.814,384.427 98.713,499.295 159.102,313.435 1,198.566 196.426,198.566 "></polygon></svg><!--?xml version="1.0" encoding="utf-8"?--><svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 12.705 512 486.59" x="0px" y="0px" xml:space="preserve" width="24px" height="24px" fill="#c2c2c2" style="margin-left: 4px;"><polygon points="256.814,12.705 317.205,198.566 512.631,198.566 354.529,313.435 414.918,499.295 256.814,384.427 98.713,499.295 159.102,313.435 1,198.566 196.426,198.566 "></polygon></svg><!--?xml version="1.0" encoding="utf-8"?--><svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 12.705 512 486.59" x="0px" y="0px" xml:space="preserve" width="24px" height="24px" fill="#c2c2c2" style="margin-left: 4px;"><polygon points="256.814,12.705 317.205,198.566 512.631,198.566 354.529,313.435 414.918,499.295 256.814,384.427 98.713,499.295 159.102,313.435 1,198.566 196.426,198.566 "></polygon></svg><!--?xml version="1.0" encoding="utf-8"?--><svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 12.705 512 486.59" x="0px" y="0px" xml:space="preserve" width="24px" height="24px" fill="#c2c2c2" style="margin-left: 4px;"><polygon points="256.814,12.705 317.205,198.566 512.631,198.566 354.529,313.435 414.918,499.295 256.814,384.427 98.713,499.295 159.102,313.435 1,198.566 196.426,198.566 "></polygon></svg></div><div class="jq-ry-rated-group jq-ry-group"><!--?xml version="1.0" encoding="utf-8"?--><svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 12.705 512 486.59" x="0px" y="0px" xml:space="preserve" width="24px" height="24px" fill="rgb(54, 124, 43)"><polygon points="256.814,12.705 317.205,198.566 512.631,198.566 354.529,313.435 414.918,499.295 256.814,384.427 98.713,499.295 159.102,313.435 1,198.566 196.426,198.566 "></polygon></svg><!--?xml version="1.0" encoding="utf-8"?--><svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 12.705 512 486.59" x="0px" y="0px" xml:space="preserve" width="24px" height="24px" fill="rgb(54, 124, 43)" style="margin-left: 4px;"><polygon points="256.814,12.705 317.205,198.566 512.631,198.566 354.529,313.435 414.918,499.295 256.814,384.427 98.713,499.295 159.102,313.435 1,198.566 196.426,198.566 "></polygon></svg><!--?xml version="1.0" encoding="utf-8"?--><svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 12.705 512 486.59" x="0px" y="0px" xml:space="preserve" width="24px" height="24px" fill="rgb(54, 124, 43)" style="margin-left: 4px;"><polygon points="256.814,12.705 317.205,198.566 512.631,198.566 354.529,313.435 414.918,499.295 256.814,384.427 98.713,499.295 159.102,313.435 1,198.566 196.426,198.566 "></polygon></svg><!--?xml version="1.0" encoding="utf-8"?--><svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 12.705 512 486.59" x="0px" y="0px" xml:space="preserve" width="24px" height="24px" fill="rgb(54, 124, 43)" style="margin-left: 4px;"><polygon points="256.814,12.705 317.205,198.566 512.631,198.566 354.529,313.435 414.918,499.295 256.814,384.427 98.713,499.295 159.102,313.435 1,198.566 196.426,198.566 "></polygon></svg><!--?xml version="1.0" encoding="utf-8"?--><svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 12.705 512 486.59" x="0px" y="0px" xml:space="preserve" width="24px" height="24px" fill="rgb(54, 124, 43)" style="margin-left: 4px;"><polygon points="256.814,12.705 317.205,198.566 512.631,198.566 354.529,313.435 414.918,499.295 256.814,384.427 98.713,499.295 159.102,313.435 1,198.566 196.426,198.566 "></polygon></svg></div></div></div><br><meta itemprop="bestRating" content="5">
                  <meta itemprop="reviewCount" content="25"><span class="align">'.$ratingstuff["Product"]["ReviewCount"].' reviews</span><div class="snapshot hide">
                     <h4>Rating Snapshot</h4>
                     <div class="g-rating-bar inline" data-total="'.$ratingstuff["Product"]["ReviewCount"].'" data-value="'.$ratingstuff["Product"]["ReviewCount5"].'"><label>5</label><div class="bar">
                           <div class="bg" ></div><span class="value">'.$ratingstuff["Product"]["ReviewCount5"].'</span></div>
                     </div>
                     <div class="g-rating-bar inline" data-total="'.$ratingstuff["Product"]["ReviewCount"].'" data-value="'.$ratingstuff["Product"]["ReviewCount4"].'"><label>4</label><div class="bar">
                           <div class="bg"></div><span class="value">'.$ratingstuff["Product"]["ReviewCount4"].'</span></div>
                     </div>
                     <div class="g-rating-bar inline" data-total="'.$ratingstuff["Product"]["ReviewCount"].'" data-value="'.$ratingstuff["Product"]["ReviewCount3"].'"><label>3</label><div class="bar">
                           <div class="bg"></div><span class="value">'.$ratingstuff["Product"]["ReviewCount3"].'</span></div>
                     </div>
                     <div class="g-rating-bar inline" data-total="'.$ratingstuff["Product"]["ReviewCount"].'" data-value="'.$ratingstuff["Product"]["ReviewCount2"].'"><label>2</label><div class="bar">
                           <div class="bg"></div><span class="value">'.$ratingstuff["Product"]["ReviewCount3"].'</span></div>
                     </div>
                     <div class="g-rating-bar inline" data-total="'.$ratingstuff["Product"]["ReviewCount"].'" data-value="'.$ratingstuff["Product"]["ReviewCount1"].'"><label>1</label><div class="bar">
                           <div class="bg"></div><span class="value">'.$ratingstuff["Product"]["ReviewCount1"].'</span></div>
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

// $jsonOfferOut = file_get_contents($objOffers["Page"]["special-offers"]["ESIFragments"], false, stream_context_create($arrContextOptions));
            $lastTime = intval($b["last_updated"]);
                $equiplink = $b["equip_link"];
                $equipname = $b["title"];


                $originallinkjson = file_get_contents($equiplink, false, stream_context_create($arrContextOptions));

                $decodeorg = json_decode($originallinkjson, true);

                $brochlink = $decodeorg["Page"]["product-summary"]["OptionalLinks"][1]["LinkUrl"];

                $apiprice = $decodeorg["Page"]["product-summary"]["ProductPrice"];

                // update price in db if date is greater than 10 days

            $lastupdate = $b["last_updated"];
            $datenow = time();
            $datediff = $datenow - $lastupdate;
            $numofdays = round($datediff / (60 * 60 * 24));
            $apipricestatus = $b["api_price_active"];
            $extra = $b["extra_content"];

            //echo $numofdays;

          //  echo $apipricestatus;
//
//
//            if($numofdays > 10 && $apipricestatus == 'true') {
//              //  echo 'true';
//                $time = time();
//                // echo 'time to update';
//                include('inc/config.php');
//                $data->query("UPDATE deere_equipment SET price = '$apiprice', last_updated = '$time' WHERE title ='$equipname'");
//
//                echo $apiprice;
//            } else {
//
//            }
//
//
//
//                if($b["api_price_active"] == 'true') {
//                    $theprice = $apiprice;
//                }
//                else {
//                    $theprice = $b["price"];
//                    $theprice = 'PRICE';
//                }

                    $theprice = $b["price"];



                    if($theprice != '' && $b["dealer_price"] != '') {
                        $pricepresent = '<span class="startingat">Starting At:</span><span style="color:red;text-decoration:line-through"><span class="equipprice" style="color: red;">' . $theprice . '</span></span><br><span class="startingat">Dealer Price:</span><span class="equipprice">' . $b["dealer_price"] . '</span>';
                        $ifcart = '<button class="btn btn-dark save-later" data-eqid="'.$b["id"].'" data-eqname="'.$b["title"].'" data-eqtype="deere" data-price="'.$b["price"].'" data-url="'.$actual_link.'"> Add To Cart <i class="fa fa-shopping-cart"></i></button>';
                    } elseif($theprice != '') {
                        $pricepresent = '<span class="startingat">Starting At:</span><span class="equipprice">' . $theprice .'</span>';
                        $ifcart = '<button class="btn btn-dark save-later" data-eqid="'.$b["id"].'" data-eqname="'.$b["title"].'" data-eqtype="deere" data-price="'.$b["price"].'" data-url="'.$actual_link.'"> Add To Cart <i class="fa fa-shopping-cart"></i></button>';
                    } else {
                        $pricepresent = '';
                        $ifcart = '';
                    }
//                echo '<pre>';
//
//                var_dump($decodeorg["Page"]["product-summary"]["OptionalLinks"][1]["LinkUrl"]);
//
//                echo '</pre>';



                 $offerlinkform = preg_replace('#[^/]*$#', '', $equiplink).'offers-json.html';


                 $offers = file_get_contents($offerlinkform, false, stream_context_create($arrContextOptions));

//                 var_dump($offers);





                $offerstags = str_replace('<esi:assign name="jsonincludedata">', '', $offers);
                $offerstags = str_replace('</esi:assign>', '', $offerstags);


                $offerstags = str_replace('\'', '"', $offerstags);

                $offersOut = json_decode($offerstags, true);

//                var_dump($offersOut);

                $finnalyOfffers = $offersOut["values"][0]["offers"];




                $q = 0;
                foreach ($finnalyOfffers as $offerlink) {


                    $offerLinkClean = str_replace('/html/deere/us/', '', $offerlink);
                    $offersLinkNow = 'https://www.deere.com/' . $offerLinkClean . '/index.json';

                    $jsonOffer = file_get_contents($offersLinkNow, false, stream_context_create($arrContextOptions));
                    $objOffers = json_decode($jsonOffer, true);


                    $today = strtotime("today midnight");

//                    var_dump($offersLinkNow);


                    if(is_null($objOffers["Page"]["special-offers"]["OfferEndDate"])) {
                        $enddate = $objOffers["Page"]["special-offers"]["special-offers"][1]["OfferEndDate"];
                    } else {
                        $enddate = $objOffers["Page"]["special-offers"]["OfferEndDate"];
                    }

//                    var_dump($enddate);

                    if ($today >= strtotime($enddate)) {
//                        echo "expired";
                    } else {
//                        echo "active";


                        if (is_array($objOffers["Page"]["special-offers"])) {
                            if (is_array($objOffers["Page"]["special-offers"]["special-offers"])) {
                                $jsonOfferOut = file_get_contents('https://www.deere.com' . $objOffers["Page"]["special-offers"]["special-offers"][1]["ESIFragments"], false, stream_context_create($arrContextOptions));
//                                var_dump($jsonOfferOut);
                            } else {
                                $jsonOfferOut = file_get_contents('https://www.deere.com' . $objOffers["Page"]["special-offers"]["ESIFragments"], false, stream_context_create($arrContextOptions));
//                                var_dump($jsonOfferOut);
                            }


                            $disclaimer .= $objOffers["Page"]["disclaimer"]["DisclaimerContainer"]["Description"];

//                        echo '<pre>';
//
//                        var_dump($objOffers["Page"]["disclaimer"]["DisclaimerContainer"]);
//
//                        echo '</pre>';

                            //var_dump($objOffers["Page"]["special-offers"]["ESIFragments"]);
                            $content = str_replace('srcset="', 'srcset="https://deere.com', $jsonOfferOut);
                            $content = str_replace('/en/', 'https://www.deere.com/en/', $content);
                            $content = str_replace('img', 'img style="width:100%"', $content);
                            $offerZ = $content . '<div class="clearfix"></div>';


                            if (strpos($offerZ, 'EXPIRED') !== false) {

                            } else {
                                $offerZZ .= $offerZ . '<div class="clearfix"></div>';
                            }


                        } else {
                            $offerZZ .= '';
                        }
                        $q = 1;

//                    }
                    }

                }


                if ($offerZZ != null) {
                    $offerZZa .= '<div class="col-md-12" style="background: #fff">';

                    $offerZZa .= '<h1 class="offers-header">Offers and Discounts</h1>';


                    $offerZZa .= '<div class="offers-holder">';
                    $offerZZa .= $offerZZ;
                    $offerZZa .= '</div>';

                    $offerZZa .= '</div>';
                    $offerZZa .= '<div class="disclaimers" style="font-size: .7rem; padding: 20px;">'.$disclaimer.'</div>';

                    ///Store offers in db///
//                    $data->query("UPDATE deere_equipment SET offers_storage = '".$data->real_escape_string($offerZZa)."' WHERE id = '".$id."'");

                    $offershtml .= $offerZZa;
                }





            $jsonAssOut = $b["accessories"];
            $assAvail = json_decode($jsonAssOut, true);



            if(is_null($assAvail["Page"]["expandcollapse"]["Section"]["SectionData"])) {
                $accoutput = '';


            } else {

                $accoutput .= '<section id="accsatts" name="accsatts" style=" background: #eff0f0; padding: 50px 20px;">
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
                                $showaccicon = '<i style="color: #377C2E;"class="fa fa-plus"></i>';

                                $accoutput .= '<div class="panel panel-default">
                   <div class="panel-heading">
                       <h4 class="panel-title">
                           <a class="acc-title" data-toggle="collapse" data-parent="#accordion" href="#acccollapse" style="text-decoration: none; color: black; font-size: 18px; font-weight: 400;">'.$showaccicon.'
                               ' . $assAvail["Page"]["expandcollapse"]["Section"]["SectionData"][$x]["Data"][$y]["TitleQuestion"] . '</a>
                       </h4>
                   </div>             
                   <div id="acccollapse" class="panel-collapse collapse acc-collapse">
                       <div class="panel-body">' .str_replace('http', 'https', $assAvail["Page"]["expandcollapse"]["Section"]["SectionData"][$x]["Data"][$y]["Description"]) . '</div>
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
                       <div class="panel-body">' .str_replace('http', 'https', $assAvail["Page"]["expandcollapse"]["Section"]["SectionData"][$x]["Data"]["Description"]) . '</div>
                   </div>
               </div>';
                    }
                }


                $accoutput .= '</div>';

                $accoutput .= '</section>';

            }

            if(!empty($accoutput) and $b["access_active"] == 'true') {
                $ifacc = 'display: block';
            } else {
                $ifacc = 'display: none';
                $accoutput = '';
            }


            if(!empty($offershtml) and $b["offers_active"] == 'true') {
                $ifoffers = 'display: block';
            } else {
                $ifoffers = 'display: none';
                $offershtml = '';
            }




            $ratingOut = $b["rating_data"];





            if(!empty($ratingGET) and $b["reviews_active"] == 'true') {
                $ifreviews = 'display: block';
            } else {
                $ifreviews = 'display: none';
                $ratingGET = '';
            }

//            $dealername = 'SunSouth Equipment';
//            $manufacturer = 'John Deere';


            $output .= '<div class="modal" id="exampleModal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Request More Info</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
       {form}New_Equipment_Request{/form}
      </div>
      <div class="modal-footer">
      
      </div>
    </div>
  </div>
</div>';

            $output .= '<div class="container-fluid" style="margin-left: 0px; margin-right: 0px; padding-left: 0px; padding-right: 0px;"><div class="row" style="margin: 0px; padding:20px">

            <div class="col-md-8 col-sm-12">
                <!--<img src="<?php echo $urlbase.$mainimg;?>" class="img-responsive" alt="product img"/>-->
                '.$imggallery.'
          </div>
            <div class="col-md-4 col-sm-12">
                
                <h1 class="model"><span class="brand"></span>'.str_replace('-', ' ',$title).'<br></h1>
                <h2 class="submodel">'.$subtitle.'<br></h2>
                <div class="rating-top" style="'.$ifreviews.'"><div class="input jq-ry-container" data-read-only="true" data-value="'.$rating.'" readonly="readonly" style="width: 96px;"><div class="jq-ry-group-wrapper"><div class="jq-ry-normal-group jq-ry-group"><!--?xml version="1.0" encoding="utf-8"?--><svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 12.705 512 486.59" x="0px" y="0px" xml:space="preserve" width="16px" height="16px" fill="#c2c2c2"><polygon points="256.814,12.705 317.205,198.566 512.631,198.566 354.529,313.435 414.918,499.295 256.814,384.427 98.713,499.295 159.102,313.435 1,198.566 196.426,198.566 "></polygon></svg><!--?xml version="1.0" encoding="utf-8"?--><svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 12.705 512 486.59" x="0px" y="0px" xml:space="preserve" width="16px" height="16px" fill="#c2c2c2" style="margin-left: 4px;"><polygon points="256.814,12.705 317.205,198.566 512.631,198.566 354.529,313.435 414.918,499.295 256.814,384.427 98.713,499.295 159.102,313.435 1,198.566 196.426,198.566 "></polygon></svg><!--?xml version="1.0" encoding="utf-8"?--><svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 12.705 512 486.59" x="0px" y="0px" xml:space="preserve" width="16px" height="16px" fill="#c2c2c2" style="margin-left: 4px;"><polygon points="256.814,12.705 317.205,198.566 512.631,198.566 354.529,313.435 414.918,499.295 256.814,384.427 98.713,499.295 159.102,313.435 1,198.566 196.426,198.566 "></polygon></svg><!--?xml version="1.0" encoding="utf-8"?--><svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 12.705 512 486.59" x="0px" y="0px" xml:space="preserve" width="16px" height="16px" fill="#c2c2c2" style="margin-left: 4px;"><polygon points="256.814,12.705 317.205,198.566 512.631,198.566 354.529,313.435 414.918,499.295 256.814,384.427 98.713,499.295 159.102,313.435 1,198.566 196.426,198.566 "></polygon></svg><!--?xml version="1.0" encoding="utf-8"?--><svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 12.705 512 486.59" x="0px" y="0px" xml:space="preserve" width="16px" height="16px" fill="#c2c2c2" style="margin-left: 4px;"><polygon points="256.814,12.705 317.205,198.566 512.631,198.566 354.529,313.435 414.918,499.295 256.814,384.427 98.713,499.295 159.102,313.435 1,198.566 196.426,198.566 "></polygon></svg></div><div class="jq-ry-rated-group jq-ry-group"><!--?xml version="1.0" encoding="utf-8"?--><svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 12.705 512 486.59" x="0px" y="0px" xml:space="preserve" width="16px" height="16px" fill="rgb(54, 124, 43)"><polygon points="256.814,12.705 317.205,198.566 512.631,198.566 354.529,313.435 414.918,499.295 256.814,384.427 98.713,499.295 159.102,313.435 1,198.566 196.426,198.566 "></polygon></svg><!--?xml version="1.0" encoding="utf-8"?--><svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 12.705 512 486.59" x="0px" y="0px" xml:space="preserve" width="16px" height="16px" fill="rgb(54, 124, 43)" style="margin-left: 4px;"><polygon points="256.814,12.705 317.205,198.566 512.631,198.566 354.529,313.435 414.918,499.295 256.814,384.427 98.713,499.295 159.102,313.435 1,198.566 196.426,198.566 "></polygon></svg><!--?xml version="1.0" encoding="utf-8"?--><svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 12.705 512 486.59" x="0px" y="0px" xml:space="preserve" width="16px" height="16px" fill="rgb(54, 124, 43)" style="margin-left: 4px;"><polygon points="256.814,12.705 317.205,198.566 512.631,198.566 354.529,313.435 414.918,499.295 256.814,384.427 98.713,499.295 159.102,313.435 1,198.566 196.426,198.566 "></polygon></svg><!--?xml version="1.0" encoding="utf-8"?--><svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 12.705 512 486.59" x="0px" y="0px" xml:space="preserve" width="16px" height="16px" fill="rgb(54, 124, 43)" style="margin-left: 4px;"><polygon points="256.814,12.705 317.205,198.566 512.631,198.566 354.529,313.435 414.918,499.295 256.814,384.427 98.713,499.295 159.102,313.435 1,198.566 196.426,198.566 "></polygon></svg><!--?xml version="1.0" encoding="utf-8"?--><svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 12.705 512 486.59" x="0px" y="0px" xml:space="preserve" width="16px" height="16px" fill="rgb(54, 124, 43)" style="margin-left: 4px;"></svg></div></div></div>
                <span class="number-reviews">'.$numratings.'</span>
                <div class="new-write-review-button" style="display: none;"><a class="cta button3 btn-write-review new-write-review-button-link" href="#" aria-label=" - 1023E" data-linkid="cta-3 :  : write-a-review" data-linktype="internal-defer">Write a Review<i style="padding-left: 10px;" class="fas fa-angle-right"></i></a></div>
                </div><div class="clearfix"></div>'.$productsummary.'
                '.$pricepresent.'<br><button style="margin-right: 20px;"class="btn btn-success moreinfo" data-url="'.$actual_link.'" data-equipment="John Deere - '.$title.'" data-toggle="modal" data-target="#exampleModal">'.$ctatext.'</button>'.$ifcart.'<br><br><a href="'.$brochlink .'" target="_blank" class="brochure-link" style="font-weight: bold; color: green;">View Product Brochure</a><br><div class="a2a_kit a2a_kit_size_32 a2a_default_style" style="line-height: 32px;">
<a class="a2a_dd" href="https://www.addtoany.com/share#url='.$actual_link.'"><span class="a2a_svg a2a_s__default a2a_s_a2a" style="background-color: rgb(1, 102, 255);"><svg focusable="false" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32"><g fill="#FFF"><path d="M14 7h4v18h-4z"></path><path d="M7 14h18v4H7z"></path></g></svg></span><span class="a2a_label a2a_localize" data-a2a-localize="inner,Share">Share</span></a>
<a class="a2a_button_facebook" target="_blank" href="/#facebook" rel="nofollow noopener"><span class="a2a_svg a2a_s__default a2a_s_facebook" style="background-color: rgb(59, 89, 152);"><svg focusable="false" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32"><path fill="#FFF" d="M17.78 27.5V17.008h3.522l.527-4.09h-4.05v-2.61c0-1.182.33-1.99 2.023-1.99h2.166V4.66c-.375-.05-1.66-.16-3.155-.16-3.123 0-5.26 1.905-5.26 5.405v3.016h-3.53v4.09h3.53V27.5h4.223z"></path></svg></span><span class="a2a_label">Facebook</span></a>
<a class="a2a_button_twitter" target="_blank" href="/#twitter" rel="nofollow noopener"><span class="a2a_svg a2a_s__default a2a_s_twitter" style="background-color: rgb(85, 172, 238);"><svg focusable="false" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32"><path fill="#FFF" d="M28 8.557a9.913 9.913 0 0 1-2.828.775 4.93 4.93 0 0 0 2.166-2.725 9.738 9.738 0 0 1-3.13 1.194 4.92 4.92 0 0 0-3.593-1.55 4.924 4.924 0 0 0-4.794 6.049c-4.09-.21-7.72-2.17-10.15-5.15a4.942 4.942 0 0 0-.665 2.477c0 1.71.87 3.214 2.19 4.1a4.968 4.968 0 0 1-2.23-.616v.06c0 2.39 1.7 4.38 3.952 4.83-.414.115-.85.174-1.297.174-.318 0-.626-.03-.928-.086a4.935 4.935 0 0 0 4.6 3.42 9.893 9.893 0 0 1-6.114 2.107c-.398 0-.79-.023-1.175-.068a13.953 13.953 0 0 0 7.55 2.213c9.056 0 14.01-7.507 14.01-14.013 0-.213-.005-.426-.015-.637.96-.695 1.795-1.56 2.455-2.55z"></path></svg></span><span class="a2a_label">Twitter</span></a>
<a class="a2a_button_google_plus" target="_blank" href="/#google_plus" rel="nofollow noopener"><span class="a2a_svg a2a_s__default a2a_s_google_plus" style="background-color: rgb(202, 224, 255);"><svg focusable="false" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32"><path d="M27 15h-2v-2h-2v2h-2v2h2v2h2v-2h2m-15-2v2.4h3.97c-.16 1.03-1.2 3.02-3.97 3.02-2.39 0-4.34-1.98-4.34-4.42s1.95-4.42 4.34-4.42c1.36 0 2.27.58 2.79 1.08l1.9-1.83C15.47 9.69 13.89 9 12 9c-3.87 0-7 3.13-7 7s3.13 7 7 7c4.04 0 6.72-2.84 6.72-6.84 0-.46-.05-.81-.11-1.16H12z" fill="#FFF"></path></svg></span><span class="a2a_label">google_plus</span></a>
<a class="a2a_button_email" target="_blank" href="/#email" rel="nofollow noopener"><span class="a2a_svg a2a_s__default a2a_s_email" style="background-color: rgb(1, 102, 255);"><svg focusable="false" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32"><path fill="#FFF" d="M26 21.25v-9s-9.1 6.35-9.984 6.68C15.144 18.616 6 12.25 6 12.25v9c0 1.25.266 1.5 1.5 1.5h17c1.266 0 1.5-.22 1.5-1.5zm-.015-10.765c0-.91-.265-1.235-1.485-1.235h-17c-1.255 0-1.5.39-1.5 1.3l.015.14s9.035 6.22 10 6.56c1.02-.395 9.985-6.7 9.985-6.7l-.015-.065z"></path></svg></span><span class="a2a_label">Email</span></a>
<div style="clear: both;"></div></div><script async="" src="https://static.addtoany.com/menu/page.js"></script><br>
    <div class="extra-content">'.$extra.'</div>

    <div id="used-car-target">'.$usedCar.'</div>
        
            </div>
            <div class="clearfix"></div>
   
            <br><br>
        </div>';

            if($b["videos"] != '' and $b["videos_active"] == 'true' ) {
                $ifvideos = "display: block";
            } else {
                $ifvideos = 'display: none;';
            }



            $output .= '<div class="sticky-wrapper"><section id="new-equip-tabs">
        <div class="row sticky"  style="top: 53px; padding: 0;" data-toggle="sticky-onscroll">
            <ul id="new-navbar" class="nav nav-tabs">
                <li class="nav-item">
                    <a class="nav-link" href="#features">Features</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#specs">Specifications</a>
                </li>
                <li class="nav-item" style="'.$ifoffers.'">
                    <a class="nav-link" href="#offers-discounts" >Offers & Discounts</a>
                </li>
                <li class="nav-item"  style="'.$ifacc.'">
                    <a class="nav-link" href="#accsatts">Accessories & Attachments</a>
                </li>
                <li class="nav-item" style="'.$ifreviews.'">
                    <a class="nav-link" href="#reviewdata" >Reviews</a>
                </li>
                 <li class="nav-item" style="'.$ifvideos.'">
                    <a class="nav-link" href="#videos" >Videos</a>
                </li>
            </ul>
        </div>
        </section></div>';

            $output .= '
       <section id="features" name="features">
           <div class="container-fluid">
               <h3>Features</h3>
           <div class="row"  style="margin-bottom: 10px; padding-left: 15px;">
               <br><br>
           '.$featureoutput.'

           </div>
           </div>
       </section>';



            $output .= '<section id="specs" name="specs" style="padding-left:15px;">
            <h2>Specifications</h2><br>
            <div class="selection-option" style="'.$ifspecs.'" >
            <p>Compare the specifications of up to 4 models</p>
           <div class="row"  style="margin-bottom: 10px;">
           <div class="col-md-3">
           '.$specoptions.'
           '.$spechtml.'
        </section>';

            $output .= '<section id="offers-discounts" name="offers-discounts">
        '.$offershtml.'
        </section>';

            $output .= $accoutput;

            $output .= '<section id="videos" name="videos" style="margin-bottom: 10px;">'.$b["videos"].'</section>';


            $output .= $ratingGET;

            $output .= '<input type="hidden" id="product" name="product" value="'.$title.'"/>
            <input type="hidden" id="brand" name="brand" value="John Deere"/>
             <input type="hidden" id="schemaimg" name="schemaimg" value="'.$schemaimg.'"/>   
            <input type="hidden" id="description" name="description" value="'.$dealername.' is proud to offer the '.$manufacturer.' '.$title.' at a competitive price and back it with reliable and affordable service throughout its lifespan of service.  From initial purchasing consultations to make sure that the '.$manufacturer.' '.$title.' is the best product for your needs to financing, purchasing and final delivery, '.$dealername.' will work to provide you with the highest level of customer service and product support. Once you put it in service, you can always rely on '.$dealername.' to provide ongoing warranty and aftermarket parts and service to keep your property and your new '.$title.' as productive as possible."/>
             <input type="hidden" id="price" name="price" value="'.$productprice.'"/>
             <input type="hidden" id="ratingval" name="ratingval" value="'.$rating.'"/>
              <input type="hidden" id="ratingcount" name="ratingcount" value="'.$numratings.'"/></div>
';


//$output .= '<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script><script>$(document).ready(function(){
//       var el = document.createElement(\'script\');
//       el.type = \'application/ld+json\';
//       el.text = JSON.stringify({ "@context" : "http://schema.org",
//  "@type" : "Product",
//  "name" : "E100",
//  "image" : "img/equip_images/E100_SEOVAL.jpg",
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

            include('inc/promo_tracker.php');

            //<--END PAGE PROCESS-->//
            $content = array();

            //DEPENDENCIES///

            $css[] = 'inc/mods/deere_equipment/deere-output/css/lightslider.css';
            $css[] = 'inc/mods/deere_equipment/deere-output/css/main.css';
            $css[] = 'inc/mods/deere_equipment/deere-output/css/jquery.paginate.css';

            $js[] = 'inc/mods/deere_equipment/deere-output/js/lightslider.js';
            $js[] = 'inc/mods/deere_equipment/deere-output/js/jquery.paginate.js';
            $js[] = 'inc/mods/deere_equipment/deere-output/js/new-output.js';
            $js[] = 'inc/mods/deere_equipment/deere_functions.js';

            $ars = array("css"=>$css, "js"=>$js);


            $arsOut = json_encode($ars);

            $content[] = array("page_name" => $page, "page_title" => '', "page_content" => $output, "active" => true, "created" => time(), "last_edit" => '', "last_user" => '', "page_lock" => 'none', "page_type" => '', "page_desc" => '', "check_out" => false, "check_out_date" => '', "page_js" => '', "dependants" => $arsOut);
            return $content;
        } else {

            ///HANDLE PRODUCT CATEGORY OUTPUT HERE///

            $a = $data->query("SELECT * FROM deere_pages WHERE page_name = '$page' AND active = 'true'");



            if($a->num_rows > 0){
                $b = $a->fetch_array();
                $pageTemplate = $b["page_content"];

                $matach = 'equipment_get';

                $theTitle = $b["page_title"];

                $categoryOut = preg_replace_callback('#{prodcat}data{/prodcat}#', function($match) use($page){


                    ////RETURN THE CATEGORIES HERE////
                    include('inc/config.php');
                    $a = $data->query("SELECT * FROM deere_pages WHERE page_name = '$page'");
                    $b = $a->fetch_array();

                    $equip_content = json_decode($b["equipment_content"],true);
                    $catOut .= '<div class="row">';
                    for($i=0; $i<count($equip_content); $i++){
                        if($equip_content[$i]["type"] == 'category'){
                            $c = $data->query("SELECT * FROM deere_pages WHERE page_name = '".$equip_content[$i]["title"]."'");
                            $d = $c->fetch_array();

                            $prodct = json_decode($d["equipment_content"],true);
                            $prodct = count($prodct);
                            //$catOut .= '<div class="image-cont col-md-4"><img style="width: 100%" title="'.$page.'" src=" '.$d["cat_img"].'"><br><span>'.str_replace('-',' ', $d["page_name"]).'</span></div>';



                            $catOut .= '<div class="col-md-4 col-sm-5">
            <div class="card" style="margin-bottom: 20px; border-radius: 0px; border: transparent;">
                <div class="product-image6">
                    <a href="'.$_SERVER['REQUEST_URI'].'/'.$d["page_name"].'">
                        <img class="pic-1 img-responsive fadeIn" style="padding: 20px" src="'.$d["cat_img"].'">
                    </a>
                </div>           
                <div class="product-content" style="padding: 20px">
                    <h3 class="title" style="font-size: 1.3rem;"><a style="color: black;" href="'.$_SERVER['REQUEST_URI'].'/'.$d["page_name"].'">'.str_replace('-',' ',$d["page_name"]).'</a></h3>
                    <small style="padding: 3px; min-height: 150px; display: block">'.$d["page_desc"].'</small>
                    
                </div>
            </div>
        </div>';

                        }else {

                            if ($equip_content[$i]["type"] == 'htmlarea') {
                                ////ADD HTML TYPE OUTPUTS HERE////
                                $catOut .= '<div class="clearfix"></div>';
                                $catOut .= $this->getBeanItems($equip_content[$i]["title"],'');
                                $catOut .= '<div class="clearfix"></div>';

                               // echo $equip_content[$i]["title"];
                            } else {


                                $e = $data->query("SELECT title, eq_image, id, price FROM deere_equipment WHERE title = '" . $equip_content[$i]["title"] . "'")or die($data->error);
                                $f = $e->fetch_array();

                                $bullets = json_decode($f["bullet_points"], true);
                                $bullOut .= '<ul style="display: block;text-align: left;font-size: 10px; color: #333; font-weight: bold">';

                                foreach ($bullets as $bull) {
                                    $bullOut .= '<li>' . $bull . '</li>';
                                }

                                if ($f["price"] != null) {
                                    $priceOuts = '<span class="product-new-label" style="color: #333; font-weight:bold; font-size: 14px; padding-left: 20px;">MSRP STARTING AT $' . $f["price"] . '</span>';
                                }

                                $isitars = json_decode($f["eq_image"],true);

                                if(is_array($isitars)){
                                    $equipImg = $isitars[0];
                                }else{
                                    $equipImg = str_replace('""','',$f["eq_image"]);
                                }







                                $bullOut .= '</ul>';

                                if (strpos($f["title"], '-') !== false) {
                                    $model = explode('-', $f["title"]);
                                    $modeltitle = $model[0];
                                } else {
                                    $modeltitle = $f["title"];
                                }

                                ///$catOut .= '<div class="image-cont col-md-4"><img style="width: 100%" title="'.$f["title"].'" src="../img/'.$f["eq_image"].'"><br><span>'.str_replace('-',' ', $f["title"]).'</span></div>';
                                $catOut .= '<div class="col-md-4 col-sm-5 product-box probox' . $f["id"] . '" data-boxval="' . $f["id"] . '" style="background: #fff;padding: 10px;border: solid 10px #fff;">
            <div class="card" style="border: transparent;">
                <div class="product-image">
                    <a href="' . $_SERVER['REQUEST_URI'] . '/' . $f["title"] . '">
                        <img class="pic-1 img-responsive fadeIn" src="../img/equip_images/' . $equipImg . '">
                        
                    </a>
                    <!--<ul class="social">
                        <li><a href="javascript:void(0)" class="quick-btn" data-qukid="' . $f["id"] . '" data-eqtype="deere" data-tip="Quick View"><i class="fa fa-search"></i></a></li>
                    </ul>-->
                    ' . $priceOuts . '
                   <!--<span class="product-discount-label">Special Offers</span>-->
                </div>
                <!--<ul class="rating">
                    <li class="fa fa-star"></li>
                    <li class="fa fa-star"></li>
                    <li class="fa fa-star"></li>
                    <li class="fa fa-star"></li>
                    <li class="fa fa-star disable"></li>
                </ul>-->
                <div class="product-content" style="border: transparent;">
                    <h3 class="title" style="margin-bottom: 0; background: #346635; color: white; font-size: 20px;"><a style="color: white; padding-left: 20px;"href="' . $_SERVER['REQUEST_URI'] . '/' . $f["title"] . '">' . str_replace('-', ' ',$f["title"]) . '</a></h3>
                    
                    <small style="min-height: 150px; display: none;">' . $bullOut . '</small>
                </div>
            </div>
        </div>';


                                $bullOut = '';
                            }
                        }
                    }

                    $catOut .= '</div>';





                    return $catOut;
                    }, $pageTemplate);

                //$categoryOut = preg_replace_callback('#{prodcat}data{/prodcat}#',"equipment_get", $pageTemplate);

                if (strpos($_SERVER['REQUEST_URI'], 'Used-Equipment') != true) {

                    $css[] = 'inc/mods/deere_equipment/deere-output/css/lightslider.css';
                    $css[] = 'inc/mods/deere_equipment/deere-output/css/main.css';
                    $css[] = 'inc/mods/deere_equipment/deere-output/css/jquery.paginate.css';

                    $js[] = 'inc/mods/deere_equipment/deere-output/js/lightslider.js';
                    $js[] = 'inc/mods/deere_equipment/deere-output/js/jquery.paginate.js';
                    $js[] = 'inc/mods/deere_equipment/deere-output/js/new-output.js';
                    $js[] = 'inc/mods/deere_equipment/deere_functions.js';

                    $ars = array("css"=>$css, "js"=>$js);


                    $arsOut = json_encode($ars);

                    $content[] = array("page_name" => 'CATEGORY PAGE', "page_title" => ''.$theTitle.'', "page_content" => $categoryOut, "active" => true, "created" => time(), "last_edit" => '', "last_user" => '', "page_lock" => 'none', "page_type" => '', "page_desc" => '', "check_out" => false, "check_out_date" => '', "page_js" => '', "dependants" => $arsOut);
                    return $content;
                }
            }else{
                ////DO NOTHING TO RETURN 404////
            }




        }
    }

    function file_get_contents_curl($url)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $data = curl_exec($ch);
        curl_close($ch);

        return $data;
    }

    function get_headers_curl($url)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $data = curl_exec($ch);
        curl_close($ch);
        $result = json_decode($data);
        if (json_last_error() === JSON_ERROR_NONE) {
            return true;
        } else {
            return false;
        }

    }

    function getDaysUpdate($timeout)
    {

        $now = time(); // or your date as well
        $your_date = $timeout;
        $datediff = $now - $your_date;

        return round($datediff / (60 * 60 * 24));

    }

    function getReviews($eqid)
    {

        include('inc/config.php');
        $a = $data->query("SELECT * FROM reveiws WHERE eqipment_link = '$eqid' AND active = 'true' AND approved = 'true'");
        while ($b = $a->fetch_array()) {
            $nickName = explode(' ', $b["name"]);
            $nickName = $nickName[0] . substr($nickName[1], 0, 1);
            $rate[] = array("rating" => $b["reveiw_stars"], "review_title" => $b["review_title"], "comment" => $b["review_text"], "nickname" => $nickName, "datesub" => $b["date_submited"]);
        }

        for ($i = 0; $i <= count($rate); $i++) {
            if ($rate[$i]["rating"] == 1) {
                $one[] = 1;
            }
            if ($rate[$i]["rating"] == 2) {
                $two[] = 1;
            }
            if ($rate[$i]["rating"] == 3) {
                $three[] = 1;
            }
            if ($rate[$i]["rating"] == 4) {
                $four[] = 1;
            }
            if ($rate[$i]["rating"] == 5) {
                $five[] = 1;
            }
        }


        $theRatings = (count($one) + count($two) * 2 + count($three) * 3 + count($four) * 4 + count($five) * 5) / count($rate);
        return array("overallrating" => round($theRatings), "allreviews" => $rate);
    }

    function getBeanItems($tag, $id)
    {
        include('inc/config.php');
        $a = $data->query("SELECT * FROM beans WHERE bean_id = '$tag' AND active = 'true'");
        $b = $a->fetch_array();
        if($b["bean_type"] == 'native' || $b["bean_type"] == 'eq_bean'){
            if($b["start_time"] == 0 && $b["end_time"] == 0){
                return $b["bean_content"];
            }else{
                if($b["start_time"] == 0 && time() < $b["end_time"]){
                    return $b["bean_content"];
                }else{
                    if($b["end_time"] == 0 && time() >= $b["start_time"]){
                        return $b["bean_content"];
                    }else{
                        if(time() >= $b["start_time"] && time() < $b["end_time"]){
                            return $b["bean_content"];
                        }
                    }
                }
            }

        }else{
            ob_start();
            include 'site-admin/installed_beans/'.$b["bean_folder"].'/output.php';
            $string = ob_get_clean();
           return $string;
       }
    }

}