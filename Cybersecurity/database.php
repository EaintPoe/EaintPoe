<?php
// database.php

// Include the connection file
include_once 'connect.php';

// Function to register a new user
function registerUser($username, $email, $password) {
    global $pdo;

    try {
        // Hash the password before storing it
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        // Insert the user into the database
        $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (:username, :email, :password)");

        // Bind the parameters and execute the query
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $hashedPassword);

        // Execute the query
        if ($stmt->execute()) {
            return true;
        } else {
            // Log error for debugging
            $errorInfo = $stmt->errorInfo();
            error_log("Database insert error: " . $errorInfo[2]);
            return false;
        }
    } catch (PDOException $e) {
        // Log any PDO errors
        error_log("PDO error: " . $e->getMessage());
        return false;
    }
}

// Function to check if a username or email already exists
function checkUserExists($username, $email) {
    global $pdo;

    try {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username OR email = :email");
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        // Log any PDO errors
        error_log("PDO error: " . $e->getMessage());
        return false;
    }
}
?>
