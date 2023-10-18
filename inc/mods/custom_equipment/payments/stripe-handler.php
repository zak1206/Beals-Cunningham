<?php

require_once('stripe/init.php');

class StripeHandler
{

  public function __construct()
  {
  }

  // Process A Credit/Debit Card Transaction Attached To A Customer
  // - Creates Customer Object
  // - Creates Customer Payment Source
  // - Creates Charge To Process The Transaction
  public function ProcessPayment($totalPrice, $fullName, $email, $phone, $addr_street, $addr_city, $addr_state, $addr_zip, $ship_street, $ship_city, $ship_state, $ship_zip, $description)
  {
    try {
      //Create A New Customer Object
      $customer = $this->CreateStripeCustomer($fullName, $email, $phone, $addr_street, $addr_city, $addr_state, $addr_zip, $ship_street, $ship_city, $ship_state, $ship_zip, $description);

      //Attach Payment Source To Customer - TEST-MODE
      $source = $this->CreateCustomerPaymentSource($customer['id']);

      //Stripe Only Accepts Total in Form of an Int, so we need to multiply our double by 100
      $charge = $this->CreateCharge($customer['id'], $totalPrice, $source);

      // Handle successful payment (redirect to a success page, store order, etc.)
      return $charge;
    } catch (\Stripe\Exception\CardException $e) {
      // Handle card errors
      echo 'Error: ' . $e->getMessage();
    } catch (\Stripe\Exception\InvalidRequestException $e) {
      // Handle invalid requests
      echo 'Error: ' . $e->getMessage();
    } catch (\Stripe\Exception\AuthenticationException $e) {
      // Handle authentication errors
      echo 'Error: ' . $e->getMessage();
    } catch (\Stripe\Exception\ApiConnectionException $e) {
      // Handle network errors
      echo 'Error: ' . $e->getMessage();
    } catch (\Stripe\Exception\ApiErrorException $e) {
      // Handle other Stripe API errors
      echo 'Error: ' . $e->getMessage();
    } catch (\Stripe\Exception\UnexpectedValueException $e) {
      // Handle other Stripe API errors
      echo 'Error: ' . $e->getMessage();
    }
  }

  //Search Customer Objects For Existing Customer - Search By Full-Name
  public function SearchForCustomer($fullName)
  {
    try {
      $stripe = new \Stripe\StripeClient('sk_test_rl8EDdilWPQMi7IiRk9jjLcC');
      $customer = $stripe->customers->search([
        'query' => 'name:\'' . $fullName . '\'',
      ]);

      return $customer;
    } catch (\Stripe\Exception\CardException $e) {
      // Handle card errors
      echo 'Error: ' . $e->getMessage();
      return null;
    } catch (\Stripe\Exception\InvalidRequestException $e) {
      // Handle invalid requests
      echo 'Error: ' . $e->getMessage();
      return null;
    } catch (\Stripe\Exception\AuthenticationException $e) {
      // Handle authentication errors
      echo 'Error: ' . $e->getMessage();
      return null;
    } catch (\Stripe\Exception\ApiConnectionException $e) {
      // Handle network errors
      echo 'Error: ' . $e->getMessage();
      return null;
    } catch (\Stripe\Exception\ApiErrorException $e) {
      // Handle other Stripe API errors
      echo 'Error: ' . $e->getMessage();
      return null;
    }
  }

  //Creates Stripe Customer Object
  //  - Returns Customer Id
  public function CreateStripeCustomer($fullName, $email, $phone, $addr_street, $addr_city, $addr_state, $addr_zip, $ship_street, $ship_city, $ship_state, $ship_zip, $description): \Stripe\Customer
  {
    try {
      //Create Customer
      $stripe = new \Stripe\StripeClient('sk_test_rl8EDdilWPQMi7IiRk9jjLcC');
      $customer = $stripe->customers->create([
        'name' => $fullName,
        'email' => $email,
        'phone' => $phone,
        'description' => $description,
        'address' => [
          'line1' => $addr_street,
          'city' => $addr_city,
          'state' => $addr_state,
          'postal_code' => $addr_zip,
          'country' => 'US',
        ],
        'shipping' => [
          'address' => [
            'line1' => $ship_street,
            'city' => $ship_city,
            'state' => $ship_state,
            'postal_code' => $ship_zip,
            'country' => 'US',
          ],
          'name' => $fullName,
          'phone' => $phone,
        ],
      ]);

      // Handle successful payment (redirect to a success page, store order, etc.)
      return $customer;
    } catch (\Stripe\Exception\CardException $e) {
      // Handle card errors
      echo 'Error: ' . $e->getMessage();
    } catch (\Stripe\Exception\InvalidRequestException $e) {
      // Handle invalid requests
      echo 'Error: ' . $e->getMessage();
    } catch (\Stripe\Exception\AuthenticationException $e) {
      // Handle authentication errors
      echo 'Error: ' . $e->getMessage();
    } catch (\Stripe\Exception\ApiConnectionException $e) {
      // Handle network errors
      echo 'Error: ' . $e->getMessage();
    } catch (\Stripe\Exception\ApiErrorException $e) {
      // Handle other Stripe API errors
      echo 'Error: ' . $e->getMessage();
    }
  }

