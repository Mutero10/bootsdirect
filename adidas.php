<?php

// Assume you already fetched $products from the database
foreach ($products as $product): ?>
    <div class="product-card" data-price="<?= htmlspecialchars($product['price']) ?>" data-type="<?= htmlspecialchars($product['type']) ?>">
        <img src="<?= htmlspecialchars($product['image_url']) ?>" alt="<?= htmlspecialchars($product['name']) ?>" class="img-fluid">
        <h5 class="card-title"><?= htmlspecialchars($product['name']) ?></h5>
        <p>Price: Ksh <?= htmlspecialchars($product['price']) ?></p>
    </div>
<?php endforeach; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adidas Football Boots</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        /* Background Styling */
body {
    background-color: rgb(180, 179, 179); /* Soft grey background */
    color: #333; /* Dark text for readability */
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
}

/* View Cart Button Styling */
.view-cart-btn {
    background-color: rgb(1, 76, 152);
    border: none;
    font-size: 14px; /* Reduced font size */
    font-weight: bold;
    padding: 8px 15px; /* Reduced padding */
    width: auto; /* Adjust width to fit content */
    display: inline-block; /* Keeps button inline */
    text-align: center;
    border-radius: 5px;
    transition: 0.3s;
    color: white;
}

.view-cart-btn:hover {
    background-color: rgb(0, 65, 230);
    transform: scale(1.05);
}

/* Navbar Styling */
.navbar {
    background-color: rgb(45, 45, 45); /* Dark grey navbar */
    padding: 15px 20px;
}

.navbar-brand, .navbar-nav .nav-link {
    color: white !important; /* White text */
    font-weight: bold;
    text-transform: uppercase;
}

.navbar-nav .nav-link:hover {
    background-color: #0056b3; /* Darker blue on hover */
    border-radius: 5px;
    transition: 0.3s ease-in-out;
}

/* Main Container */
.container {
    margin-top: 30px;
    max-width: 1200px;
}

/* Product Section */
.product-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); /* Responsive grid */
    gap: 20px;
    padding: 20px;
}

/* Product Cards */
.product-card {
    background: white;
    border-radius: 10px;
    padding: 15px;
    text-align: center;
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1); /* Subtle shadow */
    transition: 0.3s ease-in-out;
}

.product-card:hover {
    transform: translateY(-5px); /* Slight lift effect */
    box-shadow: 0px 6px 15px rgba(0, 0, 0, 0.2);
}

/* Product Images */
.product-card img {
    width: 100%;
    height: auto;
    border-radius: 10px;
    object-fit: cover;
}

/* Product Title */
.product-card h4 {
    font-size: 18px;
    font-weight: bold;
    margin: 10px 0;
}

/* Product Price */
.product-card .price {
    font-size: 16px;
    font-weight: bold;
    color: rgb(0, 65, 230); /* Dark blue */
}

/* Buy Button */
.btn-warning {
    background-color: rgb(1, 76, 152);
    border: none;
    font-size: 16px;
    font-weight: bold;
    padding: 10px 20px;
    display: block;
    width: 80%;
    margin: 10px auto;
    text-align: center;
    border-radius: 5px;
    transition: 0.3s;
    color: white;
}

.btn-warning:hover {
    background-color: rgb(0, 65, 230);
    transform: scale(1.05);
}

/* Filter Section */
.filter-section {
    background: rgba(255, 255, 255, 0.2); /* Lightened for visibility */
    padding: 15px;
    border-radius: 10px;
    margin-bottom: 20px;
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
}

/* Responsive Design */
@media (max-width: 768px) {
    .product-grid {
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    }
    .btn-warning {
        width: 100%;
    }
}

    </style>
</head>

<body>

<nav class="navbar navbar-expand-lg">
    <a class="navbar-brand" href="adidas.php"></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
        
     <!--   <a href="contact.php" class ="btn btn-danger"> Contact </a> <br><br> -->

        <a href="logout.php" class="btn btn-danger">Logout</a>
        
        </ul>
    </div>
</nav>

<!-- Main Content -->
<div class="container mt-5">

    <a href="cart.php" class="btn btn-warning">View Cart</a>  
    
    <!-- Displays product items -->
    <div class="row" id="productGrid">
        <?php include 'fetch_adidas.php'; ?>
    </div>
</div>

<!-- Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>

<script>
document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".add-to-cart").forEach(button => {
        button.addEventListener("click", function () {
            let productId = this.getAttribute("data-id");
            let productName = this.getAttribute("data-name");
            let productPrice = this.getAttribute("data-price");
            let sizeSelector = this.closest(".card-body").querySelector(".size-selector");
            let selectedSize = sizeSelector ? sizeSelector.value : null;

            if (!selectedSize) {
                alert("Please select a size before adding to cart.");
                return;
            }

            fetch("add_to_cart.php", {
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body: `product_id=${productId}&name=${encodeURIComponent(productName)}&price=${productPrice}&size=${selectedSize}`
            })
            .then(response => response.json()) // Parse JSON response
            .then(data => {
                alert(data.message); // Show success message only
            })
            .catch(error => console.error("Error:", error));
        });
    });
});
</script>


         
    <div class="row" id="productGrid">
      <?php include 'fetch_adidas.php'; ?>
    </div>

    
</body>
</html>