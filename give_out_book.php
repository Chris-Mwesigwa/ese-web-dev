<?php
require 'db.php';  // Include your DB connection file

// Fetch list of books and users for the dropdowns
$booksQuery = "SELECT book_id, title FROM books";
$booksResult = $conn->query($booksQuery);

$usersQuery = "SELECT user_id, name FROM users";
$usersResult = $conn->query($usersQuery);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Handle the form submission
    $bookId = $_POST['book_id'];
    $userId = $_POST['user_id'];
    $cashPayment = $_POST['cash_payment'];

    // Insert the transaction into the borrow_records table
    $borrowQuery = "INSERT INTO borrow_records (book_id, user_id, borrow_date, status, cash_payment) 
                    VALUES (?, ?, NOW(), 'borrowed', ?)";
    $stmt = $conn->prepare($borrowQuery);
    $stmt->bind_param("iis", $bookId, $userId, $cashPayment);

    if ($stmt->execute()) {
        echo "<script>alert('Book has been issued successfully!'); window.location.href='give_out_book.php';</script>";
    } else {
        echo "<script>alert('Error issuing the book. Please try again.');</script>";
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
    <title>Give Out a Book</title>
    <link rel="stylesheet" href="styles.css"> <!-- Assuming you have a styles.css file -->
</head>
<body>
    <h1>Give Out a Book</h1>
    <form method="POST">
        <label for="book_id">Select Book:</label>
        <select name="book_id" id="book_id" required>
            <option value="">--Select a Book--</option>
            <?php while ($row = $booksResult->fetch_assoc()): ?>
                <option value="<?php echo $row['book_id']; ?>"><?php echo $row['title']; ?></option>
            <?php endwhile; ?>
        </select><br><br>

        <label for="user_id">Select User:</label>
        <select name="user_id" id="user_id" required>
            <option value="">--Select a User--</option>
            <?php while ($row = $usersResult->fetch_assoc()): ?>
                <option value="<?php echo $row['user_id']; ?>"><?php echo $row['name']; ?></option>
            <?php endwhile; ?>
        </select><br><br>

        <label for="cash_payment">Cash Payment (if applicable):</label>
        <input type="number" name="cash_payment" id="cash_payment" min="0" step="0.01"><br><br>

        <button type="submit">Give Out Book</button>
    </form>
</body>
</html>
