<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once 'databasehandler.php';
session_start();

$dbHandler = new DatabaseHandler();
$pdo = $dbHandler->getPDO();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['conversation_id'], $_POST['reply_message']) && !empty(trim($_POST['reply_message']))) {
        $conversationId = $_POST['conversation_id'];
        $replyMessage = trim($_POST['reply_message']);
        $senderType = 'admin'; // Admin is replying

        // Retrieve the username from the conversation_id
        $stmt = $pdo->prepare("SELECT username FROM messages WHERE conversation_id = ? LIMIT 1");
        $stmt->execute([$conversationId]);
        $userRow = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$userRow) {
            echo "Error: Conversation not found.";
            exit();
        }

        $username = $userRow['username']; // Get the username associated with this conversation

        // Insert the reply into the messages table
        $stmt = $pdo->prepare("INSERT INTO messages (conversation_id, username, message, sender_type, created_at) VALUES (?, ?, ?, ?, NOW())");
        if ($stmt->execute([$conversationId, $username, $replyMessage, $senderType])) {
            header("Location: admin_messages.php?conversation_id=" . urlencode($conversationId));
            exit();
        } else {
            echo "Failed to send reply.";
        }
    } else {
        echo "Message cannot be empty.";
    }
} else {
    echo "Invalid request method.";
}
