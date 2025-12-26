<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

require 'config.php';
require 'auth.php';
require 'role_guard.php';
include 'header.php';

$success = "";
$error = "";

// Fetch dropdown values for facility, county, state
$facilities = [];
$counties = [];
$states = [];

$result = mysqli_query($conn, "SELECT facility_id, facility_name FROM facilities");
while ($row = mysqli_fetch_assoc($result)) {
    $facilities[] = $row;
}

$result = mysqli_query($conn, "SELECT county_id, county_name FROM counties");
while ($row = mysqli_fetch_assoc($result)) {
    $counties[] = $row;
}

$result = mysqli_query($conn, "SELECT state_id, state_name FROM states");
while ($row = mysqli_fetch_assoc($result)) {
    $states[] = $row;
}

// When the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $fullName = mysqli_real_escape_string($conn, $_POST['fullName']);
    $gender = mysqli_real_escape_string($conn, $_POST['gender']);
    $dateOfBirth = mysqli_real_escape_string($conn, $_POST['dateOfBirth']);
    $age = mysqli_real_escape_string($conn, $_POST['age']);
    $contact = mysqli_real_escape_string($conn, $_POST['contact']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $art_number = mysqli_real_escape_string($conn, $_POST['art_number']);
    $art_start_date = mysqli_real_escape_string($conn, $_POST['art_start_date']);
    $current_regimen = mysqli_real_escape_string($conn, $_POST['current_regimen']);
    $regimen_start_date = mysqli_real_escape_string($conn, $_POST['regimen_start_date']);
    $has_regimen_changed = isset($_POST['has_regimen_changed']) ? 1 : 0;
    $regimen_change_date = mysqli_real_escape_string($conn, $_POST['regimen_change_date']);
    $is_pregnant = isset($_POST['is_pregnant']) ? 1 : 0;
    $is_breastfeeding = isset($_POST['is_breastfeeding']) ? 1 : 0;
    $arv_adherence = mysqli_real_escape_string($conn, $_POST['arv_adherence']);
    $funding_source = mysqli_real_escape_string($conn, $_POST['funding_source']);
    $implementing_partner = mysqli_real_escape_string($conn, $_POST['implementing_partner']);
    $facility_id = mysqli_real_escape_string($conn, $_POST['facility_id']);
    $county_id = mysqli_real_escape_string($conn, $_POST['county_id']);
    $state_id = mysqli_real_escape_string($conn, $_POST['state_id']);
    $sample_type = mysqli_real_escape_string($conn, $_POST['sample_type']);
    $last_sample_collection_date = mysqli_real_escape_string($conn, $_POST['last_sample_collection_date']);
    $last_vl_result = mysqli_real_escape_string($conn, $_POST['last_vl_result']);
    $last_vl_result_date = mysqli_real_escape_string($conn, $_POST['last_vl_result_date']);
    $notes = mysqli_real_escape_string($conn, $_POST['notes']);

    // Insert into database
    $sql = "INSERT INTO patient_info (
        fullName, gender, dateOfBirth, age, contact, address, art_number, art_start_date, current_regimen,
        regimen_start_date, has_regimen_changed, regimen_change_date, is_pregnant, is_breastfeeding,
        arv_adherence, funding_source, implementing_partner, facility_id, county_id, state_id, sample_type,
        last_sample_collection_date, last_vl_result, last_vl_result_date, notes
    ) VALUES (
        '$fullName', '$gender', '$dateOfBirth', '$age', '$contact', '$address', '$art_number', '$art_start_date', '$current_regimen',
        '$regimen_start_date', '$has_regimen_changed', '$regimen_change_date', '$is_pregnant', '$is_breastfeeding',
        '$arv_adherence', '$funding_source', '$implementing_partner', '$facility_id', '$county_id', '$state_id', '$sample_type',
        '$last_sample_collection_date', '$last_vl_result', '$last_vl_result_date', '$notes'
    )";

    if (mysqli_query($conn, $sql)) {
        $success = "Patient added successfully!";
    } else {
        $error = "Error: " . mysqli_error($conn);
    }
}
?>

<main class="content">
    <div class="container-fuild p-0">
        <h1 class="h3 mb-3">Add New Patient</h1>
        <?php if ($success): ?>
            <div class="alert alert-success"><?php echo $success; ?></div>
        <?php endif; ?>
        <?php if ($error): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        <div class="card">
            <div class="card-body">
                <form method="POST" autocomplete="off">
                    <div class="mb-3">
                        <label class="form-label">Full Name</label>
                        <input type="text" name="fullName" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Gender</label>
                        <select name="gender" class="form-control" required>
                            <option value="">Select gender</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Date of Birth</label>
                        <input type="date" name="dateOfBirth" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Age</label>
                        <input type="number" name="age" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Contact</label>
                        <input type="text" name="contact" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Address</label>
                        <textarea name="address" class="form-control" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">ART Number</label>
                        <input type="text" name="art_number" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">ART Start Date</label>
                        <input type="date" name="art_start_date" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Current Regimen</label>
                        <input type="text" name="current_regimen" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Regimen Start Date</label>
                        <input type="date" name="regimen_start_date" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Has Regimen Changed?</label>
                        <input type="checkbox" name="has_regimen_changed" value="1">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Regimen Change Date</label>
                        <input type="date" name="regimen_change_date" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Is Pregnant?</label>
                        <input type="checkbox" name="is_pregnant" value="1">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Is Breastfeeding?</label>
                        <input type="checkbox" name="is_breastfeeding" value="1">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">ARV Adherence</label>
                        <input type="text" name="arv_adherence" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Funding Source</label>
                        <input type="text" name="funding_source" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Implementing Partner</label>
                        <input type="text" name="implementing_partner" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Facility</label>
                        <select name="facility_id" class="form-control">
                            <option value="">Select Facility</option>
                            <?php foreach ($facilities as $facility): ?>
                                <option value="<?php echo $facility['facility_id']; ?>">
                                    <?php echo htmlspecialchars($facility['facility_name']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">County</label>
                        <select name="county_id" class="form-control">
                            <option value="">Select County</option>
                            <?php foreach ($counties as $county): ?>
                                <option value="<?php echo $county['county_id']; ?>">
                                    <?php echo htmlspecialchars($county['county_name']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">State</label>
                        <select name="state_id" class="form-control">
                            <option value="">Select State</option>
                            <?php foreach ($states as $state): ?>
                                <option value="<?php echo $state['state_id']; ?>">
                                    <?php echo htmlspecialchars($state['state_name']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Sample Type</label>
                        <input type="text" name="sample_type" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Last Sample Collection Date</label>
                        <input type="date" name="last_sample_collection_date" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Last VL Result (cp/mL)</label>
                        <input type="number" name="last_vl_result" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Last VL Result Date</label>
                        <input type="date" name="last_vl_result_date" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Notes</label>
                        <textarea name="notes" class="form-control"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Save Patient</button>
                    <a href="patients.php" class="btn btn-secondary">Cancel</a>
                </form>
                <script>
                    document.addEventListener("DOMContentLoaded", function () {
                        const form = document.querySelector("form");
                        <?php if (!empty($success)) { ?>
                            form.reset();
                        <?php } ?>
                    });
                </script>
            </div>
        </div>
    </div>
</main>

<?php
include 'footer.php';
?>