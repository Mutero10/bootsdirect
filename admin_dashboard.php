<?php
session_start();
require 'databasehandler.php';

// Ensure only admins can access this page
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: admin_login.php");
    exit();
}

// Get database connection
$dbHandler = new DatabaseHandler();
$pdo = $dbHandler->getPDO(); // ✅ Use the getter method

// Fetch product statistics
$sql = "SELECT name, quantity FROM products";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Convert data to JSON safely
$chartData = json_encode($products);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>

<h2>Product Statistics</h2>
<canvas id="productChart"></canvas>

<script>
    let products = <?php echo $chartData ?: '[]'; ?>; // ✅ Prevent JSON errors

    if (products.length === 0) {
        document.write("<p>No product data available.</p>"); // Show message if empty
    } else {
        let labels = products.map(p => p.name);
        let quantities = products.map(p => p.quantity);

        new Chart(document.getElementById("productChart"), {
            type: "bar",
            data: {
                labels: labels,
                datasets: [{
                    label: "Available Quantity",
                    data: quantities,
                    backgroundColor: "rgba(75, 192, 192, 0.6)"
                }]
            }
        });
    }
</script>

<a href="admin_logout.php">Logout</a>
</body>
</html>
