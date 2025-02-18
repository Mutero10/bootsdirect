<?php
session_start();

// Check if index is set
if (isset($_POST['index'])) {
    $index = (int) $_POST['index'];

    if (isset($_SESSION['cart'][$index])) {
        unset($_SESSION['cart'][$index]);  // Remove item from cart
        $_SESSION['cart'] = array_values($_SESSION['cart']);  // Reindex array
    }
}

// Redirect back to cart page
header('Location: cart.php');
exit;
?>
