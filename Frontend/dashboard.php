<!-- dashboard.php -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>User Dashboard</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

  <script>
    function toggleDropdown() {
      const dropdown = document.getElementById("usersDropdown");
      dropdown.classList.toggle("hidden");
    }

    window.addEventListener("click", function(e) {
      const button = document.getElementById("dropdownButton");
      const dropdown = document.getElementById("usersDropdown");

      if (!button.contains(e.target) && !dropdown.contains(e.target)) {
        dropdown.classList.add("hidden");
      }
    });
  </script>
</head>
<body class="bg-gray-100">

<div class="flex h-screen">
  <!-- Sidebar -->
  <aside class="w-64 bg-white shadow-lg p-5">
    <h2 class="text-2xl font-bold text-pink-600 mb-8">My System</h2>
    <nav class="space-y-4 text-pink-700">
      <a href="#" class="flex items-center gap-2 hover:text-pink-900"><i class='bx bx-home'></i> Dashboard</a>
      <a href="#" class="flex items-center gap-2 hover:text-pink-900"><i class='bx bx-user'></i> My Profile</a>

      <!-- Users Dropdown -->
      <div class="relative">
        <button id="dropdownButton" onclick="toggleDropdown()" class="flex items-center justify-between w-full gap-2 hover:text-pink-900 focus:outline-none">
          <div class="flex items-center gap-2"><i class='bx bx-group'></i> Users</div>
          <i class='bx bx-chevron-down ml-auto'></i>
        </button>
        <div id="usersDropdown" class="hidden bg-white shadow-md absolute left-0 mt-2 w-48 rounded-md z-10 border border-gray-200">
          <a href="students.php" class="block px-4 py-2 text-sm hover:bg-pink-100 hover:text-pink-900">Students</a>
          <a href="employees.php" class="block px-4 py-2 text-sm hover:bg-pink-100 hover:text-pink-900">Employees</a>
          <a href="users.php" class="block px-4 py-2 text-sm hover:bg-pink-100 hover:text-pink-900">Users</a>
        </div>
      </div>

      <a href="#" class="flex items-center gap-2 hover:text-pink-900"><i class='bx bx-cog'></i> Settings</a>
      <button onclick="logout()" class="flex items-center gap-2 text-left hover:text-pink-900"><i class='bx bx-log-out'></i> Logout</button>
    </nav>
  </aside>

  <!-- Content -->
  <main class="flex-1 p-8">
    <h1 class="text-2xl font-semibold text-pink-700 mb-4">Welcome, <span id="userEmail">User</span>!</h1>
    <div class="bg-white p-6 rounded-lg shadow">
      <p>This is your dashboard. Add more features here as needed!</p>
    </div>
  </main>
</div>

<script>
  const token = localStorage.getItem("token");
  const email = localStorage.getItem("email");

  if (!token) {
    window.location.href = "login.php";
  }

  if (email) {
    document.getElementById("userEmail").textContent = email;
  }

  function logout() {
    localStorage.clear();
    window.location.href = "login.php";
  }
</script>

</body>
</html>
