<?php

include('../../config.php');

$cartRaw = $_COOKIE['cartData'];
$cartJson = json_decode($cartItemsRaw, true);

$html = '<div class="row">';

if (isset($_COOKIE['cartData'])) {
    $cartData = json_decode($_COOKIE['cartData'], true); // Decode JSON into associative array
    if ($cartData && isset($cartData[0]['cartItems']) && $cartData[0]['cartItems'] != "") {

        $cartItemCount = count($cartData[0]['cartItems']);
        if ($cartItemCount > 0) {
            $html .= '<div class="col-md-12"><h3 class="text-center"><b>Cart</b></h3></div>';

            for ($i = 0; $i < count($cartData[0]['cartItems']); $i++) {
                $id = $cartData[0]['cartItems'][$i]['id'];
                $price = $cartData[0]['cartItems'][$i]['price'];
                $qty = $cartData[0]['cartItems'][$i]['qty'];
                $uniqId = $cartData[0]['cartItems'][$i]['uniqId'];

                $a = $data->query("SELECT * FROM custom_equipment WHERE id = " . $id . "");
                $obj = $a->fetch_array();

                $html .= '<div class="col-md-5 text-center">
                        <h6><b>' . $obj['title'] . '</b></h6>
                    </div>

                    <div class="col-md-1 text-center">
                        <h6>' . $qty . '</h6>
                    </div>
                    
                    <div class="col-md-3 text-center">
                        <h6>$' . $price . '</h6>
                    </div>

                    <div class="col-md-1 ml-2 text-center">
                        <h6><button class="btn btn-danger" onclick="RemoveCartItem(\'' . $uniqId . '\')">X</button></h6>
                    </div>';
            }

            $html .= '<div class="col-md-12 ml-2 text-center">
                        <h6><a href="checkout"><button class="btn btn-success">Checkout</button></a></h6>
                    </div>';
        } else {
            $html .= '<div class="col-md-12 text-center"><h1 style="font-size: 20px !important;"><b>Nothing In Cart...</b></h1></div>';
        }
    }
} else {
    $html .= '<div class="col-md-12 text-center"><h1 style="font-size: 20px !important;"><b>Nothing In Cart...</b></h1></div>';
}

$html .= '</div>';

echo ($html);
