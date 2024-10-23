<?php
// Include PHPMailer autoload (adjust path if necessary)
require 'vendor/autoload.php';  // Ensure the path is correct based on your project structure

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Function to send OTP email
function sendOtp($userEmail, $otp) {
    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->SMTPDebug = 2;                                // Enable verbose debug output (set to 0 to disable)
        $mail->isSMTP();                                     // Set mailer to use SMTP
        $mail->Host = 'smtp.gmail.com';                      // Specify main SMTP server (replace with your SMTP server)
        $mail->SMTPAuth = true;                              // Enable SMTP authentication
        $mail->Username = 'poeeaint497@gmail.com';            // Your SMTP email
        $mail->Password = 'zqsi ndts tqhy herm';             // Your SMTP password (use app-specific password if using Gmail)
        $mail->SMTPSecure = 'tls';                           // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 587;                                   // TCP port to connect to

        //Recipients
        $mail->setFrom('poeeaint497@gmail.com', 'Eaint Poe'); // Sender's email and name
        $mail->addAddress($userEmail);                       // Add a recipient

        //Content
        $mail->isHTML(true);                                 // Set email format to HTML
        $mail->Subject = 'Your OTP Code';
        $mail->Body    = 'Your OTP code is: <strong>' . $otp . '</strong>'; // Email body with OTP
        $mail->AltBody = 'Your OTP code is: ' . $otp;        // Plain text version of the email

        // Send the email
        if ($mail->send()) {
            echo 'OTP has been sent to your email.';
        } else {
            echo 'Failed to send OTP email. Error: ' . $mail->ErrorInfo;
        }
    } catch (Exception $e) {
        echo 'Mailer Error: ' . $mail->ErrorInfo;
    }
}

// Generate OTP
$otp = rand(100000, 999999);  // Generate a random 6-digit OTP

// Assume user's email is fetched from the registration form or database
$userEmail = $_POST['email'] ?? 'user@example.com';  // Change to the actual way you get the user email

// Call the sendOtp function to send the email
sendOtp($userEmail, $otp);

// Optional: Save the OTP to the session or database for later verification
// $_SESSION['otp'] = $otp;  // Alternatively, save it to the database
