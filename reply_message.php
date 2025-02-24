<?php
require_once 'databasehandler.php';
session_start();

// Ensure admin is logged in
if (!isset($_SESSION['username'])) {
    header("Location: admin_login.php"); // Redirect if not logged in
    exit();
}

$admin_username = $_SESSION['username']; // Get admin's username

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['message_id'], $_POST['reply'])) {
    $messageId = $_POST['message_id'];
    $reply = trim($_POST['reply']);

    if (!empty($reply)) {
        $dbHandler = new DatabaseHandler();
        $pdo = $dbHandler->getPDO();

        // Fetch recipient username based on the original message
        $stmt = $pdo->prepare("SELECT username FROM messages WHERE id = :id");
        $stmt->execute(['id' => $messageId]);
        $message = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($message) {
            $recipientUsername = $message['username']; // Get original sender's username

            // Insert the admin's reply as a **separate message** with admin's username
            $sql = "INSERT INTO messages (username, message, sender_type, created_at) 
                    VALUES (:admin_username, :message, 'admin', NOW())";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(['admin_username' => $admin_username, 'message' => $reply]);
        }
    }
}

// Redirect to prevent form resubmission on refresh
header("Location: admin_messages.php");
exit();
