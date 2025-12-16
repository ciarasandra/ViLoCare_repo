<?php
// edit_eac_session.php
session_start();
if(!isset($_SESSION['username'])){ header("Location: login.php"); exit(); }
require 'includes/config.php';
include 'includes/header.php';

$eac_id=intval($_GET['id']??0);
$st=$conn->prepare("SELECT * FROM eac_sessions WHERE eac_id=?");
$st->bind_param("i",$eac_id); $st->execute();
$es=$st->get_result()->fetch_assoc();
if(!$es){ echo "Not found"; include 'includes/footer.php'; exit(); }

$errors=[];
if($_SERVER['REQUEST_METHOD']==='POST'){
    $session_date   = $_POST['session_date'] ?? '';
    $counselor      = $_POST['counselor'] ?? '';
    $barriers       = $_POST['barriers'] ?? '';
    $action_plan    = $_POST['action_plan'] ?? '';
    $completion     = $_POST['completion_status'] ?? 'Pending';

    if(!$session_date) $errors[]="Date required";
    if(!$errors){
        $st=$conn->prepare("UPDATE eac_sessions SET session_date=?, counselor=?, barriers=?, action_plan=?, completion_status=? WHERE eac_id=?");
        $st->bind_param("sssssi",$session_date,$counselor,$barriers,$action_plan,$completion,$eac_id);
        if($st->execute()){ header("Location: eac_sessions.php?updated=1"); exit(); }
        else $errors[]="DB error: ".$st->error;
    }
}
?>
<main class="content">
 <div class="container-fluid p-0">
  <h1 class="h3 mb-3">Edit EAC Session</h1>
  <?php if($errors):?><div class="alert alert-danger"><?php foreach($errors as $e) echo "<div>$e</div>";?></div><?php endif;?>

  <form method="post" class="row g-3">
      <div class="col-md-2">
          <label class="form-label">Session #</label>
          <input type="number" class="form-control" value="<?php echo $es['session_number'];?>" disabled>
      </div>
      <div class="col-md-3">
          <label class="form-label">Date</label>
          <input type="date" name="session_date" class="form-control" value="<?php echo $es['session_date'];?>" required>
      </div>
      <div class="col-md-3">
          <label class="form-label">Counselor</label>
          <input type="text" name="counselor" class="form-control" value="<?php echo $es['counselor'];?>">
      </div>
      <div class="col-md-6">
          <label class="form-label">Barriers</label>
          <textarea name="barriers" class="form-control"><?php echo $es['barriers'];?></textarea>
      </div>
      <div class="col-md-6">
          <label class="form-label">Action Plan</label>
          <textarea name="action_plan" class="form-control"><?php echo $es['action_plan'];?></textarea>
      </div>
      <div class="col-md-3">
          <label class="form-label">Completion Status</label>
          <select name="completion_status" class="form-select">
             <option value="Pending"   <?php if($es['completion_status']=='Pending') echo 'selected';?>>Pending</option>
             <option value="Completed" <?php if($es['completion_status']=='Completed') echo 'selected';?>>Completed</option>
          </select>
      </div>
      <div class="col-12">
          <button class="btn btn-primary">Update</button>
          <a href="eac_sessions.php" class="btn btn-secondary">Back</a>
      </div>
  </form>
 </div>
</main>
<?php include 'includes/footer.php'; ?>