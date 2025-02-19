<?php
session_start();
require 'databasehandler.php';

// Ensure only admins can access this page
if (!isset($_SESSION['user_id']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    die("Access Denied! You are not an admin.");
}

$dbHandler = new DatabaseHandler();
$pdo = $dbHandler->getPDO(); // ✅ Use the getter method

try {
    // Fetch product statistics
    $sql = "SELECT id, name, quantity, price FROM products";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    die("Error fetching products: " . $e->getMessage());
}

try {
    // Fetch users
    $sqlUsers = "SELECT student_id, email FROM students";
    $stmtUsers = $pdo->prepare($sqlUsers);
    $stmtUsers->execute();
    $users = $stmtUsers->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    die("Error fetching users: " . $e->getMessage());
}

try {
    // Fetch orders
    $sqlOrders = "SELECT id, name, email, total_price FROM orders";
    $stmtOrders = $pdo->prepare($sqlOrders);
    $stmtOrders->execute();
    $orders = $stmtOrders->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    die("Error fetching orders: " . $e->getMessage());
}

// Convert to JSON safely
$chartData = json_encode($products, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .navbar {
            background-color: #333;
            overflow: hidden;
            padding: 15px;
            text-align: right;
        }
        .navbar a {
            color: white;
            text-decoration: none;
            font-size: 18px;
            padding: 10px 15px;
        }
        .navbar a:hover {
            background-color: #575757;
            border-radius: 5px;
        }
        .container {
            width: 80%;
            margin: 20px auto;
            background: white;
            padding: 20px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        h2, h3 {
            text-align: center;
        }
        canvas {
            display: block;
            margin: 20px auto;
            max-width: 600px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }
        th {
            background-color: #333;
            color: white;
        }
        .btn-container {
            text-align: center;
            margin: 20px 0;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            margin: 5px;
            text-decoration: none;
            color: white;
            background-color: #28a745;
            border-radius: 5px;
        }
        .btn:hover {
            background-color: #218838;
        }
        .edit-btn {
            background-color: #007bff;
        }
        .edit-btn:hover {
            background-color: #0056b3;
        }
        .delete-btn {
            background-color: #dc3545;
        }
        .delete-btn:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-dark bg-dark">
    <div class="container-fluid">
        <a href="admin_logout.php" class="btn btn-danger">Logout</a>
    </div>
</nav>
<div class="container mt-4">
    <h3 class="text-center">Product Statistics</h3>

    <!-- Resizable Chart -->
    <div class="d-flex justify-content-center">
        <canvas id="productChart" style="max-width: 100%; height: 400px;"></canvas>
    </div>
    
    <!-- Product Statistics -->
    <h3>Product Statistics</h3>
    <canvas id="productChart"></canvas>

    <script>
        let products = <?php echo $chartData; ?>;

        if (Array.isArray(products) && products.length > 0) {
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
        } else {
            console.error("No product data available for chart.");
        }
    </script>

    <!-- Product Management Section -->
    <h3>Manage Products</h3>

    <div class="btn-container">
        <a href="add.php" class="btn">Add Product</a>
    </div>

    <table>
        <tr>
            <th>Name</th>
            <th>Quantity</th>
            <th>Price</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($products as $product): ?>
            <tr>
                <td><?php echo htmlspecialchars($product['name']); ?></td>
                <td><?php echo htmlspecialchars($product['quantity']); ?></td>
                <td><?php echo htmlspecialchars($product['price']); ?></td>
                <td>
                    <a href="edit.php?id=<?php echo $product['id']; ?>" class="btn edit-btn">Edit</a>
                    <a href="delete.php?id=<?php echo $product['id']; ?>" class="btn delete-btn" onclick="return confirm('Are you sure?')">Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>

</body>
</html>