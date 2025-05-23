<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Coordinator Dashboard</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="admin-style.css">
</head>
<body>

<?php include 'sidebar.php'; ?>

<div class="main-content">
  <div class="top-navbar d-flex justify-content-between align-items-center p-3 bg-light border-bottom">
    <div><strong>COORDINATOR DASHBOARD</strong></div>
    <div class="dropdown">
      <button class="btn btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
        <span id="userName">Coordinator</span>
      </button>
      <ul class="dropdown-menu dropdown-menu-end">
        <li><a class="dropdown-item" href="#">Profile</a></li>
        <li><hr class="dropdown-divider"></li>
        <li><a class="dropdown-item text-danger" href="login.php" onclick="logout()">Logout</a></li>
      </ul>
    </div>
  </div>

  <div class="content p-4">
    <h4>Coordinator Tasks</h4>
    <p>Welcome to the BSAS Coordinator Dashboard. Use the sidebar to manage scholarship activities.</p>

    <!-- Dashboard Cards -->
    <div class="row mt-4">
      <div class="col-md-4">
        <div class="card text-white bg-primary mb-3 shadow">
          <div class="card-body">
            <h5 class="card-title">Scholarship Posts</h5>
            <p class="card-text fs-3" id="totalScholarships">0</p>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card text-white bg-success mb-3 shadow">
          <div class="card-body">
            <h5 class="card-title">Pending Applications</h5>
            <p class="card-text fs-3" id="pendingApplications">0</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
  const token = localStorage.getItem('auth_token');
  const user = JSON.parse(localStorage.getItem('user'));

  if (!token || !user || user.role != 1) {
    window.location.href = 'login.php';
  }

  document.getElementById('userName').innerText = user.name;

  function logout() {
    localStorage.clear();
    window.location.href = 'login.php';
  }

  // Fetch total scholarship posts
  fetch('http://127.0.0.1:8000/api/total-scholarships')
    .then(response => response.json())
    .then(data => {
      if (data.status) {
        document.getElementById('totalScholarships').innerText = data.total_scholarships;
      }
    });

  // Fetch pending applications
  fetch('http://127.0.0.1:8000/api/pending-applications')
    .then(response => response.json())
    .then(data => {
      if (data.status) {
        document.getElementById('pendingApplications').innerText = data.total_pending;
      }
    });
</script>

</body>
</html>
