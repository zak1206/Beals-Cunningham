<?php
session_start();

// Check if the cart exists in the session
if (isset($_SESSION['cart'])) {
    $cartItems = $_SESSION['cart']['items'];
    
    // Generate the HTML for displaying the cart items
    $html = '';
    
    if (!empty($cartItems)) {
        $html .= '
            <tr>
                <th>Product</th>
                <th>Quantity</th>
                <th>Price</th>
            </tr>
        ';
        
        foreach ($cartItems as $item) {
            $html .= '
                <tr>
                    <td>' . $item['productName'] . '</td>
                    <td>' . $item['quantity'] . '</td>
                    <td>$' . $item['price'] . '</td>
                </tr>
            ';
        }
    } else {
        $html = '<tr><td colspan="3">Cart is empty</td></tr>';
    }
    
    echo $html;
} else {
    echo '<tr><td colspan="3">Cart is empty</td></tr>';
}
