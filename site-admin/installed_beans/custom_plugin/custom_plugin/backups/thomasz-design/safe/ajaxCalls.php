<?php
include('config.php');
$act = $_REQUEST["action"];

if($act == 'requestcat'){
    $sel .= '<option value="none">Select Option</option>';
    if($_REQUEST["manufacturer"] != 'none') {
        $a = $data->query("SELECT * FROM used_equipment WHERE manufacturer = '" . $_REQUEST["manufacturer"] . "' AND active != 'false' GROUP BY category");
    }else{
        $a = $data->query("SELECT * FROM used_equipment WHERE active != 'false' GROUP BY category");
    }
    while($b = $a->fetch_array()){
        $sel .= '<option value="'.$b["category"].'">'.$b["category"].'</option>';
    }
    echo $sel;
}

if($act == 'updateimgpos'){
    $profid = $_REQUEST["profid"];
    $lefts = $_REQUEST["left"];
    $top = $_REQUEST["top"];
    $site->updateImgPos($profid,$lefts,$top);
}



if($act == 'saveforlater'){
    $total = 0;
    session_start();
    $eqipid = $_POST["eqipid"];
    $eqname = $_POST["eqname"];
    $eqtype = $_POST["eqtype"];
    $price = $_POST["price"];
    $url = $_POST["ecomurl"];
    $tabs = $_POST["tabs"];
    $qty = $_POST["qty"];
    $itemid = $_POST["itemid"];
    $pickup = $_POST["pickup"];
    //$qty = '1';

    $chk = $data->query("SELECT setting_value FROM shop_settings WHERE setting_name = 'location_select'");
    $chk1 = $chk->fetch_array();
    if($chk1["setting_value"] == 'true') {
        $locasel = $_POST["locasel"];
    }else{
        // attempt to get default location//
        $loc = $data->query("SELECT setting_value FROM shop_settings WHERE setting_name = 'default_ship_location'");
        $defloc = $loc->fetch_array();
        $locasel = $defloc["setting_value"];
    }

    $theSession = $_COOKIE["savedData"];


    if(isset($theSession)){
        $theSession = json_decode($theSession,true);
        for($i=0; $i < count($theSession["cartitems"]); $i++){
            $mydata[] = array("id"=>$theSession["cartitems"][$i]["id"],"name"=>$theSession["cartitems"][$i]["name"], "eqtype"=>$theSession["cartitems"][$i]["eqtype"], "price"=>$theSession["cartitems"][$i]["price"], "url"=>$theSession["cartitems"][$i]["url"], "eqtabs"=>$theSession["cartitems"][$i]["eqtabs"], "qty"=>$theSession["cartitems"][$i]["qty"], "itemid"=>$theSession["cartitems"][$i]["itemid"], "pickup"=>$theSession["cartitems"][$i]["pickup"]);
        }

        $mydata[] = array("id"=>$eqipid,"name"=>$eqname, "eqtype"=>$eqtype, "price"=>$price, "url"=>$url, "eqtabs"=>$tabs, "qty"=>$qty, "itemid"=>$itemid, "pickup"=>$pickup);

        $eq = json_encode(array("shop_location"=>$theSession["shop_location"],"cartitems"=>$mydata,"discount_code"=>"","shipping_type"=>"","shipping_token"=>"","shipping_price"=>""));
        $chk = $data->query("SELECT setting_value FROM shop_settings WHERE setting_name = 'location_select'");
        $chk1 = $chk->fetch_array();
        if($chk1["setting_value"] == 'true') {
            $x = $data->query("SELECT stock FROM equipment_location_manager WHERE equip_id = '$eqipid' AND equip_line = '$tabs' AND location_id = '$locasel'");
            if ($x->num_rows > 0) {
                $v = $x->fetch_array();
                if ($qty <= $v["stock"]) {
                    setcookie("savedData", $eq, time() + (86400 * 30), "/", false);
                    $retMess = array('response' => 'good', 'message' => 'Added to cart.');
                } else {
                    $retMess = array('response' => 'bad', 'message' => 'Out of stock at your selected location. Please select another location.');
                }
            } else {
                $retMess = array('response' => 'bad', 'message' => 'Out of stock at your selected location. Please select another location.');
            }
        }else{
            $chk = $data->query("SELECT setting_value FROM shop_settings WHERE setting_name = 'sell_per_qty'");
            $chk1 = $chk->fetch_array();

            if($chk1["setting_value"] == 'true'){
                $aa = $data->query("SELECT stock FROM equipment_location_manager WHERE location_id = '$locasel' AND equip_id = '$eqipid' AND equip_line = '$tabs'");
                $bb = $aa->fetch_array();
                if($bb["stock"] >= $qty){
                    setcookie("savedData", $eq, time() + (86400 * 30), "/", false);
                    $retMess = array('response' => 'good', 'message' => 'Added to cart.');
                }else{
                    $retMess = array('response' => 'bad', 'message' => 'Not enough stock.');
                }
            }else{
                setcookie("savedData", $eq, time() + (86400 * 30), "/", false);
                $retMess = array('response' => 'good', 'message' => 'Added to cart.');
            }
        }



        $html .= '<input type="hidden" id="cart_total" name="cart_total" value="'.number_format($total,2).'">';
        echo json_encode($retMess);

    }else{
        //$mydata[] = array("shop_location"=>$locasel);
        $mydata[] = array("id"=>$eqipid,"name"=>$eqname,"eqtype"=>$eqtype, "price"=>$price,"url"=>$url, "eqtabs"=>$tabs, "qty"=>$qty, "itemid"=>$itemid, "pickup"=>$pickup);

        $eq = json_encode(array("shop_location"=>$locasel,"cartitems"=>$mydata,"discount_code"=>"","shipping_type"=>"","shipping_token"=>"","shipping_price"=>""));

        //do some secondary stock checks//
        $chk = $data->query("SELECT setting_value FROM shop_settings WHERE setting_name = 'location_select'");
        $chk1 = $chk->fetch_array();
        if($chk1["setting_value"] == 'true') {
            $x = $data->query("SELECT stock FROM equipment_location_manager WHERE equip_id = '$eqipid' AND equip_line = '$tabs' AND location_id = '$locasel'");
            if ($x->num_rows > 0) {
                $v = $x->fetch_array();
                if ($qty <= $v["stock"]) {
                    setcookie("savedData", $eq, time() + (86400 * 30), "/", false);
                    $retMess = array('response' => 'good', 'message' => 'Added to cart.');
                } else {
                    $retMess = array('response' => 'bad', 'message' => 'Out of stock at your selected location. Please select another location.');
                }
            } else {
                $retMess = array('response' => 'bad', 'message' => 'Out of stock at your selected location. Please select another location.');
            }
        }else{

            $chk = $data->query("SELECT setting_value FROM shop_settings WHERE setting_name = 'sell_per_qty'");
            $chk1 = $chk->fetch_array();

            if($chk1["setting_value"] == 'true'){
                $aa = $data->query("SELECT stock FROM equipment_location_manager WHERE location_id = '$locasel' AND equip_id = '$eqipid' AND equip_line = '$tabs'");
                $bb = $aa->fetch_array();
                if($bb["stock"] >= $qty){
                    setcookie("savedData", $eq, time() + (86400 * 30), "/", false);
                    $retMess = array('response' => 'good', 'message' => 'Added to cart.');
                }else{
                    $retMess = array('response' => 'bad', 'message' => 'Not enough stock.');
                }
            }else{
                setcookie("savedData", $eq, time() + (86400 * 30), "/", false);
                $retMess = array('response' => 'good', 'message' => 'Added to cart.');
            }


        }

        $html .= '<input type="hidden" id="cart_total" name="cart_total" value="'.number_format($price,2).'">';

        echo json_encode($retMess);
    }


}

if($act == 'getmini'){
    include('config.php');
    session_start();

    $cartQty = 0;
    $cartRaw = $_COOKIE["savedData"];
    $cartItems_or = json_decode($_COOKIE["savedData"],true);
    $cartItems = $cartItems_or["cartitems"];


    if(!empty($cartItems)) {
        $priceOut = 0;
        $qtyOut = 0;
        for ($i = 0; $i < count($cartItems); $i++) {
            $itemId = $cartItems[$i]["id"];
            $itemName = $cartItems[$i]["name"];
            $itemsTable = $cartItems[$i]["eqtabs"];
            $itemQty = $cartItems[$i]["qty"];
            $itemUrl = $cartItems[$i]["url"];
            $itemPrice = $cartItems[$i]["price"] * $itemQty;

            if(strlen($itemName) > 40){
                $itemName = substr($itemName, 0, 40).'...';
            }else{
                $itemName = $itemName;
            }

            //get image//
            $a = $data->query("SELECT eq_image FROM $itemsTable WHERE id = '$itemId'");
            $b = $a->fetch_array();


            if ($b["eq_image"] != null || $b["eq_image"] != '[]') {
                $itemsImagepre = json_decode($b["eq_image"], true);
                $itemsImage = $itemsImagepre[0];
            }


            $cartThings .= '<div class="row cart-detail"><div class="col-lg-4 col-sm-4 col-4 cart-detail-img"><img src="img/custom/' . str_replace('../', '', $itemsImage) . '"></div><div class="col-lg-8 col-sm-8 col-8 cart-detail-product"><p>' . str_replace('_', ' ', $itemName) . '</p><span class="price text-info"> $' . $itemPrice . '</span> <span class="count"> Qty:' . $itemQty . '</span></div></div>';

            $priceOut += $itemPrice;
            $qtyOut += $itemQty;
        }

        $html .= '<div class="row total-header-section"><div class="col-lg-6 col-sm-6 col-6"><i class="fa fa-shopping-cart" aria-hidden="true"></i> <span class="badge badge-pill badge-danger">' . $qtyOut . '</span></div><div class="col-lg-6 col-sm-6 col-6 total-section text-right"><p>Total: <span class="text-info">$' . number_format($priceOut, 2) . '</span></p></div></div>';
        $html .= $cartThings;

        $html .= '<div class="row"><div class="col-lg-12 col-sm-12 col-12 text-center"><a href="checkout" class="btn btn-primary btn-block font-20">Checkout</a></div></div>';
    }else{
        $html .= '<div class="row total-header-section"><div class="col-lg-6 col-sm-6 col-6"><i class="fa fa-shopping-cart" aria-hidden="true"></i> <span class="badge badge-pill badge-danger">' . count($cartItems) . '</span></div><div class="col-lg-6 col-sm-6 col-6 total-section text-right"><p>Total: <span class="text-info">$' . number_format($priceOut, 2) . '</span></p></div></div>';
        $html .= '<div style="color: #666868; font-style: italic; padding-top:10px"><strong>NOTHING IN CART.</strong></div>';
    }
    echo json_encode(array('itemCount'=>$qtyOut, 'cart'=>$html));

}

