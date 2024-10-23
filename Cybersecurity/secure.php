<?php
session_start(); // Start session for messages

// Include the database connection
require_once 'connect.php'; // Include the connection file

// Include PHPMailer for sending OTP via email
require 'C:/xampp/htdocs/Cybersecurity/PHPMailer-master/src/PHPMailer.php';
require 'C:/xampp/htdocs/Cybersecurity/PHPMailer-master/src/SMTP.php';
require 'C:/xampp/htdocs/Cybersecurity/PHPMailer-master/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Initialize variables for error handling
$error_message = '';
$success_message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the form data
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Validate the form inputs
    if (empty($username) || empty($email) || empty($password)) {
        $error_message = "All fields are required.";
    } elseif (strlen($username) < 4) {
        $error_message = "Username must be at least 4 characters.";
    } elseif (strlen($password) < 8 || !preg_match('/[A-Z]/', $password) || !preg_match('/[0-9]/', $password) || !preg_match('/[\W]/', $password)) {
        $error_message = "Password must be at least 8 characters long, include an uppercase letter, a number, and a special character.";
    } else {
        // Check if the user already exists
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            $error_message = "A user with this email already exists.";
        } else {
            // Hash the password
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

            // Insert user data into the database
            $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (:username, :email, :password)");
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $hashedPassword);

            if ($stmt->execute()) {
                // Registration is successful, redirect to login_process.php page
                header('Location: login_process.php');
                exit();
            } else {
                $error_message = "Error during registration. Please try again.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Secure Registration</title>
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script> <!-- Include reCAPTCHA script -->

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #1d3557;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .secure-container {
            background-color: #BBDEFB;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 24px;
            color: #333;
        }

        .input-group {
            margin-bottom: 20px;
        }

        .input-group label {
            display: block;
            margin-bottom: 6px;
            font-size: 14px;
            color: #555;
        }

        .input-group input {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 14px;
            color: #333;
        }

        .input-group small {
            display: block;
            margin-top: 5px;
            font-size: 12px;
            color: #888;
        }

        .password-wrapper {
            display: flex;
            align-items: center;
        }

        .password-wrapper input {
            width: 90%;
        }

        #togglePassword {
            background: none;
            border: none;
            color: #007bff;
            font-size: 14px;
            cursor: pointer;
            padding-left: 8px;
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }

        .g-recaptcha {
            margin-top: 10px;
        }

        /* Responsiveness */
        @media (max-width: 768px) {
            .secure-container {
                padding: 20px;
            }
        }

        .error {
            color: red;
            text-align: center;
            margin-bottom: 15px;
        }

        .success {
            color: green;
            text-align: center;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <div class="secure-container">
        <form id="secureRegistrationForm" action="secure.php" method="POST">
            <h2><i class="fas fa-lock"></i> Secure User Registration</h2>

            <!-- Display error message -->
            <?php if (!empty($error_message)): ?>
                <div class="error"><?php echo htmlspecialchars($error_message); ?></div>
            <?php endif; ?>

            <!-- Display success message -->
            <?php if (!empty($success_message)): ?>
                <div class="success"><?php echo htmlspecialchars($success_message); ?></div>
            <?php endif; ?>
            
            <!-- Username -->
            <div class="input-group">
                <label for="username"><i class="fas fa-user"></i> Username</label>
                <input type="text" id="username" name="username" required placeholder="Enter your username">
                <small>At least 4 characters</small>
            </div>
            
            <!-- Email -->
            <div class="input-group">
                <label for="email"><i class="fas fa-envelope"></i> Email</label>
                <input type="email" id="email" name="email" required placeholder="Enter your email">
                <small>Enter a valid email address</small>
            </div>

            <!-- Password -->
            <div class="input-group">
                <label for="password"><i class="fas fa-lock"></i> Password</label>
                <div class="password-wrapper">
                    <input type="password" id="password" name="password" required placeholder="Enter your password">
                    <button type="button" id="togglePassword" onclick="togglePasswordVisibility()">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
                <small>Password must be at least 8 characters and include uppercase, number, and special character</small>
            </div>

            <!-- reCAPTCHA -->
            <div class="input-group">
                <div class="g-recaptcha" data-sitekey="6Ld4DWcqAAAAAJ306e-8XOd028YeBMr287ryMNrh"></div>
                <small>Prove you're human</small>
            </div>

            <!-- Submit Button -->
            <button type="submit"><i class="fas fa-user-plus"></i> Register</button>
        </form>
    </div>

    <script>
        // Toggle password visibility
        function togglePasswordVisibility() {
            var password = document.getElementById("password");
            var togglePassword = document.getElementById("togglePassword");
            if (password.type === "password") {
                password.type = "text";
                togglePassword.innerHTML = '<i class="fas fa-eye-slash"></i>';
            } else {
                password.type = "password";
                togglePassword.innerHTML = '<i class="fas fa-eye"></i>';
            }
        }
    </script>
</body>
</html>
