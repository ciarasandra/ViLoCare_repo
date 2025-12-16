<?php
// index.php  –  ViLoCare Dashboard (updated with action-button links)

session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
require 'includes/config.php';
include 'includes/header.php';

/* ------------------------------------------------------------------
 * 1. Collect filter values
 * ----------------------------------------------------------------*/
$facilities = mysqli_query($conn, "SELECT facility_id, facility_name FROM facilities ORDER BY facility_name");
$counties   = mysqli_query($conn, "SELECT county_id, county_name FROM counties   ORDER BY county_name");
$states     = mysqli_query($conn, "SELECT state_id,  state_name  FROM states     ORDER BY state_name");

$filter_facility = isset($_GET['facility']) ? intval($_GET['facility']) : '';
$filter_county   = isset($_GET['county'])   ? intval($_GET['county'])   : '';
$filter_state    = isset($_GET['state'])    ? intval($_GET['state'])    : '';
$filter_month    = isset($_GET['month'])    ? $_GET['month']           : date('m');
$filter_year     = isset($_GET['year'])     ? $_GET['year']            : date('Y');

/* build WHERE for month/year-restricted queries */
$where = [];
if ($filter_facility) $where[] = "p.facility_id = $filter_facility";
if ($filter_county)   $where[] = "p.county_id   = $filter_county";
if ($filter_state)    $where[] = "p.state_id    = $filter_state";
if ($filter_month)    $where[] = "MONTH(sc.collection_date) = '".mysqli_real_escape_string($conn,$filter_month)."'";
if ($filter_year)     $where[] = "YEAR(sc.collection_date)  = '".mysqli_real_escape_string($conn,$filter_year)."'";
$where_clause = $where ? "WHERE " . implode(' AND ', $where) : "";

/* ------------------------------------------------------------------
 * 2. Summary counts
 * ----------------------------------------------------------------*/
# Patients
$sqlPatients  = "SELECT COUNT(*) AS total FROM patients p";
if ($filter_facility || $filter_county || $filter_state) {
    $sqlPatients .= " WHERE 1=1";
    if ($filter_facility) $sqlPatients .= " AND p.facility_id = $filter_facility";
    if ($filter_county)   $sqlPatients .= " AND p.county_id   = $filter_county";
    if ($filter_state)    $sqlPatients .= " AND p.state_id    = $filter_state";
}
$totalPatients = mysqli_fetch_assoc(mysqli_query($conn,$sqlPatients))['total'];

# VL appointments today
$today = date('Y-m-d');
$sqlAppointments = "
    SELECT COUNT(*) AS total
    FROM appointments a
    JOIN patients p ON a.patient_id = p.patient_id
    WHERE DATE(a.appointment_date) = '$today'";
if ($filter_facility) $sqlAppointments .= " AND p.facility_id = $filter_facility";
if ($filter_county)   $sqlAppointments .= " AND p.county_id   = $filter_county";
if ($filter_state)    $sqlAppointments .= " AND p.state_id    = $filter_state";
$totalAppointmentsToday = mysqli_fetch_assoc(mysqli_query($conn,$sqlAppointments))['total'];

# Samples collected
$sqlSamplesCollected = "
    SELECT COUNT(*) AS total
    FROM sample_collection sc
    JOIN patients p ON sc.patient_id = p.patient_id
    $where_clause";
$totalSamplesCollected = mysqli_fetch_assoc(mysqli_query($conn,$sqlSamplesCollected))['total'];

# High VL
$sqlHighVL = "
    SELECT COUNT(*) AS total
    FROM viral_load_results vl
    JOIN patients p ON vl.patient_id = p.patient_id
    WHERE vl.result_cpml >= 1000";
if ($filter_facility) $sqlHighVL .= " AND p.facility_id = $filter_facility";
if ($filter_county)   $sqlHighVL .= " AND p.county_id   = $filter_county";
if ($filter_state)    $sqlHighVL .= " AND p.state_id    = $filter_state";
if ($filter_month)    $sqlHighVL .= " AND MONTH(vl.sample_date) = '".mysqli_real_escape_string($conn,$filter_month)."'";
if ($filter_year)     $sqlHighVL .= " AND YEAR(vl.sample_date)  = '".mysqli_real_escape_string($conn,$filter_year)."'";
$totalHighVL = mysqli_fetch_assoc(mysqli_query($conn,$sqlHighVL))['total'];