if ($act == 'getwholecart') {
    include('config.php');
    session_start();

    $cartQty = 0;
    $cartRaw = $_COOKIE["savedData"];
    $cartItems_or = json_decode($_COOKIE["savedData"], true);
    $cartItems = $cartItems_or["cartitems"];
    //var_dump($cartItems_or);

    ///GET TOTAL QTY IN CART//
    for ($i = 0; $i < count($cartItems); $i++) {
        $theQty = $cartItems[$i]["qty"];
        $cartQty += $theQty;
    }


    $html .= '<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
<div class="container-fluid" id="printOrder">
    <div class="wrapper wrapper-content">
        <div class="row m-0">
            <div class="col-md-9" style="margin-bottom: 30px;">
                <div class="ibox">
                    <div class="ibox-title">
                        <span class="pull-right">(<strong>' . $cartQty . '</strong>) items</span>
                        <h5>Items in your cart</h5>
                    </div>';



    if (count($cartItems) > 0) {

        for ($i = 0; $i < count($cartItems); $i++) {
            $itemPrice = $cartItems[$i]["price"];
            $thePurchaseIn .= '' . ucwords($cartItems[$i]["eqtype"]) . ' - ' . $cartItems[$i]["name"] . ' ';
            $countOut += $itemPrice;
        }

        // get tax rate //
        $taxset = $data->query("SELECT setting_value FROM shop_settings WHERE setting_name = 'do_tax_stuff'");
        $taxGet = $taxset->fetch_array();
        if ($taxGet["setting_value"] == 'true') {
            $location = $cartItems["shop_location"];
            $tax = $data->query("SELECT tax_rate FROM equipment_tax WHERE relid = '$location' AND active = 'true'") or die($data->error);
            $taxOut = $tax->fetch_array();

            if ($taxOut["tax_rate"] != '') {
                $taxRate = $taxOut["tax_rate"];
            } else {
                $taxRate = '0';
            }
        } else {
            $taxRate = 0;
        }

        $countOut = 0;
        $taxrate = $taxRate;
        $weightOut = 0;

        for ($i = 0; $i < count($cartItems); $i++) {
            $itemPrice = $cartItems[$i]["price"];


            ///APPLIED PATCH FOR PRICE ADJUSTMENT FOR SHIPPING AND STUFF///

            $eqipId = $cartItems[$i]["id"];
            $eqipTab = $cartItems[$i]["eqtabs"];

            $x = $data->query("SELECT msrp, sales_price, eq_image, discount, description, weight FROM $eqipTab WHERE id = '$eqipId'") or die("THIS IS ONE " . $data->error);
            $v = $x->fetch_array();

            if($v["sales_price"] != 'Null'){
                $price = $v["sales_price"] * $cartItems[$i]["qty"]. 'SALES';

            }else{
                $price = $v["msrp"] * $cartItems[$i]["qty"].'MSRP';

            }

            $weight = $v["weight"] * $cartItems[$i]["qty"];

            $image1 = json_decode($v["eq_image"], true);
            $image = $image1[0];

            if (strlen($v["description"]) > 140) {
                $descript = substr($v["description"], 0, 140) . ' ...';
            } else {
                if ($v["description"] != null) {
                    $descript = $v["description"];
                }
            }

            if($v["sale_price"] != 'Null'){
                $listpr = $v["sale_price"]. 'SALES';
            }else{
                $listpr = $v["msrp"]. 'MSRP';
            }

            $thePurchasesd .= '<tr><td>' . $cartItems[$i]["name"] . '</td><td>$' . number_format($listpr, 2) . '</td><td><input class="form-control" style="max-width: 55%" type="text" name="itmqty_' . $cartItems[$i]["itemid"] . '" id="itmqty_' . $cartItems[$i]["itemid"] . '" value="' . $cartItems[$i]["qty"] . '"> <a href="javascript:void(0)" class="updateval" data-itemid="' . $cartItems[$i]["itemid"] . '" data-itemname="' . $cartItems[$i]["name"] . '" data-realid="' . $cartItems[$i]["id"] . '" data-eqtabs="' . $cartItems[$i]["eqtabs"] . '">Update</a></td><td>$' . number_format($price, 2) . '</td><td><a class="removit" href="javascript:void(0)" onclick="removeSavedCart(' . $cartItems[$i]["itemid"] . ',' . $cartItems[$i]["eqtabs"] . ')">remove</a></td></tr>';

            $thePurchase .= '<div class="ibox-content">
                        <div class="table-responsive">
                            <table class="table shoping-cart-table">
                                <tbody>
                                <tr>
                                    <td width="90">
                                        <div class="cart-product-imitation"><img style="width: 100%" src="img/custom/' . $image . '">
                                        </div>
                                    </td>
                                    <td class="desc" style="width:50%">
                                        <h5 style="margin: 0">
                                            <a href="' . $cartItems[$i]["url"] . '" class="text-navy">
                                                ' . str_replace('_', ' ', $cartItems[$i]["name"]) . '
                                            </a>
                                        </h5>
                                        <small style="font-style: italic">$' . number_format($listpr, 2) . ' ea</small><br>
                                        <p class="small" style="margin-top: 10px">
                                            ' . $descript . '
                                        </p>
                                        

                                        <div class="m-t-sm">
                                            <a class="removit text-muted" href="javascript:void(0)" onclick="removeSavedCart(\'' . $cartItems[$i]["itemid"] . '\',\'' . $cartItems[$i]["eqtabs"] . '\')"><i class="fa fa-trash"></i> Remove item</a>
                                        </div>
                                    </td>

                                   
                                    <td style="min-width: 100px">
                                    <div class="input-group mb-3">
  <input type="number" style="border-radius: 0" class="form-control" name="itmqty_' . $cartItems[$i]["itemid"] . '" id="itmqty_' . $cartItems[$i]["itemid"] . '" value="' . $cartItems[$i]["qty"] . '">
  <script>$("#itmqty_' . $cartItems[$i]["itemid"] . '").change(function(){
    onchangeItemQty("' . $cartItems[$i]["itemid"] . '", "' . $cartItems[$i]["eqtabs"] . '", "' . $cartItems[$i]["name"] . '", "' . $cartItems[$i]["id"] . '");
  });</script>
  <div class="input-group-append">
    
  </div>
</div><td>
                                   
                                </td>
                                        
                                    </td>
                                    <td>
                                        <h4 style="display: block; width:100px">
                                            $' . number_format($price, 2) . '
                                        </h4>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>

                    </div>';

            $countOut += str_replace(',', '', $price);

            $weightOut += $weight;
        }


        $tax = round((($countOut * $taxrate)), 2);
        // $countOut = $countOut + $tax;

        $totalWeight = $weightOut;

        $html .= $thePurchase;
    } else {
        $html .= '<div class="jumbotron"><b>Whoops!</b><br><p>You have no items in your cart.</p></div>';
        unset($_SESSION["customer_shipping_info"]);
        unset($_COOKIE["savedData"]);
        setcookie("savedData", "", time() - (60 * 60 * 24), "/");
    }

    $html .= '<div class="ibox-content">';


    if (!empty($cartItems)) {
        $html .= ' <button class="btn btn-primary pull-right thecheckout"><i class="fa fa fa-shopping-cart"></i> Checkout </button>';
    }
    $html .= ' <a class="btn btn-white" href="attachments"><i class="fa fa-arrow-left"></i> Continue shopping</a>

                    </div>
                </div>

            </div>
            <div class="col-md-3">
                <div class="ibox">
                    <div class="ibox-title">
                        <h5>Cart Summary</h5>
                    </div>
                    <div class="ibox-content">
                    <span>
                        Sub Total
                    </span>
                        <h2 class="font-bold">
                            $' . number_format($countOut, 2) . '
                        </h2>

                        <hr>

                        
                    </div>
                </div>



<!--                <div class="ibox">-->
<!--                    <div class="ibox-content">-->
<!---->
<!--                        <p class="font-bold">-->
<!--                            Other products you may be interested-->
<!--                        </p>-->
<!--                        <hr>-->
<!--                        <div>-->
<!--                            <a href="#" class="product-name"> Product 1</a>-->
<!--                            <div class="small m-t-xs">-->
<!--                                Many desktop publishing packages and web page editors now.-->
<!--                            </div>-->
<!--                            <div class="m-t text-righ">-->
<!---->
<!--                                <a href="#" class="btn btn-xs btn-outline btn-primary">Info <i class="fa fa-long-arrow-right"></i> </a>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                        <hr>-->
<!--                        <div>-->
<!--                            <a href="#" class="product-name"> Product 2</a>-->
<!--                            <div class="small m-t-xs">-->
<!--                                Many desktop publishing packages and web page editors now.-->
<!--                            </div>-->
<!--                            <div class="m-t text-righ">-->
<!---->
<!--                                <a href="#" class="btn btn-xs btn-outline btn-primary">Info <i class="fa fa-long-arrow-right"></i> </a>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
            </div>
        </div>
    </div>
</div>';

    echo $html;
}

//GET CART SECOND STEP//

