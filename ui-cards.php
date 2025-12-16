<?php
// ui-cards.php - Cards Page for ViLoCare
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
  <title>ViLoCare - Cards</title>
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
        <h1 class="h3 mb-4">Cards</h1>
        <div class="row g-4">
          <!-- Card with image and links -->
          <div class="col-12 col-md-6">
            <div class="card">
              <img src="img/photos/unsplash-1.jpg" class="card-img-top" alt="Image">
              <div class="card-body">
                <h5 class="card-title">Card with image and links</h5>
                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                <a href="#" class="card-link">Card link</a>
                <a href="#" class="card-link">Another link</a>
              </div>
            </div>
          </div>
          <!-- Card with image and button -->
          <div class="col-12 col-md-6">
            <div class="card">
              <img src="img/photos/unsplash-2.jpg" class="card-img-top" alt="Image">
              <div class="card-body">
                <h5 class="card-title">Card with image and button</h5>
                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                <a href="#" class="btn btn-primary">Go somewhere</a>
              </div>
            </div>
          </div>
          <!-- Card with links -->
          <div class="col-12 col-md-6">
            <div class="card">
              <div class="card-header">
                <h5 class="card-title mb-0">Card with links</h5>
              </div>
              <div class="card-body">
                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                <a href="#" class="card-link">Card link</a>
                <a href="#" class="card-link">Another link</a>
              </div>
            </div>
          </div>
          <!-- Card with button -->
          <div class="col-12 col-md-6">
            <div class="card">
              <div class="card-header">
                <h5 class="card-title mb-0">Card with button</h5>
              </div>
              <div class="card-body">
                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                <a href="#" class="btn btn-primary">Go somewhere</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </main>
    <!-- Footer -->
    <footer class="footer mt-auto py-3 bg-light">
      <div class="container">
        <div class="row align-items-center">
          <div class="col-6">
            <p class="mb-0">&copy; 2024 ViLoCare. All rights reserved.</p>
          </div>
          <div class="col-6 text-end">
            <ul class="list-inline mb-0">
              <li class="list-inline-item"><a href="#">Support</a></li>
              <li class="list-inline-item"><a href="#">Help Center</a></li>
              <li class="list-inline-item"><a href="#">Privacy</a></li>
              <li class="list-inline-item"><a href="#">Terms</a></li>
            </ul>
          </div>
        </div>
      </div>
    </footer>
  </div>
</div>
<script src="js/app.js"></script>
</body>
</html>