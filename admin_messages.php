<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once 'databasehandler.php';
session_start();

$dbHandler = new DatabaseHandler();
$pdo = $dbHandler->getPDO();

// Fetch all conversations
$sql = "SELECT DISTINCT conversation_id, username FROM messages ORDER BY created_at DESC";
$stmt = $pdo->query($sql);
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

$messages = [];
$selectedUser = "";
$conversationId = "";

if (isset($_GET['conversation_id'])) {
    $conversationId = $_GET['conversation_id'];

    // Fetch chat messages
    $stmt = $pdo->prepare("SELECT * FROM messages WHERE conversation_id = ? ORDER BY created_at ASC");
    $stmt->execute([$conversationId]);
    $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Get the username for this conversation
    $selectedUser = $messages[0]['username'] ?? "";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Chat</title>
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
            align-self: flex-start;
        }
        .admin-message {
            background-color: #e9ecef;
            color: black;
            align-self: flex-end;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h2>Admin Chat</h2>
        <div class="row">
            <div class="col-md-4">
                <ul class="list-group">
                    <?php foreach ($users as $user): ?>
                        <li class="list-group-item">
                            <a href="admin_messages.php?conversation_id=<?= urlencode($user['conversation_id']) ?>">
                                <?= htmlspecialchars($user['username']) ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <div class="col-md-8">
                <?php if ($conversationId): ?>
                    <h4>Chat with <?= htmlspecialchars($selectedUser) ?></h4>
                    <div class="chat-container">
                        <?php foreach ($messages as $msg): ?>
                            <div class="message <?= $msg['sender_type'] === 'admin' ? 'admin-message' : 'user-message' ?>">
                                <?= htmlspecialchars($msg['message']) ?>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <!-- Reply Box -->
                    <form action="reply_message.php" method="POST">
                        <input type="hidden" name="conversation_id" value="<?= htmlspecialchars($conversationId) ?>">
                        <textarea class="form-control mt-2" name="reply_message" required></textarea>
                        <button type="submit" class="btn btn-success btn-sm mt-2">Send Reply</button>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>