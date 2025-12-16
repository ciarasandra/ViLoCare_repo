<?php
// pages-profile.php - User Profile for ViLoCare
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>ViLoCare - Profile</title>
  <link href="css/app.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet" />
</head>
<body>
<div class="wrapper">
  <!-- Sidebar: include your existing sidebar here -->
  <!-- Main content -->
  <div class="main">
    <!-- Navbar: include your existing navbar here -->
    <main class="content">
      <div class="container-fluid p-4">
        <h1 class="h3 mb-4">Profile</h1>
        <div class="row">
          <!-- Profile Info -->
          <div class="col-md-4 mb-4">
            <div class="card">
              <div class="card-header">
                <h5 class="card-title mb-0">Profile Details</h5>
              </div>
              <div class="card-body text-center">
                <img src="img/avatars/avatar.jpg" alt="Profile" class="img-fluid rounded-circle mb-3" width="128" height="128" />
                <h5 class="mb-1"><?php echo htmlspecialchars($_SESSION['username']); ?></h5>
                <p class="text-muted mb-2">Role: <?php echo htmlspecialchars($_SESSION['role'] ?? 'User'); ?></p>
                <p>Here you can add user details, edit profile, update password, etc.</p>
                <a href="edit-profile.php" class="btn btn-primary btn-sm">Edit Profile</a>
              </div>
            </div>
          </div>
          <!-- Activity feed or other profile info -->
          <div class="col-md-8 mb-4">
            <div class="card h-100">
              <div class="card-header">
                <h5 class="card-title mb-0">Recent Activity</h5>
              </div>
              <div class="card-body">
                <!-- Example static activity, replace with dynamic data if needed -->
                <p><strong>John Doe</strong> updated his profile.</p>
                <p><strong>Jane Smith</strong> submitted a new viral load result.</p>
                <p><strong>Admin</strong> reviewed user reports.</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </main>
    <!-- include footer here if needed -->
  </div>
</div>
<script src="js/app.js"></script>
</body>
</html>