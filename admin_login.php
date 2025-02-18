<?php
session_start();
require 'databasehandler.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $dbHandler = new DatabaseHandler();
    $sql = "SELECT * FROM students WHERE email = :email AND role = 'admin'";
    $stmt = $dbHandler->pdo->prepare($sql);
    $stmt->execute(['email' => $email]);
    $admin = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($admin && password_verify($password, $admin['password'])) {
        $_SESSION['user_id'] = $admin['id'];
        $_SESSION['role'] = 'admin';
        header("Location: admin_dashboard.php");
        exit();
    } else {
        echo "<p>Invalid login credentials!</p>";
    }
}
?>

<form method="POST" action="">
    <input type="email" name="email" placeholder="Admin Email" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit">Login</button>
</form>
