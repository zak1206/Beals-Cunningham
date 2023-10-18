<?php

class ElavonHandler
{
    public function __construct()
    {
    }

    public function ProcessElavonPayment($endpoint, $merchantId, $merchantUser, $merchantPin)
    {
        // Set variables
        $merchantID = $merchantId; //Converge 6 or 7-Digit Account ID *Not the 10-Digit Elavon Merchant ID*
        $merchantUserID = $merchantUser; //Converge User ID *MUST FLAG AS HOSTED API USER IN CONVERGE UI*
        $merchantPIN = $merchantPin; //Converge PIN (64 CHAR A/

        $url = $endpoint; // URL to Converge production session token server

        // Read the following querystring variables
        $firstname = $_POST['ssl_first_name']; //Post first name
        $lastname = $_POST['ssl_last_name']; //Post first name
        $amount = $_POST['ssl_amount']; //Post Tran Amount

        $ch = curl_init();    // initialize curl handle
        curl_setopt($ch, CURLOPT_URL, $url); // set url to post to
        curl_setopt($ch, CURLOPT_POST, true); // set POST method
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        // Set up the post fields. If you want to add custom fields, you would add them in Converge, and add the field name in the curlopt_postfields string.
        curl_setopt(
            $ch,
            CURLOPT_POSTFIELDS,
            "ssl_merchant_id=$merchantID" .
                "&ssl_user_id=$merchantUserID" .
                "&ssl_pin=$merchantPIN" .
                "&ssl_transaction_type=ccsale" .
                "&ssl_first_name=$firstname" .
                "&ssl_last_name=$lastname" .
                "&ssl_get_token=Y" .
                "&ssl_add_token=Y" .
                "&ssl_amount=$amount"
        );

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_VERBOSE, true);

        $result = curl_exec($ch); // run the curl procss
        curl_close($ch); // Close cURL

