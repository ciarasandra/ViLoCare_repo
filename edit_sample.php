<?php
session_start();
if(!isset($_SESSION['username'])){header("Location: login.php");exit();}
require 'includes/config.php';
include 'includes/header.php';

$sample_id=intval($_GET['id']??0);
$st=$conn->prepare("SELECT * FROM sample_collection WHERE sample_id=?");
$st->bind_param("i",$sample_id); $st->execute();
$sc=$st->get_result()->fetch_assoc();
if(!$sc){echo"Not found";include 'includes/footer.php';exit();}

$errors=[];
if($_SERVER['REQUEST_METHOD']==='POST'){
   $collection_date=$_POST['collection_date']??'';
   $sample_type=$_POST['sample_type']??'Plasma';
   $status=$_POST['status']??'Collected';
   $remote=$_POST['remote_sample_id']??'';
   $collector=$_POST['collector']??'';

   if(!$collection_date) $errors[]="Date required";
   if(!$errors){
        $u=$conn->prepare("UPDATE sample_collection SET collection_date=?,sample_type=?,collector=?,status=?,remote_sample_id=? WHERE sample_id=?");
        $u->bind_param("sssssi",$collection_date,$sample_type,$collector,$status,$remote,$sample_id);
        if($u->execute()){header("Location: samples.php?updated=1");exit();}
        else $errors[]="DB error: ".$u->error;
   }
}
?>
<main class="content"><div class="container-fluid p-0">
 <h1 class="h3 mb-3">Edit Sample</h1>
 <?php if($errors):?><div class="alert alert-danger"><?php foreach($errors as $e) echo"<div>$e</div>";?></div><?php endif;?>
 <form method="post" class="row g-3">
   <div class="col-md-3">
      <label class="form-label">Collection Date</label>
      <input type="date" name="collection_date" class="form-control" value="<?php echo $sc['collection_date'];?>" required>
   </div>
   <div class="col-md-3">
      <label class="form-label">Sample Type</label>
      <select name="sample_type" class="form-select">
         <option <?php if($sc['sample_type']=='Plasma')echo"selected";?>>Plasma</option>
         <option <?php if($sc['sample_type']=='DBS')echo"selected";?>>DBS</option>
      </select>
   </div>
   <div class="col-md-3">
      <label class="form-label">Collector</label>
      <input type="text" name="collector" class="form-control" value="<?php echo $sc['collector'];?>">
   </div>
   <div class="col-md-3">
      <label class="form-label">Status</label>
      <select name="status" class="form-select">
          <option <?php if($sc['status']=='Collected')echo"selected";?>>Collected</option>
          <option <?php if($sc['status']=='Tested')echo"selected";?>>Tested</option>
          <option <?php if($sc['status']=='Rejected')echo"selected";?>>Rejected</option>
      </select>
   </div>
   <div class="col-md-3">
      <label class="form-label">Remote Sample ID</label>
      <input type="text" name="remote_sample_id" class="form-control" value="<?php echo $sc['remote_sample_id'];?>">
   </div>
   <div class="col-12">
       <button class="btn btn-primary">Update</button>
       <a href="samples.php" class="btn btn-secondary">Back</a>
   </div>
 </form>
</div></main>
<?php include 'includes/footer.php'; ?>