<?php
session_start();
if(!isset($_SESSION['username'])){header("Location: ../login.php");exit();}
require '../includes/config.php';
header('Content-Type: text/csv'); 
header('Content-Disposition: attachment; filename=unsuppressed_'.date('Ymd').'.csv');
$out=fopen('php://output','w');
fputcsv($out,['ART Number','Patient Name','VL cp/mL','Sample Date']);
$q="SELECT p.art_number, CONCAT(p.first_name,' ',p.last_name) AS pname, vl.result_cpml, vl.sample_date
    FROM viral_load_results vl
    JOIN patients p ON vl.patient_id=p.patient_id
    WHERE vl.result_cpml>=1000
    ORDER BY vl.sample_date DESC";
$res=mysqli_query($conn,$q);
while($row=mysqli_fetch_assoc($res)) fputcsv($out,$row);
fclose($out); exit();