<?php
include('cart/cart.php');

$act = $_REQUEST["action"];

if ($act == 'quickview') {

    include('../../config.php');

    $prodId = $_REQUEST['equipid'];
    $equiptype = $_REQUEST["equiptype"];
    if ($prodId != null) {
        if ($equiptype == 'deere') {
            $a = $data->query("SELECT * FROM deere_equipment WHERE id = '$prodId'");
        }
        if ($equiptype == 'honda') {
            $a = $data->query("SELECT * FROM honda_equipment WHERE id = '$prodId'");
        }

        if ($equiptype == 'stihl') {
            $a = $data->query("SELECT * FROM stihl_equipment WHERE id = '$prodId'");
        }
        if ($equiptype == 'kuhn') {
            $a = $data->query("SELECT * FROM custom_equipment WHERE id = '$prodId'");
        }
        if ($equiptype == 'woods') {
            $a = $data->query("SELECT * FROM woods_equipment WHERE id = '$prodId'");
        }
        if ($equiptype == 'custom') {
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


        if ($equiptype == 'deere') {
            $image = 'img/' . $obj["eq_image"];
            $price = $price;
        }

        if ($equiptype == 'honda') {
            $imgas = json_decode($obj["eq_image"], true);
            $image = 'img/Honda/' . $imgas[0];
            $price = number_format(trim($price, " \t\n\r\0\x0B\xC2\xA0"));
        }

        if ($equiptype == 'stihl') {
            $imgas = json_decode($obj["eq_image"], true);
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
            $priceOut = '<span>STARTING AT:<br><strong style="font-size: 24px">$' . $price . '</strong></span><br>';
        } else {
            $priceOut = '';
        }

        $html .= '<div class="col-md-4"><h1>' . str_replace('_', ' ', $title) . '<br><span class="sub-h1">' . $outTitleSub . '</span></h1>' . $bullethtml . '<br>' . $priceOut . '<br>' . $optLinksOut . '<br><br><a href="' . $_POST["linkset"] . '/' . $title . '" class="btn btn-default">View Details Page</a></div>';

        $html .= '<div class="clearfix"></div><br>';


        $html = '<div class="">' . $html . '</div>';

        $html .= '</div>';

        echo $html;
    } else {

        echo 'No Products Found';
    }
}

if ($act == 'removecartitem') {
    $id = $_POST['id'];

    if ($cart->RemoveCartItem($id)) {
        echo "SUCCESS";
    } else {
        echo "FAILED";
    }
}

if ($act == 'updateqty') {
    $id = $_POST['id'];
    $uniqId = $_POST['uniqId'];
    $qty = $_POST['qty'];
    $name = $_POST['name'];
    $price = $_POST['price'];
    $currentQty = -1;
    $newItemTotal = 0;
    $newCartTotal = 0;

    $returnArray = $cart->SetItemQty($uniqId, $qty);
    $newItemTotal = $returnArray['itemTotal'];
    $newCartTotal = $returnArray['cartTotal'];

    if ($newItemTotal != -1) {
        $currentQty = $qty;
    }

    $json = json_encode(array("response" => "good", "qty" => $currentQty, "itemTotal" => number_format($newItemTotal, 2, '.', ','), "cartTotal" => number_format($newCartTotal, 2, '.', ',')), true);
    echo $json;
}

if ($act == 'addtocart') {
    $total = 0;
    session_start();
    $eqipid = $_POST["id"];
    $eqname = $_POST["title"];
    $price = $_POST["price"];
    $url = $_POST["url"];
    $shipType = $_POST["shipType"];
    $cart->AddNewCartItem($eqipid, $eqname, $price, $url, 1, $shipType);
    //$cart->GetCartTotalNoTax(json_decode($_COOKIE['cartData'], true));
    $json = json_encode(array("response" => "good"), true);
    echo $json;

    //return true;

    // $chk = $data->query("SELECT setting_value FROM shop_settings WHERE setting_name = 'location_select'");
    // $chk1 = $chk->fetch_array();
    // if ($chk1["setting_value"] == 'true') {
    //     $locasel = $_POST["locasel"];
    // } else {
    //     // attempt to get default location//
    //     $loc = $data->query("SELECT setting_value FROM shop_settings WHERE setting_name = 'default_ship_location'");
    //     $defloc = $loc->fetch_array();
    //     $locasel = $defloc["setting_value"];
    // }

    // $theSession = $_COOKIE["savedData"];


    // if (isset($theSession)) {
    //     $theSession = json_decode($theSession, true);
    //     for ($i = 0; $i < count($theSession["cartitems"]); $i++) {
    //         $mydata[] = array("id" => $theSession["cartitems"][$i]["id"], "name" => $theSession["cartitems"][$i]["name"], "eqtype" => $theSession["cartitems"][$i]["eqtype"], "price" => $theSession["cartitems"][$i]["price"], "url" => $theSession["cartitems"][$i]["url"], "eqtabs" => $theSession["cartitems"][$i]["eqtabs"], "qty" => $theSession["cartitems"][$i]["qty"], "itemid" => $theSession["cartitems"][$i]["itemid"]);
    //     }

    //     $mydata[] = array("id" => $eqipid, "name" => $eqname, "eqtype" => $eqtype, "price" => $price, "url" => $url, "eqtabs" => $tabs, "qty" => $qty, "itemid" => $itemid);

    //     $eq = json_encode(array("shop_location" => $theSession["shop_location"], "cartitems" => $mydata, "discount_code" => "", "shipping_type" => "", "shipping_token" => "", "shipping_price" => ""));
    //     $chk = $data->query("SELECT setting_value FROM shop_settings WHERE setting_name = 'location_select'");
    //     $chk1 = $chk->fetch_array();
    //     if ($chk1["setting_value"] == 'true') {
    //         $x = $data->query("SELECT stock FROM equipment_location_manager WHERE equip_id = '$eqipid' AND equip_line = '$tabs' AND location_id = '$locasel'");
    //         if ($x->num_rows > 0) {
    //             $v = $x->fetch_array();
    //             if ($qty <= $v["stock"]) {
    //                 setcookie("savedData", $eq, time() + (86400 * 30), "/", false);
    //                 $retMess = array('response' => 'good', 'message' => 'Added to cart.');
    //             } else {
    //                 $retMess = array('response' => 'bad', 'message' => 'Out of stock at your selected location. Please select another location.');
    //             }
    //         } else {
    //             $retMess = array('response' => 'bad', 'message' => 'Out of stock at your selected location. Please select another location.');
    //         }
    //     } else {
    //         $chk = $data->query("SELECT setting_value FROM shop_settings WHERE setting_name = 'sell_per_qty'");
    //         $chk1 = $chk->fetch_array();

    //         if ($chk1["setting_value"] == 'true') {
    //             $aa = $data->query("SELECT stock FROM equipment_location_manager WHERE location_id = '$locasel' AND equip_id = '$eqipid' AND equip_line = '$tabs'");
    //             $bb = $aa->fetch_array();
    //             if ($bb["stock"] >= $qty) {
    //                 setcookie("savedData", $eq, time() + (86400 * 30), "/", false);
    //                 $retMess = array('response' => 'good', 'message' => 'Added to cart.');
    //             } else {
    //                 $retMess = array('response' => 'bad', 'message' => 'Not enough stock.');
    //             }
    //         } else {
    //             setcookie("savedData", $eq, time() + (86400 * 30), "/", false);
    //             $retMess = array('response' => 'good', 'message' => 'Added to cart.');
    //         }
    //     }



    //     $html .= '<input type="hidden" id="cart_total" name="cart_total" value="' . number_format($total, 2) . '">';
    //     echo json_encode($retMess);
    // } else {
    //     //$mydata[] = array("shop_location"=>$locasel);
    //     $mydata[] = array("id" => $eqipid, "name" => $eqname, "eqtype" => $eqtype, "price" => $price, "url" => $url, "eqtabs" => $tabs, "qty" => $qty, "itemid" => $itemid);

    //     $eq = json_encode(array("shop_location" => $locasel, "cartitems" => $mydata, "discount_code" => "", "shipping_type" => "", "shipping_token" => "", "shipping_price" => ""));

    //     //do some secondary stock checks//
    //     $chk = $data->query("SELECT setting_value FROM shop_settings WHERE setting_name = 'location_select'");
    //     $chk1 = $chk->fetch_array();
    //     if ($chk1["setting_value"] == 'true') {
    //         $x = $data->query("SELECT stock FROM equipment_location_manager WHERE equip_id = '$eqipid' AND equip_line = '$tabs' AND location_id = '$locasel'");
    //         if ($x->num_rows > 0) {
    //             $v = $x->fetch_array();
    //             if ($qty <= $v["stock"]) {
    //                 setcookie("savedData", $eq, time() + (86400 * 30), "/", false);
    //                 $retMess = array('response' => 'good', 'message' => 'Added to cart.');
    //             } else {
    //                 $retMess = array('response' => 'bad', 'message' => 'Out of stock at your selected location. Please select another location.');
    //             }
    //         } else {
    //             $retMess = array('response' => 'bad', 'message' => 'Out of stock at your selected location. Please select another location.');
    //         }
    //     } else {

    //         $chk = $data->query("SELECT setting_value FROM shop_settings WHERE setting_name = 'sell_per_qty'");
    //         $chk1 = $chk->fetch_array();

    //         if ($chk1["setting_value"] == 'true') {
    //             $aa = $data->query("SELECT stock FROM equipment_location_manager WHERE location_id = '$locasel' AND equip_id = '$eqipid' AND equip_line = '$tabs'");
    //             $bb = $aa->fetch_array();
    //             if ($bb["stock"] >= $qty) {
    //                 setcookie("savedData", $eq, time() + (86400 * 30), "/", false);
    //                 $retMess = array('response' => 'good', 'message' => 'Added to cart.');
    //             } else {
    //                 $retMess = array('response' => 'bad', 'message' => 'Not enough stock.');
    //             }
    //         } else {
    //             setcookie("savedData", $eq, time() + (86400 * 30), "/", false);
    //             $retMess = array('response' => 'good', 'message' => 'Added to cart.');
    //         }
    //     }

    //     $html .= '<input type="hidden" id="cart_total" name="cart_total" value="' . number_format($price, 2) . '">';

    //     echo json_encode($retMess);
    // }
}

if ($act == 'elavonpay') {
    include('payments/stripe-handler.php');
    $payment_processor = new StripeHandler();
    //echo $payment_processor->CreateStripeCustomer(0);
}

if ($act == 'complete_elavon_purchase') {
    include('payments/elevon-handler.php');
    $elavon = new ElavonHandler();
    echo $elavon->CompleteElavonPurchase();
}

if ($act == 'eventtrak') {
    include('siteFunctions.php');
    $a = new site();
    $a->saveCaffEvent($_REQUEST["target"], $_REQUEST["page"]);
}

if ($action == "writereview") {
    include('config.php');
    $name = $_POST['name'];
    $loc = $_POST['location'];
    $title = $_POST['title'];
    $desc = $_POST['description'];
    $usage = $_POST['usage'];
    $length = $_POST['length'];
    $rating = $_POST['rating'];
    $product = $_POST['product'];

    $rev = $data->query("INSERT INTO custom_equipment_reviews SET from = '" . $name . "', location = '" . $loc . "', ownership_length = '" . $length . "', usage = '" . $usage . "', post_date = '" . strval(time()) . "', review_title = '" . $title . "', review_description = '" . $desc . "', rating = '" . $rating . "', active = 'true', product_name = '" . $product . "'") or die($data->error);

    echo $rating;
}
