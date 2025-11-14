<?php
require 'db_config.php';

// Only run if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $fullname = $_POST['fullname'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    // Simple validation
    if (empty($fullname) || empty($email) || empty($password)) {
        header("Location: signup.php?error=EmptyFields");
        exit();
    }

    $password = password_hash($password, PASSWORD_DEFAULT);

    // Check if email already exists
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        header("Location: signup.php?error=EmailAlreadyRegistered");
        exit();
    }

    // Insert new user
    $stmt = $conn->prepare("INSERT INTO users (fullname, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $fullname, $email, $password);

    if ($stmt->execute()) {
        header("Location: login.php?signup=success");
        exit();
    } else {
        header("Location: signup.php?error=DatabaseError");
        exit();
    }

    $conn->close();
}
?>