# Samples rejected
$sqlSamplesRejected = "
    SELECT COUNT(*) AS total
    FROM sample_rejections sr
    JOIN sample_collection sc ON sr.sample_id = sc.sample_id
    JOIN patients p           ON sc.patient_id = p.patient_id
    $where_clause";
$totalSamplesRejected = mysqli_fetch_assoc(mysqli_query($conn,$sqlSamplesRejected))['total'];

# Patients due for EAC
$sqlDueEAC = "
    SELECT COUNT(DISTINCT vl.patient_id) AS total
    FROM viral_load_results vl
    JOIN patients p ON vl.patient_id = p.patient_id
    WHERE vl.result_cpml >= 1000 AND vl.status = 'Active'";
if ($filter_facility) $sqlDueEAC .= " AND p.facility_id = $filter_facility";
if ($filter_county)   $sqlDueEAC .= " AND p.county_id   = $filter_county";
if ($filter_state)    $sqlDueEAC .= " AND p.state_id    = $filter_state";
if ($filter_month)    $sqlDueEAC .= " AND MONTH(vl.sample_date) = '".mysqli_real_escape_string($conn,$filter_month)."'";
if ($filter_year)     $sqlDueEAC .= " AND YEAR(vl.sample_date)  = '".mysqli_real_escape_string($conn,$filter_year)."'";
$totalDueEAC = mysqli_fetch_assoc(mysqli_query($conn,$sqlDueEAC))['total'];

# Patients due for repeat VL
$sqlDueRepeat = "
    SELECT COUNT(DISTINCT es.patient_id) AS total
    FROM eac_sessions es
    JOIN patients p ON es.patient_id = p.patient_id
    WHERE es.completion_status = 'Completed'
      AND es.session_number    = 3
      AND NOT EXISTS (
          SELECT 1 FROM viral_load_results vl
          WHERE vl.patient_id = es.patient_id
            AND vl.sample_date > es.session_date
      )";
