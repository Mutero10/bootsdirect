<?php
session_start();
require 'databasehandler.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') { 
    $email = $_POST['email'];
    $password = $_POST['password'];

    $dbHandler = new DatabaseHandler();
    $pdo = $dbHandler->getPDO();

    $sql = "SELECT student_id, email, password FROM students WHERE email = :email AND role = 'admin'";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['email' => $email]);
    $admin = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$admin) {
        echo "<p>No admin found with this email.</p>";
        exit();
    }

    // ✅ Debugging: Print stored hash
    var_dump($admin); // See full array output

    echo "<br>Entered Password: " . $password;
    echo "<br>Stored Hash: " . ($admin['password'] ?? 'NULL');

    if (!empty($admin['password']) && password_verify($password, $admin['password'])) {
        $_SESSION['student_id'] = $admin['student_id'];
        $_SESSION['role'] = 'admin';
        header("Location: admin_dashboard.php");
        exit();
    } else {
        echo "<p>Invalid password!</p>";
    }
}


?>


<form method="POST" action="admin_login.php">
    <input type="email" name="email" placeholder="Admin Email" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit" name="login">Login</button>
</form>

