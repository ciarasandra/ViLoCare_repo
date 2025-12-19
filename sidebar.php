<?php
// sidebar.php

// Debugging: Show errors
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Determine current page. For "index.php" returns "index"
$currentPage = basename($_SERVER['PHP_SELF'], '.php');

// Sidebar menu configuration
$menuItems = [
    [ 'id' => 'index',          'label' => 'Dashboard',     'icon' => '📊', 'href' => 'index.php' ],
    [ 'id' => 'patients',       'label' => 'Patients',      'icon' => '👥', 'href' => 'patients.php' ],
    [ 'id' => 'viral-load',     'label' => 'Viral Load',    'icon' => '🧪', 'href' => 'viral_load.php' ],
    [ 'id' => 'eac-sessions',   'label' => 'EAC Sessions',  'icon' => '💬', 'href' => 'eac_sessions.php' ],
    [ 'id' => 'appointments',   'label' => 'Appointments',  'icon' => '📅', 'href' => 'appointments.php' ],
    [ 'id' => 'samples',        'label' => 'Samples',       'icon' => '🔬', 'href' => 'samples.php' ],
    [ 'id' => 'reports',        'label' => 'Reports',       'icon' => '📈', 'href' => 'reports.php' ]
];
?>

<!-- Sidebar HTML -->
<nav id="sidebar" class="sidebar bg-primary text-white" style="width: 260px; min-height: 100vh; padding: 32px 16px;">
    <div class="mb-5">
        <h1 class="h4 fw-bold mb-1">ViLoCare</h1>
        <p class="text-light small mb-0">HIV VL Management</p>
    </div>
    <ul class="list-unstyled">
        <?php foreach ($menuItems as $item): 
            $active = ($currentPage === $item['id']) ? 'bg-primary text-white' : 'text-light';
        ?>
            <li class="mb-2">
                <a href="<?php echo $item['href']; ?>"
                   class="d-flex align-items-center px-4 py-3 rounded <?php echo $active; ?>"
                   style="text-decoration: none; transition: background 0.2s;">
                    <span class="mr-3" style="font-size:1.5rem;"><?php echo $item['icon']; ?></span>
                    <span><?php echo $item['label']; ?></span>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
</nav>