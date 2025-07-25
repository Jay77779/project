<?php
$host = 'localhost';
$db = 'student_db';
$user = 'root';
$pass = ''; // Default XAMPP MySQL password is empty

$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>