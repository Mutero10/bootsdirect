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
            background-color:rgba(85, 87, 88, 0.54); /* Light Blue background */
            color: #333; /* Dark text */
            font-family: Arial, sans-serif;
        }

        /* Navbar Styling */
        .navbar {
            background-color:rgb(0, 36, 75); /* Blue navbar */
        }

        .navbar-brand, .navbar-nav .nav-link {
            color: #fff !important; /* White text for navbar items */
        }

        .navbar-nav .nav-link:hover {
            background-color: #0056b3; /* Darker blue on hover */
            border-radius: 5px;
        }

        /* Container Styling */
        .container {
            margin-top: 30px;
        }

        /* Button Styling */
        .btn-warning {
            background-color:rgb(4, 81, 158);
            border: none;
            font-size: 16px;
            font-weight: bold;
            padding: 10px 20px;
            display: block;
            width: 200px;
            margin: 10px auto;
            text-align: center;
            transition: 0.3s;
        }

        .btn-warning:hover {
            background-color:rgb(0, 65, 230);
            transform: scale(1.05);
        }

        .filter-section {
            background: rgba(255, 255, 255, 0.1);
            padding: 15px;
            border-radius: 10px;
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

    
          
    <div class="row" id="productGrid">
      <?php include 'fetch_adidas.php'; ?>
    </div>


    <script>
        // JavaScript for filtering and search functionality
document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('searchInput');
    const typeFilter = document.getElementById('typeFilter');
    const priceFilter = document.getElementById('priceFilter');
    const productCards = document.querySelectorAll('.product-card');

    function filterProducts() {
        const searchText = searchInput.value.toLowerCase();
        const selectedType = typeFilter.value;
        const selectedPrice = priceFilter.value;

        productCards.forEach(card => {
            const title = card.querySelector('.card-title').textContent.toLowerCase();
            const type = card.getAttribute('data-type');
            const price = parseFloat(card.getAttribute('data-price'));
            
            let isVisible = true;

            // Search filter
            if (searchText && !title.includes(searchText)) {
                isVisible = false;
            }

            // Type filter
            if (selectedType && selectedType !== "all" && type !== selectedType) {
                isVisible = false;
            }

            // Price filter
            if (selectedPrice) {
                const [min, max] = selectedPrice.split('-').map(Number);
                if (price < min || (max && price > max)) {
                    isVisible = false;
                }
            }

            // Apply visibility
            card.style.display = isVisible ? 'flex' : 'none';  // Use 'flex' if your product grid uses flexbox
        });
    }

    // Event listeners
    searchInput.addEventListener('input', filterProducts);
    typeFilter.addEventListener('change', filterProducts);
    priceFilter.addEventListener('change', filterProducts);
});

    </script>  
    
</body>
</html>