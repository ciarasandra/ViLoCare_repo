<?php
// export/export_vl.php – export all VL results
session_start();
if(!isset($_SESSION['username'])){ header("Location: ../login.php"); exit(); }
require '../includes/config.php';

header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=viral_load_results_'.date('Ymd').'.csv');
$output = fopen('php://output', 'w');
fputcsv($output, ['ART Number','Patient Name','Sample Date','Result cp/mL','Result log','Result Date','Lab','Status']);

$sql="
  SELECT p.art_number, CONCAT(p.first_name,' ',p.last_name) AS pname,
         vl.sample_date, vl.result_cpml, vl.result_log, vl.result_date, vl.lab, vl.status
  FROM viral_load_results vl
  JOIN patients p ON vl.patient_id=p.patient_id
  ORDER BY vl.sample_date DESC
";
$res=mysqli_query($conn,$sql);
while($row=mysqli_fetch_assoc($res)){
    fputcsv($output,$row);
}
fclose($output);
exit();