        return $result;  //shows the session token.
    }

    public function CompleteElavonPurchase()
    {
        include('config.php');
        session_start();

        // CUSTOMER BILLING DETAILS //
        $bill_fname = $_POST["bill_fname"];
        $bill_lname = $_POST["bill_lname"];
        $bill_address = $_POST["bill_address"];
        $bill_city = $_POST["bill_city"];
        $bill_state = $_POST["bill_state"];
        $bill_zip = $_POST["bill_zip"];


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
        } else {
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

            $chkz = $data->query("SELECT setting_value FROM shop_settings WHERE setting_name = 'sell_per_qty'");
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
        $taxset = $data->query("SELECT setting_value FROM shop_settings WHERE setting_name = 'do_tax_stuff'");
        $taxGet = $taxset->fetch_array();
        if ($taxGet["setting_value"] == 'true') {

            $locSet = $data->query("SELECT setting_value FROM shop_settings WHERE setting_name = 'location_select'");
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

        // ADD SOME SHIPPING PRICE IF SELECTED //
        if ($shipping_price != '') {
            $countOutDone = $countOutFin + $tax + $shipping_price;
        } else {
            $countOutDone = $countOutFin + $tax;
        }

        // DO SHIPPING THINGS //
        // - Get Shipping Label
        // - Get Tracking Number

        // GENERATE PURCHASE NUMBER //
        $purcahseNum = $this->random19();
        $countOutDone = number_format($countOutDone, 2);

        // CREATE INVOICE //
        $data->query("INSERT INTO custom_equipment_shop_orders SET purchase_num = '" . $data->real_escape_string($purcahseNum) . "', store_location = '" . $data->real_escape_string($shop_location) . "', first_name = '" . $data->real_escape_string($bill_fname) . "', last_name = '" . $data->real_escape_string($bill_lname) . "', email = '" . $data->real_escape_string($shipping_email) . "', phone = '" . $data->real_escape_string($shipping_phone) . "', address = '" . $data->real_escape_string($bill_address) . "', city = '" . $data->real_escape_string($bill_city) . "', state = '" . $data->real_escape_string($bill_state) . "', zip = '" . $data->real_escape_string($bill_zip) . "', ship_address = '" . $data->real_escape_string($shipping_address) . "', ship_city = '" . $data->real_escape_string($shipping_city) . "', ship_state = '" . $data->real_escape_string($shipping_state) . "', ship_zip = '" . $data->real_escape_string($shipping_zip) . "', items_list = '" . $data->real_escape_string($cartData) . "', purchase_price = '" . $data->real_escape_string($countOutDone) . "', ship_price = '$shipping_price', discount_applied = '" . $data->real_escape_string($discount_applied) . "', applied_tax = '" . $data->real_escape_string($tax) . "', ship_type = '" . $data->real_escape_string($cartItems["shipping_type"]) . "', ship_label_url = '" . $data->real_escape_string($ship_label) . "', ship_tracking = '" . $data->real_escape_string($ship_track) . "', date_sub = '" . time() . "'") or die($data->error);

        // INVOICE EMAIL TO CUSTOMER START===================
        include('siteFunctions.php');
        $process = new site();
        $emailtime = date("m/d/Y");

        if ($shipping_email != '') {
            $name = $bill_fname . ' ' . $bill_lname;
            $to[] = array("email" => $shipping_email, "name" => $name);
        }

        $dealerEmail1[] = array("email" => "ecommerce@westcentraleq.com", "name" => "West Central Equipment");
        $a = $data->query("SELECT * FROM location WHERE id = '$shop_location'");
        $b = $a->fetch_array();
        $invoceTable = $data->query("SELECT * FROM invoice_settings WHERE id = 1");
        $invoceTableDetails = $invoceTable->fetch_array();
        $shoppingDetails = stripslashes(trim($cartData, '"'));
        $purchaseDetails = json_decode($shoppingDetails, true);
        $fromemail = "system@bcssdevelopment.com";
        $fromName = "West Central Equipment Invoice";
        $subject = $invoceTableDetails["invoice_subject"];
        $invoiceHeaderImg = str_replace("../", "/", $invoceTableDetails["invoice_img"]);

        if ($shipping_details["shipping_method"] == "Customer Pickup") {
            $loc_data = $data->query("SELECT * FROM location WHERE location_name = '$pickup_location'");
            $loc_data_val = $loc_data->fetch_array();
            $shipping_data = '<p style="margin-bottom: 5px">Pickup Address<br><b>West Central Equipment <br>' . $loc_data_val["location_address"] . '<br />' . $loc_data_val["location_city"] . ' ' . $loc_data_val["location_state"] . ', ' . $loc_data_val["location_zip"] . '</b></p>';
            $shipping_price = number_format(0, 2);
        } else {
            $shipping_data = '<p style="margin-bottom: 5px">Shipping Address<br><b>' . $shipping_address . '<br />' . $shipping_city . ' ' . $shipping_state . ', ' . $shipping_zip . '</b></p>';
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
    <a href="https://www.westcentraleq.com/"><img src="https://www.westcentraleq.com' . $invoiceHeaderImg . '" alt="Website Logo"></a>
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
        <p style="margin-bottom: 5px">Billed To<br>
        <b>' . $bill_address . '<br />' . $bill_city . ' ' . $bill_state . ', ' . $bill_zip . '<br /><i>' . $shipping_email . '</i><br />' . $shipping_phone . '</b
          >
        </p>
      </td>
      <td>
        ' . $shipping_data . '
        <p style="margin-bottom: 5px">
          Store Location: <br /><b>' . $b["location_name"] . '</b>
        </p>
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
        $message .= $discountEmail . '<tr>
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
                    </html>';

        $process->mailIt($to, $fromemail, $fromName, $subject, $message);
        $process->mailIt($dealerEmail1, $fromemail, $fromName, $subject, $message);
        $process->mailIt($dealerEmail2, $fromemail, $fromName, $subject, $message);
        // INVOICE EMAIL TO CUSTOMER END=====================

        //Reset Cart-Data COOKIE
        unset($_COOKIE["cartData"]);
        setcookie("cartData", "", time() - (60 * 60 * 24), "/");

        //Get success message
        $a = $data->query("SELECT information FROM shop_settings WHERE setting_name = 'payment_success'");
        $b = $a->fetch_array();
        $messOuts = $b["information"] . '<br>Your Order <a onclick =\"printTheOrder()\" href=\"javascript:void(0)\">#: ' . $purcahseNum . '</a>';

        return '{"ret_status": "good","ret_message": "<b>Payment Successful</b><br><p>' . $messOuts . '</p>"}';
    }

    private function random19()
    {
        $today = date("Ymd");
        $rand = strtoupper(substr(uniqid(sha1(time())), 0, 4));
        return $unique = $today . $rand;
    }
}
