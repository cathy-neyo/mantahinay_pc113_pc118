<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>BSAS Login</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <style>
    body {
      background: linear-gradient(to right, #6a11cb, #2575fc);
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .login-card {
      background-color: #fff;
      padding: 2rem;
      border-radius: 10px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.25);
    }
  </style>
</head>
<body>

<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-6 col-lg-4">
      <div class="login-card">
        <h4 class="text-center mb-4">Login</h4>
        <form id="loginForm">
          <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" required>
          </div>
          <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" required>
          </div>
          <button type="submit" class="btn btn-primary w-100">Login</button>
        </form>

        <div class="text-center mt-3">
          <a href="auth/forgot-password.php" class="d-block text-primary">Forgot Password?</a>
          <a href="register.php" class="d-block mt-1 text-decoration-none">Don't have an account? Register</a>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
document.getElementById('loginForm').addEventListener('submit', function(e) {
  e.preventDefault();

  const email = document.getElementById('email').value;
  const password = document.getElementById('password').value;

  fetch('http://localhost:8000/api/login', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({ email, password })
  })
  .then(res => res.json().then(data => ({ status: res.status, body: data })))
  .then(({ status, body }) => {
    if (status === 200 && body.token) {
      localStorage.setItem('auth_token', body.token);
      localStorage.setItem('user', JSON.stringify(body.user));

      const redirectURL = body.redirect_url || 'login.php';

      Swal.fire({
        icon: 'success',
        title: 'Login Successful',
        text: `Welcome ${body.user.name}`,
        timer: 1500,
        showConfirmButton: false
      }).then(() => {
        window.location.href = redirectURL;
      });

    } else {
      Swal.fire({
        icon: 'error',
        title: 'Login Failed',
        text: body.message || 'Invalid credentials.'
      });
    }
  })
  .catch(error => {
    console.error('Login Error:', error);
    Swal.fire({
      icon: 'error',
      title: 'Something went wrong',
      text: 'Please try again later.'
    });
  });
});
</script>

</body>
</html>
