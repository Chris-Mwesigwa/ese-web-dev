<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        /* Navbar Styles */
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #333;
            padding: 10px 20px;
            color: #fff;
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
            width: 100%;
            box-sizing: border-box;
        }
        .navbar .logo a {
            color: #fff;
            font-size: 24px;
            text-decoration: none;
        }
        .navbar .links {
            display: flex;
        }
        .navbar .links a {
            color: #fff;
            margin-left: 20px;
            text-decoration: none;
            font-size: 16px;
        }
        .navbar .links a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <div class="logo">
            <a href="index.php">My Website</a>
        </div>
        <div class="links">
            <a href="index.php">Home</a>
            <a href="listings.php">Listings</a>
            <a href="profile.php">Profiles</a>
            <a href="dashboard.php">Dashboard</a>
            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="logout.php">Logout</a>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>