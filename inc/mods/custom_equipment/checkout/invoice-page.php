<?php

use ShipEngine\ShipEngine;

error_reporting(E_ALL);
ini_set('display_errors', '1');
include('config.php');
include('../settings/settings.php');
include('../shipping/shipping-interface.php');
include('../shipping/shippo-handler.php');
include('../shipping/ship-engine-handler.php');
include('../shipping/shipping_handler.php');
include('../tax/zip-tax-handler.php');
$tax_handler = new ZipTaxHandler();

$settings = new EStore_Settings();
$default_shipping_location_ID = $settings->DEFAULT_SHOP_LOCATION;

$shipping = new ShippingHandler();
$engine = new ShipEngineHandler();

$currentDate = date('d M, Y');
$first_name = $_POST['firstName'];
$last_name = $_POST['lastName'];
$street1 = $addr;
$street2 = $addr2;
$city = $city;
$state = $state;
$zip = $zip;
$dateTime = new DateTime();
$currentTimestamp = $dateTime->getTimestamp();

$service_code = "stdn"; //$_COOKIE['shippingData']['service_code'];
$shipping_charges = $engine->EstimateCartShippingCharges("Zak Rowton", $street1, $street2, $city, $state, $zip, $phone, $email, $service_code, true);
echo var_dump($shipping_charges);
$labels = $engine->CreateCartShippingLabels("Zak Rowton", $street1, $street2, $city, $state, $zip, $phone, $email);
//echo var_dump($labels);

//Shipping Labels
$label_urls = array();
$weight_tracker = 0.0;
$length_tracker = 0.0;
$width_tracker = 0.0;
$height_tracker = 0.0;

$invoice_number = generateOrderID();
$status = 'succeeded'; //$token['status'];

$cookieJson = json_decode($_COOKIE['cartData'], true);
$cartItems = $cookieJson[0]['cartItems'];
$ship_type = $cookieJson[0]['pickup'] == true ? "pickup_only" : "api_system";
$sub_total = 0;
$discount_total = 0;

//Receipt Settings -------
$a = $data->query("SELECT * FROM custom_equipment_receipt_settings WHERE id = 1");
$receipt_settings = $a->fetch_array();

$receipt_subject = $receipt_settings['receipt_subject'];
$receipt_success_msg = $receipt_settings['receipt_headline'];
$receipt_sales_message = $receipt_settings['receipt_sales_message'];
$receipt_logo = str_replace('../', '', $receipt_settings['receipt_img']);
//-------------------------

//------- SUCCESS/FAIL ALERT
$html = '
    <div class="row justify-content-center">
        <div class="col-md-9">';
if ($status == 'succeeded') {
    //Payment Was Successful
    $html .= '<div class="alert alert-success" role="alert">
                ' . $receipt_success_msg . '
            </div>';

    $invoiceStatus = "Successful Payment";
} else {
    //Failed Payment
    $html .= '<div class="alert alert-danger" role="alert">
                <b>There Was An Issue Processing Your Payment!</b><br><br>
                Your payment failed to process.<br>
            </div>';
    $invoiceStatus = "Failed Payment";
}
$html .= '</div>
    </div>';

if ($status != 'succeeded') {
    echo $html;
}

//-------- INVOICE RECEIPT
$html .= '
<div class="printable-content">
    <div class="row justify-content-center">
        <div class="col-lg-9">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-10">
                            <h3>' . $receipt_subject . '</h3>
                        </div>
                        <div class="col-md-2 mb-4">
                            <h4 class="float-right font-size-15">
                                <span class="badge bg-success font-size-12 ms-2 text-light ">
                                    Successful Payment
                                </span>
                            </h4>
                        </div>
                    </div>
                    <div class="invoice-title row justify-content-between">
                        <div class="col-md-6 mb-4 p-3 pr-5">
                            <img class="navbar-logo img-responsive" src="' . $receipt_logo . '" alt="Stellar Equipment Logo" style="max-width: 450px;" />
                        </div>
                        <div class="col-md-6 pl-5">
                            <div class="text-muted text-sm-end">
                                <div class="row">
                                    <h5 class="col-12 font-size-15 mb-1">Invoice No:</h5><br>
                                    <p>#' . $invoice_number . '</p>
                                </div>
                                <div class="row mt-4">
                                    <h5 class="col-12 font-size-15 mb-1">Invoice Date:</h5>
                                    <p>' . $currentDate . '</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="text-muted">
                                <h5 class="font-size-16 mb-3"><b>' . ($ship_type == "pickup_only" ? "Pickup" : "Shipping") . ' Location:</b></h5>';
