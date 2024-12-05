<?php
    
$conn = new mysqli("localhost", "root", "pass", "web_training_db");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>