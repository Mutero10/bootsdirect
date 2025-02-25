<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if Composer's autoload file exists
$autoloadPath = __DIR__ . '/vendor/autoload.php';
if (!file_exists($autoloadPath)) {
    die("❌ Composer autoload file not found! Run 'composer install' in your project directory.");
}

// Load Composer's autoloader
require $autoloadPath;

// Check if PHPMailer class exists
if (!class_exists('PHPMailer\PHPMailer\PHPMailer')) {
    die("❌ PHPMailer class not found! Check if PHPMailer is installed correctly.");
}

// Import PHPMailer classes
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Check if session data exists
if (!isset($_SESSION['signup_data']['email'])) {
    die("⚠️ Session expired. Please sign up again.");
}

$email = $_SESSION['signup_data']['email'];
$twoFactorCode = mt_rand(100000, 999999);
$_SESSION['twoFactorCode'] = $twoFactorCode;

// Create PHPMailer object
$mail = new PHPMailer(true);

try {
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'amutero5@gmail.com';  // Replace with your email
    $mail->Password = 'bzvo eqtv imcc rzfd'; // Replace with your app password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    $mail->setFrom('your-email@gmail.com', 'BootsDirect 2FA');
    $mail->addAddress($email);
    $mail->isHTML(true);
    $mail->Subject = 'Your 2FA Verification Code';
    $mail->Body = "<h2>Your verification code is:</h2> <h1>$twoFactorCode</h1>";

    if (!$mail->send()) {
        die("❌ Error sending email: " . $mail->ErrorInfo);
    } else {
        header('Location: verify-2fa.php');
        exit();
    }
} catch (Exception $e) {
    die("❌ PHPMailer Error: " . $mail->ErrorInfo);
}
?>





<form method="POST">
    <label for="twoFactorCode">Enter the 2FA Code sent to your email:</label>
    <input type="text" name="twoFactorCode" id="twoFactorCode" required>
    <button type="submit">Verify</button>
</form>

