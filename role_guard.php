<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['role'])) {
    header("Location: login.php");
    exit();
}

$role = $_SESSION['role'];
$current_page = basename($_SERVER['PHP_SELF']);

//Pages each role can access 
$permissions = ['Administrator' => ['*'], 
'Clinician' => ['*'], 
'Data Officer' =>['patients.php', 'appointments.php',  'reports.php'],
'Lab Technician' =>['viral_load.php', 'samples.php', 'reports.php']
];

//allow Admin and Clinician
if (in_array($role, ['Administrator', 'Clinician'])){
    return; //access granted
}

if (!isset($permissions[$role])) {
    die("Access denied: role not recognized.");
}

//page restriction check
if (!in_array('*', $permissions[$role]) && !in_array($current_page, $permissions[$role])){
    http_response_code(403);
    echo "<h3 style='text-align:center;margin-top:50px;'> 403 - Access Denied </h3>";
    echo "<p style='text-align: center;'> You do not have permission to access this page. </p>";
    exit();
}
