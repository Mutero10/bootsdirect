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
        <h1 class="text-center mb-4">Adidas Football Boots</h1>

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
                        <option value="">All Prices</option>
                        <option value="0-50">Under Ksh 50</option>
                        <option value="50-100">Ksh50 - Ksh100</option>
                        <option value="100-150">Ksh100 - Ksh150</option>
                        <option value="150">Above Ksh150</option>
                    </select>
                </div>
            </div>
        </div>

          <!-- Products Grid -->
          <div class="row" id="productGrid">
            <!-- Example Product Card -->
            <div class="col-md-4 mb-4 product-card" data-type="firm-ground" data-price="120">
                <div class="card h-100">
                    <img src="boot1.jpg" class="card-img-top product-image" alt="Adidas Predator">
                    <div class="card-body">
                        <h5 class="card-title">Adidas Predator</h5>
                        <p class="card-text">$120</p>
                        <a href="#" class="btn btn-primary">View Details</a>
                    </div>
                </div>
            </div>
            <!-- More product cards... -->
        </div>
        
<h1 style ="text-align:center"> BEST OF ADIDAS </h1> <hr>
    
</body>
</html>