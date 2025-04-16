<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Students</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            display: flex;
            margin: 0;
            padding: 0;
        }
        .sidebar {
            width: 230px;
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
            margin-left: 250px; /* Adjusted margin to avoid overlap */
            padding: 30px;
            width: calc(100% - 250px); /* Adjust content width accordingly */
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
    <h2 class="mb-4">Students</h2>
    <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#addStudentModal">Add Student</button>

    <table id="studentsTable" class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Firstname</th>
                <th>Lastname</th>
                <th>Age</th>
                <th>Gender</th>
                <th>Address</th>
                <th>Email</th>
                <th>Contact #</th>
                <th>Course</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>

<!-- ADD Modal -->
<div class="modal fade" id="addStudentModal" tabindex="-1">
    <div class="modal-dialog">
        <form id="addStudentForm" class="modal-content">
            <div class="modal-header"><h5 class="modal-title">Add Student</h5></div>
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
                <input type="text" id="addContact" class="form-control mb-2" placeholder="Contact Number" required>
                <select id="addCourse" class="form-control mb-2" required>
                    <option value="" disabled selected>Select Course</option>
                    <option>BSIT</option>
                    <option>BEED</option>
                    <option>BSMATH</option>
                    <option>BSED</option>
                </select>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Add</button>
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
    function fetchStudents() {
        $.ajax({
            url: 'http://127.0.0.1:8000/api/students',
            method: 'GET',
            headers: { 'Authorization': 'Bearer ' + localStorage.getItem('token') },
            success: function (data) {
                let rows = '';
                data.forEach(s => {
                    rows += `
                        <tr>
                            <td>${s.id}</td>
                            <td>${s.firstname}</td>
                            <td>${s.lastname}</td>
                            <td>${s.age}</td>
                            <td>${s.gender}</td>
                            <td>${s.address}</td>
                            <td>${s.email}</td>
                            <td>${s.contact_number}</td>
                            <td>${s.course}</td>
                            <td>
                                <button class="btn btn-sm btn-warning" onclick="editModal(${s.id}, '${s.firstname}', '${s.lastname}', ${s.age}, '${s.gender}', '${s.address}', '${s.email}', '${s.contact_number}', '${s.course}')">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-sm btn-danger" onclick="deleteStudent(${s.id})">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </td>
                        </tr>`;
                });
                $('#studentsTable').DataTable().destroy();
                $('#studentsTable tbody').html(rows);
                $('#studentsTable').DataTable();
            }
        });
    }

    $('#addStudentForm').submit(function (e) {
        e.preventDefault();
        const data = {
            firstname: $('#addFirstname').val(),
            lastname: $('#addLastname').val(),
            age: $('#addAge').val(),
            gender: $('#addGender').val(),
            address: $('#addAddress').val(),
            email: $('#addEmail').val(),
            contact_number: $('#addContact').val(),
            course: $('#addCourse').val(),
        };
        $.ajax({
            url: 'http://127.0.0.1:8000/api/students',
            method: 'POST',
            headers: { 'Authorization': 'Bearer ' + localStorage.getItem('token') },
            contentType: 'application/json',
            data: JSON.stringify(data),
            success: function () {
                $('#addStudentModal').modal('hide');
                Swal.fire('Success!', 'Student added.', 'success');
                fetchStudents();
            }
        });
    });

    function editModal(id, firstname, lastname, age, gender, address, email, contact, course) {
        $('#editId').val(id);
        $('#editFirstname').val(firstname);
        $('#editLastname').val(lastname);
        $('#editAge').val(age);
        $('#editGender').val(gender);
        $('#editAddress').val(address);
        $('#editEmail').val(email);
        $('#editContact').val(contact);
        $('#editCourse').val(course);
        $('#editStudentModal').modal('show');
    }

    $('#editStudentForm').submit(function (e) {
        e.preventDefault();
        const id = $('#editId').val();
        const data = {
            firstname: $('#editFirstname').val(),
            lastname: $('#editLastname').val(),
            age: $('#editAge').val(),
            gender: $('#editGender').val(),
            address: $('#editAddress').val(),
            email: $('#editEmail').val(),
            contact_number: $('#editContact').val(),
            course: $('#editCourse').val(),
        };
        $.ajax({
            url: `http://127.0.0.1:8000/api/students/${id}`,
            method: 'PUT',
            headers: { 'Authorization': 'Bearer ' + localStorage.getItem('token') },
            contentType: 'application/json',
            data: JSON.stringify(data),
            success: function () {
                $('#editStudentModal').modal('hide');
                Swal.fire('Updated!', 'Student updated.', 'success');
                fetchStudents();
            }
        });
    });

    function deleteStudent(id) {
        Swal.fire({
            title: 'Confirm Delete',
            text: 'Are you sure you want to delete this student?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it'
        }).then(result => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `http://127.0.0.1:8000/api/students/${id}`,
                    method: 'DELETE',
                    headers: { 'Authorization': 'Bearer ' + localStorage.getItem('token') },
                    success: function () {
                        Swal.fire('Deleted!', 'Student has been removed.', 'success');
                        fetchStudents();
                    }
                });
            }
        });
    }

    $(document).ready(fetchStudents);
</script>

</body>
</html>
