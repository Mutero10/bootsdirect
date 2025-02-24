<?php
require_once 'databasehandler.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['message_id'], $_POST['reply'])) {
    $messageId = $_POST['message_id'];
    $reply = trim($_POST['reply']);

    if (!empty($reply)) {
        $dbHandler = new DatabaseHandler();
        $pdo = $dbHandler->getPDO();

        $sql = "UPDATE messages SET reply = :reply WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['reply' => $reply, 'id' => $messageId]);
    }
}

header("Location: admin_messages.php");
exit();