if ($ship_type == "pickup_only") {
    //Get Pickup Location Address
    if (intval($cookieJson[0]['shop_location']) == -1) {
        //Default Shipping Location
        $p = $data->query("SELECT * FROM location WHERE id = '" . $default_shipping_location_ID . "'") or die($data->error);
        $pickup_location = $p->fetch_assoc();
        $emailJson = json_decode($pickup_location['location_emails'], true);
        $phoneJson = json_decode($pickup_location['location_phones'], true);

        $html .= '<p class="mb-1">' . $pickup_location['location_name'] . '</p>
                    <p class="mb-1">' . $pickup_location['location_address'] . '</p>
                    <p class="mb-1">' . $pickup_location['location_city'] . ', ' . $pickup_location['location_state'] . ' ' . $pickup_location['location_zip'] . '</p>
                    <p class="mb-1"><i class="uil uil-envelope-alt me-1"></i> ' . $emailJson[0]['emailOut'] . '</p>
                    <p><i class="uil uil-phone me-1"></i> ' . $phoneJson[0]['phoneNum'] . '</p>';
    } else {
        //Shipping Location Selected
        $p = $data->query("SELECT * FROM location WHERE id = '" . $cookieJson[0]['shop_location'] . "'") or die($data->error);
        $pickup_location = $p->fetch_assoc();
        $emailJson = json_decode($pickup_location['location_emails'], true);
        $phoneJson = json_decode($pickup_location['location_phones'], true);

        $html .= '<p class="mb-1">' . $pickup_location['location_name'] . '</p>
                        <p class="mb-1">' . $pickup_location['location_address'] . '</p>
                        <p class="mb-1">' . $pickup_location['location_city'] . ', ' . $pickup_location['location_state'] . ' ' . $pickup_location['location_zip'] . '</p>
                        <p class="mb-1"><i class="uil uil-envelope-alt me-1"></i> ' . $emailJson[0]['emailOut'] . '</p>
                        <p><i class="uil uil-phone me-1"></i> ' . $phoneJson[0]['phoneNum'] . '</p>';
    }
} else {
    if (intval($cookieJson[0]['shop_location']) == -1) {
        //Default Shipping Location
        $p = $data->query("SELECT * FROM location WHERE id = '" . $default_shipping_location_ID . "'") or die($data->error);
        $pickup_location = $p->fetch_assoc();
        $emailJson = json_decode($pickup_location['location_emails'], true);
        $phoneJson = json_decode($pickup_location['location_phones'], true);

        $html .= '<p class="mb-1">' . $pickup_location['location_name'] . '</p>
                <p class="mb-1">' . $pickup_location['location_address'] . '</p>
                <p class="mb-1">' . $pickup_location['location_city'] . ', ' . $pickup_location['location_state'] . ' ' . $pickup_location['location_zip'] . '</p>
                <p class="mb-1"><i class="uil uil-envelope-alt me-1"></i> ' . $emailJson[0]['emailOut'] . '</p>
                <p><i class="uil uil-phone me-1"></i> ' . $phoneJson[0]['phoneNum'] . '</p>';
    } else {
        //Shipping Location Selected
        $p = $data->query("SELECT * FROM location WHERE id = '" . $cookieJson[0]['shop_location'] . "'") or die($data->error);
        $pickup_location = $p->fetch_assoc();
        $emailJson = json_decode($pickup_location['location_emails'], true);
        $phoneJson = json_decode($pickup_location['location_phones'], true);

        $html .= '<p class="mb-1">' . $pickup_location['location_name'] . '</p>
                    <p class="mb-1">' . $pickup_location['location_address'] . '</p>
                    <p class="mb-1">' . $pickup_location['location_city'] . ', ' . $pickup_location['location_state'] . ' ' . $pickup_location['location_zip'] . '</p>
                    <p class="mb-1"><i class="uil uil-envelope-alt me-1"></i> ' . $emailJson[0]['emailOut'] . '</p>
                    <p><i class="uil uil-phone me-1"></i> ' . $phoneJson[0]['phoneNum'] . '</p>';
    }
}
$html .= '</div>
                        </div>
                        <div class="col-md-6">
                            <div class="text-muted">
                                <h5 class="font-size-16 mb-3"><b>Billed To:</b></h5>
                                <h6 class="font-size-15 mb-2">' . $billing_first_name . ' ' . $billing_last_name . '</h6>
                                <p class="mb-1">' . $billing_address . '<br>' . $billing_city . ', ' . $billing_state . ' ' . $billing_zip . '</p>
                                <br>
                                <p class="mb-1">' . $email . '</p>
                                <p>' . $phone . '</p>
                            </div>
                        </div>
                    </div>

                    <hr class="my-4">

                    <div class="row">
                        <div class="col-md-12">
                            <p>' . $receipt_sales_message . '</p>
                        </div>
                    </div>
                    
                    <div class="row py-2">
                        <h5 class="font-size-15">Order Summary</h5>

                        <div class="col-md-12 table-responsive">
                            <table class="table align-middle table-nowrap table-centered mb-0">
                                <thead>
                                    <tr>
                                        <th style="width: 250px;">Item</th>
                                        <th>Price</th>
                                        <th>Quantity</th>
                                        <th>Total</th>
                                    </tr>
                                <tbody>';

