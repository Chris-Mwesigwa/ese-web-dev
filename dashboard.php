<?php
require 'db.php'; 
include 'navbar.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if($_SESSION['role'] === 'student'){
    header("Location: index.php");
}

// Fetch borrowed books
$borrowedBooksQuery = "SELECT br.record_id, b.title, u.name, br.borrow_date, br.return_date 
                       FROM borrow_records br 
                       JOIN books b ON br.book_id = b.book_id 
                       JOIN users u ON br.user_id = u.user_id 
                       WHERE br.status = 'borrowed'";
$borrowedBooks = $conn->query($borrowedBooksQuery);

// Fetch returned books
$returnedBooksQuery = "SELECT b.title, u.name, br.return_date 
                       FROM borrow_records br 
                       JOIN books b ON br.book_id = b.book_id 
                       JOIN users u ON br.user_id = u.user_id 
                       WHERE br.status = 'returned'";
$returnedBooks = $conn->query($returnedBooksQuery);

// Fetch registered users
$registeredUsersQuery = "SELECT *FROM users";
$registeredUsers= $conn->query($registeredUsersQuery);

// Fetch Available subjects
$trainingSubjectsQuery = "SELECT *FROM training_subjects";
$trainingSubjects= $conn->query($trainingSubjectsQuery);

// Fetch users
$usersQuery = "SELECT name, role, email FROM users";
$users = $conn->query($usersQuery);

// Punished users query
$punishedUsersQuery = "SELECT br.record_id, u.name, b.title, br.status 
                        FROM borrow_records br 
                        JOIN users u ON br.user_id = u.user_id 
                        JOIN books b ON br.book_id = b.book_id 
                        WHERE br.status = 'punished'";
$punishedUsers = $conn->query($punishedUsersQuery);

// Handle book giving out
if (isset($_POST['give_out'])) {
    $bookId = $_POST['book_id'];
    $userId = $_POST['user_id'];
    $borrowDate = date('Y-m-d');
    $returnDate = date('Y-m-d', strtotime('+7 days')); // Assume 7 days for return
    $giveOutQuery = "INSERT INTO borrow_records (user_id, book_id, borrow_date, return_date, status) 
                     VALUES (?, ?, ?, ?, 'borrowed')";
    $stmt = $conn->prepare($giveOutQuery);
    $stmt->bind_param("iiss", $userId, $bookId, $borrowDate, $returnDate);
    if ($stmt->execute()) {
        echo "<script>alert('Book has been successfully borrowed.'); window.location.href='dashboard.php';</script>";
    } else {
        echo "<script>alert('Error giving out book. Please try again.');</script>";
    }
    $stmt->close();
}

// Handle book return
if (isset($_POST['return_book'])) {
    $recordId = $_POST['record_id'];
    $returnQuery = "UPDATE borrow_records SET status = 'returned' WHERE record_id = ?";
    $stmt = $conn->prepare($returnQuery);
    $stmt->bind_param("i", $recordId);
    if ($stmt->execute()) {
        echo "<script>alert('Book has been returned successfully.'); window.location.href='dashboard.php';</script>";
    } else {
        echo "<script>alert('Error returning book. Please try again.');</script>";
    }
    $stmt->close();
}

