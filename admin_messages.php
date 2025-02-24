<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once 'databasehandler.php';
session_start();

$dbHandler = new DatabaseHandler();
$pdo = $dbHandler->getPDO();

// Fetch distinct users who have sent messages
$sql = "SELECT DISTINCT username FROM messages ORDER BY created_at DESC";
$stmt = $pdo->query($sql);
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
    <div class="row">

        <!-- Left Sidebar: List of users -->
        <div class="col-md-4">
            <ul class="list-group">
                <?php foreach ($users as $user): ?>
                    <li class="list-group-item">
                        <a href="admin_messages.php?user=<?= urlencode($user['username']) ?>">
                            <?= htmlspecialchars($user['username']) ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>

        <!-- Right Side: Chat Box -->
        <div class="col-md-8">
            <?php if (isset($_GET['user'])): 
                $selectedUser = $_GET['user'];

                // Fetch messages between the admin and the selected user
                $stmt = $pdo->prepare("SELECT * FROM messages WHERE username = ? ORDER BY created_at ASC");
                $stmt->execute([$selectedUser]);
                $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);
            ?>
                <h4>Chat with <?= htmlspecialchars($selectedUser) ?></h4>
                <ul class="list-group">
                    <?php foreach ($messages as $msg): ?>
                        <li class="list-group-item">
                            <strong><?= $msg['sender_type'] === 'admin' ? 'Admin' : 'User' ?>:</strong> 
                            <?= htmlspecialchars($msg['message']) ?>
                        </li>
                    <?php endforeach; ?>
                </ul>

                <!-- Reply Box -->
                <form action="reply_message.php" method="POST">
                    <input type="hidden" name="recipient_username" value="<?= htmlspecialchars($selectedUser) ?>">
                    <textarea class="form-control mt-2" name="reply_message" required></textarea>
                    <button type="submit" class="btn btn-success btn-sm mt-2">Send Reply</button>
                </form>
            <?php endif; ?>
        </div>
    </div>
</div>
</body>
</html>
