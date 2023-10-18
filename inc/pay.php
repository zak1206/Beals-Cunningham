<?php

require_once('../stripe_thing/init.php');


$curl = new \Stripe\HttpClient\CurlClient([CURLOPT_SSLVERSION => CURL_SSLVERSION_TLSv1]);
\Stripe\ApiRequestor::setHttpClient($curl);

\Stripe\Stripe::setApiKey('sk_test_rl8EDdilWPQMi7IiRk9jjLcC');
$charge = \Stripe\Charge::create(['amount' => 2000, 'currency' => 'usd', 'source' => 'tok_189fqt2eZvKYlo2CTGBeg6Uq']);
echo $charge;

?>