<?php
session_start();
$cartRaw = $_COOKIE["cartData"];
$cartItems = json_decode($_COOKIE["cartData"], true);
//$cartItems = $cartItems["cartitems"];
//echo '<pre>';
//var_dump($cartItems);
//echo '</pre>';
?>
<div class="overlays"></div>
<div class="lds-ring">
    <div></div>
    <div></div>
    <div></div>
    <div></div>
</div>
<div class="informares container"></div>
<div class="cartcontents"></div>