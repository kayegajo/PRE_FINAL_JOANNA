<?php
require 'db_config.php';
header('Content-Type: application/json');

$id = $_POST['id'] ?? '';
$fullname = trim($_POST['fullname'] ?? '');
$email = trim($_POST['email'] ?? '');
$password = trim($_POST['password'] ?? '');

if(!$id || !$fullname || !$email){
    echo json_encode(['status'=>'error','message'=>'ID, Name, and Email are required']);
    exit;
}

if($password){
    $hashed = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("UPDATE users SET fullname=?, email=?, password=? WHERE id=?");
    $stmt->bind_param("sssi", $fullname, $email, $hashed, $id);
} else {
    $stmt = $conn->prepare("UPDATE users SET fullname=?, email=? WHERE id=?");
    $stmt->bind_param("ssi", $fullname, $email, $id);
}

if($stmt->execute()){
    echo json_encode(['status'=>'success','message'=>'User updated successfully!']);
} else {
    echo json_encode(['status'=>'error','message'=>$stmt->error]);
}
