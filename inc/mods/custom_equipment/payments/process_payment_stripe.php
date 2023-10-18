<?php

// Include the Stripe PHP library
require_once 'stripe/init.php';

// Set API key
\Stripe\Stripe::setApiKey('sk_test_rl8EDdilWPQMi7IiRk9jjLcC');

// Retrieve JSON from POST body
$jsonStr = file_get_contents('php://input');
$jsonObj = json_decode($jsonStr);

if ($jsonObj->request_type == 'create_payment_intent') {

    // Define item price and convert to cents
    $itemPriceCents = round($itemPrice * 100);

    // Set content type to JSON
    header('Content-Type: application/json');

    try {
        // Create PaymentIntent with amount and currency
        $paymentIntent = \Stripe\PaymentIntent::create([
            'amount' => $itemPriceCents,
            'currency' => $currency,
            'description' => $itemName,
            'payment_method_types' => [
                'card'
            ]
            /*'automatic_payment_methods' => [
				'enabled' => true
			]*/
        ]);

        $output = [
            'id' => $paymentIntent->id,
            'clientSecret' => $paymentIntent->client_secret
        ];

        echo json_encode($output);
    } catch (Error $e) {
        http_response_code(500);
        echo json_encode(['error' => $e->getMessage()]);
    }
} elseif ($jsonObj->request_type == 'create_customer') {
    $payment_intent_id = !empty($jsonObj->payment_intent_id) ? $jsonObj->payment_intent_id : '';
    $name = !empty($jsonObj->name) ? $jsonObj->name : '';
    $email = !empty($jsonObj->email) ? $jsonObj->email : '';

    // Add customer to stripe
    try {
        $customer = \Stripe\Customer::create(array(
            'name' => $name,
            'email' => $email
        ));
    } catch (Exception $e) {
        $api_error = $e->getMessage();
    }

    if (empty($api_error) && $customer) {
        try {
            // Update PaymentIntent with the customer ID
            $paymentIntent = \Stripe\PaymentIntent::update($payment_intent_id, [
                'customer' => $customer->id
            ]);
        } catch (Exception $e) {
            // log or do what you want
        }

        $output = [
            'id' => $payment_intent_id,
            'customer_id' => $customer->id
        ];
        echo json_encode($output);
    } else {
        http_response_code(500);
        echo json_encode(['error' => $api_error]);
    }
} elseif ($jsonObj->request_type == 'payment_insert') {
    $payment_intent = !empty($jsonObj->payment_intent) ? $jsonObj->payment_intent : '';
    $customer_id = !empty($jsonObj->customer_id) ? $jsonObj->customer_id : '';

    // Retrieve customer info
    try {
        $customer = \Stripe\Customer::retrieve($customer_id);
    } catch (Exception $e) {
        $api_error = $e->getMessage();
    }

    // Check whether the charge was successful
    if (!empty($payment_intent) && $payment_intent->status == 'succeeded') {
        // Transaction details 
        $transaction_id = $payment_intent->id;
        $paid_amount = $payment_intent->amount;
        $paid_amount = ($paid_amount / 100);
        $paid_currency = $payment_intent->currency;
        $payment_status = $payment_intent->status;

        $customer_name = $customer_email = '';
        if (!empty($customer)) {
            $customer_name = !empty($customer->name) ? $customer->name : '';
            $customer_email = !empty($customer->email) ? $customer->email : '';
        }

        $output = [
            'payment_txn_id' => base64_encode($transaction_id)
        ];
        echo json_encode($output);
    } else {
        http_response_code(500);
        echo json_encode(['error' => 'Transaction has been failed!']);
    }
}