if ($act == 'getwholecart-two') {
    include('config.php');
    session_start();

    //    var_dump($_COOKIE["savedData"]);

    if (isset($_SESSION["customer_shipping_info"])) {

        $shippingInfo = json_decode($_SESSION["customer_shipping_info"], true);

        $shipping_first_name = $shippingInfo["shipping_first_name"];
        $shipping_last_name = $shippingInfo["shipping_last_name"];
        $shipping_address = $shippingInfo["shipping_address"];
        $shipping_option_address = $shippingInfo["shipping_option_address"];
        $shipping_city = $shippingInfo["shipping_city"];
        $shipping_state = $shippingInfo["shipping_state"];
        $shipping_zip = $shippingInfo["shipping_zip"];
        $shipping_email = $shippingInfo["shipping_email"];
        $shipping_phone = $shippingInfo["shipping_phone"];
    } else {
        $shipping_first_name = '';
        $shipping_last_name = '';
        $shipping_address = '';
        $shipping_option_address = '';
        $shipping_city = '';
        $shipping_state = '';
        $shipping_zip = '';
        $shipping_email = '';
        $shipping_phone = '';
    }

    $cartQty = 0;
    $cartRaw = $_COOKIE["savedData"];
    $cartItems_or = json_decode($_COOKIE["savedData"], true);
    $cartItems = $cartItems_or["cartitems"];
//    var_dump($cartItems);

    ///GET TOTAL QTY IN CART//
    for ($i = 0; $i < count($cartItems); $i++) {
        $theQty = $cartItems[$i]["qty"];
        $cartQty += $theQty;
        if($cartItems[$i]["pickup"] == 'True' || $cartItems[$i]["pickup"] == 'true'){
            $pickup[] = 'true';
        }else{

        }
    }

    if(!empty($pickup)){
        $pickupFlag = 'true';
    }else{
        $pickupFlag = 'false';
    }


    $html .= '<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
<div class="container-fluid">
    <div class="wrapper wrapper-content">
    
    <div class="overlays"><div class="lds-ring"></div></div>
        <div class="row m-0" style="margin-bottom: 30px;">';

    if($pickupFlag == 'false') {

        $html .= '<div class="col-md-7"><form name="billing_details" id="billing_details" method="post" action="">
                <div class="ibox">
                    <div class="ibox-title">
                        <h5>Shipping Details</h5>
                    </div>';


        $html .= '<div class="ibox-content">';


        $html .= '<div class="row">';
        $html .= '<div class="col-md-6"><label>First Name*</label><input type="text" class="form-control" name="shipping_first_name" id="shipping_first_name" required="required" autocomplete="none" value="' . $shipping_first_name . '"></div>';
        $html .= '<div class="col-md-6"><label>Last Name*</label><input type="text" class="form-control" name="shipping_last_name" name="shipping_last_name" required="required" autocomplete="none" value="' . $shipping_last_name . '"></div>';
        $html .= '</div>';

        $html .= '<div class="row" style="margin-top: 5px">';
        $html .= '<div class="col-md-12"><label>Address*</label><input type="text" class="form-control" name="shipping_address" id="shipping_address" required="required" autocomplete="none" value="' . $shipping_address . '"></div>';
        $html .= '</div>';

        $html .= '<div class="row" style="margin-top: 5px">';
        $html .= '<div class="col-md-12"><label>Apt #, Suite, Floor (Optional)</label><input type="text" class="form-control" name="shipping_option_address" id="shipping_option_address" autocomplete="none" value="' . $shipping_option_address . '"></div>';
        $html .= '</div>';

        $html .= '<div class="row" style="margin-top: 5px">';
        $html .= '<div class="col-md-6"><label>City*</label><input type="text" class="form-control" name="shipping_city" name="shipping_city" required="required" autocomplete="none" value="' . $shipping_city . '"></div>';

        $html .= '<div class="col-md-4"><label>State*</label>';

        $states = array(
            'Alabama' => 'AL',
            'Alaska' => 'AK',
            'Arizona' => 'AZ',
            'Arkansas' => 'AR',
            'California' => 'CA',
            'Colorado' => 'CO',
            'Connecticut' => 'CT',
            'Delaware' => 'DE',
            'Florida' => 'FL',
            'Georgia' => 'GA',
            'Hawaii' => 'HI',
            'Idaho' => 'ID',
            'Illinois' => 'IL',
            'Indiana' => 'IN',
            'Iowa' => 'IA',
            'Kansas' => 'KS',
            'Kentucky' => 'KY',
            'Louisiana' => 'LA',
            'Maine' => 'ME',
            'Maryland' => 'MD',
            'Massachusetts' => 'MA',
            'Michigan' => 'MI',
            'Minnesota' => 'MN',
            'Mississippi' => 'MS',
            'Missouri' => 'MO',
            'Montana' => 'MT',
            'Nebraska' => 'NE',
            'Nevada' => 'NV',
            'New Hampshire' => 'NH',
            'New Jersey' => 'NJ',
            'New Mexico' => 'NM',
            'New York' => 'NY',
            'North Carolina' => 'NC',
            'North Dakota' => 'ND',
            'Ohio' => 'OH',
            'Oklahoma' => 'OK',
            'Oregon' => 'OR',
            'Pennsylvania' => 'PA',
            'Rhode Island' => 'RI',
            'South Carolina' => 'SC',
            'South Dakota' => 'SD',
            'Tennessee' => 'TN',
            'Texas' => 'TX',
            'Utah' => 'UT',
            'Vermont' => 'VT',
            'Virginia' => 'VA',
            'Washington' => 'WA',
            'West Virginia' => 'WV',
            'Wisconsin' => 'WI',
            'Wyoming' => 'WY'
        );

        $html .= '<select name="shipping_state" id="shipping_state" class="form-control" required="required">';
        $html .= '<option value="">Select State</option>';

        foreach ($states as $key => $val) {
            if ($shipping_state == $val) {
                $html .= '<option value="' . $val . '" selected="selected">' . $key . '</option>';
            } else {
                $html .= '<option value="' . $val . '">' . $key . '</option>';
            }
        }

        $html .= '</select>';


        $html .= '</div>';

        $html .= '<div class="col-md-2"><label>Zip*</label><input class="form-control" type="text" name="shipping_zip" id="shipping_zip" required="required" autocomplete="none" value="' . $shipping_zip . '" maxlength="5"></div>';

        $html .= '</div>';
        $html .= '</div>';

        $html .= '</div>';

        $html .= '<div class="ibox">';

        $html .= '<div class="ibox-title"><h5>Contact Details</h5></div>';

        $html .= '<div class="ibox-content">';

        $html .= '<div class="row">';
        $html .= '<div class="col-md-12"><label>Email Address</label><input type="email" class="form-control" name="shipping_email" id="shipping_option_email" required="required" autocomplete="none" value="' . $shipping_email . '"></div>';
        $html .= '</div>';
        $html .= '<div class="row" style="margin-top: 5px; margin-bottom: 10px;">';
        $html .= '<div class="col-md-12"><label>Phone Number</label><input type="text" class="form-control phone_us" name="shipping_phone" id="shipping_option_phone" required="required" autocomplete="none" value="' . $shipping_phone . '" maxlength="14"></div>';
        $html .= '</div>';


        $html .= '
                </div>
                </div></form>
            </div>';
    }else{
        //pickup at location//
        $html .= '<div class="col-md-7"><form name="billing_details" id="billing_details" method="post" action="">
                <div class="ibox">
                    <div class="ibox-title">
                        <h5>Pickup Details 1</h5>
                    </div>';


        $html .= '<div class="ibox-content">';


        $html .= '<div class="row">';
        $html .= '<div class="col-md-6"><label>First Name*</label><input type="text" class="form-control" name="shipping_first_name" id="shipping_first_name" required="required" autocomplete="none" value="' . $shipping_first_name . '"></div>';
        $html .= '<div class="col-md-6"><label>Last Name*</label><input type="text" class="form-control" name="shipping_last_name" name="shipping_last_name" required="required" autocomplete="none" value="' . $shipping_last_name . '"></div>';
        $html .= '</div>';

        $html .= '<br>';

        $html .= '<div class="row">';
        $html .= '<div class="col-md-6"><label>Select Pickup Location*</label>';
        $html .= '<select class="form-control" name="pickuplocs" id="pickuplocs" required="required">';
        $html .= '<option value="">SELECT PICKUP LOCATION</option>';

        $a = $data->query("SELECT id, location_name, location_address, location_city, location_state, location_zip FROM location WHERE active = 'true' ORDER BY location_state ASC, location_city ASC");
        while($b = $a->fetch_array()){
            if($b["location_name"] != null) {
                $html .= '<option value="' . $b["id"] . '" data-pickupaddress="'.$b["location_address"].'" data-pickupcity="'.$b["location_city"].'" data-pickupcity="'.$b["location_city"].'" data-pickupstate="'.$b["location_state"].'" data-pickupzip="'.$b["location_zip"].'">' . $b["location_name"] . ', ' . $b["location_state"] . ', ' . $b["location_zip"] . '</option>';
            }
        }

        $html .= '</select>';

        $html .= '';

        $html .= '</div>';

        $html .= '</div>';



        $html .= '</div>';
        $html .= '</div><br>';


        $html .= '<div class="ibox">';

        $html .= '<div class="ibox-title"><h5>Contact Details</h5></div>';

        $html .= '<div class="ibox-content">';

        $html .= '<div class="row">';
        $html .= '<div class="col-md-12"><label>Email Address</label><input type="email" class="form-control" name="shipping_email" id="shipping_option_email" required="required" autocomplete="none" value="' . $shipping_email . '"></div>';
        $html .= '</div>';
        $html .= '<div class="row" style="margin-top: 5px; margin-bottom: 10px;">';
        $html .= '<div class="col-md-12"><label>Phone Number</label><input type="text" class="form-control phone_us" name="shipping_phone" id="shipping_option_phone" required="required" autocomplete="none" value="' . $shipping_phone . '" maxlength="14"></div>';
        $html .= '</div>';


        $html .= '
                </div>
                </div></form>
            </div>';
    }


            $html .='<div class="col-md-5">';




    for ($i = 0; $i < count($cartItems); $i++) {
        $itemPrice = $cartItems[$i]["price"];
        $thePurchaseIn .= '' . ucwords($cartItems[$i]["eqtype"]) . ' - ' . $cartItems[$i]["name"] . ' ';
        $countOut += $itemPrice;
    }

    $countOut = 0;

    //get tax rate//
    $taxset = $data->query("SELECT setting_value FROM shop_settings WHERE setting_name = 'do_tax_stuff'");
    $taxGet = $taxset->fetch_array();
    if ($taxGet["setting_value"] == 'true') {
        $location = $cartItems["shop_location"];
        $tax = $data->query("SELECT tax_rate FROM equipment_tax WHERE relid = '$location' AND active = 'true'");
        $taxOut = $tax->fetch_array();

        if ($taxOut["tax_rate"] != '') {
            $taxRate = $taxOut["tax_rate"];
        } else {
            $taxRate = '0';
        }
    } else {
        $taxRate = '0';
    }

    $taxrate = $taxRate;
    $weightOut = 0;

    $thePurchase .= '<div class="ibox-content">
                        <div class="table-responsive">
                            <table class="table shoping-cart-table">
                            <thead><tr><td><b>Item</b></td><td style="width: 50%"><b>Qty</b></td><td style="width: 50%; text-align: right"><b>Price</b></td></tr></thead>
                                <tbody>';

   // var_dump($cartItems);


    for ($i = 0; $i < count($cartItems); $i++) {
        $itemPrice = $cartItems[$i]["price"];

        if($cartItems[$i]["pickup"] == 'True' || $cartItems[$i]["pickup"] == 'true'){
            $pickItUp[] = 'true';
        }

        if ($i < count($cartItems) - 1) {
            $borderSty = 'style="border-bottom: solid thin #efefef"';
        } else {
            $borderSty = '';
        }

        ///APPLIED PATCH FOR PRICE ADJUSTMENT FOR SHIPPING AND STUFF///

        $eqipId = $cartItems[$i]["id"];
        $eqipTab = $cartItems[$i]["eqtabs"];

        $x = $data->query("SELECT msrp, sales_price, discount, description FROM $eqipTab WHERE id = '$eqipId'") or die("THIS IS ONE " . $data->error);
        $v = $x->fetch_array();


        if($v["sales_price"] != 'Null'){
            $price = $v["sales_price"] * $cartItems[$i]["qty"];
        }else{
            $price = $v["msrp"] * $cartItems[$i]["qty"];
        }

        $weight = $v["weight"] * $cartItems[$i]["qty"];

        if (strlen($v["description"]) > 140) {
            $descript = substr($v["description"], 0, 140) . ' ...';
        } else {
            if ($v["description"] != null) {
                $descript = $v["description"];
            }
        }

        if($v["sale_price"] != 'Null'){
            $listpr = $v["sale_price"];
        }else{
            $listpr = $v["msrp"];
        }


        $thePurchasesds .= '<tr><td>' . $cartItems[$i]["name"] . '</td><td>$' . number_format($listpr, 2) . '</td><td>' . $cartItems[$i]["qty"] . '<input class="form-control" style="max-width: 55%" type="text" name="itmqty_' . $cartItems[$i]["itemid"] . '" id="itmqty_' . $cartItems[$i]["itemid"] . '" value="' . $cartItems[$i]["qty"] . '"> <a href="javascript:void(0)" class="updateval" data-itemid="' . $cartItems[$i]["itemid"] . '" data-itemname="' . $cartItems[$i]["name"] . '" data-realid="' . $cartItems[$i]["id"] . '" data-eqtabs="' . $cartItems[$i]["eqtabs"] . '">Update</a></td><td>$' . number_format($price, 2) . '</td><td><a class="removit" href="javascript:void(0)" onclick="removeSavedCart(' . $cartItems[$i]["itemid"] . ',' . $cartItems[$i]["eqtabs"] . ')">remove</a></td></tr>';

        $thePurchase .= '
                               
                                <tr ' . $borderSty . '>
                                    <td class="desc" style="width:50%">
                                        <h5 style="margin: 0">
                                            <a href="' . $cartItems[$i]["url"] . '" class="text-navy-small" >
                                                ' . str_replace('_', ' ', $cartItems[$i]["name"]) . '
                                            </a>
                                        </h5>
                                        <small style="font-style: italic">$' . number_format($listpr, 2) . ' ea</small><br>
                                        <!--<b style="color: red">NOTICE! - This item Must be picked up1.</b>-->
                                       
                                    </td>

                                   
                                    <td width="">
                                    ' . $cartItems[$i]["qty"] . '
                                   
                                </td>
                                        
                                   
                                    <td>
                                        <h8 style="display: block; width:100px;text-align: right">
                                            $' . number_format($price, 2) . '
                                        </h8>
                                    </td>
                                </tr>
                                ';

        $countOut += str_replace(',', '', $price);

        $weightOut += $weight;
    }

    $thePurchase .= '</tbody>
                            </table>
                        </div>

                    </div>';


    $tax = round((($countOut * $taxrate)), 2);
    $total = $countOut + $tax;

    $totalWeight = $weightOut;


    $html .= '<div class="ibox">
                    <div class="ibox-title">
                        <h5>Cart Summary</h5> 
                    </div>
                    <div>' . $thePurchase . '</div>';


    $savingCode = $cartItems_or["discount_code"];

    if ($savingCode == '') {

        $html .= '<form name="the-discount" id="the-discount" method="post" action=""><div style="padding: 30px"><div class="input-group mb-3">
  <input type="text" class="form-control" name="thesdiscount" id="thesdiscount" placeholder="Discount Code" required="required" autocomplete="off">
  <div class="input-group-append">
    <button class="btn btn-secondary" type="submit">Redeem</button>
  </div>
</div></div></form>';
    }

    $html .= '<div class="discountapply ibox-content">';
    //DO SOME DISCOUNT STUFF OR WHATEVA//





    $a = $data->query("SELECT percentage_off, date_expire, status FROM shop_discounts WHERE dis_code = '$savingCode' AND active = 'true'") or die($data->error);


    if ($a->num_rows > 0) {
        $b = $a->fetch_array();
        $discountAval = $b["percentage_off"];
        $discountAval = $discountAval / 100;

        $percent = $discountAval * $countOut;

        $countOutFin = $countOut - $percent;

        $html .= '<table class="table shoping-cart-table"><tbody><tr><td style="padding: 10px">Applied Discount:</td><td style="padding: 10px;text-align: right"><small>' . $b["percentage_off"] . '% Off</small><br>-$' . number_format($percent, 2) . '</td></tr></tbody></table>';
        $countOut = $countOutFin;
    }

    $html .= '</div>';


    $html .= '<div class="ibox-content" style="text-align: right">
                    <span>
                        Sub Total
                    </span>
                        <h2 class="font-bold thetotals" style="text-align: right">
                            $' . number_format($countOut, 2) . '
                        </h2>
                        



                        <div class="m-t-sm">
                            <div class="btn-group">
                            <a href="checkout" class="btn-default btn-sm"><i class="fa fa-arrow-left"></i>  Back to Cart</a>
                                <button class="btn btn-primary btn-sm checkout-shipping"><i class="fa fa-shopping-cart"></i> Continue to shipping method</button>
                                
                            </div>
                        </div>
                    </div>
                </div>



<!--                <div class="ibox">-->
<!--                    <div class="ibox-content">-->
<!---->
<!--                        <p class="font-bold">-->
<!--                            Other products you may be interested-->
<!--                        </p>-->
<!--                        <hr>-->
<!--                        <div>-->
<!--                            <a href="#" class="product-name"> Product 1</a>-->
<!--                            <div class="small m-t-xs">-->
<!--                                Many desktop publishing packages and web page editors now.-->
<!--                            </div>-->
<!--                            <div class="m-t text-righ">-->
<!---->
<!--                                <a href="#" class="btn btn-xs btn-outline btn-primary">Info <i class="fa fa-long-arrow-right"></i> </a>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                        <hr>-->
<!--                        <div>-->
<!--                            <a href="#" class="product-name"> Product 2</a>-->
<!--                            <div class="small m-t-xs">-->
<!--                                Many desktop publishing packages and web page editors now.-->
<!--                            </div>-->
<!--                            <div class="m-t text-righ">-->
<!---->
<!--                                <a href="#" class="btn btn-xs btn-outline btn-primary">Info <i class="fa fa-long-arrow-right"></i> </a>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
            </div>
        </div>
    </div>
</div>';

    echo $html;
}

if ($act == 'updateqty') {
    //inc/ajaxCalls.php?action=updateqty&itemname='+itemname+'&eqtabs='+eqtabs+'&qty
    $itemname = $_REQUEST["itemname"];
    $eqtabs = $_REQUEST["eqtabs"];
    $qty = $_REQUEST["qty"];
    $itemid = $_REQUEST["itemid"];
    $realid = $_REQUEST["realid"];

    include('siteFunctions.php');
    $a = new site();

    $thing = $a->updateQty($itemname, $itemid, $realid, $qty, $eqtabs);

    echo $thing;
}

if ($act == 'removesaved') {
    include('siteFunctions.php');
    $a = new site();
    $outty = $a->removeSave($_REQUEST["varid"], $_REQUEST["saletabs"]);
}

if ($act == 'getcartitems') {
    include('siteFunctions.php');
    $a = new site();
    $outty = $a->getSaves();

    echo $outty["saves"] . '<input type="hidden" id="cart_total" name="cart_total" value="' . number_format($outty["total"], 2) . '">';
}

