<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

require 'config.php';

include 'header.php';

if (!isset($_GET['id'])) {
    echo "<div class='alert alert-danger'>No patient selected.</div>";
    exit();
}

$patientinfo_id = mysqli_real_escape_string($conn, $_GET['id']);

// Fetch patient
$sql = "SELECT * FROM patient_info WHERE patientinfo_id = '$patientinfo_id'";
$result = mysqli_query($conn, $sql);

if (!$result || mysqli_num_rows($result) === 0) {
    echo "<div class='alert alert-danger'>Patient not found.</div>";
    exit();
}

$patient = mysqli_fetch_assoc($result);

$success = "";
$error = "";

// If form submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullName = mysqli_real_escape_string($conn, $_POST['fullName']);
    $gender = mysqli_real_escape_string($conn, $_POST['gender']);
    $dateOfBirth = mysqli_real_escape_string($conn, $_POST['dateOfBirth']);
    $contact = mysqli_real_escape_string($conn, $_POST['contact']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);

    $updateSql = "UPDATE patient_info SET 
                    fullName = '$fullName',
                    gender = '$gender',
                    dateOfBirth = '$dateOfBirth',
                    contact = '$contact',
                    address = '$address'
                  WHERE patientinfo_id = '$patientinfo_id'";

    if (mysqli_query($conn, $updateSql)) {
        $success = "Patient details updated successfully!";
        // refresh patient data after update
        $res2 = mysqli_query($conn, "SELECT * FROM patient_info WHERE patientinfo_id = '$patientinfo_id'");
        if ($res2 && mysqli_num_rows($res2) > 0) {
            $patient = mysqli_fetch_assoc($res2);
        }
    } else {
        $error = "Error updating record: " . mysqli_error($conn);
    }
}
?>

<main class="content">
    <div class="container-fluid p-0">
        <h1 class="h3 mb-3">Edit Patient</h1>

        <?php
        if (!empty($success)) {
            echo '<div class="alert alert-success">'.htmlspecialchars($success).'</div>';
        }

        if (!empty($error)) {
            echo '<div class="alert alert-danger">'.htmlspecialchars($error).'</div>';
        }
        ?>

        <div class="card">
            <div class="card-body">
                <form method="POST" autocomplete="off">

                    <div class="mb-3">
                        <label class="form-label">Full Name</label>
                        <input type="text" name="fullName" class="form-control" value="<?php echo htmlspecialchars($patient['fullName']); ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Gender</label>
                        <select name="gender" class="form-control" required>
                            <option value="Male" <?php echo ($patient['gender'] == 'Male') ? 'selected' : ''; ?>>Male</option>
                            <option value="Female" <?php echo ($patient['gender'] == 'Female') ? 'selected' : ''; ?>>Female</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Age</label>
                        <input type="text" name="age" class="form-control" value="<?php echo htmlspecialchars($patient['Age']); ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Contact</label>
                        <input type="text" name="contact" class="form-control" value="<?php echo htmlspecialchars($patient['contact']); ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Address</label>
                        <textarea name="address" class="form-control" required><?php echo htmlspecialchars($patient['address']); ?></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary">Update Patient</button>
                    <a href="patients.php" class="btn btn-secondary">Cancel</a>

                </form>
                <script>
                    document.addEventListener("DOMContentLoaded", function () {
                        <?php if (!empty($success)){ ?>
                            document.querySelector("form").reset();
                            <?php 
                        } ?>
                    });
                </script>
            </div>
        </div>
    </div>
</main>

<?php
include 'footer.php';
?>