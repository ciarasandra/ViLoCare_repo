<?php
session_start(); if(!isset($_SESSION['username'])){header("Location: ../login.php");exit();}
require '../includes/config.php';
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename=patients_due_repeat_VL_'.date('Ymd').'.csv');
$out=fopen('php://output','w');
fputcsv($out,['ART Number','Patient Name','Last EAC Date']);

$q="
 SELECT es.patient_id, p.art_number, CONCAT(p.first_name,' ',p.last_name) AS pname,
        MAX(es.session_date) AS last_eac
 FROM eac_sessions es
 JOIN patients p ON p.patient_id=es.patient_id
 WHERE es.completion_status='Completed' AND es.session_number=3
   AND NOT EXISTS (SELECT 1 FROM viral_load_results vl 
                   WHERE vl.patient_id=es.patient_id 
                     AND vl.sample_date>es.session_date)
 GROUP BY es.patient_id
";
$res=mysqli_query($conn,$q);
while($r=mysqli_fetch_assoc($res)) fputcsv($out,$r);
fclose($out); exit();