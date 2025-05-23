<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Users</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    body { display: flex; font-family: 'Poppins', sans-serif; }
    .sidebar {
      width: 220px;
      background: linear-gradient(135deg, #ff758c, #ff7eb3);
      height: 100vh;
      padding: 20px;
      color: white;
      position: fixed;
    }
    .sidebar h4 { text-align: center; margin-bottom: 30px; }
    .sidebar a {
      color: white;
      display: block;
      margin: 10px 0;
      text-decoration: none;
    }
    .content { margin-left: 240px; padding: 30px; width: 100%; }
  </style>
</head>
<body>

<!-- SIDEBAR -->
<div class="sidebar">
  <h4>Dashboard</h4>
  <a href="dashboard.php"><i class="fas fa-home"></i> Home</a>
  <a href="students.php"><i class="fas fa-user-graduate"></i> Students</a>
  <a href="employees.php"><i class="fas fa-user-tie"></i> Employees</a>
  <a href="users.php"><i class="fas fa-users"></i> Users</a>
</div>

<!-- MAIN CONTENT -->
<div class="content">
  <h2 class="mb-4">Users</h2>
  <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#addUserModal">Add User</button>

  <table id="usersTable" class="table table-bordered">
    <thead>
      <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Role</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody></tbody>
  </table>
</div>

<!-- ADD Modal -->
<div class="modal fade" id="addUserModal" tabindex="-1">
  <div class="modal-dialog">
    <form id="addUserForm" class="modal-content">
      <div class="modal-header"><h5 class="modal-title">Add User</h5></div>
      <div class="modal-body">
        <input type="text" id="addName" class="form-control mb-2" placeholder="Name" required>
        <input type="email" id="addEmail" class="form-control mb-2" placeholder="Email" required>
        <input type="password" id="addPassword" class="form-control mb-2" placeholder="Password" required>
        <select id="addRole" class="form-control mb-2" required>
          <option value="" disabled selected>Select Role</option>
          <option value="0">Admin</option>
          <option value="1">User</option>
        </select>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Add</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
      </div>
    </form>
  </div>
</div>

<!-- EDIT Modal -->
<div class="modal fade" id="editUserModal" tabindex="-1">
  <div class="modal-dialog">
    <form id="editUserForm" class="modal-content">
      <div class="modal-header"><h5 class="modal-title">Edit User</h5></div>
      <div class="modal-body">
        <input type="hidden" id="editId">
        <input type="text" id="editName" class="form-control mb-2" placeholder="Name" required>
        <input type="email" id="editEmail" class="form-control mb-2" placeholder="Email" required>
        <select id="editRole" class="form-control mb-2" required>
          <option value="0">Admin</option>
          <option value="1">User</option>
        </select>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-warning">Update</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
      </div>
    </form>
  </div>
</div>

<!-- JS + Plugins -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap4.min.js"></script>

<script>
$(document).ready(function () {
  const token = localStorage.getItem("token");
  if (!token) {
    Swal.fire("Unauthorized!", "Please login first", "error").then(() => window.location.href = "index.php");
    return;
  }

  const table = $('#usersTable').DataTable();

  function loadUsers() {
    $.ajax({
      url: "http://127.0.0.1:8000/api/users",
      headers: { "Authorization": "Bearer " + token },
      success: function (data) {
        table.clear().draw();
        data.forEach(user => {
          table.row.add([
            user.id,
            user.name,
            user.email,
            user.role == 0 ? 'Admin' : 'User',
            `<button class="btn btn-sm btn-warning editBtn" data-id="${user.id}" data-name="${user.name}" data-email="${user.email}" data-role="${user.role}">
              <i class="fas fa-edit"></i>
            </button>
            <button class="btn btn-sm btn-danger deleteBtn" data-id="${user.id}">
              <i class="fas fa-trash-alt"></i>
            </button>`
          ]).draw();
        });
      }
    });
  }

  loadUsers();

  $('#addUserForm').submit(function (e) {
    e.preventDefault();
    const user = {
      name: $('#addName').val(),
      email: $('#addEmail').val(),
      password: $('#addPassword').val(),
      role: $('#addRole').val()
    };
    $.ajax({
      url: "http://127.0.0.1:8000/api/users",
      method: "POST",
      headers: {
        "Authorization": "Bearer " + token,
        "Content-Type": "application/json"
      },
      data: JSON.stringify(user),
      success: function () {
        $('#addUserModal').modal('hide');
        $('#addUserForm')[0].reset();
        Swal.fire("Success!", "User added.", "success");
        loadUsers();
      }
    });
  });

  $(document).on("click", ".editBtn", function () {
    $('#editId').val($(this).data("id"));
    $('#editName').val($(this).data("name"));
    $('#editEmail').val($(this).data("email"));
    $('#editRole').val($(this).data("role"));
    $('#editUserModal').modal("show");
  });

  $('#editUserForm').submit(function (e) {
    e.preventDefault();
    const id = $('#editId').val();
    const user = {
      name: $('#editName').val(),
      email: $('#editEmail').val(),
      role: $('#editRole').val()
    };
    $.ajax({
      url: `http://127.0.0.1:8000/api/users/${id}`,
      method: "PUT",
      headers: {
        "Authorization": "Bearer " + token,
        "Content-Type": "application/json"
      },
      data: JSON.stringify(user),
      success: function () {
        $('#editUserModal').modal('hide');
        Swal.fire("Updated!", "User updated successfully.", "success");
        loadUsers();
      }
    });
  });

  $(document).on("click", ".deleteBtn", function () {
    const id = $(this).data("id");
    Swal.fire({
      title: 'Are you sure?',
      text: "This action cannot be undone.",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: `http://127.0.0.1:8000/api/users/${id}`,
          method: "DELETE",
          headers: { "Authorization": "Bearer " + token },
          success: function () {
            Swal.fire("Deleted!", "User has been deleted.", "success");
            loadUsers();
          }
        });
      }
    });
  });
});
</script>
</body>
</html>
