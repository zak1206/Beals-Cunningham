<?php
include('config.php');

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
        <script src="inc/mods/custom_equipment/checkout_functions.js" crossorigin="anonymous"></script>
        <script src="inc/mods/custom_equipment/custom_functions.js" crossorigin="anonymous"></script>

        <div class="container my-5 wrapper wrapper-content checkout-content">
            <div class="row justify-content-center">
                <div class="col-md-9" style="margin-bottom: 30px;">
                    <div class="ibox">
                        <div class="ibox-title">
                            <span class="pull-right"><strong>0</strong> item(s)</span>
                            <h3>Your Cart is Empty!</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>';

    echo $html;
}

if (isset($_REQUEST['action'])) {
    $action = $_REQUEST['action'];
}

if ($action == 'step-1' && isset($_COOKIE['cartData'])) {
    $html = '
            <style>
                .bg-success {
                    background-color: #367c2b !important;
                }
            </style>
            <script src="inc/mods/custom_equipment/checkout_functions.js" crossorigin="anonymous"></script>
            <script src="inc/mods/custom_equipment/custom_functions.js" crossorigin="anonymous"></script>

            <div class="container my-5 wrapper wrapper-content checkout-content">
                    <div class="row justify-content-center mb-5">
                        <div class="col-12 text-center"><h4>Checkout Progress</h4></div>
                        <div class="col-9 progress p-0 text-center" style="height: 30px; font-size: 1rem;">
                            <div class="progress-bar progress-bar-striped progress-bar-animated bg-success" id="check-prog" name="check-prog" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 20%"></div>
                        </div>
                        <div class="col-12 text-center">
                            <b style="padding-top: 5px;">20% [Step 1 of 5]</b>
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
        $price_of_all = number_format(intval($cartItemsJSON[$i]['qty']) * $cartItemsJSON[$i]['price'], 2, '.', ',');
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
                                            <input onchange="UpdateQty(' . $cartItemsJSON[$i]['id'] . ')" type="number" style="border-radius: 0" class="form-control" name="itmqty_' . $cartItemsJSON[$i]['uniqId'] . '" id="itmqty_' . $cartItemsJSON[$i]['uniqId'] . '" value="' . $cartItemsJSON[$i]['qty'] . '">';

        $html .= '<script>
            function UpdateQty(id) {
                var amt = $("#itmqty_' . $cartItemsJSON[$i]['uniqId'] . '").val();
                console.log("Still Under Contruction!");
                //TODO
                $.ajax({
                    type: "POST",
                    url: "inc/mods/custom_equipment/command_processor.php?action=updateqty",
                    data: {
                        id: id,
                        qty: amt
                    },
                    dataType: "json",
                    success: function(obj) {
                        if (obj.response == "good") {
                            location.reload();
                        } else {
                            alert(obj.message);
                        }
                    }
                })
            }
        </script>';

        $html .= '</div>
                                    </td>

                                    <!--     $$ Total   -->
                                    <td>
                                        <h4 id="price_of_all_' . $cartItemsJSON[$i]['id'] . '" style="display: block; width:100px; padding-right: 50px;">
                                            $' . $price_of_all . '
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
                            <a onclick="Checkout_Step2()" class="btn btn-success thecheckout float-right pl-2 my-2 text-white">
                                <i class="fa fa fa-shopping-cart" aria-hidden="true"></i> 
                                Continue 
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> ';

    echo $html;
}

if ($action == 'step-2') {



    $html = '
            <style>
                .bg-success {
                    background-color: #367c2b !important;
                }
            </style>
            <script src="inc/mods/custom_equipment/checkout_functions.js" crossorigin="anonymous"></script>
            <script src="inc/mods/custom_equipment/custom_functions.js" crossorigin="anonymous"></script>

            <div class="container my-5 wrapper wrapper-content checkout-content">
                <div class="row justify-content-center mb-5">
                    <div class="col-12 text-center"><h4>Checkout Progress</h4></div>
                    <div class="col-9 progress p-0 text-center" style="height: 30px; font-size: 1rem;">
                        <div class="progress-bar progress-bar-striped progress-bar-animated bg-success" id="check-prog" name="check-prog" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%"></div>
                    </div>
                        <div class="col-12 text-center">
                            <b style="padding-top: 5px;">40% [Step 2 of 5]</b>
                        </div>
                </div>
                <div class="row justify-content-center">

                    <div class="col-md-8" style="margin-bottom: 30px;">
                        {form}Checkout_Shipping_Details{/form}
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

                            <div class-"row justify-content-end">
                                <div class="col-md-12 form-group align-content-end">
                                    <input type="text" name="discount-code" id="discount-code" value="" placeholder="Discount Code">
                                    <button onclick="ApplyDiscountCode()" class="btn btn-primary" name="apply-discount-btn" id="apply-discount-btn">Apply</button>
                                </div>
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

                            <div class="row mt-5 text-center justify-content-end" style="margin-top: 50px;">
                                <div class="col-md-3 mx-3">
                                    <a class="btn btn-white my-2" href="checkout?action=step-1">
                                        <i class="fa fa-arrow-left" aria-hidden="true"></i> 
                                        Go Back
                                    </a> 
                                </div>
        
                                <div class="col-md-3 ml-3">
                                    <a onclick="Checkout_Step3()" class="btn btn-success thecheckout float-right pl-2 my-2 text-white">
                                        <i class="fa fa fa-shopping-cart" aria-hidden="true"></i> 
                                        Continue
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>';

    echo $html;
}

