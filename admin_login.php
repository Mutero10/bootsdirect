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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="d-flex align-items-center justify-content-center vh-100 bg-light">

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card shadow-lg">
                <div class="card-header bg-dark text-white text-center">
                    <h4>Admin Login</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="">
                        <div class="mb-3">
                            <label for="email" class="form-label">Admin Email</label>
                            <input type="email" id="email" name="email" class="form-control" placeholder="Enter your email" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" id="password" name="password" class="form-control" placeholder="Enter your password" required>
                        </div>
                        <button type="submit" class="btn btn-dark w-100">Login</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>

