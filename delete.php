<?php
session_start();
require 'databasehandler.php';

// Ensure only admins can access
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    die("Access Denied! You are not an admin.");
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $dbHandler = new DatabaseHandler();
    $pdo = $dbHandler->getPDO();

    try {
        $sql = "DELETE FROM products WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['id' => $id]);

        echo "<p>Product deleted successfully!</p>";
    } catch (Exception $e) {
        die("Error deleting product: " . $e->getMessage());
    }
} else {
    die("No product selected!");
}
?>

<a href="admin_dashboard.php">Back to Dashboard</a>