//CALCULATE CART TOTALS + WEIGHT OF ALL PRODUCTS
$total_weight = 0;
$items = array();

foreach ($cartItems as $item) {
    $totalPriceOfItems = (doubleval($item['price']) * intval($item['qty']));
    $prod = $data->query("SELECT * FROM custom_equipment WHERE id = " . $item['id'] . "") or die($data->error);
    $product = $prod->fetch_array();

    //Check if Shipping Allowed
    if ($item['ship_type'] == 'api_system') {
        $weight = doubleval($product['weight']) * intval($item['qty']);
        $total_weight = doubleval($total_weight) + doubleval($weight);
    }

    $array = array(
        "id" => $item['id'],
        "name" => $item['name'],
        "price" => $item['price'],
        "qty" => $item['qty'],
        "dimentions" => $product['dimentions'],
        "weight" => $product['weight']
    );

    array_push($items, $array);

    $html .= '<tr>
                <td>
                     ' . $item['name'] . '
                </td>
                <td>$' . $item['price'] . '</td>
                <td>' . $item['qty'] . '</td>
                <td class="text-end">$' . $totalPriceOfItems . '</td>
            </tr>';

    $applied_discount = (doubleval($item['applied_discount']) * doubleval($item['price'])) * intval($item['qty']);
    $discount_total = doubleval($discount_total) + doubleval($applied_discount);
    $sub_total = doubleval($sub_total) + doubleval($totalPriceOfItems);
}

$tax = (floatval($tax_handler->GetTaxRateByZipCode($zip)) * floatval($sub_total));

if ($ship_type == "api_system") {
    //Calculate Shipping + Create Labels
    $isPickup = false;
    if (doubleval($total_weight) > 0) {
        $total_weight = doubleval($total_weight);
    } else {
        //Pickup Only
        $isPickup = true;
    }

    $ship = 'test'; //$shipping->CreateShippingLabel(($first_name . ' ' . $last_name), $street1, $street2, $city, $state, $zip, 1, 1, 1, "in", $total_weight, "lb", $phone, $email);
    array_push($label_urls, array("url" => $ship));
    $shipCost = 0; //$shipping->CalculateShippingCharges(($first_name . ' ' . $last_name), $street1, $street2, $city, $state, $zip, $phone, $email);
    $shipping_cost = doubleval($shipCost);
    //END CALCULATE SHIPPING + CREATE LABELS
}


//DISPLAY TOTALS
// - SUB-TOTAL      [TOTAL BEFORE DISCOUNTS & TAX]
// - DISCOUNT-TOTAL [TOTAL APPLIED DISCOUNTS]
// - SHIPPING-TOTAL [TOTAL COST OF SHIPPING (IF NOT PICKUP)]
// - TOTAL          [TRUE TOTAL AFTER TAX/SHIPPING & DISCOUNTS]
$true_total = (floatval($sub_total) - floatval($discount_total)) + floatval($tax);

