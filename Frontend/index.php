<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>

<div class="flex flex-wrap min-h-screen w-full content-center justify-center bg-pink-100 py-10">
  <div class="flex shadow-lg rounded-lg overflow-hidden">
    <div class="flex flex-wrap content-center justify-center rounded-l-lg bg-white p-8" style="width: 24rem; height: 32rem;">
      <div class="w-72">
        <h1 class="text-xl font-semibold text-pink-700">Welcome Back, Maot!</h1>
        <small class="text-gray-500">Enter your details to continue</small>
        
        <form id="loginform" class="mt-4">
          <div class="mb-3">
            <label class="mb-2 block text-xs font-semibold text-pink-700">Email</label>
            <input type="email" id="email" name="email" placeholder="Enter your email" class="block w-full rounded-md border border-pink-300 focus:border-pink-500 focus:outline-none focus:ring-1 focus:ring-pink-500 py-2 px-3 text-gray-500" required>
          </div>
          <div class="mb-3">
            <label class="mb-2 block text-xs font-semibold text-pink-700">Password</label>
            <input type="password" id="password" name="password" placeholder="Enter password" class="block w-full rounded-md border border-pink-300 focus:border-pink-500 focus:outline-none focus:ring-1 focus:ring-pink-500 py-2 px-3 text-gray-500" required>
          </div>
          <div class="mb-3">
            <button type="submit" class="mb-1.5 block w-full text-center text-white bg-pink-500 hover:bg-pink-700 px-4 py-2 rounded-md shadow-md">Log in</button>
          </div>
        </form>
      </div>
    </div>
    <div class="flex flex-wrap content-center justify-center rounded-r-lg bg-pink-300" style="width: 24rem; height: 32rem;">
      <img class="w-full h-full bg-center bg-no-repeat bg-cover rounded-r-lg" src="https://i.imgur.com/9l1A4OS.jpeg">
    </div>
  </div>
</div>

<script>
    document.getElementById("loginform").addEventListener("submit", async function(event) {
        event.preventDefault();
        const email = document.getElementById("email").value;
        const password = document.getElementById("password").value;

        try {
            const response = await fetch("http://127.0.0.1:8000/api/login", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ email, password })
            });

            const data = await response.json();

            if (response.ok) {
                localStorage.setItem("token", data.token);
                window.location.href = "dashboard.html";
            } else {
                alert(data.message || "Invalid email or password");
            }
        } catch (error) {
            console.error("Error:", error);
            alert("An error occurred. Please try again later.");
        }
    });
</script>

</body>
</html>
