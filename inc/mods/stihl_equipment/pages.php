<?php
class stihl_equipment
{
    function page($page)
    {
        include('inc/config.php');
        $a = $data->query("SELECT * FROM stihl_equipment WHERE title = '$page'") or die($data->error);
        if ($a->num_rows > 0) {

            $obj = $a->fetch_array();
            $title = str_replace('_', ' ', $obj["title"]);
            $equipPrice = $obj["price"];
            $equipMake = "STIHL";
            $equipModel = $obj["parent_cat"];
            $sku = $obj["parent_cat"];
            $sku_num = $obj["sku"];

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
                        <input type="hidden" name="eqiptype" id="eqiptype" value="stihl">
                        
                        <button class="btn btn-success">Submit Review</button>
                    </form>
                </div>
                
            </div>
        </div>
    </div>';


            $price = str_replace('*', '', $obj["price"]);
            $imageMain = json_decode($obj["eq_image"], true);
            $image = $imageMain[0];
            $tt = $obj["common_name"];

            $html .= '<h1 class="" style="text-transform: capitalize; text-align:center;">' . $tt . '</h1><div class="row">';

            $html .= '<div class="col-md-8" style="padding:0; padding-bottom: 60px;"><img class="img-responsive" style="display:block; margin:0px auto; max-height: 500px; object-fit: contain;" src="' . $image . '"></div>';

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
            $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";


            // $tt = str_replace('-', ' ', $title);


            $html .= '<div class="col-md-4" style="margin-top: 20px;"><h5><strong>Make: </strong>' . $equipMake . '</h5><h5><strong>Model: </strong>' . $equipModel . '</h5><h5><strong>Price: </strong>$' . $equipPrice . '</h5> <!--<button class="btn btn-success moreinfo parts-button" style="background-color:#FF7900; border-color: #FF7900; "data-url="' . $actual_link . '" data-equipment="Stihl - ' . $title . '" data-toggle="modal" data-target="#exampleModal">Request A Quote</button>' . $saveButton . '<br><br>-->

<div style="margin-top:7px">
<div><label class=" required ">
<h5 class="labelText">Store Pickup Location</h5>
<select required="" name="Store Pickup Location" placeholder="" class="filled form-control" id="in-store-pickup-location">
<option selected="" value="" disabled="">Select</option>
  <option value="https://riestererandschnellantigo.stihldealer.net/redirect/?sku=' . $sku_num . '">Antigo, WI</option>
  <option value="https://riestererschnellinccampbellsport.stihldealer.net/redirect/?sku=' . $sku_num . '">Campbellsport, WI</option>
  <option value="https://riestererschnellincchilton.stihldealer.net/redirect/?sku=' . $sku_num . '">Chilton, WI</option>
  <option value="https://riestererandschnelldenmark.stihldealer.net/redirect/?sku=' . $sku_num . '">Denmark, WI</option>
  <option value="https://riestererandschellfonddulac.stihldealer.net/redirect/?sku=' . $sku_num . '">Fond du Lac, WI</option>
  <option value="https://riestererschnellinchortonville.stihldealer.net/redirect/?sku=' . $sku_num . '">Hortonville, WI</option>
  <option value="https://riestererschnellincmarion.stihldealer.net/redirect/?sku=' . $sku_num . '">Marion, WI</option>
  <option value="https://riestererschnellincneenah.stihldealer.net/redirect/?sku=' . $sku_num . '">Neenah, WI</option>
  <option value="https://riestererschnellinc.stihldealer.net/redirect/?sku=' . $sku_num . '">Pulaski, WI</option>
  <option value="https://riestererschnellshawano.stihldealer.net/redirect/?sku=' . $sku_num . '">Shawano, WI</option>
  <option value="https://riestererschnellstevenspoint.stihldealer.net/redirect/?sku=' . $sku_num . '">Stevens Point, WI</option>
  <option value="https://riestererschnellstratford.stihldealer.net/redirect/?sku=' . $sku_num . '">Stratford, WI</option>
  <option value="https://riestererschnellwestfield.stihldealer.net/redirect/?sku=' . $sku_num . '">Westfield, WI</option></select></label><br>
 <button type="submit" id="buy-online" style="margin:5px 0 15px; background-color:#FF7900; border-color: #FF7900;" class="btn btn-success" onclick="linkSelected()">Buy Online</button>
 </div>
 </div>
<!-- AddToAny BEGIN -->
<div class="a2a_kit a2a_kit_size_32 a2a_default_style">
<a class="a2a_dd" href="https://www.addtoany.com/share"></a>
<a class="a2a_button_facebook"></a>
<a class="a2a_button_twitter"></a>
<a class="a2a_button_google_plus"></a>
<a class="a2a_button_email"></a>
</div>

<script async src="https://static.addtoany.com/menu/page.js"></script>
<script>
 function linkSelected(){
  // var linkSelected = document.getElementById(\'in-store-pickup-location\').value;
  var e = document.getElementById(\'in-store-pickup-location\');
  var value = e.options[e.selectedIndex].value;
  window.open(value, \'blank\');
  console.log(value);
 }
</script>
<!-- AddToAny END<br><br><div style="font-size:30px">' . $starsNow . ' <br>' . $readRevs . ' <a style="font-size: 12px" href="javascript:void(0)" class="reviewit" data-neweqids="' . $obj["id"] . '"></a></div><br><br>' . $optLinksOut . '<br><br><div class="offer-titles-set"></div>--></div>';

            $html .= '<div class="clearfix"></div><br>';


            $specLink = $obj["specs"];

            if ($specLink != NULL) {

                $html .= '<div class="container spec-contain" style="margin-top: 10px;margin-bottom: 50px;">';

                //$html .= '<div class="table-responsive table table-striped">';
                $specs1 = json_decode($obj["specs"], true);
                if (!empty($specs1)) {
                    $html .= '<h3 style="background: #F26729; padding: 10px; color: #fff; display: block">Specifications</h3><div style="margin: 0 20px 10px 20px;"><table class="table table-striped"><tbody>';
                }
                for ($i = 0; $i < count($specs1); $i++) {
                    $html .= '<tr><th scope="row">' . $specs1[$i]["name"] . '</th><td>';
                    $html .= $specs1[$i]["description"] . '</td>';
                    $html .= '</tr>';
                }

                $html .= '</tbody></table></div></div><!--End of Specs-->';
            }

            $html .= '<div class="clearfix"></div><br>';

            $html .= '<div class="container spec-contain" style="margin-top: 10px;margin-bottom: 50px;">';

            $features1 = json_decode($obj["features"], true);
            if (!empty($features1)) {
                $html .= '<h3 style="background: #F26729; padding: 10px; color: #fff; display: block">Features</h3>';
            }
            for ($i = 0; $i < count($features1); $i++) {

                $html .= '<div class="row" style="margin: 20px 20px 0 20px;"><div class="col-md-4" style="text-align:center;"><img class="img-responsive" style="width: 75%; object-fit: contain;" src="' . $features1[$i]["imageurl"] . '"></div><div class="col-md-8">';
                $html .= $features1[$i]["description"] . '</div></div><hr>';
            }

            $html .= '</div><!--End of Features-->';

            $html .= '<div class="clearfix"></div>';

            if ($obj["extra_content"] != '') {
                $html .= '<div class="col-md-12 extra-content">' . $obj["extra_content"] . '</div>';
                $html .= '<div class="clearfix"></div><br>';
            }

            $html .= '</div>';
            $html .= '<div class="clearfix"></div>';

            $html .= '</div>';

            $html = '<div class="headermargin marginsept"></div><div class="container">' . $html . '</div>';

            //<--END PAGE PROCESS-->//
            $content = array();
            $content[] = array("page_name" => $page, "page_title" => '', "page_content" => $html, "active" => true, "created" => time(), "last_edit" => '', "last_user" => '', "page_lock" => 'none', "page_type" => '', "page_desc" => '', "check_out" => false, "check_out_date" => '', "page_js" => '');

            return $content;
        } else {

            ///HANDLE PRODUCT CATEGORY OUTPUT HERE///

            $a = $data->query("SELECT * FROM stihl_pages WHERE page_name = '$page' AND active = 'true'");

            if ($a->num_rows > 0) {
                $b = $a->fetch_array();
                $pageTemplate = $b["page_content"];

                $matach = 'equipment_get';

                $categoryOut = preg_replace_callback('#{prodcat}data{/prodcat}#', function ($match) use ($page) {

                    ////RETURN THE CATEGORIES HERE////
                    include('inc/config.php');
                    $a = $data->query("SELECT * FROM stihl_pages WHERE page_name = '$page'");
                    $b = $a->fetch_array();

                    $equip_content = json_decode($b["equipment_content"], true);
                    $catOut .= '<div class="row">';
                    for ($i = 0; $i < count($equip_content); $i++) {
                        if ($equip_content[$i]["type"] == 'category') {
                            $c = $data->query("SELECT * FROM stihl_pages WHERE page_name = '" . $equip_content[$i]["title"] . "'");
                            $d = $c->fetch_array();

                            $prodct = json_decode($d["equipment_content"], true);
                            $prodct = count($prodct);

                            $catOut .= '<div class="col-md-4 col-sm-5">
            <div class="card" style="margin-bottom: 90px; border-radius: 0px; border: transparent; box-shadow:0 4px 8px 0 rgb(0 0 0 / 20%), 0 6px 20px 0 rgb(0 0 0 / 19%);">
                <div class="product-image6">
                    <a href="' . $_SERVER['REQUEST_URI'] . '/' . $d["page_name"] . '">
                        <img class="pic-1 img-responsive fadeIn" style="height: 250px; object-fit: cover; padding:20px" src="' . $d["cat_img"] . '">
                    </a>
                </div>           
                <div class="product-content" style="padding: 20px">
                    <h3 class="title" style="font-size: 1.3rem; text-align:center;"><a style="color: black;" href="' . $_SERVER['REQUEST_URI'] . '/' . $d["page_name"] . '">' . str_replace('-', ' ', $d["page_name"]) . '</a></h3>
                    <small style="padding: 3px; min-height: 50px; display: none">' . $d["page_desc"] . '</small>
                    
                </div>
            </div>
        </div>';
                        } else {

                            if ($equip_content[$i]["type"] == 'htmlarea') {
                                ////ADD HTML TYPE OUTPUTS HERE////
                                $catOut .= '<div class="clearfix"></div>';
                                $catOut .= $this->getBeanItems($equip_content[$i]["title"], '');
                                $catOut .= '<div class="clearfix"></div>';
                            } else {


                                $e = $data->query("SELECT title, eq_image, id, price, common_name FROM stihl_equipment WHERE title = '" . $equip_content[$i]["title"] . "'") or die($data->error);
                                $f = $e->fetch_array();
                                $name= $f["common_name"];
                                $name1 = substr($name, 0, strpos($name, "-"));
                                $name2= strtoupper($name1);

                                $bullets = json_decode($f["bullet_points"], true);
                                $bullOut .= '<ul style="display: block;text-align: left;font-size: 10px; color: #333; font-weight: bold">';

                                foreach ($bullets as $bull) {
                                    $bullOut .= '<li>' . $bull . '</li>';
                                }

                                if ($f["price"] != null) {
                                    $priceOuts = '<span class="product-new-label" style="color: #333; font-weight:bold; font-size: 14px; padding-left: 20px;">MSRP STARTING AT $' . $f["price"] . '</span>';
                                }

                                $isitars = json_decode($f["eq_image"], true);

                                if (is_array($isitars)) {
                                    $equipImg = $isitars[0];
                                } else {
                                    $equipImg = str_replace('""', '', $f["eq_image"]);
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
            <div class="card" style="margin-bottom: 90px;border: transparent; box-shadow:0 4px 8px 0 rgb(0 0 0 / 20%), 0 6px 20px 0 rgb(0 0 0 / 19%);">
                <div class="product-image">
                    <a href="' . $_SERVER['REQUEST_URI'] . '/' . $f["title"] . '">
                        <img class="pic-1 pic-y img-responsive fadeIn" style="height: 250px; object-fit: cover; padding: 20px;" src="' . $equipImg . '">
                        
                    </a>
                  
                </div>
              
                <div class="product-content" style="border: transparent;">
                    <h3 class="title" style="margin-bottom: 0; background: #FF7900; color: white; font-size: 20px; text-align:center;"><a style="color: white; padding-left: 20px;"href="' . $_SERVER['REQUEST_URI'] . '/' . $f["title"] . '">' . $name2 . '</a></h3>
                    
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

                if (strpos($_SERVER['REQUEST_URI'], 'Used-Equipment') != true) {

                    $css[] = 'inc/mods/stihl_equipment/stihl-output/css/lightslider.css';
                    $css[] = 'inc/mods/stihl_equipment/stihl-output/css/main.css';
                    $css[] = 'inc/mods/stihl_equipment/stihl-output/css/jquery.paginate.css';

                    $js[] = 'inc/mods/stihl_equipment/stihl-output/js/lightslider.js';
                    $js[] = 'inc/mods/stihl_equipment/stihl-output/js/jquery.paginate.js';
                    $js[] = 'inc/mods/stihl_equipment/stihl-output/js/new-output.js';
                    $js[] = 'inc/mods/stihl_equipment/stihl_functions.js';

                    $ars = array("css" => $css, "js" => $js);


                    $arsOut = json_encode($ars);

                    $content[] = array("page_name" => 'CATEGORY PAGE', "page_title" => 'CATEGORY PAGE', "page_content" => $categoryOut, "active" => true, "created" => time(), "last_edit" => '', "last_user" => '', "page_lock" => 'none', "page_type" => '', "page_desc" => '', "check_out" => false, "check_out_date" => '', "page_js" => '', "dependants" => $arsOut);
                    return $content;
                }
            } else {
                ////DO NOTHING TO RETURN 404////
            }
        }
    }
}
