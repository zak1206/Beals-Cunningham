<?php

use ShipEngine\ShipEngine;
use Stripe\ShippingRate;

class Checkout
{

    public function __construct()
    {
    }

    /**
     * 
     * Gets the string value containing html contents of step-1 checkout page
     * 
     * @return returns string value containing html contents of step-1 checkout page
     */
    public function GetCheckoutPage_Step1(): string
    {
        include('config.php');
        $cartTotal = 0.0;

        if (isset($_COOKIE['cartData'])) {
            $cartDataRaw = $_COOKIE["cartData"];
            $cartDataJSON = json_decode($cartDataRaw, true);
            $cartItemsJSON = $cartDataJSON[0]['cartItems'];
            $itemCount = count($cartItemsJSON);
        }

        $html = '
            <style>
                .bg-success {
                    background-color: #367c2b !important;
                }
            </style>
            <script src="inc/mods/custom_equipment/checkout/checkout_functions.js" crossorigin="anonymous"></script>
            <script src="inc/mods/custom_equipment/custom_functions.js" crossorigin="anonymous"></script>

            <div class="container my-5 wrapper wrapper-content checkout-content">
                    <div class="row justify-content-center mb-5">
                        <div class="col-12 text-center"><h4>Checkout Progress</h4></div>
                        <div class="col-9 progress p-0 text-center" style="height: 30px; font-size: 1rem;">
                            <div class="progress-bar progress-bar-striped progress-bar-animated bg-success" id="check-prog" name="check-prog" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div>
                        </div>
                        <div class="col-12 text-center">
                            <b style="padding-top: 5px;">0% [Step 1 of 4]</b>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-md-9" style="margin-bottom: 30px;">
                            <div class="ibox">
                                <div class="ibox-title">
                                    <span class="pull-right"><strong>' . $itemCount . '</strong> item(s)</span>
                                    <h3>Items in your cart</h3>
                                </div>';

        for ($i = 0; $i < $itemCount; $i++) {
            $a = $data->query("SELECT * FROM custom_equipment WHERE id = " . $cartItemsJSON[$i]['id'] . "") or die($data->error);
            $b = $a->fetch_array();

            $img = json_decode($b['eq_image'], true);
            $mainImg = $img[0];
            $title = ucwords(str_replace('-', ' ', $b['title']));
            $url = $cartItemsJSON[$i]['url'];
            $description = substr($b['short_description'], 0, 50);
            $price = number_format($cartItemsJSON[$i]['price'], 2, '.', ',');
            $price_of_all_items = number_format(intval($cartItemsJSON[$i]['qty']) * $cartItemsJSON[$i]['price'], 2, '.', ',');
            $cartTotal = $cartTotal + ($cartItemsJSON[$i]['price'] * intval($cartItemsJSON[$i]['qty']));

            $html .= '<div class="ibox-content">
                        <div class="table-responsive">
                            <table class="table shoping-cart-table">
                                <tbody>
                                    <tr>

                                        <!--     Main Image    -->
                                        <td width="360">
                                            <div class="cart-product-imitation">
                                                <img style="width: 100%;" src="' . $mainImg . '">
                                            </div>
                                        </td>

                                        <!--     Description    -->
                                        <td class="desc" style="width:40%">
                                            <h5 style="margin: 0">
                                                <a href="' . $url . '" class="text-success">
                                                    <b>' . $title . '</b>
                                                </a>
                                            </h5>
                                            <small style="font-style: italic">$' . $price . ' ea</small>
                                            <br>
                                            <p class="small" style="margin-top: 10px">
                                                <span>' . $description . '...</span>
                                            </p>
                                        </td>

                                        <!--     Quantity    -->
                                        <td style="min-width: 100px; width: 150px; padding-right: 50px;">
                                            <div class="input-group mb-3">
                                                <input onchange="UpdateQty(' . $cartItemsJSON[$i]['id'] . ', \'' . $cartItemsJSON[$i]['uniqId'] . '\', \'' . $cartItemsJSON[$i]['name'] . '\', ' . $cartItemsJSON[$i]['price'] . ')" type="number" style="border-radius: 0" class="form-control" name="itmqty_' . $cartItemsJSON[$i]['uniqId'] . '" id="itmqty_' . $cartItemsJSON[$i]['uniqId'] . '" value="' . $cartItemsJSON[$i]['qty'] . '">';

            $html .= '</div>
                                        </td>

                                        <!--     $$ Total   -->
                                        <td>
                                            <h4 id="price_of_all_' . $cartItemsJSON[$i]['uniqId'] . '" style="display: block; width:100px; padding-right: 50px;">
                                                $' . $price_of_all_items . '
                                            </h4>
                                        </td>
                                        
                                        <!--     Remove From Cart Button    -->
                                        <td>
                                            <div class="m-t-sm">
                                                <a class="removit text-danger" style="font-weight: 500; font-size: 30px; cursor: pointer;" onclick="RemoveCartItem(\'' . $cartItemsJSON[$i]['uniqId'] . '\')"><b><i class="fa fa-trash" aria-hidden="true"></i></b></a>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>';
        }


        $html .= '
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="ibox">
                        <div class="row ibox-title text-center">
                            <b><h3>Cart Summary</h3></b>
                        </div>
                        
                        <hr>

                        <div class="row justify-content-end mt-4">
                            <span style="font-style: bold;">
                                <b>Sub Total:</b>
                            </span>
                        </div>

                        <div class="row justify-content-end">
                            <h4 class="font-bold" id="price-total">
                                $' . number_format($cartTotal, 2, '.', ',') . '
                            </h4>
                        </div>

                        <hr>

                        <div class="row mt-3 text-center justify-content-end">
                            <div class="col-md-6">
                                <a class="btn btn-white my-2" href="EStore">
                                    <i class="fa fa-arrow-left" aria-hidden="true"></i> 
                                    Continue Shopping
                                </a> 
                            </div>

                            <div class="col-md-6">
                                <a onclick="Checkout_Step2()" class="btn btn-success thecheckout next-button float-right pl-2 my-2 text-white">
                                    <i class="fa fa fa-shopping-cart" aria-hidden="true"></i> 
                                    Continue 
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> ';

        return $html;
    }

