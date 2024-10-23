<?php
// Include PHPMailer autoload file
require 'vendor/autoload.php';  // Adjust this path based on your project structure

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function sendOtp($userEmail, $otp) {
    // Create a new PHPMailer instance
    $mail = new PHPMailer(true);
    
    try {
        // Server settings
        $mail->SMTPDebug = 0;  // Change to 2 for detailed debug output
        $mail->isSMTP();       // Set mailer to use SMTP
        $mail->Host = 'smtp.gmail.com';  // Specify main SMTP server
        $mail->SMTPAuth = true;           // Enable SMTP authentication
        $mail->Username = 'your-email@gmail.com';  // SMTP email (your Gmail)
        $mail->Password = 'your-app-specific-password';  // SMTP password (app-specific for Gmail)
        $mail->SMTPSecure = 'tls';         // Enable TLS encryption
        $mail->Port = 587;                 // TCP port to connect to

        // Recipients
        $mail->setFrom('your-email@gmail.com', 'Your Name');  // Your email and name
        $mail->addAddress($userEmail);    // Recipient's email

        // Content
        $mail->isHTML(true);               // Set email format to HTML
        $mail->Subject = 'Your OTP Code';
        $mail->Body    = "Your OTP code is: <strong>{$otp}</strong>";  // HTML message
        $mail->AltBody = "Your OTP code is: {$otp}";  // Plain-text message for email clients that don't support HTML

        // Send email
        if ($mail->send()) {
            return true;
        } else {
            throw new Exception('Unable to send OTP email.');
        }
    } catch (Exception $e) {
        echo "Mailer Error: {$mail->ErrorInfo}";
        return false;
    }
}

// Generate a random 6-digit OTP
$otp = rand(100000, 999999);

// Assuming the user's email is coming from a POST request (e.g., a form)
$userEmail = $_POST['email'] ?? 'user@example.com';  // Replace with actual method to get the user's email

// Send the OTP email
if (sendOtp($userEmail, $otp)) {
    echo "OTP has been sent successfully to {$userEmail}.";
} else {
    echo "Failed to send OTP. Please try again.";
}

// Optional: Save OTP to the session or database for later verification
// $_SESSION['otp'] = $otp;  // Or save to your database
?>
