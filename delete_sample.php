<?php
session_start();
if(!isset($_SESSION['username'])){ header("Location: login.php"); exit(); }
require 'includes/config.php';

$id=intval($_GET['id']??0);
if($id){
  $st=$conn->prepare("DELETE FROM sample_collection WHERE sample_id=?");
  $st->bind_param("i",$id); $st->execute();

  // also delete any rejection row
  $st2=$conn->prepare("DELETE FROM sample_rejections WHERE sample_id=?");
  $st2->bind_param("i",$id); $st2->execute();
}
header("Location: samples.php?deleted=1");
exit();