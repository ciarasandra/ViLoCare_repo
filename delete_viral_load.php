<?php
// delete_viral_load.php
session_start();
if(!isset($_SESSION['username'])){ header("Location: login.php"); exit(); }
require 'includes/config.php';

$id = intval($_GET['id'] ?? 0);
if($id>0){
    $stmt=$conn->prepare("DELETE FROM viral_load_results WHERE vl_id=?");
    $stmt->bind_param("i",$id);
    $stmt->execute();
}
header("Location: viral_load.php?deleted=1");
exit();