<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once 'databasehandler.php';
session_start();

$dbHandler = new DatabaseHandler();
$pdo = $dbHandler->getPDO();

// Ensure the admin is logged in
$admin_email = $_SESSION['email'] ?? 'admin@example.com';

// Handle admin reply
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['message_id'], $_POST['reply'])) {
    $message_id = $_POST['message_id'];
    $reply_message = trim($_POST['reply']);

    if (!empty($reply_message)) {
        $sender_type = 'admin'; // Marking the message as from admin

        // Update the existing message with the admin's reply
        $stmt = $pdo->prepare("UPDATE messages SET reply = ?, sender_type = ? WHERE id = ?");
        if ($stmt->execute([$reply_message, $sender_type, $message_id])) {
            echo "<p style='color: green;'>Reply sent successfully!</p>";
        } else {
            echo "<p style='color: red;'>Failed to send reply.</p>";
        }
    }
}

// Fetch all messages (latest first)
$sql = "SELECT * FROM messages ORDER BY created_at DESC";
$stmt = $pdo->query($sql);
$messages = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Messages</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
<div class="container mt-5">
    <h2>Admin Messages</h2>

    <ul class="list-group">
        <?php foreach ($messages as $msg): ?>
            <li class="list-group-item">
                <strong>User (<?= htmlspecialchars($msg['username']) ?>):</strong> <?= htmlspecialchars($msg['message']) ?><br>

                <!-- Display reply if available -->
                <?php if (!empty($msg['reply'])): ?>
                    <p class="mt-2"><strong>Admin:</strong> <?= htmlspecialchars($msg['reply']) ?></p>
                <?php endif; ?>

                <!-- Admin reply form -->
                <form action="admin_messages.php" method="POST">
                    <input type="hidden" name="message_id" value="<?= $msg['id'] ?>">
                    <textarea class="form-control mt-2" name="reply" required placeholder="Reply to this user..."></textarea>
                    <button type="submit" class="btn btn-success btn-sm mt-2">Send Reply</button>
                </form>
            </li>
        <?php endforeach; ?>
    </ul>
</div>

</body>
</html>
