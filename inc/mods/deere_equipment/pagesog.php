<?php
class deere_equipment
{


    function page($page)
    {

        include('inc/config.php');

        $a = $data->query("SELECT * FROM deere_equipment WHERE title = '$page'");
        if ($a->num_rows > 0) {
            $b = $a->fetch_array();
            $mainLink = $b["equip_link"];
            $equiplink = $mainLink;


            if ($b["last_updated"] == 0) {
                //UPDATE THE EQUIPMENT DATABASE HERE//
                $arrContextOptions = array(
                    "ssl" => array(
                        "verify_peer" => false,
                        "verify_peer_name" => false,
                    ),
                );

                $originallinkjson = file_get_contents($equiplink, false, stream_context_create($arrContextOptions));

                $decodeprod = json_decode($originallinkjson, true);


                //======META DATA======//
                $metaTitle = $decodeprod["Page"]["MetaData"]["Title"];
                $metaDescription = $decodeprod["Page"]["MetaData"]["Description"];
                $metaKeywords = $decodeprod["Page"]["MetaData"]["Keywords"];
                //======END META DATA======//

                //======OVERVIEW DATA======//
                $overView = $decodeprod["Page"]["product-summary"]["ProductOverview"];
                $productLinks = $decodeprod["Page"]["product-summary"]["OptionalLinks"];
                $productLinksDB = json_encode($productLinks);

                $productCatName = $decodeprod["Page"]["product-summary"]["ProductModelName"];
                $modelNumber = $decodeprod["Page"]["product-summary"]["ProductModelNumber"];
                $price = $decodeprod["Page"]["product-summary"]["ProductPrice"];
                $imageGallery = $decodeprod["Page"]["product-summary"]["ImageGalleryContainer"];
                $imageGalleryDB = json_encode($imageGallery);
                //======END OVERVIEW DATA======//

                //======FEATURES======//
                $featuresLinks = str_replace('.html', '.json', 'https://www.deere.com' . $decodeprod["Page"]["ESI Include Features"]["ESIFragments"]);
                $featuresJSON = file_get_contents($featuresLinks, false, stream_context_create($arrContextOptions));


                //======END FEATURES======//

                //======SPECS======//
                $specLinks = str_replace('.html', '.json', 'https://www.deere.com' . $decodeprod["Page"]["ESI Include Specifications"]["ESIFragments"]);
                $specJSON = file_get_contents($specLinks, false, stream_context_create($arrContextOptions));


                //======END SPECS======//

                //======OFFERS DATA=======//
                $offerlinkform = preg_replace('#[^/]*$#', '', $mainLink) . 'offers-json.html';

                $offers = file_get_contents($offerlinkform, false, stream_context_create($arrContextOptions));



                $offerstags = str_replace('<esi:assign name="jsonincludedata">', '', $offers);
                $offerstags = str_replace('</esi:assign>', '', $offerstags);
                $offerstags = str_replace('\'', '"', $offerstags);
                $offersOut = json_decode($offerstags, true);

                $finnalyOfffers = $offersOut["values"][0]["offers"];
                //======OFFERS DATA END=======//

                //======ACCESSORIES======//
                $accesslink = $decodeprod["Page"]["ESI Include Accessories-Attachments"]["ESIFragments"];
                $accLinkClean = str_replace('/html/deere/us/', '', $accesslink);
                $accLinkCleaner = str_replace('.html', '', $accLinkClean);

                $accLinkNow = 'https://www.deere.com/' . $accLinkCleaner . '.json';
                $accessobj = file_get_contents($accLinkNow, false, stream_context_create($arrContextOptions));



                $accessobjDec = json_decode($accessobj, true);
                //======END ACCESSORIES======//

                //======REVIEWS START========//
                $reviews = $decodeprod["Page"]["reviews-ratings"]["Review"];
                $reviewsDB = json_encode($reviews);
                //======END REVIEWS========//

                //======REVIEWS START========//
                $videos = $decodeprod["Page"]["video-gallery"]["Videos"];

                $videoDB = json_encode($videos);
                //======END REVIEWS========//

                //INSERT INTO DATABASE//
                $data->query("UPDATE deere_equipment SET model_number = '" . $data->real_escape_string($modelNumber) . "', eq_image = '" . $data->real_escape_string($imageGalleryDB) . "', product_overview = '" . $data->real_escape_string($overView) . "', features = '" . $data->real_escape_string($featuresJSON) . "', specs = '" . $data->real_escape_string($specJSON) . "', offers_storage = '" . $data->real_escape_string($offers) . "',accessories_storage = '" . $data->real_escape_string($accessobj) . "', review_rating_storage = '" . $data->real_escape_string($reviewsDB) . "', video_storage = '" . $data->real_escape_string($videoDB) . "', price = '" . $data->real_escape_string($price) . "', meta_title = '" . $data->real_escape_string($metaTitle) . "', meta_description = '" . $data->real_escape_string($metaDescription) . "', meta_keywords = '" . $data->real_escape_string($metaKeywords) . "', product_links = '" . $data->real_escape_string($productLinksDB) . "', last_updated = '" . time() . "' WHERE title = '$page'");
            } else {
                //PULL EQUIPMENT INFO DIRECTLY FROM DB//

                $metaTitle = $b["meta_title"];
                $metaDescription = $b["meta_description"];
                $metaKeywords = $b["meta_keywords"];

                $overView = $b["product_overview"];
                $productLinks = json_decode($b["product_links"], true);
                $productCatName = $b["sub_title"];
                $modelNumber = $b["model_number"];
                $price = $b["price"];
                $imageGallery = $b["eq_image"];

                $featuresJSON = $b["features"];
                $specJSON = $b["specs"];

                $offers = $b["offers_storage"];
                $offerstags = str_replace('<esi:assign name="jsonincludedata">', '', $offers);
                $offerstags = str_replace('</esi:assign>', '', $offerstags);
                $offerstags = str_replace('\'', '"', $offerstags);
                $offersOut = json_decode($offerstags, true);

                $finnalyOfffers = $offersOut["values"][0]["offers"];

                $accessobj = $b["accessories_storage"];
                $accessobjDec = json_decode($accessobj, true);

                $reviews = json_decode($b["review_rating_storage"], true);

                if ($b["video_storage"] != null) {
                    $videos = json_decode($b["video_storage"], true);
                }
            }

            //DO IMAGE THINGS//

            function isJSON($string)
            {
                return is_string($string) && is_array(json_decode($string, true)) && (json_last_error() == JSON_ERROR_NONE) ? true : false;
            }


            if (isJSON($imageGallery)) {
                $imageGallery = json_decode($imageGallery, true);
            } else {
                $imageGallery = $imageGallery;
            }


            if ($imageGallery[0]["ImageLarge"] != null) {
                for ($i = 0; $i < count($imageGallery); $i++) {
                    $eqImage[] = 'https://deere.com' . $imageGallery[$i]["ImageLarge"];
                }
            } else {
                $eqImage[] = 'https://deere.com' . $imageGallery["ImageLarge"];
            }


            $html .= $metaTitle . '<br>';
            $html .= $metaDescription . '<br>';
            $html .= $metaKeywords . '<br>';

            $html .= $productCatName . '<br>';
            $html .= $modelNumber . '<br>';
            $html .= $overView . '<br>';
            $html .= $price . '<br>';


            $html .= '<h1>FEATURES-SYSTEM</h1>' . $featuresLink . '<br>';

            $html .= '<h1>SPECS-SYSTEM</h1>' . $specLink . '<br>';


            //====START DEERE EQUIPMENT CONTAINER====//
            $htmlOut .= '<div class="deere_equipment_container container" style="position: relative; margin-top: 40px;">';

            //======START ROW FOR TOP======//
            $htmlOut .= '<div class="row" style="margin: 0 0 20px">';

            //======PROCESS EQ IMAGES======//
            $htmlOut .= '<div class="col-md-8">';


            $img = 0;
            foreach ($eqImage as $eqimage) {
                if ($img == 0) {
                    $htmlOut .= '<img style="width:100%; margin-bottom:5px" src="' . $eqimage . '">';
                }
                $img++;
            }

            $htmlOut .= '</div>';
            //====END EQ IMAGES====//

            //======RIGHT COLUMN DETAILS======//

            if ($price != null) {
                $priceOut = '<br><p class="price_area">Starting At:</p><h5><span class="thedeereprice" style="font-weight: bold; font-size: 22px; font-style: italic;">$' . $price . '</span></h5>';
            }

            //attempt brochure equipment link stuff//

            $productLinks = '<br><span><a href="' . $productLinks[1]["LinkUrl"] . '" target="_blank">' . $productLinks[1]["LinkText"] . '</a></span>';

            $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";



            $htmlOut .= '<div class="col-md-4 my-auto"><h1 class="model_header">' . $modelNumber . '</h1><h4 class="category_type">' . $productCatName . '</h4><br><div class="deere_overview">' . preg_replace('#<a.*?>.*?</a>#i', '', $overView) . '</div><br><button style="margin-right: 20px;"class="btn btn-success moreinfo" data-url="' . $actual_link . '" data-equipment="John Deere - ' . $modelNumber . '" data-toggle="modal" data-target="#exampleModal">Request A Quote</button><br><div class="modal" id="exampleModal" tabindex="-1" role="dialog">
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
          </div>' . $priceOut . ' ' . $productLinks . '</div>';


            //======END RIGHT COLUMN DETAILS======//

            $htmlOut .= '</div>';
            //====END TOP ROW==//

            $htmlOut .= '<div id="stick-here" style="background: #fff"></div><div id="stickThis" class="deere_section" style="background: #fff">';

            $htmlOut .= '<ul class="nav nav-pills" style="width: 100%; border-bottom: solid thin #efefef;">';
            $htmlOut .= '<li class="nav-item col-sm-auto">
            <a class="nav-link active" data-toggle="pill" href="#features" style="width: max-content;height: 100%;">FEATURES</a>
          </li>';

            $htmlOut .= '<li class="nav-item col-sm-auto">
            <a class="nav-link" data-toggle="pill" href="#specs">SPEC & COMPARE</a>
          </li>';

            if (!empty($finnalyOfffers)) {
                $htmlOut .= '<li class="nav-item col-sm-auto">
            <a class="nav-link" data-toggle="pill" href="#offers">OFFERS & DISCOUNTS</a>
          </li>';
            }

            $accArs = $accessobjDec["Page"]["expandcollapse"]["Section"]["SectionData"];
            if (!empty($accArs)) {
                $htmlOut .= '<li class="nav-item col-sm-auto">
            <a class="nav-link" data-toggle="pill" href="#accessories">ACCESSORIES & ATTACHMENTS</a>
          </li>';
            }

            if (!empty($reviews)) {
                $htmlOut .= '<li class="nav-item col-sm-auto">
            <a class="nav-link" data-toggle="pill" href="#reviews" style="width: max-content;height: 100%;">REVIEWS</a>
          </li>';
            }

            if (!empty($videos)) {
                $htmlOut .= '<li class="nav-item col-sm-auto">
            <a class="nav-link" data-toggle="pill" href="#videos">VIDEOS</a>
          </li>';
            }
            $htmlOut .= '</ul>';

            $htmlOut .= '</div>';


            $htmlOut .= '<div class="tab-content">';


            $htmlOut .= '<div class="tab-pane active" id="features">';
            //======START FEATURES AREA ROW======//
            $htmlOut .= '<div class="row " style="margin: 0; padding-top: 20px 0">';
            $htmlOut .= '<h2>Features</h2>';


            $htmlOut .= '<div id="accordion">'; //START TAB FEATURES//

            $DeereFeatures = json_decode($featuresJSON, true);
            $deereFetSecs = $DeereFeatures["Page"]["expandcollapse"]["Section"]["SectionData"]["Data"];



            if (count($deereFetSecs) > 2) {
                for ($i = 0; $i < count($deereFetSecs); $i++) {
                    $htmlOut .= '<div class="fetheads" data-toggle="collapse" data-target="#collapse' . $i . '" aria-expanded="true" aria-controls="collapse' . $i . '" style="padding: 10px; background:#efefef"><i class="fas fa-plus"></i> ' . $deereFetSecs[$i]["TitleQuestion"] . '</div>';
                    $htmlOut .= '<div id="collapse' . $i . '" class="collapse fetdets" aria-labelledby="heading' . $i . '" data-parent="#accordion">' . $deereFetSecs[$i]["Description"] . '</div>';
                }
            } else {
                $htmlOut .= '<div class="fetheads" data-toggle="collapse" data-target="#collapse1" aria-expanded="true" aria-controls="collapse1" style="padding: 10px; background:#efefef"><i class="fas fa-plus"></i> ' . $deereFetSecs["TitleQuestion"] . '</div>';
                $htmlOut .= '<div id="collapse1" class="collapse fetdets" aria-labelledby="heading1" data-parent="#accordion">' . $deereFetSecs["Description"] . '</div>';
            }


            $htmlOut .= '</div><!--end accord-->';


            $htmlOut .= '</div><!--end row-->';
            //=====END FEATURES AREA ROW=====//

            $specJSONs = json_decode($specJSON, true);

            $htmlOut .= '</div><!--end feature tab-->';

            $htmlOut .= '<div class="tab-pane" id="specs"><!--start spec tab-->';

            ////START TABLE////
            $htmlOut .= '<div class="row " style="margin: 0; padding-top: 20px">';

            $DeereSpecsRelated = $specJSONs["Page"]["specifications"]["RelatedModels"];

            if (!empty($DeereSpecsRelated)) {
                $specSele .= '<small>ADD MODEL</small><select class="form-control" name="compare_select" id="compare_select" style="margin: 0 0 0 auto;">';

                $specSele .= '<option>--Select to Compare--</option>';

                for ($o = 0; $o < count($DeereSpecsRelated); $o++) {
                    if ($DeereSpecsRelated[$o]["Name"]  != null) {
                        $specSele .= '<option value="' . $o . '" data-seleq="' . $page . '">' . $DeereSpecsRelated[$o]["Name"] . '</option>';
                    }
                }

                $specSele .= '</select>';
            }

            $htmlOut .= '<div class="col-sm-6 col-lg-8" style="padding: 0"><h2>Specs & Compare</h2></div><div class="col-sm-6 col-lg-4" style="text-align: right;width: 100%; padding: 0;">' . $specSele . '<br></div>';


            $htmlOut .= '<table class="table specstab">';

            $DeereSpecs = $specJSONs["Page"]["specifications"]["Category"];


            for ($j = 0; $j < count($DeereSpecs); $j++) {
                if ($j == 0) {
                    $htmlOut .= '<tr class="deerets" style="background: #efefef"><td><h4>' . $DeereSpecs[$j]["Name"] . '</h4></td><td><b>' . $modelNumber . '</b><br><small>Current Model</small></td></tr>';
                } else {
                    $htmlOut .= '<tr class="table_head" style="background: #efefef"><td><h4>' . $DeereSpecs[$j]["Name"] . '</h4></td><td></td></tr>';
                }
                $specInside = $DeereSpecs[$j]["Specs"];
                for ($k = 0; $k < count($specInside); $k++) {
                    $htmlOut .= '<tr class="deerets"><td><b>' . $specInside[$k]["Name"] . '</b></td><td>' . $specInside[$k]["CurrentModelDescription"] . '</td></tr>';
                }
            }
            $htmlOut .= '</table>';

            $htmlOut .= '</div>';


            $htmlOut .= '</div><!--end spec tab-->';

            $htmlOut .= '<div class="tab-pane" id="offers"><!--start offers tab-->';

            $htmlOut .= '<h2 style="margin: 20px">Offers & Discounts</h2>';


            $q = 0;
            foreach ($finnalyOfffers as $offerlink) {
                $offerLinkClean = str_replace('/html/deere/us/', '', $offerlink);
                $offersLinkNow = 'https://www.deere.com/' . $offerLinkClean . '/index.json';

                $jsonOffer = file_get_contents($offersLinkNow, false, stream_context_create($arrContextOptions));
                $objOffers = json_decode($jsonOffer, true);

                $today = strtotime("today midnight");

                if (is_null($objOffers["Page"]["special-offers"]["OfferEndDate"])) {
                    $enddate = $objOffers["Page"]["special-offers"]["special-offers"][1]["OfferEndDate"];
                } else {
                    $enddate = $objOffers["Page"]["special-offers"]["OfferEndDate"];
                }

                if ($today >= strtotime($enddate)) {
                    //echo "expired";
                } else {
                    //echo "active";
                    if (is_array($objOffers["Page"]["special-offers"])) {
                        if (is_array($objOffers["Page"]["special-offers"]["special-offers"])) {
                            $jsonOfferOut = file_get_contents('https://www.deere.com' . $objOffers["Page"]["special-offers"]["special-offers"][1]["ESIFragments"], false, stream_context_create($arrContextOptions));
                        } else {
                            $jsonOfferOut = file_get_contents('https://www.deere.com' . $objOffers["Page"]["special-offers"]["ESIFragments"], false, stream_context_create($arrContextOptions));
                        }


                        $disclaimer .= $objOffers["Page"]["disclaimer"]["DisclaimerContainer"]["Description"];

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
                }
            }


            if ($offerZZ != null) {
                $offerZZa .= '<div class="col-md-12" style="background: #fff">';

                $offerZZa .= '<div class="offers-holder">';
                $offerZZa .= $offerZZ;
                $offerZZa .= '</div>';

                $offerZZa .= '</div>';
                $offerZZa .= '<div class="disclaimers" style="font-size: .7rem; padding: 20px;">' . $disclaimer . '</div>';

                ///Store offers in db///
                //$data->query("UPDATE deere_equipment SET offers_storage = '".$data->real_escape_string($offerZZa)."' WHERE id = '".$id."'");
                $offershtml .= $offerZZa;
            } else {
                $offershtml = '<div class="col-6"><div class="alert alert-warning">No current offers.</div></div>';
            }

            $htmlOut .= preg_replace('#<a.*?>.*?</a>#i', '', $offershtml);

            $htmlOut .= '</div><!--end offers tab-->';


            $accArs = $accessobjDec["Page"]["expandcollapse"]["Section"]["SectionData"];
            if (!empty($accArs)) {

                $htmlOut .= '<div class="tab-pane" id="accessories" style="padding: 20px"><!--start accessories tab-->';

                $htmlOut .= '<h2>Accessories & Attachments</h2><br><br>';


                $htmlOut .= '<div id="accordion col-12">';

                for ($i = 0; $i < count($accArs); $i++) {

                    $accData = $accArs[$i]["Data"];
                    // loop through the data for each item //
                    if (count($accArs[$i]["Data"]) > 2) {
                        $htmlOut .= '<h4 style="margin: 14px 0px; padding: 10px; background:#efefef">' . $accArs[$i]["SubTitle"] . '</h4>';

                        for ($j = 0; $j < count($accData); $j++) {
                            if ($accData[$j]["TitleQuestion"] != null) {
                                $htmlOut .= '<div class="fetheads" data-toggle="collapse" data-target="#collapse' . $i . '' . $j . '" aria-expanded="true" aria-controls="collapse' . $i . '' . $j . '">' . $accData[$j]["TitleQuestion"] . '</div>';
                                if ($accData[$j]["Description"] != null) {
                                    $htmlOut .= '<div id="collapse' . $i . '' . $j . '" class="collapse fetdets" aria-labelledby="heading' . $i . '' . $j . '" data-parent="#accordion">' . $accData[$j]["Description"] . '</div>';
                                }
                            }
                        }
                    }
                }

                $htmlOut .= '</div>';


                $htmlOut .= '</div><!--end accessories tab-->';
            }

            if (!empty($reviews)) {
                $htmlOut .= '<div class="tab-pane" id="reviews" style="padding-top: 20px"><!--start accessories tab-->';

                $htmlOut .= '<h2>Reviews</h2><br><br>';

                for ($r = 0; $r < 10; $r++) {
                    $authorName = $reviews[$r]["AuthorName"];

                    $rating = $reviews[$r]["Rating"];
                    //do rating stuff//
                    $stars = '';
                    $cts = array();
                    $starsFull = '';
                    $starsEmpty = '';
                    for ($st = 0; $st < $rating; $st++) {
                        $starsFull .= '<i class="fa fa-star" style="color: green"></i>';
                        $cts[] = '';
                    }
                    if (count($cts) == 5) {
                        //DO NOTHING
                    } else {
                        $getBlankStars = 5 - count($cts);

                        for ($bnk = 0; $bnk < $getBlankStars; $bnk++) {
                            $starsEmpty .= '<i class="fa fa-star" style="color: #efefef"></i>';
                        }
                    }


                    $theReview = $reviews[$r]["ReviewText"];
                    $title = $reviews[$r]["Title"];
                    $usage = $reviews[$r]["UsageFrequency"];
                    $expert = $reviews[$r]["LevelOfExpertise"];
                    $lengthOwner = $reviews[$r]["LengthOfOwnership"];
                    $locationUser = $reviews[$r]["ReviewerLocation"];

                    $pros = $reviews[$r]["ProsText"];
                    $cons = $reviews[$r]["ConsText"];
                    if ($pros != null) {
                        $pros = '<b>Pros:</b> ' . $reviews[$r]["ProsText"];
                    }

                    if ($cons != null) {
                        $cons = '<b>Cons:</b> ' . $reviews[$r]["ConsText"];
                    }

                    if ($authorName != null) {
                        $htmlOut .= '<div class="row" style="padding: 5px; border-bottom: solid thin #efefef"><div class="col-md-3" style="font-style: italic"><b>' . $authorName . '</b><br><b>Location:</b> ' . $locationUser . '<br><b>Length of Ownership:</b> ' . $lengthOwner . '<br><b>Usage:</b> ' . $usage . '<br></div><div class="col-md-9"><b>' . $title . '</b><br>' . $starsFull . '' . $starsEmpty . '<br><p>' . $theReview . '</p><p>' . $pros . '<br>' . $cons . '</p></div></div>';
                    }
                }


                $htmlOut .= '</div><!--end review tab-->';
            }

            $htmlOut .= '<div class="tab-pane" id="videos" style="padding-top: 20px"><!--start accessories tab-->';

            $htmlOut .= '<h2>Videos</h2><br><br>';
            $htmlOut .= '<div class="row">';
            $htmlOut .= '<div class="col-lg-8">';
            $htmlOut .= '<div class="embed-responsive embed-responsive-16by9">
  <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/' . $videos[0]["Youtube"]["Id"] . '" allowfullscreen></iframe>
</div>';
            $htmlOut .= '</div>';
            $htmlOut .= '<div class="col-lg-4">';

            $htmlOut .= '<div class="row">';
            for ($v = 0; $v < count($videos); $v++) {
                $htmlOut .= '<div class="col-xl-6"><img style="width:100%" src="https://img.youtube.com/vi/' . $videos[$v]["Youtube"]["Id"] . '/0.jpg"></div>';
            }
            $htmlOut .= '</div>';


            $htmlOut .= '</div>';
            $htmlOut .= '</div>';
            $htmlOut .= '</div><!--end videos tab-->';
            //========END TAB AREA=======//
            $htmlOut .= '</div><!--end tab content-->';

            $htmlOut .= '</div>';
            //====END DEERE EQUIPMENT CONTAINER====//

            //DEPENDENCIES///

            //            $css[] = 'inc/mods/deere_equipment/deere-output/css/lightslider.css';
            //            $css[] = 'inc/mods/deere_equipment/deere-output/css/main.css';
            //            $css[] = 'inc/mods/deere_equipment/deere-output/css/jquery.paginate.css';
            //
            //            $js[] = 'inc/mods/deere_equipment/deere-output/js/lightslider.js';
            //            $js[] = 'inc/mods/deere_equipment/deere-output/js/jquery.paginate.js';
            //            $js[] = 'inc/mods/deere_equipment/deere-output/js/new-output.js';
            //            $js[] = 'inc/mods/deere_equipment/deere_functions.js';

            // $ars = array("css"=>$css, "js"=>$js);
            //======OUTPUT EQUIPMENT DATA======//
            $content = array();
            $content[] = array("page_name" => 'CATEGORY PAGE', "page_title" => 'FUN', "page_content" => $htmlOut, "active" => true, "created" => time(), "last_edit" => '', "last_user" => '', "page_lock" => 'none', "page_type" => '', "page_desc" => '', "check_out" => false, "check_out_date" => '', "page_js" => '', "dependants" => '');
            return $content;
            die();
        } else {
            //======TRY TO GET CATEGORY LISTING======//
            include('inc/config.php');
            $a = $data->query("SELECT * FROM deere_pages WHERE page_name = '$page' AND active = 'true'");
            if ($a->num_rows > 0) {
                $b = $a->fetch_array();
                $pageTemplate = $b["page_content"];


                $categoryOut = preg_replace_callback('#{prodcat}data{/prodcat}#', function ($match) use ($page) {
                    //SETUP CATEGORY OUTPUT UI//
                    include('inc/config.php');

                    $a = $data->query("SELECT * FROM deere_pages WHERE page_name = '$page' AND active = 'true'") or die($data->error);
                    $b = $a->fetch_array();

                    $itemData = json_decode($b["equipment_content"], true);
                    $deereContent .= '<div class="row">';
                    for ($i = 0; $i <= count($itemData); $i++) {
                        if ($itemData[$i]["type"] == 'category') {
                            //HANDLE EQUIPMENT CATEGORY INFO HERE//
                            $c = $data->query("SELECT cat_img,page_desc FROM deere_pages WHERE page_name = '" . $itemData[$i]["title"] . "'");
                            $d = $c->fetch_array();
                            $deereContent .= '<div class="col-12 col-sm-6 col-lg-4" style="width: 18rem;"><a href="' . $_SERVER['REQUEST_URI'] . '/' . $itemData[$i]["title"] . '"><img class="img-responsive" src="' . $d["cat_img"] . '" ></a><div style="padding: 0 10px"><h3 class="proxima-nova-condensed heavy" style="font-weight: bold; font-style: italic">' . str_replace("-", " ", $itemData[$i]["title"]) . '</h3><p style="padding-bottom: 20px">' . $d["page_desc"] . '</p></div></div>';
                        } else {
                            //HANDLE EQUIPMENT INFO HERE//
                            if ($itemData[$i]["title"] != null) {
                                include('inc/config.php');
                                $c = $data->query("SELECT * FROM deere_equipment WHERE title = '" . $itemData[$i]["title"] . "'");
                                $d = $c->fetch_array();
                                $imageThumb = json_decode($d["eq_image"], true);
                                $textCat = $d["model_number"];
                                $mainImg = 'https://deere.com' . $imageThumb["ImageThumbnail"];

                                if ($imageThumb["ImageThumbnail"] != null) {
                                    $mainImg = 'https://deere.com' . $imageThumb["ImageThumbnail"];
                                } else {
                                    $mainImg = 'https://deere.com' . $imageThumb[0]["ImageThumbnail"];
                                }
                                $deereContent .= '<div class="col-md-6 col-xl-4 d-flex"><div class="card" style="border: none; text-align: center;"><a href="' . $_SERVER['REQUEST_URI'] . '/' . $itemData[$i]["title"] . '"><img class="card-img-top" src="' . $mainImg . '"></a><div class="card-body" style="padding: 0 10px"><h3 class="proxima-nova-condensed heavy" style="font-weight: bold; font-style: italic">' . $textCat . '</h3><p class="card-text" style="padding-bottom: 20px">' . $d["product_overview"] . '</p></div></div></div>';
                            }
                        }
                    }

                    /*for($i=0; $i <= count($itemData); $i++) {

                    }*/


                    $deereContent .= '</div>';

                    return $deereContent;
                }, $pageTemplate);

                $content[] = array("page_name" => 'CATEGORY PAGE', "page_title" => 'FUN', "page_content" => $categoryOut, "active" => true, "created" => time(), "last_edit" => '', "last_user" => '', "page_lock" => 'none', "page_type" => '', "page_desc" => '', "check_out" => false, "check_out_date" => '', "page_js" => '', "dependants" => $arsOut);
                return $content;
            } else {
                ///NO DATA RETURN NEEDED///
            }
        }
    }
}
