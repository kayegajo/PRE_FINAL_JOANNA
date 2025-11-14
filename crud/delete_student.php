<?php
session_start();
require '../db_config.php'; // adjust path if necessary

if (!isset($_SESSION['username'])) {
    header("Location: ../index.html");
    exit();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $conn->prepare("DELETE FROM students WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
}

$conn->close();
header("Location: ../index.php");
exit();
?>
