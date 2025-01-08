<?php
session_start();

require __DIR__ . '/../vendor/autoload.php';

//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
require 'C:/xampp/htdocs/api_exempt/vendor/autoload.php';

$twoFactorCode = mt_rand(100000, 999999); // Generate a 6-digit code

//session_start();
$_SESSION['twoFactorCode'] = $twoFactorCode;
$_SESSION['userEmail'] = $_POST['email']; // Store user's email for verification
echo "Generated Code: " . $twoFactorCode;  // For debugging purposes

// Debugging to check session variables
echo "<pre>";
var_dump($_SESSION['twoFactorCode'], $_SESSION['userEmail']);
echo "</pre>";

function send2FACode($userEmail, $twoFactorCode) {
    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // Your SMTP server
        $mail->SMTPAuth = true;
        $mail->Username = 'amutero5@gmail.com'; // Your email address
        $mail->Password = 'bzvo eqtv imcc rzfd';   // Your app password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        //Recipients
        $mail->setFrom('exempt@gmail.com', 'Mailer');
        $mail->addAddress('mutero.27.andrew@gmail.com', 'Andrew Mutero');

        //Content
        $mail->isHTML(true);
        $mail->Subject = 'Your 2FA Code';
        $mail->Body    = "Your verification code is: <strong>$twoFactorCode</strong>";
        $mail->AltBody = "Your verification code is: $twoFactorCode";

        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log("Error sending email: {$mail->ErrorInfo}");
        return false;
    }
}

if (!send2FACode($_POST['email'], $twoFactorCode)) {
    echo "Failed to send the 2FA code. Please try again.";
    exit;
}

header('Location: /api_exempt/includes/verify-2fa.php');
exit;

//session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $enteredCode = $_POST['twoFactorCode'];

    if ($enteredCode == $_SESSION['twoFactorCode']) {
        echo "2FA Verification Successful!";
        // Proceed with the signup process
        // Clear the session
        unset($_SESSION['twoFactorCode']);
    } else {
        echo "Invalid 2FA Code. Please try again.";
    }
}

?>
<form method="POST">
    <label for="twoFactorCode">Enter the 2FA Code sent to your email:</label>
    <input type="text" name="twoFactorCode" id="twoFactorCode" required>
    <button type="submit">Verify</button>
</form>


