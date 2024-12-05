<?php
require 'db.php';

session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];

            if($_SESSION['role'] === 'student'){
                header("Location: index.php");
            } else{
                header("Location: dashboard.php");
            }
        } else {
            echo "<p style='color:red;'>Invalid password.</p>";
        }
    } else {
        echo "<p style='color:red;'>User not found.</p>";
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        /* Global Styling */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f7fc;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        /* Login Form Styling */
        .login-form {
            background-color: #fff;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }

        .login-form h1 {
            margin-bottom: 20px;
            font-size: 36px;
            color: #333;
        }

        .login-form label {
            display: block;
            margin-bottom: 8px;
            font-size: 14px;
            color: #333;
        }

        .login-form input[type="text"],
        .login-form input[type="password"] {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
            box-sizing: border-box;
        }

        .login-form button {
            background-color: #007bff;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 4px;
            font-size: 18px;
            width: 100%;
            cursor: pointer;
            margin-top: 15px;
        }

        .login-form button:hover {
            background-color: #0056b3;
        }

        /* Error Message Styling */
        .error {
            color: red;
            font-size: 14px;
            margin-top: 10px;
        }

        /* Mobile Responsiveness */
        @media (max-width: 480px) {
            .login-form {
                padding: 20px;
                width: 90%;
            }

            .login-form h1 {
                font-size: 28px;
            }

            .login-form button {
                font-size: 16px;
                padding: 10px 15px;
            }
        }
    </style>
</head>
<body>
    <div class="login-form">
        <h1>Login to WTP</h1>
        <form method="POST">
            <div>
                <label for="username">Username:</label>
                <input type="text" name="username" id="username" required>
            </div>
            <div>
                <label for="password">Password:</label>
                <input type="password" name="password" id="password" required>
            </div>
            <button type="submit">Login</button>
            <div style="padding-block:16px;">Don't have an account? <a href="register.php">Register</a></div>
        </form>
        <p class="error"><?php echo isset($error) ? $error : ''; ?></p>
    </div>
</body>
</html>