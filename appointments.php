<?php
//appointments.php- Manage Appointments
session_start();
//redirect if not logged in
if (!isset($_SESSION['username'])){
    header("Location: login.php");
    exit();
}
require 'config.php';
require 'auth.php';
require 'role_guard.php';
include 'header.php';

//fetch all applointments
$sql = "SELECT appointmentId, patientinfo_id, doctorName, appointmentDate, appointmentTime, status FROM schedule ORDER BY appointmentDate DESC, appointmentTime DESC";
$result = mysqli_query($conn, $sql); 
?>
<main class="content">
    <div class="container-fluid p-0">
        <h1 class="h3 mb-3"> Appointments Management </h1>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex jusitfy-content-between align-items-center">
                        <h5 class="card-title mb-0"> All Appointments </h5>
                        <a href="new_appointment.php" class="btn btn-warning btn-sm">
                            <i class="align-middle" data-feather="calendar-plus"></i> New Appointment
                        </a>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover align-middle">
                                <thread>
                                    <tr>
                                        <th> #</th>
                                        <th> Patient ID </th>
                                        <th> Doctor Name </th>
                                        <th> Date </th>
                                        <th> Time </th>
                                        <th> Status </th>
                                        
                                        <th> Actions </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (mysqli_num_rows($result) > 0){
                                        $num = 1;
                                        while($row = mysqli_fetch_assoc($result)){
                                            ?>
                                            <tr>
                                                <td><?php echo $num++;?></td>
                                                <td><?php echo htmlspecialchars($row['patientinfo_id']);?></td>
                                                <td><?php echo htmlspecialchars($row['doctorName']);?></td>
                                                <td><?php echo htmlspecialchars($row['appointmentDate']);?></td> 
                                                <td><?php echo htmlspecialchars($row['appointmentTime']);?></td>
                                                <td>
                                                    <?php if ($row['status'] === "Confirmed") { ?>
                                                        <span class="badge bg-success"><?php echo $row['status']; ?></span>
                                                    <?php } elseif ($row['status'] === "pending") { ?>
                                                        <span class="badge bg-warning text-dark"> <?php echo $row['status']; ?></span>
                                                    <?php } else{ ?>
                                                        <span class="badge bg-secondary">default status text</span>
                                                    <?php } ?>
                                                </td>
                                                <td>
                                                    <a href="edit_appointment.php?id=<?php echo $row['appointmentId'];?>" class="btn btn-sm btn-outlin-info">Edit</a>
                                                    <a href="cancel_appointment.php?id=<?php echo $row['appointmentId'];?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Cancel this appointment?');">Cancel</a>
                                                </td>
                                            </tr>
                                            <?php    
                                        }
                                    } else {
                                        ?>
                                        <tr>
                                            <td colspan="7" class="text-center text-muted">No appointments found.</td>
                                        </tr>
                                        <?php 
                                    }?>
                                   
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php
include 'footer.php';
mysqli_close($conn)
?>