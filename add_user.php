<?php
session_start();

if (!isset($_SESSION['fullname'])) {
    header("Location: login.php"); 
    exit();
}
require 'db_config.php';
header('Content-Type: application/json');

$fullname = trim($_POST['fullname'] ?? '');
$email = trim($_POST['email'] ?? '');
$password = trim($_POST['password'] ?? '');

if(!$fullname || !$email || !$password){
    echo json_encode(['status'=>'error','message'=>'All fields are required']);
    exit;
}

$hashed = password_hash($password, PASSWORD_DEFAULT);
$stmt = $conn->prepare("INSERT INTO users (fullname,email,password) VALUES (?,?,?)");
$stmt->bind_param("sss", $fullname, $email, $hashed);

if($stmt->execute()){
    echo json_encode(['status'=>'success','message'=>'User added successfully!']);
} else {
    echo json_encode(['status'=>'error','message'=>$stmt->error]);
}
