<?php
session_start();
require 'config.php';

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php");
    exit;
}

$success = $error = "";

// Fetch all students
$students = $conn->query("SELECT id, name, roll_no FROM students ORDER BY name ASC");

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $student_id = $_POST['student_id'];
    $subject = $_POST['subject'];
    $marks = $_POST['marks'];
    $exam = $_POST['exam'];

    if ($student_id && $subject && $marks !== "" && $exam) {
        $stmt = $conn->prepare("INSERT INTO student_marks (student_id, subject, marks, exam) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("isis", $student_id, $subject, $marks, $exam);
        if ($stmt->execute()) {
            $success = "Marks added successfully.";
        } else {
            $error = "Failed to add marks.";
        }
    } else {
        $error = "All fields are required.";
    }
}

include 'add_marks.html';
?>
