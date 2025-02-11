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

     /* Center the slideshow and resize images */
     .carousel-container {
      width: 50%; /* Adjust width as needed */
      margin: auto;
    }
    .carousel-item img {
      width: 100%; /* Keeps image responsive */
      max-width: 400px; /* Prevents image from becoming too wide */
      height: auto; /* Maintains aspect ratio */
      object-fit: contain; /* Ensures the full image is visible */
      display: block;
      margin: auto; /* Centers the image */
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

  <!-- Bootstrap Slideshow -->
  <div class="carousel-container">
    <div id="bannerSlideshow" class="carousel slide" data-bs-ride="carousel" data-bs-interval="6000">
      <div class="carousel-inner">
        <div class="carousel-item active">
          <img src="banner1.jpg" class="d-block" alt="Slide 1">
        </div>
        <div class="carousel-item">
          <img src="banner2.jpg" class="d-block" alt="Slide 2">
        </div>
        <div class="carousel-item">
          <img src="banner3.jpg" class="d-block" alt="Slide 3">
        </div>
      </div>
      
      
      <!-- Optional: Slideshow Controls -->
      <button class="carousel-control-prev" type="button" data-bs-target="#bannerSlideshow" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#bannerSlideshow" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
      </button>
    </div>
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