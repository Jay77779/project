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
    <title>Student Profile</title>
    <link rel="stylesheet" href="student_profile.css">
</head>
<body>
    <div class="profile-box">
        <h2>Your Profile</h2>
        <table>
            <tr><td><strong>Name:</strong></td><td><?= htmlspecialchars($student['name']) ?></td></tr>
            <tr><td><strong>Roll No:</strong></td><td><?= htmlspecialchars($student['roll_no']) ?></td></tr>
            <tr><td><strong>Class:</strong></td><td><?= htmlspecialchars($student['class']) ?></td></tr>
            <tr><td><strong>DOB:</strong></td><td><?= htmlspecialchars($student['dob']) ?></td></tr>
            <tr><td><strong>Email:</strong></td><td><?= htmlspecialchars($student['email']) ?></td></tr>
            <tr><td><strong>Phone:</strong></td><td><?= htmlspecialchars($student['phone']) ?></td></tr>
            <tr><td><strong>Address:</strong></td><td><?= htmlspecialchars($student['address']) ?></td></tr>
        </table>
        <div class="buttons">
            <a href="student_dashboard.php">⬅ Back</a>
            <a href="student_logout.php">Logout</a>
        </div>
    </div>
</body>
</html>
