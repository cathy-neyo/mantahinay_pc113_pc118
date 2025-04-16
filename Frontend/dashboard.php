<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Dashboard</title>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <link rel="stylesheet" href="//cdn.datatables.net/2.2.2/css/dataTables.dataTables.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>

    <style>
        body {
            display: flex;
            height: 100vh;
            background-color: #ffe4ec;
            font-family: 'Poppins', sans-serif;
        }

        .sidebar {
            width: 250px;
            height: 100vh;
            background: linear-gradient(135deg, #ff9a9e, #fad0c4);
            color: white;
            padding-top: 1rem;
            position: fixed;
            transition: all 0.3s;
            box-shadow: 5px 0px 15px rgba(0, 0, 0, 0.2);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .sidebar .logo {
            text-align: center;
            font-size: 1.5rem;
            font-weight: bold;
            padding-bottom: 1rem;
        }

        .sidebar a {
            color: white;
            padding: 12px 20px;
            display: flex;
            align-items: center;
            text-decoration: none;
            font-size: 1.1rem;
            transition: 0.3s;
        }

        .sidebar a i {
            margin-right: 10px;
        }

        .sidebar a:hover {
            background-color: rgba(255, 255, 255, 0.2);
            border-radius: 5px;
        }

        .menu {
            flex-grow: 1;
        }

        .logout-btn {
            padding: 15px;
        }

        .content {
            margin-left: 250px;
            padding: 20px;
            flex-grow: 1;
            width: 100%;
            transition: all 0.3s;
        }

        .sidebar-toggle {
            display: none;
            position: absolute;
            top: 15px;
            left: 15px;
            background-color: #ff9a9e;
            color: white;
            border: none;
            font-size: 1.5rem;
            padding: 5px 10px;
            cursor: pointer;
            z-index: 10;
        }

        .dropdown-menu {
            background-color: rgba(255, 255, 255, 0.2);
            border: none;
        }

        .dropdown-menu a {
            color: white;
            padding: 10px;
            display: block;
        }

        .dropdown-menu a:hover {
            background-color: rgba(255, 255, 255, 0.3);
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 200px;
                transform: translateX(-100%);
            }

            .sidebar.open {
                transform: translateX(0);
            }

            .content {
                margin-left: 0;
            }

            .sidebar-toggle {
                display: block;
            }
        }
    </style>
</head>
<body>

    <button class="sidebar-toggle" onclick="toggleSidebar()">☰</button>
    <div class="sidebar" id="sidebar">
        <div class="menu">
            <div class="logo">Dashboard</div>
            <a href="dashboard.php"><i class="fas fa-home"></i> Home</a>
            
            <!-- Dropdown Menu for Users -->
            <div class="dropdown">
                <a href="#" class="dropdown-toggle" id="userDropdown" onclick="toggleDropdown()">
                    <i class="fas fa-users"></i> User List <i class="fas fa-chevron-down"></i>
                </a>
                <div class="dropdown-menu" id="dropdownMenu">
                    <a href="users.php"><i class="fas fa-user"></i> Users</a>
                    <a href="employees.php"><i class="fas fa-briefcase"></i> Employees</a>
                    <a href="students.php"><i class="fas fa-graduation-cap"></i> Students</a>
                </div>
            </div>
        </div>

        <!-- Logout Button at the Bottom -->
        <div class="logout-btn">
            <button onclick="logout()" class="btn btn-light w-100 text-danger">
                <i class="fas fa-sign-out-alt"></i> Logout
            </button>
        </div>
    </div>

    <div class="content">
        <h2 class="text-center text-pink">Welcome to Your Dashboard</h2>
    </div>

    <script>
        function toggleSidebar() {
            document.getElementById("sidebar").classList.toggle("open");
        }

        function toggleDropdown() {
            let dropdownMenu = document.getElementById("dropdownMenu");
            dropdownMenu.style.display = (dropdownMenu.style.display === "block") ? "none" : "block";
        }

        function logout() {
            const token = localStorage.getItem("token");

            if (!token) {
                window.location.href = "index.php";
                return;
            }

            $.ajax({
                url: "http://127.0.0.1:8000/api/logout",
                method: "POST",
                headers: {
                    "Authorization": "Bearer " + token,
                    "Content-Type": "application/json"
                },
                success: function (response) {
                    console.log("Logout successful:", response);
                    localStorage.removeItem("token");
                    localStorage.removeItem("role");
                    window.location.href = "index.php";
                },
                error: function (xhr) {
                    console.error("Logout failed:", xhr);
                    localStorage.removeItem("token");
                    localStorage.removeItem("role");
                    window.location.href = "index.php";
                }
            });
        }
    </script>
</body>
</html>
