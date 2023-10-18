<?php

$action = $_REQUEST['action'];

if ($action == 'createcustomer') {
    include('../payments/stripe-handler.php');
    include('../tax/zip-tax-handler.php');
    $tax_handler = new ZipTaxHandler();
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
    $bill_address = $_POST['billing_address'];
    $billing_city = $_POST['billing_city'];
    $billing_state = $_POST['billing_state'];
    $billing_zip = $_POST['billing_zip'];
    $cartData = json_decode($_COOKIE['cartData'], true);
    $total = doubleval($cartData[0]['cart_total']);
    $taxRate = $tax_handler->GetTaxRateByZipCode($zip);
    $tax = floatval($taxRate) * floatval($total);
    $_SESSION['tax'] = $tax;
    $true_total = intval($tax + $total);

    $processor = new StripeHandler();
    $token = $processor->ProcessPayment($true_total, ($firstName), $email, $phone, ($addr), $city, $state, $zip, $bill_address, $billing_city, $billing_state, $billing_zip, 'WOOT!');

    include('../checkout/invoice-page.php');

    echo "Success";
}
