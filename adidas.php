<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Adidas Football Boots</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

</head>
<body>
<div class="container mt-5">
        <h1 class="text-center mb-4"> BEST OF ADIDAS <hr></h1> 

        <nav>
    <ul>
        <li><a href="products.php?brand=adidas">Adidas Products</a></li>
        <li><a href="products.php?brand=puma">Puma Products</a></li>
    </ul>
</nav>

<!-- Filter Section -->
    <div class="filter-section">
    <div class="row">
        <div class="col-md-4">
        <input type="text" id="searchInput" class="form-control" placeholder="Search boots...">
    </div>
        <div class="col-md-4">
        <select id="typeFilter" class="form-control">
            <option value="">All Types</option>
            <option value="firm-ground">Firm Ground</option>
            <option value="soft-ground">Soft Ground</option>
            <option value="artificial-grass">Artificial Grass</option>
            <option value="indoor">Indoor</option>
            </select>
        </div>

        <div class="col-md-4">
        <select id="priceFilter" class="form-control">
            <option value="all">All Prices</option>
            <option value="6000-6500">6000 - 6500</option>
            <option value="5000-5999">5000 - 5999</option>
            <option value="4000-4999">4000 - 4999</option>
        </select>
        </div>
        </div>
        </div>
          
    <div class="row" id="productGrid">
      <?php include 'products.php'; ?>
    </div>

    <!-- Pagination -->
    <nav>
    <ul class="pagination justify-content-center">
    <li class="page-item disabled">
        <a class="page-link" href="#" tabindex="-1">Previous</a>
    </li>
        <li class="page-item active"><a class="page-link" href="#">1</a></li>
        <li class="page-item"><a class="page-link" href="#">2</a></li>
        <li class="page-item"><a class="page-link" href="#">3</a></li>
        <li class="page-item">
           <a class="page-link" href="#">Next</a>
        </li>
     </ul>
    </nav>
    </div>

    <div id="productContainer" class="row"></div>


    <script>
        fetch('fetch_products.php')
        .then(response => response.json())
        .then(data => {
            let container = document.getElementById('productContainer');
            container.innerHTML = data.map(product => `
                <div class="col-md-4 mb-4 product-card">
                <div class="card h-100">
                    <img src="images/${product.image}" class="card-img-top" alt="${product.name}">
                    <div class="card-body">
                        <h5 class="card-title">${product.name}</h5>
                        <p class="card-text">Ksh ${product.price}</p>
                        <a href="#" class="btn btn-primary">View Details</a>
                    </div>
                </div>
            </div>
            `).join('');
        })
        .catch(error => console.error('Error:', error));

    document.getElementById('searchInput').addEventListener('input', fetchProducts);
    document.getElementById('priceFilter').addEventListener('change', fetchProducts);

function fetchProducts() {
    let search = document.getElementById('searchInput').value;
    let price = document.getElementById('priceFilter').value;
    
    fetch(`fetch_products.php?search=${search}&price=${price}`)
        .then(response => response.json())
        .then(data => {
            let container = document.getElementById('productContainer');
            container.innerHTML = data.map(product => `
                <div class="col-md-4 mb-4 product-card">
                <div class="card h-100">
                    <img src="images/${product.image}" class="card-img-top" alt="${product.name}">
                    <div class="card-body">
                        <h5 class="card-title">${product.name}</h5>
                        <p class="card-text">Ksh ${product.price}</p>
                        <a href="#" class="btn btn-primary">View Details</a>
                    </div>
                </div>
                </div>
            `).join('');
        })
        .catch(error => console.error('Error:', error));
}

// JavaScript for filtering and search functionality
    document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('searchInput');
    const typeFilter = document.getElementById('typeFilter');
    const priceFilter = document.getElementById('priceFilter');
    const productCards = document.querySelectorAll('.product-card');

    function filterProducts() {
        const searchText = searchInput.value.toLowerCase();
        const selectedType = typeFilter ? typeFilter.value : "all"; // Handle cases where typeFilter is missing
        const selectedPrice = priceFilter.value;

    productCards.forEach(card => {
        const title = card.querySelector('.card-title').textContent.toLowerCase();
        const type = card.getAttribute('data-type');
        const price = parseFloat(card.getAttribute('data-price')); // Ensure proper number conversion
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
        if (selectedPrice !== "all") {
            const priceRange = selectedPrice.split('-').map(num => parseInt(num.trim(), 10));
            if (priceRange.length === 2) {
                const min = priceRange[0];
                const max = priceRange[1];
                if (isNaN(price) || price < min || price > max) {
                        isVisible = false;
                    }
                }
            }

    // Apply final visibility
        card.style.display = isVisible ? 'block' : 'none';
        });
    }

    // Event Listeners
        searchInput.addEventListener('input', filterProducts);
        typeFilter.addEventListener('change', filterProducts);
        priceFilter.addEventListener('change', filterProducts);
});

    </script>  
    
</body>
</html>