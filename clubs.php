<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Home Page</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    .navbar { padding: 20px; } /* Makes the navbar thicker */
    .custom-img { width: 200px; height: auto; } 
    .slideshow-item img {
      width: 100%;
      height: 500px; /* Adjust height as needed */
      object-fit: cover; /* Ensures images fill the space nicely */
  </style>

</head>
<body class="bg-light">

  <nav class="navbar navbar-dark bg-dark px-4">
    <div class="container-fluid">
      <span class="navbar-brand h1">WELCOME</span>
      <div>
        <a href="adidas.php" class="btn btn-outline-light me-2">Adidas</a>
        <a href="nike.php" class="btn btn-outline-light me-2">Nike</a>
        <a href="puma.php" class="btn btn-outline-light">Puma</a>
      </div>
    </div>
  </nav>

  <div class="container text-center mt-4">
    <!-- Popular Right Now -->
    <h1 class="mb-4">NEW ARRIVALS <hr> </h1>
    <div class="row justify-content-center mb-4">
      <div class="col-md-3">
        <img src="boots.webp" class="img-fluid rounded custom-img">
      </div>
      <div class="col-md-3">
        <img src="boots2.jpeg" class="img-fluid rounded custom-img">
      </div>
    </div>

    <!-- Latest Release -->
    <h1 class="mb-4">WHAT'S HOT <hr> </h1>
    <div class="row justify-content-center">
      <div class="col-md-3">
        <img src="boots3.avif" class="img-fluid rounded custom-img">
      </div>
      <div class="col-md-3">
        <img src="boots4.webp" class="img-fluid rounded custom-img">
      </div>
    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>