<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Register</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body style="background: linear-gradient(to right, #6a11cb, #2575fc); min-height: 100vh; display: flex; align-items: center; justify-content: center;">

  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-6 col-lg-5">
        <div class="card shadow-sm">
          <div class="card-body p-4">
            <h4 class="card-title text-center mb-4">Register</h4>
            <form id="registerForm">
              <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" id="name" class="form-control" required>
              </div>
              <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" id="email" class="form-control" required>
              </div>
              <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" id="password" class="form-control" required>
              </div>
              <div class="mb-3">
                <label for="password_confirmation" class="form-label">Confirm Password</label>
                <input type="password" id="password_confirmation" class="form-control" required>
              </div>
              <button type="submit" class="btn btn-primary w-100">Register</button>
              <div class="text-center mt-3">
                <a href="login.php" class="text-decoration-none">Already have an account? Login</a>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script>
    document.getElementById('registerForm').addEventListener('submit', async function(e) {
      e.preventDefault();

      const name = document.getElementById('name').value;
      const email = document.getElementById('email').value;
      const password = document.getElementById('password').value;
      const password_confirmation = document.getElementById('password_confirmation').value;

      const res = await fetch('http://127.0.0.1:8000/api/register', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
        },
        body: JSON.stringify({ name, email, password, password_confirmation })
      });

      const data = await res.json();

      if (res.ok && data.status) {
        Swal.fire('Success', data.message, 'success').then(() => {
          window.location.href = 'login.php';
        });
      } else {
        let errors = '';
        if (data.errors) {
          for (let key in data.errors) {
            errors += data.errors[key][0] + '\n';
          }
        } else {
          errors = data.message || 'Registration failed';
        }

        Swal.fire('Registration Failed', errors, 'error');
      }
    });
  </script>
</body>
</html>
