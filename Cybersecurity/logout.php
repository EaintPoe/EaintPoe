<?php
session_start(); // Start the session

// Destroy all session data
session_destroy();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logout - Café Aroma</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&family=Great+Vibes&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #fff6e5; /* Warm coffee background */
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            color: #4b3832;
        }

        .container {
            text-align: center;
            padding: 40px;
            background-color: #fff;
            border-radius: 12px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
        }

        .container h1 {
            font-family: 'Great Vibes', cursive;
            font-size: 36px;
            color: #4b3832;
            margin-bottom: 20px;
        }

        .container p {
            font-size: 18px;
            color: #6a4f4b;
            margin-bottom: 20px;
        }

        .container a {
            display: inline-block;
            padding: 12px 24px;
            background-color: #4b3832;
            color: #f7eee0;
            text-decoration: none;
            border-radius: 8px;
            font-size: 18px;
            transition: background-color 0.3s ease;
        }

        .container a:hover {
            background-color: #a0522d;
        }

        @media (max-width: 768px) {
            .container {
                padding: 20px;
            }

            .container h1 {
                font-size: 28px;
            }

            .container p {
                font-size: 16px;
            }
        }
    </style>
</head>
<body>

    <div class="container">
        <h1>Goodbye, See You Soon!</h1>
        <p>You have been logged out successfully.</p>
        <a href="secure.php">Go to Registration</a>
    </div>

    <!-- Auto-redirect after 5 seconds -->
    <script>
        setTimeout(function() {
            window.location.href = 'secure.php'; // Redirect to register.php after 5 seconds
        }, 5000);
    </script>

</body>
</html>
