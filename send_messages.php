<?php
session_start();
require_once 'databasehandler.php';

// Ensure user is logged in
if (!isset($_SESSION['email'])) {
    header("Location: formlogin.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['message'])) {
    $email = $_SESSION['email'];
    $message = trim($_POST['message']);

    if (!empty($message)) {
        $dbHandler = new DatabaseHandler();
        $pdo = $dbHandler->getPDO();

        $sql = "INSERT INTO messages (user_email, message) VALUES (:email, :message)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['email' => $email, 'message' => $message]);
    }
}

header("Location: contact.php");
exit();
