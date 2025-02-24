<?php
require_once 'databasehandler.php';

$dbHandler = new DatabaseHandler();
$pdo = $dbHandler->getPDO();

// Fetch all messages
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
                    <strong>User (<?= htmlspecialchars($msg['user_email']) ?>):</strong> <?= htmlspecialchars($msg['message']) ?><br>
                    <form action="reply_message.php" method="POST">
                        <input type="hidden" name="message_id" value="<?= $msg['id'] ?>">
                        <textarea class="form-control mt-2" name="reply" required><?= htmlspecialchars($msg['reply'] ?? '') ?></textarea>
                        <button type="submit" class="btn btn-success btn-sm mt-2">Send Reply</button>
                    </form>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</body>
</html>
