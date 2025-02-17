<?php
include 'databasehandler.php';

$db = new DatabaseHandler();
$products = $db->getAdidasProducts(); // Fetch only Adidas products

if (!empty($products)) {
    foreach ($products as $row) {
    echo '
    <div class="col-md-4 mb-4 product-card" data-type="' . htmlspecialchars($row["type"]) . '" data-price="' . htmlspecialchars($row["price"]) . '">
    <div class="card h-100">
        <img src="' . htmlspecialchars($row["image"]) . '" class="card-img-top product-image" alt="' . htmlspecialchars($row["name"]) . '">
        <div class="card-body">
            <h5 class="card-title">' . htmlspecialchars($row["name"]) . '</h5>
            <p class="card-text">Ksh ' . htmlspecialchars($row["price"]) . '</p>

        <button class="btn btn-success add-to-cart" 
        data-id="' . htmlspecialchars($row["id"]) . '" 
        data-name="' . htmlspecialchars($row["name"]) . '" 
        data-price="' . htmlspecialchars($row["price"]) . '">Add to Cart</button>

        </div>
    </div>
</div>';
    }
} else {
    echo "<p>No Adidas products found.</p>";
}
?>

<script>
    // Add event listeners for all the Add to Cart buttons
    document.querySelectorAll('.add-to-cart').forEach(function(button) {
        button.addEventListener('click', function() {
            const product = {
                id: this.getAttribute('data-id'),
                name: this.getAttribute('data-name'),
                price: parseFloat(this.getAttribute('data-price'))
            };

            // Get the current cart from localStorage, or initialize an empty array
            let cart = JSON.parse(localStorage.getItem('cart')) || [];

            // Add the new product to the cart
            cart.push(product);

            // Save the updated cart back to localStorage
            localStorage.setItem('cart', JSON.stringify(cart));

            // Notify the user that the product was added
            alert(product.name + ' has been added to your cart!');
        });
    });
</script>

