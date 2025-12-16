// dashboard_data.php
<?php
require 'config.php';

// Example: count total patients
$total_patients = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM patients"))['total'];

// Samples collected
$samples_collected = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM sample_collection WHERE status='Collected'"))['total'];

// Rejected samples
$rejected_samples = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM sample_rejections"))['total'];

// Patients due for VL test
$due_vl = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM alerts_schedules WHERE event_type='VL' AND due_date <= CURDATE() AND status='Pending'"))['total'];

// and so on...

echo json_encode([
    'total_patients' => $total_patients,
    'samples_collected' => $samples_collected,
    'rejected_samples' => $rejected_samples,
    'due_vl' => $due_vl,
]);
mysqli_close($conn);
?>