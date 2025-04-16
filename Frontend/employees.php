<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Employees</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    body {
      display: flex;
    }
    .sidebar {
      width: 220px;
      background: linear-gradient(135deg, #ff758c, #ff7eb3);
      height: 100vh;
      padding: 20px;
      color: white;
      position: fixed;
    }
    .sidebar h4 {
      text-align: center;
      margin-bottom: 30px;
    }
    .sidebar a {
      color: white;
      display: block;
      margin: 10px 0;
      text-decoration: none;
    }
    .content {
      margin-left: 240px;
      padding: 30px;
      width: 100%;
    }
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
  <h2 class="mb-4">Employees</h2>
  <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#addEmployeeModal">Add Employee</button>

  <table id="employeesTable" class="table table-bordered">
    <thead>
      <tr>
        <th>ID</th>
        <th>Firstname</th>
        <th>Lastname</th>
        <th>Age</th>
        <th>Gender</th>
        <th>Address</th>
        <th>Email</th>
        <th>Phone</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody></tbody>
  </table>
</div>

<!-- ADD Modal -->
<div class="modal fade" id="addEmployeeModal" tabindex="-1">
  <div class="modal-dialog">
    <form id="addEmployeeForm" class="modal-content">
      <div class="modal-header"><h5 class="modal-title">Add Employee</h5></div>
      <div class="modal-body">
        <input type="text" id="addFirstname" class="form-control mb-2" placeholder="First Name" required>
        <input type="text" id="addLastname" class="form-control mb-2" placeholder="Last Name" required>
        <input type="number" id="addAge" class="form-control mb-2" placeholder="Age" required>
        <select id="addGender" class="form-control mb-2" required>
          <option value="" disabled selected>Select Gender</option>
          <option>Male</option>
          <option>Female</option>
        </select>
        <input type="text" id="addAddress" class="form-control mb-2" placeholder="Address" required>
        <input type="email" id="addEmail" class="form-control mb-2" placeholder="Email" required>
        <input type="text" id="addPhone" class="form-control mb-2" placeholder="Phone" required>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Add</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
      </div>
    </form>
  </div>
</div>

<!-- EDIT Modal -->
<div class="modal fade" id="editEmployeeModal" tabindex="-1">
  <div class="modal-dialog">
    <form id="editEmployeeForm" class="modal-content">
      <div class="modal-header"><h5 class="modal-title">Edit Employee</h5></div>
      <div class="modal-body">
        <input type="hidden" id="editId">
        <input type="text" id="editFirstname" class="form-control mb-2" placeholder="First Name" required>
        <input type="text" id="editLastname" class="form-control mb-2" placeholder="Last Name" required>
        <input type="number" id="editAge" class="form-control mb-2" placeholder="Age" required>
        <select id="editGender" class="form-control mb-2" required>
          <option value="" disabled>Select Gender</option>
          <option>Male</option>
          <option>Female</option>
        </select>
        <input type="text" id="editAddress" class="form-control mb-2" placeholder="Address" required>
        <input type="email" id="editEmail" class="form-control mb-2" placeholder="Email" required>
        <input type="text" id="editPhone" class="form-control mb-2" placeholder="Phone" required>
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
function fetchEmployees() {
  $.ajax({
    url: 'http://127.0.0.1:8000/api/employees',
    method: 'GET',
    headers: { 'Authorization': 'Bearer ' + localStorage.getItem('token') },
    success: function(data) {
      let rows = '';
      data.forEach(e => {
        rows += `
          <tr>
            <td>${e.id}</td>
            <td>${e.firstname}</td>
            <td>${e.lastname}</td>
            <td>${e.age}</td>
            <td>${e.gender}</td>
            <td>${e.address}</td>
            <td>${e.email}</td>
            <td>${e.phone}</td>
            <td>
              <button class="btn btn-sm btn-warning" onclick="editModal(${e.id}, '${e.firstname}', '${e.lastname}', ${e.age}, '${e.gender}', '${e.address}', '${e.email}', '${e.phone}')">
                <i class="fas fa-edit"></i>
              </button>
              <button class="btn btn-sm btn-danger" onclick="deleteEmployee(${e.id})">
                <i class="fas fa-trash-alt"></i>
              </button>
            </td>
          </tr>`;
      });
      $('#employeesTable').DataTable().destroy();
      $('#employeesTable tbody').html(rows);
      $('#employeesTable').DataTable();
    }
  });
}

$('#addEmployeeForm').submit(function(e) {
  e.preventDefault();
  const data = {
    firstname: $('#addFirstname').val(),
    lastname: $('#addLastname').val(),
    age: $('#addAge').val(),
    gender: $('#addGender').val(),
    address: $('#addAddress').val(),
    email: $('#addEmail').val(),
    phone: $('#addPhone').val(),
  };
  $.ajax({
    url: 'http://127.0.0.1:8000/api/employees',
    method: 'POST',
    headers: { 'Authorization': 'Bearer ' + localStorage.getItem('token') },
    contentType: 'application/json',
    data: JSON.stringify(data),
    success: function() {
      $('#addEmployeeModal').modal('hide');
      Swal.fire('Success!', 'Employee added.', 'success');
      fetchEmployees();
    }
  });
});

function editModal(id, firstname, lastname, age, gender, address, email, phone) {
  $('#editId').val(id);
  $('#editFirstname').val(firstname);
  $('#editLastname').val(lastname);
  $('#editAge').val(age);
  $('#editGender').val(gender);
  $('#editAddress').val(address);
  $('#editEmail').val(email);
  $('#editPhone').val(phone);
  $('#editEmployeeModal').modal('show');
}

$('#editEmployeeForm').submit(function(e) {
  e.preventDefault();
  const id = $('#editId').val();
  const data = {
    firstname: $('#editFirstname').val(),
    lastname: $('#editLastname').val(),
    age: $('#editAge').val(),
    gender: $('#editGender').val(),
    address: $('#editAddress').val(),
    email: $('#editEmail').val(),
    phone: $('#editPhone').val(),
  };
  $.ajax({
    url: `http://127.0.0.1:8000/api/employees/${id}`,
    method: 'PUT',
    headers: { 'Authorization': 'Bearer ' + localStorage.getItem('token') },
    contentType: 'application/json',
    data: JSON.stringify(data),
    success: function() {
      $('#editEmployeeModal').modal('hide');
      Swal.fire('Updated!', 'Employee updated.', 'success');
      fetchEmployees();
    }
  });
});

function deleteEmployee(id) {
  Swal.fire({
    title: 'Confirm Delete',
    text: 'Are you sure you want to delete this employee?',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Yes, delete it'
  }).then(result => {
    if (result.isConfirmed) {
      $.ajax({
        url: `http://127.0.0.1:8000/api/employees/${id}`,
        method: 'DELETE',
        headers: { 'Authorization': 'Bearer ' + localStorage.getItem('token') },
        success: function() {
          Swal.fire('Deleted!', 'Employee has been removed.', 'success');
          fetchEmployees();
        }
      });
    }
  });
}

$(document).ready(fetchEmployees);
</script>

</body>
</html>
