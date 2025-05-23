<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Barangay Scholarship Assistance System</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/@lottiefiles/lottie-player@1.0.0/dist/lottie-player.js">
  <style>
    body {
      background: linear-gradient(to right, #87CEEB, #ffffff);
      font-family: 'Segoe UI', sans-serif;
      scroll-behavior: smooth;
    }

    .navbar {
      background-color: white;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
      border-bottom: 2px solid #87CEEB;
      position: sticky;
      top: 0;
      z-index: 1000;
    }

    .navbar-brand {
      font-size: 1.8rem;
      font-weight: bold;
      color: #87CEEB;
      transition: color 0.3s ease;
    }

    .navbar-brand:hover {
      color: #1E90FF;
    }

    .navbar-nav .nav-link {
      color: #333;
      transition: color 0.3s ease;
    }

    .navbar-nav .nav-link:hover {
      color: #87CEEB;
    }

    .card img {
      height: 200px;
      object-fit: cover;
      transition: transform 0.3s ease, opacity 0.3s ease;
    }

    .card img:hover {
      transform: scale(1.05);
      opacity: 0.9;
    }

    .card-body {
      background-color: #f8f9fa;
      padding: 20px;
      transition: background-color 0.3s ease;
    }

    .card-body:hover {
      background-color: #e9ecef;
    }

    .hero-section {
      background: linear-gradient(to right, #87CEEB, #00BFFF);
      color: white;
      padding: 100px 0;
      text-align: center;
      background-attachment: fixed;
      position: relative;
      z-index: 1;
    }

    .hero-section h1 {
      font-size: 3.5rem;
      font-weight: bold;
      /* animation: fadeIn 2s ease-in-out; */
    }

    .hero-section p {
      font-size: 1.2rem;
      /* animation: fadeIn 3s ease-in-out; */
    }

    .btn-primary {
      background-color: #87CEEB;
      border: none;
      transition: background-color 0.3s ease, transform 0.3s ease;
    }

    .btn-primary:hover {
      background-color: #1E90FF;
      transform: scale(1.05);
    }

    footer {
      background-color: white;
      padding: 30px 0;
      text-align: center;
      margin-top: 40px;
      box-shadow: 0 -2px 8px rgba(0, 0, 0, 0.2);
    }

    #searchFilterBar {
      margin-bottom: 30px;
    }

    .container {
      max-width: 1200px;
    }

    /* .floating-action-btn {
      position: fixed;
      right: 20px;
      bottom: 20px;
      background-color: #87CEEB;
      border: none;
      border-radius: 50%;
      width: 60px;
      height: 60px;
      box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
      font-size: 30px;
      color: white;
      display: flex;
      align-items: center;
      justify-content: center;
      transition: transform 0.3s ease;
    } */
/* 
    .floating-action-btn:hover {
      transform: scale(1.1);
      background-color: #1E90FF;
    } */
/* 
    .parallax-bg {
      background-image: url('https://via.placeholder.com/1920x800/87CEEB/FFFFFF?text=Scholarship+Assistance');
      background-position: center;
      background-repeat: no-repeat;
      background-size: cover;
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      z-index: -1;
      animation: parallax 10s linear infinite;
    } */

    /* @keyframes parallax {
      0% { background-position: 0 0; }
      100% { background-position: 0 50%; }
    }

    @keyframes fadeIn {
      from { opacity: 0; }
      to { opacity: 1; } */
    /* } */
  </style>
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-light">
  <div class="container">
    <a class="navbar-brand" href="index.php">BSAScholarship</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item"><a class="nav-link active" href="#scholarships">Scholarships</a></li>
        <li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>
        <li class="nav-item"><a class="nav-link" href="register.php">Register</a></li>
      </ul>
    </div>
  </div>
</nav>

<!-- HERO SECTION WITH PARALLAX -->
<header class="hero-section">
  <div class="parallax-bg"></div>
  <div class="container">
    <h1>Welcome to the Barangay Scholarship Assistance System</h1>
    <p>Find and apply for available scholarships in your barangay.</p>
    <a href="#scholarships" class="btn btn-light mt-3">View Scholarships</a>
  </div>
</header>

<!-- SCHOLARSHIPS SECTION -->
<section class="container py-5" id="scholarships">
  <h2 class="mb-4 text-center">Available Scholarships</h2>

  <!-- Search & Filter -->
  <div id="searchFilterBar" class="row mb-4">
    <div class="col-md-6 mb-2">
      <input type="text" id="searchKeyword" class="form-control" placeholder="Search scholarships...">
    </div>
    <div class="col-md-6 mb-2">
      <select id="deadlineFilter" class="form-select">
        <option value="all">All Deadlines</option>
        <option value="upcoming">Upcoming Only</option>
        <option value="past">Past Only</option>
      </select>
    </div>
  </div>

  <!-- Posts -->
  <div class="row" id="scholarshipPosts"></div>
</section>

<!-- FOOTER -->
<footer>
  <div class="container">
    <p>&copy; 2025 Barangay Scholarship Assistance System</p>
  </div>
</footer>

<!-- FLOATING ACTION BUTTON -->
<!-- <button class="floating-action-btn" onclick="scrollToTop()">↑</button> -->

<!-- SCRIPTS -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
  let scholarships = [];

  $(document).ready(function () {
    fetchScholarships();

    $('#searchKeyword, #deadlineFilter').on('input change', filterScholarships);
  });

  function fetchScholarships() {
    $.get('http://localhost:8000/api/scholarships', function (data) {
      scholarships = data;
      filterScholarships();
    });
  }

  function filterScholarships() {
    const keyword = $('#searchKeyword').val().toLowerCase();
    const deadlineOption = $('#deadlineFilter').val();
    const today = new Date();

    const filtered = scholarships.filter(s => {
      const titleMatch = s.title.toLowerCase().includes(keyword);
      const descMatch = s.description.toLowerCase().includes(keyword);
      const matchesSearch = titleMatch || descMatch;

      const endDate = new Date(s.end_date);
      const isUpcoming = endDate >= today;
      const isPast = endDate < today;

      let matchesDeadline = true;
      if (deadlineOption === 'upcoming') matchesDeadline = isUpcoming;
      else if (deadlineOption === 'past') matchesDeadline = isPast;

      return matchesSearch && matchesDeadline;
    });

    displayScholarships(filtered);
  }

  function displayScholarships(list) {
    const container = $('#scholarshipPosts');
    container.empty();

    if (list.length === 0) {
      container.append(`<div class="col-12 text-center"><p>No scholarships found.</p></div>`);
      return;
    }

    $.each(list, function (i, s) {
      const image = s.image ?? 'https://via.placeholder.com/400x200?text=No+Image';
      container.append(`
        <div class="col-md-4 mb-4">
          <div class="card shadow-sm h-100">
            <img src="${image}" class="card-img-top" alt="Scholarship Image">
            <div class="card-body d-flex flex-column">
              <h5 class="card-title">${s.title}</h5>
              <p class="card-text">${s.description.substring(0, 100)}...</p>
              <p><strong>Amount:</strong> ₱${s.amount}</p>
              <p><strong>Deadline:</strong> ${s.end_date}</p>
              <button class="btn btn-primary mt-auto" onclick="viewScholarship(${s.id})">View More</button>
            </div>
          </div>
        </div>
      `);
    });
  }

  function viewScholarship(id) {
    $.get(`http://localhost:8000/api/scholarships/${id}`, function (s) {
      Swal.fire({
        title: s.title,
        html: `
          <img src="${s.image}" class="img-fluid mb-3" />
          <p><strong>Description:</strong><br>${s.description}</p>
          <p><strong>Requirements:</strong><br>${s.requirements}</p>
          <p><strong>Start:</strong> ${s.start_date}</p>
          <p><strong>End:</strong> ${s.end_date}</p>
        `,
        width: '600px'
      });
    });
  }

  function scrollToTop() {
    window.scrollTo({ top: 0, behavior: 'smooth' });
  }
</script>

</body>
</html>

