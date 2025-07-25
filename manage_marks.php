<?php
session_start();
require 'config.php';

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php");
    exit;
}

$query = "
    SELECT m.id, s.name, s.roll_no, m.subject, m.marks, m.exam
    FROM student_marks m
    JOIN students s ON m.student_id = s.id
    ORDER BY m.id DESC
";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Marks</title>
    <link rel="stylesheet" href="edit_marks.css">
</head>
<body>
    <div class="container">
        <h2>All Student Marks</h2>
        <table>
            <thead>
                <tr>
                    <th>Student</th>
                    <th>Roll No</th>
                    <th>Subject</th>
                    <th>Marks</th>
                    <th>Exam</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['name']) ?></td>
                        <td><?= htmlspecialchars($row['roll_no']) ?></td>
                        <td><?= htmlspecialchars($row['subject']) ?></td>
                        <td><?= htmlspecialchars($row['marks']) ?></td>
                        <td><?= htmlspecialchars($row['exam']) ?></td>
                        <td>
                            <a href="edit_marks.php?id=<?= $row['id'] ?>">✏️ Edit</a>
                            <a href="delete_marks.php?id=<?= $row['id'] ?>" onclick="return confirm('Are you sure?')">❌ Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <a href="dashboard.php">⬅ Back to Dashboard</a>
    </div>
</body>
</html>
