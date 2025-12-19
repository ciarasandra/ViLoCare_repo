<?php
session_start();

// patients.php – Patient registry & import from VLSM

require 'config.php';
require 'auth.php';
require 'role_guard.php';
include 'header.php';

/* ------------------------------------------------------------------
 * Fetch all patients (core columns used in other pages)
 * ----------------------------------------------------------------*/
$sql = "
    SELECT 
        p.patient_id,
        p.art_number,
        CONCAT(p.first_name,' ',p.last_name) AS full_name,
        p.sex,
        p.dob,
        p.phone,
        p.address
    FROM patients p
    ORDER BY p.art_number ASC
";
$result = mysqli_query($conn, $sql);
if (!$result) die("SQL Error: " . mysqli_error($conn));

/* flash message */
$flash = "";
if (isset($_GET['success']))   $flash = "Patient added successfully!";
if (isset($_GET['updated']))   $flash = "Patient updated successfully!";
if (isset($_GET['deleted']))   $flash = "Patient deleted successfully!";
if (isset($_GET['imported']))  $flash = "VLSM data imported successfully!";
?>
<main class="content">
 <div class="container-fluid p-0">
  <h1 class="h3 mb-3">Patient Management</h1>

  <?php if ($flash): ?>
     <div class="alert alert-success"><?= $flash ?></div>
  <?php endif; ?>

  <div class="row">
   <div class="col-12">
     <div class="card">
       <div class="card-header d-flex justify-content-between align-items-center">
         <h5 class="card-title mb-0">Patient Records</h5>
         <div>
            <!-- NEW: Import VLSM button -->
            <a href="import_vlsm.php" class="btn btn-secondary btn-sm me-2">
               <i class="bi bi-upload"></i> Import VLSM Data
            </a>
            <a href="add_patients.php" class="btn btn-primary btn-sm">
               <i class="bi bi-person-plus"></i> Add Patient
            </a>
         </div>
       </div>

       <div class="card-body">
        <div class="table-responsive">
         <table class="table table-striped table-hover align-middle">
          <thead>
            <tr>
                <th>#</th>
                <th>ART&nbsp;Number</th>
                <th>Full&nbsp;Name</th>
                <th>Sex</th>
                <th>Date&nbsp;of&nbsp;Birth</th>
                <th>Phone</th>
                <th>Address</th>
                <th style="width:120px;">Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php
            if (mysqli_num_rows($result) > 0):
                $n = 1;
                while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                       <td><?= $n++; ?></td>
                       <td><?= htmlspecialchars($row['art_number']); ?></td>
                       <td><?= htmlspecialchars($row['full_name']);  ?></td>
                       <td><?= htmlspecialchars($row['sex']);        ?></td>
                       <td><?= htmlspecialchars($row['dob']);        ?></td>
                       <td><?= htmlspecialchars($row['phone']);      ?></td>
                       <td><?= htmlspecialchars($row['address']);    ?></td>
                       <td>
                           <a href="editpatient.php?id=<?= $row['patient_id']; ?>" class="btn btn-sm btn-outline-info">Edit</a>
                           <a href="delete_patient.php?id=<?= $row['patient_id']; ?>" class="btn btn-sm btn-outline-danger"
                              onclick="return confirm('Delete this patient?');">Delete</a>
                       </td>
                    </tr>
            <?php endwhile;
            else: ?>
                <tr><td colspan="8" class="text-center text-muted">No patient records found.</td></tr>
            <?php endif; ?>
          </tbody>
         </table>
        </div>
       </div>
     </div>
   </div>
  </div>
 </div>
</main>

<?php
include 'footer.php';
mysqli_close($conn);
?>