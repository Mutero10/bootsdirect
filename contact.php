<?php
include 'databasehandler.php';
session_start();

$db = new DatabaseHandler();
$pdo = $db->getPDO();
$username = $_SESSION['username'] ?? 'Guest'; // Retrieve username from session



// Handle message submission
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['message'])) {
    $message = trim($_POST['message']);

    if (!empty($message)) {
        $sender_type = 'user'; // Indicating the message is from a user

        $stmt = $pdo->prepare("INSERT INTO messages (username, message, sender_type, created_at) VALUES (?, ?, ?, NOW())");
        $stmt->execute([$username, $message, $sender_type]);
    }
}

// Retrieve messages from the database
$stmt = $pdo->query("SELECT * FROM messages ORDER BY created_at ASC");
$messages = $stmt ? $stmt->fetchAll(PDO::FETCH_ASSOC) : [];
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Support</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <h2>Contact Support</h2>
        <p>Welcome, <strong></strong> Send a message to the admin below:</p>

        <form action="contact.php" method="POST">
            <textarea class="form-control" name="message" rows="3" placeholder="Type your message..." required></textarea>
            <button type="submit" class="btn btn-dark mt-2">Send Message</button>
        </form>

        <h3 class="mt-4">Message History</h3>
        <div class="card p-3">
            <?php if (!empty($messages)) : ?>
                <?php foreach ($messages as $msg) : ?>
                    <p><strong><?php echo ($msg['sender_type'] === 'admin') ? "Admin" : "You"; ?>:</strong> 
                    <?php echo htmlspecialchars($msg['message']); ?></p>
                <?php endforeach; ?>
            <?php else : ?>
                <p>No messages yet.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
