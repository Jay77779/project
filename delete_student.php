<?php
session_start();
require 'config.php';

if (!isset($_SESSION["admin_logged_in"])) {
    header("Location: admin_login.php");
    exit;
}

$id = $_GET['id'] ?? null;

if ($id) {
    $stmt = $conn->prepare("DELETE FROM students WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: view_students.php?deleted=1");
        exit;
    } else {
        echo "Error deleting student.";
    }
} else {
    echo "Invalid student ID.";
}
?>