    /**
     * 
     * gets html contents of Step-2 Checkout page
     * 
     * @return returns string value containing html contents of Step-2 Checkout page
     */
    public function GetCheckoutPage_Step2(): string
    {
        include('config.php');
        $cartTotal = 0.0;

        if (isset($_COOKIE['cartData'])) {
            $cartDataRaw = $_COOKIE["cartData"];
            $cartDataJSON = json_decode($cartDataRaw, true);
            $cartItemsJSON = $cartDataJSON[0]['cartItems'];
            $itemCount = count($cartItemsJSON);
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
        }

        $html = '
                <style>
                    .bg-success {
                        background-color: #367c2b !important;
                    }
                    #Checkout_Shipping_Details {
                        background-color: #efefef !important;
                        padding: 20px;
                        border-radius: 15px;
                    }
                </style>
                <script src="inc/mods/custom_equipment/checkout/checkout_functions.js" crossorigin="anonymous"></script>
                <script src="inc/mods/custom_equipment/custom_functions.js" crossorigin="anonymous"></script>

                <div class="container my-5 wrapper wrapper-content checkout-content">
                    <div class="row justify-content-center mb-5">
                        <div class="col-12 text-center"><h4>Checkout Progress</h4></div>
                        <div class="col-9 progress p-0 text-center" style="height: 30px; font-size: 1rem;">
                            <div class="progress-bar progress-bar-striped progress-bar-animated bg-success" id="check-prog" name="check-prog" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" style="width: 25%"></div>
                        </div>
                            <div class="col-12 text-center">
                                <b style="padding-top: 5px;">25% [Step 2 of 4]</b>
                            </div>
                    </div>
                    <div class="row justify-content-center">

                        <div class="col-md-8" style="margin-bottom: 30px;">
                            <div class="row justify-content-center">
                                <div class="col-12 alert alert-danger form-errors d-none" role="alert">
                                This is a danger alert—check it out!
                                </div>
                            </div>';

        $html .= '<form class="form-process row" name="Checkout_Shipping_Details" id="Checkout_Shipping_Details" action="javascript:ContinueToShippingMethod()" method="post" novalidate="novalidate"><input type="hidden" name="form_table" id="form_table" value="Checkout_Shipping_Details"><h3 class="col-12">Shipping Details</h3><div class="col-md-6 col-lg-6 col-xl-6 col-sm-12 mb-1"><label>First Name*</label><br><input class="form-control" type="text" name="ship_firstName" id="ship_firstName" value="" maxlength="maxlength=" required="required"></div><div class="col-md-6 col-lg-6 col-xl-6 col-sm-12 mt-1"><label>Last Name*</label><br><input class="form-control" type="text" name="ship_lastName" id="ship_lastName" value="" maxlength="maxlength=" required="required"></div><div class="col-md-12 col-lg-12 col-xl-12 col-sm-12 mt-1"><label>Address*</label><br><input class="form-control" type="text" name="ship_address" id="ship_address" value="" maxlength="maxlength=" required="required"></div><div class="col-md-12 col-lg-12 col-sm-12 mt-1"><label>Apt #, Suite, Floor (Optional)</label><br><input class="form-control" type="text" name="ship_address_2" id="ship_address_2" value="" maxlength="maxlength="></div><div class="col-md-4 col-lg-6 col-sm-12 mt-1"><label>City*</label><br><input class="form-control" type="text" name="ship_city" id="ship_city" value="" maxlength="maxlength=" required="required"></div><div class="col-md-4 col-lg-4 col-xl-4 col-sm-6 mt-1"><label>State*</label><br><select name="ship_state" id="ship_state" class="form-control" required="required"><option value="TX">Texas</option><option value="OK">Oklahoma</option><option value="FL">Florida</option><option value="CO">Colorado</option></select></div><div class="col-md-4 col-lg-2 col-xl-2 col-sm-6 mt-1"><label>Zip*</label><br><input class="form-control" type="text" name="ship_zip" id="ship_zip" value="" maxlength="maxlength=" required="required"></div><h3 class="col-12 mt-5">Contact Details</h3><div class="col-md-12 col-lg-12 col-xl-12 mt-1"><label>Email Address*</label><br><input class="form-control" type="text" name="contact_email" id="contact_email" value="" maxlength="maxlength=" required="required"></div><div class="col-md-12 mt-1"><label>Phone Number*</label><br><input class="form-control" type="text" name="contact_phone" id="contact_phone" value="" maxlength="maxlength=" required="required"></div><div class="col-12"><button class="btn btn-success shipping-method d-none">Submit</button></div></form>';
        $html .= '</div>

