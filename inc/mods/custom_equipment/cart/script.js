$(document).ready(function() {
    // Add to cart button click event
    $('#addToCartBtn').click(function() {
        var productName = "Example Product";
        var quantity = 1;
        var price = 10;

        var items = {
            productName: productName,
            quantity: quantity,
            price: price
        };

        addToCart(items);
    });

    // Cart icon click event
    $('#cartIcon').click(function() {
        showCartPreview();
    });

    // Add item to cart
function addToCart(item) {
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'add_to_cart.php', true);
    xhr.setRequestHeader('Content-Type', 'application/json');
    xhr.onload = function() {
        if (xhr.status === 200) {
            alert(xhr.responseText);
        } else {
            alert('An error occurred while adding the item to the cart.');
            console.log(xhr.responseText);
        }
    };
    xhr.send(JSON.stringify({ item: item }));
}

function addtocart(){
    var item = {
        productName: "Example Product",
        quantity: 1,
        price: 10
    };
    
    addToCart(item);
}



    // Show cart preview
function showCartPreview() {
    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'get_cart_items.php', true);
    xhr.onload = function() {
        if (xhr.status === 200) {
            var cartItems = JSON.parse(xhr.responseText);
            var cartItemsTable = document.getElementById('cartItems');
            cartItemsTable.innerHTML = '';

            if (cartItems && cartItems.length > 0) {
                var tableHeader = document.createElement('tr');
                tableHeader.innerHTML = '<th>Product</th><th>Quantity</th><th>Price</th>';
                cartItemsTable.appendChild(tableHeader);

                for (var i = 0; i < cartItems.length; i++) {
                    var item = cartItems[i];
                    var row = document.createElement('tr');
                    row.innerHTML = '<td>' + item.productName + '</td><td>' + item.quantity + '</td><td>' + item.price + '</td>';
                    cartItemsTable.appendChild(row);
                }
            } else {
                var emptyRow = document.createElement('tr');
                emptyRow.innerHTML = '<td colspan="3">Cart is empty</td>';
                cartItemsTable.appendChild(emptyRow);
            }

            updateCartTotal();
        } else {
            console.error('Error retrieving cart items. Status code: ' + xhr.status);
        }
    };
    xhr.send();
}

// Update cart total
function updateCartTotal() {
    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'get_cart_total.php', true);
    xhr.onload = function() {
        if (xhr.status === 200) {
            var cartTotalPrice = document.getElementById('cartTotalPrice');
            cartTotalPrice.textContent = '$' + parseFloat(xhr.responseText).toFixed(2);
        } else {
            console.error('Error retrieving cart total. Status code: ' + xhr.status);
        }
    };
    xhr.send();
}

});
