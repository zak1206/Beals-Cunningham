<!DOCTYPE html>
<html>

<head>
    <title>Shopping Cart Example</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <h1>Shopping Cart</h1>

        <div class="row">
            <div class="col-md-6">
                <h2>Product A</h2>
                <p>Price: $10</p>
                <button class="btn btn-primary add-to-cart" data-product-id="1" data-product-name="Product A" data-product-price="10">Add to Cart</button>
            </div>
            <!-- Add more products here -->
        </div>

        <h2>Cart</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="cart-items">
                <!-- Cart items will be dynamically added here -->
            </tbody>
        </table>

        <h3>Total Cost: <span id="total-cost">$0</span></h3>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
        $(document).ready(function() {
            // Add to Cart button click event
            $('.add-to-cart').on('click', function() {
                var productId = $(this).data('product-id');
                var productName = $(this).data('product-name');
                var productPrice = $(this).data('product-price');

                addToCart(productId, productName, productPrice);
            });

            // Function to add item to the cart using Ajax
            function addToCart(productId, productName, productPrice) {
                $.ajax({
                    url: 'cart.php', // Replace with the path to your PHP file
                    method: 'POST',
                    data: {
                        action: 'add',
                        product_id: productId,
                        name: productName,
                        price: productPrice,
                        quantity: 1 // You can adjust the quantity as needed
                    },
                    success: function(response) {
                        // Reload the cart items and total cost
                        loadCart();
                    }
                });
            }

            // Function to load the cart items and total cost using Ajax
            function loadCart() {
                $.ajax({
                    url: 'cart.php', // Replace with the path to your PHP file
                    method: 'POST',
                    data: {
                        action: 'load'
                    },
                    success: function(response) {
                        // Parse the JSON response
                        var data = JSON.parse(response);

                        // Update the cart items
                        $('#cart-items').html(data.cartItems);

                        // Update the total cost
                        $('#total-cost').text('$' + data.totalCost);
                    }
                });
            }

            // Initial load of the cart items and total cost
            loadCart();
        });
    </script>
</body>

</html>