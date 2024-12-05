<?php
require 'db.php';

$subjectsQuery = "SELECT * FROM training_subjects";
$subjects = $conn->query($subjectsQuery);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Web Training Subjects</title>
    <style>
        /* General Body Styling */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f7fc;
            margin: 0;
            padding: 0;
        }

        /* Header Styling */
        h1 {
            text-align: center;
            color: #333;
            margin-top: 30px;
            font-size: 36px;
        }

        /* Table Styling */
        table {
            width: 80%;
            margin: 30px auto;
            border-collapse: collapse;
            background-color: #ffffff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        th, td {
            padding: 15px;
            text-align: left;
            border: 1px solid #ddd;
        }

        th {
            background-color: #007bff;
            color: white;
            text-transform: uppercase;
            font-weight: bold;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        /* Request Training Form Styling */
        .request-form {
            text-align: center;
            margin-top: 30px;
        }

        .request-form select, .request-form input[type="submit"] {
            padding: 10px 15px;
            font-size: 16px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .request-form select {
            width: 300px;
        }

        .request-form input[type="submit"] {
            background-color: #28a745;
            color: white;
            cursor: pointer;
            border: none;
        }

        .request-form input[type="submit"]:hover {
            background-color: #218838;
        }

        /* Container Styling for overall content */
        .content-container {
            width: 90%;
            margin: 0 auto;
            max-width: 1200px;
        }
    </style>
</head>
<body>

    <div class="content-container">
        <!-- Title Section -->
        <h1>Available Training Subjects</h1>

        <!-- Training Subjects Table -->
        <table>
            <thead>
                <tr>
                    <th>Subject Name</th>
                    <th>Description</th>
                    <th>Fee</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $subjects->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['subject_name']; ?></td>
                        <td><?php echo $row['description']; ?></td>
                        <td><?php echo $row['fee']; ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <!-- Request Training Form -->
        <div class="request-form">
            <h2>Request a Training</h2>
            <form action="request_training.php" method="POST">
                <select name="training_subject_id" required>
                    <option value="" disabled selected>Select a Subject</option>
                    <?php
                    // Fetch all available subjects for the request form
                    $subjectsRequestQuery = "SELECT * FROM training_subjects";
                    $subjectsRequestResult = $conn->query($subjectsRequestQuery);
                    while ($subject = $subjectsRequestResult->fetch_assoc()):
                    ?>
                        <option value="<?php echo $subject['subject_id']; ?>">
                            <?php echo $subject['subject_name']; ?>
                        </option>
                    <?php endwhile; ?>
                </select>
                <input type="submit" value="Request Training">
            </form>
        </div>
    </div>

</body>
</html>