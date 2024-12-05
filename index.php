<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Web Training Platform</title>
    <style>
        /* Global Styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
        }
        h1 {
            text-align: center;
            color: #333;
            margin-top: 20px;
        }
        p {
            text-align: center;
            font-size: 18px;
        }

        /* Navbar Styles */
        nav {
            display: flex;
            justify-content: space-between;
            background-color: #007bff;
            padding: 15px;
            color: white;
        }
        nav a {
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            font-size: 18px;
            margin: 0 10px;
            border-radius: 4px;
            transition: background-color 0.3s;
        }
        nav a:hover {
            background-color: #0056b3;
        }

        /* User Info */
        .user-info {
            text-align: center;
            margin-top: 20px;
        }

        .user-info a {
            font-size: 18px;
            color: #007bff;
            text-decoration: none;
            padding: 5px 10px;
            border: 1px solid #007bff;
            border-radius: 4px;
        }

        .user-info a:hover {
            background-color: #007bff;
            color: white;
        }

        /* Footer */
        footer {
            text-align: center;
            padding: 20px;
            margin-top: 50px;
            background-color: #333;
            color: white;
        }

    </style>
</head>
<body>

    <!-- Navbar -->
    <nav>
        <div>
            WTP
        </div>
        <div>
            <a href="listings.php">Trainings</a>
            <a href="view_books.php">Books</a>
            <a href="view_penalties.php">Penalties</a>
            <a href="contact_us.php">Contact Us</a>
            <a href="about_me.php">profile</a>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="content">
        <h1>Welcome to the Web Training Platform</h1>
        <p>Learn web development skills such as HTML, CSS, PHP, and more!</p>
    </div>

    <!-- User Info -->
    <div class="user-info">
        <?php if (isset($_SESSION['user_id'])): ?>
            <p>Welcome, <?php echo $_SESSION['username']; ?> | <a href="logout.php">Logout</a></p>
        <?php else: ?>
            <p><a href="login.php">Login</a> | <a href="register.php">Register</a></p>
        <?php endif; ?>
    </div>

    <!-- Footer -->
    <footer>
        <p>&copy; 2024 Web Training Platform | All Rights Reserved</p>
    </footer>

</body>
</html>