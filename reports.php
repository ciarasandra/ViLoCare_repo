<?php
// reports.php – Key programme reports & exports
session_start();
if (!isset($_SESSION['username'])) { 
    header("Location: login.php"); 
    exit(); 
}

require 'config.php';
require 'auth.php';
require 'role_guard.php';
include 'header.php';

/* Short helper for counts */
function quickCount($conn,$sql){
    return mysqli_fetch_assoc(mysqli_query($conn,$sql))['total'] ?? 0;
}

/* Totals */
$totalUnsuppressed = quickCount($conn,"
       SELECT COUNT(*) AS total 
       FROM viral_load_results 
       WHERE result_cpml >= 1000
");

$totalDueEAC = quickCount($conn,"
       SELECT COUNT(DISTINCT patient_id) AS total
       FROM viral_load_results
       WHERE result_cpml >= 1000 AND status='Active'
");

$totalDueRepeat = quickCount($conn,"
       SELECT COUNT(DISTINCT es.patient_id) AS total
       FROM eac_sessions es
       WHERE es.completion_status='Completed'
         AND es.session_number=3
         AND NOT EXISTS (SELECT 1 FROM viral_load_results vl 
                         WHERE vl.patient_id=es.patient_id 
                           AND vl.sample_date>es.session_date)
");

/* Detailed lists (top 100 for performance) */
$unsuppressed = mysqli_query($conn,"
    SELECT vl.vl_id, p.art_number, CONCAT(p.first_name,' ',p.last_name) AS patient_name,
           vl.result_cpml, vl.sample_date
    FROM viral_load_results vl
    JOIN patients p ON vl.patient_id=p.patient_id
    WHERE vl.result_cpml>=1000
    ORDER BY vl.sample_date DESC
    LIMIT 100
");

$dueEAC = mysqli_query($conn,"
    SELECT DISTINCT p.patient_id, p.art_number, CONCAT(p.first_name,' ',p.last_name) AS patient_name,
           MAX(vl.sample_date) AS last_high_vl
    FROM viral_load_results vl
    JOIN patients p ON vl.patient_id=p.patient_id
    WHERE vl.result_cpml>=1000 AND vl.status='Active'
    GROUP BY p.patient_id
    LIMIT 100
");

$dueRepeat = mysqli_query($conn,"
    SELECT es.patient_id, p.art_number, CONCAT(p.first_name,' ',p.last_name) AS patient_name,
           MAX(es.session_date) AS last_eac_date
    FROM eac_sessions es
    JOIN patients p ON es.patient_id=p.patient_id
    WHERE es.completion_status='Completed' AND es.session_number=3
      AND NOT EXISTS (SELECT 1 FROM viral_load_results vl 
                      WHERE vl.patient_id = es.patient_id 
                        AND vl.sample_date > es.session_date)
    GROUP BY es.patient_id
    LIMIT 100
");
?>
<main class="content">
 <div class="container-fluid p-0">
  <h1 class="h3 mb-3">Programme Reports</h1>

  <!-- KPI Cards -->
  <div class="row mb-4">
      <div class="col-md-4">
          <div class="card">
              <div class="card-body text-center">
                  <h5>Unsuppressed VL (&ge;1,000 cp/mL)</h5>
                  <h1><?php echo $totalUnsuppressed; ?></h1>
                  <a href="#unsup" class="stretched-link"></a>
              </div>
          </div>
      </div>
      <div class="col-md-4">
          <div class="card">
              <div class="card-body text-center">
                  <h5>Patients Due&nbsp;for&nbsp;EAC</h5>
                  <h1><?php echo $totalDueEAC; ?></h1>
                  <a href="#dueeac" class="stretched-link"></a>
              </div>
          </div>
      </div>
      <div class="col-md-4">
          <div class="card">
              <div class="card-body text-center">
                  <h5>Due&nbsp;for&nbsp;Repeat&nbsp;VL</h5>
                  <h1><?php echo $totalDueRepeat; ?></h1>
                  <a href="#duerepeat" class="stretched-link"></a>
              </div>
          </div>
      </div>
  </div>

  <!-- Tabs -->
  <ul class="nav nav-tabs mb-3" role="tablist">
      <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#unsup"   role="tab">Unsuppressed VL</a></li>
      <li class="nav-item"><a class="nav-link"       data-bs-toggle="tab" href="#dueeac"  role="tab">Due for EAC</a></li>
      <li class="nav-item"><a class="nav-link"       data-bs-toggle="tab" href="#duerepeat" role="tab">Due Repeat VL</a></li>
  </ul>

  <div class="tab-content">
    <!-- Unsuppressed -->
    <div class="tab-pane fade show active" id="unsup" role="tabpanel">
      <div class="table-responsive">
       <table class="table table-striped table-hover align-middle">
        <thead>
         <tr>
          <th>#</th><th>ART No.</th><th>Patient</th><th>VL (cp/mL)</th><th>Sample Date</th>
         </tr>
        </thead><tbody>
        <?php $x=1;
        if ($unsuppressed && mysqli_num_rows($unsuppressed)):
          while($r=mysqli_fetch_assoc($unsuppressed)):?>
           <tr>
            <td><?php echo $x++;?></td>
            <td><?php echo htmlspecialchars($r['art_number']);?></td>
            <td><?php echo htmlspecialchars($r['patient_name']);?></td>
            <td class="text-danger fw-bold"><?php echo htmlspecialchars($r['result_cpml']);?></td>
            <td><?php echo htmlspecialchars($r['sample_date']);?></td>
           </tr>
        <?php endwhile; else: ?>
           <tr><td colspan="5" class="text-center text-muted">No data.</td></tr>
        <?php endif; ?>
        </tbody>
       </table>
      </div>
      <a href="export/export_unsuppressed.php" class="btn btn-sm btn-danger">Export CSV</a>
    </div>

    <!-- Due EAC -->
    <div class="tab-pane fade" id="dueeac" role="tabpanel">
     <div class="table-responsive">
      <table class="table table-striped table-hover align-middle">
        <thead><tr><th>#</th><th>ART No.</th><th>Patient</th><th>Last High VL Date</th></tr></thead>
        <tbody>
        <?php $y=1;
        if($dueEAC && mysqli_num_rows($dueEAC)):
            while($d=mysqli_fetch_assoc($dueEAC)):?>
            <tr>
             <td><?php echo $y++;?></td>
             <td><?php echo htmlspecialchars($d['art_number']);?></td>
             <td><?php echo htmlspecialchars($d['patient_name']);?></td>
             <td><?php echo htmlspecialchars($d['last_high_vl']);?></td>
            </tr>
        <?php endwhile; else: ?>
            <tr><td colspan="4" class="text-center text-muted">No data.</td></tr>
        <?php endif; ?>
        </tbody>
      </table>
     </div>
     <a href="export/export_due_eac.php" class="btn btn-sm btn-danger">Export CSV</a>
    </div>

    <!-- Due repeat -->
    <div class="tab-pane fade" id="duerepeat" role="tabpanel">
     <div class="table-responsive">
      <table class="table table-striped table-hover align-middle">
        <thead><tr><th>#</th><th>ART No.</th><th>Patient</th><th>Last EAC Date</th></tr></thead>
        <tbody>
        <?php $z=1;
        if($dueRepeat && mysqli_num_rows($dueRepeat)):
            while($d=mysqli_fetch_assoc($dueRepeat)):?>
            <tr>
             <td><?php echo $z++;?></td>
             <td><?php echo htmlspecialchars($d['art_number']);?></td>
             <td><?php echo htmlspecialchars($d['patient_name']);?></td>
             <td><?php echo htmlspecialchars($d['last_eac_date']);?></td>
            </tr>
        <?php endwhile; else: ?>
            <tr><td colspan="4" class="text-center text-muted">No data.</td></tr>
        <?php endif; ?>
        </tbody>
      </table>
     </div>
     <a href="export/export_due_repeat.php" class="btn btn-sm btn-danger">Export CSV</a>
    </div>
  </div>
 </div>
</main>
<?php
include 'footer.php';
mysqli_close($conn);
?>