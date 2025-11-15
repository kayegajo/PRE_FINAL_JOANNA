<?php
session_start();
require 'db_config.php'; // Database connection

if (!isset($_SESSION['fullname'])) {
    header("Location: login.php");
    exit();
}

// Fetch students from database
$students = [];
$result = $conn->query("SELECT * FROM students ORDER BY id ASC");
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $students[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dashboard - CRUD</title>
<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<style>
header { background-color: #1c1c1c; color: white; padding: 20px; text-align: center; font-size: 20px; font-weight: 600; height:100px; }
.action-btn { padding: 5px 10px; border: none; border-radius: 5px; color: white; cursor: pointer; font-size: 14px; margin-right: 5px; }
.btn-user {
    background-color: #5361b3ff; /* Green background */
    color: white; /* Text color */
    border: none; /* Optional: remove border */
    border-radius: 5px; /* Optional: rounded corners */
}

.btn-user:hover {
    background-color: #4442c2ff; /* Slightly darker on hover */
}

.edit { background-color: #ff9800; }
.delete { background-color: #f44336; }
table.table {
    background-color: #f8f9fa; /* Light grey background for readability */
}
table.table th {
    background-color: #343a40; /* Darker header for contrast */
    color: white;
}
table.table td {
    background-color: #ffffff; /* White for table rows */
}

</style>
<body>
<header>CRUD APPLICATION USING PHP AND MYSQL</header>

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>All Students</h2>
        <div>
            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#studentModal">Create</button>
            <button class="btn btn-user" onclick="window.location.href='user.php'">Users</button>
             <button class="btn btn-danger" onclick="window.location.href='logout.php'">Logout</button>
        </div>
        </div>
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Age</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($students as $student): ?>
            <tr>
                <td><?php echo $student['id']; ?></td>
                <td><?php echo htmlspecialchars($student['first_name']); ?></td>
                <td><?php echo htmlspecialchars($student['last_name']); ?></td>
                <td><?php echo $student['age']; ?></td>
                <td>
                    <button class="action-btn edit" data-bs-toggle="modal" data-bs-target="#editModal<?php echo $student['id']; ?>">Edit</button>
                    <a href="crud/delete_student.php?id=<?php echo $student['id']; ?>" class="action-btn delete" onclick="return confirm('Are you sure you want to delete this student?')">Delete</a>
                </td>
            </tr>

            <!-- Edit Modal for each student -->
            <div class="modal fade" id="editModal<?php echo $student['id']; ?>" tabindex="-1" aria-labelledby="editModalLabel<?php echo $student['id']; ?>" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <form action="crud/edit_student.php" method="POST">
                    <div class="modal-header">
                      <h5 class="modal-title" id="editModalLabel<?php echo $student['id']; ?>">Edit Student</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id" value="<?php echo $student['id']; ?>">
                        <div class="mb-3">
                          <label class="form-label">First Name</label>
                          <input type="text" class="form-control" name="first_name" value="<?php echo htmlspecialchars($student['first_name']); ?>" required>
                        </div>
                        <div class="mb-3">
                          <label class="form-label">Last Name</label>
                          <input type="text" class="form-control" name="last_name" value="<?php echo htmlspecialchars($student['last_name']); ?>" required>
                        </div>
                        <div class="mb-3">
                          <label class="form-label">Age</label>
                          <input type="number" class="form-control" name="age" value="<?php echo $student['age']; ?>" min="1" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                      <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- Add Student Modal -->
<div class="modal fade" id="studentModal" tabindex="-1" aria-labelledby="studentModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="studentForm" action="crud/create_student.php" method="POST">
        <div class="modal-header">
          <h5 class="modal-title" id="studentModalLabel">Add Student</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="mb-3">
              <label for="firstName" class="form-label">First Name</label>
              <input type="text" class="form-control" id="firstName" name="first_name" required>
            </div>
            <div class="mb-3">
              <label for="lastName" class="form-label">Last Name</label>
              <input type="text" class="form-control" id="lastName" name="last_name" required>
            </div>
            <div class="mb-3">
              <label for="age" class="form-label">Age</label>
              <input type="number" class="form-control" id="age" name="age" min="1" required>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Bootstrap JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
