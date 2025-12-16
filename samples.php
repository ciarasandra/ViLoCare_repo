<?php
// samples.php – Manage sample collection & rejections
session_start();
if (!isset($_SESSION['username'])) { header("Location: login.php"); exit(); }
require 'includes/config.php';
include 'includes/header.php';

/* Filters */
$filter_status = isset($_GET['status']) ? $_GET['status'] : '';
$whereStatus   = $filter_status ? "WHERE sc.status='".mysqli_real_escape_string($conn,$filter_status)."'" : "";

/* Fetch */
$sql = "
  SELECT sc.sample_id, sc.collection_date, sc.sample_type, sc.status,
         sc.remote_sample_id,
         p.art_number,
         CONCAT(p.first_name,' ',p.last_name) AS patient_name,
         sr.reason AS rejection_reason
  FROM sample_collection sc
  JOIN patients p           ON sc.patient_id = p.patient_id
  LEFT JOIN sample_rejections sr ON sr.sample_id = sc.sample_id
  $whereStatus
  ORDER BY sc.collection_date DESC
";
$res = mysqli_query($conn,$sql);
?>
<main class="content">
 <div class="container-fluid p-0">
   <h1 class="h3 mb-3">Samples Management</h1>

   <form class="row mb-3" method="get">
      <div class="col-md-3">
          <select name="status" class="form-control">
              <option value="">All Status</option>
              <option value="Collected"  <?php if($filter_status=='Collected') echo 'selected'; ?>>Collected</option>
              <option value="Tested"     <?php if($filter_status=='Tested') echo 'selected'; ?>>Tested</option>
              <option value="Rejected"   <?php if($filter_status=='Rejected') echo 'selected'; ?>>Rejected</option>
          </select>
      </div>
      <div class="col-md-3">
          <button class="btn btn-primary">Filter</button>
      </div>
      <div class="col-md-6 text-end">
          <a href="collect_sample.php"  class="btn btn-success"><i class="bi bi-plus-circle"></i> Collect Sample</a>
          <a href="export/export_samples.php" class="btn btn-danger"><i class="bi bi-file-earmark-arrow-down"></i> Export CSV</a>
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
           <th>Collection&nbsp;Date</th>
           <th>Sample&nbsp;Type</th>
           <th>Status</th>
           <th>Rejection Reason</th>
           <th>Remote ID</th>
           <th>Actions</th>
         </tr>
        </thead>
        <tbody>
        <?php
        $k=1;
        if($res && mysqli_num_rows($res)>0):
            while($row=mysqli_fetch_assoc($res)): ?>
              <tr>
               <td><?php echo $k++; ?></td>
               <td><?php echo htmlspecialchars($row['art_number']); ?></td>
               <td><?php echo htmlspecialchars($row['patient_name']); ?></td>
               <td><?php echo htmlspecialchars($row['collection_date']); ?></td>
               <td><?php echo htmlspecialchars($row['sample_type']); ?></td>
               <td><?php echo htmlspecialchars($row['status']); ?></td>
               <td><?php echo htmlspecialchars($row['rejection_reason']); ?></td>
               <td><?php echo htmlspecialchars($row['remote_sample_id']); ?></td>
               <td>
                   <a href="edit_sample.php?id=<?php echo $row['sample_id'];?>" class="btn btn-sm btn-outline-info">Edit</a>
                   <a href="delete_sample.php?id=<?php echo $row['sample_id'];?>" class="btn btn-sm btn-outline-danger"
                      onclick="return confirm('Delete this sample?');">Delete</a>
               </td>
              </tr>
        <?php endwhile;
        else: ?>
              <tr><td colspan="9" class="text-center text-muted">No samples found.</td></tr>
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