if ($action == 'step-3') {

    //TODO - HANDLE CHECKING IF ANY POST VALUES NOT SET THEN GO BACK AND DISPLAY WARNING

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

    if (isset($_POST['discountCode'])) {
        $coupon_code = $_POST['discountCode'];
    }
    $cartTotal = $cartDataJSON[0]['cart_total'];
    $cartTrueTotal = intval($tax) + intval($cartTotal);

    $html = '
    <style>
        .bg-success {
            background-color: #367c2b !important;
        }
    </style>
    <script src="inc/mods/custom_equipment/checkout_functions.js" crossorigin="anonymous"></script>
    <script src="inc/mods/custom_equipment/custom_functions.js" crossorigin="anonymous"></script>

    <div class="container my-5 wrapper wrapper-content checkout-content">
        <div class="row justify-content-center mb-5">
            <div class="col-12 text-center"><h4>Checkout Progress</h4></div>
            <div class="col-9 progress p-0 text-center" style="height: 30px; font-size: 1rem;">
                <div class="progress-bar progress-bar-striped progress-bar-animated bg-success" id="check-prog" name="check-prog" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%"></div>
            </div>
                <div class="col-12 text-center">
                    <b style="padding-top: 5px;">60% [Step 3 of 5]</b>
                </div>
        </div>
        <div class="row justify-content-center">

            <div class="col-md-8 align-content-center align-items-center" style="margin-bottom: 30px;">
                <div class="row justify-content-center">
                    <div class="col-md-4 mx-5">
                        <h3 class="mt-3"><b>Shipping Details</b></h3>
                        <p style="margin-left:20px;">Zak Rowton<br>502 E. Rickenbacker Dr.<br>Oklahoma City, OK 73110<br>United States</p>
                    </div>
                    <div class="col-md-4 mx-5">
                        <h3 class="mt-3"><b>Contact Details</b></h3>
                        <p style="margin-left:20px;"><b>Email</b><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;zakr@bealscunningham.com<br><b>Phone</b><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;+1 (817) 899-8723</p>
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

                    <div class="row justify-content-end mt-4">
                        <span class="col-md-12">
                            <h5><b>No Coupon Code Added</b></h5>
                            <a href="checkout?action=step-2" class="ml-0">
                                <button type="button" class="btn btn-primary btn-sm">Apply Coupon</button>
                            </a>
                        </span>
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

                    <div class="ibox-content" style="text-align: right;">
                        <div style="text-align: right; font-weight: bold">Select Pickup / Shipping Method<br><br></div>
                        <form name="shipssels" id="shipssels" method="post" action="" novalidate="novalidate">
                            <script>$(".tax_inplace").html("$0.00");</script>
                            <div class="alert alert-danger" style="text-align: left">
                                <h3>Pickup Only!</h3>
                                <p>Your items are shown to be in-store pickup only.<br>Please select a store to pickup your order at.</p>
                            </div>
                            <script>select_pickup_location();</script>
                            <select name="pickup_location" id="pickup_location" class="form-control" required="required">
                                <option value="">Select Pickup Location</option>
                                <option value="8">Butler</option>
                                <option value="9">Ebensburg</option>
                                <option value="10">Martinsburg</option>
                                <option value="11">New Alexandria</option>
                                <option value="12">Somerset</option>
                            </select>
                        </form>
                    </div>

                    <div class="row justify-content-end mt-4">
                        <span style="font-style: bold;">
                            <b>Sub Total:</b>
                        </span>
                    </div>

                    <div class="row justify-content-end">
                        <h4 class="font-bold" id="price-total">
                            $' . number_format($cartTrueTotal, 2, '.', ',') . '
                        </h4>
                    </div>

                    <div class="row mt-5 text-center justify-content-end" style="margin-top: 50px;">
                        <div class="col-md-3 mx-3">
                            <a class="btn btn-white my-2" href="checkout?action=step-2">
                                <i class="fa fa-arrow-left" aria-hidden="true"></i> 
                                Go Back
                            </a> 
                        </div>

                        <div class="col-md-3 ml-3">
                            <a onclick="Checkout_Step3()" class="btn btn-success thecheckout float-right pl-2 my-2 text-white">
                                <i class="fa fa fa-shopping-cart" aria-hidden="true"></i> 
                                Continue
                            </a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>';

    echo $html;
}

