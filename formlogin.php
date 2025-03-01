<?php
// Start session
session_start();

// Include necessary files
require_once 'databasehandler.php';


// Preserve cart before logging in
$cartBackup = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];

// Check if the form has been submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Initialize DatabaseHandler
    $dbHandler = new DatabaseHandler();

    // Get user credentials
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check if the credentials are correct (use your own database logic)
    if ($dbHandler->checkLogin($username, $password)) {
        // Regenerate session ID for security
        session_regenerate_id(true);

        // Restore cart data after login
        $_SESSION['cart'] = $cartBackup;

        // Set session username
        $_SESSION['username'] = $username;

        // Redirect to clubs.php
        header("Location: clubs.php");
        exit();
    } else {
        echo "<p>Invalid username or password!</p>";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="card p-4 shadow" style="width: 100%; max-width: 400px;">

        <!-- Image -->
        <div class ="col-md-12 text-center"> 
            <img src ="messi.jpg" alt ="LogIn" class ="img-fluid rounded w-100">
        </div>

            
        <h1 class="text-center mb-4" style ="font-family: 'Palatino Black', serif;">LOGIN</h1>
            <form action="clubs.php" id ="loginForm"  method="POST">
               
               <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="e.g., username@gmail.com" required>
                </div>

                <div class="mb-3">
                 <label for="password" class="form-label">Password</label>
                 <input type="password" class="form-control" id="password" name="password" placeholder="Enter Password" required>
                </div>

                <div id="error" style="color: red; margin-top: 10px;"></div>

            <a href="formsubmit.php"> Don't have an account? </a> 
            <div class ="text-center">
                <button type="submit" class="btn btn-dark w-50">LogIn</button>
            </div>

            </form>
        </div>
    </div>

    <!-- Include Bootstrap Bundle with JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <script src ="formvalidate.js?v=1.0"></script>
</body>
</html>