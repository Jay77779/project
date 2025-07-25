<?php
session_start();
if (!isset($_SESSION['student'])) {
    header("Location: student_login.php");
    exit;
}

$student = $_SESSION['student'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Student Dashboard</title>
    <link rel="stylesheet" href="student_dashboard.css">
</head>
<body>
    <div class="dashboard-box">
        <h2>Welcome, <?= htmlspecialchars($student['name']) ?></h2>
        <p>Roll No: <?= htmlspecialchars($student['roll_no']) ?></p>
        <p>Email: <?= htmlspecialchars($student['email']) ?></p>
        <p>Class: <?= htmlspecialchars($student['class']) ?></p>

        <div class="buttons">
            <a href="student_profile.php" class="btn">View Full Profile</a>
            <a href="student_marks.php" class="btn">📊 View Marks</a>
            <a href="student_logout.php" class="btn logout">Logout</a>
            <a href="student_change_password.php" class="btn change-pass">🔒 Change Password</a>
        </div>
    </div>
</body>
</html>
