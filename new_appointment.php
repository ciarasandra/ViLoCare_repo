<?php
session_start();

if (!isset($_SESSION['username'])){
    header("Location: login.php");
    exit();
}

require 'includes/config.php';

$success = "";
$error = "";

//handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    $patientinfo_id = trim($_POST['patientinfo_id']);
    $doctorName = trim($_POST['doctorName']);
    $appointmentDate = trim($_POST['appointmentDate']);
    $appointmentTime = trim($_POST['appointmentTime']);
    $status = trim($_POST['status']);

    if ($patientinfo_id === "" || $doctorName === "" || $appointmentDate === "" || $appointmentTime === "" || $status === ""){
        $error = "All fields are required.";
    } else {
        $stmt = mysqli_prepare($conn, "INSERT INTO appointments (patientinfo_id, doctorName, appointmentDate, appointmentTime, status, createdAt) VALUES (?, ?, ?, ?, ?, NOW())");
        if ($stmt){
            mysqli_stmt_bind_param($stmt, "sssss", $patientinfo_id, $doctorName, $appointmentDate, $appointmentTime, $status);
            if (mysqli_stmt_execute($stmt)){
                $success = "Appointment created successfully!";
            } else {
                $error = "Database insert failed.";
            }
            mysqli_stmt_close($stmt);
        } else {
            $error = "Query preparation failed.";
        }
    }
}

include 'includes/header.php';
?>

<main class="content">
    <div class="container-fluid p-0">
        <h1 class="h3 mb-3"> Create New Appointment </h1>
        <div class="card">
            <div class="card-body">
                <?php if ($success): ?>
                <div class="alert alert-success">
                    <?php echo $success; ?>
                </div>
                <?php endif; ?>
                <?php if ($error):?>
                <div class="alert alert-danger">
                    <?php echo $error;?>
                </div>
                <?php endif; ?>
                <form method="POST" autocomplete="off">
                    <div class="mb-3">
                        <label class="form-label"> Patient ID</label>
                        <input type="text" name="patientId" class="form-control" required placeholder="Enter patient ID">
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Doctor Name</label>
                        <input type="text" name="doctorName" class="form-control" required placeholder="Enter doctor name">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Appointment Date</label>
                        <input type="date" name="appointmentDate" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Appointment Time</label>
                        <input type="time" name="appointmentTime" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select" required>
                            <option value="" disabled selected>Select status</option>
                            <option value="Pending">Pending</option>
                            <option value="Confirmed">Confirmed</option>
                            <option value="Cancelled">Cancelled</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Save Appointment</button>

                    <div class="text-center mt-3">
                        <a href="appointments.php" class="btn btn-secondary btn-sm">Back to Appointments</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>


<?php
include 'includes/footer.php';
?>