<?php
class custom_equipment
{
    function page($page)
    {
        include('inc/config.php');
        $a = $data->query("SELECT * FROM custom_equipment WHERE title = '$page'") or die($data->error);
        if ($a->num_rows > 0) {

            $obj = $a->fetch_array();
            $title = str_replace('_', ' ', $obj["title"]);
            $outTitleSub = $obj["sub_title"];

            $bullets = $obj["bullet_points"];

            $html .= '<!--modal begin-->
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel">Request a Quote</h4>
                </div>
                <div class="modal-body">
                    {form}New_Equipment_Request{/form}
                </div>
                
            </div>
        </div>
    </div>
    <!--end modal nothing to see here-->';

            $html .= '<!-- Modal -->
    <div class="modal fade" id="myModalEqRV" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel">Review For ' . $title . '</h4>
                </div>
                <div class="modal-body">
                
                    <form class="review-form" id="revieweq" name="revieweq" onsubmit="return false">
                    <div class="alert alert-success">
                <p><strong>Writing guidelines</strong><br>
<p>We want to publish your review, so please:</p>


<p>Keep your review focused on the product -
Avoid writing about customer service; contact us instead if you have issues requiring immediate attention -
Refrain from mentioning competitors or the specific price you paid for the product -
Do not allow children to operate, ride on or play near equipment</p>
</div>
                    <label>Rating</label><br>
                        <input class="form-control" type="text" name="rating_rv" id="rating_rv" class="rating" data-size="sm" data-step="1" data-theme="krajee-fa" value="1"><br>
                       <label>Full Name</label><br>
                        <input class="form-control" type="text" name="full_name_rv" id="full_name_rv" value="" required><br>
                        <label>Review Title</label><br>
                        <input class="form-control" type="text" name="title_rv" id="title_rv" value="" required><br>

                        <label>Email</label><br>
                        
                        <input class="form-control" type="text" name="email_rv" id="email_rv" value="" required><br>
<label>Your Review</label><br>
                        <textarea class="form-control" name="review_rv" id="review_rv"></textarea><br>
                        <input type="hidden" name="eqid_review" id="eqid_review" value="' . $obj["id"] . '">
                        <input type="hidden" name="eqiptype" id="eqiptype" value="custom">
                        
                        <button class="btn btn-success">Submit Review</button>
                    </form>
                </div>
                
            </div>
        </div>
    </div>';


            $price = str_replace('*', '', $obj["sales_price"]);

            if ($obj["quick_links_active"] == 'true') {

                $optLinks = json_decode($obj["opt_links"], true);


                for ($l = 0; $l <= count($optLinks); $l++) {
                    if ($l == 0) {
                    } else {
                        if ($optLinks[$l]["LinkUrl"] != '' && $optLinks[$l]["LinkText"] != 'Request a Demo') {
                            $optLinksOut .= '<a class="optlinks" href="' . $optLinks[$l]["LinkUrl"] . '">' . $optLinks[$l]["LinkText"] . ' <i class="fa fa-angle-right" aria-hidden="true"></i></a>';
                        }
                    }
                }

            } else {
                $optLinksOut = '';
            }


            ///$image = 'img/' . $obj["eq_image"];
            $imageMain = json_decode($obj["eq_image"],true);
            $image = $imageMain[0];


            $features = $obj["features"];
            $description1 .= $obj["description"];

            $bulletsOut = json_decode($bullets, true);

            $bullethtml .= '<ul>';

            foreach ($bulletsOut as $bull) {
                $bullethtml .= '<li>' . $bull . '</li>';
            }

            $bullethtml .= '</ul>';

            $html .= '<div class="row">';


            $html .= '<div class="col-md-8" style="padding:0"><img style="width:50%; display:block; margin:0px auto;" src="img/Custom/' . $image . '"></div>';



            $url = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

            $page = substr($url, strrpos($url, '/') + 1);

            if (isset($_COOKIE["savedData"])) {
                $theSessionOut = json_decode($_COOKIE["savedData"], true);
                for ($i = 0; $i < count($theSessionOut); $i++) {
                    if ($title == $theSessionOut[$i]["machine"]["name"]) {
                        $saveFlag = true;
                    }
                }

            }

//            if ($price != null) {
//                if (isset($saveFlag)) {
//                    $saveButton = '<button class="btn btn-default" disabled>Added To Cart!</button>';
//                } else {
//                    $saveButton = '<button class="btn btn-default save-later" data-eqid="' . $obj["id"] . '" data-eqname="' . $page . '" data-eqtype="custom" data-price="' . str_replace(",", "", $price) . '" data-url="' . $url . '"><i class="fa fa-shopping-cart"></i></button>';
//                }
//            } else {
//                $saveButton = '';
//            }

            $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";


            $tt = str_replace('-', ' ', $title);
            $html .= '<div class="col-md-4"><h1 class="eq_title big-fat-title" style= "color:#383838;">' . $tt . '</h1><br><span class="sub-h1">' . $features . '</span><br><br> ';
//            if ($obj["msrp"] != null) {
//                $html .= "M.S.R.P Pricing <br><strong style=\"font-size: 24px\">$" . $obj["msrp"] . '</strong><br><br>';
//            } else {
//                $html .= '';
//            }
//
//
//            if ($obj["sales_price"] != null) {
//                $html .= '<span class="product-new-label" style="color: #333; font-weight:bold; font-size: 14px; padding-left: 20px;">MSRP STARTING AT $' . $obj["sales_price"] . '</span><br><br>';
//            }
$theprice = $obj["sales_price"];

            if($theprice != '' && $obj["msrp"] != '') {
                $pricepresent = '<span class="startingat">Starting At:</span><span style="color:red;text-decoration:line-through;"><span class="equipprice" style="color: red; font-size: 2.6rem;">' . $theprice . '</span></span><br><span class="startingat">Dealer Price:</span><span class="equipprice" style="font-size: 2.6rem;">' . $obj["msrp"] . '</span>';
                //$ifcart = '<button class="btn btn-dark save-later" data-eqid="'.$b["id"].'" data-eqname="'.$b["title"].'" data-eqtype="deere" data-price="'.$b["price"].'" data-url="'.$actual_link.'"> Add To Cart <i class="fa fa-shopping-cart"></i></button>';
            } elseif($theprice != '') {
                $pricepresent = '<span class="startingat">Starting At:</span><span class="equipprice" style="font-size: 2.6rem;">' . $theprice .'</span>';
                //$ifcart = '<button class="btn btn-dark save-later" data-eqid="'.$b["id"].'" data-eqname="'.$b["title"].'" data-eqtype="deere" data-price="'.$b["price"].'" data-url="'.$actual_link.'"> Add To Cart <i class="fa fa-shopping-cart"></i></button>';
            } else {
                $pricepresent = '';
                //$ifcart = '';
            }

            $html .= '<div class="clearfix"></div>'.$pricepresent.'<br><button class="btn btn-success parts-button moreinfo" style="background-color:#383838; border-color: #383838;" data-url="'.$actual_link.'" data-equipment="Custom - '.$title.'" data-toggle="modal" data-target="#exampleModal">Request A Quote</button> ' . $saveButton . '<br><br>
<!-- AddToAny BEGIN -->
<div class="a2a_kit a2a_kit_size_32 a2a_default_style">
<a class="a2a_dd" href="https://www.addtoany.com/share"></a>
<a class="a2a_button_facebook"></a>
<a class="a2a_button_twitter"></a>
<a class="a2a_button_google_plus"></a>
<a class="a2a_button_email"></a>
</div>


<script async src="https://static.addtoany.com/menu/page.js"></script>
<!-- AddToAny END --><br><br><div style="font-size:30px">' . $starsNow . ' <br>' . $readRevs . ' <a style="font-size: 12px" href="javascript:void(0)" class="reviewit" data-neweqids="' . $obj["id"] . '"></a></div><br><br>' . $optLinksOut . '<br><br><div class="offer-titles-set"></div></div>';


            $html .= '<div class="clearfix"></div><br>';


            if ($obj["extra_content"] != '') {
                $html .= '<div class="col-md-12 extra-content">' . $obj["extra_content"] . '</div>';
                $html .= '<div class="clearfix"></div><br>';
            }

            //$html .= $features;

            if ($obj["videos_active"] == 'true') {

                //YOUTUBE VIDEOS OUTPUT//

                $videosTitle = '';
                $videos = json_decode($obj["videos"], true);

                ///var_dump($videos);


                if (!empty($videos)) {

                    if (count($videos) > 1) {

                        $firstVid = str_replace(' ', '', $videos[0]["Youtube"]["Id"]);


                        $html .= '<div class="video-container" style="background: #333;">';
                        ///$html .= '<h2 style="color: #fff; padding: 25px">' . $videosTitle . '</h2>';
                        $html .= '<div class="col-md-12" style="padding: 0">';
                        $html .= '<div class="vidoverall" style="padding:20px; display:none;"><button type="btn" class="close close-vids" style="padding:10px"><i class="fa fa-times"></i> Close</button><div class="clearfix"></div><div class="embed-responsive embed-responsive-16by9"><iframe id="customvids" class="embed-responsive-item" src="https://www.youtube.com/embed/' . $firstVid . '?rel=0" allowfullscreen></iframe></div></div>';
                        $html .= '</div>';
                        $html .= '<div class="col-md-12" style="padding: 0; text-align: center">';
                        $html .= '<div class="vid-list-header" style="font-size: 30px; font-weight:bold">Videos</div>';
                        $html .= '<div style="width:100%; overflow-x:scroll">';


                        for ($vd = 0; $vd <= count($videos); $vd++) {
                            $lastTime = $this->getDaysUpdate($obj["last_updated"]);
                            $videoOuput = trim(preg_replace('/[\x00-\x1F\x7F\xA0]/u', "", $videos[$vd]["Youtube"]["Id"]));
                            $lastTime = $this->getDaysUpdate($obj["last_updated"]);
                            if ($lastTime > 10) {
                                $headers = $this->get_headers_curl('https://www.youtube.com/oembed?format=json&url=http://www.youtube.com/watch?v=' . str_replace(' ', '', $videoOuput));


                                if ($headers == true) {
                                    $validVid = true;
                                } else {
                                    $validVid = false;
                                }
                                if (str_replace(' ', '', $videoOuput) != null && $validVid == true) {

                                    $html .= '<div class="vid-thumb vidshow" data-vidlink="' . str_replace(' ', '', $videoOuput) . '"><img style="width:100%; padding: 5px; border:solid thin yellow" src="https://img.youtube.com/vi/' . $videoOuput . '/hqdefault.jpg"></div>';
                                    $vidOut[] = str_replace(' ', '', $videoOuput);


                                }
                            } else {
                                $vidOut = '';
                            }
                        }


                        if (!empty($vidOut)) {
                            $vids = json_encode($vidOut);
                            ///echo "This is ". $vids;
                            $data->query("UPDATE custom_equipment SET video_storage = '" . $data->real_escape_string($vids) . "' WHERE id = '" . $obj["id"] . "'") or die($data->error) or die($data->error);
                        } else {
                            $spillVid = json_decode($obj["video_storage"], true);
                            foreach ($spillVid as $vidout) {
                                $html .= '<div class="vid-thumb vidshow" data-vidlink="' . str_replace(' ', '', $vidout) . '"><img style="width:100%; padding: 5px; border:solid thin yellow" src="https://img.youtube.com/vi/' . $vidout . '/hqdefault.jpg"></div>';
                            }
                        }

                    } else {
                        $firstVid = $videos["Youtube"]["Id"];

                        $html .= '<div class="video-container" style="background: #333;">';
                        $html .= '<h2 style="color: #fff; padding: 25px">' . $videosTitle . '</h2>';
                        $html .= '<div class="col-md-12" style="padding: 0">';
                        $html .= '<div class="embed-responsive embed-responsive-16by9"><iframe id="customvids" class="embed-responsive-item" src="https://www.youtube.com/embed/' . $firstVid . '?rel=0" allowfullscreen></iframe></div>';
                        $html .= '</div>';
                        $html .= '<div class="col-md-12" style="padding: 0; text-align: center">';
                        $html .= '<div class="vid-list-header">More Videos</div>';
                        $html .= '<div style="width:100%; overflow-x:scroll">';
                        $html .= '<div class="vid-thumb vidshow" data-vidlink="' . str_replace(' ', '', $firstVid) . '"><img style="width:100%; padding: 5px; border:solid thin yellow" src="https://img.youtube.com/vi/' . $firstVid . '/hqdefault.jpg"></div>';
                    }
                    $html .= '</div>';
                    $html .= '</div>';
                    $html .= '<div class="clearfix"></div>';
                    $html .= '</div>';

                }
                //END VIDEOS//
            }


            $specLink = $obj["specs"];


            $html .= '<div class="container spec-contain" style="margin-top: -105px;">';

            $html .= '<h1 class="big-fat-title" style="background:#383838; padding: 10px; color:#fff; display:block;">Specs</h1>';



            $html .= '<div class="table-responsive table table-striped-new">';
            $html .= $description1;

            $html .= '</div>';
            $html .= '</div>';

           /// $html .= '<div style="text-align: center"><button class="btn btn-default open-spec" style="margin: 20px"><i class="fa fa-align-left" aria-hidden="true"></i> Show More</button></div>';

            if ($obj["offers_active"] == 'true') {
                //OFFERS START//

                ///get last updated//

                $lastTime = $this->getDaysUpdate($obj["last_updated"]);

                if ($lastTime > 10) {

                    $offers = $this->file_get_contents_curl($obj["offers_link"]);


                    $offerstags = str_replace('<esi:assign name="jsonincludedata">', '', $offers);
                    $offerstags = str_replace('</esi:assign>', '', $offerstags);


                    $offerstags = str_replace('\'', '"', $offerstags);

                    $offersOut = json_decode($offerstags, true);

                    $finnalyOfffers = $offersOut["values"][0]["offers"];

                    $q = 0;
                    foreach ($finnalyOfffers as $offerlink) {

                        $offerLinkClean = str_replace('/html/custom/us/en/website/', 'en/', $offerlink);
                        $offersLinkNow = 'https://www.custom.com/' . $offerLinkClean . '/index.json';
                        //echo $offersLinkNow . '<br>';
                        $jsonOffer = $this->file_get_contents_curl($offersLinkNow);
                        $objOffers = json_decode($jsonOffer, true);

                        if (is_array($objOffers) && $objOffers["Page"]["special-offers"]["ESIFragments"] != null) {
                            if (strpos($objOffers["Page"]["special-offers"]["ESIFragments"], 'https://www.custom.com') !== false) {
                                $jsonOfferOut = $this->file_get_contents_curl($objOffers["Page"]["special-offers"]["ESIFragments"]);
                            } else {
                                $jsonOfferOut = $this->file_get_contents_curl('https://www.custom.com' . $objOffers["Page"]["special-offers"]["ESIFragments"]);
                            }

                            //var_dump($objOffers["Page"]["special-offers"]["ESIFragments"]);
                            $content = str_replace('srcset="', 'srcset="https://custom.com', $jsonOfferOut);
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

                    }


                    if ($offerZZ != null) {
                        $offerZZa .= '<div class="col-md-12" style="background: #fff">';

                        $offerZZa .= '<h1 class="offers-header">Offers and Discounts</h1>';


                        $offerZZa .= '<div class="offers-holder">';
                        $offerZZa .= $offerZZ;
                        $offerZZa .= '</div>';

                        $offerZZa .= '</div>';

                        ///Store offers in db///

                        $data->query("UPDATE custom_equipment SET offers_storage = '" . $data->real_escape_string($offerZZa) . "', last_updated = '" . time() . "' WHERE id = '" . $obj["id"] . "'") or die($data->error);

                        $html .= $offerZZa;
                    }
                } else {
                    $html .= $obj["offers_storage"];

                }

                ///OFFERS END///
            }


            if ($obj["access_active"] == 'true') {

                ///START ACCESSORIES//


                $lastTime = $this->getDaysUpdate($obj["last_updated"]);

                if ($lastTime > 30) {
                    if ($obj["accessories"] != 'https://www.custom.com') {
                        $accessories = $this->file_get_contents_curl($obj["accessories"]);
                        $headers = $this->get_headers_curl($obj["accessories"]);
                        if (strpos($accessories, '404 Error Page') !== false) {
                            $asscor = false;
                        } else {
                            $asscor = true;
                        }
                        if ($asscor == true) {
                            $assOut .= '<div class="clearfix"></div>';
                            $assOut .= '<div class="col-md-12">';
                            $assOut .= '<h2 class="accheader">Accessories and Attachments</h2>';
                            $assOut .= '</div>';
                            $assOut .= '<div class="col-md-12 access-cotainer">';


                            if (is_array($headers) ? preg_match('/^HTTP\\/\\d+\\.\\d+\\s+2\\d\\d\\s+.*$/', $headers[0]) : false) {
                                $validAcc = true;
                            } else {
                                $validAcc = true;
                            }

                            if ($validAcc == true) {
                                $assOut .= $accessories;
                            }

                            $assOut .= '</div>';

                            $assOut .= '<div style="text-align: center"><button class="btn btn-default open-attach" style="margin: 20px"><i class="fa fa-align-left" aria-hidden="true"></i> Show More</button></div>';
                        }
                        // $html .= $obj["Page"]["ESI Include Accessories-Attachments"]["ESIFragments"] . '<br>';

                        //$html .= $obj["Page"]["expandcollapse"]["Section"]["SectionData"]["ESIData"]["ESICategoryData"];

                        $assOut .= '<hr>';

                        $data->query("UPDATE custom_equipment SET accessories_storage = '" . $data->real_escape_string($assOut) . "', last_updated = '" . time() . "' WHERE id = '" . $obj["id"] . "'") or die($data->error);

                        $html .= $assOut;
                    }
                } else {
                    $html .= $obj["accessories_storage"];
                }


            }



            $html .= '<div class="clearfix"></div>';

//            $html .= '<div class="review-panel" style="padding: 10px; text-align: center; background: #FEDC33; color:#333; margin: 20px"><h2>CUSTOMER REVIEWS</h2></div>';
//
//
//            $fullReviews = $reviewOutty["allreviews"];
//
//            if (!(empty($fullReviews))) {
//
//                for ($rvs = 0; $rvs < count($fullReviews); $rvs++) {
//                    $rating = $fullReviews[$rvs]["rating"];
//                    $comment = $fullReviews[$rvs]["comment"];
//                    $nickname = $fullReviews[$rvs]["nickname"];
//                    $datesub = ucwords(date('M d, Y', $fullReviews[$rvs]["datesub"]));
//
//                    for ($z = 0; $z < $rating; $z++) {
//                        $starsFilledPer .= '<i class="fa fa-star" style="color: #fdda1f"></i>';
//                    }
//
//                    if ($rating < 5) {
//                        $grayPer .= 5 - $rating;
//                    } else {
//                        $grayPer = '0';
//                    }
//
//                    for ($e = 0; $e < $grayPer; $e++) {
//                        $grayStarsPer .= '<i class="fa fa-star" style="color: #e6e6e6"></i>';
//                    }
//
//                    $starsNowPer = $starsFilledPer . $grayStarsPer;
//
//                    $html .= '<div class="" style="padding: 20px; margin: 20px; background: #efefef;"><small style="font-weight: bold;">' . $datesub . '</small><br><h4 style="font-weight: bold;">' . $fullReviews[$rvs]["review_title"] . '</h4><br>' . $starsNowPer . '<br><p>' . $comment . '</p><small style="font-style: italic">' . $nickname . '</small></div>';
//                    $grayPer = 0;
//                    $rating = 0;
//                    $starsFilledPer = '';
//                    $grayStarsPer = '';
//                }
//            } else {
//                $html .= '<div class="" style="padding: 20px; margin: 20px; background: #efefef; text-align: center; font-style: italic">No reviews have been created.</div>';
//            }

            $html .= '</div>';
            
            $html = '<div class="headermargin marginsept"></div><div class="">' . $html . '</div>';

            //<--END PAGE PROCESS-->//
            $content = array();
            $content[] = array("page_name" => $page, "page_title" => '', "page_content" => $html, "active" => true, "created" => time(), "last_edit" => '', "last_user" => '', "page_lock" => 'none', "page_type" => '', "page_desc" => '', "check_out" => false, "check_out_date" => '', "page_js" => '');

            return $content;
        } else {

            ///HANDLE PRODUCT CATEGORY OUTPUT HERE///

            $a = $data->query("SELECT * FROM custom_pages WHERE page_name = '$page' AND active = 'true'")or die($data->error);



            if($a->num_rows > 0){


                $b = $a->fetch_array();
                $pageTemplate = $b["page_content"];

                $matach = 'equipment_get';

                $categoryOut = preg_replace_callback('#{prodcat}data{/prodcat}#', function($match) use($page){


                    ////RETURN THE CATEGORIES HERE////
                    include('inc/config.php');
                    $a = $data->query("SELECT * FROM custom_pages WHERE page_name = '$page'")or die($data->error);
                    $b = $a->fetch_array();

                    $equip_content = json_decode($b["equipment_content"],true);


                    $catOut .= '<div class="row">';
                    for($i=0; $i<count($equip_content); $i++){
                        if($equip_content[$i]["type"] == 'category'){

                            $c = $data->query("SELECT * FROM custom_pages WHERE page_name = '".$equip_content[$i]["title"]."'")or die($data->error);
                            $d = $c->fetch_array();

                            $prodct = json_decode($d["equipment_content"],true);
                            $prodct = count($prodct);
                            //$catOut .= '<div class="image-cont col-md-4"><img style="width: 100%" title="'.$page.'" src=" '.$d["cat_img"].'"><br><span>'.str_replace('-',' ', $d["page_name"]).'</span></div>';

                            $catOut .= '<div class="col-md-4 col-sm-5">
            <div class="card" style="margin-bottom: 20px; border-radius: 0px; border: transparent;">
                <div class="product-image6">
                    <a href="'.$_SERVER['REQUEST_URI'].'/'.$d["page_name"].'">
                        <img class="pic-1 img-responsive fadeIn" src="'.$d["cat_img"].'">
                    </a>
                </div>
                <div class="product-content" style="padding: 20px;">
                    <h3 class="title" style="font-size: 1.3rem;"><a href="'.$_SERVER['REQUEST_URI'].'/'.$d["page_name"].'" style="color:black;">'.str_replace('-',' ', $d["page_name"]).'</a></h3>
                    <small style="padding: 3px">'.$d["page_desc"].'</small>
                    
                </div>
                <div class="social">
                   
                    <small style="padding: 3px; display: block; background: #fff; color: #333; height: auto">'.$d["page_desc"].'<br><br></small>
                    
                </div>
            </div>
        </div>';

                        }else{

                            $e = $data->query("SELECT * FROM custom_equipment WHERE title = '".$equip_content[$i]["title"]."'")or die($data->error);
                            $f = $e->fetch_array();

                            $bullets = json_decode($f["bullet_points"],true);
                            $bullOut .= '<ul style="display: block;text-align: left;font-size: 10px; color: #333; font-weight: bold">';

                            foreach ($bullets as $bull){
                                $bullOut .= '<li>'.$bull.'</li>';
                            }

                            if($f["price"] != null){
                                $priceOuts = '<span class="product-new-label" style="color: #333; font-weight:bold; font-size: 14px">Only $'.$f["sales_price"].'</span>';
                            }

                            $bullOut .= '</ul>';

                            $imageMain = json_decode($f["eq_image"],true);
                            $mainImage = $imageMain[0];

                            $catOut .= '<div class="col-md-4 col-sm-5' . $f["id"] . '" data-boxval="' . $f["id"] . '" >
    <div class="card" style="margin-bottom: 20px; border-radius: 0px; border: transparent;">
        <div class="product-image6">
            <a href="' . $_SERVER['REQUEST_URI'] . '/' . $f["title"] . '">
                <img class="pic-1 img-responsive fadeIn" style="padding: 20px;" src="../img/Custom/' . $mainImage . '">
                
            </a>
            <!--<ul class="social">
                <li><a href="javascript:void(0)" class="quick-btn" data-qukid="' . $f["id"] . '" data-eqtype="deere" data-tip="Quick View"><i class="fa fa-search"></i></a></li>
            </ul>
            ' . $priceOuts . '
           <span class="product-discount-label">Special Offers</span>-->
        </div>
        <!--<ul class="rating">
            <li class="fa fa-star"></li>
            <li class="fa fa-star"></li>
            <li class="fa fa-star"></li>
            <li class="fa fa-star"></li>
            <li class="fa fa-star disable"></li>
        </ul>-->
        <div class="product-content" style="border: transparent;">
            <h3 class="title" style="margin-bottom: 0; background: #383838; color: white; font-size: 20px;"><a href="' . $_SERVER['REQUEST_URI'] . '/' . $f["title"] . '" style="color: white;">' . $f["title"] . '</a></h3>
            
            <small style="min-height: 150px; display: block">' . $bullOut . '</small>
        </div>
    </div>
</div>';




                            $bullOut ='';

                        }
                    }

                    $catOut .= '</div>';
                    return $catOut;
                }, $pageTemplate);

                //$categoryOut = preg_replace_callback('#{prodcat}data{/prodcat}#',"equipment_get", $pageTemplate);



                $content[] = array("page_name" => $page, "page_title" => 'CATEGORY PAGE', "page_content" => $categoryOut, "active" => true, "created" => time(), "last_edit" => '', "last_user" => '', "page_lock" => 'none', "page_type" => '', "page_desc" => '', "check_out" => false, "check_out_date" => '', "page_js" => '');
                return $content;
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

}