if ($act == 'selectshipping') {
    session_start();
    include('config.php');
    if (isset($_REQUEST["redoship"])) {
        $shippingInfo = json_decode($_SESSION["customer_shipping_info"], true);
        $shipping_first_name = $shippingInfo["shipping_first_name"];
        $shipping_last_name = $shippingInfo["shipping_last_name"];
        $shipping_address = $shippingInfo["shipping_address"];
        $shipping_option_address = $shippingInfo["shipping_option_address"];
        $shipping_city = $shippingInfo["shipping_city"];
        $shipping_state = $shippingInfo["shipping_state"];
        $shipping_zip = $shippingInfo["shipping_zip"];
        $shipping_email = $shippingInfo["shipping_email"];
        $shipping_phone = $shippingInfo["shipping_phone"];
        // $shipping_phone = '123-456-7891';
    } else {
        $shippingInfo = $_POST;
        $_SESSION["customer_shipping_info"] = json_encode($shippingInfo);

        //    var_dump($_COOKIE["savedData"]);

        if (isset($_SESSION["customer_shipping_info"])) {

            $shippingInfo = json_decode($_SESSION["customer_shipping_info"], true);

            $shipping_first_name = $shippingInfo["shipping_first_name"];
            $shipping_last_name = $shippingInfo["shipping_last_name"];
            $shipping_address = $shippingInfo["shipping_address"];
            $shipping_option_address = $shippingInfo["shipping_option_address"];
            $shipping_city = $shippingInfo["shipping_city"];
            $shipping_state = $shippingInfo["shipping_state"];
            $shipping_zip = $shippingInfo["shipping_zip"];
            $shipping_email = $shippingInfo["shipping_email"];
            $shipping_phone = $shippingInfo["shipping_phone"];

            // $shipping_phone = '222-333-4444';
        } else {
            $shipping_first_name = '';
            $shipping_last_name = '';
            $shipping_address = '';
            $shipping_option_address = '';
            $shipping_city = '';
            $shipping_state = '';
            $shipping_zip = '';
            $shipping_email = '';
            $shipping_phone = '333-444-5555';
        }
    }

    $cartQty = 0;
    $cartRaw = $_COOKIE["savedData"];

    $cartRaw = json_decode($cartRaw, true);
    $cartItems_or = json_decode($_COOKIE["savedData"], true);
    $cartItems = $cartItems_or["cartitems"];
    //var_dump($cartItems);

    ///GET TOTAL QTY IN CART//
    for ($i = 0; $i < count($cartItems); $i++) {
        $theQty = $cartItems[$i]["qty"];
        $cartQty += $theQty;
    }


    $html .= '<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
<div class="container-fluid">
    <div class="wrapper wrapper-content">
    
    
        <div class="row m-0" style="margin-bottom:30px;">
        
            <div class="col-md-7 p-0">';

    $location = $cartItems_or["shop_location"];
    $a = $data->query("SELECT location_name, location_address, location_city, location_state, location_zip FROM location WHERE id = '" . $location . "'") or die($data->error);
    $b = $a->fetch_array();

    $shopStore = $b["location_name"];
    $shopAddress = $b["location_address"];
    $shopCity = $b["location_city"];
    $shopState = $b["location_state"];
    $shopZip = $b["location_zip"];


    $chk = $data->query("SELECT setting_value FROM shop_settings WHERE setting_name = 'location_select'");
    $chk1 = $chk->fetch_array();
    if ($chk1["setting_value"] == 'true') {


        $html .= '<div class="ibox">
                    <div class="ibox-title">
                        <h5>Store Location</h5>
                    </div>';

        $html .= '<div class="ibox-content">';

        $html .= '<div class="row">';
        $html .= '<div class="col-md-12" style="font-style: italic">' . $b["location_name"] . '<br>' . $b["location_address"] . ' <br>' . $b["location_city"] . ' ' . $b["location_state"] . ', ' . $b["location_zip"] . '</div>';
        $html .= '</div>';


        $html .= '</div>';
        $html .= '</div>';
    }

    $html .= '<div class="ibox">
    <div class="overlays"><div class="lds-ring"></div></div>
                    <div class="row"><div class="col-md-6 col-6">
                    <div class="ibox-title">';
    if(isset($shippingInfo["pickuplocs"])) {
        $html .= '<h5>Pickup Details 2</h5>';
    }else{
        $html .= '<h5>Shipping Details</h5>';
    }
                    $html .= '</div>';


    $html .= '<div class="ibox-content">';

    if(isset($shippingInfo["pickuplocs"])){
        $sh = $data->query("SELECT location_name, location_address, location_city, location_state, location_zip FROM location WHERE id = '".$shippingInfo["pickuplocs"]."'");
        $shinfo = $sh->fetch_array();

        $html .= '<div class="row">';
        $html .= '<div class="col-md-12" style="font-style: italic">';
        $html .= '<b>Customer: </b> '.$shipping_first_name . ' ' . $shipping_last_name . '<br>';
        $html .= '<b>James River '.$shinfo["location_name"].' Store Location</b><br>';
        $html .= $shinfo["location_address"].'<br>';
        $html .= $shinfo["location_city"]. ' ' . $shinfo["location_state"] . ', ' . $shinfo["location_zip"] . '<br>';
        $html .= '</div>';
        $html .= '</div>';
    }else{
        $html .= '<div class="row">';
        $html .= '<div class="col-md-12" style="font-style: italic">';
        $html .= $shipping_first_name . ' ' . $shipping_last_name . '<br>';
        $html .= $shipping_address . ' ' . $shipping_option_address . '<br>';
        $html .= $shipping_city . ' ' . $shipping_state . ', ' . $shipping_zip . '<br>';
        $html .= '</div>';
        $html .= '</div>';
    }



    $html .= '</div></div>';




    $html .= '<div class="col-md-6 col-6"><div class="ibox">';

    $html .= '<div class="ibox-title"><h5>Contact Details</h5></div>';

    $html .= '<div class="ibox-content">';

    $html .= '<div class="row">';
    $html .= '<div class="col-md-12" style="font-style: italic">em. ' . $shipping_email . '</div>';
    $html .= '</div>';
    $html .= '<div class="row" style="margin-top: 5px">';
    $html .= '<div class="col-md-12" style="font-style: italic">ph. ' . $shipping_phone . '</div>';
    
    $html .= '</div>';
    $html .= '</div>';





    $html .= '
                </div>
                </div>
            </div></div>';
    $html .= '<div class="col-md-12" style="margin-top: 15px"><a href="javascript:void(0)" class="btn-default btn-sm thecheckout"><i class="fa fa-arrow-left"></i> Edit Details</a></div>';
    $html .='</div>
            <div class="col-md-5">';




    for ($i = 0; $i < count($cartItems); $i++) {
        $itemPrice = $cartItems[$i]["price"];
        $thePurchaseIn .= '' . ucwords($cartItems[$i]["eqtype"]) . ' - ' . $cartItems[$i]["name"] . ' ';
        $countOut += $itemPrice;
    }

    $countOut = 0;

    //get tax rate//
    $taxset = $data->query("SELECT setting_value FROM shop_settings WHERE setting_name = 'do_tax_stuff'");
    $taxGet = $taxset->fetch_array();
    if ($taxGet["setting_value"] == 'true') {
        $location = $cartRaw["shop_location"];
        $tax = $data->query("SELECT tax_rate FROM equipment_tax WHERE relid = '$location' AND active = 'true'");
        $taxOut = $tax->fetch_array();

        if ($taxOut["tax_rate"] != '') {
            $taxRate = $taxOut["tax_rate"];
        } else {
            $taxRate = '0';
        }
    } else {
        $taxRate = 0;
    }

    $taxrate = $taxRate;
    $weightOut = 0;

    $thePurchase .= '<div class="ibox-content">
                        <div class="table-responsive">
                            <table class="table shoping-cart-table">
                            <thead><tr><td><b>Item</b></td><td style="width: 50%"><b>Qty</b></td><td style="width: 50%; text-align: right"><b>Price</b></td></tr></thead>
                                <tbody>';


    for ($i = 0; $i < count($cartItems); $i++) {
        $itemPrice = $cartItems[$i]["price"];

        if ($i < count($cartItems) - 1) {
            $borderSty = 'style="border-bottom: solid thin #efefef"';
        } else {
            $borderSty = '';
        }

        ///APPLIED PATCH FOR PRICE ADJUSTMENT FOR SHIPPING AND STUFF///

        $eqipId = $cartItems[$i]["id"];
        $eqipTab = $cartItems[$i]["eqtabs"];

        $x = $data->query("SELECT msrp, sales_price, discount, description, weight, ship_type, dimentions  FROM $eqipTab WHERE id = '$eqipId'") or die("THIS IS ONE " . $data->error);
        $v = $x->fetch_array();

        if($v["sales_price"] != 'Null'){
            $price = $v["sales_price"] * $cartItems[$i]["qty"];
        }else{
            $price = $v["msrp"] * $cartItems[$i]["qty"];
        }

        $weight = $v["weight"] * $cartItems[$i]["qty"];

        if (strlen($v["description"]) > 140) {
            $descript = substr($v["description"], 0, 140) . ' ...';
        } else {
            if ($v["description"] != null) {
                $descript = $v["description"];
            }
        }

        if($v["dimentions"] != null) {

            $dimentions = explode('X', $v["dimentions"]);

            $packArs[] = array("l" => $dimentions[0], "w" => $dimentions[1], "h" => $dimentions[2]);
        }else{
            $pickUpItem[] = array('true');
        }

        if($v["sale_price"] != 'Null'){
            $listpr = $v["sale_price"];
        }else{
            $listpr = $v["msrp"];
        }


        $thePurchasesds .= '<tr><td>' . $cartItems[$i]["name"] . '</td><td>$' . number_format($listpr, 2) . '</td><td>' . $cartItems[$i]["qty"] . '<input class="form-control" style="max-width: 55%" type="text" name="itmqty_' . $cartItems[$i]["itemid"] . '" id="itmqty_' . $cartItems[$i]["itemid"] . '" value="' . $cartItems[$i]["qty"] . '"> <a href="javascript:void(0)" class="updateval" data-itemid="' . $cartItems[$i]["itemid"] . '" data-itemname="' . $cartItems[$i]["name"] . '" data-realid="' . $cartItems[$i]["id"] . '" data-eqtabs="' . $cartItems[$i]["eqtabs"] . '">Update</a></td><td>$' . number_format($price, 2) . '</td><td><a class="removit" href="javascript:void(0)" onclick="removeSavedCart(' . $cartItems[$i]["itemid"] . ',' . $cartItems[$i]["eqtabs"] . ')">remove</a></td></tr>';

        if($v["dimentions"] != null){
            $pickupMessage = '';
        }else{
            $pickupMessage = '<!--<b style="color: red">NOTICE! - This item must be picked up.</b>-->';
        }

        $thePurchase .= '
                               
                                <tr ' . $borderSty . '>
                                    <td class="desc" style="width:50%">
                                        <h5 style="margin: 0">
                                            <a href="' . $cartItems[$i]["url"] . '" class="text-navy-small" >
                                                ' . str_replace('_', ' ', $cartItems[$i]["name"]) . '
                                            </a>
                                        </h5>
                                        <small style="font-style: italic">$' . number_format($listpr, 2) . ' ea</small><br>
                                        '.$pickupMessage.'
                                       
                                    </td>

                                   
                                    <td width="">
                                    ' . $cartItems[$i]["qty"] . '
                                   
                                </td>
                                        
                                   
                                    <td style="text-align: right">
                                        <h8 style="display: block; width:100px">
                                            $' . number_format($price, 2) . '
                                        </h8>
                                    </td>
                                </tr>
                                ';

        $countOut += str_replace(',', '', $price);

        $weightOut += $weight;
    }

    $thePurchase .= '</tbody>
                            </table>
                        </div>

                    </div>';

    $savingCode = $cartItems_or["discount_code"];
    $a = $data->query("SELECT percentage_off, date_expire, status FROM shop_discounts WHERE dis_code = '$savingCode' AND active = 'true'") or die($data->error);

    if ($a->num_rows > 0) {
        $b = $a->fetch_array();
        $discountAval = $b["percentage_off"];
        $discountAval = $discountAval / 100;

        $percent = $discountAval * $countOut;

        $countOutFin = $countOut - $percent;

        $discountGivin = '<table class="table shoping-cart-table couponars"><tbody><tr><td style="padding: 10px">Applied Discount:</td><td style="padding: 10px;text-align: right"><small>' . $b["percentage_off"] . '% Off</small><br>-$' . number_format($percent, 2) . '</td></tr></tbody></table>';
        $countOut = $countOutFin;
    }


    $tax = $countOut * $taxrate / 100;



    $totalWeight = $weightOut;




    $html .= '<div class="ibox">
                    <div class="ibox-title">
                        <h5>Cart Summary</h5> 
                    </div>
                    <div>' . $thePurchase . '</div>';




    if ($savingCode == '') {

        $htmlOLD .= '<form name="the-discount" id="the-discount" method="post" action=""><div style="padding: 30px"><div class="input-group mb-3">
  <input type="text" class="form-control" name="thesdiscount" id="thesdiscount" placeholder="Discount Code" required="required" autocomplete="off">
  <div class="input-group-append">
    <button class="btn btn-secondary" type="submit">Redeem</button>
  </div>
</div></div></form>';

        $html .= '<div class="couponars" style="text-align: right; padding: 20px"><b>No Coupon Added.</b><br><a href="javascript:void(0)" class="thecheckout">Apply Coupon Code</a>.</div>';
    }



    $html .= '<div class="discountapply ibox-content">';
    //DO SOME DISCOUNT STUFF OR WHATEVA//
    $html .= $discountGivin;


    $taxset = $data->query("SELECT setting_value FROM shop_settings WHERE setting_name = 'do_tax_stuff'");
    $taxGet = $taxset->fetch_array();
    if ($taxGet["setting_value"] == 'true') {
        $shippingInfo = json_decode($_SESSION["customer_shipping_info"], true);
        $shipping_address = $shippingInfo["shipping_address"];
        $shipping_option_address = $shippingInfo["shipping_option_address"];
        $shipping_city = $shippingInfo["shipping_city"];
        $shipping_state = $shippingInfo["shipping_state"];
        $shipping_zip = $shippingInfo["shipping_zip"];

        if(isset($shippingInfo["pickuplocs"])){
            $sh = $data->query("SELECT location_zip FROM location WHERE id = '".$shippingInfo["pickuplocs"]."'");
            $shzip = $sh->fetch_array();
            $shipping_zip = $shzip["location_zip"];
        }

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.zip-tax.com/request/v40?key=boqTFIlB6wW83VHr&postalcode=' . $shipping_zip . '',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
        ));

        $response = curl_exec($curl);
        $response = json_decode($response, true);
        $taxRate = $response["results"][0]["taxSales"];
        curl_close($curl);

        // ADD IT TO THE COOKIE SO WE DONT HAVE TO RECALL IT //
        $cartRaw = $_COOKIE["savedData"];
        $cartRaw = json_decode($cartRaw, true);
        $theSessionOut = json_decode($_COOKIE["savedData"], true);
        $cartItems = $theSessionOut["cartitems"];
        $shopLocation = $theSessionOut["shop_location"];
        $code = $theSessionOut["discount_code"];
        $countOut = 0;

       // var_dump($cartItems);
        for ($i = 0; $i < count($cartItems); $i++) {
            $mydata[] = array("id" => $cartItems[$i]["id"], "name" => $cartItems[$i]["name"], "eqtype" => $cartItems[$i]["eqtype"], "price" => $cartItems[$i]["price"], "url" => $cartItems[$i]["url"], "eqtabs" => $cartItems[$i]["eqtabs"], "qty" => $cartItems[$i]["qty"], "pickup" => $cartItems[$i]["pickup"], "itemid" => $cartItems[$i]["itemid"]);
            $price = $cartItems[$i]["price"] * $cartItems[$i]["qty"];
            $countOut += str_replace(',', '', $price);
        }

        if ($percent != null) {
            $countOut = $countOut - $percent;
        }



        $tax = round((($countOut * $taxRate)), 2);
        $eq = json_encode(array("shop_location" => $shopLocation, "cartitems" => $mydata, "discount_code" => $code, "shipping_type" => '', "shipping_token" => '', "shipping_price" => '', "applied_tax" => $tax));
        unset($_COOKIE["savedData"]);
        setcookie("savedData", $eq, time() + (86400 * 30), "/", false);

        $html .= '<table class="table shoping-cart-table"><tbody><tr><td style="padding: 10px">Tax:</td><td class="tax_inplace" style="padding: 10px;text-align: right">$' . number_format($tax, 2) . '</td></tr></tbody></table>';
        $countOut = $countOut + $tax;
    } else {
        $countOut = $countOut;
    }

    $html .= '</div>';

    $html .= '<div class="ibox-content" style="text-align: right;">';
    if(isset($shippingInfo["pickuplocs"])) {
        $html .= '<div style="text-align: right; font-weight: bold">Selected Pickup Location<br><br></div>';
    }else{
        $html .= '<div style="text-align: right; font-weight: bold">Select Pickup / Shipping Method<br><br></div>';
    }


    if(isset($shippingInfo["pickuplocs"])){

        $sh = $data->query("SELECT location_name, location_address, location_city, location_state, location_zip FROM location WHERE id = '".$shippingInfo["pickuplocs"]."'");
        $shinfo = $sh->fetch_array();

        $html .= '<div class="alert alert-warning"><b>Pickup Location</b><br>James River '.$shinfo["location_name"].' Store <br> '.$shinfo["location_address"].'<br>'.$shinfo["location_city"].' '.$shinfo["location_state"].', '.$shinfo["location_zip"].'</div><br>';

        $html .= '<form name="shipssels" id="shipssels"><input type="hidden" name="shipping_select" id="shipping_select" value="pickup"><input type="hidden" name="pickup_location" id="pickup_location" value="'.$shippingInfo["pickuplocs"].'"></form>';
    }else{
        require_once('vendor/shippo/lib/Shippo.php');

        Shippo::setApiKey("shippo_test_64652f09f24e5e7ff9f19f5e31eaa70366f57d85");

        //    var_dump($_COOKIE);


        $from = 'FROM: ' . $shopStore . ' - ' . $shopAddress . ' - ' . $shopCity . ' - ' . $shopState . ' - ' . $shopZip . '<br>';

        // Example from_address array
        // The complete refence for the address object is available here: https://goshippo.com/docs/reference#addresses

        $from_address = array(
            'name' => 'John Doe',
            'company' => $shopStore,
            'street1' => $shopAddress,
            'city' => $shopCity,
            'state' => $shopState,
            'zip' => $shopZip,
            'country' => 'US',
            'phone' => '+1 405 478 4752',
            'email' => 'sales@bealscunningham.com',
        );

        $toplace = 'TO:' . $shipping_first_name . ' - ' . $shipping_last_name . ' - ' . $shipping_address . ' - ' . $shipping_option_address . ' - ' . $shipping_city . ' - ' . $shipping_state . ' - ' . $shipping_zip . ' - ' . $shipping_phone . ' - ' . $shipping_email;

        // Example to_address array
        // The complete refence for the address object is available here: https://goshippo.com/docs/reference#addresses
        $completeShippingAddress = $shipping_address . ', ' . $shipping_option_address;
        $to_address = array(
            'name' => $shipping_first_name . ' ' . $shipping_last_name,
            'company' => '',
            'street1' => $completeShippingAddress,
            'city' => $shipping_city,
            'state' => $shipping_state,
            'zip' => $shipping_zip,
            'country' => 'US',
            'phone' => $shipping_phone,
            'email' => $shipping_email,
        );


        // Parcel information array
        // The complete reference for parcel object is here: https://goshippo.com/docs/reference#parcels
        // Below we are getting all the items in cart and calculating the maximum width, height, and length
        //    $packArs[] = array("l"=>20,"w"=>10,"h"=>30);
        //    $packArs[] = array("l"=>17,"w"=>45,"h"=>7);
        //    $packArs[] = array("l"=>23,"w"=>25,"h"=>14);

        for ($n = 0; $n < count($packArs); $n++) {
            $lenArs[] = $packArs[$n]["l"];
            $widArs[] = $packArs[$n]["w"];
            $heiArs[] = $packArs[$n]["h"];
        }


        $maxLength = max($lenArs);
        $maxwidth = max($widArs);
        $maxheight = max($heiArs);

        $dimentions = $maxLength . 'X' . $maxwidth . 'X' . $maxheight;
        // echo $dimentions. ' - '. $weightOut;

        $parcel = array(
            'length' => $maxLength,
            'width' => $maxwidth,
            'height' => $maxheight,
            'distance_unit' => 'in',
            'weight' => $weightOut,
            'mass_unit' => 'lb',
        );

        // Example shipment object
        // For complete reference to the shipment object: https://goshippo.com/docs/reference#shipments
        // This object has async=false, indicating that the function will wait until all rates are generated before it returns.
        // By default, Shippo handles responses asynchronously. However this will be depreciated soon. Learn more: https://goshippo.com/docs/async
        $shipment = Shippo_Shipment::create(
            array(
                'address_from' => $from_address,
                'address_to' => $to_address,
                'parcels' => array($parcel),
                'async' => false,
            )
        );


        // Filter rates by MAX_TRANSIT_TIME_DAYS
        // Rates are stored in the `rates` array
        // The details on the returned object are here: https://goshippo.com/docs/reference#rates
        $eligible_rates = array_values(array_filter(
            $shipment['rates'],
            function ($rate) {
                return $rate['days'] <= MAX_TRANSIT_TIME_DAYS;
            }
        ));
        // var_dump($from_address);
        // Select the cheapest rate from eligible service levels
        usort($eligible_rates, function ($a, $b) {
            // usort function casts the result to int, so be aware that returning $a['amount'] - $b['amount']
            // may state that 2 amounts are equal when they are not
            if ($a['amount'] < $b['amount']) return -1;
            if ($a['amount'] > $b['amount']) return 1;
            return 0;
        });


        //    echo '<pre style="background: #efefef; padding: 20px; margin: 30px; max-height: 300px; overflow: scroll">';
        //
        //    var_dump($eligible_rates);
        //
        //    echo '</pre>';

        for ($i = 0; $i < count($eligible_rates); $i++) {
            // $html .= $eligible_rates[$i]["amount"].' - '.$eligible_rates[$i]["provider"].' '.$eligible_rates[$i]["servicelevel"]["name"].' - '.$eligible_rates[$i]["object_id"].' - <img src="'.$eligible_rates[$i]["provider_image_75"].'"><br>';

            $sippingOptions .= '<option value="' . $eligible_rates[$i]["object_id"] . '" data-amount="' . $eligible_rates[$i]["amount"] . '">' . $eligible_rates[$i]["provider"] . ' ' . $eligible_rates[$i]["servicelevel"]["name"] . ' - $' . $eligible_rates[$i]["amount"] . '</option>';

            $look .= $eligible_rates[$i]["amount"] . ' - ' . $eligible_rates[$i]["object_id"] . ' - ' . $eligible_rates[$i]["provider"] . '<br>';
        }
        $html .= '<form name="shipssels" id="shipssels" method="post" action="">';

        if (!empty($pickUpItem)) {
            $html .= 'You have items in your cart that need to be picked up.';
        }

        if ($sippingOptions != null) {

            $html .= '<select class="form-control" name="shipping_select" id="shipping_select" required="required"><option value="">Select Option</option> ';
            $chk = $data->query("SELECT setting_value FROM shop_settings WHERE setting_name = 'location_select'");
            $chk1 = $chk->fetch_array();
            if ($chk1["setting_value"] == 'true') {
                $html .= '<option disabled>----------</option>';
                $html .= '<option value="pickup" data-amount="pickup">Pickup From Store Location</option>';
                $html .= '<option disabled>----------</option>';
            }
            $html .= $sippingOptions;
            $html .= '</select>';
        } else {
            $html .= '<script>$(".tax_inplace").html("$0.00");</script>';
            $html .= '<div class="alert alert-danger" style="text-align: left"><h3>Shipping Error!</h3>     <p>Either the cart weight limit of 150lbs has been exceeded or your shipping details are incorrect. Please review your <a href="Checkout" style="color:blue">shipping details</a> or select pickup location below.</p></div>';

            $html .= '<script>select_pickup_location();</script>';

            $html .= '<select name="pickup_location" id="pickup_location" class="form-control" required="required">';
            $html .= '<option value="">Select Pickup Location</option>';
            $locs = $data->query("SELECT id,location_name FROM location WHERE active = 'true' ORDER BY location_name ASC");
            while ($losc = $locs->fetch_array()) {
                $html .= '<option value="' . $losc["id"] . '">' . $losc["location_name"] . '</option>';
            }
            $html .= '</select>';
        }
    }
    $html .= '</form>';




    //// Purchase the desired rate with a transaction request
    //// Set async=false, indicating that the function will wait until the carrier returns a shipping label before it returns
    //$transaction = Shippo_Transaction::create(array(
    //    'rate'=> $eligible_rates[0]['object_id'],
    //    'async'=> false,
    //));
    //
    //// Print the shipping label from label_url
    //// Get the tracking number from tracking_number
    //if ($transaction['status'] == 'SUCCESS'){
    //    echo "--> " . "Shipping label url: " . $transaction['label_url'] . "\n";
    //    echo "--> " . "Shipping tracking number: " . $transaction['tracking_number'] . "\n";
    //} else {
    //    echo "Transaction failed with messages:" . "\n";
    //    foreach ($transaction['messages'] as $message) {
    //        echo "--> " . $message . "\n";
    //    }
    //}

    // For more tutorals of address validation, tracking, returns, refunds, and other functionality, check out our
    // complete documentation: https://goshippo.com/docs/
    $html .= '</div>';

    $html .= '<div class="ibox-content" style="text-align: right">

                    <span>
                        Total
                    </span>
                        <h2 class="font-bold thetotals" style="text-align: right">
                            $' . number_format($countOut, 2) . '
                        </h2><input type="hidden" name="cartpricez" id="cartpricez" value="' . number_format($countOut, 2) . '">
                        



                        <div class="m-t-sm">
                            <div class="btn-group">
                            <a href="javascript:void(0)" class="btn-default btn-sm thecheckout"><i class="fa fa-arrow-left"></i>  Back to Details</a>
                                <button class="btn btn-primary btn-sm checkout-payment"><i class="fa fa-shopping-cart"></i> Continue to payment method</button>
                            </div>
                        </div>
                    </div>
                </div>



