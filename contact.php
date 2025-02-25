<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'databasehandler.php';
session_start();

$db = new DatabaseHandler();
$pdo = $db->getPDO();

$username = $_SESSION['username'] ?? 'Guest';

// Handle message submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['message']) && !empty(trim($_POST['message']))) {
        $message = trim($_POST['message']);
        $sender_type = 'user';

        // Ensure the user has a conversation ID
        $stmt = $pdo->prepare("SELECT conversation_id FROM messages WHERE username = ? LIMIT 1");
        $stmt->execute([$username]);
        $conversation = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$conversation) {
            // Create a new conversation ID
            $conversation_id = uniqid();
        } else {
            $conversation_id = $conversation['conversation_id'];
        }

        // Insert message
        $stmt = $pdo->prepare("INSERT INTO messages (conversation_id, username, message, sender_type, created_at) VALUES (?, ?, ?, ?, NOW())");
        if ($stmt->execute([$conversation_id, $username, $message, $sender_type])) {
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        }
    }
}

// Retrieve chat history
$stmt = $pdo->prepare("SELECT * FROM messages WHERE username = ? ORDER BY created_at ASC");
$stmt->execute([$username]);
$messages = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chatbox</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .chat-container {
            max-width: 600px;
            margin: auto;
            background: #f9f9f9;
            border-radius: 10px;
            padding: 15px;
            height: 500px;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
        }
        .message {
            max-width: 70%;
            padding: 10px 15px;
            margin: 5px 0;
            border-radius: 15px;
            word-wrap: break-word;
        }
        .user-message {
            background-color: #007bff;
            color: white;
            align-self: flex-end;
        }
        .admin-message {
            background-color: #e9ecef;
            color: black;
            align-self: flex-start;
        }
        .chat-input {
            margin-top: 10px;
            display: flex;
        }
        .chat-input textarea {
            flex-grow: 1;
            border-radius: 10px;
            padding: 5px;
        }
        .chat-input button {
            margin-left: 5px;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h3 class="text-center">Chat with Admin</h3>
        <div class="chat-container">
            <?php foreach ($messages as $msg): ?>
                <div class="message <?= $msg['sender_type'] === 'user' ? 'user-message' : 'admin-message' ?>">
                    <?= htmlspecialchars($msg['message']) ?>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Message Input -->
        <form method="POST" class="chat-input">
            <textarea name="message" class="form-control" required placeholder="Type your message..."></textarea>
            <button type="submit" class="btn btn-primary">Send</button>
        </form>
    </div>
</body>
</html>
