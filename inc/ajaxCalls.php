<?php
include('config.php');
$act = $_REQUEST["action"];

if ($act == 'requestcat') {
    $sel .= '<option value="none">Select Option</option>';
    if ($_REQUEST["manufacturer"] != 'none') {
        $a = $data->query("SELECT * FROM used_equipment WHERE manufacturer = '" . $_REQUEST["manufacturer"] . "' AND active != 'false' GROUP BY category");
    } else {
        $a = $data->query("SELECT * FROM used_equipment WHERE active != 'false' GROUP BY category");
    }
    while ($b = $a->fetch_array()) {
        $sel .= '<option value="' . $b["category"] . '">' . $b["category"] . '</option>';
    }
    echo $sel;
}

if ($act == 'updateimgpos') {
    $profid = $_REQUEST["profid"];
    $lefts = $_REQUEST["left"];
    $top = $_REQUEST["top"];
    $site->updateImgPos($profid, $lefts, $top);
}



if ($act == 'saveforlater') {
    $total = 0;
    session_start();
    $eqipid = $_POST["eqipid"];
    $eqname = $_POST["eqname"];
    $eqtype = $_POST["eqtype"];
    $price = $_POST["price"];
    $url = $_POST["url"];
    $tabs = $_POST["tabs"];
    $qty = $_POST["qty"];
    $itemid = $_POST["itemid"];
    //$qty = '1';

    $chk = $data->query("SELECT setting_value FROM shop_settings WHERE setting_name = 'location_select'");
    $chk1 = $chk->fetch_array();
    if ($chk1["setting_value"] == 'true') {
        $locasel = $_POST["locasel"];
    } else {
        // attempt to get default location//
        $loc = $data->query("SELECT setting_value FROM shop_settings WHERE setting_name = 'default_ship_location'");
        $defloc = $loc->fetch_array();
        $locasel = $defloc["setting_value"];
    }

    $theSession = $_COOKIE["savedData"];


    if (isset($theSession)) {
        $theSession = json_decode($theSession, true);
        for ($i = 0; $i < count($theSession["cartitems"]); $i++) {
            $mydata[] = array("id" => $theSession["cartitems"][$i]["id"], "name" => $theSession["cartitems"][$i]["name"], "eqtype" => $theSession["cartitems"][$i]["eqtype"], "price" => $theSession["cartitems"][$i]["price"], "url" => $theSession["cartitems"][$i]["url"], "eqtabs" => $theSession["cartitems"][$i]["eqtabs"], "qty" => $theSession["cartitems"][$i]["qty"], "itemid" => $theSession["cartitems"][$i]["itemid"]);
        }

        $mydata[] = array("id" => $eqipid, "name" => $eqname, "eqtype" => $eqtype, "price" => $price, "url" => $url, "eqtabs" => $tabs, "qty" => $qty, "itemid" => $itemid);

        $eq = json_encode(array("shop_location" => $theSession["shop_location"], "cartitems" => $mydata, "discount_code" => "", "shipping_type" => "", "shipping_token" => "", "shipping_price" => ""));
        $chk = $data->query("SELECT setting_value FROM shop_settings WHERE setting_name = 'location_select'");
        $chk1 = $chk->fetch_array();
        if ($chk1["setting_value"] == 'true') {
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
        } else {
            $chk = $data->query("SELECT setting_value FROM shop_settings WHERE setting_name = 'sell_per_qty'");
            $chk1 = $chk->fetch_array();

            if ($chk1["setting_value"] == 'true') {
                $aa = $data->query("SELECT stock FROM equipment_location_manager WHERE location_id = '$locasel' AND equip_id = '$eqipid' AND equip_line = '$tabs'");
                $bb = $aa->fetch_array();
                if ($bb["stock"] >= $qty) {
                    setcookie("savedData", $eq, time() + (86400 * 30), "/", false);
                    $retMess = array('response' => 'good', 'message' => 'Added to cart.');
                } else {
                    $retMess = array('response' => 'bad', 'message' => 'Not enough stock.');
                }
            } else {
                setcookie("savedData", $eq, time() + (86400 * 30), "/", false);
                $retMess = array('response' => 'good', 'message' => 'Added to cart.');
            }
        }



        $html .= '<input type="hidden" id="cart_total" name="cart_total" value="' . number_format($total, 2) . '">';
        echo json_encode($retMess);
    } else {
        //$mydata[] = array("shop_location"=>$locasel);
        $mydata[] = array("id" => $eqipid, "name" => $eqname, "eqtype" => $eqtype, "price" => $price, "url" => $url, "eqtabs" => $tabs, "qty" => $qty, "itemid" => $itemid);

        $eq = json_encode(array("shop_location" => $locasel, "cartitems" => $mydata, "discount_code" => "", "shipping_type" => "", "shipping_token" => "", "shipping_price" => ""));

        //do some secondary stock checks//
        $chk = $data->query("SELECT setting_value FROM shop_settings WHERE setting_name = 'location_select'");
        $chk1 = $chk->fetch_array();
        if ($chk1["setting_value"] == 'true') {
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
        } else {

            $chk = $data->query("SELECT setting_value FROM shop_settings WHERE setting_name = 'sell_per_qty'");
            $chk1 = $chk->fetch_array();

            if ($chk1["setting_value"] == 'true') {
                $aa = $data->query("SELECT stock FROM equipment_location_manager WHERE location_id = '$locasel' AND equip_id = '$eqipid' AND equip_line = '$tabs'");
                $bb = $aa->fetch_array();
                if ($bb["stock"] >= $qty) {
                    setcookie("savedData", $eq, time() + (86400 * 30), "/", false);
                    $retMess = array('response' => 'good', 'message' => 'Added to cart.');
                } else {
                    $retMess = array('response' => 'bad', 'message' => 'Not enough stock.');
                }
            } else {
                setcookie("savedData", $eq, time() + (86400 * 30), "/", false);
                $retMess = array('response' => 'good', 'message' => 'Added to cart.');
            }
        }

        $html .= '<input type="hidden" id="cart_total" name="cart_total" value="' . number_format($price, 2) . '">';

        echo json_encode($retMess);
    }
}

