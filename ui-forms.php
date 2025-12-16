<?php
// ui-forms.php - Forms Page for ViLoCare
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
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <title>ViLoCare - Forms</title>
  <link href="css/app.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet" />
</head>

<body>
  <div class="wrapper">
    <!-- Sidebar navigation omitted for brevity, include your existing sidebar here -->

    <div class="main">
      <!-- Navbar omitted for brevity, include your existing navbar here -->

      <main class="content">
        <div class="container-fluid p-0">
          <h1 class="h3 mb-3">Forms</h1>
          <div class="row">
            <!-- Sample Form: Patient Registration -->
            <div class="col-12 col-lg-6 mb-4">
              <div class="card">
                <div class="card-header">
                  <h5 class="card-title mb-0">Register New Patient</h5>
                </div>
                <div class="card-body">
                  <form method="POST" action="submit_patient.php">
                    <div class="mb-3">
                      <label class="form-label">First Name</label>
                      <input type="text" class="form-control" name="first_name" required>
                    </div>
                    <div class="mb-3">
                      <label class="form-label">Last Name</label>
                      <input type="text" class="form-control" name="last_name" required>
                    </div>
                    <div class="mb-3">
                      <label class="form-label">Date of Birth</label>
                      <input type="date" class="form-control" name="dob" required>
                    </div>
                    <div class="mb-3">
                      <label class="form-label">Gender</label>
                      <select class="form-select" name="gender" required>
                        <option value="">Select gender</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                      </select>
                    </div>
                    <div class="mb-3">
                      <label class="form-label">Phone</label>
                      <input type="tel" class="form-control" name="phone" required>
                    </div>
                    <div class="mb-3">
                      <label class="form-label">Address</label>
                      <input type="text" class="form-control" name="address" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Register Patient</button>
                  </form>
                </div>
              </div>
            </div>

            <!-- Sample Form: Viral Load Result Entry -->
            <div class="col-12 col-lg-6 mb-4">
              <div class="card">
                <div class="card-header">
                  <h5 class="card-title mb-0">Enter Viral Load Result</h5>
                </div>
                <div class="card-body">
                  <form method="POST" action="submit_vl_result.php">
                    <div class="mb-3">
                      <label class="form-label">Patient ID</label>
                      <input type="number" class="form-control" name="patient_id" required>
                    </div>
                    <div class="mb-3">
                      <label class="form-label">Sample Date</label>
                      <input type="date" class="form-control" name="sample_date" required>
                    </div>
                    <div class="mb-3">
                      <label class="form-label">Result</label>
                      <input type="number" class="form-control" name="result" required>
                    </div>
                    <div class="mb-3">
                      <label class="form-label">Lab</label>
                      <input type="text" class="form-control" name="lab" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit VL Result</button>
                  </form>
                </div>
              </div>
            </div>
          </div>

          <!-- Add more forms as needed, following similar structure -->
        </div>
      </main>

      <!-- Footer omitted for brevity, include your footer here -->
    </div>
  </div>
  <script src="js/app.js"></script>
</body>
</html>