<?php
$token = $_GET['token'] ?? '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Reset Password</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-light">

<div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="card shadow">
        <div class="card-header bg-success text-white text-center">
          <h4>Reset Password</h4>
        </div>
        <div class="card-body">
          <form id="resetPasswordForm">
            <input type="hidden" id="token" value="<?= htmlspecialchars($token) ?>">
            <div class="mb-3">
              <label for="password" class="form-label">New Password</label>
              <input type="password" class="form-control" id="password" required>
            </div>
            <div class="mb-3">
              <label for="confirmPassword" class="form-label">Confirm Password</label>
              <input type="password" class="form-control" id="confirmPassword" required>
            </div>
            <button type="submit" class="btn btn-success w-100">Reset Password</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
document.getElementById('resetPasswordForm').addEventListener('submit', function(e) {
  e.preventDefault();
  
  const password = document.getElementById('password').value;
  const confirmPassword = document.getElementById('confirmPassword').value;
  const token = document.getElementById('token').value;

  if (password !== confirmPassword) {
    Swal.fire('Error', 'Passwords do not match.', 'error');
    return;
  }

  fetch('http://localhost:8000/api/reset-password', {
    method: 'POST',
    headers: {'Content-Type': 'application/json'},
    body: JSON.stringify({ token, password })
  })
  .then(res => res.json())
  .then(data => {
    if (data.status) {
      Swal.fire('Success', data.message, 'success').then(() => {
        window.location.href = '../login.php';
      });
    } else {
      Swal.fire('Error', data.message, 'error');
    }
  })
  .catch(() => {
    Swal.fire('Error', 'Something went wrong.', 'error');
  });
});
</script>

</body>
</html>
