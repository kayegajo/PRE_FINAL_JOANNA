<?php
include 'db_config.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>User Management</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    /* Header Styling */
    .page-header {
      background-color: black;
      color: white;
      padding: 20px;
      text-align: center;
      margin-bottom: 30px;
      border-radius: 8px;
      background-image: url('your-background-image.jpg'); /* Optional */
      background-size: cover;
      background-position: center;
    }

    .action-buttons {
      display: flex;
      justify-content: flex-end;
      gap: 10px;
      margin-bottom: 20px;
      flex-wrap: wrap;
    }
    .action-buttons h3 {
      margin-right: auto;
      align-self: center;
    }
  </style>
</head>
<body>

<div class="container mt-4">
    <!-- Header -->
    <h3 class="page-header">USER MANAGEMENT</h3>

    <!-- Action Buttons -->
    <div class="action-buttons">
       <h3>ALL USERS</h3>
        <a href="index.php" class="btn btn-secondary">Students</a>
        <button class="btn btn-danger" id="logoutBtn">Logout</button>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">Add User</button>
    </div>

    <!-- Users Table -->
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
         
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            <?php
            $sql = "SELECT * FROM users ORDER BY id ASC";
            $result = mysqli_query($conn, $sql);
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<tr>
                        <td>'.$row['id'].'</td>
                        <td>'.htmlspecialchars($row['fullname']).'</td>
                        <td>'.htmlspecialchars($row['email']).'</td>
                        <td>
                            <button class="btn btn-sm btn-warning editBtn"
                                data-id="'.$row['id'].'"
                                data-fullname="'.htmlspecialchars($row['fullname']).'"
                                data-email="'.htmlspecialchars($row['email']).'">
                                Edit
                            </button>
                            <a href="delete_user.php?id='.$row['id'].'" class="btn btn-sm btn-danger"
                               onclick="return confirm(\'Are you sure?\')">Delete</a>
                        </td>
                      </tr>';
            }
            ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Include Modals -->
<?php include 'component/user_modal.php'; ?>
<?php include 'component/edit_user_modal.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {

    // Logout Button
    document.getElementById("logoutBtn").addEventListener("click", function(){
        if(confirm("Are you sure you want to logout?")){
            window.location.href = "logout.php";
        }
    });

    // Open Edit Modal and fill data
    const editButtons = document.querySelectorAll(".editBtn");
    editButtons.forEach(btn => {
        btn.addEventListener("click", function() {
            const id = this.dataset.id;
            const fullname = this.dataset.fullname;
            const email = this.dataset.email;

            document.getElementById("editId").value = id;
            document.getElementById("editFullname").value = fullname;
            document.getElementById("editEmail").value = email;
            document.getElementById("editPassword").value = "";

            const modal = new bootstrap.Modal(document.getElementById("editUserModal"));
            modal.show();
        });
    });

    // Add User Form
    document.getElementById("addUserForm").addEventListener("submit", function(e){
        e.preventDefault();
        let formData = new FormData(this);

        fetch("add_user.php", {
            method: "POST",
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            alert(data.message);
            if(data.status === "success") location.reload();
        });
    });

    // Edit User Form
    document.getElementById("editUserForm").addEventListener("submit", function(e){
        e.preventDefault();
        let formData = new FormData(this);

        fetch("update_user.php", {
            method: "POST",
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            alert(data.message);
            if(data.status === "success") location.reload();
        });
    });

});
</script>
</body>
</html>
