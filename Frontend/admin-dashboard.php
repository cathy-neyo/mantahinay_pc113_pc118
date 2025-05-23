<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Dashboard</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="admin-style.css">
</head>
<body>

<?php include 'sidebar.php'; ?>

<div class="main-content">
  <!-- TOP NAVBAR -->
  <div class="top-navbar d-flex justify-content-between align-items-center p-3 bg-light border-bottom">
    <div><strong>DASHBOARD</strong></div>

    <div class="dropdown ms-auto">
      <button class="btn btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
        <span id="userName">Admin</span>
      </button>
      <ul class="dropdown-menu dropdown-menu-end">
        <li><a class="dropdown-item" href="#">Profile</a></li>
        <li><hr class="dropdown-divider"></li>
        <li><a class="dropdown-item text-danger" href="login.php" onclick="logout()">Logout</a></li>
      </ul>
    </div>
  </div>

  <!-- CONTENT -->
  <div class="content p-4">
    <h4>Admin Tasks</h4>
    <p>Welcome to the BSAS Admin Dashboard. Use the sidebar to manage the system.</p>

    <!-- Dashboard Cards -->
    <div class="row mt-4">
      <div class="col-md-4">
        <div class="card text-white bg-primary mb-3 shadow">
          <div class="card-body">
            <h5 class="card-title">Total Scholarship Staff</h5>
            <p class="card-text fs-3" id="totalScholarshipStaff">0</p>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card text-white bg-success mb-3 shadow">
          <div class="card-body">
            <h5 class="card-title">Scholarship Posts</h5>
            <p class="card-text fs-3" id="totalScholarships">0</p>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>

<!-- BOOTSTRAP & JS -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>

<script>
  const token = localStorage.getItem('auth_token');
  const user = JSON.parse(localStorage.getItem('user'));

  if (!token || !user || user.role != 0) {
    window.location.href = 'login.php';
  }

  document.getElementById('userName').innerText = user.name;

  function logout() {
    localStorage.clear();
    window.location.href = 'login.php';
  }

  // Fetch Total Users
  fetch('http://127.0.0.1:8000/api/total-users')
    .then(res => res.json())
    .then(data => {
      document.getElementById('totalScholarshipStaff').innerText = data.status ? data.total_users : 'Error';
    })
    .catch(() => {
      document.getElementById('totalScholarshipStaff').innerText = 'Error';
    });

  // Fetch Total Scholarships
  fetch('http://127.0.0.1:8000/api/total-scholarships')
    .then(res => res.json())
    .then(data => {
      document.getElementById('totalScholarships').innerText = data.status ? data.total_scholarships : 'Error';
    })
    .catch(() => {
      document.getElementById('totalScholarships').innerText = 'Error';
    });
</script>

</body>
</html>