<!--                <div class="ibox">-->
<!--                    <div class="ibox-content">-->
<!---->
<!--                        <p class="font-bold">-->
<!--                            Other products you may be interested-->
<!--                        </p>-->
<!--                        <hr>-->
<!--                        <div>-->
<!--                            <a href="#" class="product-name"> Product 1</a>-->
<!--                            <div class="small m-t-xs">-->
<!--                                Many desktop publishing packages and web page editors now.-->
<!--                            </div>-->
<!--                            <div class="m-t text-righ">-->
<!---->
<!--                                <a href="#" class="btn btn-xs btn-outline btn-primary">Info <i class="fa fa-long-arrow-right"></i> </a>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                        <hr>-->
<!--                        <div>-->
<!--                            <a href="#" class="product-name"> Product 2</a>-->
<!--                            <div class="small m-t-xs">-->
<!--                                Many desktop publishing packages and web page editors now.-->
<!--                            </div>-->
<!--                            <div class="m-t text-righ">-->
<!---->
<!--                                <a href="#" class="btn btn-xs btn-outline btn-primary">Info <i class="fa fa-long-arrow-right"></i> </a>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
            </div>
        </div>
    </div>
</div>';

    echo $html;
}

if ($act == 'selectedpickuplocation') {
    include('siteFunctions.php');
    $location_id = $_POST["location_id"];

    $a = $data->query("SELECT * FROM location WHERE id = $location_id AND active = 'true'") or die($data->error);

    $b = $a->fetch_array();
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api.zip-tax.com/request/v40?key=boqTFIlB6wW83VHr&postalcode=' . $b["location_zip"] . '',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
    ));

    $response = curl_exec($curl);
    $response = json_decode($response, true);
    $taxRate = $response["results"][0]["taxSales"];
    curl_close($curl);
    $cartRaw = $_COOKIE["savedData"];

    $cartRaw = json_decode($cartRaw, true);
    $theSessionOut = json_decode($_COOKIE["savedData"], true);
    $cartItems = $theSessionOut["cartitems"];
    $shopLocation = $theSessionOut["shop_location"];
    $code = $theSessionOut["discount_code"];
    $countOut = 0;
    for ($i = 0; $i < count($cartItems); $i++) {
        $mydata[] = array("id" => $cartItems[$i]["id"], "name" => $cartItems[$i]["name"], "eqtype" => $cartItems[$i]["eqtype"], "price" => $cartItems[$i]["price"], "url" => $cartItems[$i]["url"], "eqtabs" => $cartItems[$i]["eqtabs"], "qty" => $cartItems[$i]["qty"], "itemid" => $cartItems[$i]["itemid"]);
        $price = $cartItems[$i]["price"] * $cartItems[$i]["qty"];
        $countOut += str_replace(',', '', $price);
    }
    // var_dump($countOut);
    $savingCode = $theSessionOut["discount_code"];
    $aa = $data->query("SELECT percentage_off, date_expire, status FROM shop_discounts WHERE dis_code = '$savingCode' AND active = 'true'") or die($data->error);

    if ($aa->num_rows > 0) {
        $bb = $aa->fetch_array();
        $discountAval = $bb["percentage_off"];
        $discountAval = $discountAval / 100;
        $percent = $discountAval * $countOut;
        $countOutFin = $countOut - $percent;
        $countOut = $countOutFin;
    }
    // var_dump($countOut);
    $tax = round((($countOut * $taxRate)), 2);
    $eq = json_encode(array("shop_location" => $shopLocation, "cartitems" => $mydata, "discount_code" => $code, "shipping_type" => 'Customer Pickup', "shipping_token" => '', "pickup" => $b["location_name"], "applied_tax" => $tax));
    // $pickup_add = json_encode(array("shop_location" => $shopLocation, "cartitems" => $mydata, "discount_code" => $code, "shipping_type" => 'Customer Pickup', "shipping_token" => '', "pickup" => '', "applied_tax" => $tax));
    unset($_COOKIE["savedData"]);
    // unset($_SESSION["customer_shipping_info"]);

    setcookie("savedData", $eq, time() + (86400 * 30), "/", false);
    // setcookie("customer_shipping_info", $eq, time() + (86400 * 30), "/", false);
    // var_dump($_COOKIE["savedData"]);

    $html .= '<table class="table shoping-cart-table"><tbody><tr><td style="padding: 10px">Tax:</td><td class="tax_inplace" style="padding: 10px;text-align: right">$' . number_format($tax, 2) . '</td></tr></tbody></table>';
    $countOut = $countOut + $tax;
    echo '{"return_code":"1","total": "' . number_format($countOut, 2) . '","taxTotal": "' . number_format($tax, 2) . '"}';
}

if ($act == 'checkcodes') {
    include('siteFunctions.php');
    $a = new site();
    $info = $a->checkCodes($_POST["thesdiscount"]);

    echo $info;
}

if ($act == 'getCartTotal') {
    $cartRaw = $_COOKIE["savedData"];
    $cartItems_or = json_decode($_COOKIE["savedData"], true);

    $discountCode = $cartItems_or["discount_code"];

    $a = $data->query("SELECT percentage_off, date_expire, status FROM shop_discounts WHERE dis_code = '$discountCode' AND active = 'true'") or die($data->error);
    if ($a->num_rows > 0) {
        $b = $a->fetch_array();

        $cartItems = $cartItems_or["cartitems"];
        $countOut = 0;
        for ($i = 0; $i < count($cartItems); $i++) {
            $itemPrice = $cartItems[$i]["price"];
            $eqipId = $cartItems[$i]["id"];
            $eqipTab = $cartItems[$i]["eqtabs"];

            $x = $data->query("SELECT msrp, sales_price, discount, description FROM $eqipTab WHERE id = '$eqipId'") or die("THIS IS ONE " . $data->error);
            $v = $x->fetch_array();

            if($v["sales_price"] != 'NULL'){
                $price = $v["sales_price"] * $cartItems[$i]["qty"];
            }else{
                $price = $v["msrp"] * $cartItems[$i]["qty"];
            }

            $thePurchaseIn .= '' . ucwords($cartItems[$i]["eqtype"]) . ' - ' . $cartItems[$i]["name"] . ' ';
            $countOut += str_replace(',', '', $price);
        }



        $discountAval = $b["percentage_off"];
        $discountAval = $discountAval / 100;

        $percent = $discountAval * $countOut;

        $countOutFin = $countOut - $percent;

        $tabInfo = addslashes('<table class="table shoping-cart-table"><tbody><tr><td style="padding: 10px">Applied Discount:</td><td style="padding: 10px;text-align: right"><small>' . $b["percentage_off"] . '% Off</small><br>-$' . number_format($percent, 2) . '</td></tr></tbody></table>');

        echo '{"return_code":"1","total": "$' . number_format($countOutFin, 2) . '","discount_info": "' . $tabInfo . '"}';
    } else {
    }



    //echo '{"total": "'.$countOut.'","discount_info": "<table class="table shoping-cart-table"><tbody><tr><td style="padding: 10px">Applied Discount:</td><td style="padding: 10px"><small>10% Off</small><br>-$2.34</td></tr></tbody></table>"}';


}

