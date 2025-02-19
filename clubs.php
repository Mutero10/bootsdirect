<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Home Page</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    .navbar { padding: 20px; background-color:black } /* Makes the navbar thicker */
    .custom-img { width: 200px; height: auto; } 


    /* Layout adjustments */
    .slideshow-container {
      display: flex;
      flex-direction: column; /* Stacks items vertically */
      align-items: center; /* Centers content horizontally */
      justify-content: center;
      height: 80vh; /* Makes sure the content is in the center of the screen */
      position: relative;
    }
  
     /* Center the slideshow and resize images */
     .carousel-container {
      width: 50%; /* Adjust width as needed */
      margin: auto;
    }
    .carousel-item img {
      width: 100%; /* Keeps image responsive */
      max-width: 450px; /* Prevents image from becoming too wide */
      height: auto; /* Maintains aspect ratio */
      object-fit: contain; /* Ensures the full image is visible */
      display: block;
      margin: auto; /* Centers the image */
    }

/* Background Image Styling */
body {
      background: url('back2.jpg') no-repeat center center fixed; /* Replace 'background.jpg' with your image */
      background-size: cover; /* Ensures the image covers the whole screen */
      height: 100%; /* Full screen height */
      margin: 0; /* Removes default margins */
      color: white; /* Ensures text is visible on dark images */
      text-align: center;
    }

/* Optional: Add a slight dark overlay for better readability */
.overlay {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.5); /* Adjust opacity */
      z-index: -1; /* Keeps it behind content */
    }

    /* Centered text */
    .content {
      position: relative;
      z-index: 1; /* Ensures it stays above the overlay */
    }

    /* Bold, black headers */
  h1 {
    font-weight: bold;
    color: black;
  }

  /* Adds hover effect to images */
  .custom-img {
    transition: 0.3s ease-in-out;
    width: 100%; /* Ensures responsive images */
    max-width: 250px; /* Adjust size */
    height: auto; /* Keeps aspect ratio */
  }

  .image-container:hover .custom-img {
    filter: brightness(85%); /* Light grey highlight */
    transform: scale(1.05); /* Slight zoom effect */
  }

  /* Centers text below images */
  .img-text {
    margin-top: 8px;
    font-size: 16px;
    font-weight: bold;
    color: black;
  }
  </style>

</head>
<body class="bg-light">


  <nav class="navbar navbar-dark bg-dark px-4">
    <div class="container-fluid">
      <span class="navbar-brand mx-auto text-center w-100 h1"> STEP UP YOUR GAME</span>
      <div>
        <a href="adidas.php" class="btn btn-outline-light me-2">Adidas</a>
        
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

        <div class="carousel-item">
          <img src="banner4.jpg" class="d-block" alt="Slide 2">
        </div>

        <div class="carousel-item">
          <img src="banner5.jpg" class="d-block" alt="Slide 2">
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



  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

  <script> 
  // Set interval to 5 seconds (5000ms)
  let slideshowElement = document.querySelector('#bannerSlideshow');
  let slideshow = new bootstrap.Carousel(slideshowElement, { interval: 5000 });
  </script>

</body>
</html>