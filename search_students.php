<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: admin_login.php");
    exit;
}

include 'config.php';

$students = [];

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['search'])) {
    $search = "%" . $_GET['search'] . "%";

    $stmt = $conn->prepare("SELECT * FROM students WHERE name LIKE ? OR email LIKE ?");
    $stmt->bind_param("ss", $search, $search);
    $stmt->execute();
    $result = $stmt->get_result();
    $students = $result->fetch_all(MYSQLI_ASSOC);
}
?>

<?php include 'search_students.html'; ?>
