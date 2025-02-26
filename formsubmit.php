<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'databasehandler.php';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['student_id']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Basic validation
    if (empty($name) || empty($email) || empty($password)) {
        die("All fields are required!");
    }

    // Hash the password for security
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Store user data temporarily in session (not inserting into DB yet)
    $_SESSION['signup_data'] = [
        'name' => $name,
        'email' => $email,
        'password' => $hashedPassword
    ];

    // Redirect to tuesday.php to generate & send the 2FA code
    header('Location: tuesday.php');
    exit();
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Submission</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
    body {
            background:rgb(65, 66, 67); /* Dark blue */
            color: white;
            font-family: Arial, sans-serif;
        }
</style>

</head>

<body class="bg-light">
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="card p-4 shadow" style="width: 100%; max-width: 500px;">

        <!-- Image -->
         <div class ="col-md-12 text-center">
            <img src = "nike.png" alt ="Signup" class ="img-fluid rounded w-100">
        </div>


        <!-- Form --> 
           <h1 class="text-center mb-4" style ="font-family: 'Palatino Black', serif;">SIGN UP</h1>
            <form action ="formsubmit.php" method="POST" id="form" novalidate>

                <div class="mb-3">
                    <label for="student_id" class="form-label">Name</label>
                    <input type="text" class="form-control" id="student_id" name="student_id" placeholder="Enter your names" required>
                </div> 

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="e.g., username@gmail.com" required>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Enter Password" required>
                </div>

                
                <div id="error" style="color: red; margin-top: 10px;"></div>
       
        <!-- Buttons-->
            <div class ="text-center">
                <button type ="submit" class ="btn btn-dark w-50"> Sign Up</button>
                <br> <br>
                <a href ="formlogin.php" class ="btn btn-dark w-50"> Log In </a>
            </div>

            </form>
        </div>
    </div>

   <!-- <form id="verifyForm">
       <label for="verificationCode">Verification Code:</label>
       <input type="text" id="verificationCode" name="verificationCode" required>
       <button type="submit">Verify</button>
    </form>
-->
    <!-- Include Bootstrap Bundle with JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="formvalidate.js"></script>

</body>
</html> 