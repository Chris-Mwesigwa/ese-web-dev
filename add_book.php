<?php
require 'navbar.php';
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (isset($_POST['add_book'])) {
    $title = $_POST['title'];
    $author = $_POST['author'];
    $status = 'available';
    
    $addBookQuery = "INSERT INTO books (title, author, status) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($addBookQuery);
    $stmt->bind_param("sss", $title, $author, $status);
    
    if ($stmt->execute()) {
        echo "<script>alert('Book has been successfully added.'); window.location.href='dashboard.php';</script>";
    } else {
        echo "<script>alert('Error adding book. Please try again.');</script>";
    }
    $stmt->close();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Book</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
        }
        h1 {
            text-align: center;
            color: #333;
        }
        .form-container {
            width: 50%;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        label {
            font-size: 16px;
            margin: 10px 0;
            display: block;
        }
        input[type="text"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            font-size: 14px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .btn {
            display: inline-block;
            padding: 10px 15px;
            font-size: 14px;
            color: #fff;
            background-color: #007bff;
            border: none;
            border-radius: 4px;
            text-decoration: none;
            cursor: pointer;
        }
        .btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

    <h1>Add New Book</h1>
    <div class="form-container">
        <form method="POST" action="add_book.php">
            <label for="title">Book Title:</label>
            <input type="text" id="title" name="title" required>

            <label for="author">Author:</label>
            <input type="text" id="author" name="author" required>

            <button type="submit" name="add_book" class="btn">Add Book</button>
        </form>
    </div>

</body>
</html>