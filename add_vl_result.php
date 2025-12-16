<?php
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $patient_id = $_POST['patient_id'];
    $sample_date = $_POST['sample_date'];
    $result = $_POST['result'];
    $lab = $_POST['lab'];
    $notes = $_POST['notes'];

    // Insert result
    $stmt = mysqli_prepare($conn, "INSERT INTO viral_load_results (patient_id, sample_date, result, lab, notes) VALUES (?, ?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "issss", $patient_id, $sample_date, $result, $lab, $notes);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    // Determine next steps based on algorithm
    $action = '';
    if ($result >= 1000) {
        $action = 'Schedule EAC and repeat VL after sessions.';
        // Insert alert for EAC
        $due_date = date('Y-m-d', strtotime('+1 month')); // example
        mysqli_query($conn, "INSERT INTO alerts_schedules (patient_id, event_type, due_date, status) VALUES ($patient_id, 'EAC', '$due_date', 'Pending')");
    } else {
        $action = 'Viral suppression achieved. Schedule next VL in 6 or 12 months.';
        // Set next routine test date
        $next_test = date('Y-m-d', strtotime('+6 months'));
        mysqli_query($conn, "INSERT INTO alerts_schedules (patient_id, event_type, due_date, status) VALUES ($patient_id, 'VL', '$next_test', 'Pending')");
    }

    echo json_encode(['status' => 'success', 'action' => $action]);
}
?>