<!-- sidebar.php -->
<style>
  /* Sidebar base styles */
  .sidebar {
    width: 250px;
    height: 100vh;
    position: fixed;
    background: linear-gradient(to bottom, #6a11cb, #2575fc);
    color: white;
    padding-top: 20px;
    font-size: 16px;
    transition: transform 0.3s ease;
    z-index: 1040; /* above main content */
  }

  .sidebar a {
    display: block;
    padding: 12px 20px;
    color: white;
    text-decoration: none;
  }

  .sidebar a:hover {
    background-color: rgba(255, 255, 255, 0.2);
  }

  /* Main content positioning */
  .main-content {
    margin-left: 250px;
    padding: 20px;
    min-height: 100vh;
    background-color: #f9f9f9;
    transition: margin-left 0.3s ease;
  }

  /* Hamburger button - only visible on small screens */
  .sidebar-toggle-btn {
    display: none;
    position: fixed;
    top: 15px;
    left: 15px;
    background: #2575fc;
    border: none;
    color: white;
    padding: 8px 12px;
    font-size: 20px;
    border-radius: 5px;
    z-index: 1100;
    cursor: pointer;
  }

  /* Responsive adjustments */
  @media (max-width: 768px) {
    .sidebar {
      transform: translateX(-260px); /* hide sidebar by default */
      position: fixed;
      top: 0;
      left: 0;
      height: 100%;
      width: 250px;
      box-shadow: 2px 0 5px rgba(0,0,0,0.3);
    }

    .sidebar.show {
      transform: translateX(0);
    }

    .main-content {
      margin-left: 0;
      padding: 20px;
    }

    .sidebar-toggle-btn {
      display: block;
    }
  }
</style>

<!-- Hamburger toggle button -->
<button class="sidebar-toggle-btn" id="sidebarToggle"><i class="fa fa-bars"></i></button>

<div class="sidebar" id="sidebar">
  <div class="text-center mb-4">
    <h4 id="sidebarRole">Dashboard</h4>
    <p id="sidebarName">User</p>
  </div>

  <div id="adminLinks" style="display: none;">
    <a href="admin-dashboard.php"><i class="fa fa-home me-2"></i> Dashboard</a>
    <a href="manage-users.php"><i class="fa fa-users me-2"></i> Manage Users</a>
    <a href="post-scholarships.php"><i class="fa fa-plus me-2"></i> Post Scholarships</a>
    <a href="evaluate-applications.php"><i class="fa fa-check-circle me-2"></i> Evaluate Applications</a>
    <a href="view-applications.php"><i class="fa fa-list me-2"></i> View Applications</a>
    <a href="view-reports.php"><i class="fa fa-chart-line me-2"></i> View Reports</a>
    <a href="settings.php"><i class="fa fa-cog me-2"></i> Settings</a>
  </div>

  <div id="coordinatorLinks" style="display: none;">
    <a href="coordinator-dashboard.php"><i class="fa fa-home me-2"></i> Dashboard</a>
    <a href="post-scholarships.php"><i class="fa fa-plus me-2"></i> Post Scholarships</a>
    <a href="view-applications.php"><i class="fa fa-list me-2"></i> View Applications</a>
    <a href="evaluate-applications.php"><i class="fa fa-check-circle me-2"></i> Evaluate Applications</a>
  </div>
</div>

<script>
  // User info and role-based link display
  if (typeof window.user === 'undefined') {
    window.user = JSON.parse(localStorage.getItem('user'));
  }

  if (window.user) {
    document.getElementById('sidebarName').innerText = window.user.name;

    if (window.user.role == 0) {
      document.getElementById('sidebarRole').innerText = "Admin";
      document.getElementById('adminLinks').style.display = "block";
    } else if (window.user.role == 1) {
      document.getElementById('sidebarRole').innerText = "Coordinator";
      document.getElementById('coordinatorLinks').style.display = "block";
    }
  }

  // Sidebar toggle button for mobile
  const sidebarToggleBtn = document.getElementById('sidebarToggle');
  const sidebar = document.getElementById('sidebar');

  sidebarToggleBtn.addEventListener('click', () => {
    sidebar.classList.toggle('show');
  });

  // Optional: close sidebar when clicking outside on small screens
  document.addEventListener('click', function(event) {
    if (window.innerWidth <= 768) {
      if (!sidebar.contains(event.target) && !sidebarToggleBtn.contains(event.target)) {
        sidebar.classList.remove('show');
      }
    }
  });
</script>
