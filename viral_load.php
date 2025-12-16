<?php
// viral_load.php – View & manage Viral-load results
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
require 'includes/config.php';
include 'includes/header.php';

/* ----------  Filters (optional) ---------- */
$search = isset($_GET['q']) ? trim($_GET['q']) : "";
$where  = "";
if ($search !== "") {
    $searchEsc = mysqli_real_escape_string($conn, $search);
    $where     = "WHERE (p.art_number LIKE '%$searchEsc%' 
                      OR CONCAT(p.first_name,' ',p.last_name) LIKE '%$searchEsc%')";
}

/* ----------  Fetch Data ---------- */
$sql = "
    SELECT vl.vl_id, p.art_number, CONCAT(p.first_name,' ',p.last_name) AS patient_name,
           vl.sample_date, vl.result_cpml, vl.result_log, vl.result_date,
           vl.lab, vl.status
    FROM viral_load_results vl
    JOIN patients p        ON vl.patient_id = p.patient_id
    $where
    ORDER BY vl.sample_date DESC
";
$result = mysqli_query($conn, $sql);
?>
<main class="content">
 <div class="container-fluid p-0">
  <h1 class="h3 mb-3">Viral Load Results</h1>

  <!-- Search / quick actions -->
  <form class="row mb-3" method="get">
      <div class="col-md-4">
          <input type="text" name="q" class="form-control" placeholder="Search ART No / Name"
                 value="<?php echo htmlspecialchars($search); ?>">
      </div>
      <div class="col-md-2">
          <button class="btn btn-primary" type="submit">Search</button>
      </div>
      <div class="col-md-6 text-end">
          <a href="add_viral_load.php" class="btn btn-success">
              <i class="bi bi-plus-circle"></i> Add VL Result
          </a>
          <a href="export/export_vl.php" class="btn btn-danger">
              <i class="bi bi-file-earmark-arrow-down"></i> Export CSV
          </a>
      </div>
  </form>

  <!-- VL table -->
  <div class="card">
   <div class="card-body">
    <div class="table-responsive">
     <table class="table table-striped table-hover align-middle">
       <thead>
         <tr>
           <th>#</th>
           <th>ART No.</th>
           <th>Patient</th>
           <th>Sample&nbsp;Date</th>
           <th>Result&nbsp;(cp/mL)</th>
           <th>Result&nbsp;(log)</th>
           <th>Result&nbsp;Date</th>
           <th>Lab</th>
           <th>Status</th>
           <th>Actions</th>
         </tr>
       </thead>
       <tbody>
       <?php
       $n = 1;
       if ($result && mysqli_num_rows($result) > 0):
            while ($row = mysqli_fetch_assoc($result)): ?>
              <tr>
                <td><?php echo $n++; ?></td>
                <td><?php echo htmlspecialchars($row['art_number']); ?></td>
                <td><?php echo htmlspecialchars($row['patient_name']); ?></td>
                <td><?php echo htmlspecialchars($row['sample_date']); ?></td>
                <td class="<?php echo ($row['result_cpml']>=1000?'text-danger fw-bold':''); ?>">
                    <?php echo htmlspecialchars($row['result_cpml']); ?>
                </td>
                <td><?php echo htmlspecialchars($row['result_log']); ?></td>
                <td><?php echo htmlspecialchars($row['result_date']); ?></td>
                <td><?php echo htmlspecialchars($row['lab']); ?></td>
                <td><?php echo htmlspecialchars($row['status']); ?></td>
                <td>
                  <a href="edit_viral_load.php?id=<?php echo $row['vl_id']; ?>" class="btn btn-sm btn-outline-info">Edit</a>
                  <a href="delete_viral_load.php?id=<?php echo $row['vl_id']; ?>" class="btn btn-sm btn-outline-danger"
                     onclick="return confirm('Delete this VL result?');">Delete</a>
                </td>
              </tr>
       <?php endwhile;
       else: ?>
              <tr><td colspan="10" class="text-center text-muted">No viral-load results found.</td></tr>
       <?php endif; ?>
       </tbody>
     </table>
    </div>
   </div>
  </div>
 </div>
</main>
<?php
include 'includes/footer.php';
mysqli_close($conn);
?>