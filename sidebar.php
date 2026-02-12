<?php
// sidebar.php

// Debugging: Show errors
ini_set('display_errors', 1);
error_reporting(E_ALL);

//Get current user role

$role = $_SESSION['role'] ?? '';

$permissions = [
    'Administrator' => ['*'],
    'Clinician' => ['*'],
    'Data Officer' => ['patients.php', 'add_patient.php', 'editpatient.php', 'appointments.php', 'reports.php'],
    'Lab Technician' => ['viral_load.php', 'samples.php', 'reports.php']
];

function canAccess($role, $page, $permissions)
{
    if (!isset($permissions[$role])) return false;
    if (in_array('*', $permissions[$role])) return true;
    return in_array($page, $permissions[$role]);
}



// Determine current page. For "index.php" returns "index"
$currentPage = basename($_SERVER['PHP_SELF'], '.php');

// Sidebar menu configuration
$menuItems = [
    ['id' => 'index',          'label' => 'Dashboard',     'icon' => '📊', 'href' => 'index.php'],
    ['id' => 'patients',       'label' => 'Patients',      'icon' => '👥', 'href' => 'patients.php'],
    ['id' => 'viral-load',     'label' => 'Viral Load',    'icon' => '🧪', 'href' => 'viral_load.php'],
    ['id' => 'eac-sessions',   'label' => 'EAC Sessions',  'icon' => '💬', 'href' => 'eac_sessions.php'],
    ['id' => 'appointments',   'label' => 'Appointments',  'icon' => '📅', 'href' => 'appointments.php'],
    ['id' => 'samples',        'label' => 'Samples',       'icon' => '🔬', 'href' => 'samples.php'],
    ['id' => 'reports',        'label' => 'Reports',       'icon' => '📈', 'href' => 'reports.php']
];
?>

<!-- Sidebar HTML -->
<nav id="sidebar" class="sidebar bg-primary text-white">
    <div class="mb-5">
        <h1 class="h4 fw-bold mb-1">ViLoCare</h1>
        <p class="text-light small mb-0">HIV VL Management</p>
    </div>
    <ul class="list-unstyled">
        <?php foreach ($menuItems as $item):

            $page = $item['href'];
            $allowed = canAccess($role, $page, $permissions);
        ?>
            <li class="mb-2">
                <?php if ($allowed): ?>
                    <a href="<?= $item['href']; ?>" class="d-flex align-items-center px-4 py-3 rounded text-light">
                        <span class="me-3"><?= $item['icon']; ?></span>
                        <?= $item['label']; ?>
                    </a>
                <?php else: ?>
                    <a href="javascript:void(0)"
                        onclick="alert('You do not have permission to access this page');"
                        class="d-flex align-items-center px-4 py-3 rounded text-light opacity-50"
                        style="cursor:not-allowed;">
                        <span class="me-3"><?= $item['icon']; ?></span>
                        <?= $item['label']; ?>
                    </a>
                <?php endif; ?>
            </li>

        <?php endforeach; ?>
    </ul>
</nav>