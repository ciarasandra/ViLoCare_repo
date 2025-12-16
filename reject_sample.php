// reject_sample.php
<?php
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sample_id = $_POST['sample_id'];
    $reason = $_POST['reason'];
    $action_taken = $_POST['action_taken'];

    mysqli_query($conn, "UPDATE sample_collection SET status='Rejected' WHERE sample_id=$sample_id");
    mysqli_query($conn, "INSERT INTO sample_rejections (sample_id, rejection_date, reason, action_taken) VALUES ($sample_id, NOW(), '$reason', '$action_taken')");

    echo json_encode(['status' => 'success']);
}
?>