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

    if ($admin) {
        echo "Entered Password: " . $password . "<br>"; // Debugging
        echo "Stored Hash: " . $admin['password'] . "<br>"; // Debugging

        // Verify hashed password
        if (password_verify($password, $admin['password'])) {
            $_SESSION['user_id'] = $admin['student_id'];
            $_SESSION['role'] = 'admin';

            echo "Redirecting..."; // Debugging
            header("Location: admin_dashboard.php");
            exit();
        } else {
            echo "<p>Invalid password!</p>";
        }
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
