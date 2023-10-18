<?php
class custom_equipment
{
    function page($page)
    {
        include('inc/config.php');
        $a = $data->query("SELECT * FROM custom_equipment WHERE title = '$page'") or die($data->error);
        if ($a->num_rows > 0) {
            $theSession = $_COOKIE["savedData"];

            //$html .= $theSession;


            $obj = $a->fetch_array();
            $title = str_replace('_', ' ', $obj["title"]);
            $outTitleSub = $obj["sub_title"];

            $bullets = $obj["bullet_points"];

            $imageMain = json_decode($obj["eq_image"], true);
            $image = $imageMain[0];

            $theprice = $obj["sales_price"];

            if (isset($theSession)) {
                //DO NOTHING//
            } else {
                //Location Getter//

                // check if location sel is turned on //
                $chk = $data->query("SELECT setting_value FROM shop_settings WHERE setting_name = 'location_select'");
                $chk1 = $chk->fetch_array();

                if ($chk1["setting_value"] == true) {

                    $cv = $data->query("SELECT id,location_name FROM location WHERE active = 'true'") or die($data->error);
                    while ($x = $cv->fetch_array()) {
                        //CHECK QTY FOR EACH LOCATION//

                        $u = $data->query("SELECT stock FROM equipment_location_manager WHERE equip_id = '" . $obj["id"] . "' AND location_id = '" . $x["id"] . "'");

                        if ($u->num_rows > 0) {
                            $w = $u->fetch_array();

                            if ($w["stock"] > 0) {
                                $locasel .= '<option value="' . $x["id"] . '">' . $x["location_name"] . '</option>';
                            } else {
                                $locasel .= '<option value="' . $x["id"] . '" disabled="disabled">' . $x["location_name"] . ' - Out of stock</option>';
                            }
                        } else {
                            $locasel .= '<option value="' . $x["id"] . '" disabled="disabled">' . $x["location_name"] . ' - Out of stock</option>';
                        }
                    }
                }
            }

            $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
            $uniqIDs = md5(date('djsi'));


            //check location selection//
            if (isset($theSession)) {
                $convertJsn = json_decode($theSession, true);
                $locids = $convertJsn["shop_location"];
                $chk = $data->query("SELECT setting_value FROM shop_settings WHERE setting_name = 'location_select'");
                $chk1 = $chk->fetch_array();
                if ($chk1["setting_value"] == 'true') {

                    $m = $data->query("SELECT location_name FROM location WHERE id = '$locids'");
                    $l = $m->fetch_array();

                    $locationSet = $l["location_name"];
                    $locOut .= '<b>Store Location:</b> <i>' . $locationSet . '</i><input type="hidden" name="locasel" id="locasel" value="' . $locids . '">';

                    //check stock for selected location//
                    $u = $data->query("SELECT stock FROM equipment_location_manager WHERE equip_id = '" . $obj["id"] . "' AND location_id = '" . $locids . "'");
                    $x = $u->fetch_array();


                    if ($x["stock"] > 0) {
                        if (array_search($obj["title"], array_column($convertJsn["cartitems"], 'name')) !== FALSE && $convertJsn["cartitems"] != null) {
                            $disabs = 'disabled="disabled"';
                            $buttonText = 'Already in Cart';
                        } else {
                            $disabs = '';
                            $buttonText = 'Add to Cart';
                        }
                    } else {
                        $disabs = 'disabled="disabled"';
                        $buttonText = 'Out of stock';
                    }
                } else {

                    // check if sell_per_qty is true //

                    $chk = $data->query("SELECT setting_value FROM shop_settings WHERE setting_name = 'sell_per_qty'");
                    $chk1 = $chk->fetch_array();
                    if ($chk1["setting_value"] == 'true') {
                        //check stock for selected location//
                        $u = $data->query("SELECT stock FROM equipment_location_manager WHERE equip_id = '" . $obj["id"] . "' AND location_id = '" . $locids . "'");
                        $x = $u->fetch_array();


                        if ($x["stock"] > 0) {
                            if (array_search($obj["title"], array_column($convertJsn["cartitems"], 'name')) !== FALSE && $convertJsn["cartitems"] != null) {
                                $disabs = 'disabled="disabled"';
                                $buttonText = 'Already in Cart';
                            } else {
                                $disabs = '';
                                $buttonText = 'Add to Cart';
                                $chk = $data->query("SELECT setting_value FROM shop_settings WHERE setting_name = 'qty_sel_prod_page'");
                                $chk1 = $chk->fetch_array();
                                if ($chk1["setting_value"] == 'true') {
                                    $qtyBox = '<input style="padding: 10px" class="" type="number" name="qty" id="qty" value="1">';
                                } else {
                                    $qtyBox = '<input class="" type="hidden" name="qty" id="qty" value="1">';
                                }
                            }
                        } else {
                            $disabs = 'disabled="disabled"';
                            $buttonText = 'Out of stock';
                        }
                    } else {
                        if (array_search($obj["title"], array_column($convertJsn["cartitems"], 'name')) !== FALSE && $convertJsn["cartitems"] != null) {
                            $disabs = 'disabled="disabled"';
                            $buttonText = 'Already in Cart';
                        } else {
                            $disabs = '';
                            $buttonText = 'Add to Cart';
                            $chk = $data->query("SELECT setting_value FROM shop_settings WHERE setting_name = 'qty_sel_prod_page'");
                            $chk1 = $chk->fetch_array();
                            if ($chk1["setting_value"] == 'true') {
                                $qtyBox = '<input style="padding: 10px" class="" type="number" name="qty" id="qty" value="1">';
                            } else {
                                $qtyBox = '<input class="" type="hidden" name="qty" id="qty" value="1">';
                            }
                        }
                    }
                }
            } else {
                $chk = $data->query("SELECT setting_value FROM shop_settings WHERE setting_name = 'location_select'");
                $chk1 = $chk->fetch_array();
                if ($chk1["setting_value"] == 'true') {
                    $locOut .= 'Select Store Location<br><select class="form-control" id="locasel" name="locasel"><option value="">Select Store Location</option>' . $locasel . '</select>';
                    $disabs = 'disabled="disabled"';
                    $buttonText = 'Add to Cart';
                    $qtyBox = '<input class="" type="hidden" name="qty" id="qty" value="1">';
                } else {
                    $chk = $data->query("SELECT setting_value FROM shop_settings WHERE setting_name = 'qty_sel_prod_page'");
                    $chk1 = $chk->fetch_array();
                    if ($chk1["setting_value"] == 'true') {

                        // some checking for stock if sell_per_qty enabled //
                        $chk = $data->query("SELECT setting_value FROM shop_settings WHERE setting_name = 'sell_per_qty'");
                        $chk1 = $chk->fetch_array();
                        if ($chk1["setting_value"] == 'true') {
                            $locs = $data->query("SELECT setting_value FROM shop_settings WHERE setting_name = 'default_ship_location'");
                            $local = $locs->fetch_array();
                            $theLocation = $local["setting_value"];
                            if ($theLocation != null) {
                                $stockInd = 'false';
                                $aa = $data->query("SELECT stock FROM equipment_location_manager WHERE equip_id = '" . $obj["id"] . "' AND location_id = '$theLocation'");
                                $bb = $aa->fetch_array();

                                if ($bb["stock"] > 0) {
                                    $stockInd = 'true';
                                    $locOut = 'Quantity';
                                    $qtyBox = '<input style="padding: 10px" class="" type="number" name="qty" id="qty" value="1">';
                                    $buttonText = 'Add to Cart';
                                } else {
                                    $stockInd = 'true';
                                    $locOut = '';
                                    $qtyBox = '';
                                    $disabs = 'disabled="disabled"';
                                    $buttonText = 'Out of Stock';
                                }
                            } else {
                                $stockInd = 'false';
                                $disabs = 'disabled="disabled"';
                                $buttonText = 'Out of Stock';
                            }
                        } else {
                            $locOut = 'Quantity';
                            $qtyBox = '<input style="padding: 10px" class="" type="number" name="qty" id="qty" value="1">';
                            $buttonText = 'Add to Cart';
                        }
                    } else {
                        $locOut = '';
                        $qtyBox = '<input class="" type="hidden" name="qty" id="qty" value="1">';
                        $buttonText = 'Add to Cart';
                    }
                }
            }
            //converting url adress to array
            $cat_link = implode(parse_url($_SERVER["REQUEST_URI"]));
            $final_cat_chain = explode("/", $cat_link);
            array_pop($final_cat_chain);

            //creating category name from page url
            $category_name = $final_cat_chain[sizeof($final_cat_chain) - 1];

            //creating category link from page url
            $category_link = implode("/", $final_cat_chain);



            $html .= '<div class="container" style="padding-top: 40px; padding-bottom: 40px;"><div class=" mt-2" style="padding: 20px 20px 0">
    <div class="card" style="border:none;">
        <div class="row g-0">
            <div class="col-md-6 border-end" align="center">
                <div class="d-flex flex-column justify-content-center">
                    <div class="main_image"> <img src="../img/custom/' . $image . '" id="main_product_image" style="width: 80%;margin: 0 auto;"> </div>
                    <!--<div class="thumbnail_images">
                        <ul id="thumbnail">
                            <li><img onclick="changeImage(this)" src="https://i.imgur.com/TAzli1U.jpg" width="70"></li>
                            <li><img onclick="changeImage(this)" src="https://i.imgur.com/w6kEctd.jpg" width="70"></li>
                            <li><img onclick="changeImage(this)" src="https://i.imgur.com/L7hFD8X.jpg" width="70"></li>
                            <li><img onclick="changeImage(this)" src="https://i.imgur.com/6ZufmNS.jpg" width="70"></li>
                        </ul>
                    </div>-->
                </div>
            </div>
            <div class="col-md-6">
                <div class="right-side">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="mb-0">' . str_replace('-', ' ', $title) . '</h3>  
                    </div>
                    <a href="' . $category_link . '" style="text-decoration: none; color: #005797; text-transform: capitalize;">' . str_replace('-', ' ', $category_name) . '</a>
                    <div class="mt-2 pr-3 content">
                        <p>' . $obj["features"] . '</p>
                    </div>
                    <h3 class="mb-1">$' . number_format($obj["msrp"], 2) . '</h3>
                    <p class="text-muted">SKU: ' . $obj["sku"] . '</p>
                    <div class="ratings d-flex flex-row align-items-center mt-3">
                        <div class="d-flex flex-row"> <i class=\'bx bxs-star\'></i> <i class=\'bx bxs-star\'></i> <i class=\'bx bxs-star\'></i> <i class=\'bx bxs-star\'></i> <i class=\'bx bx-star\'></i> </div>
                    </div>
                    <!--<div class="mt-5"> <span class="fw-bold">Color</span>
                        <div class="colors">
                            <ul id="marker">
                                <li id="marker-1"></li>
                                <li id="marker-2"></li>
                                <li id="marker-3"></li>
                                <li id="marker-4"></li>
                                <li id="marker-5"></li>
                            </ul>
                        </div>
                    </div>-->
                    <!-- AddToAny BEGIN -->
<a class="a2a_dd" href="https://www.addtoany.com/share"></a>
<a class="a2a_button_facebook"></a>
<a class="a2a_button_twitter"></a>
<a class="a2a_button_google_plus"></a>
<a class="a2a_button_email"></a><script async src="https://static.addtoany.com/menu/page.js"></script>
</div>
                    <!--<div class="mt-5 col-md-6" style="padding: 0">' . $locOut . '</div>-->
                    <div class="buttons d-flex flex-row mt-3 gap-3">' . $qtyBox . '<button class="btn btn-dark save-later disabs" style="border-radius:0; margin: 0 0 0 5px; font-size: 17px;" data-eqid="' . $obj["id"] . '" data-eqname="' . $obj["title"] . '" data-eqtype="custom" data-price="' . $obj["msrp"] . '" data-url="' . $actual_link . '" data-tabs="custom_equipment" data-pickup="'.$obj["pickup_only"].'" data-itemid="' . $uniqIDs . '" ' . $disabs . '>' . $buttonText . '</button> </div>
                    
                </div>
            </div>
        </div>
        <hr>
    </div>
    <style>.striped_details p:nth-child(odd) {background-color: #f2f2f2;} .striped_details p{margin-bottom: 0;padding: 10px 0 10px 10px;}</style>
    <div class="col-md-12 striped_details" style="margin:0;"><h2 style="color:white; background-color: #005797; padding: 5px; margin-bottom: 0 !important;">Product Details</h2>' . $obj["description"] . '</div>
</div></div>';

            $js[] = 'inc/mods/custom_equipment/custom_functions.js';
            $css[] = '';

            $ars = array("css" => $css, "js" => $js);

            $arsOut = json_encode($ars);

            $content[] = array("page_name" => $page, "page_title" => '', "page_content" => $html, "active" => true, "created" => time(), "last_edit" => '', "last_user" => '', "page_lock" => 'none', "page_type" => '', "page_desc" => '', "check_out" => false, "check_out_date" => '', "page_js" => '', 'dependants' => $arsOut);
            return $content;
        } else {
            // OUTPUT CATEGORY //

            ///HANDLE PRODUCT CATEGORY OUTPUT HERE///

            $a = $data->query("SELECT * FROM custom_pages WHERE page_name = '$page' AND active = 'true'") or die($data->error);

            if ($a->num_rows > 0) {

                $b = $a->fetch_array();
                $pageTemplate = $b["page_content"];

                $matach = 'equipment_get';

                $categoryOut = preg_replace_callback('#{prodcat}data{/prodcat}#', function ($match) use ($page) {

                    ////RETURN THE CATEGORIES HERE////
                    include('inc/config.php');
                    $a = $data->query("SELECT * FROM custom_pages WHERE page_name = '$page'") or die($data->error);
                    $b = $a->fetch_array();

                    $equip_content = json_decode($b["equipment_content"], true);

                    $catOut .= '<div class="row">';
                    for ($i = 0; $i < count($equip_content); $i++) {
                        if ($equip_content[$i]["type"] == 'category') {

                            $c = $data->query("SELECT * FROM custom_pages WHERE page_name = '" . $equip_content[$i]["title"] . "'") or die($data->error);
                            $d = $c->fetch_array();

                            $prodct = json_decode($d["equipment_content"], true);
                            $prodct = count($prodct);
                            //$catOut .= '<div class="image-cont col-md-4"><img style="width: 100%" title="'.$page.'" src=" '.$d["cat_img"].'"><br><span>'.str_replace('-',' ', $d["page_name"]).'</span></div>';

                            $catOut .= '<div class="col-md-6 col-lg-4">
            <div class="card" style="margin-bottom: 20px; border-radius: 0px; border: transparent;">
                <div class="product-image6">
                    <a href="' . $_SERVER['REQUEST_URI'] . '/' . $d["page_name"] . '">
                        <img class="pic-1 img-responsive fadeIn" style="object-fit: cover; width: 100%; height: 200px;" src="' . $d["cat_img"] . '">
                    </a>
                </div>
                <div class="product-content" style="padding: 20px;">
                    <h3 class="title text-center"><a href="' . $_SERVER['REQUEST_URI'] . '/' . $d["page_name"] . '" style="font-family:Bebas Neue, cursive">' . str_replace('-', ' ', $d["page_name"]) . '</a></h3>
                    <small style="padding: 3px">' . $d["page_desc"] . '</small>
                    
                </div>
                <div class="social">
                   
                    <small style="padding: 3px; display: block; background: #fff; color: #333; height: auto">' . $d["page_desc"] . '<br><br></small>
                    
                </div>
            </div>
        </div>';
                        } else {

                            $e = $data->query("SELECT * FROM custom_equipment WHERE title = '" . $equip_content[$i]["title"] . "'") or die($data->error);
                            $f = $e->fetch_array();

                            $bullets = json_decode($f["bullet_points"], true);
                            $bullOut .= '<ul style="display: block;text-align: left;font-size: 10px; color: #333; font-weight: bold">';

                            foreach ($bullets as $bull) {
                                $bullOut .= '<li>' . $bull . '</li>';
                            }

                            if ($f["price"] != null) {
                                $priceOuts = '<span class="product-new-label" style="color: #333; font-weight:bold; font-size: 14px">Only $' . $f["sales_price"] . '</span>';
                            }

                            $bullOut .= '</ul>';

                            $imageMain = json_decode($f["eq_image"], true);
                            $mainImage = $imageMain[0];


                            $catOut .= '<div class="col-md-6 col-lg-4" data-boxval="' . $f["id"] . '" >
    <div class="card" style="margin-bottom: 20px; border-radius: 0px; border: transparent;">
        <div class="product-image6">
            <a href="' . $_SERVER['REQUEST_URI'] . '/' . $f["title"] . '">
                <img class="pic-1 img-responsive fadeIn" style="object-fit: cover; width: 100%; height: 200px;" src="../img/custom/' . $mainImage . '">
                
            </a>
            <!--<ul class="social">
                <li><a href="javascript:void(0)" class="quick-btn" data-qukid="' . $f["id"] . '" data-eqtype="deere" data-tip="Quick View"><i class="fa fa-search"></i></a></li>
            </ul>
            ' . $priceOuts . '
           <span class="product-discount-label">Special Offers</span>-->
        </div>
        <!--<ul class="rating">
            <li class="fa fa-star"></li>s
            <li class="fa fa-star"></li>
            <li class="fa fa-star"></li>
            <li class="fa fa-star"></li>
            <li class="fa fa-star disable"></li>
        </ul>-->
        <div class="product-content" style="border: transparent;">
            <h3 class="title text-center"><a href="' . $_SERVER['REQUEST_URI'] . '/' . $f["title"] . '" style="font-family:Bebas Neue, cursive">' . str_replace('-', ' ', $f["title"]) . '</a></h3>
            
            <small style="min-height: 50px; display: block"></small>
        </div>
    </div>
</div>';




                            $bullOut = '';
                        }
                    }

                    $catOut .= '</div>';
                    return $catOut;
                }, $pageTemplate);

                //$categoryOut = preg_replace_callback('#{prodcat}data{/prodcat}#',"equipment_get", $pageTemplate);

                $js[] = 'inc/mods/custom_equipment/custom_functions.js';
                $css[] = '';

                $ars = array("css" => $css, "js" => $js);


                $arsOut = json_encode($ars);



                $content[] = array("page_name" => $page, "page_title" => 'CATEGORY PAGE', "page_content" => $categoryOut, "active" => true, "created" => time(), "last_edit" => '', "last_user" => '', "page_lock" => 'none', "page_type" => '', "page_desc" => '', "check_out" => false, "check_out_date" => '', "page_js" => '', 'dependants' => $arsOut);
                return $content;
            } else {
                ////DO NOTHING TO RETURN 404////
            }
        }
    }
}
