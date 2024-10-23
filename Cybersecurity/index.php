<?php
session_start();  // Start session

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header('Location: login.php');  // Redirect to login page if not logged in
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Café Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&family=Great+Vibes&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
    <style>
        /* Global Styles */
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #fff6e5; /* Light coffee background */
            color: #333;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* Navbar Styles */
        .navbar {
            background-color: #4b3832; /* Dark coffee color */
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: #f7eee0;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .navbar h1 {
            font-family: 'Great Vibes', cursive;
            font-size: 36px;
            color: #f7eee0;
            margin: 0;
        }

        .nav-links {
            list-style: none;
            display: flex;
            margin: 0;
        }

        .nav-links li {
            margin-left: 20px;
        }

        .nav-links a {
            text-decoration: none;
            color: #f7eee0;
            font-size: 18px;
            padding: 10px 20px;
            background-color: transparent;
            border-radius: 8px;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .nav-links a:hover {
            background-color: #f7eee0;
            color: #4b3832;
        }

        .logout-btn {
            background-color: #d9534f;
        }

        .logout-btn:hover {
            background-color: #c9302c;
        }

        /* Hero Section */
        .hero {
            background-image: url('https://images.unsplash.com/photo-1498654896293-37aacf113fd9'); /* Replace with your café image */
            background-size: cover;
            background-position: center;
            color: black;
            padding: 100px 20px;
            text-align: center;
        }

        .hero h2 {
            font-size: 48px;
            font-family: 'Great Vibes', cursive;
            margin-bottom: 20px;
        }

        .hero p {
            font-size: 24px;
            max-width: 800px;
            margin: 0 auto;
        }

        /* Content Section */
        .container {
            max-width: 1200px;
            margin: 40px auto;
            padding: 20px;
        }

        .content-section {
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
            gap: 30px;
        }

        .content-card {
            background-color: black;
            border-radius: 12px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
            text-align: center;
            padding: 30px;
            flex: 1;
            min-width: 300px;
        }

        .content-card h3 {
            font-size: 24px;
            margin-bottom: 15px;
            color: #4b3832;
        }

        .content-card p {
            font-size: 16px;
            color: #777;
        }

        .content-card a {
            display: inline-block;
            margin-top: 15px;
            padding: 10px 20px;
            background-color: #6a4f4b;
            color: #fff;
            border-radius: 8px;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        .content-card a:hover {
            background-color: #a0522d;
        }

        /* Footer */
        .footer {
            background-color: #4b3832;
            padding: 20px;
            text-align: center;
            color: #f7eee0;
            margin-top: auto;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .hero h2 {
                font-size: 32px;
            }

            .hero p {
                font-size: 18px;
            }

            .content-section {
                flex-direction: column;
            }

            .content-card {
                margin-bottom: 20px;
            }
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <div class="navbar">
        <h1>Café Aroma</h1>
        <ul class="nav-links">
            <li><a href="menu.php">Menu</a></li>
            <li><a href="orders.php">Orders</a></li>
            <li><a href="settings.php">Settings</a></li>
            <li><a href="logout.php" class="logout-btn">Logout</a></li>
        </ul>
    </div>

    <!-- Hero Section -->
    <div class="hero">
        <h2>Welcome to Café Aroma, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h2>
        <p>Your go-to place for a delightful café experience. Enjoy your stay and manage your orders with ease.</p>
    </div>

    <!-- Content Section -->
    <div class="container">
        <div class="content-section">
            <div class="content-card">
                <h3>Browse Our Menu</h3>
                <p>Discover a wide range of coffee, tea, and pastries. Handcrafted with love.</p>
                <a href="menu.php">Explore Menu</a>
            </div>

            <div class="content-card">
                <h3>Your Orders</h3>
                <p>Check your current orders, and keep track of your favorite items.</p>
                <a href="orders.php">View Orders</a>
            </div>

            <div class="content-card">
                <h3>Account Settings</h3>
                <p>Manage your account, change preferences, and update your details.</p>
                <a href="settings.php">Settings</a>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p>© 2024 Café Aroma. All Rights Reserved.</p>
    </div>

    <!-- Prevent back button caching -->
    <script type="text/javascript">
        function preventBack() { window.history.forward(); }
        setTimeout("preventBack()", 0);
        window.onunload = function () { null };
    </script>

</body>
</html>
