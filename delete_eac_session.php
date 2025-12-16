<?php
session_start();
if(!isset($_SESSION['username'])){ header("Location: login.php"); exit(); }
require 'includes/config.php';

$id=intval($_GET['id']??0);
if($id){
  $st=$conn->prepare("DELETE FROM eac_sessions WHERE eac_id=?");
  $st->bind_param("i",$id);
  $st->execute();
}
header("Location: eac_sessions.php?deleted=1");
exit();