<?php
session_start();
if(!isset($_SESSION['username'])){ header("Location: ../login.php"); exit(); }
require '../includes/config.php';

header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=samples_'.date('Ymd').'.csv');
$out=fopen('php://output','w');
fputcsv($out,['ART Number','Patient Name','Collection Date','Sample Type','Status','Rejection Reason','Remote ID']);

$sql="
 SELECT p.art_number, CONCAT(p.first_name,' ',p.last_name) AS pname,
        sc.collection_date, sc.sample_type, sc.status,
        COALESCE(sr.reason,'') AS rejection_reason,
        sc.remote_sample_id
 FROM sample_collection sc
 JOIN patients p ON sc.patient_id=p.patient_id
 LEFT JOIN sample_rejections sr ON sr.sample_id=sc.sample_id
 ORDER BY sc.collection_date DESC
";
$res=mysqli_query($conn,$sql);
while($r=mysqli_fetch_assoc($res)) fputcsv($out,$r);
fclose($out); exit();