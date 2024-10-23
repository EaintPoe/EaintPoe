<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Include PHPMailer's autoloader

$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'poeeaint497@gmail.com'; // Your email address
    $mail->Password   = 'zqsi ndts tqhy herm'; // Your email password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;

    //Recipients
    $mail->setFrom('poeeaint497@gmail.com', 'Eaint Poe');
    $mail->addAddress($user_email); // Add a recipient

    // Content
    $mail->isHTML(true);
    $mail->Subject = 'Your OTP Code';
    $mail->Body    = 'Your OTP code is: ' . $otp; // OTP code content

    $mail->send();
    echo 'OTP has been sent';
} catch (Exception $e) {
    echo "Failed to send OTP. Mailer Error: {$mail->ErrorInfo}";
}
