<?php
$connection = new mysqli("localhost", "root", "", "your_database");

if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

$query = "SELECT * FROM products";
$result = $connection->query($query);
?>