                        <div class="col-md-4">
                            <div class="ibox">
                                <div class="row ibox-title text-center">
                                    <b><h3>Cart Summary</h3></b>
                                </div>

                                <div class="row ibox-content mt-3">
                                    <div class="table-responsive">
                                        <table class="table shoping-cart-table">
                                            <tbody class="text-center">
                                                <tr>
                                                    <td>
                                                        <b>Item</b>
                                                    </td>
                                                    <td>
                                                        <b>Qty</b>
                                                    </td>
                                                    <td>
                                                        <b>Price</b>
                                                    </td>
                                                </tr>';
        for ($i = 0; $i < $itemCount; $i++) {
            $cartTotal = $cartTotal + ($cartItemsJSON[$i]['price'] * intval($cartItemsJSON[$i]['qty']));
            $html .= '
                                                    <tr>
                                                        <td>
                                                            ' . str_replace('-', ' ', $cartItemsJSON[$i]['name']) . '
                                                        </td>
                                                        <td>
                                                            ' . $cartItemsJSON[$i]['qty'] . '
                                                        </td>
                                                        <td>
                                                            ' . $cartItemsJSON[$i]['price'] . '
                                                        </td>
                                                    </tr>';
        }
        $html .= '</tbody>
                                        </table>
                                    </div>
                                </div>

                                <hr>

                                <div class="row justify-content-center" id="discount-area">
                                    <div class="input-group col-md-12 text-center mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="inputGroup-sizing-default">Coupon Code</span>
                                        </div>
                                        <div class="input-group-append">
                                            <input type="text" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" id="discount-code" name="discount-code">
                                            <button class="btn btn-success mt-0" type="button" id="discount-btn" name="discount-btn" onclick="ApplyDiscountCode()" style="height: 100%;">Apply</button>
                                        </div>
                                    </div>
                                </div>

                                <div class="row justify-content-end mt-4">
                                    <span style="font-style: bold;">
                                        <b>Sub Total:</b>
                                    </span>
                                </div>

                                <div class="row justify-content-end">
                                    <h4 class="font-bold" id="price-total">
                                        $' . number_format($cartTotal, 2, '.', ',') . '
                                    </h4>
                                </div>

                                <div class="row mt-5 text-center justify-content-end" style="margin-top: 50px;">
                                    <div class="col-md-3 mx-3">
                                        <a class="btn btn-white my-2" href="checkout?action=step-1">
                                            <i class="fa fa-arrow-left" aria-hidden="true"></i> 
                                            Go Back
                                        </a> 
                                    </div>
            
                                    <div class="col-md-3 ml-3 next-button">
                                        <a onclick="ContinueToShippingMethod()" class="btn btn-success thecheckout float-right pl-2 my-2 text-white">
                                            <i class="fa fa fa-shopping-cart" aria-hidden="true"></i> 
                                            Continue
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>';

