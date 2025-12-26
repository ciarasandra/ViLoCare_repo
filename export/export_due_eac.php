<?php
session_start(); if(!isset($_SESSION['username'])){header("Location: ../login.php");exit();}
require '../includes/config.php';
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename=patients_due_EAC_'.date('Ymd').'.csv');
$out=fopen('php://output','w');
fputcsv($out,['ART Number','Patient Name','Last High VL Date']);

$q="SELECT DISTINCT p.art_number, CONCAT(p.first_name,' ',p.last_name) AS pname,
          MAX(vl.sample_date) AS last_high_vl
    FROM viral_load_results vl
    JOIN patients p ON vl.patient_id=p.patient_id
    WHERE vl.result_cpml>=1000 AND vl.status='Active'
    GROUP BY p.patient_id";
$res=mysqli_query($conn,$q);
while($r=mysqli_fetch_assoc($res)) fputcsv($out,$r);
fclose($out); exit();