  //Creates Source Object and Assigns it To Customer
  public function CreateCustomerPaymentSource($customerId)
  {
    try {
      $stripe = new \Stripe\StripeClient('sk_test_rl8EDdilWPQMi7IiRk9jjLcC');
      $source = $stripe->customers->createSource(
        $customerId,
        [
          'source' => 'tok_visa'
        ]
      );

      return $source;
    } catch (\Stripe\Exception\CardException $e) {
      // Handle card errors
      echo 'Error: ' . $e->getMessage();
    } catch (\Stripe\Exception\InvalidRequestException $e) {
      // Handle invalid requests
      echo 'Error: ' . $e->getMessage();
    } catch (\Stripe\Exception\AuthenticationException $e) {
      // Handle authentication errors
      echo 'Error: ' . $e->getMessage();
    } catch (\Stripe\Exception\ApiConnectionException $e) {
      // Handle network errors
      echo 'Error: ' . $e->getMessage();
    } catch (\Stripe\Exception\ApiErrorException $e) {
      // Handle other Stripe API errors
      echo 'Error: ' . $e->getMessage();
    }
  }

  public function CreateCharge($customerId, $totalPrice, $objSource): Object
  {
    try {
      //Get the User's IP Address
      $clientIP = $_SERVER['REMOTE_ADDR'];

      //Stripe Only Accepts Total in Form of an Int, so we need to multiply our double by 100
      $amount = intval(doubleval($totalPrice) * 100);
      $stripe = new \Stripe\StripeClient('sk_test_rl8EDdilWPQMi7IiRk9jjLcC');
      $charge = $stripe->charges->create([
        'amount' => $amount,
        'currency' => 'usd',
        'source' => $objSource,
        'customer' => $customerId,
        'receipt_email' => 'zak.rowton@gmail.com',
        'ip' => $clientIP,
        'description' => 'WOOT! Stripe Payments Are Now Working!!!!!',
        'metadata' => [
          'name' => 'Zakary Rowton',
          'address' => '3968 rochelle ln',
          'city' => 'Heartland',
          'state' => 'TX',
          'zip' => '75126',
          'email' => 'zak.rowton@gmail.com',
          'phone' => '8178998723',
        ],
      ]);

      return $charge;
    } catch (\Stripe\Exception\CardException $e) {
      // Handle card errors
      echo 'Error: ' . $e->getMessage();
    } catch (\Stripe\Exception\InvalidRequestException $e) {
      // Handle invalid requests
      echo 'Error: ' . $e->getMessage();
    } catch (\Stripe\Exception\AuthenticationException $e) {
      // Handle authentication errors
      echo 'Error: ' . $e->getMessage();
    } catch (\Stripe\Exception\ApiConnectionException $e) {
      // Handle network errors
      echo 'Error: ' . $e->getMessage();
    } catch (\Stripe\Exception\ApiErrorException $e) {
      // Handle other Stripe API errors
      echo 'Error: ' . $e->getMessage();
    }
  }

  // !!!!!LIVE MODE ONLY!!!!
  // Create a Payment Method with card details
  // - Can Store These In Customer Objects
  public function CreatePaymentMethod($full_name, $card_no, $exp_month, $exp_year, $billing_addr, $billing_city, $billing_state, $billing_zip, $phone, $email)
  {
    //try{
    //$payment_method = $stripe->paymentMethods->create([
    //    'type' => 'card',
    //    'card' => [
    //        'number' => '4242424242424242',
    //        'exp_month' => 12,
    //        'exp_year' => 2034,
    //        'cvc' => '314',
    //    ],
    //    'billing_details' => [
    //        'address' => [
    //            'line1' => '123 Main St',
    //            'city' => 'City',
    //            'state' => 'CA',
    //            'postal_code' => '12345',
    //            'country' => 'US',
    //        ],
    //        'email' => 'example@example.com',
    //        'phone' => '+1234567890',
    //    ],
    //]);
    // } catch (\Stripe\Exception\CardException $e) {
    //   // Handle card errors
    //   echo 'Error: ' . $e->getMessage();
    // } catch (\Stripe\Exception\InvalidRequestException $e) {
    //   // Handle invalid requests
    //   echo 'Error: ' . $e->getMessage();
    // } catch (\Stripe\Exception\AuthenticationException $e) {
    //   // Handle authentication errors
    //   echo 'Error: ' . $e->getMessage();
    // } catch (\Stripe\Exception\ApiConnectionException $e) {
    //   // Handle network errors
    //   echo 'Error: ' . $e->getMessage();
    // } catch (\Stripe\Exception\ApiErrorException $e) {
    //   // Handle other Stripe API errors
    //   echo 'Error: ' . $e->getMessage();
    // }
  }

  // !!!!!LIVE MODE ONLY!!!!
  // Assigns A Payment Method To A Customer Object
  public function AssignPaymentMethodToCustomer($obj_pymt_method, $obj_customer)
  {
    //try{
    //$customer = $stripe->customers->create([
    //    'description' => 'WOOT! Stripe Payments Are Now Working!!!!!',
    //    'payment_method' => $payment_method->id,
    //]);
    // } catch (\Stripe\Exception\CardException $e) {
    //   // Handle card errors
    //   echo 'Error: ' . $e->getMessage();
    // } catch (\Stripe\Exception\InvalidRequestException $e) {
    //   // Handle invalid requests
    //   echo 'Error: ' . $e->getMessage();
    // } catch (\Stripe\Exception\AuthenticationException $e) {
    //   // Handle authentication errors
    //   echo 'Error: ' . $e->getMessage();
    // } catch (\Stripe\Exception\ApiConnectionException $e) {
    //   // Handle network errors
    //   echo 'Error: ' . $e->getMessage();
    // } catch (\Stripe\Exception\ApiErrorException $e) {
    //   // Handle other Stripe API errors
    //   echo 'Error: ' . $e->getMessage();
    // }
  }
}
