<?php
session_start();
require 'databasehandler.php';

// Ensure only admins can access
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    die("Access Denied! You are not an admin.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $quantity = $_POST['quantity'];
    $price = $_POST['price'];
    $image = null; // Default to NULL

    // Check if an image was uploaded
    if (!empty($_FILES['image']['name'])) {
        $image = $_FILES['image']['name'];
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($image);
        move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
    }

    try {
        $dbHandler = new DatabaseHandler();
        $pdo = $dbHandler->getPDO();

        // Use NULL if no image is uploaded
        $sql = "INSERT INTO products (name, quantity, price, image) VALUES (:name, :quantity, :price, :image)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':name' => $name,
            ':quantity' => $quantity,
            ':price' => $price,
            ':image' => $image // This will be NULL if no image was uploaded
        ]);

        echo "Product added successfully!";
    } catch (PDOException $e) {
        echo "Error adding product: " . $e->getMessage();
    }
}
?>

<form method="POST" action="add.php" enctype="multipart/form-data">
    <input type="text" name="name" placeholder="Product Name" required>
    <input type="number" name="quantity" placeholder="Quantity" required>
    <input type="number" step="0.01" name="price" placeholder="Price" required>
    <input type="file" name="image"> <!-- Image is now optional -->
    <button type="submit">Add Product</button>
</form>

<a href="admin_dashboard.php">Back to Dashboard</a>
