<?php
include_once 'connect.php';

try {
    // Create users table
    $sql = "
    CREATE TABLE  users (
        user_id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(255) NOT NULL UNIQUE,
        email VARCHAR(255) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )";

    // Execute the query
    $pdo->exec($sql);

    echo "Users table created successfully!";
} catch (PDOException $e) {
    die("Error creating table: " . $e->getMessage());
}
?>

