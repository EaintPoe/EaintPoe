

<?php
session_start();  // Start session for user data

// Include the database connection
require_once 'connect.php';  // Database connection file

require 'C:/xampp/htdocs/Cybersecurity/PHPMailer-master/src/PHPMailer.php';
require 'C:/xampp/htdocs/Cybersecurity/PHPMailer-master/src/SMTP.php';
require 'C:/xampp/htdocs/Cybersecurity/PHPMailer-master/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Initialize variable for error handling
$error_message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Check if 'email' and 'password' exist in POST request
    if (isset($_POST['email']) && isset($_POST['password'])) {
        $email = $_POST['email'];  // This line gets the email from the form
        $password = $_POST['password'];

        // Validate the email and password fields
        if (empty($email) || empty($password)) {
            $error_message = 'Both email and password are required.';
        } else {
            try {
                // Proceed with login validation (fetch user from the database)
                $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
                $stmt->bindParam(':email', $email);
                $stmt->execute();
                $user = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($user) {
                    // Check if the password matches the hash in the database
                    if (password_verify($password, $user['password'])) {
                        // Password correct, log in the user
                        $_SESSION['user_id'] = $user['user_id'];
                        $_SESSION['username'] = $user['username'];
                        $_SESSION['email'] = $email;  // Store email in session

                        // Generate a random 6-digit OTP
                        $otp = rand(100000, 999999);

                        // Store the OTP in the session
                        $_SESSION['otp'] = $otp;

                        // Send OTP via email
                        if (sendOtpEmail($email, $otp)) {
                            // Redirect to OTP verification page if OTP is sent
                            header("Location: verify_otp.php");
                            exit();
                        } else {
                            $error_message = "Failed to send OTP. Please try again.";
                        }
                    } else {
                        $error_message = 'Invalid email or password. Please try again.';
                    }
                } else {
                    $error_message = 'User not found. Please register.';
                }
            } catch (PDOException $e) {
                // Log any database errors for debugging
                error_log("Database error: " . $e->getMessage());
                $error_message = 'An internal error occurred. Please try again later.';
            }
        }
    } else {
        $error_message = 'Email and password are required.';
    }
}

// Function to send OTP via email
function sendOtpEmail($email, $otp) {
    $mail = new PHPMailer(true);
    
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'poeeaint497@gmail.com'; // Your Gmail address
        $mail->Password = 'zqsi ndts tqhy herm';    // Your Gmail app password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('poeeaint497@gmail.com', 'Eaint Poe');
        $mail->addAddress($email);  // Add the user's email address
        $mail->isHTML(true);
        $mail->Subject = 'Your OTP Code';
        $mail->Body    = "Your OTP code is: $otp";

        $mail->send();
        return true;  // Email sent successfully
    } catch (Exception $e) {
        error_log("Failed to send OTP email. Error: " . $mail->ErrorInfo);
        return false;  // Failed to send email
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Cafe Aroma</title>

    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4ece2;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }

        .secure-container {
            background-color: #fff;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
            border: 1px solid #dedede;
        }

        h2 {
            text-align: center;
            color: #6f4e37; /* Cafe-like dark brown */
            margin-bottom: 20px;
            font-size: 1.8rem;
            font-weight: 600;
        }

        .input-group {
            margin-bottom: 20px;
        }

        .input-group label {
            font-size: 1rem;
            color: #333;
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
        }

        .input-group input {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 1rem;
            transition: border-color 0.3s ease;
        }

        .input-group input:focus {
            border-color: #6f4e37;  /* Cafe-like dark brown */
            outline: none;
        }

        .input-group small {
            font-size: 0.85rem;
            color: #6c757d;
        }

        .password-wrapper {
            position: relative;
        }

        .password-wrapper button {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            font-size: 1rem;
            color: #6f4e37;
            cursor: pointer;
        }

        .error {
            color: red;
            font-size: 0.9rem;
            text-align: center;
            margin-bottom: 10px;
        }

        button[type="submit"] {
            width: 100%;
            padding: 14px;
            background-color: #6f4e37;
            color: #fff;
            border: none;
            border-radius: 6px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button[type="submit"]:hover {
            background-color: #5a3d2e;
        }

        /* Add a link to the registration page */
        .register-link {
            text-align: center;
            margin-top: 10px;
        }

        .register-link a {
            color: #6f4e37;
            text-decoration: none;
        }

        .register-link a:hover {
            text-decoration: underline;
        }

        /* Responsive design */
        @media (max-width: 768px) {
            .secure-container {
                padding: 20px;
            }

            h2 {
                font-size: 1.6rem;
            }
        }
    </style>
</head>
<body>

    <div class="secure-container">
        <form id="secureLoginForm" action="login_process.php" method="POST">
            <h2><i class="fas fa-sign-in-alt"></i> Login To Cafe Aroma</h2>

            <?php if (!empty($error_message)): ?>
                <p class="error"><?php echo htmlspecialchars($error_message); ?></p>
            <?php endif; ?>

            <!-- Email -->
            <div class="input-group">
                <label for="email"><i class="fas fa-envelope"></i> Email</label>
                <input type="email" id="email" name="email" required placeholder="Enter your email">
                <small>Enter your email address</small>
            </div>

            <!-- Password -->
            <div class="input-group">
                <label for="password"><i class="fas fa-lock"></i> Password</label>
                <div class="password-wrapper">
                    <input type="password" id="password" name="password" required placeholder="Enter your password">
                    <button type="button" id="togglePassword" onclick="togglePasswordVisibility()"><i class="fas fa-eye"></i></button>
                </div>
            </div>

            <!-- Submit Button -->
            <button type="submit"><i class="fas fa-sign-in-alt"></i> Login</button>

            <!-- Register Link -->
            <div class="register-link">
                <p>Don't have an account? <a href="secure_register.php">Register here</a></p>
            </div>
        </form>
    </div>

    <script>
        function togglePasswordVisibility() {
            const passwordInput = document.getElementById('password');
            const toggleButton = document.getElementById('togglePassword');
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleButton.innerHTML = '<i class="fas fa-eye-slash"></i>';
            } else {
                passwordInput.type = 'password';
                toggleButton.innerHTML = '<i class="fas fa-eye"></i>';
            }
        }
    </script>
    <!-- Prevent back button caching -->
    <script type="text/javascript">
        function preventBack() { window.history.forward() };
        setTimeout("preventBack()", 0);
        window.onunload = function () { null };
    </script>
</body>
</html>
