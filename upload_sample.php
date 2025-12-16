// upload_sample.php
<?php
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $patient_id = $_POST['patient_id'];
    $collection_date = $_POST['collection_date'];
    $sample_type = $_POST['sample_type'];
    $collector = $_POST['collector'];

    // Insert sample
    mysqli_query($conn, "INSERT INTO sample_collection (patient_id, collection_date, sample_type, collector, status) VALUES ($patient_id, '$collection_date', '$sample_type', '$collector', 'Collected')");

    echo json_encode(['status' => 'success']);
}
?>