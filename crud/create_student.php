<?php
session_start();
require '../db_config.php'; // adjust path if necessary

if (!isset($_SESSION['username'])) {
    header("Location: ../index.html");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name = $_POST['first_name'] ?? '';
    $last_name = $_POST['last_name'] ?? '';
    $age = $_POST['age'] ?? '';

    if (!empty($first_name) && !empty($last_name) && !empty($age)) {
        $stmt = $conn->prepare("INSERT INTO students (first_name, last_name, age) VALUES (?, ?, ?)");
        $stmt->bind_param("ssi", $first_name, $last_name, $age);
        $stmt->execute();
        $stmt->close();
    }
}

$conn->close();

// Redirect back to dashboard
header("Location: ../index.php");
exit();
?>
