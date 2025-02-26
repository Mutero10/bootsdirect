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
        /* Global Styling */
body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #e3e3e3;
    color: #333;
}

/* Navbar Styling */
.navbar {
    background-color: #2c3e50;
    padding: 15px;
    text-align: right;
}

.navbar a {
    color: white;
    text-decoration: none;
    font-size: 16px;
    padding: 10px 15px;
    margin: 0 5px;
    border-radius: 5px;
    transition: 0.3s;
}

.navbar a:hover {
    background-color: #34495e;
}

/* Sidebar Styling */
.sidebar {
    width: 250px;
    height: 100vh;
    position: fixed;
    left: 0;
    top: 0;
    background: #2c3e50;
    padding-top: 20px;
}

.sidebar a {
    display: block;
    color: white;
    text-decoration: none;
    padding: 15px;
    text-align: center;
    transition: 0.3s;
}

.sidebar a:hover {
    background: #34495e;
}

/* Dashboard Container */
.dashboard-container {
    margin-left: 270px;
    padding: 20px;
}

/* Card Layout for Sections */
.card {
    background: white;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
    margin-bottom: 20px;
    text-align: center;
}

/* Table Styling */
table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 10px;
}

th, td {
    border: 1px solid #ddd;
    padding: 12px;
    text-align: center;
}

th {
    background-color: #2c3e50;
    color: white;
}

/* Button Styling */
.btn {
    color: white !important; /* Ensures text is white */
    text-decoration: none;
    padding: 10px 15px;
    font-weight: bold;
    border-radius: 5px;
    transition: 0.3s;
}

/* Adjust individual button styles */
.edit-btn {
    background-color:rgb(0, 0, 0); /* Blue */
}

.edit-btn:hover {
    background-color:rgb(1, 112, 230);
}

.delete-btn {
    background-color:rgb(0, 0, 0); /* Red */
}

.delete-btn:hover {
    background-color: #c82333;
}


/* Fix the button color */
.btn-download {
    background-color: black !important; /* Black background */
    color: white !important; /* White text */
    border: none;
    padding: 10px 15px;
    font-size: 16px;
    font-weight: bold;
    border-radius: 5px;
    transition: 0.3s;
}

.btn-download:hover {
    background-color: #333 !important; /* Darker black on hover */
}

.btn-success {
    background-color: #28a745;
}

.btn-success:hover {
    background-color: #218838;
}

.btn-edit {
    background-color: #007bff;
}

.btn-edit:hover {
    background-color: #0056b3;
}

.btn-delete {
    background-color: #dc3545;
}

.btn-delete:hover {
    background-color: #c82333;
}

/* Chart Section */
canvas {
    display: block;
    margin: 20px auto;
    max-width: 600px;
}

/* Force black font for the "Add Product" button */
.btn-container .btn {
    background-color: white !important; /* White background */
    color: black !important; /* Black text */
    border: 2px solid black; /* Optional: Add a black border */
    padding: 10px 15px;
    font-size: 16px;
    font-weight: bold;
    border-radius: 5px;
    transition: 0.3s;
}

.btn-container .btn:hover {
    background-color: #ddd !important; /* Light gray on hover */
}

/* Responsive Design */
@media (max-width: 768px) {
    .sidebar {
        width: 100%;
        height: auto;
        position: relative;
    }

    .dashboard-container {
        margin-left: 0;
    }
}

    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-dark bg-dark">
    <div class="container-fluid">
        <a href="admin_logout.php" class="btn btn-danger">Logout</a>
      <!--  <a href="admin_messages.php" class="btn btn-primary">View Messages</a> -->

    </div>
</nav>
<div class="container mt-4">
    <h3 class="text-center">Product Statistics</h3>

    <!-- Resizable Chart -->
    <div class="d-flex justify-content-center">
        <canvas id="productChart" style="max-width: 100%; height: 400px;"></canvas>
    </div>

    <!-- Product Statistics -->
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

<form action="generate_pdf.php" method="POST">
<button type="submit" class="btn btn-download">Download Product Report (PDF)</button>
</form>

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
                    <a href="edit.php?id=<?php echo $product['id']; ?>" class="btn edit-btn">Update</a>
                    <a href="delete.php?id=<?php echo $product['id']; ?>" class="btn delete-btn" onclick="return confirm('Are you sure?')">Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>

</body>
</html>