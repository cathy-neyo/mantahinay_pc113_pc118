<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Evaluate Applications</title>

  <!-- Bootstrap & Icons -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"/>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"/>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <link rel="stylesheet" href="admin-style.css">
</head>
<body>

<?php include 'sidebar.php'; ?>

<div class="main-content" style="margin-left: 250px; padding: 20px;">
 <div class="container mt-5">
  <h3 class="mb-4"> Pending Scholarship Applications</h3>

  <div id="loading" class="text-center mb-3" style="display:none;">
    <div class="spinner-border text-primary" role="status"><span class="sr-only">Loading...</span></div>
  </div>

  <div class="table-responsive">
    <table class="table table-bordered table-hover" id="applications-table">
      <thead class="thead-dark">
        <tr>
          <th>Name</th>
          <th>Scholarship</th>
          <th>Date Applied</th>
          <th>Status</th>
          <th>Phone</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr><td colspan="6" class="text-center">Loading applications...</td></tr>
      </tbody>
    </table>
  </div>
</div>
</div>

<script>
  $(document).ready(function () {
    fetchApplications();

    function fetchApplications() {
      $("#loading").show();
      $.get('http://localhost:8000/api/applications/pending', function (data) {
        let rows = '';
        if (data.length === 0) {
          rows = `<tr><td colspan="6" class="text-center text-muted">No pending applications.</td></tr>`;
        } else {
          data.forEach(app => {
            rows += `
              <tr>
                <td>${app.name}</td>
                <td>${app.scholarship_title}</td>
                <td>${app.date_applied}</td>
                <td><span class="badge badge-warning text-uppercase">${app.status}</span></td>
                <td>${app.phone_number}</td>
                <td>
                  <button class="btn btn-sm btn-success approve-btn" data-id="${app.id}"><i class="fas fa-check"></i> Approve</button>
                  <button class="btn btn-sm btn-danger reject-btn" data-id="${app.id}"><i class="fas fa-times"></i> Reject</button>
                </td>
              </tr>
            `;
          });
        }
        $('#applications-table tbody').html(rows);
        $("#loading").hide();
      }).fail(function () {
        $('#applications-table tbody').html(`<tr><td colspan="6" class="text-center text-danger">Failed to load data.</td></tr>`);
        $("#loading").hide();
      });
    }

    // ✅ APPROVE with confirmation
    $(document).on('click', '.approve-btn', function () {
      const id = $(this).data('id');
      Swal.fire({
        title: 'Are you sure?',
        text: "You are about to approve this application.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#28a745',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, approve it!'
      }).then((result) => {
        if (result.isConfirmed) {
          $.post(`http://localhost:8000/api/applications/${id}/approve`, function () {
            Swal.fire('Approved!', 'Application approved successfully.', 'success');
            fetchApplications();
          }).fail(function () {
            Swal.fire('Error!', 'Failed to approve application.', 'error');
          });
        }
      });
    });

    // ❌ REJECT with confirmation
    $(document).on('click', '.reject-btn', function () {
      const id = $(this).data('id');
      Swal.fire({
        title: 'Are you sure?',
        text: "This will reject the application.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Yes, reject it!'
      }).then((result) => {
        if (result.isConfirmed) {
          $.post(`http://localhost:8000/api/applications/${id}/reject`, function () {
            Swal.fire('Rejected!', 'Application has been rejected.', 'success');
            fetchApplications();
          }).fail(function () {
            Swal.fire('Error!', 'Failed to reject application.', 'error');
          });
        }
      });
    });

  });
</script>



</body>
</html>
