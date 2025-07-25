<?php
session_start();
require 'config.php';
$error ="";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);

    if (empty($username) || empty($password)) {
        $error = "Please enter both username and password.";
    } else {
        $sql = "SELECT * FROM admin WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $admin = $result->fetch_assoc();

            // Simple plaintext comparison
            if ($admin['password'] === $password) {
                $_SESSION["admin_logged_in"] = true;
                $_SESSION["admin_username"] = $admin["username"];
                header("Location: dashboard.html");
                exit;
            } else {
                $error = "Invalid password.";
            }
        } else {
            $error = "Admin not found.";
        }
    }
}
include 'admin_login.html';
?>
