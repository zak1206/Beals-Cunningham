<?php
error_reporting(0);
$act = $_REQUEST["action"];
if($act == 'processpay'){
//echo '<pre>';
    //  var_dump($_POST);
    //  echo '</pre>';

    // By default, this sample code is designed to post to our test server for
// developer accounts: https://test.authorize.net/gateway/transact.dll
// for real accounts (even in test mode), please make sure that you are
// posting to: https://secure.authorize.net/gateway/transact.dll
    $post_url = "https://test.authorize.net/gateway/transact.dll";

    if(isset($_POST["ship_same"])){
        $shipAddress = $_POST["address"];
        $shipCity = $_POST["city"];
        $shipState = $_POST["state"];
        $shipZip = $_POST["zip"];
    }else{
        $shipAddress = $_POST["ship_address"];
        $shipCity = $_POST["ship_city"];
        $shipState = $_POST["ship_state"];
        $shipZip = $_POST["ship_zip"];
    }

    $post_values = array(

        // the API Login ID and Transaction Key must be replaced with valid values
        "x_login"			=> "",
        "x_tran_key"		=> "",

        "x_version"			=> "3.1",
        "x_delim_data"		=> "TRUE",
        "x_delim_char"		=> "|",
        "x_relay_response"	=> "FALSE",

        "x_type"			=> "AUTH_CAPTURE",
        "x_method"			=> "CC",
        "x_card_num"		=> $_POST["cc_num"],
        "x_exp_date"		=> $_POST["cc_exp"],

        "x_amount"			=> $_POST["prod_cost"],
        "x_description"		=> $_POST["prod_item"],
        "x_invoice_num" 	=> date('dmYisu'),

        "x_first_name"		=> $_POST["first_name"],
        "x_last_name"		=> $_POST["last_name"],
        "x_address"			=> $_POST["address"],
        "x_city"			=> $_POST["city"],
        "x_state"			=> $_POST["state"],
        "x_zip"				=> $_POST["zip"],
        "x_phone"		    => $_POST['phone'],
        "x_email"		    => $_POST['email'],
        "x_ship_to_first_name"	=> $_POST['first_name'],
        "x_ship_to_last_name"	=> $_POST["last_name"],
        "x_ship_to_address"	=> $_POST["address"],
        "x_ship_to_city"		=> $_POST["city"],
        "x_ship_to_state"		=> $_POST["state"],
        "x_ship_to_zip"		=> $_POST["zip"],
        // Additional fields can be added here as outlined in the AIM integration
        // guide at: https://developer.authorize.net
    );

// This section takes the input fields and converts them to the proper format
// for an http post.  For example: "x_login=username&x_tran_key=a1B2c3D4"
    $post_string = "";
    foreach( $post_values as $key => $value )
    { $post_string .= "$key=" . urlencode( $value ) . "&"; }
    $post_string = rtrim( $post_string, "& " );

// The following section provides an example of how to add line item details to
// the post string.  Because line items may consist of multiple values with the
// same key/name, they cannot be simply added into the above array.
//
// This section is commented out by default.
    /*
    $line_items = array(
        "item1<|>golf balls<|><|>2<|>18.95<|>Y",
        "item2<|>golf bag<|>Wilson golf carry bag, red<|>1<|>39.99<|>Y",
        "item3<|>book<|>Golf for Dummies<|>1<|>21.99<|>Y");

    foreach( $line_items as $value )
        { $post_string .= "&x_line_item=" . urlencode( $value ); }
    */

// This sample code uses the CURL library for php to establish a connection,
// submit the post, and record the response.
// If you receive an error, you may want to ensure that you have the curl
// library enabled in your php configuration
    $request = curl_init($post_url); // initiate curl object
    curl_setopt($request, CURLOPT_HEADER, 0); // set to 0 to eliminate header info from response
    curl_setopt($request, CURLOPT_RETURNTRANSFER, 1); // Returns response data instead of TRUE(1)
    curl_setopt($request, CURLOPT_POSTFIELDS, $post_string); // use HTTP POST to send form data
    curl_setopt($request, CURLOPT_SSL_VERIFYPEER, FALSE); // uncomment this line if you get no gateway response.
    $post_response = curl_exec($request); // execute curl post and store results in $post_response
    // additional options may be required depending upon your server configuration
    // you can find documentation on curl options at https://www.php.net/curl_setopt
    curl_close ($request); // close curl object

// This line takes the response and breaks it into an array using the specified delimiting character
    $response_array = explode($post_values["x_delim_char"],$post_response);

    //var_dump($response_array);

// The results are output to the screen in the form of an html numbered list.


    if($response_array[0] == '1'){
        //echo 'good';

        $html .= '
            <div style="padding: 20px; background: #efefef;">
                <h2 style="color: #fff; display: block; padding: 10px; background: #b51a2f"><i class="fa fa-check"></i> Thank You for your purchase.</h2>';
        $html .= '<strong style="color:#333">We have received your order and will be processing it shortly.</strong><br>You should also receive an order confirmation in your email.<br><br>';

        $html .= '<h2 style="color:#EC1C30">Order Details:</h2><span style="color:#333">
Date: '.date('m/d/Y').'<br></b>
        '.$_POST["first_name"].' '.$_POST["last_name"].'<br>
        '.$_POST["address"].'<br>
        '.$_POST["city"].' '.$_POST["state"].', '.$_POST["zip"].'<br><hr><br>

        Items Purchased: '.$_POST["prod_item"].'<br>
        Total: '.$_POST["prod_cost"].'<br></span>
';

        $html .= '</div>';

        echo $html;

    }else{
        echo "This is "$response_array[0];
        var_dump($_POST);
    }
// individual elements of the array could be accessed to read certain response
// fields.  For example, response_array[0] would return the Response Code,
// response_array[2] would return the Response Reason Code.
// for a list of response fields, please review the AIM Implementation Guide
}
?>