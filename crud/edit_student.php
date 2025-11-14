<?php
session_start();
require '../db_config.php'; // adjust path if necessary

if (!isset($_SESSION['username'])) {
    header("Location: ../index.html");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? '';
    $first_name = $_POST['first_name'] ?? '';
    $last_name = $_POST['last_name'] ?? '';
    $age = $_POST['age'] ?? '';

    if (!empty($id) && !empty($first_name) && !empty($last_name) && !empty($age)) {
        $stmt = $conn->prepare("UPDATE students SET first_name=?, last_name=?, age=? WHERE id=?");
        $stmt->bind_param("ssii", $first_name, $last_name, $age, $id);
        $stmt->execute();
        $stmt->close();
    }
}

$conn->close();
header("Location: ../index.php");
exit();
?>
