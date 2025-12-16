<?php
// eac_sessions.php – Manage Enhanced Adherence Counselling (EAC)
session_start();
if (!isset($_SESSION['username'])) { header("Location: login.php"); exit(); }
require 'includes/config.php';
include 'includes/header.php';

/* Filters */
$search = isset($_GET['q']) ? trim($_GET['q']) : "";
$where  = "";
if ($search !== "") {
   $searchEsc = mysqli_real_escape_string($conn, $search);
   $where     = "WHERE (p.art_number LIKE '%$searchEsc%' 
                    OR CONCAT(p.first_name,' ',p.last_name) LIKE '%$searchEsc%')";
}

/* Fetch data */
$sql = "
   SELECT es.eac_id, es.patient_id, es.session_number, es.session_date,
          es.counselor, es.completion_status,
          CONCAT(p.first_name,' ',p.last_name) AS patient_name,
          p.art_number
   FROM eac_sessions es
   JOIN patients p ON es.patient_id = p.patient_id
   $where
   ORDER BY es.session_date DESC
";
$result = mysqli_query($conn, $sql);
?>
<main class="content">
 <div class="container-fluid p-0">
  <h1 class="h3 mb-3">EAC Session Tracker</h1>

  <form class="row mb-3" method="get">
      <div class="col-md-4">
          <input type="text" name="q" class="form-control" placeholder="Search ART No / Name"
                 value="<?php echo htmlspecialchars($search); ?>">
      </div>
      <div class="col-md-8 text-end">
          <a href="add_eac_session.php" class="btn btn-success">
              <i class="bi bi-plus-circle"></i> New EAC Session
          </a>
          <a href="export/export_eac.php" class="btn btn-danger">
              <i class="bi bi-file-earmark-arrow-down"></i> Export CSV
          </a>
      </div>
  </form>

  <div class="card">
   <div class="card-body">
    <div class="table-responsive">
     <table class="table table-striped table-hover align-middle">
       <thead>
         <tr>
           <th>#</th>
           <th>ART No.</th>
           <th>Patient</th>
           <th>Session&nbsp;#</th>
           <th>Date</th>
           <th>Counselor</th>
           <th>Status</th>
           <th>Actions</th>
         </tr>
       </thead>
       <tbody>
       <?php
       $i=1;
       if ($result && mysqli_num_rows($result)):
          while($row=mysqli_fetch_assoc($result)): ?>
             <tr>
                <td><?php echo $i++; ?></td>
                <td><?php echo htmlspecialchars($row['art_number']); ?></td>
                <td><?php echo htmlspecialchars($row['patient_name']); ?></td>
                <td><?php echo htmlspecialchars($row['session_number']); ?></td>
                <td><?php echo htmlspecialchars($row['session_date']); ?></td>
                <td><?php echo htmlspecialchars($row['counselor']); ?></td>
                <td>
                    <?php if ($row['completion_status']=='Completed'): ?>
                       <span class="badge bg-success">Completed</span>
                    <?php else: ?>
                       <span class="badge bg-warning text-dark"><?php echo htmlspecialchars($row['completion_status']); ?></span>
                    <?php endif; ?>
                </td>
                <td>
                    <a href="edit_eac_session.php?id=<?php echo $row['eac_id']; ?>" class="btn btn-sm btn-outline-info">Edit</a>
                    <a href="delete_eac_session.php?id=<?php echo $row['eac_id']; ?>" class="btn btn-sm btn-outline-danger"
                       onclick="return confirm('Delete this session?');">Delete</a>
                </td>
             </tr>
          <?php endwhile;
       else: ?>
          <tr><td colspan="8" class="text-center text-muted">No EAC sessions found.</td></tr>
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