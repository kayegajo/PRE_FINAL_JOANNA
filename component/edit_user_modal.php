<div class="modal fade" id="editUserModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="editUserForm">
        <div class="modal-header">
          <h5 class="modal-title">Edit User</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">
          <input type="hidden" id="editId" name="id">
          <div class="mb-3">
            <label>Full Name</label>
            <input type="text" id="editFullname" name="fullname" class="form-control" required>
          </div>
          <div class="mb-3">
            <label>Email</label>
            <input type="email" id="editEmail" name="email" class="form-control" required>
          </div>
          <div class="mb-3">
            <label>Password (leave blank to keep current)</label>
            <input type="password" id="editPassword" name="password" class="form-control">
          </div>
        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Save Changes</button>
        </div>
      </form>
    </div>
  </div>
</div>
