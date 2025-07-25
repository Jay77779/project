<?php
session_start();
require 'config.php';

if (!isset($_SESSION['student'])) {
    header("Location: student_login.php");
    exit;
}

$student = $_SESSION['student'];
$student_id = $student['id'];

// Fetch marks from database
$stmt = $conn->prepare("SELECT subject, marks, exam, created_at FROM student_marks WHERE student_id = ?");
$stmt->bind_param("i", $student_id);
$stmt->execute();
$result = $stmt->get_result();
$marks = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Student Marks</title>
    <link rel="stylesheet" href="student_marks.css">
</head>
<body>
    <div class="marks-box">
        <h2>Your Marks</h2>

        <?php if (empty($marks)): ?>
            <p>No marks available.</p>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>Subject</th>
                        <th>Marks</th>
                        <th>Exam</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($marks as $m): ?>
                        <tr>
                            <td><?= htmlspecialchars($m['subject']) ?></td>
                            <td><?= htmlspecialchars($m['marks']) ?></td>
                            <td><?= htmlspecialchars($m['exam']) ?></td>
                            <td><?= date('d-M-Y', strtotime($m['created_at'])) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>

        <div class="buttons">
            <a href="student_dashboard.php">⬅ Back to Dashboard</a>
        </div>
    </div>
</body>
</html>