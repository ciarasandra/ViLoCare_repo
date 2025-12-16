<?php
include 'includes/config.php';

//check if ID is present
if (!isset($_GET['id']) || 
empty($_GET['id'])) {
    echo "Invalid request.";
    exit;
}

$patient_id = intval($_GET['id']);

//DELETE query
$sql = "DELETE FROM patient_info WHERE patientinfo_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $patient_id);

if ($stmt->execute()) {
    header("Location: patients.php? deleted=1");
    exit;
} else {
    echo "Error deleting patient: " . $conn->error;
}
$stmt->close();
$conn->close();
?>