if ($act == 'getmini') {
    include('config.php');
    //session_start();

    $cartQty = 0;
    $ret = $_COOKIES['cartData'];
    $cartRaw = json_decode($_COOKIE['cartData'], true);
    $cartItems = $cartRaw['cartItems'];

    //$html .= '<div class="row cart-detail"><div class="col-lg-4 col-sm-4 col-4 cart-detail-img"><p>' . var_dump($ret) . '</p></div></div>';


    if (!empty($cartItems)) {
        $priceOut = 0;
        $qtyOut = 0;
        for ($i = 0; $i < count($cartItems); $i++) {
            $itemId = $cartItems[$i]["id"];
            $itemName = $cartItems[$i]["name"];
            $itemsTable = $cartItems[$i]["eq_type"];
            $itemQty = $cartItems[$i]["qty"];
            $itemUrl = $cartItems[$i]["url"];
            $itemPrice = $cartItems[$i]["price"] * $itemQty;

            if (strlen($itemName) > 40) {
                $itemName = substr($itemName, 0, 40) . '...';
            } else {
                $itemName = $itemName;
            }

            // //get image//
            // $a = $data->query("SELECT eq_image FROM $itemsTable WHERE id = '$itemId'");
            // $b = $a->fetch_array();


            // if ($b["eq_image"] != null || $b["eq_image"] != '[]') {
            //     $itemsImagepre = json_decode($b["eq_image"], true);
            //     $itemsImage = $itemsImagepre[0];
            // }


            $cartThings .= '<div class="row cart-detail"><div class="col-lg-4 col-sm-4 col-4 cart-detail-img"><img src="img/no-img.png"></div><div class="col-lg-8 col-sm-8 col-8 cart-detail-product"><p>' . str_replace('_', ' ', $itemName) . '</p><span class="price text-info"> $' . $itemPrice . '</span> <span class="count"> Qty:' . $itemQty . '</span></div></div>';

            $priceOut += $itemPrice;
            $qtyOut += $itemQty;
        }

        $html .= '<div class="row total-header-section"><div class="col-lg-6 col-sm-6 col-6"><i class="fa fa-shopping-cart" aria-hidden="true"></i> <span class="badge badge-pill badge-danger">' . $qtyOut . '</span></div><div class="col-lg-6 col-sm-6 col-6 total-section text-right"><p>Total: <span class="text-info">$' . number_format($priceOut, 2) . '</span></p></div></div>';
        $html .= $cartThings;

        $html .= '<div class="row"><div class="col-lg-12 col-sm-12 col-12 text-center"><a href="checkout" class="btn btn-primary btn-block">Checkout</a></div></div>';
    } else {
    $html .= '<div class="row total-header-section"><div class="col-lg-6 col-sm-6 col-6"><i class="fa fa-shopping-cart" aria-hidden="true"></i> <span class="badge badge-pill badge-danger">' . count($cartItems) . '</span></div><div class="col-lg-6 col-sm-6 col-6 total-section text-right"><p>Total: <span class="text-info">$' . number_format($priceOut, 2) . '</span></p></div></div>';
    $html .= '<div style="color: #666868; font-style: italic; padding-top:10px"><strong>NOTHING IN CART.</strong></div>';
    }
    echo json_encode(array('itemCount' => $qtyOut, 'cart' => $html));
}

