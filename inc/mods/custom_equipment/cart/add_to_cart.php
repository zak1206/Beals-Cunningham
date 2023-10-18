<?php
// Retrieve the item data from the POST request
$item = isset($_POST['item']) ? json_decode($_POST['item'], true) : null;

// Initialize the cart data if it doesn't exist in the cookie
$cartData = isset($_COOKIE['cartData']) ? json_decode($_COOKIE['cartData'], true) : [
    'items' => [],
    'totalPrice' => 0,
    'taxCost' => 0
];

if ($item) {
    // Add the item to the cart
    $cartData['items'][] = $item;
    $cartData['totalPrice'] += $item['price'];
    $cartData['taxCost'] = calculateTax($cartData['totalPrice']);

    // Store the updated cart data in the cookie for 5 days
    setcookie('cartData', json_encode($cartData), time() + (5 * 24 * 60 * 60), '/');

    echo "Item added to cart!";
} else {
    echo "No item data received.";
}

// Calculate tax cost (example: 10% tax)
function calculateTax($totalPrice) {
    $taxRate = 0.1; // 10% tax rate
    return $totalPrice * $taxRate;
}