if ($filter_facility) $sqlDueRepeat .= " AND p.facility_id = $filter_facility";
if ($filter_county)   $sqlDueRepeat .= " AND p.county_id   = $filter_county";
if ($filter_state)    $sqlDueRepeat .= " AND p.state_id    = $filter_state";
$totalDueRepeatVL = mysqli_fetch_assoc(mysqli_query($conn,$sqlDueRepeat))['total'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>ViLoCare Dashboard</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://kit.fontawesome.com/a076d05399.js"></script>
</head>
<body>
<main class="content">
  <div class="container-fluid p-0">
    <h1 class="h3 mb-3">ViLoCare Dashboard Overview</h1>

    <!-- -------------------- Filters -------------------- -->
    <form method="get" class="row mb-4">
      <div class="col-md-2">
        <select name="state" class="form-control">
          <option value="">All States</option>
          <?php while ($row = mysqli_fetch_assoc($states)): ?>
            <option value="<?= $row['state_id'] ?>" <?= $filter_state == $row['state_id'] ? 'selected' : '' ?>>
              <?= htmlspecialchars($row['state_name']) ?>
            </option>
          <?php endwhile; ?>
        </select>
      </div>
      <div class="col-md-2">
        <select name="county" class="form-control">
          <option value="">All Counties</option>
          <?php while ($row = mysqli_fetch_assoc($counties)): ?>
            <option value="<?= $row['county_id'] ?>" <?= $filter_county == $row['county_id'] ? 'selected' : '' ?>>
              <?= htmlspecialchars($row['county_name']) ?>
            </option>
          <?php endwhile; ?>
        </select>
      </div>
      <div class="col-md-2">
        <select name="facility" class="form-control">
          <option value="">All Facilities</option>
          <?php while ($row = mysqli_fetch_assoc($facilities)): ?>
            <option value="<?= $row['facility_id'] ?>" <?= $filter_facility == $row['facility_id'] ? 'selected' : '' ?>>
              <?= htmlspecialchars($row['facility_name']) ?>
            </option>
          <?php endwhile; ?>
        </select>
      </div>
      <div class="col-md-2">
        <select name="month" class="form-control">
          <?php for ($m = 1; $m <= 12; $m++): ?>
            <?php $mPad = str_pad($m, 2, '0', STR_PAD_LEFT); ?>
            <option value="<?= $mPad ?>" <?= $filter_month == $mPad ? 'selected' : '' ?>>
              <?= date('F', mktime(0, 0, 0, $m, 1)) ?>
            </option>
          <?php endfor; ?>
        </select>
      </div>
      <div class="col-md-2">
        <select name="year" class="form-control">
          <?php for ($y = date('Y'); $y >= 2020; $y--): ?>
            <option value="<?= $y ?>" <?= $filter_year == $y ? 'selected' : '' ?>><?= $y ?></option>
          <?php endfor; ?>
        </select>
      </div>
      <div class="col-md-2">
        <button class="btn btn-primary" type="submit">Apply Filters</button>
      </div>
    </form>

    <!-- ---------------- Quick Actions ------------------ -->
    <div class="row mb-4">
      <div class="col-12">
        <div class="d-flex flex-wrap gap-2">
          <a href="add_patients.php"      class="btn btn-primary"><i class="bi bi-person-plus"></i> Register New Patient</a>
          <a href="add_viral_load.php"    class="btn btn-success"><i class="bi bi-droplet"></i> Record VL Result</a>
          <a href="add_eac_session.php"   class="btn btn-warning text-dark"><i class="bi bi-chat-dots"></i> Schedule EAC</a>
          <a href="collect_sample.php"    class="btn btn-info text-white"><i class="bi bi-clipboard-plus"></i> Collect Sample</a>
          <a href="import_vlsm.php"       class="btn btn-secondary"><i class="bi bi-upload"></i> Import VLSM Data</a>
          <a href="reports.php"           class="btn btn-danger"><i class="bi bi-file-earmark-bar-graph"></i> Export Report</a>
        </div>
      </div>
    </div>

    <!-- ---------------- Summary Cards ------------------ -->
    <div class="row mb-4">
      <div class="col-md-6 col-xl-3">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title mb-4">Number of Patients</h5>
            <h1 class="mt-1 mb-3"><?= $totalPatients ?></h1>
          </div>
        </div>
      </div>
      <div class="col-md-6 col-xl-3">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title mb-4">VL Appointments Today</h5>
            <h1 class="mt-1 mb-3"><?= $totalAppointmentsToday ?></h1>
          </div>
        </div>
      </div>
      <div class="col-md-6 col-xl-3">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title mb-4">Samples Collected</h5>
            <h1 class="mt-1 mb-3"><?= $totalSamplesCollected ?></h1>
          </div>
        </div>
      </div>
      <div class="col-md-6 col-xl-3">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title mb-4">High Viral Load (&ge;1,000)</h5>
            <h1 class="mt-1 mb-3"><?= $totalHighVL ?></h1>
          </div>
        </div>
      </div>
    </div>

    <!-- secondary cards -->
    <div class="row mb-4">
      <div class="col-md-6 col-xl-3">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title mb-4">Samples Rejected</h5>
            <h1 class="mt-1 mb-3"><?= $totalSamplesRejected ?></h1>
          </div>
        </div>
      </div>
      <div class="col-md-6 col-xl-3">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title mb-4">Patients Due for EAC</h5>
            <h1 class="mt-1 mb-3"><?= $totalDueEAC ?></h1>
          </div>
        </div>
      </div>
      <div class="col-md-6 col-xl-3">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title mb-4">Due for Repeat VL</h5>
            <h1 class="mt-1 mb-3"><?= $totalDueRepeatVL ?></h1>
          </div>
        </div>
      </div>
    </div>

  </div>
</main>

<?php include 'includes/footer.php'; ?>
</body>
</html>