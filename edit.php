<?php
session_start();
require 'databasehandler.php';

// Ensure only admins can access
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    die("Access Denied! You are not an admin.");
}

$dbHandler = new DatabaseHandler();
$pdo = $dbHandler->getPDO();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $quantity = $_POST['quantity'];
    $price = $_POST['price'];

    if (!empty($name) && is_numeric($quantity) && is_numeric($price)) {
        try {
            $sql = "UPDATE products SET name = :name, quantity = :quantity, price = :price WHERE id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(['name' => $name, 'quantity' => $quantity, 'price' => $price, 'id' => $id]);

            echo "<p>Product updated successfully!</p>";
        } catch (Exception $e) {
            die("Error updating product: " . $e->getMessage());
        }
    } else {
        echo "<p>Invalid input data!</p>";
    }
}

// Fetch product details
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "SELECT * FROM products WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => $id]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$product) {
        die("Product not found!");
    }
} else {
    die("No product selected!");
}
?>

<form method="POST">
    <input type="hidden" name="id" value="<?php echo htmlspecialchars($product['id']); ?>">
    <input type="text" name="name" value="<?php echo htmlspecialchars($product['name']); ?>" required>
    <input type="number" name="quantity" value="<?php echo htmlspecialchars($product['quantity']); ?>" required>
    <input type="text" name="price" value="<?php echo htmlspecialchars($product['price']); ?>" required>
    <button type="submit">Update Product</button>
</form>

<a href="admin_dashboard.php">Back to Dashboard</a>
