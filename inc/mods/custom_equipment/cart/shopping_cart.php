<?php

include('config.php');

$cartRaw = $_COOKIE['cartData'];
$cartJson = json_decode($cartItemsRaw, true);

if (isset($_COOKIE['cartData'])) {
    $cartData = json_decode($_COOKIE['cartData'], true); // Decode JSON into associative array
    if ($cartData && isset($cartData[0]['cartItems']) && $cartData[0]['cartItems'] != "") {

        $cartItemCount = count($cartData[0]['cartItems']);
        if ($cartItemCount > 0) {
            for ($i = 0; $i < count($cartData[0]['cartItems']); $i++) {
                $id = $cartData[0]['cartItems'][$i]['id'];
                $price = $cartData[0]['cartItems'][$i]['price'];
                $qty = $cartData[0]['cartItems'][$i]['qty'];
                $uniqId = $cartData[0]['cartItems'][$i]['uniqId'];

                $a = $data->query("SELECT * FROM custom_equipment WHERE id = " . $id . "");
                $obj = $a->fetch_array();

                $items .= '
                            <div class="col-lg-4 col-sm-4 col-4 cart-detail-product my-2 cart-item-' . $uniqId . '">
                                <p style="margin: 0;">' . str_replace('-', ' ', $cartData[0]['cartItems'][$i]['name']) . '</p>
                            </div>
                            <div class="col-md-3 col-sm-3 col-3 my-2 cart-item-' . $uniqId . '">
                                <span class="price text-info"> $' . number_format(floatval($price), 2, '.', ',') . '  </span>
                            </div>
                            <div class="col-md-2 col-sm-2 col-2 my-2 cart-item-' . $uniqId . '">
                                <span class="count">  Qty:' . $qty . '</span>
                            </div>
                            <div class="col-md-1 col-sm-1 col-1 my-2 ml-4 cart-item-' . $uniqId . '">
                                <a onclick="RemoveCartItem(\'' . $uniqId . '\')"><button class="btn btn-danger ml-1"><i class="fa fa-trash" aria-hidden="true"></i></button></a>
                            </div>';

                $cartItemCount = intval($cartItemCount) + intval($cartData[0]['cartItems'][$i]['qty']);
            }

            $items .= '<hr>
                        <div class="row justify-content-center mt-3" style="width: 100%;">
                                <a href="checkout" class="btn btn-primary btn-block" style="width: 100%;">Checkout</a>
                        </div>';
        } else {
            $items .= '<div class="col-md-12 text-center"><h1 style="font-size: 20px !important;"><b>Nothing In Cart...</b></h1></div>';
        }
    }
} else {
    $items .= '<div class="col-md-12 text-center"><h1 style="font-size: 20px !important;"><b>Nothing In Cart...</b></h1></div>';
}
$total = CalculateCartTotalNoTax();
$html = '   <div class="row total-header-section">
                <div class="col-lg-6 col-sm-6 col-6">
                    <i class="fa fa-shopping-cart" aria-hidden="true"></i> <span class="badge badge-pill badge-danger cartcount">' . $cartItemCount . '</span>
                </div>
                <div class="col-lg-6 col-sm-6 col-6 total-section text-right">
                    <p>Total: <span class="text-info cart-total">$' . number_format(floatval($total), 2, '.', ',') . '</span></p>
                </div>
            </div>
            <div class="row cart-detail">
            ' . $items . '';
$html .= '</div>';

$returnArray = array(
    'html' => $html,
    'count' => $cartItemCount
);

$returnJson = json_encode($returnArray, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

function CalculateCartTotalNoTax()
{
    $total = 0;
    foreach (json_decode($_COOKIE['cartData'], true)[0]['cartItems'] as $item) {
        $total = doubleval($total) + (doubleval($item['price']) * intval($item['qty']));
    }
    return doubleval($total);
}

echo ($html);
?>

<script>
    $('.cart-total').html("$<?php $cartData[0]['cart_total'] ?>");
    $('.cartcount').html("$<?php count($cartData[0]['cartItems']) ?>");


    //Remove Item From Cart
    function RemoveCartItem(id) {
        $.ajax({
            type: "POST",
            url: "inc/mods/custom_equipment/command_processor.php?action=removecartitem",
            data: {
                id: id
            },
            success: function(obj) {
                console.log("Removed Item!: " + obj);
                UpdateCart();
            }
        })
    }

    //Update Cart In Navigation
    function UpdateCart() {
        $.ajax({
            type: "POST",
            url: "inc/mods/custom_equipment/cart/shopping_cart.php",
            dataType: "json",
            success: function(obj) {
                $(".cart-dropdown-menu").html(obj.html);
                $(".cartcount").val(obj.count);
                location.reload();
            }
        })
    }
</script>