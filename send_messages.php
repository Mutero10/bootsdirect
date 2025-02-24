<?php
session_start();
require_once 'databasehandler.php';

// Ensure user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: formlogin.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['message'])) {
    $username = $_SESSION['username'];
    $message = trim($_POST['message']);

    if (!empty($message)) {
        $dbHandler = new DatabaseHandler();
        $pdo = $dbHandler->getPDO();

        $sql = "INSERT INTO messages (username, message, sender_type, created_at) VALUES (:username, :message, 'user', NOW())";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['username' => $username, 'message' => $message]);
    }
}

// Redirect to contact.php to prevent form resubmission on refresh
header("Location: contact.php");
exit();