// Handle punishing late returns
if (isset($_POST['punish_late'])) {
    $recordId = $_POST['record_id'];
    $punishQuery = "UPDATE borrow_records SET status = 'punished' WHERE record_id = ?";
    $stmt = $conn->prepare($punishQuery);
    $stmt->bind_param("i", $recordId);
    if ($stmt->execute()) {
        echo "<script>alert('User has been punished for late return.'); window.location.href='dashboard.php';</script>";
    } else {
        echo "<script>alert('Error punishing user. Please try again.');</script>";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 16px;
            background-color: #f4f4f9;
        }
        h1, h2 {
            /* text-align: center; */
            color: #333;
        }
        h2 {
            margin-top: 40px;
        }
        table {
            width: 100%;
            margin: 0 auto;
            border-collapse: collapse;
            background-color: #fff;
            border: 1px solid #ccc;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        th, td {
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
        }
        th {
            background-color: #007bff;
            color: #fff;
            text-align: left;
        }
        tr:hover {
            background-color: #f9f9f9;
        }
        .btn {
            display: inline-block;
            padding: 6px 12px;
            font-size: 14px;
            color: #fff;
            background-color: #28a745;
            border: none;
            border-radius: 4px;
            text-decoration: none;
            cursor: pointer;
        }
        .btn:hover {
            background-color: #218838;
        }
        section {
            margin-block: 40px;
        }
    </style>
</head>
<body>
    <h1>Dashboard</h1>

    <section>
        <h2>Borrowed Books</h2>
        <table>
            <tr>
                <th>Title</th>
                <th>Borrower</th>
                <th>Borrow Date</th>
                <th>Return Date</th>
                <th>Actions</th>
            </tr>
            <?php while ($row = $borrowedBooks->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['title']; ?></td>
                    <td><?php echo $row['name']; ?></td>
                    <td><?php echo $row['borrow_date']; ?></td>
                    <td><?php echo $row['return_date']; ?></td>
                    <td>
                        <!-- Return Book Button -->
                        <form method="POST" style="display:inline-block;">
                            <input type="hidden" name="record_id" value="<?php echo $row['record_id']; ?>">
                            <button type="submit" name="return_book" class="btn">Return Book</button>
                        </form>
                        <!-- Punish Late Return Button -->
                        <form method="POST" style="display:inline-block;">
                            <input type="hidden" name="record_id" value="<?php echo $row['record_id']; ?>">
                            <button type="submit" name="punish_late" class="btn">Punish Late Return</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
    </section>

    <section>
        <div style="display: flex; flex-direction:column;">
            <h2>Available Books</h2>
            <a class='btn' href="add_book.php" style="width:text;">Add Book</a>
        </div>
        <table>
            <tr>
                <th>Title</th>
                <th>Author</th>
                <th>Actions</th>
            </tr>
            <?php
                // Fetch available books
                $availableBooksQuery = "SELECT book_id, title, author FROM books WHERE status = 'available'";
                $availableBooks = $conn->query($availableBooksQuery);
                while ($row = $availableBooks->fetch_assoc()):
            ?>
                <tr>
                    <td><?php echo $row['title']; ?></td>
                    <td><?php echo $row['author']; ?></td>
                    <td>
                        <form method="POST" style="display:inline-block;">
                            <input type="hidden" name="book_id" value="<?php echo $row['book_id']; ?>">
                            <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id']; ?>">
                            <button type="submit" name="give_out" class="btn">Give Out</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
    </section>

    <section>
        <h2>Available training subjects</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Description</th>
                <th>Fee</th>
            </tr>
            <?php while ($row = $trainingSubjects->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['subject_id']; ?></td>
                    <td><?php echo $row['subject_name']; ?></td>
                    <td><?php echo $row['description']; ?></td>
                    <td><?php echo $row['fee']; ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    </section>

    <section>
        <h2>Returned Books</h2>
        <table>
            <tr>
                <th>Title</th>
                <th>Borrower</th>
                <th>Return Date</th>
            </tr>
            <?php while ($row = $returnedBooks->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['title']; ?></td>
                    <td><?php echo $row['name']; ?></td>
                    <td><?php echo $row['return_date']; ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    </section>

    <section>
        <h2>Punished Users</h2>
        <table>
            <tr>
                <th>User</th>
                <th>Book Title</th>
                <th>Reason</th>
                <th>Actions</th>
            </tr>
            <?php while ($row = $punishedUsers->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['name']; ?></td>
                    <td><?php echo $row['title']; ?></td>
                    <td><?php echo $row['status']; ?></td>
                    <td>
                        <button>Paddon</button>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
    </section>

    <section>
        <h2>Registered users</h2>
        <table>
            <tr>
                <th>UserID</th>
                <th>Names Title</th>
                <th>Phone Number</th>
                <th>Email</th>
                <th>Address</th>
                <th>Username</th>
                <th>Role</th>
                <th>Actions</th>
            </tr>
            <?php while ($row = $registeredUsers->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['user_id']; ?></td>
                    <td><?php echo $row['name']; ?></td>
                    <td><?php echo $row['phone']; ?></td>
                    <td><?php echo $row['email']; ?></td>
                    <td><?php echo $row['address']; ?></td>
                    <td><?php echo $row['username']; ?></td>
                    <td><?php echo $row['role']; ?></td>
                    <td>
                        <!-- Action Buttons if needed -->
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
    </section>
</body>
</html>