//Check If Need To Add Shipping Cost
if ($ship_type == "api_system") {
    $true_total = doubleval($true_total) + doubleval($shipping_charges);
}


$html .= '                          </tbody>
                                </table>
                            <hr>
                        </div>
                        
                        <div class="text-end row mt-3">
                                <table class="float-right">
                                    <tbody>
                                        <tr class="mt-5">
                                            <th scope="row" colspan="4" class="text-end">Sub Total :</th>
                                            <td class="text-end">$' . number_format($sub_total, 2, '.', ',') . '</td>
                                        </tr>';

if (doubleval($discount_total) > 0) {
    $html .= '<tr>
                                        <th scope="row" colspan="4" class="border-0 text-end">
                                                Discount :</th>
                                            <td class="border-0 text-end">- $' . number_format($discount_total, 2, '.', ',') . '</td>
                                        </tr>';
}

$html .= '
                                        <tr>
                                            <th scope="row" colspan="4" class="border-0 text-end">Shipping Charge :</th>
                                            <td class="border-0 text-end">' . ($ship_type == "api_system" ? '$' . number_format($shipping_charges, 2, '.', ',') : "<span class=\"text-danger\">In-Store Pickup</span>") . '</td>
                                        </tr>
                                        
                                        <tr>
                                            <th scope="row" colspan="4" class="border-0 text-end">
                                                Tax :</th>
                                            <td class="border-0 text-end">$' . number_format($tax, 2, '.', ',') . '</td>
                                        </tr>
                                        

                                        <tr class="mt-4">
                                            <th scope="row" colspan="4" class="border-0 text-end"><h3>Total :</h3></th>
                                            <td class="border-0 text-end"><h3 class="m-0 fw-semibold">$' . number_format($true_total, 2, '.', ',') . '</h3></td>
                                        </tr>
                                    </tbody>
                                </table>
                        </div>
                    </div>
                    <div class="row justify-content-end d-print-none mt-4">
                        <div class="col-md-3">
                            <a onclick="printContent()" class="btn btn-success me-1" style="color: white;"><i class="fa fa-print"></i></a>
                            <a href="EStore" class="btn btn-success w-md">Continue Shopping</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>';

//Create New Order In DB
try {
    $tracking_no = '98798sd-2342-23423nkj-23423';
    $itemsJson = json_encode($items, true);
    $sql = "INSERT INTO `custom_equipment_shop_orders` (`purchase_num`, `first_name`, `last_name`, `email`, `phone`, `address`, `city`, `state`, `zip`, `ship_address`, `ship_city`, `ship_state`, `ship_zip`, `pickup_location`, `order_notes`, `items_list`, `purchase_price`, `date_sub`, `status`, `applied_tax`, `ship_type`, `ship_cost`, `ship_label_url`, `receipt`, `discounts`, `tracking_number`, `meta_deta`) VALUES ('" . $invoice_number . "', '" . $first_name . "', '" . $last_name . "', '" . $email . "', '" . $phone . "', '" . $street1 . " " . $street2 . "', '" . $city . "', '" . $state . "', '" . $zip . "', '" . $billing_address . "', '" . $billing_city . "', '" . $billing_state . "', '" . $billing_zip . "', '" . $cookieJson[0]['shop_location'] . "', 'no order notes', '" . $itemsJson . "', '" . number_format($true_total, 2, '.', ',') . "', " . $currentTimestamp . ", 'Pending', '" . $tax . "', '" . $ship_type . "', '" . $shipping_charges . "', '" . json_encode($labels) . "', '" . $html . "', '[{}]', '234234234234', '[{}]');";
    // Prepare the SQL statement
    $stmt = $data->query($sql);
} catch (PDOException $e) {
    // Handle any exceptions thrown during query execution
    echo "Error: " . $e->getMessage();
}

echo $html;

/////// -------- HELPER FUNCTIONS ------- ////////

function generateOrderID()
{
    $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $orderId = '';
    $length = strlen($characters);

    // Generate a random 8-character order ID
    for ($i = 0; $i < 8; $i++) {
        $orderId .= $characters[rand(0, $length - 1)];
    }

    return $orderId;
}
