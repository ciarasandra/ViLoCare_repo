<?php
require 'config.php';

$result = mysqli_query($conn, "SELECT p.patient_id, p.first_name, p.last_name, p.dob, p.sex, p.phone, p.address, p.art_start_date, ac.description AS age_desc FROM patients p LEFT JOIN age_categories ac ON p.age_category = ac.category_id");

$patients = [];
while ($row = mysqli_fetch_assoc($result)) {
    $patients[] = $row;
}
echo json_encode($patients);
mysqli_close($conn);
?>