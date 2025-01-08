<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $enteredCode = $_POST['code'];  // The code entered by the user
    $email = $_POST['email'];      // The email entered by the user

    // Retrieve stored values from session
    $storedCode = $_SESSION['twoFactorCode'] ?? null;
    $storedEmail = $_SESSION['userEmail'] ?? null;

    // Check if the entered code and email match the stored values
    if ($enteredCode == $storedCode && $email == $storedEmail) {
        echo "<h2>2FA verification successful! You are now signed up.</h2>";
       
        // Clear the stored session data
        unset($_SESSION['twoFactorCode']);  
        unset($_SESSION['userEmail']);      
        
        // Redirect to the signup page or another welcome page
        header('Location: /includes/formsubmit.php');  // Adjust to your desired page
        exit();
    } else {
        // Display an error message if the code or email is invalid
        echo "<h2>Invalid verification code or email. Please try again.</h2>";
    }
} else {
    // Prevent direct access to this page if session data is missing
    if (!isset($_SESSION['twoFactorCode']) || !isset($_SESSION['userEmail'])) {
        header('Location: /includes/formsubmit.php');  // Redirect to the signup page
        exit();
    }
}
?>

<!-- Verification form -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>2FA Verification</title>
    
    <!-- Include Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="card shadow p-4" style="width: 100%; max-width: 400px;">
        <h3 class="text-center mb-4">2FA Verification</h3>
        <form method="POST" action="verify-2fa.php">
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input 
                    type="email" 
                    class="form-control" 
                    name="email" 
                    value="<?php echo htmlspecialchars($_SESSION['userEmail']); ?>" 
                    required 
                >
            </div>
            <div class="mb-3">
                <label for="code" class="form-label">Verification Code</label>
                <input 
                    type="text" 
                    class="form-control" 
                    name="code" 
                    placeholder="Enter code" 
                    required 
                >
            </div>
            <div class="d-grid">
                <button type="submit" class="btn btn-primary">Verify</button>
            </div>
        </form>
    </div>
</div>

<!-- Include Bootstrap JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
