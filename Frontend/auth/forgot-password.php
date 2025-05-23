<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Forgot Password</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-light">

<div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="card shadow">
        <div class="card-header bg-primary text-white text-center">
          <h4>Forgot Password</h4>
        </div>
        <div class="card-body">
          <form id="forgotPasswordForm">
            <div class="mb-3">
              <label for="email" class="form-label">Email Address</label>
              <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Send Reset Link</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
document.getElementById('forgotPasswordForm').addEventListener('submit', function(e) {
  e.preventDefault();
  const email = document.getElementById('email').value;

  fetch('http://localhost:8000/api/forgot-password', {
    method: 'POST',
    headers: {'Content-Type': 'application/json'},
    body: JSON.stringify({ email: email })
  })
  .then(res => res.json())
  .then(data => {
    if (data.status) {
      Swal.fire('Success', data.message, 'success');
    } else {
      Swal.fire('Error', data.message, 'error');
    }
  })
  .catch(err => {
    Swal.fire('Error', 'Something went wrong.', 'error');
  });
});
</script>

</body>
</html>
