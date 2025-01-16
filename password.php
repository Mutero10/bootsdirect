<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);

    // Validate the email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<p>Invalid email format. Please try again.</p>";
    } else {
        // Include database connection
        require_once 'databasehandler.php';

        // Check if the email exists in the database
        $dbHandler = new DatabaseHandler();
        $user = $dbHandler->getUserByEmail($email); // Define a method to fetch the user

        if ($user) {
            // Generate a unique token
            $resetToken = bin2hex(random_bytes(16));
            $expiry = date('Y-m-d H:i:s', strtotime('+1 hour'));

            // Update the database with the token and expiry
            $dbHandler->storeResetToken($email, $resetToken, $expiry);

            // Send the reset link to the user's email
            require 'tuesday.php'; // Assume PHPMailer is set up here
            $resetLink = "http://localhost/includes/reset_password.php?token=$resetToken";
            $subject = "Password Reset Request";
            $body = "Hi, <br><br>Click <a href='$resetLink'>here</a> to reset your password. The link will expire in 1 hour.<br><br>Thanks!";
            
            $mail = new PHPMailer(true);
            try {
                // Set mail parameters
                $mail->setFrom('amutero5@gmail.com', 'Your Application');
                $mail->addAddress($email);
                $mail->Subject = $subject;
                $mail->Body = $body;
                $mail->isHTML(true);
                $mail->send();
                echo "<p>Password reset link has been sent to your email.</p>";
            } catch (Exception $e) {
                echo "<p>Failed to send email. Please try again.</p>";
            }
        } else {
            echo "<p>Email not found in our system.</p>";
        }
    }
}
?>

<form method="POST" action="reset_password.php">
    <label for="email">Enter your email address:</label>
    <input type="email" name="email" required>
    <button type="submit">Request Password Reset</button>
</form>
