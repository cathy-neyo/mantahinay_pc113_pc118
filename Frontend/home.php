<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>BSAS Scholarship</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
  <link href="https://fonts.googleapis.com/css2?family=Inter&display=swap" rel="stylesheet"/>
  <style>
    body {
      font-family: 'Inter', sans-serif;
    }
  </style>
</head>
<body class="bg-white text-gray-700">

  <!-- HEADER -->
  <header class="bg-white shadow-md sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
      <!-- Logo -->
      <div class="flex items-center space-x-3">
        <img src="logo.jpg" alt="BSAS Logo" class="w-10 h-10 md:w-12 md:h-12 object-cover border border-gray-300 rounded-full">
        <span class="text-lg md:text-2xl font-bold text-gray-800">BSAS</span>
      </div>

      <!-- Desktop Navigation -->
      <nav class="hidden md:flex space-x-8 text-sm font-semibold text-gray-600">
        <a href="#" class="hover:text-yellow-500 hover:underline underline-offset-8">Home</a>
        <a href="#posts" class="hover:text-yellow-500 hover:underline underline-offset-8">Posts</a>
        <a href="#" class="hover:text-yellow-500 hover:underline underline-offset-8">About Us</a>
        <a href="login.php" class="hover:text-yellow-500 hover:underline underline-offset-8">Login</a>
        <a href="register.php" class="hover:text-yellow-500 hover:underline underline-offset-8">Register</a>
      </nav>

      <!-- Mobile Menu Button -->
      <button id="mobile-menu-button" class="md:hidden text-gray-600 text-2xl focus:outline-none">
        <i class="fas fa-bars"></i>
      </button>
    </div>

    <!-- Mobile Navigation -->
    <div id="mobile-menu" class="md:hidden hidden px-6 py-4 space-y-2 bg-white border-t">
      <a href="#" class="block text-sm font-semibold text-gray-700 hover:text-yellow-500">Home</a>
      <a href="#posts" class="block text-sm font-semibold text-gray-700 hover:text-yellow-500">Posts</a>
      <a href="#" class="block text-sm font-semibold text-gray-700 hover:text-yellow-500">About Us</a>
      <a href="login.php" class="block text-sm font-semibold text-gray-700 hover:text-yellow-500">Login</a>
      <a href="register.php" class="block text-sm font-semibold text-gray-700 hover:text-yellow-500">Register</a>
    </div>
  </header>

  <!-- MAIN SECTION -->
  <main class="max-w-7xl mx-auto px-6 py-16 grid grid-cols-1 md:grid-cols-2 gap-10 items-center">
    <div>
      <h1 class="text-3xl sm:text-4xl md:text-5xl font-bold text-gray-800 leading-tight mb-6">
        Get Full Free <br> Scholarship Now
      </h1>
      <p class="text-sm sm:text-base md:text-lg text-gray-600 mb-8 leading-relaxed">
        Unlock opportunities with full scholarships to top institutions. Apply today and start your journey toward success.
      </p>
      <div class="flex flex-wrap gap-4 mb-10">
        <button class="bg-yellow-400 hover:bg-yellow-500 text-white font-semibold px-6 py-2 rounded-lg shadow-md transition transform hover:scale-105">
          MEET US
        </button>
        <button class="border border-gray-700 text-gray-700 font-semibold px-6 py-2 rounded-lg transition transform hover:bg-gray-100 hover:scale-105">
          CONSULTATION
        </button>
      </div>

      <div class="bg-yellow-50 rounded-lg px-6 py-6 grid sm:grid-cols-2 gap-6 text-sm">
        <div class="flex space-x-3">
          <i class="far fa-award text-2xl text-yellow-500"></i>
          <div>
            <p class="font-bold text-gray-700">Certified</p>
            <p class="text-gray-600 text-xs">Recognized by top institutions for credibility and excellence in education support.</p>
          </div>
        </div>
        <div class="flex space-x-3">
          <i class="fas fa-home text-2xl text-yellow-500"></i>
          <div>
            <p class="font-bold text-gray-700">Accommodation</p>
            <p class="text-gray-600 text-xs">We help you find affordable and safe living spaces near your chosen school.</p>
          </div>
        </div>
      </div>
    </div>

    <div class="flex justify-center md:justify-end">
      <img src="https://storage.googleapis.com/a1aa/image/276b9434-1341-4255-fad4-83945e2ab24a.jpg" alt="Graduates" class="w-full max-w-xs sm:max-w-md md:max-w-lg rounded-lg shadow-lg hover:shadow-2xl transition duration-300 ease-in-out transform hover:scale-105"/>
    </div>
  </main>

  <!-- Posts Section -->
  <section id="posts" class="max-w-7xl mx-auto px-6 py-12">
    <h2 class="text-2xl sm:text-3xl font-bold mb-6 text-gray-800">Latest Scholarship Posts</h2>
    <div id="scholarship-posts" class="grid sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
      <!-- Dynamic content will be loaded here -->
    </div>
  </section>

  <!-- Scripts -->
  <script>
    // Toggle mobile menu
    document.getElementById('mobile-menu-button').addEventListener('click', function () {
      const menu = document.getElementById('mobile-menu');
      menu.classList.toggle('hidden');
    });

    // Load scholarships
    document.addEventListener("DOMContentLoaded", function () {
      fetch('http://localhost:8000/api/scholarships') // Adjust to your actual endpoint
        .then(response => response.json())
        .then(data => {
          const container = document.getElementById('scholarship-posts');
          if (data.length === 0) {
            container.innerHTML = '<p class="text-gray-600">No scholarships available right now.</p>';
          } else {
            data.forEach(scholarship => {
              container.innerHTML += `
                <div class="bg-white p-6 rounded-lg shadow-lg hover:shadow-2xl transition duration-300 ease-in-out transform hover:scale-105">
                  <img src="/storage/scholarships/${scholarship.image}" alt="Scholarship Image" class="w-full h-48 object-cover rounded-t-lg mb-4">
                  <h3 class="text-lg font-semibold text-gray-800 mb-3">${scholarship.title}</h3>
                  <p class="text-gray-600 text-sm mb-4">${scholarship.description.substring(0, 100)}...</p>
                  <div class="flex justify-between items-center text-xs text-gray-400">
                    <p>Posted on: ${new Date(scholarship.created_at).toLocaleDateString()}</p>
                    <a href="/scholarships/${scholarship.id}" class="text-blue-500 hover:underline">Read More</a>
                  </div>
                </div>
              `;
            });
          }
        })
        .catch(error => {
          console.error('Error loading scholarships:', error);
        });
    });
  </script>

</body>
</html>
