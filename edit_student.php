<?php
session_start();
require 'config.php';

if (!isset($_SESSION["admin_logged_in"])) {
    header("Location: admin_login.php");
    exit;
}

$id = $_GET['id'] ?? null;
if (!$id) {
    echo "Invalid ID."; exit;
}

$success = $error = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $roll_no = $_POST["roll_no"];
    $class = $_POST["class"];
    $gender = $_POST["gender"];
    $dob = $_POST["dob"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $address = $_POST["address"];

    $stmt = $conn->prepare("UPDATE students SET name=?, roll_no=?, class=?, gender=?, dob=?, email=?, phone=?, address=? WHERE id=?");
    $stmt->bind_param("ssssssssi", $name, $roll_no, $class, $gender, $dob, $email, $phone, $address, $id);

    if ($stmt->execute()) {
        echo "<script>
            alert('Student updated successfully.');
            window.location.href = 'view_students.php';
        </script>";
        exit;
    } else {
        $error = "Update failed: " . $stmt->error;
    }
}

$stmt = $conn->prepare("SELECT * FROM students WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$student = $stmt->get_result()->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Student</title>
    <link rel="stylesheet" href="css/studentadd.css">
</head>
<body>
    <div class="form-box">
        <h2>Edit Student</h2>
        <?php if ($success): ?><p class="success"><?= $success ?></p><?php endif; ?>
        <?php if ($error): ?><p class="error"><?= $error ?></p><?php endif; ?>

        <form method="POST">
            <input type="text" name="name" value="<?= htmlspecialchars($student['name']) ?>" placeholder="Full Name" required>
            <input type="text" name="roll_no" value="<?= htmlspecialchars($student['roll_no']) ?>" placeholder="Roll No" required>
            <input type="text" name="class" value="<?= htmlspecialchars($student['class']) ?>" placeholder="Class" required>

            <select name="gender" required>
                <option value="">Select Gender</option>
                <option value="Male" <?= $student['gender'] === 'Male' ? 'selected' : '' ?>>Male</option>
                <option value="Female" <?= $student['gender'] === 'Female' ? 'selected' : '' ?>>Female</option>
            </select>

            <input type="date" name="dob" value="<?= $student['dob'] ?>" required>
            <input type="email" name="email" value="<?= htmlspecialchars($student['email']) ?>" placeholder="Email" required>
            <input type="text" name="phone" value="<?= htmlspecialchars($student['phone']) ?>" placeholder="Phone" required>
            <textarea name="address" placeholder="Address"><?= htmlspecialchars($student['address']) ?></textarea>
            <button type="submit">Update Student</button>
        </form>
    </div>
</body>
</html>