if ($act == 'selectedshipping') {
    $price = $_POST["price"];
    $readable = $_POST["readable"];
    $shipToken = $_POST["shipToken"];

    include('siteFunctions.php');
    $a = new site();

    if ($price != 'pickup') {
        $thing = $a->setShip($shipToken, $price, $readable);
        echo $thing;
    } else {
        $thing = $a->setShip(null, '0.00', 'Customer Pickup');
        echo $thing;
    }
}

if ($act == 'paymentforms') {

    include('config.php');
    session_start();
    // var_dump($_SESSION["customer_shipping_info"]);

    $price = $customer_shipping_info["price"] * $customer_shipping_info["qty"];
    $countOut += str_replace(',', '', $price);
    $cartData = json_encode($_COOKIE["savedData"]);


    if (isset($_SESSION["customer_shipping_info"])) {

        $shippingInfo = json_decode($_SESSION["customer_shipping_info"], true);

        $shipping_first_name = $shippingInfo["shipping_first_name"];
        $shipping_last_name = $shippingInfo["shipping_last_name"];
        $shipping_address = $shippingInfo["shipping_address"];
        $shipping_option_address = $shippingInfo["shipping_option_address"];
        $shipping_city = $shippingInfo["shipping_city"];
        $shipping_state = $shippingInfo["shipping_state"];
        $shipping_zip = $shippingInfo["shipping_zip"];
        $shipping_email = $shippingInfo["shipping_email"];
        $shipping_phone = $shippingInfo["shipping_phone"];
    } else {
        $shipping_first_name = '';
        $shipping_last_name = '';
        $shipping_address = '';
        $shipping_option_address = '';
        $shipping_city = '';
        $shipping_state = '';
        $shipping_zip = '';
        $shipping_email = '';
        $shipping_phone = '';
    }

    $cartQty = 0;
    $cartRaw = $_COOKIE["savedData"];
    $cartRaw = json_decode($cartRaw, true);
    // var_dump($cartRaw);

    if ($cartRaw["shipping_type"] == "Customer Pickup") {

        $customer_shipping_info = json_decode($_SESSION["customer_shipping_info"], true);
        $shipping_first_name = $customer_shipping_info["shipping_first_name"];
        $shipping_last_name = $customer_shipping_info["shipping_last_name"];
        $shipping_address = $customer_shipping_info["shipping_address"];
        $shipping_option_address = $customer_shipping_info["shipping_option_address"];
        $shipping_city = $customer_shipping_info["shipping_city"];
        $shipping_state = $customer_shipping_info["shipping_state"];
        $shipping_zip = $customer_shipping_info["shipping_zip"];
        $shipping_email = $customer_shipping_info["shipping_email"];
        $shipping_phone = $customer_shipping_info["shipping_phone"];


        $customer_shipping_data = json_encode(array("shipping_first_name" => $shipping_first_name, "shipping_last_name" => $shipping_last_name, "shipping_address" => $shipping_address, "shipping_option_address" => $shipping_option_address, "shipping_city" => $shipping_city, "shipping_state" => $shipping_state, "shipping_zip" => $shipping_zip, "shipping_email" => $shipping_email, "shipping_phone" => $shipping_phone, "shipping_method" => $cartRaw["shipping_type"], "pickup_location" => $cartRaw["pickup"]));

        unset($_SESSION["customer_shipping_info"]);
        $_SESSION["customer_shipping_info"] = $customer_shipping_data;
    }

    // var_dump($_SESSION["customer_shipping_info"]);
    $cartItems_or = json_decode($_COOKIE["savedData"], true);
    $cartItems = $cartItems_or["cartitems"];
    //var_dump($cartItems);

    ///GET TOTAL QTY IN CART//
    for ($i = 0; $i < count($cartItems); $i++) {
        $theQty = $cartItems[$i]["qty"];
        $cartQty += $theQty;
    }


    $html .= '<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
<div class="container-fluid" id="printOrder">
    <div class="wrapper wrapper-content">
    
        <div class="row m-0">
        
            <div class="col-md-7">';

    $html .= '<div class="messageareas"></div><div class="overlays"><div class="lds-ring"></div></div>';


    $html .= '<!-- Display a payment form -->
    <form id="payment-form" method="post" action="" style="background: #efefef; padding: 20px; border-radius: 15px;">';
    $html .= '<div class="row">';
    $html .= '<div class="col-md-12"><h3 class="jr-font">Payment Details</h3></div>';
    $html .= '<div class="col-md-6">';
    $html .= '<label>First Name</label><br>';
    $html.= '<input type="text" class="form-control" name="first_name_on_card" id="first_name_on_card" value="" placeholder="First Name" required="required">';
    $html .= '</div>';
    $html .= '<div class="col-md-6">';
    $html .= '<label>Last Name</label><br>';
    $html.= '<input type="text" class="form-control" name="last_name_on_card" id="last_name_on_card" value="" placeholder="Last Name" required="required">';
    $html .= '</div><br>';
    $html .= '<div class="col-md-12" style="margin-top: 15px;">
    <div id="payment-element" style="margin-bottom: 10px;">
        <!--Stripe.js injects the Payment Element-->
      </div>
      </div>';
    if(isset($_REQUEST["pickuploc"]) && $_REQUEST["pickuploc"] != '' && $_REQUEST["pickuploc"] != 'undefined'){
        $a = $data->query("SELECT location_name, location_address, location_city, location_state, location_zip FROM location WHERE id = '" . $_REQUEST["pickuploc"] . "'") or die($data->error);
        $b = $a->fetch_array();

        $html .= '<div class="col-md-12"><br><h5>Pickup Details</h5></div>';
        $html .= '<div class="alert alert-warning"><b>James River '.$b["location_name"].' Store</b><br>'.$b["location_address"].'<br>'.$b["location_city"].' '.$b["location_state"].', '.$b["location_zip"].'</div>';
        $html .= '<input type="hidden" name="locationpickup" id="locationpickup" value="'.$_REQUEST["pickuploc"].'">';
        $html .= '</div>';
    }else{
        $html .= '<div class="col-md-12"><br><h5>Billing Details</h5></div>';
        $html .= '<div class="col-md-12"><input type="checkbox" id="sameShippingAddr" name="sameShippingAddr" value="Bike"> Same as Shipping Address</div><script>
    $("#sameShippingAddr").change(function () {
        if($("#sameShippingAddr").is(":checked")){
            $("#billing_address").val("'.$shipping_address.'");
            $("#billing_city").val("'.$shipping_city.'");
            $("#billing_state").val("'.$shipping_state.'");
            $("#billing_zip").val("'.$shipping_zip.'");
        }else{
            $("#billing_address").val("");
            $("#billing_city").val("");
            $("#billing_state").val("");
            $("#billing_zip").val("");
        } 
     });
    </script>';


        $html .= '<div class="col-md-12">';
        $html .= '<label>Address*</label><br>';
        $html .= '<input type="text" class="form-control" name="billing_address" id="billing_address" value="" placeholder="Address Here" required="required">';
        $html .= '</div>';
        $html .= '<div class="col-md-5"><br>';
        $html .= '<label>City*</label><br>';
        $html .= '<input type="text" class="form-control" name="billing_city" id="billing_city" value="" placeholder="City" required="required">';
        $html .= '</div>';
        $html .= '<div class="col-md-4"><br>';
        $html .= '<label>State*</label><br>';
        $states = array(
            'Alabama' => 'AL',
            'Alaska' => 'AK',
            'Arizona' => 'AZ',
            'Arkansas' => 'AR',
            'California' => 'CA',
            'Colorado' => 'CO',
            'Connecticut' => 'CT',
            'Delaware' => 'DE',
            'Florida' => 'FL',
            'Georgia' => 'GA',
            'Hawaii' => 'HI',
            'Idaho' => 'ID',
            'Illinois' => 'IL',
            'Indiana' => 'IN',
            'Iowa' => 'IA',
            'Kansas' => 'KS',
            'Kentucky' => 'KY',
            'Louisiana' => 'LA',
            'Maine' => 'ME',
            'Maryland' => 'MD',
            'Massachusetts' => 'MA',
            'Michigan' => 'MI',
            'Minnesota' => 'MN',
            'Mississippi' => 'MS',
            'Missouri' => 'MO',
            'Montana' => 'MT',
            'Nebraska' => 'NE',
            'Nevada' => 'NV',
            'New Hampshire' => 'NH',
            'New Jersey' => 'NJ',
            'New Mexico' => 'NM',
            'New York' => 'NY',
            'North Carolina' => 'NC',
            'North Dakota' => 'ND',
            'Ohio' => 'OH',
            'Oklahoma' => 'OK',
            'Oregon' => 'OR',
            'Pennsylvania' => 'PA',
            'Rhode Island' => 'RI',
            'South Carolina' => 'SC',
            'South Dakota' => 'SD',
            'Tennessee' => 'TN',
            'Texas' => 'TX',
            'Utah' => 'UT',
            'Vermont' => 'VT',
            'Virginia' => 'VA',
            'Washington' => 'WA',
            'West Virginia' => 'WV',
            'Wisconsin' => 'WI',
            'Wyoming' => 'WY'
        );

        $html .= '<select name="billing_state" id="billing_state" class="form-control" required="required">';
        $html .= '<option value="">Select State</option>';

        foreach ($states as $key => $val) {

            $html .= '<option value="' . $val . '">' . $key . '</option>';
        }



        $html .= '</select>';
        $html .= '</div>';
        $html .= '<div class="col-md-2">';
        $html .= '<br><label>Zip Code*</label><br>';
        $html .= '<input type="text" class="form-control" name="billing_zip" id="billing_zip" value="" placeholder="00000" required="required" maxlength="5">';
        $html .= '</div>';
        $html .= '</div>';
    }

    $html .= '</form><br><br>';

    if(isset($_REQUEST["pickuploc"]) && $_REQUEST["pickuploc"] != '' && $_REQUEST["pickuploc"] != 'undefined'){
    $tabDis = 'display:none';
    }else{
        $tabDis = '';
    }
    $html .= '<div class="ibox">
    <table style="width: 100%; '.$tabDis.'"><tr><td>
                    <div class="ibox-title">
                        <h5>Store Location</h5>
                    </div>';
    $html .= '<div class="ibox-content">';

    $location = $cartItems_or["shop_location"];




    $a = $data->query("SELECT location_name, location_address, location_city, location_state, location_zip FROM location WHERE id = '" . $location . "'") or die($data->error);
    $b = $a->fetch_array();

    $shopStore = $b["location_name"];
    $shopAddress = $b["location_address"];
    $shopCity = $b["location_city"];
    $shopState = $b["location_state"];
    $shopZip = $b["location_zip"];


    // Shipping/Pickup Location Start===========
    if ($cartRaw["shipping_type"] == "Customer Pickup") {
        $shipping_details_title = '<div class="ibox-title">
        <h5>Pickup Details 4</h5>
    </div>';
        $pickup_data = $data->query("SELECT * FROM location WHERE location_name = '" . $cartRaw["pickup"] . "'") or die($data->error);
        $pickup_data_val = $pickup_data->fetch_array();
        $shipping_details_payment .= 'James River Equipment, ' . $pickup_data_val["location_name"] . '<br>';
        $shipping_details_payment .= $pickup_data_val["location_address"] . '<br>';
        $shipping_details_payment .= $pickup_data_val["location_city"] . ' ' . $pickup_data_val["location_state"] . ', ' . $pickup_data_val["location_zip"];
    } else {
        $shipping_details_title = '<div class="ibox-title">
        <h5>Shipping Details</h5>
    </div>';

        $shipping_details_payment .= $shipping_first_name . ' ' . $shipping_last_name . '<br>';
        $shipping_details_payment .= $shipping_address . ' ' . $shipping_option_address . '<br>';
        $shipping_details_payment .= $shipping_city . ' ' . $shipping_state . ', ' . $shipping_zip;
    }

    // Shipping/Pickup Location End===========


    $html .= '<div class="row m-0">';
    $html .= '<div class="col-md-12 p-0" style="font-style: italic">' . $b["location_name"] . '<br>' . $b["location_address"] . ' <br>' . $b["location_city"] . ' ' . $b["location_state"] . ', ' . $b["location_zip"] . '</div>';
    $html .= '</div>';



    $html .= '</div></td>';


    $html .= '<td><div class="ibox">
    <div class="overlays"><div class="lds-ring"></div></div>
                    ' . $shipping_details_title;

    $html .= '<div class="ibox-content">';

    $html .= '<div class="row m-0">';
    $html .= '<div class="col-md-12 p-0" style="font-style: italic">';
    $html .= $shipping_details_payment . '<br>';

    $html .= '</div>';
    $html .= '</div>';

    $html .= '</div>';

    $html .= '</div></td>';

    $html .= '<td><div class="ibox" style="margin-bottom: 30px;">';

    $html .= '<div class="ibox-title"><h5>Contact Details</h5></div>';

    $html .= '<div class="ibox-content">';

    $html .= '<div class="row m-0">';
    $html .= '<div class="col-md-12 p-0" style="font-style: italic">em. ' . $shipping_email . '</div>';
    $html .= '</div>';
    $html .= '<div class="row" style="margin-top: 5px">';
    $html .= '<div class="col-md-12" style="font-style: italic">ph. ' . $shipping_phone . '</div>';
    $html .= '<div class="col-md-12 couponars" style="margin-top: 15px; display: none"><a href="javascript:void(0)" class="btn-default btn-sm thecheckout"><i class="fa fa-arrow-left"></i> Edit Details</a> </div>';
    $html .= '</div>';
    $html .= '</div></td></tr></table>';

    $html .= '
                
                </div>
            </div>
            <div class="col-md-5">';




    for ($i = 0; $i < count($cartItems); $i++) {
        $itemPrice = $cartItems[$i]["price"];
        $thePurchaseIn .= '' . ucwords($cartItems[$i]["eqtype"]) . ' - ' . $cartItems[$i]["name"] . ' ';
        $countOut += $itemPrice;
    }

    $countOut = 0;

    //get tax rate//
    $chk = $data->query("SELECT setting_value FROM shop_settings WHERE setting_name = 'do_tax_stuff'");
    $chk1 = $chk->fetch_array();
    if ($chk1["setting_value"] == 'true') {

        if ($cartRaw["shipping_type"] != 'Customer Pickup') {
            $tax = $cartRaw["applied_tax"];
        } else {
            $tax = $cartRaw["applied_tax"];
        }
    } else {
        $taxrate = 0;
    }
    $weightOut = 0;

    $thePurchase .= '<div class="ibox-content">
                        <div class="table-responsive">
                            <table class="table shoping-cart-table">
                            <thead><tr><td><b>Item</b></td><td style="width: 50%"><b>Qty</b></td><td style="width: 50%; text-align: right"><b>Price</b></td></tr></thead>
                                <tbody>';


    for ($i = 0; $i < count($cartItems); $i++) {
        $itemPrice = $cartItems[$i]["price"];

        if ($i < count($cartItems) - 1) {
            $borderSty = 'style="border-bottom: solid thin #efefef"';
        } else {
            $borderSty = '';
        }

        ///APPLIED PATCH FOR PRICE ADJUSTMENT FOR SHIPPING AND STUFF///

        $eqipId = $cartItems[$i]["id"];
        $eqipTab = $cartItems[$i]["eqtabs"];

        $x = $data->query("SELECT msrp, sales_price, discount, description, weight, ship_type, dimentions  FROM $eqipTab WHERE id = '$eqipId'") or die("THIS IS ONE " . $data->error);
        $v = $x->fetch_array();

        if($v["sales_price"] != 'Null'){
            $price = $v["sales_price"] * $cartItems[$i]["qty"];
        }else{
            $price = $v["msrp"] * $cartItems[$i]["qty"];
        }

        $weight = $v["weight"] * $cartItems[$i]["qty"];

        if (strlen($v["description"]) > 140) {
            $descript = substr($v["description"], 0, 140) . ' ...';
        } else {
            if ($v["description"] != null) {
                $descript = $v["description"];
            }
        }

        $dimentions = explode('X', $v["dimentions"]);

        $packArs[] = array("l" => $dimentions[0], "w" => $dimentions[1], "h" => $dimentions[2]);

        if($v["sale_price"] != 'Null'){
            $listpr = $v["sale_price"];
        }else{
            $listpr = $v["msrp"];
        }


        $thePurchasesds .= '<tr><td>' . $cartItems[$i]["name"] . '</td><td>$' . number_format($listpr, 2) . '</td><td>' . $cartItems[$i]["qty"] . '<input class="form-control" style="max-width: 55%" type="text" name="itmqty_' . $cartItems[$i]["itemid"] . '" id="itmqty_' . $cartItems[$i]["itemid"] . '" value="' . $cartItems[$i]["qty"] . '"> <a href="javascript:void(0)" class="updateval" data-itemid="' . $cartItems[$i]["itemid"] . '" data-itemname="' . $cartItems[$i]["name"] . '" data-realid="' . $cartItems[$i]["id"] . '" data-eqtabs="' . $cartItems[$i]["eqtabs"] . '">Update</a></td><td>$' . number_format($price, 2) . '</td><td><a class="removit" href="javascript:void(0)" onclick="removeSavedCart(' . $cartItems[$i]["itemid"] . ',' . $cartItems[$i]["eqtabs"] . ')">remove</a></td></tr>';

        $thePurchase .= '
                               
                                <tr ' . $borderSty . '>
                                    <td class="desc" style="width:50%">
                                        <h5 style="margin: 0">
                                            <a href="' . $cartItems[$i]["url"] . '" class="text-navy-small" >
                                                ' . str_replace('_', ' ', $cartItems[$i]["name"]) . '
                                            </a>
                                        </h5>
                                        <small style="font-style: italic">$' . number_format($listpr, 2) . ' ea</small><br>
                                        <!--<b style="color: red">NOTICE! - This item Must be picked up.</b>-->
                                       
                                    </td>

                                   
                                    <td width="">
                                    ' . $cartItems[$i]["qty"] . '
                                   
                                </td>
                                        
                                   
                                    <td>
                                        <h8 style="display: block; width:100px; text-align: right">
                                            $' . number_format($price, 2) . '
                                        </h8>
                                    </td>
                                </tr>
                                ';

        $countOut += str_replace(',', '', $price);

        $weightOut += $weight;
    }

    $thePurchase .= '</tbody>
                            </table>
                        </div>

                    </div>';

    $savingCode = $cartItems_or["discount_code"];
    $a = $data->query("SELECT percentage_off, date_expire, status FROM shop_discounts WHERE dis_code = '$savingCode' AND active = 'true'") or die($data->error);

    if ($a->num_rows > 0) {
        $b = $a->fetch_array();
        $discountAval = $b["percentage_off"];
        $discountAval = $discountAval / 100;

        $percent = $discountAval * $countOut;

        $countOutFin = $countOut - $percent;

        $discountGivin = '<table class="table shoping-cart-table"><tbody><tr><td style="padding: 10px">Applied Discount:</td><td style="padding: 10px;text-align: right"><small>' . $b["percentage_off"] . '% Off</small><br>-$' . number_format($percent, 2) . '</td></tr></tbody></table>';
        $countOut = $countOutFin;
    }

    //get tax rate//
    $chk = $data->query("SELECT setting_value FROM shop_settings WHERE setting_name = 'do_tax_stuff'");
    $chk1 = $chk->fetch_array();
    if ($chk1["setting_value"] == 'true') {

        if ($cartRaw["shipping_type"] != 'Customer Pickup') {
            $tax = $cartRaw["applied_tax"];
        } else {
            $tax = $cartRaw["applied_tax"];
        }
    } else {
        $tax = 0;
    }



    $countOut = $countOut + $tax;

    $totalWeight = $weightOut;




    $html .= '<div class="ibox">
                    <div class="ibox-title">
                        <h5>Cart Summary</h5> 
                    </div>
                    <div>' . $thePurchase . '</div>';




    if ($savingCode == '') {

        $htmlOLD .= '<form name="the-discount" id="the-discount" method="post" action=""><div style="padding: 30px"><div class="input-group mb-3">
  <input type="text" class="form-control" name="thesdiscount" id="thesdiscount" placeholder="Discount Code" required="required" autocomplete="off">
  <div class="input-group-append">
    <button class="btn btn-secondary" type="submit">Redeem</button>
  </div>
</div></div></form>';

        $html .= '<div style="text-align: right; padding: 20px" class="couponars"><b>No Coupon Added.</b></div>';
    }



    $html .= '<div class="discountapply ibox-content">';
    //DO SOME DISCOUNT STUFF OR WHATEVA//
    $html .= $discountGivin;



    $taxset = $data->query("SELECT setting_value FROM shop_settings WHERE setting_name = 'do_tax_stuff'");
    $taxGet = $taxset->fetch_array();
    if ($taxGet["setting_value"] == 'true') {
        $html .= '<table class="table shoping-cart-table"><tbody><tr><td style="padding: 10px">Tax:</td><td style="padding: 10px; text-align: right">$' . number_format($tax, 2) . '</td></tr></tbody></table>';
    }


    $html .= '</div>';

    $html .= '<div class="ibox-content" style="text-align: right;">';
    $html .= '<div style="text-align: right; font-weight: bold">Selected Pickup/Shipping Method<br></div>';


    $html .= $cartItems_or["shipping_type"] . '<br><br>';




    //// Purchase the desired rate with a transaction request
    //// Set async=false, indicating that the function will wait until the carrier returns a shipping label before it returns
    //$transaction = Shippo_Transaction::create(array(
    //    'rate'=> $eligible_rates[0]['object_id'],
    //    'async'=> false,
    //));
    //
    //// Print the shipping label from label_url
    //// Get the tracking number from tracking_number
    //if ($transaction['status'] == 'SUCCESS'){
    //    echo "--> " . "Shipping label url: " . $transaction['label_url'] . "\n";
    //    echo "--> " . "Shipping tracking number: " . $transaction['tracking_number'] . "\n";
    //} else {
    //    echo "Transaction failed with messages:" . "\n";
    //    foreach ($transaction['messages'] as $message) {
    //        echo "--> " . $message . "\n";
    //    }
    //}

    // For more tutorals of address validation, tracking, returns, refunds, and other functionality, check out our
    // complete documentation: https://goshippo.com/docs/
    $html .= '</div>';

    $grandTotal = $countOut + $cartItems_or["shipping_price"];

    $html .= '<div class="ibox-content" style="text-align: right">

                    <h5>
                        Total
                    </h5>
                        <h2 class="font-bold thetotals" style="text-align: right">
                            $' . number_format($grandTotal, 2) . '
                        </h2><input type="hidden" name="cartpricez" id="cartpricez" value="' . number_format($grandTotal, 2) . '">
                        



                        <div class="m-t-sm">
                            <div class="btn-group">
                            <a href="checkout" class="btn-default btn-sm"><i class="fa fa-arrow-left"></i>  Back to Cart</a>
                                <button id="submit-payment-form" class="btn btn-primary btn-sm complete-payment"><i class="fa fa-shopping-cart"></i> PLACE YOUR ORDER</button>
                            </div>
                        </div>
                    </div>
                </div>



<!--                <div class="ibox">-->
<!--                    <div class="ibox-content">-->
<!---->
<!--                        <p class="font-bold">-->
<!--                            Other products you may be interested-->
<!--                        </p>-->
<!--                        <hr>-->
<!--                        <div>-->
<!--                            <a href="#" class="product-name"> Product 1</a>-->
<!--                            <div class="small m-t-xs">-->
<!--                                Many desktop publishing packages and web page editors now.-->
<!--                            </div>-->
<!--                            <div class="m-t text-righ">-->
<!---->
<!--                                <a href="#" class="btn btn-xs btn-outline btn-primary">Info <i class="fa fa-long-arrow-right"></i> </a>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                        <hr>-->
<!--                        <div>-->
<!--                            <a href="#" class="product-name"> Product 2</a>-->
<!--                            <div class="small m-t-xs">-->
<!--                                Many desktop publishing packages and web page editors now.-->
<!--                            </div>-->
<!--                            <div class="m-t text-righ">-->
<!---->
<!--                                <a href="#" class="btn btn-xs btn-outline btn-primary">Info <i class="fa fa-long-arrow-right"></i> </a>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
            </div>
        </div>
    </div>
</div>';

    echo $html;
}