        return $html;
    }

    /**
     * 
     * Gets the string value containing html contents of step-3 checkout page
     * 
     * @return returns string value containing html contents of step-3 checkout page
     */
    public function GetCheckoutPage_Step3(): string
    {
        include('../cart/cart.php');
        $cart = new Cart();
        include('../shipping/shipping-interface.php');
        include('../shipping/shippo-handler.php');
        include('../shipping/ship-engine-handler.php');
        include('../shipping/shipping_handler.php');
        include('../tax/zip-tax-handler.php');
        $taxHandler = new ZipTaxHandler();
        $shipping_handler = new ShippingHandler();
        //$result = $shipping_handler->CreateShippingLabel('Zak Rowton', '3968 rochelle ln', '', 'Heartland', 'TX', '76137', 12, 12, 12, "inch", 65, "pound", '817-899-8723', 'zak.rowton@gmail.com');
        include('config.php');
        $cartTotal = 0.0;

        if (isset($_COOKIE['cartData'])) {
            $cartDataRaw = $_COOKIE["cartData"];
            $cartDataJSON = json_decode($cartDataRaw, true);
            $cartItemsJSON = $cartDataJSON[0]['cartItems'];
            $itemCount = count($cartItemsJSON);
        }

        $couponMsg = '';
        $firstName = $_POST['firstName'];
        $lastName = $_POST['lastName'];
        $Addr = $_POST['addr'];
        $Addr2 = $_POST['addr2'];
        $city = $_POST['city'];
        $state = $_POST['state'];
        $zip = $_POST['zip'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $cartTotal = $cartDataJSON[0]['cart_total'];
        $cartTrueTotal = intval($tax) + intval($cartTotal);
        $cartItems = $cartDataJSON[0]['cartItems'];

        if (isset($_COOKIE['addressData'])) {
            $addressDataJSON = json_decode($_COOKIE['addressData'], true);
            $newAddressDataJSON = [
                "shipping_address" => [
                    "first_name" => $firstName,
                    "last_name" => $lastName,
                    "street1" => $Addr,
                    "street2" => $Addr2,
                    "city" => $city,
                    "state" => $state,
                    "zip" => $zip
                ],
                "billing_address" =>
                [
                    "first_name" => $addressDataJSON['billing_address']['first_name'],
                    "last_name" => $addressDataJSON['billing_address']['last_name'],
                    "street1" => $addressDataJSON['billing_address']['street1'],
                    "street2" => $addressDataJSON['billing_address']['street2'],
                    "city" => $addressDataJSON['billing_address']['city'],
                    "state" => $addressDataJSON['billing_address']['state'],
                    "zip" => $addressDataJSON['billing_address']['zip']
                ],
                "email" => $email,
                "phone" => $phone
            ];
            setcookie('addressData', json_encode($newAddressDataJSON, true), 0, '/');
        } else {
            $newAddressDataJSON = [
                "shipping_address" => [
                    "first_name" => $firstName,
                    "last_name" => $lastName,
                    "street1" => $Addr,
                    "street2" => $Addr2,
                    "city" => $city,
                    "state" => $state,
                    "zip" => $zip
                ],
                "billing_address" =>
                [
                    "first_name" => "",
                    "last_name" => "",
                    "street1" => "",
                    "street2" => "",
                    "city" => "",
                    "state" => "",
                    "zip" => ""
                ],
                "email" => $email,
                "phone" => $phone
            ];
            setcookie('addressData', json_encode($newAddressDataJSON, true), 0, '/');
        }

        $total = 0;
        if (isset($_POST['discountCode'])) {
            $coupon_code = $_POST['discountCode'];
        }

        //Product Discounts
        foreach ($cartItems as &$item) {
            if ($item['applied_discount'] > 0) {
                $total = $total + (($item['price'] * $item['applied_discount']) * $item['qty']);
            } else {
                $total = $total + ($item['price'] * $item['qty']);
            }
        }

        //Check Cart Discount
        if ($cartDataJSON[0]['applied_discount'] > 0) {
            $total = $total - ($total * $cartDataJSON[0]['applied_discount']);
        }

        $html = '
        <style>
            .bg-success {
                background-color: #367c2b !important;
            }
        </style>
            <script src="inc/mods/custom_equipment/checkout/checkout_functions.js" crossorigin="anonymous"></script>
        <script src="inc/mods/custom_equipment/custom_functions.js" crossorigin="anonymous"></script>
    
        <div class="container my-5 wrapper wrapper-content checkout-content">
            <div class="row justify-content-center mb-5">
                <div class="col-12 text-center"><h4>Checkout Progress</h4></div>
                <div class="col-9 progress p-0 text-center" style="height: 30px; font-size: 1rem;">
                    <div class="progress-bar progress-bar-striped progress-bar-animated bg-success" id="check-prog" name="check-prog" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 50%"></div>
                </div>
                    <div class="col-12 text-center">
                        <b style="padding-top: 5px;">50% [Step 3 of 4]</b>
                    </div>
            </div>
            <div class="row justify-content-center">
    
                <div class="col-md-8 align-content-center align-items-center" style="margin-bottom: 30px;">
                    <div class="row justify-content-center">
                        <div class="col-12 alert alert-danger form-errors d-none" role="alert">
                            This is a danger alert—check it out!
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-md-4 mx-5">
                            <h3 class="mt-3"><b>Shipping Details</b></h3>
                            <p style="margin-left:20px;">' . $firstName . ' ' . $lastName . '<br>' . $Addr . ' ' . $Addr2 . '<br>' . $city . ', ' . $state . ' ' . $zip . '<br>United States</p>
                        </div>
                        <div class="col-md-4 mx-5">
                            <h3 class="mt-3"><b>Contact Details</b></h3>
                            <p style="margin-left:20px;"><b>Email</b><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $email . '<br><b>Phone</b><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $phone . '</p>
                        </div>
                    </div>
                </div>
    
                <div class="col-md-4">
                    <div class="ibox">
                        <div class="row ibox-title text-center">
                            <b><h3>Cart Summary</h3></b>
                        </div>
    
                        <div class="row ibox-content mt-3">
                            <div class="table-responsive">
                                <table class="table shoping-cart-table">
                                    <tbody class="text-center">
                                        <tr>
                                            <td>
                                                <b>Item</b>
                                            </td>
                                            <td>
                                                <b>Qty</b>
                                            </td>
                                            <td>
                                                <b>Price</b>
                                            </td>
                                        </tr>';

        for ($i = 0; $i < $itemCount; $i++) {
            $a = $data->query("SELECT * FROM custom_equipment WHERE id = " . $cartItemsJSON[$i]['id'] . "") or die($data->error);
            $b = $a->fetch_array();
            $_price = doubleval($cartItemsJSON[$i]['applied_discount']) > 0 ? doubleval($cartItemsJSON[$i]['price']) * doubleval($cartItemsJSON[$i]['applied_discount']) : $cartItemsJSON[$i]['price'];
            $beforeDiscount = doubleval($cartItemsJSON[$i]['applied_discount']) > 0 ? '<span style="text-decoration: line-through;">' . $cartItemsJSON[$i]['price'] . '</span> ' : '';

            if (doubleval($cartItemsJSON[$i]['applied_discount']) > 0) {
                $discountAmt = doubleval($cartItemsJSON[$i]['applied_discount']) * 100;
                $discountedItem = $cartItemsJSON[$i]['name'];
                $couponMsg .= '<span class="text-danger">- ' . $discountAmt . '% Discount Applied To ' . $discountedItem . '</span><br>';
            }

            $html .= '<tr>
                        <td>
                            ' . str_replace('-', ' ', $cartItemsJSON[$i]['name']) . '
                        </td>
                        <td>
                            ' . $cartItemsJSON[$i]['qty'] . '
                        </td>
                        <td>
                            ' . $beforeDiscount . '' . number_format($_price, 2, '.', ',') . '
                        </td>
                    </tr>';
        }

        $html .= '</tbody>
                </table>
            </div>
        </div>

        <div class="mt-5">
            <div class="row justify-content-center">';

        if (is_null($couponMsg) && $couponMsg != '') {
            $html .= $couponMsg;
        } else {
            $html .= '<h5 class="mr-3 pb-2"><b>No Coupon Code Added</b></h5>';
            $html .= '<a onclick="Checkout_Step2()">
                                    <button type="button" class="btn btn-success btn-sm mt-2" style="border-radius: 5px;">Apply Coupon</button>
                                </a>';
        }

        //Calculate Tax After Discount Applied
        $cart->UpdateCartTotalAfterDiscount();
        $tax = $taxHandler->GetTaxRateByZipCode($zip);
        $tax = $tax * $total;
        $cart->SetAppliedTax($tax);

        $html .= '</div>
                        </div>
    
                        <div class="discountapply ibox-content mt-3">
                            <table class="table shoping-cart-table">
                                <tbody>
                                    <tr>
                                        <td style="padding: 10px">Tax:</td>
                                        <td class="tax_inplace" style="padding: 10px;text-align: right">$' . number_format($tax, 2, '.', ',') . '</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
    
                        <div class="ibox-content" style="text-align: right;">';

        //SHIPPING STUFF
        $html .= '<div style="text-align: right; font-weight: bold">';

        //Check if Product Allows Shipping or Pickup OR is Pickup ONLY
        if ($b['pickup_only'] == "true") {
            //PICKUP-ONLY
            $html .= '<form name="shipssels" id="shipssels" method="post" action="" novalidate="novalidate">
                        <label class="float-left justify-content-start mt-3" for="pickup_location">Select Pickup Location: </label>
                        <select onchange="SetPickupLocation()" name="pickup_location" id="pickup_location" class="form-control" required="required">';

            $c = $data->query("SELECT * FROM location WHERE active = 'true'") or die($data->error);
            while ($d = $c->fetch_array()) {
                $html .= '<option value="' . $d['id'] . '">' . $d['location_name'] . '</option>';
            }

            $html .= '</select>
                </form>
            </div>';
        } else {
            //Shipping or Pickup Allowed
            $html .= '
                    <label for="ship_type" class="float-left justify-content-start mt-2">Select Pickup / Shipping Method</label>
                    <select class="form-control" id="ship_type" name="ship_type" onchange="SetShippingType()">
                        <option value="-1">Select Pickup / Shipping Method</option>
                        <option value="0">Shipping</option>
                        <option value="1">In-Store Pickup</option>
                    </select>';
        }

        $html .= '</div>
    
                <div class="ship_type_section">
                </div>
        </div>';


        //TODO SHIPPING

        $html .= '<div class="row justify-content-end mt-4">
                            <span style="font-style: bold;">
                                <b>Sub Total:</b>
                            </span>
                        </div>
    
                        <div class="row justify-content-end">
                            <h4 class="font-bold" id="price-total">
                                $' . number_format($total + $tax, 2, '.', ',') . '
                            </h4>
                        </div>
    
                        <div class="row mt-5 text-center justify-content-end" style="margin-top: 50px;">
                            <div class="col-md-3 mx-3">
                                <a class="btn btn-white my-2" onclick="Checkout_Step2()">
                                    <i class="fa fa-arrow-left" aria-hidden="true"></i> 
                                    Go Back
                                </a> 
                            </div>

                            <div class="col-md-3 ml-3 next-button">
                                <a onclick="Checkout_Step4(\'' . $firstName . '\', \'' . $lastName . '\', \'' . $Addr . '\', \'' . $Addr2 . '\', \'' . $city . '\', \'' . $state . '\', \'' . $zip . '\', \'' . $email . '\', \'' . $phone . '\')" class="btn btn-success thecheckout float-right pl-2 my-2 text-white">
                                    <i class="fa fa fa-shopping-cart" aria-hidden="true"></i> 
                                    Continue
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
    
            </div>
        </div>';

        return $html;
    }

    /**
     * 
     * Gets the string value containing html contents of step-4 checkout page
     * 
     * @return returns string value containing html contents of step-4 checkout page
     */
    public function GetCheckoutPage_Step4($firstName, $lastName, $Addr, $Addr2, $city, $state, $zip, $email, $phone): string
    {
        include('../cart/cart.php');
        $cart = new Cart();
        include('../shipping/shipping-interface.php');
        include('../shipping/shippo-handler.php');
        include('../shipping/ship-engine-handler.php');
        include('../shipping/shipping_handler.php');
        include('../tax/zip-tax-handler.php');
        $taxHandler = new ZipTaxHandler();
        $shipping_handler = new ShipEngineHandler();
        $cartTotal = 0.0;

        if (isset($_COOKIE['cartData'])) {
            $cartDataRaw = $_COOKIE["cartData"];
            $cartDataJSON = json_decode($cartDataRaw, true);
            $cartItemsJSON = $cartDataJSON[0]['cartItems'];
            $itemCount = count($cartItemsJSON);
        }

        $couponMsg = '';
        $total_length = 10;
        $total_width = 10;
        $total_height = 10;
        $tax = $cartDataJSON[0]['applied_tax'];
        $cartTotal = $cartDataJSON[0]['cart_total'];
        $cartTrueTotal = intval($tax) + intval($cartTotal);
        $cartItems = $cartDataJSON[0]['cartItems'];
        $total = 0;

        if (isset($_POST['discountCode'])) {
            $coupon_code = $_POST['discountCode'];
        }

        //Product Discounts
        foreach ($cartItems as &$item) {
            if ($item['applied_discount'] > 0) {
                $total = $total + (($item['price'] * $item['applied_discount']) * $item['qty']);
            } else {
                $total = $total + ($item['price'] * $item['qty']);
            }
        }

        //Check Cart Discount
        if ($cartDataJSON[0]['applied_discount'] > 0) {
            $total = $total * $cartData[0]['applied_discount'];
        }

        //Check If Pickup
        if ($cartDataJSON[0]['pickup'] == true) {
            $p = $data->query("SELECT * FROM location WHERE id = '" . $cartDataJSON[0]['shop_location'] . "'") or die($data->error);
            $pickup_location = $p->fetch_assoc();

            if (!empty($pickup_location)) {
                $pickup_loc_name = $pickup_location['location_name'];
                $pickup_loc_address = $pickup_location['location_address'];
                $pickup_loc_city = $pickup_location['location_city'];
                $pickup_loc_state = $pickup_location['location_state'];
                $pickup_loc_zip = $pickup_location['location_zip'];
                $pickup_loc_operation = json_decode($pickup_location['location_hours'], true);
                $pickup_loc_days = $pickup_loc_operation[0]['day'];
                $pickup_loc_hours = $pickup_loc_operation[0]['hours'];
                $noIssues = true;
            } else {
                $noIssues = false;
            }
        }

        $html = '<style>
                    .bg-success {
                        background-color: #367c2b !important;
                    }
                </style>
                <script src="inc/mods/custom_equipment/checkout/checkout_functions.js" crossorigin="anonymous"></script>
                <script src="inc/mods/custom_equipment/custom_functions.js" crossorigin="anonymous"></script>

                <div class="container my-5 wrapper wrapper-content checkout-content">
                    <div class="row justify-content-center mb-5">
                        <div class="col-12 text-center"><h4>Checkout Progress</h4></div>
                        <div class="col-9 progress p-0 text-center" style="height: 30px; font-size: 1rem;">
                            <div class="progress-bar progress-bar-striped progress-bar-animated bg-success" id="check-prog" name="check-prog" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: 75%"></div>
                        </div>
                            <div class="col-12 text-center">
                                <b style="padding-top: 5px;">75% [Step 4 of 4]</b>
                            </div>
                    </div>
                    <div class="row justify-content-center">
                        <style>
                            .card-form {
                                background: #efefef;
                                padding: 20px;
                                border-radius: 15px;
                            }
                        </style>
                        <div class="col-md-8" style="margin-bottom: 30px;">
                        
                            <div class="row justify-content-center">
                                <div class="col-12 alert alert-danger form-errors d-none" role="alert">
                                    This is a danger alert—check it out!
                                </div>
                            </div>

                            <div class="row justify-content-center mt-2">';

        //Display Pickup Location
        if ($cartDataJSON[0]['pickup'] == true && $noIssues) {
            $html .= '<div class="col-md-3 mx-3">
                                    <h3 class="mt-3"><b>Pickup Location</b></h3>
                                    <p style="">' . $pickup_loc_address . '<br>' . $pickup_loc_city . ', ' . $pickup_loc_state . ' ' . $pickup_loc_zip . '<br>United States<br></p>
                                    <h5 class=""><b>Hours of Operation</b></h5>
                                    <p><b>Days:  </b>' . $pickup_loc_days . '</p>
                                    <p><b>Hours:  </b>' . $pickup_loc_hours . '</p>
                                </div>';
        }

        $cartItemsJSON = $cartDataJSON[0]['cartItems'];
        $html .= '<div class="col-md-3 mx-3">
                                    <h3 class="mt-3"><b>Shipping Details</b></h3>
                                    <p style="">' . $firstName . ' ' . $lastName . '<br>' . $Addr . '    ' . $Addr2 . '<br>' . $city . ', ' . $state . ' ' . $zip . '<br>United States</p>
                                </div>
                                <div class="col-md-3 mx-3">
                                    <h3 class="mt-3"><b>Contact Details</b></h3>
                                    <p style=""><b>Email</b><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $email . '
                                    <br>
                                    <b>Phone</b><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $phone . '</p>
                                </div>
                            </div>
                            <div class="row card-form">
                                <form class="form-process row" name="Credit_Card_Details" id="Credit_Card_Details" action="" method="post" onsubmit="return false" novalidate="novalidate">
                                    <input type="hidden" name="form_table" id="form_table" value="Credit_Card_Details">
                                    
                                    <h1 class="col-md-12 col-sm-12 col-lg-12 col-xl-12">Payment Details</h1>
                                    <div class="col-md-6 col-lg-6 col-xl-6 col-sm-12 mt-2">
                                        <label>First Name</label>
                                        <br>
                                        <input class="form-control" type="text" name="first_name" id="first_name" value="" required="required">
                                    </div>
                                    <div class="col-md-6 col-lg-6 col-xl-6 col-sm-12 mt-2">
                                        <label>Last Name</label>
                                        <br>
                                        <input class="form-control" type="text" name="last_name" id="last_name" value="" required="required">
                                    </div>
                                    <div class="col-md-12 col-lg-12 col-xl-12 col-sm-12 mt-2">
                                    <label>Card Number</label>
                                    <br>
                                    <input class="form-control" type="text" name="card_number" id="card_number" value="" placeholder="0000 0000 0000 0000" required="required">
                                    </div>
                                    <div class="col-md-6 col-lg-6 col-xl-6 col-sm-12 mt-2">
                                        <label>Expiration</label>
                                        <br>
                                        <input class="form-control" type="text" name="expiration" id="expiration" value="" placeholder="00/00" required="required">
                                    </div>
                                    <div class="col-md-6 col-lg-6 col-xl-6 col-sm-12 mt-2">
                                        <label>CSV</label>
                                        <br>
                                        <input class="form-control" type="text" name="csv" id="csv" value="" placeholder="000" required="required">
                                    </div>

                                    <h1 class="col-md-12 col-sm-12 col-lg-12 mt-4">Billing Details</h1>
                                    <div class="col-md-12 col-lg-12 col-xl-12 col-sm-12 text-center">
                                        <label></label>
                                        <br>
                                        <div style="display:inline-block; padding:5px">
                                            <a onclick="SetBillingAddress(\'' . $Addr . ' ' . $Addr2 . '\', \'' . $city . '\', \'' . $state . '\', \'' . $zip . '\')"><input class="form-control" type="checkbox" id="form-control0" name="sameShippingAddr[]" value="same"> 
                                            <label for="form-control0">Same As Shipping Address </label>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-12 mt-2">
                                        <label>Address</label>
                                        <br>
                                        <input class="form-control" type="text" name="address" id="address" value="" required="required">
                                    </div>
                                    <div class="col-md-7 col-lg-7 col-xl-7 col-sm-12 mt-2">
                                        <label>City</label>
                                        <br>
                                        <input class="form-control" type="text" name="city" id="city" value="" required="required">
                                    </div>
                                    <div class="col-md-3 col-lg-3 col-xl-3 col-sm-6 mt-2">
                                        <label>State</label>
                                        <br>
                                        <select name="state" id="state" class="form-control" required="required">
                                            <option value="tx">TX</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2 col-lg-2 col-xl-2 col-sm-6 mt-2">
                                        <label>Zip</label>
                                        <br>    
                                        <input class="form-control" type="text" name="zip" id="zip" value="" required="required">
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="ibox">
                                <div class="row ibox-title text-center">
                                    <b><h3>Cart Summary</h3></b>
                                </div>

                                <div class="row ibox-content mt-3">
                                    <div class="table-responsive">
                                        <table class="table shoping-cart-table">
                                            <tbody class="text-center">
                                                <tr>
                                                    <td>
                                                        <b>Item</b>
                                                    </td>
                                                    <td>
                                                        <b>Qty</b>
                                                    </td>
                                                    <td>
                                                        <b>Price</b>
                                                    </td>
                                                </tr>';

        //Get Total Length/Width/Height of all Items
        for ($i = 0; $i < $itemCount; $i++) {
            include('config.php');
            $a = $data->query("SELECT * FROM custom_equipment WHERE id = " . $cartItemsJSON[$i]['id'] . "") or die($data->error);
            $b = $a->fetch_assoc();
            $_price = doubleval($cartItemsJSON[$i]['applied_discount']) > 0 ? doubleval($cartItemsJSON[$i]['price']) * doubleval($cartItemsJSON[$i]['applied_discount']) : $cartItemsJSON[$i]['price'];
            $beforeDiscount = doubleval($cartItemsJSON[$i]['applied_discount']) > 0 ? '<span style="text-decoration: line-through;">' . $cartItemsJSON[$i]['price'] . '</span> ' : '';

            $dimensions = explode('X', $b['dimentions'], 3);
            $total_length = doubleval($total_length) + doubleval($dimensions[0]);
            $total_width = doubleval($total_width) + doubleval($dimensions[1]);
            $total_height = doubleval($total_height) + doubleval($dimensions[2]);

            if (doubleval($cartItemsJSON[$i]['applied_discount']) > 0) {
                $discountAmt = doubleval($cartItemsJSON[$i]['applied_discount']) * 100;
                $discountedItem = $cartItemsJSON[$i]['name'];
                $couponMsg .= '<span class="text-danger">- ' . $discountAmt . '% Discount Applied To ' . $discountedItem . '</span><br>';
            }

            $html .= '
                                                    <tr>
                                                        <td>
                                                            ' . str_replace('-', ' ', $cartItemsJSON[$i]['name']) . '
                                                        </td>
                                                        <td>
                                                            ' . $cartItemsJSON[$i]['qty'] . '
                                                        </td>
                                                        <td>
                                                            ' . $beforeDiscount . '' . number_format($_price, 2, '.', ',') . '
                                                        </td>
                                                    </tr>';
        }

        $html .= '</tbody>
                        </table>
                    </div>
                </div>

                <div class="mt-5">
                    <div class="row justify-content-center">';

        if ($couponMsg != '') {
            $html .= $couponMsg;
        } else {
            $html .= '<h5 class="mr-3 pb-2"><b>No Coupon Code Added</b></h5>';
            $html .= '<a onclick="Checkout_Step2()">
                                <button type="button" class="btn btn-success btn-sm mt-2" style="border-radius: 5px;">Apply Coupon</button>
                            </a>';
        }

        $shipCost = $shipping_handler->CalculateCharges(($firstName . ' ' . $lastName), $Addr, $Addr2, $city, $state, $zip, $phone, $email);
        $shipping_cost = floatval($shipCost);
        //$cart->UpdateCartWithShippingLabel($ship, $shipping_cost);
        //$cart->UpdateCartTotalAfterDiscount();
        $tax = $taxHandler->GetTaxRateByZipCode($zip);
        $tax = $tax * $total;
        $cart->SetAppliedTax($tax);
        $shipping_handling = $cartDataJSON[0]['pickup'] == true ? "<b class=\"text-danger\">In-Store Pickup</b>" : ('$' . number_format($shipCost, 2, '.', ','));
        $shipping_cost = number_format($shipping_cost, 2, '.', ',');
        //Calculate Cart Total w/ Discounts/Tax/Shipping

        $html .= '</div>
                                </div>

                                <div class="discountapply ibox-content mt-3">
                                    <table class="table shoping-cart-table">
                                        <tbody>
                                            <tr>
                                                <td style="padding: 10px">Tax:</td>
                                                <td class="tax_inplace" style="padding: 10px;text-align: right">$' . number_format($tax, 2, '.', ',') . '</td>
                                            </tr>
                                            <tr>
                                                <td style="padding: 10px">Shipping &amp; Handling:</td>
                                                <td class="tax_inplace" style="padding: 10px;text-align: right">' . number_format($shipping_cost, 2, '.', ',') . '</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <div class="ibox-content" style="text-align: right;">';

        $html .= '<div class="ship_type_section">
                        </div>
                </div>';
        $html .= '<div class="row justify-content-end mt-3">
                        <h4 style="font-style: bold;">
                            <b>Sub Total:</b>
                        </h4>
                    </div>

                    <div class="row justify-content-end">
                        <h4 class="font-bold" id="price-total">
                            $' . number_format($cartTrueTotal, 2, '.', ',') . '
                        </h4>
                    </div>

                    <div class="row mt-5 text-center justify-content-end" style="margin-top: 50px;">
                        <div class="col-md-3 mx-5">
                            <a class="btn btn-white my-2" onclick="GoBackStep3(\'' . $firstName . '\', \'' . $lastName . '\', \'' . $Addr . '\', \'' . $Addr2 . '\', \'' . $city . '\', \'' . $state . '\', \'' . $zip . '\', \'' . $email . '\', \'' . $phone . '\')">
                                <i class="fa fa-arrow-left" aria-hidden="true"></i> 
                                Go Back
                            </a> 
                        </div>

                        <div class="col-md-3 ml-5 next-button">
                            <a onclick="ProcessPayment(\'' . $firstName . '\', \'' . $lastName . '\', \'' . $Addr . '\', \'' . $Addr2 . '\', \'' . $city . '\', \'' . $state . '\', \'' . $zip . '\', \'' . $email . '\', \'' . $phone . '\')" class="btn btn-success thecheckout next-button float-right pl-2 my-2 text-white">
                                <i class="fa fa fa-shopping-cart" aria-hidden="true"></i> 
                                Process Payment
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div></div>';

        return $html;
    }
}
