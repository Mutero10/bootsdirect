<?php
session_start();

$message = ''; // Variable for storing feedback messages
$messageType = ''; // 'success' or 'error'

// Include necessary files
require_once 'databasehandler.php';
require_once 'formhandler.php';

// Check if the form has been submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Initialize DatabaseHandler
    $dbHandler = new DatabaseHandler();

    // Initialize FormHandler
    $formHandler = new FormHandler($dbHandler);

    // Handle form submission
    $formHandler->handleFormSubmission($_POST);

    // Now, generate the 2FA code using tuesday.php logic
    include('tuesday.php');  // Ensure tuesday.php generates the 2FA code and stores it in $_SESSION

    // Redirect to verify-2fa.php for the user to input the verification code
    header('Location: verify-2fa.php');
    exit();
    include 'formsubmit.php';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Submission</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="card p-4 shadow" style="width: 100%; max-width: 500px;">

        <!-- Image -->
         <div class ="col-md-12 text-center">
            <img src = "Chess photo.jpg" alt ="Signup" class ="img-fluid rounded w-100">
        </div>


        <!-- Form --> 
           <h1 class="text-center mb-4" style ="font-family: 'Palatino Black', serif;">CLUBS SIGN UP</h1>
            <form action ="formsubmit.php" method="POST" id="form" novalidate>

                <div class="mb-3">
                    <label for="student_id" class="form-label">Student ID</label>
                    <input type="text" class="form-control" id="student_id" name="student_id" placeholder="Enter Student ID" required>
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
        <!-- Password link -->
          <a href ="password.php"> Forgotten Password? </a>

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