if ($act == 'getwholecart') {
    include('config.php');
    session_start();

    $cartQty = 0;
    $cartRaw = $_COOKIE["savedData"];
    $cartItems_or = json_decode($_COOKIE["savedData"], true);
    $cartItems = $cartItems_or["cartitems"];
    //var_dump($cartItems_or);
    $html = var_dump(json_decode($_COOKIE['cartItems']))

//     ///GET TOTAL QTY IN CART//
//     for ($i = 0; $i < count($cartItems); $i++) {
//         $theQty = $cartItems[$i]["qty"];
//         $cartQty += $theQty;
//     }


//     $html .= '<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
// <div class="container proxima-nova">
//     <div class="wrapper wrapper-content">
//         <div class="row">
//             <div class="col-md-8">
//                 <div class="ibox">
//                     <div class="ibox-title">
//                         <p class="pull-right">( <strong style="color: #367C2B;">' . $cartQty . '</strong> ) items</p>
//                         <h3 class="proxima-nova"><i><b>Items in your cart</b></i></h3>
//                     </div>';



//     if (count($cartItems) > 0) {

//         for ($i = 0; $i < count($cartItems); $i++) {
//             $itemPrice = $cartItems[$i]["price"];
//             $thePurchaseIn .= '' . ucwords($cartItems[$i]["eqtype"]) . ' - ' . $cartItems[$i]["name"] . ' ';
//             $countOut += $itemPrice;
//         }

//         // get tax rate //
//         $taxset = $data->query("SELECT setting_value FROM shop_settings WHERE setting_name = 'do_tax_stuff'");
//         $taxGet = $taxset->fetch_array();
//         if ($taxGet["setting_value"] == 'true') {
//             $location = $cartItems["shop_location"];
//             $tax = $data->query("SELECT tax_rate FROM equipment_tax WHERE relid = '$location' AND active = 'true'") or die($data->error);
//             $taxOut = $tax->fetch_array();

//             if ($taxOut["tax_rate"] != '') {
//                 $taxRate = $taxOut["tax_rate"];
//             } else {
//                 $taxRate = '0';
//             }
//         } else {
//             $taxRate = 0;
//         }

//         $countOut = 0;
//         $taxrate = $taxRate;
//         $weightOut = 0;

//         for ($i = 0; $i < count($cartItems); $i++) {
//             $itemPrice = $cartItems[$i]["price"];


//             ///APPLIED PATCH FOR PRICE ADJUSTMENT FOR SHIPPING AND STUFF///

//             $eqipId = $cartItems[$i]["id"];
//             $eqipTab = $cartItems[$i]["eqtabs"];

//             $x = $data->query("SELECT msrp, discount,eq_image, description, weight FROM $eqipTab WHERE id = '$eqipId'") or die("THIS IS ONE " . $data->error);
//             $v = $x->fetch_array();

//             $image1 = json_decode($v["eq_image"], true);
//             $image = $image1[0];


//             $price = $v["msrp"] * $cartItems[$i]["qty"];
//             $weight = $v["weight"];

//             if (strlen($v["description"]) > 140) {
//                 $descript = substr($v["description"], 0, 140) . ' ...';
//             } else {
//                 if ($v["description"] != null) {
//                     $descript = $v["description"];
//                 }
//             }


//             $thePurchasesd .= '<tr><td>' . $cartItems[$i]["name"] . '</td><td>$' . number_format($v["msrp"], 2) . '</td><td><input class="form-control" style="max-width: 55%" type="text" name="itmqty_' . $cartItems[$i]["itemid"] . '" id="itmqty_' . $cartItems[$i]["itemid"] . '" value="' . $cartItems[$i]["qty"] . '"> <a href="javascript:void(0)" class="updateval" data-itemid="' . $cartItems[$i]["itemid"] . '" data-itemname="' . $cartItems[$i]["name"] . '" data-realid="' . $cartItems[$i]["id"] . '" data-eqtabs="' . $cartItems[$i]["eqtabs"] . '">Update</a></td><td>$' . number_format($price, 2) . '</td><td><a class="removit" href="javascript:void(0)" onclick="removeSavedCart(' . $cartItems[$i]["itemid"] . ',' . $cartItems[$i]["eqtabs"] . ')">remove</a></td></tr>';

//             $thePurchase .= '<div class="ibox-content">
//                         <div class="table-responsive">
//                             <table class="table shoping-cart-table">
//                                 <tbody>
//                                 <tr>
//                                     <td width="100">
//                                         <div class="cart-product-imitation"><img style="width: 100%" src="img/custom/' . $image . '">
//                                         </div>
//                                     </td>
//                                     <td class="desc" style="width:50%">
//                                         <h3 style="margin: 0">
//                                             <a href="' . $cartItems[$i]["url"] . '" class="text-navy">
//                                                 ' . str_replace('_', ' ', $cartItems[$i]["name"]) . '
//                                             </a>
//                                         </h3>
//                                         <small style="font-style: italic">$' . number_format($v["msrp"], 2) . ' ea</small><br>
//                                         <p class="small" style="margin-top: 0px">
//                                             <i>' . $descript . '</i>
//                                         </p>
                                        

//                                         <div class="m-t-sm">
//                                             <a class="removit text-muted" href="javascript:void(0)" onclick="removeSavedCart(\'' . $cartItems[$i]["itemid"] . '\',\'' . $cartItems[$i]["eqtabs"] . '\')"><i class="fa fa-trash"></i> Remove item</a>
//                                         </div>
//                                     </td>

                                   
//                                     <td width="">
//                                     <div class="input-group mb-3">
//   <input type="number" style="border-radius: 0" class="form-control" name="itmqty_' . $cartItems[$i]["itemid"] . '" id="itmqty_' . $cartItems[$i]["itemid"] . '" value="' . $cartItems[$i]["qty"] . '">
//   <div class="input-group-append">
//     <button style="border-radius: 0" class="btn btn-outline-secondary updateval" data-itemid="' . $cartItems[$i]["itemid"] . '" data-itemname="' . $cartItems[$i]["name"] . '" data-realid="' . $cartItems[$i]["id"] . '" data-eqtabs="' . $cartItems[$i]["eqtabs"] . '" type="button"><i class="fa fa-refresh" aria-hidden="true"></i></button>
//   </div>
// </div><td>
                                   
//                                 </td>
                                        
//                                     </td>
//                                     <td>
//                                         <h3 style="display: block; width:100px">
//                                             $' . number_format($price, 2) . '
//                                         </h3>
//                                     </td>
//                                 </tr>
//                                 </tbody>
//                             </table>
//                         </div>

//                     </div>';

//             $countOut += str_replace(',', '', $price);

//             $weightOut += $weight;
//         }


//         $tax = round((($countOut * $taxrate)), 2);
//         // $countOut = $countOut + $tax;

//         $totalWeight = $weightOut;

//         $html .= $thePurchase;
//     } else {
//         $html .= '<div class="jumbotron"><b>Whoops!</b><br><p>You have no items in your cart.</p></div>';
//         unset($_SESSION["customer_shipping_info"]);
//         unset($_COOKIE["savedData"]);
//         setcookie("savedData", "", time() - (60 * 60 * 24), "/");
//     }

//     $html .= '<div class="ibox-content">';


//     if (!empty($cartItems)) {
//         $html .= ' <button class="btn btn-green pull-right thecheckout"><i class="fa fa fa-shopping-cart"></i> Checkout </button>';
//     }
//     $html .= ' <button class="btn btn-white" ><i class="fa fa-arrow-left"></i> Continue shopping</button>

//                     </div>
//                 </div>

//             </div>
//             <div class="col-md-1"></div>
//             <div class="col-md-3">
//                 <div class="ibox">
//                     <div class="ibox-title">
//                         <h5>Cart Summary</h5>
//                     </div>
//                     <div class="ibox-content">
//                     <span>
//                         Sub Total
//                     </span>
//                         <h2 class="font-bold">
//                             $' . number_format($countOut, 2) . '
//                         </h2>

//                         <hr>

                        
//                     </div>
//                 </div>



// <!--                <div class="ibox">-->
// <!--                    <div class="ibox-content">-->
// <!---->
// <!--                        <p class="font-bold">-->
// <!--                            Other products you may be interested-->
// <!--                        </p>-->
// <!--                        <hr>-->
// <!--                        <div>-->
// <!--                            <a href="#" class="product-name"> Product 1</a>-->
// <!--                            <div class="small m-t-xs">-->
// <!--                                Many desktop publishing packages and web page editors now.-->
// <!--                            </div>-->
// <!--                            <div class="m-t text-righ">-->
// <!---->
// <!--                                <a href="#" class="btn btn-xs btn-outline btn-primary">Info <i class="fa fa-long-arrow-right"></i> </a>-->
// <!--                            </div>-->
// <!--                        </div>-->
// <!--                        <hr>-->
// <!--                        <div>-->
// <!--                            <a href="#" class="product-name"> Product 2</a>-->
// <!--                            <div class="small m-t-xs">-->
// <!--                                Many desktop publishing packages and web page editors now.-->
// <!--                            </div>-->
// <!--                            <div class="m-t text-righ">-->
// <!---->
// <!--                                <a href="#" class="btn btn-xs btn-outline btn-primary">Info <i class="fa fa-long-arrow-right"></i> </a>-->
// <!--                            </div>-->
// <!--                        </div>-->
// <!--                    </div>-->
// <!--                </div>-->
//             </div>
//         </div>
//     </div>
// </div>';

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
    //var_dump($cartItems);

    ///GET TOTAL QTY IN CART//
    for ($i = 0; $i < count($cartItems); $i++) {
        $theQty = $cartItems[$i]["qty"];
        $cartQty += $theQty;
    }


    $html .= '<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
<div class="container">
    <div class="wrapper wrapper-content">
    
        <div class="row">
        
            <div class="col-md-7"><form name="billing_details" id="billing_details" method="post" action="">
                <div class="ibox">
                    <div class="ibox-title">
                        <h5>Shipping Details</h5>
                    </div>';


    $html .= '<div class="ibox-content">';


    $html .= '<div class="row">';
    $html .= '<div class="col-md-6"><label>First Name</label><input type="text" class="form-control" name="shipping_first_name" id="shipping_first_name" required="required" autocomplete="none" value="' . $shipping_first_name . '"></div>';
    $html .= '<div class="col-md-6"><label>Last Name</label><input type="text" class="form-control" name="shipping_last_name" name="shipping_last_name" required="required" autocomplete="none" value="' . $shipping_last_name . '"></div>';
    $html .= '</div>';

    $html .= '<div class="row" style="margin-top: 5px">';
    $html .= '<div class="col-md-12"><label>Address</label><input type="text" class="form-control" name="shipping_address" id="shipping_address" required="required" autocomplete="none" value="' . $shipping_address . '"></div>';
    $html .= '</div>';

    $html .= '<div class="row" style="margin-top: 5px">';
    $html .= '<div class="col-md-12"><label>Apt #, Suite, Floor (Optional)</label><input type="text" class="form-control" name="shipping_option_address" id="shipping_option_address" autocomplete="none" value="' . $shipping_option_address . '"></div>';
    $html .= '</div>';

    $html .= '<div class="row" style="margin-top: 5px">';
    $html .= '<div class="col-md-6"><label>City</label><input type="text" class="form-control" name="shipping_city" name="shipping_city" required="required" autocomplete="none" value="' . $shipping_city . '"></div>';

    $html .= '<div class="col-md-4"><label>State</label>';

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

    $html .= '<div class="col-md-2"><label>Zip</label><input class="form-control" type="text" name="shipping_zip" id="shipping_zip" required="required" autocomplete="none" value="' . $shipping_zip . '"></div>';

    $html .= '</div>';
    $html .= '</div>';

    $html .= '</div>';

    $html .= '<div class="ibox">';

    $html .= '<div class="ibox-title"><h5>Contact Details</h5></div>';

    $html .= '<div class="ibox-content">';

    $html .= '<div class="row">';
    $html .= '<div class="col-md-12"><label>Email Address</label><input type="email" class="form-control" name="shipping_email" id="shipping_option_email" required="required" autocomplete="none" value="' . $shipping_email . '"></div>';
    $html .= '</div>';
    $html .= '<div class="row" style="margin-top: 5px">';
    $html .= '<div class="col-md-12"><label>Phone Number</label><input type="text" class="form-control" name="shipping_phone" id="shipping_option_phone" required="required" autocomplete="none" value="' . $shipping_phone . '"></div>';
    $html .= '</div>';





    $html .= '
                </div>
                </div></form>
            </div>
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
                            <thead><tr><td><b>Item</b></td><td style="width: 50%"><b>Qty</b></td><td style="width: 50%"><b>Price</b></td></tr></thead>
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

        $x = $data->query("SELECT msrp, discount, description FROM $eqipTab WHERE id = '$eqipId'") or die("THIS IS ONE " . $data->error);
        $v = $x->fetch_array();

        $price = $v["msrp"] * $cartItems[$i]["qty"];
        $weight = $v["weight"];

        if (strlen($v["description"]) > 140) {
            $descript = substr($v["description"], 0, 140) . ' ...';
        } else {
            if ($v["description"] != null) {
                $descript = $v["description"];
            }
        }


        $thePurchasesds .= '<tr><td>' . $cartItems[$i]["name"] . '</td><td>$' . number_format($v["msrp"], 2) . '</td><td>' . $cartItems[$i]["qty"] . '<input class="form-control" style="max-width: 55%" type="text" name="itmqty_' . $cartItems[$i]["itemid"] . '" id="itmqty_' . $cartItems[$i]["itemid"] . '" value="' . $cartItems[$i]["qty"] . '"> <a href="javascript:void(0)" class="updateval" data-itemid="' . $cartItems[$i]["itemid"] . '" data-itemname="' . $cartItems[$i]["name"] . '" data-realid="' . $cartItems[$i]["id"] . '" data-eqtabs="' . $cartItems[$i]["eqtabs"] . '">Update</a></td><td>$' . number_format($price, 2) . '</td><td><a class="removit" href="javascript:void(0)" onclick="removeSavedCart(' . $cartItems[$i]["itemid"] . ',' . $cartItems[$i]["eqtabs"] . ')">remove</a></td></tr>';

        $thePurchase .= '
                               
                                <tr ' . $borderSty . '>
                                    <td class="desc" style="width:50%">
                                        <h5 style="margin: 0">
                                            <a href="' . $cartItems[$i]["url"] . '" class="text-navy-small" >
                                                ' . str_replace('_', ' ', $cartItems[$i]["name"]) . '
                                            </a>
                                        </h5>
                                        <small style="font-style: italic">$' . number_format($v["msrp"], 2) . ' ea</small><br>
                                       
                                    </td>

                                   
                                    <td width="">
                                    ' . $cartItems[$i]["qty"] . '
                                   
                                </td>
                                        
                                   
                                    <td>
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

        $html .= '<table class="table shoping-cart-table"><tbody><tr><td style="padding: 10px">Applied Discount:</td><td style="padding: 10px"><small>' . $b["percentage_off"] . '% Off</small><br>-$' . number_format($percent, 2) . '</td></tr></tbody></table>';
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
                            <a href="checkout2" class="btn-default btn-sm"><i class="fa fa-arrow-left"></i>  Back to Cart</a>
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
        $shipping_phone = '123-456-7891';
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
            $shipping_phone = '222-333-4444';
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
<div class="container">
    <div class="wrapper wrapper-content">
    
        <div class="row">
        
            <div class="col-md-7">';

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
                    <div class="ibox-title">
                        <h5>Shipping Details</h5>
                    </div>';


    $html .= '<div class="ibox-content">';

    $html .= '<div class="row">';
    $html .= '<div class="col-md-12" style="font-style: italic">';
    $html .= $shipping_first_name . ' ' . $shipping_last_name . '<br>';
    $html .= $shipping_address . ' ' . $shipping_option_address . '<br>';
    $html .= $shipping_city . ' ' . $shipping_state . ', ' . $shipping_zip . '<br>';
    $html .= '</div>';
    $html .= '</div>';

    $html .= '</div>';




    $html .= '<div class="ibox">';

    $html .= '<div class="ibox-title"><h5>Contact Details</h5></div>';

    $html .= '<div class="ibox-content">';

    $html .= '<div class="row">';
    $html .= '<div class="col-md-12" style="font-style: italic">em. ' . $shipping_email . '</div>';
    $html .= '</div>';
    $html .= '<div class="row" style="margin-top: 5px">';
    $html .= '<div class="col-md-12" style="font-style: italic">ph. ' . $shipping_phone . '</div>';
    $html .= '<div class="col-md-12" style="margin-top: 15px"><a href="">Edit Details</a> </div>';
    $html .= '</div>';
    $html .= '</div>';





    $html .= '
                </div>
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


    $thePurchase .= '<div class="ibox-content">
                        <div class="table-responsive">
                            <table class="table shoping-cart-table">
                            <thead><tr><td><b>Item</b></td><td style="width: 50%"><b>Qty</b></td><td style="width: 50%"><b>Price</b></td></tr></thead>
                                <tbody>';

    $weightOut = 0;
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

        $x = $data->query("SELECT msrp, discount, description, weight, ship_type, dimentions  FROM $eqipTab WHERE id = '$eqipId'") or die("THIS IS ONE " . $data->error);
        $v = $x->fetch_array();

        $price = $v["msrp"] * $cartItems[$i]["qty"];
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


        $thePurchasesds .= '<tr><td>' . $cartItems[$i]["name"] . '</td><td>$' . number_format($v["msrp"], 2) . '</td><td>' . $cartItems[$i]["qty"] . '<input class="form-control" style="max-width: 55%" type="text" name="itmqty_' . $cartItems[$i]["itemid"] . '" id="itmqty_' . $cartItems[$i]["itemid"] . '" value="' . $cartItems[$i]["qty"] . '"> <a href="javascript:void(0)" class="updateval" data-itemid="' . $cartItems[$i]["itemid"] . '" data-itemname="' . $cartItems[$i]["name"] . '" data-realid="' . $cartItems[$i]["id"] . '" data-eqtabs="' . $cartItems[$i]["eqtabs"] . '">Update</a></td><td>$' . number_format($price, 2) . '</td><td><a class="removit" href="javascript:void(0)" onclick="removeSavedCart(' . $cartItems[$i]["itemid"] . ',' . $cartItems[$i]["eqtabs"] . ')">remove</a></td></tr>';

        $thePurchase .= '
                               
                                <tr ' . $borderSty . '>
                                    <td class="desc" style="width:50%">
                                        <h5 style="margin: 0">
                                            <a href="' . $cartItems[$i]["url"] . '" class="text-navy-small" >
                                                ' . str_replace('_', ' ', $cartItems[$i]["name"]) . '
                                            </a>
                                        </h5>
                                        <small style="font-style: italic">$' . number_format($v["msrp"], 2) . ' ea</small><br>
                                       
                                    </td>

                                   
                                    <td width="">
                                    ' . $cartItems[$i]["qty"] . '
                                   
                                </td>
                                        
                                   
                                    <td>
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

        $discountGivin = '<table class="table shoping-cart-table couponars"><tbody><tr><td style="padding: 10px">Applied Discount:</td><td style="padding: 10px"><small>' . $b["percentage_off"] . '% Off</small><br>-$' . number_format($percent, 2) . '</td></tr></tbody></table>';
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
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.zip-tax.com/request/v40?key=hvuGeQxLR5Y4ECyt&postalcode=' . $shipping_zip . '',
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
        for ($i = 0; $i < count($cartItems); $i++) {
            $mydata[] = array("id" => $cartItems[$i]["id"], "name" => $cartItems[$i]["name"], "eqtype" => $cartItems[$i]["eqtype"], "price" => $cartItems[$i]["price"], "url" => $cartItems[$i]["url"], "eqtabs" => $cartItems[$i]["eqtabs"], "qty" => $cartItems[$i]["qty"], "itemid" => $cartItems[$i]["itemid"]);
            $price = $cartItems[$i]["price"] * $cartItems[$i]["qty"];
            $countOut += str_replace(',', '', $price);
        }

        if ($percent != null) {
            $countOut = $countOut - $percent;
        };


        $tax = round((($countOut * $taxRate)), 2);
        $eq = json_encode(array("shop_location" => $shopLocation, "cartitems" => $mydata, "discount_code" => $code, "shipping_type" => '', "shipping_token" => '', "shipping_price" => '', "applied_tax" => $tax));
        unset($_COOKIE["savedData"]);
        setcookie("savedData", $eq, time() + (86400 * 30), "/", false);

        $html .= '<table class="table shoping-cart-table"><tbody><tr><td style="padding: 10px">Tax:</td><td class="tax_inplace" style="padding: 10px">$' . number_format($tax, 2) . '</td></tr></tbody></table>';
        $countOut = $countOut + $tax;
    } else {
        $countOut = $countOut;
    }

    $html .= '</div>';

    $html .= '<div class="ibox-content" style="text-align: right;">';
    $html .= '<div style="text-align: right; font-weight: bold">Select Pickup / Shipping Method 4<br><br></div>';



    require_once('vendor/shippo/lib/Shippo.php');

    Shippo::setApiKey("shippo_test_3b57b47f8854fd4d5c35da13b2d4d2ad16633110");

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
    $to_address = array(
        'name' => $shipping_first_name . ' ' . $shipping_last_name,
        'company' => '',
        'street1' => $shipping_address,
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

    $dimentions =  $maxLength . 'X' . $maxwidth . 'X' . $maxheight;
    echo $dimentions . ' - ' . $weightOut;

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

    $html .= '<form name="shipssels" id="shipssels" method="post" action=""><select class="form-control" name="shipping_select" id="shipping_select" required="required"><option value="">Select Option</option> ';
    $chk = $data->query("SELECT setting_value FROM shop_settings WHERE setting_name = 'location_select'");
    $chk1 = $chk->fetch_array();
    if ($chk1["setting_value"] == 'true') {
        $html .= '<option disabled>----------</option>';
        $html .= '<option value="pickup" data-amount="pickup">Pickup From Store Location</option>';
        $html .= '<option disabled>----------</option>';
    }
    $html .= $sippingOptions;
    $html .= '</select></form>';




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

if ($act == 'submitreview') {
    include('siteFunctions.php');
    $a = new site();
    $a->processReview($_POST);
}

if ($act == 'destroycart') {
    echo "We are going";
    include('siteFunctions.php');
    $a = new site();
    session_start();
    setcookie("savedData", '', time() - (86400 * 30), "/", false);
    $results = $a->destroyCart();
    echo "This is " . $results;
}

if ($act == 'eventtrak') {
    include('siteFunctions.php');
    $a = new site();
    $a->saveCaffEvent($_REQUEST["target"], $_REQUEST["page"]);
}
