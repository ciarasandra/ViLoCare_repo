<?php
// maps-google.php - Google Maps for ViLoCare
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
<title>ViLoCare - Maps</title>
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
        <h1 class="h3 mb-4">Google Maps</h1>
        <div class="row g-4">
          <!-- Default Map -->
          <div class="col-12 col-lg-6">
            <div class="card">
              <div class="card-header">
                <h5 class="card-title mb-0">Default Map</h5>
                <h6 class="card-subtitle text-muted">Displays the default road map view.</h6>
              </div>
              <div class="card-body">
                <div id="default_map" style="height: 300px; width: 100%;"></div>
              </div>
            </div>
          </div>
          <!-- Hybrid Map -->
          <div class="col-12 col-lg-6">
            <div class="card">
              <div class="card-header">
                <h5 class="card-title mb-0">Hybrid Map</h5>
                <h6 class="card-subtitle text-muted">Displays a mixture of normal and satellite views.</h6>
              </div>
              <div class="card-body">
                <div id="hybrid_map" style="height: 300px; width: 100%;"></div>
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
            <p class="mb-0">&copy; 2024 ViLoCare</p>
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
<script>
  function initMaps() {
    const centerCoords = { lat: 40.7128, lng: -74.0060 }; // Example: New York City
    new google.maps.Map(document.getElementById("default_map"), {
      zoom: 14,
      center: centerCoords,
      mapTypeId: google.maps.MapTypeId.ROADMAP,
    });
    new google.maps.Map(document.getElementById("hybrid_map"), {
      zoom: 14,
      center: centerCoords,
      mapTypeId: google.maps.MapTypeId.HYBRID,
    });
  }
</script>
<script
  src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&callback=initMaps"
  async
  defer
></script>
</body>
</html>