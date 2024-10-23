<?php
// PHP code for handling the form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and process the form data
    $username = htmlspecialchars($_POST['username']);
    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']);
    $captcha = $_POST['g-recaptcha-response'];

    // Validate CAPTCHA using secret key
    $secretKey = "YOUR_SECRET_KEY";
    $responseKey = $captcha;
    $userIP = $_SERVER['REMOTE_ADDR'];

    $url = "https://www.google.com/recaptcha/api/siteverify?secret=$secretKey&response=$responseKey&remoteip=$userIP";
    $response = file_get_contents($url);
    $responseKeys = json_decode($response, true);

    if (intval($responseKeys["success"]) !== 1) {
        echo "<script>alert('Please complete the CAPTCHA');</script>";
    } else {
        // Handle the successful registration process (e.g., saving to database)
        echo "<script>alert('Registration successful!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Secure Registration</title>
    <!-- Font Awesome for Icons -->
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
            padding: 0;
        }

        .secure-container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
            width: 350px;
            max-width: 100%;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #1d3557;
            font-size: 1.8rem;
            font-weight: 600;
        }

        .input-group {
            margin-bottom: 20px;
        }

        .input-group label {
            font-size: 0.9rem;
            color: #1d3557;
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
        }

        .input-group input {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 6px;
            box-sizing: border-box;
            font-size: 0.95rem;
            transition: border-color 0.2s ease;
        }

        .input-group input:focus {
            border-color: #e63946;
            outline: none;
        }

        .input-group small {
            font-size: 0.75rem;
            color: #888;
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: #e63946;
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #d32f2f;
        }

        .password-wrapper {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .password-wrapper input {
            width: 85%;
        }

        #togglePassword {
            background: none;
            border: none;
            color: #1d3557;
            cursor: pointer;
            font-size: 1rem;
            margin-left: 10px;
        }

        /* Responsiveness */
        @media (max-width: 768px) {
            .secure-container {
                width: 90%;
            }

            h2 {
                font-size: 1.5rem;
            }
        }

        /* reCAPTCHA styling */
        .g-recaptcha {
            margin-top: 10px;
        }

        /* Submit Button Styling */
        button i {
            margin-right: 8px;
        }
    </style>
</head>
<body>
    <div class="secure-container">
        <form id="secureRegistrationForm" action="" method="POST" onsubmit="return validateForm();">
            <h2><i class="fas fa-user-lock"></i> Secure User Registration</h2>
            
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
                    <input type="password" id="password" name="password" required placeholder="Enter your password" onkeyup="checkPasswordStrength();">
                    <button type="button" id="togglePassword" onclick="togglePasswordVisibility()"><i class="fas fa-eye"></i></button>
                </div>
                <small>Password must be at least 8 characters, include uppercase, number, and special character</small>
                <div id="passwordStrength"></div>
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

    <script src="secure-script.js"></script>
    <script>
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
_______