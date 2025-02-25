<?php
session_start();
require_once 'databasehandler.php'; // Ensure the database handler is included

// Ensure the session has the stored 2FA code
if (!isset($_SESSION['twoFactorCode'])) {
    die("Error: Session expired or 2FA code not set. Please sign up again.");
}

// Debugging (Remove after testing)
echo "Stored 2FA Code: " . $_SESSION['twoFactorCode'] . "<br>";

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get user input and trim whitespace
    $enteredCode = trim($_POST['twoFactorCode']);

    // Debugging (Remove after testing)
    echo "Entered 2FA Code: " . $enteredCode . "<br>";

    // Check if entered code matches stored code
    if ((string) $enteredCode === (string) $_SESSION['twoFactorCode']) {
        // Success: Proceed with registration
        $db = new DatabaseHandler();

        // Check if signup data exists
        if (!isset($_SESSION['signup_data'])) {
            die("Error: Missing user signup data. Please try again.");
        }

        // Get stored user data
        $userData = $_SESSION['signup_data'];

        // Insert into database
        $query = "INSERT INTO students (student_id, email, password, role) VALUES (?, ?, ?, ?)";
        $db->executeQuery($query, [
            $userData['student_id'], 
            $userData['email'], 
            password_hash($userData['password'], PASSWORD_DEFAULT), // Secure password storage
            'student'
        ]);

        // Clear session data
        unset($_SESSION['signup_data']);
        unset($_SESSION['twoFactorCode']);

        // Redirect after successful registration
        header("Location: formlogin.php");
        exit;
    } else {
        echo "Invalid 2FA code. Try again.";
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
        <form method="POST" action="/bootsdirect/verify-2fa.php">
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input 
                    type="email" 
                    class="form-control" 
                    id="email"  
                    name="email" 
                    value="<?php echo isset($_SESSION['userEmail']) ? htmlspecialchars($_SESSION['userEmail']) : ''; ?>" 
                    required 
                >
            </div>

            <div class="mb-3">
                <label for="twoFactorCode" class="form-label">Verification Code</label>
                <input 
                    type="text" 
                    class="form-control" 
                    id="twoFactorCode"  
                    name="twoFactorCode"  
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
