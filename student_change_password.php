<?php
session_start();
require 'config.php';

if (!isset($_SESSION['student'])) {
    header("Location: student_login.php");
    exit;
}

$student_id = $_SESSION['student']['id'];
$success = $error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $current = $_POST['current_password'];
    $new = $_POST['new_password'];
    $confirm = $_POST['confirm_password'];

    // Fetch current password from DB
    $stmt = $conn->prepare("SELECT password FROM students WHERE id = ?");
    $stmt->bind_param("i", $student_id);
    $stmt->execute();
    $stmt->bind_result($db_password);
    $stmt->fetch();
    $stmt->close();

    if ($current !== $db_password) {
        $error = "❌ Current password is incorrect.";
    } elseif ($new !== $confirm) {
        $error = "❌ New passwords do not match.";
    } else {
        $update = $conn->prepare("UPDATE students SET password = ? WHERE id = ?");
        $update->bind_param("si", $new, $student_id);
        if ($update->execute()) {
            $success = "✅ Password changed successfully.";
            $_SESSION['student']['password'] = $new;
        } else {
            $error = "❌ Error updating password.";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Change Password</title>
    <link rel="stylesheet" href="student_change_password.css">
</head>
<body>
    <div class="form-box">
        <h2>Change Password</h2>
        <?php if ($success): ?>
            <p class="success"><?= $success ?></p>
        <?php elseif ($error): ?>
            <p class="error"><?= $error ?></p>
        <?php endif; ?>

        <form method="POST">
            <label>Current Password</label>
            <input type="password" name="current_password" required>

            <label>New Password</label>
            <input type="password" name="new_password" required>

            <label>Confirm New Password</label>
            <input type="password" name="confirm_password" required>

            <input type="submit" value="Change Password">
        </form>

        <a href="student_dashboard.php">⬅ Back to Dashboard</a>
    </div>
</body>
</html>
