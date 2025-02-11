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
    }
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

  <!-- Banner slideshow --> 
<div id="bannerSlideshow" class="slideshow slide" data-bs-ride="slideshow">
    <div class="slideshow-inner">
      <div class="slideshow-item active">
        <img src="banner1.jpg" class="d-block w-100" alt="Slide 1">
      </div>
      <div class="slideshow-item">
        <img src="banner2.jpg" class="d-block w-100" alt="Slide 2">
      </div>
      <div class="slideshow-item">
        <img src="banner3.jpg" class="d-block w-100" alt="Slide 3">
      </div>
    </div>

  <!-- Slideshow Controls -->
    <button class="slideshow-control-prev" type="button" data-bs-target="#bannerSlideshow" data-bs-slide="prev">
      <span class="slideshow-control-prev-icon" aria-hidden="true"></span>
    </button>
    <button class="slideshow-control-next" type="button" data-bs-target="#bannerSlideshow" data-bs-slide="next">
      <span class="slideshow-control-next-icon" aria-hidden="true"></span>
    </button>
  </div>


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

  <script> 
  // Set interval to 5 seconds (5000ms)
  let slideshowElement = document.querySelector('#bannerSlideshow');
  let slideshow = new bootstrap.Carousel(slideshowElement, { interval: 5000 });
  </script>

</body>
</html>