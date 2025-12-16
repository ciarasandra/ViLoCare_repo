<?php
session_start();
require 'config.php'; // your database connection

$error = "";

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? "");
    $password = trim($_POST['password'] ?? "");
    $role = trim($_POST['role'] ?? "");

    if ($username === '' || $password === '' || $role === '') {
        $error = "Please fill in all fields.";
    } else {
        // Prepare statement to prevent SQL injection
        $stmt = mysqli_prepare($conn, "SELECT id, username, password, role FROM users WHERE LOWER(username) = LOWER(?) AND role = ? LIMIT 1");
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "ss", $username, $role);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if ($row = mysqli_fetch_assoc($result)) {
                // Compare plaintext password (since your DB stores plain text)
                if ($password === $row['password']) {
                    $_SESSION['username'] = $row['username'];
                    $_SESSION['role'] = $row['role'];
                    mysqli_stmt_close($stmt);
                    mysqli_close($conn);
                    header("Location: index.php");
                    exit();
                } else {
                    $error = "Invalid credentials.";
                }
            } else {
                $error = "User not found or role incorrect.";
            }
            mysqli_stmt_close($stmt);
        } else {
            $error = "Database query error.";
        }
        mysqli_close($conn);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>ViLoCare - HIV Patient Viral Load Management System</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
  <style>
    body { background-color: #f8fafc; min-height: 100vh; }
    .login-container { background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); height: 100vh; display: flex; align-items: center; justify-content: center; }
    .login-card { background: white; border-radius: 12px; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04); width: 100%; max-width: 420px; padding: 2rem; }
    .login-logo { text-align: center; margin-bottom: 2rem; }
    .login-logo img { height: 80px; }
    .btn-primary { background-color: #2563eb; border-color: #2563eb; }
    .btn-primary:hover { background-color: #1d4ed8; border-color: #1d4ed8; }
  </style>
</head>
<body>
  <div class="login-container">
    <div class="login-card">
      <div class="login-logo">
        <img src="vilocarelogo.png" alt="ViLoCare Logo" class="img-fluid" style="max-height: 80px;" />
        <p class="text-muted mb-3" style="font-size: 1rem;">HIV Patient Viral Load Management System</p>
      </div>
      <?php if ($error): ?>
        <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
      <?php endif; ?>
      <form method="post" autocomplete="off">
        <div class="mb-3">
          <label for="username" class="form-label">Username</label>
          <input type="text" name="username" class="form-control" id="username" placeholder="Enter your username" required />
        </div>
        <div class="mb-3">
          <label for="password" class="form-label">Password</label>
          <input type="password" name="password" class="form-control" id="password" placeholder="Enter your password" required />
        </div>
        <div class="mb-3">
          <label for="role" class="form-label">Select your role</label>
          <select class="form-select" name="role" id="role" required>
            <option value="" disabled selected>Select your role</option>
            <option value="Clinician">Clinician</option>
            <option value="Lab Technician">Lab Technician</option>
            <option value="Data Officer">Data Officer</option>
            <option value="Administrator">Administrator</option>
          </select>
        </div>
        <div class="mb-3 form-check">
          <input type="checkbox" class="form-check-input" id="remember-me" />
          <label class="form-check-label" for="remember-me">Remember me</label>
        </div>
        <button type="submit" class="btn btn-primary w-100">Sign in</button>
        <div class="text-center mt-3">
          <a href="#" class="text-decoration-none">Forgot password?</a>
        </div>
      </form>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>