if ($action == "step-4") {
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

    if (isset($_POST['discountCode'])) {
        $coupon_code = $_POST['discountCode'];
    }
    $cartTotal = $cartDataJSON[0]['cart_total'];
    $cartTrueTotal = intval($tax) + intval($cartTotal);

    $html = '
    <style>
        .bg-success {
            background-color: #367c2b !important;
        }
    </style>
    <script src="inc/mods/custom_equipment/checkout_functions.js" crossorigin="anonymous"></script>
    <script src="inc/mods/custom_equipment/custom_functions.js" crossorigin="anonymous"></script>

    <div class="container my-5 wrapper wrapper-content checkout-content">
        <div class="row justify-content-center mb-5">
            <div class="col-12 text-center"><h4>Checkout Progress</h4></div>
            <div class="col-9 progress p-0 text-center" style="height: 30px; font-size: 1rem;">
                <div class="progress-bar progress-bar-striped progress-bar-animated bg-success" id="check-prog" name="check-prog" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: 80%"></div>
            </div>
                <div class="col-12 text-center">
                    <b style="padding-top: 5px;">80% [Step 4 of 5]</b>
                </div>
        </div>
        <div class="row justify-content-center">
            <style>
                .card-form {
                    background: #efefef;
                    padding: 20px;
                    border-radius: 15px;
                }
                input[type=checkbox]:after {
                    background: none;
                    height: 100%;
                    width: 100%;
                    font-family: "Font Awesome\ 5 Free";
                    display: inline-block;
                    content: "\2b";
                    letter-spacing: 10px;
                    font-weight: bold;
                    font-size: 30px;
                    color: #a6a6a6;    
                    position: relative;
                    -webkit-appearance: none;
                    -moz-appearance: none;
                }
            </style>
            <div class="col-md-8" style="margin-bottom: 30px;">
                <div class="row card-form">{form}Credit_Card_Details{/form}</div>
                <div class="row justify-content-center mt-2">
                    <div class="col-md-4 mx-3">
                        <h3 class="mt-3"><b>Shipping Details</b></h3>
                        <p style="">' . $firstName . ' ' . $lastName . '<br>' . $Addr . '<br>' . $Addr2 . '<br>' . $city . ', ' . $state . ' ' . $zip . '<br>United States</p>
                    </div>
                    <div class="col-md-4 mx-3">
                        <h3 class="mt-3"><b>Contact Details</b></h3>
                        <p style=""><b>Email</b><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $email . '
                        <br>
                        <b>Phone</b><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $phone . '</p>
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

                    <div class="row justify-content-end mt-4">
                            <p><b>No Coupon Code Added</b></p>
                    </div>

                    <div class="discountapply ibox-content mt-1">
                        <table class="table shoping-cart-table">
                            <tbody>
                                <tr>
                                    <td style="padding: 10px">Tax:</td>
                                    <td class="tax_inplace" style="padding: 10px;text-align: right">$' . number_format($tax, 2, '.', ',') . '</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="row justify-content-end mt-4">
                        <span style="font-style: bold;">
                            <b>Sub Total:</b>
                        </span>
                    </div>

                    <div class="row justify-content-end">
                        <h4 class="font-bold" id="price-total">
                            $' . number_format($cartTrueTotal, 2, '.', ',') . '
                        </h4>
                    </div>

                    <div class="row mt-5 text-center justify-content-end" style="margin-top: 50px;">
                        <div class="col-md-3 mx-3">
                            <a class="btn btn-white my-2" href="checkout?action=step-3">
                                <i class="fa fa-arrow-left" aria-hidden="true"></i> 
                                Go Back
                            </a> 
                        </div>

                        <div class="col-md-5 ml-3">
                            <a onclick="Checkout_Step4()" class="btn btn-success thecheckout float-right pl-2 my-2 text-white">
                                <i class="fa fa fa-shopping-cart" aria-hidden="true"></i> 
                                Place Your Order
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>';

    echo $html;
}
