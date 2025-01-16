<?php
session_start();
require_once 'databasehandler.php'; // Ensure this file has your database connection logic
require_once 'PHPMailer/PHPMailer.php'; // Include PHPMailer for email functionality

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);

    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $dbHandler = new DatabaseHandler();

        // Check if the user exists in the database
        $user = $dbHandler->getUserByEmail($email);

        if ($user) {
            // Generate a unique reset token
            $token = bin2hex(random_bytes(16)); // 32-character secure token
            $tokenExpiry = date('Y-m-d H:i:s', strtotime('+1 hour')); // Token expires in 1 hour

            // Store the token and its expiry in the database
            $dbHandler->storeResetToken($email, $token, $tokenExpiry);

            // Generate the password reset link
            $resetLink = "http://localhost/includes/reset_password.php?token=" . urlencode($token);

            // Send the reset link to the user's email
            $mail = new PHPMailer\PHPMailer\PHPMailer();
            $mail->setFrom('amutero5@gmail.com', 'Your App');
            $mail->addAddress($email);
            $mail->Subject = "Password Reset Request";
            $mail->Body = "Click the link below to reset your password:\n\n" . $resetLink;

            if ($mail->send()) {
                echo "<p>A password reset link has been sent to your email address.</p>";
            } else {
                echo "<p>Failed to send the reset email. Please try again later.</p>";
            }
        } else {
            echo "<p>No account found with that email address.</p>";
        }
    } else {
        echo "<p>Invalid email address. Please try again.</p>";
    }
}
?>

<form method="POST" action="">
    <label for="email">Enter your email address:</label>
    <input type="email" name="email" required>
    <button type="submit">Send Reset Link</button>
</form>
