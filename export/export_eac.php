<?php
session_start();
if(!isset($_SESSION['username'])){ header("Location: ../login.php"); exit(); }
require '../includes/config.php';

header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=eac_sessions_'.date('Ymd').'.csv');
$out=fopen('php://output','w');
fputcsv($out,['ART Number','Patient Name','Session #','Date','Counselor','Status','Barriers','Action Plan']);

$q="
 SELECT p.art_number, CONCAT(p.first_name,' ',p.last_name) AS patient,
        es.session_number, es.session_date, es.counselor, es.completion_status,
        es.barriers, es.action_plan
 FROM eac_sessions es
 JOIN patients p ON p.patient_id=es.patient_id
 ORDER BY es.session_date DESC
";
$res=mysqli_query($conn,$q);
while($row=mysqli_fetch_assoc($res)) fputcsv($out,$row);
fclose($out); exit();