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
    <title>Admin Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>

<h2>Admin Dashboard</h2>

<h3>Product Statistics</h3>
<canvas id="productChart"></canvas>

<script>
    let products = <?php echo $chartData; ?>;

    if (!Array.isArray(products) || products.length === 0) {
        console.error("Invalid product data for chart.");
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

<!-- Product Management Section -->
<h3>Manage Products</h3>
<a href="add.php"><button>Add Product</button></a>

<table border="1">
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
                <a href="edit.php?id=<?php echo $product['id']; ?>">Edit</a>
                <a href="delete.php?id=<?php echo $product['id']; ?>" onclick="return confirm('Are you sure?')">Delete</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

<a href="admin_logout.php">Logout</a>

</body>
</html>

