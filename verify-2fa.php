<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the entered code and email from the form
    $enteredCode = trim($_POST['code'] ?? '');  // Trim code
    $email = trim($_POST['email'] ?? '');        // Trim email

    // Retrieve the stored code and email from the session
    $storedCode = $_SESSION['twoFactorCode'] ?? null; // Get the 2FA code from session
    $storedEmail = $_SESSION['userEmail'] ?? null;   // Get the email from session

    // Debugging: Output the stored and entered values
    //echo "<pre>";
    //var_dump($enteredCode, $storedCode, $email, $storedEmail);
    //echo "</pre>";


    // Check if the entered code and email match the stored values
    if ($enteredCode === $storedCode && $email === $storedEmail) {
        echo "<h2>2FA verification successful! You are now signed up.</h2>";
       
        unset($_SESSION['twoFactorCode']);  // Clear the stored 2FA code
        unset($_SESSION['userEmail']);      // Clear the stored email
        
        header('Location: /api_exempt/includes/formsubmit.php');  // Redirect to a welcome page
        exit();
    } else {
        echo "<h2>Invalid verification code or email. Please try again.</h2>";
    }
} else {
    header('Location: /api_exempt/includes/formsubmit.php'); // Redirect to signup if directly accessed
    exit();
}
?>

<!-- Verification form -->
<form method="POST" action="verify-2fa.php">
    <label for="email">Email:</label>
    <input type="email" name="email" value="<?php echo htmlspecialchars($_SESSION['userEmail']); ?>" required>
    
    <label for="code">Verification Code:</label>
    <input type="text" name="code" required>
    
    <button type="submit">Verify</button>
</form>

