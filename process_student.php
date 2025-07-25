<?php
session_start();
require 'config.php';

if (!isset($_SESSION["admin_logged_in"])) {
    header("Location: admin_login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name     = trim($_POST["name"]);
    $roll_no  = trim($_POST["roll_no"]);
    $class    = trim($_POST["class"]);
    $gender   = $_POST["gender"];
    $dob      = $_POST["dob"];
    $email    = trim($_POST["email"]);
    $phone    = trim($_POST["phone"]);
    $address  = trim($_POST["address"]);
    $password = trim($_POST["password"]);

    if (
        empty($name) || empty($roll_no) || empty($class) || empty($gender) ||
        empty($dob) || empty($email) || empty($phone) || empty($address) || empty($password)
    ) {
        die("All fields are required.");
    }

    $check = $conn->prepare("SELECT id FROM students WHERE roll_no = ?");
    $check->bind_param("s", $roll_no);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        echo "<script>
            alert('Student with this Roll Number already exists.');
            window.location.href = 'add_student_form.html';
        </script>";
        exit;
    }

    $stmt = $conn->prepare("INSERT INTO students (name, roll_no, password, class, gender, dob, email, phone, address, created_at) 
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())");
    $stmt->bind_param("sssssssss", $name, $roll_no, $password, $class, $gender, $dob, $email, $phone, $address);

    if ($stmt->execute()) {
        echo "<script>
            alert('Student added successfully.');
            window.location.href = 'add_student_form.html';
        </script>";
        exit;
    } else {
        echo "<script>
            alert('Error: " . addslashes($stmt->error) . "');
            window.location.href = 'add_student_form.html';
        </script>";
        exit;
    }
}
?>