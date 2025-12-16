<?php
// doctors.php - Manage Doctors
session_start();
// Redirect to login if not logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

include 'includes/header.php';
require 'config.php';

// Fetch doctors with requesting clinician names if applicable
// Assuming there's a 'requested_by' field referencing the 'users' table
$resultDoctors = mysqli_query($conn, "
    SELECT d.*, u.first_name AS requester_first, u.last_name AS requester_last
    FROM doctors d
    LEFT JOIN users u ON d.requested_by = u.id
    ORDER BY d.date_added DESC");
?>

<main class="content">
    <div class="container-fluid p-0">
        <h1 class="h3 mb-3">Doctors Management</h1>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Registered Doctors</h5>
                        <a href="#" class="btn btn-success btn-sm">
                            <i class="align-middle" data-feather="user-plus"></i> Add Doctors
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover align-middle">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Full Name</th>
                                        <th>Specialisation</th>
                                        <th>Gender</th>
                                        <th>Contact</th>
                                        <th>Email</th>
                                        <th>Date</th>
                                        <th>Requested By</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $counter = 1;
                                    while ($doctor = mysqli_fetch_assoc($resultDoctors)) {
                                        ?>
                                        <tr>
                                            <td><?php echo $counter++; ?></td>
                                            <td><?php echo htmlspecialchars($doctor['full_name']); ?></td>
                                            <td><?php echo htmlspecialchars($doctor['specialisation']); ?></td>
                                            <td><?php echo htmlspecialchars($doctor['gender']); ?></td>
                                            <td><?php echo htmlspecialchars($doctor['contact']); ?></td>
                                            <td><?php echo htmlspecialchars($doctor['email']); ?></td>
                                            <td><?php echo htmlspecialchars($doctor['date_added']); ?></td>
                                            <td>
                                                <?php
                                                if ($doctor['requester_first'] && $doctor['requester_last']) {
                                                    echo htmlspecialchars($doctor['requester_first'] . ' ' . $doctor['requester_last']);
                                                } else {
                                                    echo 'N/A';
                                                }
                                                ?>
                                            </td>
                                            <td>
                                                <a href="edit_doctor.php?doctor_id=<?php echo $doctor['doctor_id']; ?>" class="btn btn-sm btn-outline-info">Edit</a>
                                                <a href="delete_doctor.php?doctor_id=<?php echo $doctor['doctor_id']; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this doctor?');">Delete</a>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                    <?php mysqli_free_result($resultDoctors); ?>
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
include 'includes/footer.php';
?>