<?php
$host = "localhost";
$user = "root"; 
$pass = "";
$db   = "others_management"; // 🔥 change this to your real database name

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
