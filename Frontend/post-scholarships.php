<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Post Scholarships</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f4f4f4;
    }
    .sidebar {
      height: 100vh;
      width: 250px;
      background: linear-gradient(45deg, rgb(140, 0, 255), rgb(66, 29, 168));
      position: fixed;
      top: 0;
      left: 0;
      padding: 20px 0;
      color: white;
    }
    .sidebar h4 {
      text-align: center;
      margin-bottom: 30px;
      font-weight: bold;
    }
    .sidebar a {
      display: block;
      padding: 12px 25px;
      color: white;
      text-decoration: none;
      transition: 0.3s;
    }
    .sidebar a:hover {
      background: rgba(255, 255, 255, 0.2);
    }
    .content {
      margin-left: 250px;
      padding: 20px;
    }
    .navbar {
      background-color: #fff;
      box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    .profile {
      margin-left: auto;
      padding-right: 20px;
      display: flex;
      align-items: center;
    }
    .profile span {
      margin-right: 10px;
      font-weight: bold;
    }
    .profile button {
      border: none;
      background: none;
      color: red;
      cursor: pointer;
    }
    .img-preview {
      max-width: 100%;
      height: auto;
      border-radius: 8px;
      max-height: 300px; /* Limit height */
      object-fit: contain; /* Keeps aspect ratio */
      display: block;
      margin: 10px auto;
    }
  </style>
</head>
<body>

<?php include 'sidebar.php'; ?>

<div class="content">
  <nav class="navbar navbar-expand navbar-light bg-white rounded mb-3">
    <div class="container-fluid">
      <span class="navbar-brand">Scholarship Posting</span>
      <!-- <div class="profile">
        <span id="coordinatorName">Coordinator</span>
        <button onclick="logout()" title="Logout"><i class="fas fa-sign-out-alt"></i></button>
      </div>
    </div> -->
  </nav>

  <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#addModal">
    <i class="fas fa-plus"></i> Add Scholarship
  </button>

  <table class="table table-bordered table-hover bg-white shadow">
    <thead class="table-primary">
      <tr>
        <th>Title</th>
        <th>Amount</th>
        <th>Start</th>
        <th>End</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody id="scholarshipTable"></tbody>
  </table>
</div>

<!-- ADD MODAL -->
<div class="modal fade" id="addModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <form id="addForm" class="modal-content p-3" enctype="multipart/form-data">
      <div class="modal-header">
        <h5 class="modal-title">Add Scholarship</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body row g-3">
        <div class="col-md-6">
          <label class="form-label">Title</label>
          <input type="text" name="title" class="form-control" required>
        </div>
        <div class="col-md-6">
          <label class="form-label">Amount</label>
          <input type="number" name="amount" class="form-control" required>
        </div>
        <div class="col-12">
          <label class="form-label">Description</label>
          <textarea name="description" class="form-control" rows="2" required></textarea>
        </div>
        <div class="col-12">
          <label class="form-label">Requirements</label>
          <textarea name="requirements" class="form-control" rows="2" required></textarea>
        </div>
        <div class="col-md-6">
          <label class="form-label">Start Date</label>
          <input type="date" name="start_date" class="form-control" required>
        </div>
        <div class="col-md-6">
          <label class="form-label">End Date</label>
          <input type="date" name="end_date" class="form-control" required>
        </div>
        <div class="col-12">
          <label class="form-label">Scholarship Image</label>
          <input type="file" name="image" class="form-control" accept="image/*" required>
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-primary" type="submit">Save</button>
      </div>
    </form>
  </div>
</div>

<!-- VIEW MODAL -->
<div class="modal fade" id="viewModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content p-3">
      <div class="modal-header">
        <h5 class="modal-title">Scholarship Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <p><strong>Description:</strong></p>
        <p id="viewDescription"></p>
        <p><strong>Requirements:</strong></p>
        <p id="viewRequirements"></p>
        <p><strong>Image:</strong></p>
        <img id="viewImage" class="img-preview" src="">
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
$(document).ready(function () {
  fetchScholarships();

  function fetchScholarships() {
    $.get('http://localhost:8000/api/scholarships', function (data) {
      $('#scholarshipTable').empty();
      $.each(data, function (i, s) {
        $('#scholarshipTable').append(`
          <tr>
            <td>${s.title}</td>
            <td>${s.amount}</td>
            <td>${s.start_date}</td>
            <td>${s.end_date}</td>
            <td>
              <button class="btn btn-info btn-sm viewBtn" data-id="${s.id}"><i class="fas fa-eye"></i></button>
              <button class="btn btn-danger btn-sm deleteBtn" data-id="${s.id}"><i class="fas fa-trash-alt"></i></button>
            </td>
          </tr>
        `);
      });
    });
  }

  $('#addForm').on('submit', function (e) {
    e.preventDefault();
    const form = new FormData(this);
    form.append('posted_by', 'Coordinator');
    $.ajax({
      url: 'http://localhost:8000/api/scholarships',
      type: 'POST',
      data: form,
      contentType: false,
      processData: false,
      success: function () {
        $('#addModal').modal('hide');
        $('#addForm')[0].reset();
        fetchScholarships();
        Swal.fire('Success', 'Scholarship added successfully!', 'success');
      }
    });
  });

  $(document).on('click', '.viewBtn', function () {
    const id = $(this).data('id');
    $.get(`http://localhost:8000/api/scholarships/${id}`, function (s) {
      $('#viewDescription').text(s.description);
      $('#viewRequirements').text(s.requirements);
      $('#viewImage').attr('src', s.image);
      $('#viewModal').modal('show');
    });
  });

  $(document).on('click', '.deleteBtn', function () {
    const id = $(this).data('id');
    Swal.fire({
      title: 'Are you sure?',
      text: "This will delete the scholarship!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#e3342f',
      cancelButtonColor: '#6c757d',
      confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: `http://localhost:8000/api/scholarships/${id}`,
          type: 'DELETE',
          success: function () {
            fetchScholarships();
            Swal.fire('Deleted!', 'Scholarship has been removed.', 'success');
          }
        });
      }
    });
  });

  const user = JSON.parse(localStorage.getItem('user'));
  if (user) {
    $('#coordinatorName').text(user.name);
  }

  window.logout = function () {
    localStorage.clear();
    window.location.href = 'login.php';
  }
});
</script>

</body>
</html>