if ($act == 'complete_stripe_purchase') {

    include('config.php');
    session_start();

    /// echo 'starting ....';

    // CUSTOMER BILLING DETAILS //
    $bill_fname = $_POST["bill_fname"];
    $bill_lname = $_POST["bill_lname"];
    $bill_address = $_POST["bill_address"];
    $bill_city = $_POST["bill_city"];
    $bill_state = $_POST["bill_state"];
    $bill_zip = $_POST["bill_zip"];
    $locationpickup = $_POST["locationpickup"];


    // CUSTOMER SHIPPING DETAILS //
    $shipping_details = json_decode($_SESSION["customer_shipping_info"], true);
    if ($shipping_details["shipping_method"] != "Customer Pickup") {
        $ship_firstname = $shipping_details["shipping_first_name"];
        $ship_lastname = $shipping_details["shipping_last_name"];
        $shipping_address = $shipping_details["shipping_address"];
        $shipping_city = $shipping_details["shipping_city"];
        $shipping_state = $shipping_details["shipping_state"];
        $shipping_zip = $shipping_details["shipping_zip"];
        $shipping_email = $shipping_details["shipping_email"];
        $shipping_phone = $shipping_details["shipping_phone"];
    } else if ($shipping_details["shipping_method"] == "Customer Pickup") {
        $shipping_type = $shipping_details["shipping_method"];
        $ship_firstname = $shipping_details["shipping_first_name"];
        $ship_lastname = $shipping_details["shipping_last_name"];
        $customer_address = $shipping_details["shipping_address"];
        $customer_city = $shipping_details["shipping_city"];
        $customer_state = $shipping_details["shipping_state"];
        $customer_zip = $shipping_details["shipping_zip"];
        $shipping_email = $shipping_details["shipping_email"];
        $shipping_phone = $shipping_details["shipping_phone"];
        $pickup_location = $shipping_details["pickup_location"];
    }

    // PROCESS CART ITEMS AND CREATE ORDER //
    $cartItems = json_decode($_COOKIE["savedData"], true);
    $cartItemsProds = $cartItems["cartitems"];
    $shop_location = $cartItems["shop_location"];
    $cart_items = $cartItems["cartitems"];
    $discount = $cartItems["discount_code"];
    $shipping_type = $cartItems["shipping_type"];
    $shipping_token = $cartItems["shipping_token"];
    $shipping_price = $cartItems["shipping_price"];

    for ($i = 0; $i < count($cartItemsProds); $i++) {

        // MAKE ADJUSTMENTS TO PRODUCT QTY WHEN PURCHASED //

        $eqTable = $cartItemsProds[$i]["eqtabs"];
        $productId = $cartItemsProds[$i]["id"];
        $orderedQty = $cartItemsProds[$i]["qty"];

        $chkz = $data->query("SELECT setting_value FROM shop_settings WHERE setting_name = 'sell_per_qty'") or die($data->error);
        $chk22 = $chkz->fetch_array();

        if ($chk22["setting_value"] == 'true') {
            /// echo 'THis is  '. $shop_location.' - '.$eqTable.' - '.$productId.' - '.$orderedQty;
            $prod = $data->query("SELECT stock FROM equipment_location_manager WHERE equip_id = '$productId' AND equip_line = '$eqTable' AND location_id = '$shop_location'") or die($data->error);
            $prodDet = $prod->fetch_array();
            $currentStock = $prodDet["stock"] - $orderedQty;
            $data->query("UPDATE equipment_location_manager SET stock = '$currentStock' WHERE equip_id = '$productId' AND equip_line = '$eqTable' AND location_id = '$shop_location'") or die($data->error);
        }
        $mydata[] = array("id" => $cartItemsProds[$i]["id"], "name" => $cartItemsProds[$i]["name"], "eqtype" => $cartItemsProds[$i]["eqtype"], "price" => $cartItemsProds[$i]["price"], "url" => $cartItemsProds[$i]["url"], "eqtabs" => $cartItemsProds[$i]["eqtabs"], "qty" => $cartItemsProds[$i]["qty"], "itemid" => $cartItemsProds[$i]["itemid"]);
        $price = $cartItemsProds[$i]["price"] * $cartItemsProds[$i]["qty"];
        $countOut += str_replace(',', '', $price);
    }

    $cartData = json_encode($_COOKIE["savedData"]);

    // CHECK FOR COUPON CODES //
    if ($discount != '') {
        $a = $data->query("SELECT percentage_off, date_expire, status FROM shop_discounts WHERE dis_code = '$discount' AND active = 'true'") or die($data->error);
        if ($a->num_rows > 0) {
            $b = $a->fetch_array();
            $discountAval = $b["percentage_off"];
            $discountAval = $discountAval / 100;
            $percent = $discountAval * $countOut;
            $countOutFin = $countOut - $percent;
            $discount_applied = $countOut - $percent;

            $discountEmail = '<tr>
            <td class="table-td">
              <p style="margin-bottom: 5px">Discount Applied</p>
              <small>' . $b["percentage_off"] . '% off</small>
            </td>
            <td class="table-td"><p style="margin-bottom: 5px">-$' . $percent . '</p></td>
          </tr>';
        } else {
            $countOutFin = $countOut;
            $discountEmail = '';
        }
    } else {
        $countOutFin = $countOut;
    }



    // CHECK TAX RATES //
    $taxset = $data->query("SELECT setting_value FROM shop_settings WHERE setting_name = 'do_tax_stuff'") or die($data->error);
    $taxGet = $taxset->fetch_array();
    if ($taxGet["setting_value"] == 'true') {

        $locSet = $data->query("SELECT setting_value FROM shop_settings WHERE setting_name = 'location_select'") or die($data->error);
        $locgets = $locSet->fetch_array();
        if ($locgets["setting_value"] == 'true') {

            $tax = $data->query("SELECT tax_rate FROM equipment_tax WHERE relid = '$shop_location' AND active = 'true'") or die($data->error);
            $taxOut = $tax->fetch_array();


            if ($taxOut["tax_rate"] != '') {
                $taxRate = $taxOut["tax_rate"];
            } else {
                $taxRate = '0';
            }
            $taxrate = $taxRate;
            $tax = round((($countOutFin * $taxrate)), 2);
        } else {
            $tax = $cartItems["applied_tax"];
        }
    } else {
        $tax = 0;
    }

    //echo "This is ". $countOutFin.' and this is tax'.$tax;

    // ADD SOME SHIPPING PRICE IF SELECTED //
    if ($shipping_price != '') {
        $countOutDone = $countOutFin + $tax + $shipping_price;
    } else {
        $countOutDone = $countOutFin + $tax;
    }




    // DO SHIPPING THINGS //
    // echo "This is shipping token".$shipping_token;
    if ($cartItems["shipping_type"] != 'Customer Pickup') {

        $chk = $data->query("SELECT setting_value FROM shop_settings WHERE setting_name = 'ship_type_global'") or die($data->error);
        $chk2 = $chk->fetch_array();

        // check the shop settings to see if the client wants to create the shipping label //
        if ($chk2["setting_value"] == 'create_label') {
            require_once('vendor/shippo/lib/Shippo.php');

            Shippo::setApiKey("shippo_live_8ff94615685dcdd32f96cf1a08812c3fad943c5c");

            $transaction = Shippo_Transaction::create(array(
                'rate' => $shipping_token,
                'async' => false,
            ));

            // Print the shipping label from label_url
            // Get the tracking number from tracking_number
            if ($transaction['status'] == 'SUCCESS') {
                //                echo "--> " . "Shipping label url: " . $transaction['label_url'] . "\n";
                //                echo "--> " . "Shipping tracking number: " . $transaction['tracking_number'] . "\n";
                $ship_label = $transaction['label_url'];
                $ship_track = $transaction['tracking_number'];
            } else {
                //                echo "Transaction failed with messages:" . "\n";
                foreach ($transaction['messages'] as $message) {
                    //echo "--> " . $message . "\n";
                }

                $ship_label = 'Shipment Not Created';
                $ship_track = 'No Tracking';
            }
            $ship_label = $transaction['label_url'];
            $ship_track = $transaction['tracking_number'];
        } else {
            $ship_label = 'Label Not Created - Using suggested price only.';
            $ship_track = 'none';
        }
    } else {
        $ship_label = 'Customer Pickup';
        $ship_track = 'none';
    }

    //echo 'middle AFTER tax....'. $ship_label;

    // GENERATE PURCHASE NUMBER //
    function random19()
    {
        $today = date("Ymd");
        $rand = strtoupper(substr(uniqid(sha1(time())), 0, 4));
        return $unique = $today . $rand;
    }

    $purcahseNum = random19();
    $countOutDone = number_format($countOutDone, 2);

    // CREATE INVOICE //

    $data->query("INSERT INTO shop_orders SET purchase_num = '" . $data->real_escape_string($purcahseNum) . "', store_location = '" . $data->real_escape_string($shop_location) . "', first_name = '" . $data->real_escape_string($bill_fname) . "', last_name = '" . $data->real_escape_string($bill_lname) . "', email = '" . $data->real_escape_string($shipping_email) . "', phone = '" . $data->real_escape_string($shipping_phone) . "', address = '" . $data->real_escape_string($bill_address) . "', city = '" . $data->real_escape_string($bill_city) . "', state = '" . $data->real_escape_string($bill_state) . "', zip = '" . $data->real_escape_string($bill_zip) . "', ship_address = '" . $data->real_escape_string($shipping_address) . "', ship_city = '" . $data->real_escape_string($shipping_city) . "', ship_state = '" . $data->real_escape_string($shipping_state) . "', ship_zip = '" . $data->real_escape_string($shipping_zip) . "', items_list = '" . $data->real_escape_string($cartData) . "', purchase_price = '" . $data->real_escape_string($countOutDone) . "', ship_price = '$shipping_price', discount_applied = '" . $data->real_escape_string($discount_applied) . "', applied_tax = '" . $data->real_escape_string($tax) . "', ship_type = '" . $data->real_escape_string($cartItems["shipping_type"]) . "', ship_label_url = '" . $data->real_escape_string($ship_label) . "', ship_tracking = '" . $data->real_escape_string($ship_track) . "', date_sub = '" . time() . "'") or die($data->error);

    // INVOICE EMAIL TO CUSTOMER START===================
    include('siteFunctions.php');
    $process = new site();
    $emailtime = date("m/d/Y");
    if ($shipping_email != '') {
        $name = $bill_fname . ' ' . $bill_lname;
        $to[] = array("email" => $shipping_email, "name" => $name);
    }
    $dealerEmail1[] = array("email" => "sushp@bealscunningham.com", "name" => "James River Equipment");
    $a = $data->query("SELECT * FROM location WHERE id = '$shop_location'") or die($data->error);
    $b = $a->fetch_array();
    $invoceTable = $data->query("SELECT * FROM invoice_settings WHERE id = 1") or die($data->error);
    $invoceTableDetails = $invoceTable->fetch_array();
    $shoppingDetails = stripslashes(trim($cartData, '"'));
    $purchaseDetails = json_decode($shoppingDetails, true);
    $fromemail = "system@bcssdevelopment.com";
    $fromName = "James River Equipment Invoice";
    $subject = $invoceTableDetails["invoice_subject"];
    $invoiceHeaderImg = str_replace("../", "/", $invoceTableDetails["invoice_img"]);

    if ($shipping_details["shipping_method"] == "Customer Pickup") {
        $loc_data = $data->query("SELECT * FROM location WHERE location_name = '$pickup_location'");
        $loc_data_val = $loc_data->fetch_array();
        $shipping_data = '<p style="margin-bottom: 5px">Pickup Address<br><b>James River Equipment <br>
    ' . $loc_data_val["location_address"] . '<br />' . $loc_data_val["location_city"] . ' ' . $loc_data_val["location_state"] . ', ' . $loc_data_val["location_zip"] . '</b
     >
   </p>';
        $shipping_price = number_format(0, 2);
    } else {
        $shipping_data = '<p style="margin-bottom: 5px">Shipping Address<br><b>
        ' . $shipping_address . '<br />' . $shipping_city . ' ' . $shipping_state . ', ' . $shipping_zip . '</b
         >
       </p>';
    }

    if($locationpickup != ''){
        $a = $data->query("SELECT location_name, location_address, location_city, location_state, location_zip FROM location WHERE id = '$locationpickup'") or die($data->error);
        $b = $a->fetch_array();
        $shipping_data = '<p style="margin-bottom: 5px">Pickup Location<br><b>
        James River ' . $b["location_name"] . ' Store <br />' . $b["location_address"] . '<br> ' . $b["location_city"] . '' . $b["location_state"] . ', '.$b["location_zip"].'</b>
       </p>';


        $billedTo = '<p style="margin-bottom: 5px">Billed To<br>
        <b>'.$bill_fname.' '.$bill_lname.'<br><i>' . $shipping_email . '</i><br />' . $shipping_phone . '</b>
        </p>';
    }else{
        $billedTo = '<p style="margin-bottom: 5px">Billed To<br>
        <b>'.$bill_fname.' '.$bill_lname.'<br>' . $bill_address . '<br />' . $bill_city . ' ' . $bill_state . ', ' . $bill_zip . '<br /><i>' . $shipping_email . '</i><br />' . $shipping_phone . '</b>
        </p>';
    }





    $message .= '<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Order Details</title>
<style>
 body{
  width: 80%;
  margin: 10px auto;
 }
 .table-th{
  padding: 20px;
 }
 .table-td{
  padding: 5px 20px;
  border-bottom: 1px solid #dfdfdf;
 }
</style>
</head>
<body>
<div class="header">
<table style="
width: 100%;
margin: 20px;
padding: 30px;
">
 <tbody>
  <tr>
   <td>
    <a href="https://www.jamesriverequipment.com/"><img src="https://www.jamesriverequipment.com' . $invoiceHeaderImg . '" alt="Website Logo"></a>
   </td>
   <td>
    <h1 style="text-align: right;">' . $invoceTableDetails["invoice_headline"] . '</h1>
   </td>
  </tr>
 </tbody>
</table>
</div>
<table class="table" style="width: 100%; text-align: left">
  <tbody>
    <tr>
      <td>
        '.$billedTo.'
      </td>
      <td>
        ' . $shipping_data . '
       
      </td>
      <td>
       <p style="margin:0">
        Purchase Number: <br /><b>' . $purcahseNum . '</b>
      </p>
      <p style="margin-bottom: 5px">
        Purchase Date: <br /><b>' . $emailtime . '</b>
      </p>
      </td>
    </tr>
  </tbody>
</table>

<table class="table" style="width: 100%; text-align: left; margin-top: 5px;">
  <thead>
    <tr>
      <th class="table-th">Equipment</th>
      <th class="table-th">Price</th>
    </tr>
  </thead>
  <tbody>';
    foreach ($purchaseDetails["cartitems"] as $item) {
        $itemqty = (float)$item["qty"];
        $itemPrice = (float)$item["price"];
        $itemTotalPrice = $itemqty * $itemPrice;
        $message .= '<tr style="background-color: #e7e7e791">
      <td class="table-td">
        <p style="margin-bottom: 5px">
          <a href="' . $item["url"] . '" target="_blank">' . $item["name"] . '</a><br />
          <small>Quantity: ' . $item["qty"] . '</small>
        </p>
      </td>
      <td class="table-td">
        <p style="margin-bottom: 5px">
          $' . $itemTotalPrice . '<br /><small>$' . $item["price"] . '/ea</small>
        </p>
      </td>
    </tr>';
    }
    $message .= $discountEmail.'<tr>
      <td class="table-td">
        <p style="margin-bottom: 5px">Tax</p>
      </td>
      <td class="table-td"><p style="margin-bottom: 5px">$' . $tax . '</p></td>
    </tr>
    <tr>
      <td class="table-td">
        <p style="margin-bottom: 5px">
          Shipping Price<br />
          <small>' . $purchaseDetails["shipping_type"] . '</small>
        </p>
      </td>
      <td class="table-td"><p style="margin-bottom: 5px">$' . $shipping_price . '</p></td>
    </tr>
    <tr>
      <td class="table-td"><p style="margin-bottom: 5px"><b>Total</b></p></td>
      <td class="table-td"><p style="margin-bottom: 5px"><b>$' . $countOutDone . '</b></p></td>
    </tr>
  </tbody>
</table>
</body>
</html>
';

    $process->mailIt($to, $fromemail, $fromName, $subject, $message);
    $process->mailIt($dealerEmail1, $fromemail, $fromName, $subject, $message);
    // INVOICE EMAIL TO CUSTOMER END=====================


    unset($_COOKIE["savedData"]);
    unset($_SESSION["customer_shipping_info"]);
    setcookie("savedData", "", time() - (60 * 60 * 24), "/");

    // get success message //
    $a = $data->query("SELECT information FROM shop_settings WHERE setting_name = 'payment_success'") or die($data->error);
    $b = $a->fetch_array();
    $messOuts = $b["information"] . '<br>Your Order <a onclick =\"printTheOrder()\" href=\"javascript:void(0)\">#: ' . $purcahseNum .'</a>';

    echo '{"ret_status": "good","ret_message": "<b>Payment Successful</b><br><p>' . $messOuts . '</p>"}';
}


if($act == 'submitreview'){
    include('siteFunctions.php');
    $a = new site();
    $a->processReview($_POST);

}

if($act == 'destroycart'){
    echo "We are going";
    include('siteFunctions.php');
    $a = new site();
    session_start();
    setcookie("savedData", '', time() - (86400 * 30), "/", false);
    $results = $a->destroyCart();
    echo "This is ".$results;
}

if($act == 'eventtrak'){
    include('siteFunctions.php');
    $a = new site();
    $a->saveCaffEvent($_REQUEST["target"],$_REQUEST["page"]);
}
