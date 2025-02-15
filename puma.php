<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Puma </title>
</head>
<body>

<div class="container mt-5">
    <h1 class="text-center mb-4"> BEST OF PUMA <hr></h1> 

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
      <?php include 'fetch_puma.php'; ?>
    </div>


    <script>
        fetch('fetch_puma.php')
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
</body>
</html>