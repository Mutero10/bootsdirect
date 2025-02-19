<?php
require 'databasehandler.php';

$dbHandler = new DatabaseHandler();
$pdo = $dbHandler->getPDO();

$newPassword = '1111111'; // Your desired password
$hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT); // Correctly hashed password

$sql = "UPDATE students SET password = :password WHERE email = :email AND role = 'admin'";
$stmt = $pdo->prepare($sql);
$stmt->execute([
    'password' => $hashedPassword,
    'email' => 'amutero5@gmail.com'
]);

echo "Admin password updated successfully!";
?>
