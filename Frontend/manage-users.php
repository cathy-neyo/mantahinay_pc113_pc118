<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Manage Users</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <!-- DataTables CSS -->
  <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet" />
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <link rel="stylesheet" href="admin-style.css" />

  <!-- jQuery -->
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.0/dist/jquery.min.js"></script>
  <!-- Bootstrap JS Bundle -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <!-- DataTables JS -->
  <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
  <!-- SweetAlert2 -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

<?php include 'sidebar.php'; ?>

<div class="main-content">
  <div class="top-navbar">
    <div><strong>MANAGE USERS</strong></div>
  </div>

  <div class="container-fluid">
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addUserModal">Add User</button>

    <table class="table table-bordered" id="userTable">
      <thead>
        <tr>
          <th>ID</th>
          <th>Full Name</th>
          <th>Email</th>
          <th>Role</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody id="userTableBody"></tbody>
    </table>
  </div>
</div>

<!-- Add User Modal -->
<div class="modal fade" id="addUserModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="addUserForm">
        <div class="modal-header">
          <h5 class="modal-title">Add New User</h5>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label for="addName" class="form-label">Full Name</label>
            <input type="text" class="form-control" id="addName" name="name" required />
          </div>
          <div class="mb-3">
            <label for="addEmail" class="form-label">Email</label>
            <input type="email" class="form-control" id="addEmail" name="email" required />
          </div>
          <div class="mb-3">
            <label for="addPassword" class="form-label">Password</label>
            <input type="password" class="form-control" id="addPassword" name="password" required />
          </div>
          <div class="mb-3">
            <label for="addRole" class="form-label">Role</label>
            <select class="form-select" id="addRole" name="role" required>
              <option value="">Select Role</option>
              <option value="0">Admin</option>
              <option value="1">Coordinator</option>
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Add User</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Edit User Modal -->
<div class="modal fade" id="editUserModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="editUserForm">
        <div class="modal-header">
          <h5 class="modal-title">Edit User</h5>
        </div>
        <div class="modal-body">
          <input type="hidden" id="editId" name="id" />
          <div class="mb-3">
            <label for="editName" class="form-label">Full Name</label>
            <input type="text" class="form-control" id="editName" name="name" required />
          </div>
          <div class="mb-3">
            <label for="editEmail" class="form-label">Email</label>
            <input type="email" class="form-control" id="editEmail" name="email" required />
          </div>
          <div class="mb-3">
            <label for="editRole" class="form-label">Role</label>
            <select class="form-select" id="editRole" name="role" required>
              <option value="0">Admin</option>
              <option value="1">Coordinator</option>
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Update</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
  const apiBase = 'http://localhost:8000/api/users';

  function getRoleName(role) {
    return role == 0 ? 'Admin' : role == 1 ? 'Coordinator' : 'Evaluator';
  }

  // We keep DataTable instance global to reload properly
  let userTable;

  function fetchUsers() {
    $.getJSON(apiBase, function (data) {
      let rows = '';
      data.forEach((user) => {
        rows += `
          <tr>
            <td>${user.id}</td>
            <td>${user.name}</td>
            <td>${user.email}</td>
            <td>${getRoleName(user.role)}</td>
            <td>
              <button class="btn btn-sm btn-warning" onclick="editUser(${user.id})">Edit</button>
              <button class="btn btn-sm btn-danger" onclick="deleteUser(${user.id})">Delete</button>
            </td>
          </tr>
        `;
      });

      // Destroy and recreate DataTable for refresh
      if (userTable) {
        userTable.clear().destroy();
      }
      $('#userTableBody').html(rows);
      userTable = $('#userTable').DataTable({
        pageLength: 5,
        lengthMenu: [5, 10, 25, 50],
      });
    });
  }

  $('#addUserForm').submit(function (e) {
    e.preventDefault();
    const formData = {
      name: $('#addName').val(),
      email: $('#addEmail').val(),
      password: $('#addPassword').val(),
      role: $('#addRole').val(),
    };

    $.post(apiBase, formData)
      .done(() => {
        $('#addUserModal').modal('hide');
        this.reset();
        fetchUsers();
        Swal.fire('Success', 'User added!', 'success');
      })
      .fail(() => {
        Swal.fire('Error', 'Failed to add user.', 'error');
      });
  });

  function editUser(id) {
    $.getJSON(`${apiBase}/${id}`, function (user) {
      $('#editId').val(user.id);
      $('#editName').val(user.name);
      $('#editEmail').val(user.email);
      $('#editRole').val(user.role);
      $('#editUserModal').modal('show');
    }).fail(() => {
      Swal.fire('Error', 'Failed to fetch user details.', 'error');
    });
  }

  $('#editUserForm').submit(function (e) {
    e.preventDefault();
    const id = $('#editId').val();
    const formData = {
      name: $('#editName').val(),
      email: $('#editEmail').val(),
      role: $('#editRole').val(),
    };

    $.ajax({
      url: `${apiBase}/${id}`,
      method: 'PUT',
      data: formData,
      success: () => {
        $('#editUserModal').modal('hide');
        fetchUsers();
        Swal.fire('Updated!', 'User updated successfully.', 'success');
      },
      error: () => {
        Swal.fire('Error', 'Failed to update user.', 'error');
      },
    });
  });

  function deleteUser(id) {
    Swal.fire({
      title: 'Are you sure?',
      text: 'User will be permanently deleted.',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Delete',
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: `${apiBase}/${id}`,
          method: 'DELETE',
          success: () => {
            fetchUsers();
            Swal.fire('Deleted!', 'User has been deleted.', 'success');
          },
          error: () => {
            Swal.fire('Error', 'Failed to delete user.', 'error');
          },
        });
      }
    });
  }

  $(document).ready(() => {
    fetchUsers();
  });
</script>

</body>
</html>
