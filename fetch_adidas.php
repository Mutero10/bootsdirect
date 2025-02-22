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

                    <!-- Size Selection Dropdown -->
                    <select class="form-control mb-2 size-selector" data-id="' . htmlspecialchars($row["id"]) . '">
                        <option value="" disabled selected>Select Size</option>';
                        for ($size = 38; $size <= 48; $size++) {
                            echo '<option value="' . $size . '">' . $size . '</option>';
                        }
                    echo '</select>

                    <!-- Add to Cart Button -->
                    <button class="btn btn-success add-to-cart" 
                        data-id="' . htmlspecialchars($row["id"]) . '" 
                        data-name="' . htmlspecialchars($row["name"]) . '" 
                        data-price="' . htmlspecialchars($row["price"]) . '">
                        Add to Cart
                    </button>
                </div>
            </div>
        </div>';
    }
} else {
    echo "<p>No Adidas products found.</p>";
}
?>



<script>
    document.querySelectorAll('.add-to-cart').forEach(function(button) {
    button.addEventListener('click', function() {
        const product = {
            id: this.getAttribute('data-id'),
            name: this.getAttribute('data-name'),
            price: this.getAttribute('data-price')
        };

        // Send product details to PHP to store in session
        fetch('add_to_cart.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `id=${product.id}&name=${encodeURIComponent(product.name)}&price=${product.price}`
        })
        .then(response => response.text())
        .then(data => {
            alert(product.name + ' has been added to your cart!');
            console.log(data); // Debugging response from PHP
        })
        .catch(error => console.error('Error:', error));
    });
});

</script>

