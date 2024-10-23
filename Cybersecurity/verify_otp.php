<?php
session_start();

// Include PHPMailer to resend OTP if needed
require 'C:/xampp/htdocs/Cybersecurity/PHPMailer-master/src/PHPMailer.php';
require 'C:/xampp/htdocs/Cybersecurity/PHPMailer-master/src/SMTP.php';
require 'C:/xampp/htdocs/Cybersecurity/PHPMailer-master/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Check if OTP is set in the session
if (!isset($_SESSION['otp']) || !isset($_SESSION['email'])) {
    header("Location: login_process.php");  // Redirect to login if OTP is not set
    exit();
}

// Initialize variable for error handling
$error_message = '';
$success_message = '';

// Function to resend OTP via email
function resendOtpEmail($email, $otp) {
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

// Handle OTP verification submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['otp'])) {
        $entered_otp = $_POST['otp'];

        // Check if the entered OTP matches the session OTP
        if ($entered_otp == $_SESSION['otp']) {
            // OTP is correct
            $success_message = "OTP verified successfully!";
            // Clear OTP from session after verification
            unset($_SESSION['otp']);
            // Redirect to the dashboard or homepage
            header("Location: index.php");
            exit();
        } else {
            $error_message = "Invalid OTP. Please try again.";
        }
    }

    // Handle resend OTP request
    if (isset($_POST['resend'])) {
        $new_otp = rand(100000, 999999);  // Generate a new OTP
        $_SESSION['otp'] = $new_otp;  // Update OTP in session

        if (resendOtpEmail($_SESSION['email'], $new_otp)) {
            $success_message = "A new OTP has been sent to your email.";
        } else {
            $error_message = "Failed to resend OTP. Please try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify OTP</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
            text-align: center;
        }

        input[type="text"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }

        .resend-btn {
            background-color: #f39c12;
            margin-top: 10px;
        }

        .error {
            color: red;
            margin-top: 10px;
        }

        .success {
            color: green;
            margin-top: 10px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Verify OTP</h2>

    <?php if (!empty($error_message)): ?>
        <p class="error"><?php echo $error_message; ?></p>
    <?php endif; ?>

    <?php if (!empty($success_message)): ?>
        <p class="success"><?php echo $success_message; ?></p>
    <?php endif; ?>

    <form action="verify_otp.php" method="POST">
        <!-- OTP Input -->
        <input type="text" name="otp" placeholder="Enter OTP" required>
        <button type="submit">Verify</button>
    </form>

    <!-- Resend OTP Button -->
    <form action="verify_otp.php" method="POST">
        <button type="submit" name="resend" class="resend-btn">Resend OTP</button>
    </form>
</div>

</body>
</html>
