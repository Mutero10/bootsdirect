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

    
</body>
</html>