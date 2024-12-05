<?php

require 'db.php';
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM users WHERE user_id = $user_id";
$result = $conn->query($sql);
$user = $result->fetch_assoc();

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Profile</title>
</head>
<body>
    <h1>Your Profile</h1>
    <p>Name: <?php echo $user['name']; ?></p>
    <p>Email: <?php echo $user['email']; ?></p>
    <p>Role: <?php echo ucfirst($user['role']); ?></p>
    <a href="index.php">Back to Home</a>
</body>
</html>