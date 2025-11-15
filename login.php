<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start(); 
require 'db_config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if (empty($username) || empty($password)) {
        header("Location: index.html?error=EmptyFields");
        exit();
    }

    // Check user credentials
    $stmt = $conn->prepare("SELECT * FROM users WHERE email=? OR fullname=?");
    $stmt->bind_param("ss", $username, $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            // ✅ Set session after successful login
            $_SESSION['fullname'] = $row['fullname']; // or $row['email'] if you prefer
            header("Location: index.php"); // Redirect to dashboard
            exit();
        } else {
            header("Location: index.html?error=IncorrectPassword");
            exit();
        }
    } else {
        header("Location: index.html?error=NoAccount");
        exit();
    }

    $stmt->close();
    $conn->close();
} else {
    // If accessed directly without POST, redirect to the login form
    header("Location: index.html");
    exit();
}
?>
