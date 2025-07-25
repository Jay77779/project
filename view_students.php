<?php
session_start();
require 'config.php';

if (!isset($_SESSION["admin_logged_in"])) {
    header("Location: admin_login.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>View Students</title>
    <link rel="stylesheet" href="viewcss.css">
</head>
<body>
<div class="table-box">
    <h2>Student List</h2>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th><th>Name</th><th>Roll No</th><th>Class</th>
                <th>Email</th><th>Phone</th><th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php
        $sql = "SELECT * FROM students ORDER BY id DESC";
        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                    <td>{$row['id']}</td>
                    <td>{$row['name']}</td>
                    <td>{$row['roll_no']}</td>
                    <td>{$row['class']}</td>
                    <td>{$row['email']}</td>
                    <td>{$row['phone']}</td>
                    <td>
                        <a href='edit_student.php?id={$row['id']}'>Edit</a> |
                        <a href='delete_student.php?id={$row['id']}' onclick='return confirm(\"Are you sure?\")'>Delete</a>
                    </td>
                </tr>";
            }
        } else {
            echo "<tr><td colspan='7'>No students found.</td></tr>";
        }
        ?>
        </tbody>
    </table>
    <a href="dashboard.php" class="btn">Back to Dashboard</a>
</div>
</body>
</html>
