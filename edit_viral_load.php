<?php
// edit_viral_load.php
session_start();
if (!isset($_SESSION['username'])) { header("Location: login.php"); exit(); }
require 'includes/config.php';
include 'includes/header.php';

$vl_id = intval($_GET['id'] ?? 0);
if ($vl_id <= 0) { header("Location: viral_load.php"); exit(); }

/* fetch existing */
$stmt = $conn->prepare("SELECT * FROM viral_load_results WHERE vl_id=?");
$stmt->bind_param("i",$vl_id); $stmt->execute(); $vl = $stmt->get_result()->fetch_assoc();
if (!$vl) { echo "Record not found."; include 'includes/footer.php'; exit(); }

$errors=[];
if($_SERVER['REQUEST_METHOD']==='POST'){
    $sample_date = $_POST['sample_date'] ?? '';
    $result_cpml = $_POST['result_cpml'] ?? '';
    $result_log  = $_POST['result_log'] ?? '';
    $lab         = $_POST['lab'] ?? '';
    $status      = $_POST['status'] ?? 'Active';

    if(empty($sample_date)) $errors[]="Sample date required";
    if($result_cpml==='')   $errors[]="Result cp/mL required";

    if(!$errors){
        $st=$conn->prepare("UPDATE viral_load_results SET sample_date=?, result_cpml=?, result_log=?, lab=?, status=? WHERE vl_id=?");
        $st->bind_param("sdsssi",$sample_date,$result_cpml,$result_log,$lab,$status,$vl_id);
        if($st->execute()){
           header("Location: viral_load.php?updated=1"); exit();
        }else $errors[]="DB error: ".$st->error;
    }
}
?>
<main class="content">
 <div class="container-fluid p-0">
  <h1 class="h3 mb-3">Edit Viral-Load Result</h1>
  <?php if($errors):?><div class="alert alert-danger"><?php foreach($errors as $e) echo "<div>$e</div>";?></div><?php endif;?>

  <form method="post" class="row g-3">
      <div class="col-md-4">
          <label class="form-label">Sample Date</label>
          <input type="date" name="sample_date" class="form-control"
                 value="<?php echo htmlspecialchars($vl['sample_date']);?>" required>
      </div>
      <div class="col-md-3">
          <label class="form-label">Result (cp/mL)</label>
          <input type="number" name="result_cpml" class="form-control"
                 value="<?php echo htmlspecialchars($vl['result_cpml']);?>" required>
      </div>
      <div class="col-md-2">
          <label class="form-label">Result (log)</label>
          <input type="text" name="result_log" class="form-control"
                 value="<?php echo htmlspecialchars($vl['result_log']);?>">
      </div>
      <div class="col-md-4">
          <label class="form-label">Testing Lab</label>
          <input type="text" name="lab" class="form-control"
                 value="<?php echo htmlspecialchars($vl['lab']);?>">
      </div>
      <div class="col-md-3">
          <label class="form-label">Status</label>
          <select name="status" class="form-select">
             <option value="Active"   <?php if($vl['status']=='Active') echo 'selected';?>>Active</option>
             <option value="Archived" <?php if($vl['status']=='Archived') echo 'selected';?>>Archived</option>
          </select>
      </div>
      <div class="col-12">
          <button class="btn btn-primary" type="submit">Update</button>
          <a href="viral_load.php" class="btn btn-secondary">Back</a>
      </div>
  </form>
 </div>
</main>
<?php include 'includes/footer.php'; ?>