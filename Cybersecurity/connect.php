<?php
// Database connection
$host = 'localhost';      // Your database host
$dbname = 'cybersecurity'; // Your database name
$username = 'root';        // Your database username
$password = '';            // Your database password (leave blank if no password)

try {
    // Create a new PDO instance
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    // Set PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Set character set to utf8
    $pdo->exec("SET NAMES 'utf8';");
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>


