<?php
require 'db.php';  // Include your DB connection file

// Handle the form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $subjectName = $_POST['subject_name'];
    $description = $_POST['description'];

    // Insert the new training subject into the database
    $insertQuery = "INSERT INTO training_subjects (subject_name, description) 
                    VALUES (?, ?)";
    $stmt = $conn->prepare($insertQuery);
    $stmt->bind_param("ss", $subjectName, $description);

    if ($stmt->execute()) {
        echo "<script>alert('Training subject added successfully!'); window.location.href='insert_training_subject.php';</script>";
    } else {
        echo "<script>alert('Error adding the training subject. Please try again.');</script>";
    }
    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert Training Subject</title>
    <link rel="stylesheet" href="styles.css"> <!-- Assuming you have a styles.css file -->
</head>
<body>
    <h1>Insert Training Subject</h1>
    <form method="POST">
        <label for="subject_name">Subject Name:</label>
        <input type="text" name="subject_name" id="subject_name" required><br><br>

        <label for="description">Description:</label>
        <textarea name="description" id="description" rows="4" cols="50" required></textarea><br><br>

        <button type="submit">Add Subject</button>
    </form>
</body>
</html>