<?php
include 'db_config.php';

if(isset($_GET['id'])){
    $id = $_GET['id'];

    $sql = "DELETE FROM users WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);

    if(mysqli_stmt_execute($stmt)){
        header("Location: user.php?success=User deleted successfully");
        exit();
    } else {
        header("Location: user.php?error=Failed to delete user");
        exit();
    }
} else {
    header("Location: user.php?error=Invalid ID");
    exit();
}
?>
