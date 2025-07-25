<?php
session_start();
require 'config.php';

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php");
    exit;
}

$id = $_GET['id'] ?? null;

if (!$id) {
    header("Location: manage_marks.php");
    exit;
}

$stmt = $conn->prepare("SELECT * FROM student_marks WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$mark = $stmt->get_result()->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $subject = $_POST['subject'];
    $marks = $_POST['marks'];
    $exam = $_POST['exam'];

    $update = $conn->prepare("UPDATE student_marks SET subject = ?, marks = ?, exam = ? WHERE id = ?");
    $update->bind_param("sisi", $subject, $marks, $exam, $id);
    if ($update->execute()) {
        header("Location: manage_marks.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Marks</title>
    <link rel="stylesheet" href="edit_marks.css">
</head>
<body>
    <div class="container">
        <h2>Edit Marks</h2>
        <form method="POST">
            <label>Subject</label>
            <input type="text" name="subject" value="<?= htmlspecialchars($mark['subject']) ?>" required>

            <label>Marks</label>
            <input type="number" name="marks" value="<?= htmlspecialchars($mark['marks']) ?>" required>

            <label>Exam Type</label>
            <input type="text" name="exam" value="<?= htmlspecialchars($mark['exam']) ?>" required>

            <input type="submit" value="Update">
        </form>
        <a href="manage_marks.php">⬅ Cancel</a>
    </div>
</body>
</html>
