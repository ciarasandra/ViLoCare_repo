<?php
// add_eac_session.php
session_start();
if(!isset($_SESSION['username'])){ header("Location: login.php"); exit(); }
require 'includes/config.php';
include 'includes/header.php';

$errors=[];
if($_SERVER['REQUEST_METHOD']==='POST'){
    $patient_id     = intval($_POST['patient_id']);
    $session_number = intval($_POST['session_number']);
    $session_date   = $_POST['session_date'] ?? '';
    $counselor      = $_POST['counselor'] ?? '';
    $barriers       = $_POST['barriers'] ?? '';
    $action_plan    = $_POST['action_plan'] ?? '';
    $completion     = $_POST['completion_status'] ?? 'Pending';

    if($patient_id<=0)        $errors[]="Patient required";
    if(!$session_date)        $errors[]="Session date required";

    if(!$errors){
        $st=$conn->prepare("INSERT INTO eac_sessions
           (patient_id,session_number,session_date,counselor,barriers,action_plan,completion_status)
           VALUES (?,?,?,?,?,?,?)");
        $st->bind_param("iisssss",$patient_id,$session_number,$session_date,$counselor,$barriers,$action_plan,$completion);
        if($st->execute()){
            header("Location: eac_sessions.php?success=1"); exit();
        } else $errors[]="DB error: ".$st->error;
    }
}

$patients=mysqli_query($conn,"SELECT patient_id,art_number,CONCAT(first_name,' ',last_name) AS pname FROM patients ORDER BY art_number");
?>
<main class="content">
 <div class="container-fluid p-0">
  <h1 class="h3 mb-3">Add EAC Session</h1>
  <?php if($errors): ?><div class="alert alert-danger"><?php foreach($errors as $e) echo "<div>$e</div>";?></div><?php endif; ?>

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
    <div class="col-md-2">
        <label class="form-label">Session #</label>
        <select name="session_number" class="form-select">
            <option value="1">1</option><option value="2">2</option><option value="3">3</option>
        </select>
    </div>
    <div class="col-md-3">
        <label class="form-label">Date</label>
        <input type="date" name="session_date" class="form-control" required>
    </div>
    <div class="col-md-3">
        <label class="form-label">Counselor</label>
        <input type="text" name="counselor" class="form-control">
    </div>
    <div class="col-md-6">
        <label class="form-label">Barriers</label>
        <textarea name="barriers" class="form-control"></textarea>
    </div>
    <div class="col-md-6">
        <label class="form-label">Action Plan</label>
        <textarea name="action_plan" class="form-control"></textarea>
    </div>
    <div class="col-md-3">
        <label class="form-label">Completion Status</label>
        <select name="completion_status" class="form-select">
            <option value="Pending">Pending</option>
            <option value="Completed">Completed</option>
        </select>
    </div>
    <div class="col-12">
       <button class="btn btn-primary">Save</button>
       <a href="eac_sessions.php" class="btn btn-secondary">Cancel</a>
    </div>
  </form>
 </div>
</main>
<?php include 'includes/footer.php'; ?>