<?php
session_start();
require 'config.php';  

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $roll_no = $_POST['roll_no'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM students WHERE roll_no = ? AND password = ?");
    $stmt->bind_param("ss", $roll_no, $password);
    $stmt->execute();
    $result = $stmt->get_result();
    $student = $result->fetch_assoc();

    if ($student) {
        $_SESSION['student'] = $student;
        header("Location: student_dashboard.php");
        exit;
    } else {
        $error = "Invalid roll number or password!";
    }
}
?>

<?php include 'student_login.html'; ?>
