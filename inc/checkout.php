<?php
session_start();
$cartRaw = $_COOKIE["savedData"];
$cartItems = json_decode($_COOKIE["savedData"], true);
?>

<?php
if (!empty($cartItems)) {

    require 'stripe/init.php';
    if (isset($_POST["cctype"])) {


        function random19()
        {
            $number = "";
            for ($i = 0; $i < 19; $i++) {
                $min = ($i == 0) ? 1 : 0;
                $number .= mt_rand($min, 9);
            }
            return $number;
        }

        $purcahseNum = random19();

        $person = $_POST["first_name"] . ' ' . $_POST["last_name"];

        // $curl = new \Stripe\HttpClient\CurlClient([CURLOPT_SSLVERSION => CURL_SSLVERSION_TLSv1]);
        // \Stripe\ApiRequestor::setHttpClient($curl);
        // \Stripe\Stripe::setApiKey("sk_live_0GiPeFwxMeoahNXtv99l7byU");
        $error = '';
        $success = '';
        try {
            if (!isset($_POST['stripeToken']))
                throw new Exception("The Stripe Token was not generated correctly");
            \Stripe\Charge::create(array(
                "amount" => $_POST["prod_cost"],
                "currency" => "usd",
                "description" => "Agrivision Purchase - " . $person . " - " . $purcahseNum,
                "card" => $_POST['stripeToken']
            ));
            ///echo'Your payment was successful.';
            ///
            include('config.php');
            $post = $_POST;
            if (isset($post["ship_same"])) {
                $ship_address = $post["address"];
                $ship_city = $post["city"];
                $ship_state = $post["state"];
                $ship_zip = $post["zip"];
            } else {
                $ship_address = $post["ship_address"];
                $ship_city = $post["ship_city"];
                $ship_state = $post["ship_state"];
                $ship_zip = $post["ship_zip"];
            }

            //ORDER INFO//

            $thePurchaseIn .= '<table class="table" style="width: 100%">
        <thead style="background:#363737; color:#fff">
        <tr>
            <th>Product</th>
            <th>Total</th>
            <th></th>
        </tr>
        </thead>
        <tbody>';
            $countOut = 0;
            $taxrate = 6.0;

            for ($i = 0; $i < count($cartItems); $i++) {
                $itemPrice = $cartItems[$i]["machine"]["price"];
                $thePurchaseIn .= '<tr><td>' . ucwords($cartItems[$i]["machine"]["eqtype"]) . ' - ' . $cartItems[$i]["machine"]["name"] . '</td><td>$' . $cartItems[$i]["machine"]["price"] . '<input type="hidden" id="prod_item" name="prod_item" value="2 16 OZ JARS"></td><td></td></tr>';
                $countOut += $itemPrice;
            }

            $tax = round((($countOut * $taxrate) / 100), 2);
            $total = $countOut + $tax;

            $thePurchaseIn .= ' <tr><td></td><td><strong>Subtotal</strong></td><td>$' . number_format($countOut, 2) . '</td></tr>
        <tr><td style="border-top:0"></td><td><strong>Tax</strong></td><td>$' . $tax . '</td></tr>
        <tr><td style="border-top:0"></td><td><strong>Total: </strong></td><td><strong>$' . number_format($total, 2) . '</strong></td></tr>
        </tbody>
    </table>';



            $data->query("INSERT INTO shop_orders SET purchase_num = '" . $data->real_escape_string($purcahseNum) . "', first_name = '" . $data->real_escape_string($post["first_name"]) . "', last_name = '" . $data->real_escape_string($post["last_name"]) . "', email = '" . $data->real_escape_string($post["email"]) . "', phone = '" . $data->real_escape_string($post["phone"]) . "', address = '" . $data->real_escape_string($post["address"]) . "', city = '" . $data->real_escape_string($post["city"]) . "', state = '" . $data->real_escape_string($post["state"]) . "', zip = '" . $data->real_escape_string($post["zip"]) . "',  ship_address = '" . $data->real_escape_string($ship_address) . "', ship_city = '" . $data->real_escape_string($ship_city) . "', ship_state = '" . $data->real_escape_string($ship_state) . "', ship_zip = '" . $data->real_escape_string($ship_zip) . "', order_notes = '" . $data->real_escape_string($post["order_notes"]) . "', items_list = '" . $data->real_escape_string($thePurchaseIn) . "', purchase_price = '" . $data->real_escape_string(number_format($total, 2)) . "', date_sub = '" . time() . "'") or die($data->error);

            $eq = json_encode($_COOKIE["savedData"]);
            unset($_COOKIE["savedData"]);
            setcookie("savedData", "", time() - (60 * 60 * 24), "/");



            ////MAIL RECEIPT///
            ///
            require 'phpmail/PHPMailerAutoload.php';
            date_default_timezone_set('UTC');

            $mail = new PHPMailer;

            $fromemail = 'orders@agrivisionequipment.com';
            $fromName = 'Agrivision Equipment Orders';

            $toArs[] = array("email" => "jasonc@bealscunningham.com", "name" => "Jason Cotton");

            //MAY NEED TO BE ENABLED FOR LIVE SERVER $mail->isSMTP();

            // 0 = off (for production use)
            // 1 = client messages
            // 2 = client and server messages
            $mail->SMTPDebug = 0;
            $mail->Debugoutput = 'html';
            $mail->Host = "smtpout.secureserver.net";
            $mail->Port = 80;
            $mail->SMTPAuth = true;
            $mail->Username = "dev@bcssdevelopment.com";
            $mail->Password = "BCss1957"; ///SHHHHHH! This is a secrete////
            $mail->setFrom($fromemail, $fromName);

            $mail->addReplyTo($fromemail, $fromName);

            for ($i = 0; $i <= count($toArs); $i++) {
                if ($toArs[$i]["name"] != '' && $toArs[$i]["email"] != '') {
                    $mail->addAddress($toArs[$i]["email"], $toArs[$i]["name"]);
                }
            }

            $message .= '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd"><html lang="en"><head> <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"> <meta name="viewport" content="width=device-width, initial-scale=1"> <meta http-equiv="X-UA-Compatible" content="IE=edge"> <title></title> <style type="text/css"> </style> </head><body style="margin:0; padding:0;">';
            $message .= '<div style="padding: 20px"><h2>Order Summary</h2></div>';
            $message .= '<div style="padding: 20px"><table width="50%" border="0" cellpadding="0" cellspacing="0">';

            $message .= '<img style="width:250px" src="https://bcssdevelop.com/img/logo-desktop.png"><br><br>';

            $message .= '<div><strong>Thank you for your purchase!</strong><br><p>We have received your order and will begin to process it shortly. <br>We will also be in contact with you regarding your purchase delivery.<br><br><strong>Your purchase number is: ' . $purcahseNum . '</strong><br><br>
<table style="width: 100%">
<tr><td>Purchaser: </td><td>' . $_POST["first_name"] . ' ' . $_POST["last_name"] . '</td></tr>
<tr><td>Email: </td><td>' . $_POST["email"] . '</td></tr>
<tr><td>Phone: </td><td>' . $_POST["phone"] . '</td></tr>
<tr><td>Billing Address: </td><td>' . $_POST["address"] . '<br>' . $_POST["city"] . ' ' . $_POST["state"] . ', ' . $_POST["zip"] . '</td></tr>

</table><br>';

            $message .= '</table><br><br><h2>Items Purchased</h2><br>' . $thePurchaseIn . '</div></div>';
            $message .= '</body></html>';


            $mail->Subject = 'Agrivision Equipment Order';
            $mail->msgHTML($message);

            if (!$mail->send()) {
                //                ///echo "<div class='alert alert-danger'>Mailer Error: " . $mail->ErrorInfo . "</div>";
                //                return false;
            } else {
                //                //echo "<div class='alert alert-success'><strong>Thank You - We have received your message and will get back with you shortly.</strong></div>";
                //                return true;
            }




            echo '<script>$(function(){$(".removit").hide(); $.ajax({ url: "inc/ajaxCalls.php?action=destroycart",cache:false,success: function(data){   $(".shopping-cart-items").html(\'<span style="font-style: italic">Nothing In Your Cart...</span>\'); $(".sav-nums").html(\'0\')}});});</script>';

            echo '<div class="alert alert-success"><strong>Thank you for your purchase!</strong><br><p>We have received your order and will begin to process it shortly. <br>We will also be in contact with you regarding your purchase delivery.<br><br><strong>Your purchase number is: ' . $purcahseNum . '</strong><br><br>
<table>
<tr><td>Purchaser: </td><td>' . $_POST["first_name"] . ' ' . $_POST["last_name"] . '</td></tr>
<tr><td>Email: </td><td>' . $_POST["email"] . '</td></tr>
<tr><td>Phone: </td><td>' . $_POST["phone"] . '</td></tr>
<tr><td>Billing Address: </td><td>' . $_POST["address"] . '<br>' . $_POST["city"] . ' ' . $_POST["state"] . ', ' . $_POST["zip"] . '</td></tr>

</table><br>
<br><button class="btn btn-default printMe" style="background: #000;color: #fff;border: 0;"><i class="fa fa-print"></i> Print Page</button></p></div>';
            $process = true;
        } catch (Exception $e) {
            $errorCode = 'ERROR - ' . $e->getMessage();
            echo '<div class="alert alert-danger"><strong>Payment not processed!</strong><br><p>It appears there was a payment issue. <br>Please make sure your card details are correct and try again. If you continue to have issues please <a href="Contact-Us" style="color: #333">contact us</a>.</p></div>';
            $process = false;
        }

        if ($process == true) {
            $firstname = '';
            $lastname = '';
            $address = '';
            $city = '';
            $state = '';
            $zip = '';
            $email = '';
            $phone = '';

            $shipaddress = '';
            $shipcity = '';
            $shipstate = '';
            $shipzip = '';

            $order_notes = '';

            $payBox = 'style="display:none"';
        } else {
            $firstname = $_POST["first_name"];
            $lastname = $_POST["last_name"];
            $address = $_POST["address"];
            $city = $_POST["city"];
            $state = $_POST["state"];
            $zip = $_POST["zip"];
            $email = $_POST["email"];
            $phone = $_POST["phone"];

            $shipaddress = $_POST["ship_address"];
            $shipcity = $_POST["ship_city"];
            $shipstate = $_POST["ship_state"];
            $shipzip = $_POST["ship_zip"];

            $order_notes = $_POST["order_notes"];
            $payBox = 'style="display:block"';
        }
    }

?>


    <div class="order-container" style="padding:10px">

        <div class="payment_mess">

        </div>

        <div class="clearfix"></div>

        <h2 style="font-weight:bold">Order Details</h2>

        <?php

        $thePurchase .= '<table class="table">
        <thead style="background:#363737; color:#fff">
        <tr>
            <th>Product</th>
            <th>Total</th>
            <th></th>
        </tr>
        </thead>
        <tbody>';
        $countOut = 0;
        $taxrate = 6.0;

        for ($i = 0; $i < count($cartItems); $i++) {
            $itemPrice = $cartItems[$i]["machine"]["price"];
            $thePurchase .= '<tr><td>' . ucwords($cartItems[$i]["machine"]["eqtype"]) . ' - ' . $cartItems[$i]["machine"]["name"] . '</td><td>$' . $cartItems[$i]["machine"]["price"] . '<input type="hidden" id="prod_item" name="prod_item" value="2 16 OZ JARS"></td><td><a class="removit" href="javascript:void(0)" onclick="removeSavedCart(\'' . $cartItems[$i]["machine"]["name"] . '\')">remove</a></td></tr>';
            $countOut += $itemPrice;
        }

        $tax = round((($countOut * $taxrate) / 100), 2);
        $total = $countOut + $tax;

        $thePurchase .= ' <tr><td></td><td><strong>Subtotal</strong></td><td>$' . number_format($countOut, 2) . '</td></tr>
        <tr><td style="border-top:0"></td><td><strong>Tax</strong></td><td>$' . $tax . '</td></tr>
        <!--<tr><td><strong>Tax</strong></td><td>$1.16</td></tr>-->
        <tr><td style="border-top:0"></td><td><strong>Total: </strong></td><td><strong>$' . number_format($total, 2) . '</strong></td></tr>
        </tbody>
    </table>';

        echo $thePurchase;

        ?>

        <hr>




    </div>

    <div class="col-md-12 loadscree" style="display: none"><img style="width: 30px" src="img/loader.gif"> <strong>Processing Order... Please Wait...</strong></div>

    <div class="order_infosetter" <?php echo $payBox; ?>>
        <div class="col-md-6">
            <form name="order_process" id="order_process" method="post" action="" onsubmit="return false">
                <input type="hidden" id="prod_cost" name="prod_cost" value="<?php echo preg_replace('/[^0-9]/', '', $total); ?>">
                <h2 style="font-weight: bold;">Billing Details</h2>

                <label>First Name*</label><br>
                <input class="form-control" type="text" name="first_name" id="first_name" value="<?php echo $firstname; ?>" required=""><br>
                <label>Last Name*</label><br>
                <input class="form-control" type="text" name="last_name" id="last_name" value="<?php echo $lastname; ?>" required="">
                <label>Email Address*</label><br>
                <input class="form-control" type="email" name="email" id="email" value="<?php echo $email; ?>" required="">
                <label>Address*</label><br>
                <input class="form-control" type="text" name="address" id="address" value="<?php echo $address; ?>" required="">
                <label>City*</label><br>
                <input class="form-control" type="text" name="city" id="city" value="<?php echo $city; ?>" required="">
                <label>state*</label><br>
                <select class="form-control" name="state" id="state" required="">

                    <?php

                    $states = array(
                        'AL' => 'Alabama',
                        'AK' => 'Alaska',
                        'AZ' => 'Arizona',
                        'AR' => 'Arkansas',
                        'CA' => 'California',
                        'CO' => 'Colorado',
                        'CT' => 'Connecticut',
                        'DE' => 'Delaware',
                        'FL' => 'Florida',
                        'GA' => 'Georgia',
                        'HI' => 'Hawaii',
                        'ID' => 'Idaho',
                        'IL' => 'Illinois',
                        'IN' => 'Indiana',
                        'IA' => 'Iowa',
                        'KS' => 'Kansas',
                        'KY' => 'Kentucky',
                        'LA' => 'Louisiana',
                        'ME' => 'Maine',
                        'MD' => 'Maryland',
                        'MA' => 'Massachusetts',
                        'MI' => 'Michigan',
                        'MN' => 'Minnesota',
                        'MS' => 'Mississippi',
                        'MO' => 'Missouri',
                        'MT' => 'Montana',
                        'NE' => 'Nebraska',
                        'NV' => 'Nevada',
                        'NH' => 'New Hampshire',
                        'NJ' => 'New Jersey',
                        'NM' => 'New Mexico',
                        'NY' => 'New York',
                        'NC' => 'North Carolina',
                        'ND' => 'North Dakota',
                        'OH' => 'Ohio',
                        'OK' => 'Oklahoma',
                        'OR' => 'Oregon',
                        'PA' => 'Pennsylvania',
                        'RI' => 'Rhode Island',
                        'SC' => 'South Carolina',
                        'SD' => 'South Dakota',
                        'TN' => 'Tennessee',
                        'TX' => 'Texas',
                        'UT' => 'Utah',
                        'VT' => 'Vermont',
                        'VA' => 'Virginia',
                        'WA' => 'Washington',
                        'WV' => 'West Virginia',
                        'WI' => 'Wisconsin',
                        'WY' => 'Wyoming',
                    );

                    foreach ($states as $key => $val) {
                        if ($key == $state) {
                            echo '<option value="' . $key . '" selected="selected">' . $val . '</option>';
                        } else {
                            echo '<option value="' . $key . '">' . $val . '</option>';
                        }
                    }

                    ?>

                </select>
                <label>Zip*</label><br>
                <input class="form-control" type="text" name="zip" id="zip" value="<?php echo $zip; ?>" required="">
                <label>Phone*</label><br>
                <input class="form-control" type="text" name="phone" id="phone" value="<?php echo $phone; ?>" required="">

                <hr>

                <h2 style="font-weight: bold;">Payment Details</h2>

                <div class="alert alert-danger messars" style="display: none"></div>

                <label>Payment Method</label>
                <select name="cctype" id="cctype" class="form-control select-valid" required="">
                    <option selected="selected" value="none">Select Payment Type</option>
                    <option value="VISA">VISA</option>
                    <option value="MasterCard">MasterCard</option>
                    <option value="American Express">American Express</option>
                </select>
                <label>Card Number</label>
                <input class="form-control" type="text" name="cc_num" id="cc_num" value="" required="">
                <div class="col-md-6" style="padding-left: 0">
                    <label>Card Code <a href=""><i class="fa fa-info-circle" aria-hidden="true" style="color: rgb(204, 0, 1);"></i></a></label>
                    <input class="form-control" type="text" name="cc_code" id="cc_code" value="" required="">
                </div>
                <div class="col-md-6">
                    <label>Card Expiration</label><br>
                    <div class="col-sm-6"><input class="form-control" type="text" name="cc_exp_month" id="cc_exp_month" value="" placeholder="mm" required=""></div>
                    <div class="col-sm-6"><input class="form-control" type="text" name="cc_exp_year" id="cc_exp_year" value="" placeholder="yy" required=""></div>


                </div>

                <div class="clearfix"></div>
                <br><br>
                <button class="btn btn-success submit-button">PLACE ORDER</button>
        </div>

        <?php
        if (isset($_POST["ship_same"])) {
            $issame = 'checked="checked"';
        } else {
            $issame = '';
        }
        ?>


        <div class="col-md-6">
            <h2 style="font-weight: bold;">Shipping Address</h2>
            <label style="padding: 32px 4px;">
                <input type="checkbox" name="ship_same" id="ship_same" value="true" <?php echo $issame; ?>> Same as billing.
            </label>
            <br>
            <div class="ship_pan" style="display: block;">
                <label>Address*</label><br>
                <input class="form-control" type="text" name="ship_address" id="ship_address" value="<?php echo $shipaddress; ?>">
                <label>City*</label><br>
                <input class="form-control" type="text" name="ship_city" id="ship_city" value="<?php echo $shipcity; ?>">
                <label>state*</label><br>
                <select class="form-control" name="ship_state" id="ship_state">
                    <?php

                    $states = array(
                        'AL' => 'Alabama',
                        'AK' => 'Alaska',
                        'AZ' => 'Arizona',
                        'AR' => 'Arkansas',
                        'CA' => 'California',
                        'CO' => 'Colorado',
                        'CT' => 'Connecticut',
                        'DE' => 'Delaware',
                        'FL' => 'Florida',
                        'GA' => 'Georgia',
                        'HI' => 'Hawaii',
                        'ID' => 'Idaho',
                        'IL' => 'Illinois',
                        'IN' => 'Indiana',
                        'IA' => 'Iowa',
                        'KS' => 'Kansas',
                        'KY' => 'Kentucky',
                        'LA' => 'Louisiana',
                        'ME' => 'Maine',
                        'MD' => 'Maryland',
                        'MA' => 'Massachusetts',
                        'MI' => 'Michigan',
                        'MN' => 'Minnesota',
                        'MS' => 'Mississippi',
                        'MO' => 'Missouri',
                        'MT' => 'Montana',
                        'NE' => 'Nebraska',
                        'NV' => 'Nevada',
                        'NH' => 'New Hampshire',
                        'NJ' => 'New Jersey',
                        'NM' => 'New Mexico',
                        'NY' => 'New York',
                        'NC' => 'North Carolina',
                        'ND' => 'North Dakota',
                        'OH' => 'Ohio',
                        'OK' => 'Oklahoma',
                        'OR' => 'Oregon',
                        'PA' => 'Pennsylvania',
                        'RI' => 'Rhode Island',
                        'SC' => 'South Carolina',
                        'SD' => 'South Dakota',
                        'TN' => 'Tennessee',
                        'TX' => 'Texas',
                        'UT' => 'Utah',
                        'VT' => 'Vermont',
                        'VA' => 'Virginia',
                        'WA' => 'Washington',
                        'WV' => 'West Virginia',
                        'WI' => 'Wisconsin',
                        'WY' => 'Wyoming',
                    );

                    foreach ($states as $key => $val) {
                        if ($key == $shipstate) {
                            echo '<option value="' . $key . '" selected="selected">' . $val . '</option>';
                        } else {
                            echo '<option value="' . $key . '">' . $val . '</option>';
                        }
                    }

                    ?>
                </select>
                <label>Zip*</label><br>
                <input class="form-control" type="text" name="ship_zip" id="ship_zip" value="<?php echo $shipzip; ?>">
            </div>
            <label>Order Notes</label><br>
            <textarea class="form-control" name="order_notes" id="order_notes" placeholder="Notes about your order, e.g. special notes for delivery."><?php echo $notes; ?></textarea>
        </div>

    </div>
    </form>
    <div class="clearfix"></div>
    <br><br>

<?php } else { ?>

    <div class="jumbotron" style="font-style: italic;">Nothing has been added to your cart.</div>

<?php } ?>