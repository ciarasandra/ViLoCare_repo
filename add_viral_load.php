<?php
// add_viral_load.php – create new VL result
session_start();
if (!isset($_SESSION['username'])) { 
    header("Location: login.php"); 
    exit(); 
}

require 'auth.php';
require 'role_guard.php';
require 'config.php';
include 'header.php';

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // collect / sanitise
    $patient_id   = intval($_POST['patient_id']);
    $sample_date  = $_POST['sample_date'] ?? '';
    $result_cpml  = $_POST['result_cpml'] ?? '';
    $result_log   = $_POST['result_log'] ?? '';
    $lab          = $_POST['lab'] ?? '';
    $status       = $_POST['status'] ?? 'Active';

    // basic validation
    if ($patient_id <= 0)          $errors[] = "Patient is required";
    if (empty($sample_date))       $errors[] = "Sample date required";
    if ($result_cpml === '')       $errors[] = "Result (cp/mL) required";

    if (empty($errors)) {
        $stmt = $conn->prepare("INSERT INTO viral_load_results 
            (patient_id, sample_date, result_cpml, result_log, lab, status, result_date)
            VALUES (?,?,?,?,?, ?, NOW())");
        $stmt->bind_param("isdsss", $patient_id, $sample_date, $result_cpml, $result_log, $lab, $status);
        if ($stmt->execute()) {
            header("Location: viral_load.php?success=1");
            exit();
        } else {
            $errors[] = "DB error: " . $stmt->error;
        }
        $stmt->close();
    }
}

/* Dropdown – patients */
$patients = mysqli_query($conn, "SELECT patient_id, art_number, CONCAT(first_name,' ',last_name) AS pname FROM patients ORDER BY art_number");
?>
<main class="content">
 <div class="container-fluid p-0">
  <h1 class="h3 mb-3">Add Viral-Load Result</h1>

  <?php if ($errors): ?>
    <div class="alert alert-danger">
        <?php foreach ($errors as $e) echo "<div>$e</div>"; ?>
    </div>
  <?php endif; ?>

  <form method="post" class="row g-3">
      <div class="col-md-4">
          <label class="form-label">Patient</label>
          <select name="patient_id" class="form-select" required>
              <option value="">-- choose --</option>
              <?php while($p=mysqli_fetch_assoc($patients)): ?>
                 <option value="<?php echo $p['patient_id']; ?>">
                     <?php echo $p['art_number']." - ".$p['pname']; ?>
                 </option>
              <?php endwhile; ?>
          </select>
      </div>
      <div class="col-md-3">
          <label class="form-label">Sample Date</label>
          <input type="date" name="sample_date" class="form-control" required>
      </div>
      <div class="col-md-3">
          <label class="form-label">Result (cp/mL)</label>
          <input type="number" name="result_cpml" class="form-control" required>
      </div>
      <div class="col-md-2">
          <label class="form-label">Result (log)</label>
          <input type="text" name="result_log" class="form-control">
      </div>
      <div class="col-md-4">
          <label class="form-label">Testing Lab</label>
          <input type="text" name="lab" class="form-control">
      </div>
      <div class="col-md-3">
          <label class="form-label">Status</label>
          <select name="status" class="form-select">
              <option value="Active">Active</option>
              <option value="Archived">Archived</option>
          </select>
      </div>
      <div class="col-12">
          <button class="btn btn-primary" type="submit">Save</button>
          <a href="viral_load.php" class="btn btn-secondary">Cancel</a>
      </div>
  </form>
 </div>
</main>
<?php include 'footer.php'; ?>