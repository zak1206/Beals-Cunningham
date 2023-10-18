<?php
include('config.php');
include('checkout.php');

$checkout = new Checkout();

error_reporting(E_ALL);
ini_set('display_errors', '1');

$cartTotal = 0;
$action = 'step-1';

if (isset($_COOKIE['cartData'])) {
    $cartDataRaw = $_COOKIE["cartData"];
    $cartDataJSON = json_decode($cartDataRaw, true);
    $cartItemsJSON = $cartDataJSON[0]['cartItems'];
    $itemCount = count($cartItemsJSON);
} else {
    $html = '
            <div class="row justify-content-center">
                <div class="col-md-9" style="margin-bottom: 30px;">
                    <div class="ibox">
                        <div class="ibox-title">
                            <span class="pull-right"><strong>0</strong> item(s)</span>
                            <h3>Your Cart is Empty!</h3>
                        </div>
                    </div>
                </div>
            </div>';

    echo $html;
}

//Check if we are returning from step-3
if (isset($_POST['firstName'])) {
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $Addr = $_POST['addr'];
    $Addr2 = $_POST['addr2'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $zip = $_POST['zip'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $tax = $cartDataJSON[0]['applied_tax'];
}

if (isset($_REQUEST['action'])) {
    $action = $_REQUEST['action'];
}

if ($action == 'step-1') {
    $html = $checkout->GetCheckoutPage_Step1();
    echo $html;
}

if ($action == 'step-2') {
    $html = $checkout->GetCheckoutPage_Step2();
    echo $html;
}

if ($action == 'step-3') {
    $html = $checkout->GetCheckoutPage_Step3();
    echo $html;
}

if ($action == "step-4") {
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
    $cartDataJSON = json_decode($cartDataRaw, true);
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $Addr = $_POST['addr'];
    $Addr2 = $_POST['addr2'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $zip = $_POST['zip'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $tax = $cartDataJSON[0]['applied_tax'];
    $checkouts = new Checkout();
    $html = $checkouts->GetCheckoutPage_Step4($firstName, $lastName, $Addr, $Addr2, $city, $state, $zip, $email, $phone);
    echo $html;
}

if ($action == 'applydiscount') {
    $code = $_POST['discountCode'];

    include('../coupons/coupon-handler.php');
    $coupons = new CouponHandler();
    echo $coupons->ApplyCouponCode($code);
}

if ($action == 'pickuplocation') {
    $id = $_POST['id'];
    include('../cart/cart.php');
    $cart->SetShopLocation($id);
    echo "SUCCESS";
}

if ($action == 'setshipservice') {
    $service_code = $_POST['service_code'];
    $carrier_id = $_POST['carrier_id'];
    $shippingData = array([
        "service_code" => $service_code,
        "carrier_id" => $carrier_id
    ]);

    //Verify Cookie Was Set
    if (setcookie('shippingData', json_encode($shippingData, true), 0, '/')) {
        echo "SUCCESS";
    } else {
        echo "FAILED";
    }
}

if ($action == 'setshiptype') {
    $type = $_POST['shipType'];
    if ($type == '1') {
        $type = 1;
        //Pickup Selected
        $html = '<form name="shipssels" id="shipssels" method="post" action="" novalidate="novalidate">
                    <label class="float-left justify-content-start mt-3" for="pickup_location">Select Pickup Location: </label>
                    <select onchange="SetPickupLocation()" name="pickup_location" id="pickup_location" class="form-control" required="required">
                        <option value="Select A Pickup Location"></option>';

        $c = $data->query("SELECT * FROM location WHERE active = 'true'") or die($data->error);
        while ($d = $c->fetch_array()) {
            $html .= '<option value="' . $d['id'] . '">' . $d['location_name'] . '</option>';
        }

        $html .= '</select>
            </form>
        </div>';

        $cartDataOld = json_decode($_COOKIE['cartData'], true);
        $cartDataNewNew = array([
            "shop_location" => $cartDataOld[0]['shop_location'],
            "pickup" => true,
            "applied_tax" => $cartDataOld[0]['applied_tax'],
            "applied_discount" => $cartDataOld[0]['applied_discount'],
            "cart_total" => $cartDataOld[0]['cart_total'],
            "cartItems" => $cartDataOld[0]['cartItems'],
            "coupons" => $cartDataOld[0]['coupons']
        ]);
        setcookie('cartData', json_encode($cartDataNewNew, true), 0, '/');
    } else if ($type == '0') {

        $type = 0;
        //Shipping Selected
        $cartDataOld = json_decode($_COOKIE['cartData'], true);
        $cartDataNewNew = array([
            "shop_location" => $cartDataOld[0]['shop_location'],
            "pickup" => false,
            "applied_tax" => $cartDataOld[0]['applied_tax'],
            "applied_discount" => $cartDataOld[0]['applied_discount'],
            "cart_total" => $cartDataOld[0]['cart_total'],
            "cartItems" => $cartDataOld[0]['cartItems'],
            "coupons" => $cartDataOld[0]['coupons']
        ]);
        setcookie('cartData', json_encode($cartDataNewNew, true), 0, '/');

        $html = '<hr>
                <form name="servsel" id="servsel" method="post" novalidate="novalidate">
                    <label class="float-left justify-content-start" for="ship_service"><b>Select Shipping Speed:</b> </label>
                    <select onchange="SetShippingServiceCode()" name="ship_service" id="ship_service" class="form-control" required="required">';

        include('../shipping/shipping-interface.php');
        include('../shipping/shippo-handler.php');
        include('../shipping/ship-engine-handler.php');
        include('../shipping/shipping_handler.php');
        $shipping = new ShippingHandler();
        $carriers = $shipping->GetCarrierID();

        //Fill Drop-Down w/ Available Shipping Service Codes
        for ($i = 0; $i < count($carriers); $i++) {
            if (isset($carriers[$i]['service_code'])) {
                $html .= '<option value="' . $carriers[$i]['service_code'] . '|' . $carriers[$i]['carrier_id'] . '">' . ucwords(str_replace('_', ' ', $carriers[$i]['service_code'])) . '</option>';
            }
        }

        $html .= '</select>
            </form>';
    } else {
        //Reset Selected
        $html = '';
    }

    echo $html;
}

if ($action == 'update_cart_dropdown') {
    include('config.php');
    $cartRaw = $_COOKIE['cartData'];
    $cartJson = json_decode($cartItemsRaw, true);

    $html = '<div class="row">';

    if (isset($_COOKIE['cartData'])) {
        $cartData = json_decode($_COOKIE['cartData'], true); // Decode JSON into associative array
        if ($cartData && isset($cartData[0]['cartItems']) && $cartData[0]['cartItems'] != "") {

            $cartItemCount = count($cartData[0]['cartItems']);
            if ($cartItemCount > 0) {
                $html .= '<div class="col-md-12"><h3 class="text-center"><b>Cart</b></h3></div>';

                for ($i = 0; $i < count($cartData[0]['cartItems']); $i++) {
                    $id = $cartData[0]['cartItems'][$i]['id'];
                    $price = $cartData[0]['cartItems'][$i]['price'];
                    $qty = $cartData[0]['cartItems'][$i]['qty'];
                    $uniqId = $cartData[0]['cartItems'][$i]['uniqId'];

                    $a = $data->query("SELECT * FROM custom_equipment WHERE id = " . $id . "");
                    $obj = $a->fetch_array();

                    $html .= '<div class="col-md-5 text-center">
                        <h6><b>' . $obj['title'] . '</b></h6>
                    </div>

                    <div class="col-md-1 text-center">
                        <h6>' . $qty . '</h6>
                    </div>
                    
                    <div class="col-md-3 text-center">
                        <h6>$' . $price . '</h6>
                    </div>

                    <div class="col-md-1 ml-2 text-center">
                        <h6><button class="btn btn-danger" onclick="RemoveCartItem(\'' . $uniqId . '\')">X</button></h6>
                    </div>';
                }

                $html .= '<div class="col-md-12 ml-2 text-center">
                        <h6><a href="checkout"><button class="btn btn-success">Checkout</button></a></h6>
                    </div>';
            } else {
                $html .= '<div class="col-md-12 text-center"><h1 style="font-size: 20px !important;"><b>Nothing In Cart...</b></h1></div>';
            }
        }
    } else {
        $html .= '<div class="col-md-12 text-center"><h1 style="font-size: 20px !important;"><b>Nothing In Cart...</b></h1></div>';
    }

    $html .= '</div>';

    $returnArray = array(
        'html' => $html,
        'count' => $cartItemCount
    );

    $returnJson = json_encode($returnArray, true);

    echo ($returnJson);
}

if ($action == 'validateaddress') {
    include('../shipping/shipping-interface.php');
    include('../shipping/shippo-handler.php');
    include('../shipping/ship-engine-handler.php');
    include('../shipping/shipping_handler.php');
    $shipping_class = new ShippingHandler();
    $shipAPI = $shipping_class->Get_Shipping_Type();
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $Addr = $_POST['addr'];
    $Addr2 = $_POST['addr2'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $zip = $_POST['zip'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    if ($shipAPI == 'shipengine') {
        //Handle Address Validation Using Ship-Engine API
        $ship_engine = new ShipEngineHandler();
        $validation = $ship_engine->ValidateAddress($Addr, $Addr2, $city, $state, $zip);
        $isValid = $validation;
    } elseif ($shipAPI == 'shippo') {
        //TODO

        //Handle Address Validation Using Google API
        $ship_engine = new ShippoHandler();
        $validation = $ship_engine->ValidateAddress($Addr, $Addr2, $city, $state, $zip);
        $isValid = true;
    } else {
        //Handle No API Set
        $validation = false;
        $isValid = false;
    }

    if ($validation) {
        $returnArray = array(
            'valid' => $isValid ? true : false,
            'hasError' => $isValid ? false : true,
            'errorMessage' => '[Address Invalid] - Please Enter A Valid Address Into The Fields Below.'
        );
        $jsonReturn = json_encode($returnArray, true);
    } else {
        $returnArray = array(
            'valid' => $isValid ? true : false,
            'hasError' => $isValid ? false : true,
            'errorMessage' => '[Address Invalid] - Please Enter A Valid Address Into The Fields Below.'
        );
        $jsonReturn = json_encode($returnArray, true);
    }
    echo $jsonReturn;
}

if ($action == 'processpayment') {
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $addr = $_POST['addr'];
    $addr2 = $_POST['addr2'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $zip = $_POST['zip'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $billing_first_name = $_POST['billing_first_name'];
    $billing_last_name = $_POST['billing_last_name'];
    $billing_address = $_POST['billing_address'];
    $billing_city = $_POST['billing_city'];
    $billing_state = $_POST['billing_state'];
    $billing_zip = $_POST['billing_zip'];
    $addressData = json_decode($_COOKIE['addressData'], true);
    $newBillingAddrData = array(
        'first_name' => $billing_first_name,
        'last_name' => $billing_last_name,
        'street1' => $billing_address,
        'city' => $billing_city,
        'state' => $billing_state,
        'zip' => $billing_zip
    );
    $addressData['billing_address'] = $newBillingAddrData;
    $newAddressDataJSON = json_encode($addressData, true);
    setcookie('addressData', $newAddressDataJSON, 0, '/');

    //include('../payments/stripe-handler.php');
    //$processor = new StripeHandler();
    //$token = $processor->ProcessPayment(intval($_COOKIE['cartData'][0]['cart_total']), ($firstName), $email, $phone, ($addr), $city, $state, $zip, $billing_address, $billing_city, $billing_state, $billing_zip, 'WOOT!');

    //Email Customer

    //Email Store Notifying of Order

    //Display Invoice
    include('../checkout/invoice-page.php');
}
