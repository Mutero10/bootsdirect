<?php
require_once 'databasehandler.php';

if (isset($_GET['token'])) {
    $token = $_GET['token']; // Retrieve the token from the URL
    $dbHandler = new DatabaseHandler();

    // Fetch the user by the token
    $user = $dbHandler->getUserByToken($token);

    if ($user) {
        // Check if the token has expired
        if (strtotime($user['token_expiry']) > time()) {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $newPassword = trim($_POST['new_password']);
                $confirmPassword = trim($_POST['confirm_password']);

                if ($newPassword === $confirmPassword) {
                    // Hash the new password
                    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

                    // Update the user's password in the database
                    $dbHandler->updateUserPassword($user['email'], $hashedPassword);

                    // Clear the reset token and expiry
                    $dbHandler->clearResetToken($user['email']);

                    echo "<p>Your password has been successfully reset.</p>";
                    exit();
                } else {
                    echo "<p>Passwords do not match. Please try again.</p>";
                }
            }
        } else {
            echo "<p>This reset link has expired. Please request a new one.</p>";
        }
    } else {
        echo "<p>Invalid reset link or token not found in the database.</p>";
    }
} else {
    echo "<p>No reset token provided in the URL.</p>";
}
?>

<<form method="POST" action="">
    <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">
    
    <label for="new_password">Enter new password:</label>
    <input type="password" name="new_password" required>
    
    <label for="confirm_password">Confirm new password:</label>
    <input type="password" name="confirm_password" required>
    
    <button type="submit">Reset Password</button>
</form>

