<?php
// Database connection parameters
$host = "localhost"; // Your database host (e.g., localhost)
$dbname = "bank"; // Your database name
$username = "root"; // Your database username
$password = ""; // Your database password

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    // Set PDO to throw exceptions on errors
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>
