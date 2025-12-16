<?php
// collect_sample.php – add new sample
session_start();
if(!isset($_SESSION['username'])){ header("Location: login.php"); exit(); }
require 'includes/config.php';
include 'includes/header.php';

$errors=[];
if($_SERVER['REQUEST_METHOD']==='POST'){
    $patient_id = intval($_POST['patient_id']);
    $collection_date=$_POST['collection_date']??'';
    $sample_type = $_POST['sample_type']??'Plasma';
    $status      = $_POST['status']??'Collected';
    $remote_id   = $_POST['remote_sample_id']??'';
    $collector   = $_POST['collector']??'';

    if($patient_id<=0)         $errors[]="Patient required";
    if(!$collection_date)      $errors[]="Collection date required";

    if(!$errors){
        $st=$conn->prepare("INSERT INTO sample_collection
           (patient_id,collection_date,sample_type,collector,status,remote_sample_id)
           VALUES (?,?,?,?,?,?)");
        $st->bind_param("isssss",$patient_id,$collection_date,$sample_type,$collector,$status,$remote_id);
        if($st->execute()){ header("Location: samples.php?success=1"); exit();}
        else $errors[]="DB error: ".$st->error;
    }
}
$patients=mysqli_query($conn,"SELECT patient_id,art_number, CONCAT(first_name,' ',last_name) AS pname FROM patients ORDER BY art_number");
?>
<main class="content"><div class="container-fluid p-0">
 <h1 class="h3 mb-3">Collect Sample</h1>
 <?php if($errors):?><div class="alert alert-danger"><?php foreach($errors as $e) echo "<div>$e</div>";?></div><?php endif;?>
 <form method="post" class="row g-3">
   <div class="col-md-4">
     <label class="form-label">Patient</label>
     <select name="patient_id" class="form-select" required>
        <option value="">--select--</option>
        <?php while($p=mysqli_fetch_assoc($patients)):?>
          <option value="<?php echo $p['patient_id'];?>"><?php echo $p['art_number'].' - '.$p['pname'];?></option>
        <?php endwhile;?>
     </select>
   </div>
   <div class="col-md-3">
      <label class="form-label">Collection Date</label>
      <input type="date" name="collection_date" class="form-control" required>
   </div>
   <div class="col-md-3">
      <label class="form-label">Sample Type</label>
      <select name="sample_type" class="form-select">
          <option>Plasma</option><option>DBS</option>
      </select>
   </div>
   <div class="col-md-3">
      <label class="form-label">Collector</label>
      <input type="text" name="collector" class="form-control">
   </div>
   <div class="col-md-3">
      <label class="form-label">Status</label>
      <select name="status" class="form-select">
         <option>Collected</option><option>Tested</option><option>Rejected</option>
      </select>
   </div>
   <div class="col-md-3">
      <label class="form-label">Remote Sample ID</label>
      <input type="text" name="remote_sample_id" class="form-control">
   </div>
   <div class="col-12">
      <button class="btn btn-primary">Save</button>
      <a href="samples.php" class="btn btn-secondary">Cancel</a>
   </div>
 </form>
</div></main>
<?php include 'includes/footer.php'; ?>