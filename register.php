<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $role = $_POST['role'];

    $sql = "INSERT INTO users (name, phone, email, address, username, password, role) 
            VALUES ('$name', '$phone', '$email', '$address', '$username', '$password', '$role')";

    if ($conn->query($sql) === TRUE) {
        echo "<p style='color:green;'>Registration successful! <a href='login.php'>Login here</a></p>";
    } else {
        echo "<p style='color:red;'>Error: " . $sql . "<br>" . $conn->error . "</p>";
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account</title>
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

        .register-form {
            background-color: #fff;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 800px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .register-form h1 {
            grid-column: span 2;
            margin-bottom: 20px;
            font-size: 36px;
            color: #333;
            text-align: center;
        }

        .register-form label {
            display: block;
            margin-bottom: 8px;
            font-size: 14px;
            color: #333;
        }

        .register-form input[type="text"],
        .register-form input[type="email"],
        .register-form input[type="password"],
        .register-form select {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
            box-sizing: border-box;
        }

        .register-form button {
            background-color: #007bff;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 4px;
            font-size: 18px;
            width: 100%;
            cursor: pointer;
            margin-top: 15px;
            grid-column: span 2;
        }

        .register-form button:hover {
            background-color: #0056b3;
        }

        /* Error and Success Message Styling */
        .error, .success {
            font-size: 14px;
            margin-top: 10px;
            text-align: center;
        }

        .error {
            color: red;
        }

        .success {
            color: green;
        }

        /* Mobile Responsiveness */
        @media (max-width: 480px) {
            .register-form {
                padding: 20px;
                width: 90%;
                grid-template-columns: 1fr;
            }

            .register-form h1 {
                font-size: 28px;
            }

            .register-form button {
                font-size: 16px;
                padding: 10px 15px;
            }
        }
    </style>
</head>
<body>
    <div class="register-form">
        <h1>Create Account</h1>
        <form method="POST">
            <div>
                <label for="name">Name:</label>
                <input type="text" name="name" id="name" required>
            </div>
            <div>
                <label for="phone">Phone:</label>
                <input type="text" name="phone" id="phone" required>
            </div>
            <div>
                <label for="email">Email:</label>
                <input type="email" name="email" id="email" required>
            </div>
            <div>
                <label for="address">Address:</label>
                <input type="text" name="address" id="address" required>
            </div>
            <div>
                <label for="username">Username:</label>
                <input type="text" name="username" id="username" required>
            </div>
            <div>
                <label for="password">Password:</label>
                <input type="password" name="password" id="password" required>
            </div>
            <div>
                <label for="role">Role:</label>
                <select name="role" id="role" required>
                    <option value="student">Student</option>
                    <option value="staff">Staff</option>
                </select>
            </div>
            <button type="submit">Register</button>
            <div style="padding-block:16px; text-align: center;">Already have an account? <a href="login.php">Login</a></div>
        </form>
        <p class="error"><?php echo isset($error) ? $error : ''; ?></p>
    </div>
</body>
</html>