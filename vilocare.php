<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>ViLoCare - HIV Patient Viral Load Management System</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
  <style id="app-style">
    :root {
      --primary-color: #2563eb;
      --secondary-color: #10b981;
      --accent-color: #f59e0b;
      --danger-color: #ef4444;
      --warning-color: #f97316;
      --success-color: #22c55e;
    }
    
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-color: #f8fafc;
      min-height: 100vh;
    }
    
    .login-container {
      background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
      height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    
    .login-card {
      background: white;
      border-radius: 12px;
      box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
      width: 100%;
      max-width: 450px;
      padding: 2rem;
    }
    
    .login-logo {
      text-align: center;
      margin-bottom: 2rem;
    }
    
    .login-logo img {
      height: 80px;
    }
    
    .btn-primary {
      background-color: var(--primary-color);
      border-color: var(--primary-color);
    }
    
    .btn-primary:hover {
      background-color: #1d4ed8;
      border-color: #1d4ed8;
    }
    
    .btn-success {
      background-color: var(--success-color);
      border-color: var(--success-color);
    }
    
    .btn-success:hover {
      background-color: #15803d;
      border-color: #15803d;
    }
    
    .sidebar {
      background-color: #1e293b;
      color: #f8fafc;
      width: 280px;
      position: fixed;
      top: 0;
      left: 0;
      height: 100vh;
      z-index: 1000;
      padding-top: 1rem;
      transition: all 0.3s;
    }
    
    .sidebar-collapsed {
      width: 70px;
    }
    
    .sidebar-brand {
      padding: 1rem 1.5rem;
      display: flex;
      align-items: center;
      font-size: 1.25rem;
      font-weight: 600;
      color: white;
      text-decoration: none;
    }
    
    .sidebar-brand img {
      height: 40px;
      margin-right: 0.75rem;
    }
    
    .sidebar-menu {
      padding: 1rem 0;
    }
    
    .sidebar-header {
      font-size: 0.75rem;
      text-transform: uppercase;
      letter-spacing: 0.1em;
      color: #94a3b8;
      padding: 0.5rem 1.5rem;
      margin-top: 1rem;
    }
    
    .sidebar-item {
      display: block;
      padding: 0.75rem 1.5rem;
      color: #e2e8f0;
      text-decoration: none;
      display: flex;
      align-items: center;
      border-left: 4px solid transparent;
      transition: all 0.2s;
    }
    
    .sidebar-item:hover {
      background-color: #334155;
      color: white;
    }
    
    .sidebar-item.active {
      background-color: #334155;
      color: white;
      border-left-color: var(--secondary-color);
    }
    
    .sidebar-item i {
      margin-right: 0.75rem;
      width: 20px;
      text-align: center;
    }
    
    .main-content {
      margin-left: 280px;
      padding: 1rem;
      transition: all 0.3s;
    }
    
    .main-content-expanded {
      margin-left: 70px;
    }
    
    .top-navbar {
      background-color: white;
      padding: 1rem;
      box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
      margin-bottom: 1rem;
      border-radius: 0.5rem;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    
    .page-title {
      font-size: 1.5rem;
      font-weight: 600;
      color: #1e293b;
      margin: 0;
    }
    
    .user-dropdown img {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      margin-right: 0.5rem;
    }
    
    .card {
      border: none;
      border-radius: 0.5rem;
      box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
      margin-bottom: 1.5rem;
    }
    
    .card-header {
      background-color: white;
      border-bottom: 1px solid rgba(0, 0, 0, 0.05);
      font-weight: 600;
    }
    
    .stats-card {
      background-color: white;
      border-radius: 0.5rem;
      box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
      padding: 1.5rem;
      margin-bottom: 1.5rem;
      position: relative;
      overflow: hidden;
    }
    
    .stats-card .icon {
      position: absolute;
      right: 1rem;
      top: 1rem;
      font-size: 2rem;
      opacity: 0.2;
    }
    
    .stats-card .number {
      font-size: 2rem;
      font-weight: 700;
      margin-bottom: 0.5rem;
    }
    
    .stats-card .label {
      color: #64748b;
      font-size: 0.875rem;
    }
    
    .stats-card.primary {
      background-color: #eff6ff;
      color: var(--primary-color);
    }
    
    .stats-card.success {
      background-color: #f0fdf4;
      color: var(--success-color);
    }
    
    .stats-card.warning {
      background-color: #fffbeb;
      color: var(--warning-color);
    }
    
    .stats-card.danger {
      background-color: #fef2f2;
      color: var(--danger-color);
    }
    
    .form-section {
      margin-bottom: 2rem;
    }
    
    .form-section-title {
      font-size: 1.25rem;
      font-weight: 600;
      margin-bottom: 1rem;
      padding-bottom: 0.5rem;
      border-bottom: 1px solid #e2e8f0;
    }
    
    .form-label {
      font-weight: 500;
    }
    
    .required-field::after {
      content: "*";
      color: #ef4444;
      margin-left: 0.25rem;
    }
    
    .patient-profile {
      background-color: white;
      border-radius: 0.5rem;
      box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
      padding: 2rem;
    }
    
    .patient-avatar {
      width: 100px;
      height: 100px;
      border-radius: 50%;
      background-color: #e2e8f0;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 2.5rem;
      color: #94a3b8;
      margin-bottom: 1rem;
    }
    
    .patient-id {
      background-color: #f8fafc;
      padding: 0.25rem 0.5rem;
      border-radius: 0.25rem;
      font-size: 0.875rem;
      color: #64748b;
    }
    
    .profile-section {
      margin-bottom: 1.5rem;
    }
    
    .profile-section-title {
      font-size: 1.125rem;
      font-weight: 600;
      margin-bottom: 1rem;
      padding-bottom: 0.5rem;
      border-bottom: 1px solid #e2e8f0;
    }
    
    .timeline {
      position: relative;
      padding-left: 1.5rem;
      margin-left: 1rem;
    }
    
    .timeline:before {
      content: "";
      position: absolute;
      left: 0;
      top: 0;
      height: 100%;
      width: 2px;
      background-color: #e2e8f0;
    }
    
    .timeline-item {
      position: relative;
      margin-bottom: 1.5rem;
      padding-bottom: 1.5rem;
    }
    
    .timeline-dot {
      position: absolute;
      left: -1.75rem;
      top: 0.25rem;
      width: 1rem;
      height: 1rem;
      border-radius: 50%;
      background-color: var(--primary-color);
    }
    
    .timeline-date {
      font-size: 0.875rem;
      color: #64748b;
      margin-bottom: 0.25rem;
    }
    
    .timeline-content {
      background-color: #f8fafc;
      padding: 1rem;
      border-radius: 0.5rem;
    }
    
    .timeline-title {
      font-weight: 600;
      margin-bottom: 0.5rem;
    }
    
    .high-viral-load {
      color: var(--danger-color);
    }
    
    .low-viral-load {
      color: var(--success-color);
    }
    
    .alert-due {
      background-color: #fffbeb;
      border-left: 4px solid var(--warning-color);
      padding: 1rem;
      margin-bottom: 1.5rem;
      border-radius: 0.25rem;
    }
    
    .upload-box {
      border: 2px dashed #e2e8f0;
      border-radius: 0.5rem;
      padding: 2rem;
      text-align: center;
      margin-bottom: 1.5rem;
      cursor: pointer;
      transition: all 0.2s;
    }
    
    .upload-box:hover {
      border-color: var(--primary-color);
    }
    
    .upload-icon {
      font-size: 3rem;
      color: #94a3b8;
      margin-bottom: 1rem;
    }
    
    .file-list {
      margin-top: 1rem;
    }
    
    .file-item {
      display: flex;
      align-items: center;
      padding: 0.5rem 0.75rem;
      background-color: #f8fafc;
      border-radius: 0.25rem;
      margin-bottom: 0.5rem;
    }
    
    .file-item-icon {
      margin-right: 0.5rem;
      color: #64748b;
    }
    
    .file-item-name {
      flex-grow: 1;
      font-size: 0.875rem;
      margin-right: 0.5rem;
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
    }
    
    .file-item-actions {
      display: flex;
    }
    
    .file-item-action {
      padding: 0.25rem;
      color: #64748b;
      cursor: pointer;
    }
    
    .file-item-action:hover {
      color: var(--primary-color);
    }
    
    .view-tab-container {
      display: none;
    }
    
    .view-tab-container.active {
      display: block;
    }
    
    @media (max-width: 992px) {
      .sidebar {
        width: 70px;
      }
      
      .sidebar .sidebar-brand span,
      .sidebar .sidebar-item span {
        display: none;
      }
      
      .sidebar-header {
        display: none;
      }
      
      .main-content {
        margin-left: 70px;
      }
    }
    
    @media (max-width: 768px) {
      .sidebar {
        width: 0;
      }
      
      .sidebar.show {
        width: 280px;
      }
      
      .sidebar.show .sidebar-brand span,
      .sidebar.show .sidebar-item span {
        display: inline;
      }
      
      .sidebar.show .sidebar-header {
        display: block;
      }
      
      .main-content {
        margin-left: 0;
      }
    }
  </style>
</head>
<body>
  <!-- Login Screen -->
  <div id="login-screen" class="login-container">
    <div class="login-card">
      <div class="login-logo">
        <img src="vilocarelogo.png" alt="ViLoCare Logo">
        <h2 class="mt-2">ViLoCare</h2>
        <p class="text-muted">HIV Patient Viral Load Management System</p>
      </div>
      <form id="login-form">
        <div class="mb-3">
          <label for="username" class="form-label">Username</label>
          <input type="text" class="form-control" id="username" required>
        </div>
        <div class="mb-3">
          <label for="password" class="form-label">Password</label>
          <input type="password" class="form-control" id="password" required>
        </div>
        <div class="mb-3">
          <label for="role" class="form-label">Role</label>
          <select class="form-select" id="role" required>
            <option value="" selected disabled>Select your role</option>
            <option value="clinician">Clinician</option>
            <option value="lab">Lab Technician</option>
            <option value="data">Data Officer</option>
            <option value="admin">Administrator</option>
          </select>
        </div>
        <div class="mb-3 form-check">
          <input type="checkbox" class="form-check-input" id="remember-me">
          <label class="form-check-label" for="remember-me">Remember me</label>
        </div>
        <button type="submit" class="btn btn-primary w-100">Login</button>
        <div class="text-center mt-3">
          <a href="javascript:void(0)" class="text-decoration-none">Forgot password?</a>
        </div>
      </form>
    </div>
  </div>

  <!-- Main Application -->
  <div id="app" style="display: none;">
    <!-- Sidebar Navigation -->
    <div class="sidebar">
      <a href="javascript:void(0)" class="sidebar-brand">
        <img src="https://cdn.pixabay.com/photo/2017/05/15/23/47/aids-ribbon-2316539_960_720.png" alt="ViLoCare Logo">
        <span>ViLoCare</span>
      </a>
      
      <div class="sidebar-menu">
        <div class="sidebar-header">
          <span>MAIN NAVIGATION</span>
        </div>
        
        <a href="javascript:void(0)" class="sidebar-item active" data-view="dashboard">
          <i class="fas fa-chart-line"></i>
          <span>Dashboard</span>
        </a>
        
        <a href="javascript:void(0)" class="sidebar-item" data-view="patients">
          <i class="fas fa-users"></i>
          <span>Patient List</span>
        </a>
        
        <a href="javascript:void(0)" class="sidebar-item" data-view="data-entry">
          <i class="fas fa-file-medical-alt"></i>
          <span>Data Entry</span>
        </a>
        
        <a href="javascript:void(0)" class="sidebar-item" data-view="import">
          <i class="fas fa-file-import"></i>
          <span>Import Data</span>
        </a>
        
        <div class="sidebar-header">
          <span>MANAGEMENT</span>
        </div>
        
        <a href="javascript:void(0)" class="sidebar-item" data-view="reports">
          <i class="fas fa-chart-bar"></i>
          <span>Reports</span>
        </a>
        
        <a href="javascript:void(0)" class="sidebar-item" data-view="settings">
          <i class="fas fa-cog"></i>
          <span>Settings</span>
        </a>
      </div>
    </div>

    <!-- Main Content Area -->
    <div class="main-content">
      <div class="top-navbar">
        <div class="d-flex align-items-center">
          <button id="toggle-sidebar" class="btn btn-sm btn-light me-2">
            <i class="fas fa-bars"></i>
          </button>
          <h1 class="page-title" id="current-view-title">Dashboard</h1>
        </div>
        
        <div class="user-dropdown dropdown">
          <button class="btn dropdown-toggle d-flex align-items-center" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
            <img src="https://cdn.pixabay.com/photo/2016/08/08/09/17/avatar-1577909_960_720.png" alt="User Avatar">
            <div class="ms-2 d-none d-sm-block">
              <div class="fw-bold">Jane Doe</div>
              <div class="small text-muted" id="user-role">Clinician</div>
            </div>
          </button>
          <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
            <li><a class="dropdown-item" href="javascript:void(0)"><i class="fas fa-user me-2"></i> My Profile</a></li>
            <li><a class="dropdown-item" href="javascript:void(0)"><i class="fas fa-cog me-2"></i> Settings</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="javascript:void(0)" id="logout-btn"><i class="fas fa-sign-out-alt me-2"></i> Logout</a></li>
          </ul>
        </div>
      </div>

      <!-- Dashboard View -->
      <div id="dashboard-view" class="view-tab-container active">
        <div class="row">
          <div class="col-lg-3 col-md-6">
            <div class="stats-card primary">
              <i class="fas fa-users icon"></i>
              <div class="number">1,247</div>
              <div class="label">Total Patients</div>
            </div>
          </div>
          
          <div class="col-lg-3 col-md-6">
            <div class="stats-card success">
              <i class="fas fa-vial icon"></i>
              <div class="number">342</div>
              <div class="label">Samples Collected</div>
            </div>
          </div>
          
          <div class="col-lg-3 col-md-6">
            <div class="stats-card warning">
              <i class="fas fa-calendar-check icon"></i>
              <div class="number">98</div>
              <div class="label">Viral Load Tests Due</div>
            </div>
          </div>
          
          <div class="col-lg-3 col-md-6">
            <div class="stats-card danger">
              <i class="fas fa-exclamation-triangle icon"></i>
              <div class="number">24</div>
              <div class="label">High Viral Load Cases</div>
            </div>
          </div>
        </div>
        
        <div class="row">
          <div class="col-lg-8">
            <div class="card">
              <div class="card-header d-flex justify-content-between align-items-center">
                <span>Patient Demographics</span>
                <div class="d-flex">
                  <div class="input-group input-group-sm">
                    <input type="text" class="form-control" id="dashboard-date-range" placeholder="Date range">
                    <button class="btn btn-outline-secondary" type="button">
                      <i class="fas fa-calendar"></i>
                    </button>
                  </div>
                </div>
              </div>
              <div class="card-body">
                <canvas id="demographics-chart" height="300"></canvas>
              </div>
            </div>
          </div>
          
          <div class="col-lg-4">
            <div class="card">
              <div class="card-header">
                <span>Viral Load Status</span>
              </div>
              <div class="card-body">
                <canvas id="viral-load-status-chart" height="250"></canvas>
              </div>
            </div>
            
            <div class="card">
              <div class="card-header">
                <span>Sample Rejection Reasons</span>
              </div>
              <div class="card-body">
                <canvas id="rejection-reasons-chart" height="250"></canvas>
              </div>
            </div>
          </div>
        </div>
        
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header d-flex justify-content-between align-items-center">
                <span>Patients Due for Services</span>
                <a href="javascript:void(0)" class="btn btn-sm btn-primary">View All</a>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-striped">
                    <thead>
                      <tr>
                        <th>Patient ID</th>
                        <th>Name</th>
                        <th>Age/Sex</th>
                        <th>Service Due</th>
                        <th>Due Date</th>
                        <th>Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>VLC-2025-001</td>
                        <td>John Smith</td>
                        <td>34/M</td>
                        <td><span class="badge bg-warning">Viral Load Test</span></td>
                        <td>2025-04-15</td>
                        <td>
                          <a href="javascript:void(0)" class="btn btn-sm btn-outline-primary" data-patient-id="VLC-2025-001">View</a>
                        </td>
                      </tr>
                      <tr>
                        <td>VLC-2025-042</td>
                        <td>Sarah Johnson</td>
                        <td>28/F</td>
                        <td><span class="badge bg-danger">EAC Session 2</span></td>
                        <td>2025-04-12</td>
                        <td>
                          <a href="javascript:void(0)" class="btn btn-sm btn-outline-primary" data-patient-id="VLC-2025-042">View</a>
                        </td>
                      </tr>
                      <tr>
                        <td>VLC-2025-108</td>
                        <td>Michael Thomas</td>
                        <td>12/M</td>
                        <td><span class="badge bg-info">Repeat Test</span></td>
                        <td>2025-04-18</td>
                        <td>
                          <a href="javascript:void(0)" class="btn btn-sm btn-outline-primary" data-patient-id="VLC-2025-108">View</a>
                        </td>
                      </tr>
                      <tr>
                        <td>VLC-2025-156</td>
                        <td>Emily Davis</td>
                        <td>43/F</td>
                        <td><span class="badge bg-warning">Viral Load Test</span></td>
                        <td>2025-04-20</td>
                        <td>
                          <a href="javascript:void(0)" class="btn btn-sm btn-outline-primary" data-patient-id="VLC-2025-156">View</a>
                        </td>
                      </tr>
                      <tr>
                        <td>VLC-2025-203</td>
                        <td>David Wilson</td>
                        <td>17/M</td>
                        <td><span class="badge bg-danger">EAC Session 1</span></td>
                        <td>2025-04-11</td>
                        <td>
                          <a href="javascript:void(0)" class="btn btn-sm btn-outline-primary" data-patient-id="VLC-2025-203">View</a>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Patient List View -->
      <div id="patients-view" class="view-tab-container">
        <div class="card">
          <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
              <h5 class="mb-0">Patient List</h5>
              <div>
                <button class="btn btn-success me-2" data-bs-toggle="modal" data-bs-target="#newPatientModal">
                  <i class="fas fa-plus"></i> Add New Patient
                </button>
                <button class="btn btn-outline-secondary">
                  <i class="fas fa-download"></i> Export
                </button>
              </div>
            </div>
          </div>
          <div class="card-body">
            <div class="row mb-3">
              <div class="col-md-3">
                <input type="text" class="form-control" placeholder="Search by ID or Name">
              </div>
              <div class="col-md-2">
                <select class="form-select">
                  <option value="" selected>All Age Groups</option>
                  <option value="under15">Under 15</option>
                  <option value="15plus">15 and Above</option>
                </select>
              </div>
              <div class="col-md-2">
                <select class="form-select">
                  <option value="" selected>All Genders</option>
                  <option value="M">Male</option>
                  <option value="F">Female</option>
                </select>
              </div>
              <div class="col-md-3">
                <select class="form-select">
                  <option value="" selected>All Test Status</option>
                  <option value="due">Test Due</option>
                  <option value="eac">EAC Required</option>
                  <option value="suppressed">Suppressed</option>
                  <option value="unsuppressed">Unsuppressed</option>
                </select>
              </div>
              <div class="col-md-2">
                <button class="btn btn-primary w-100">
                  <i class="fas fa-search"></i> Filter
                </button>
              </div>
            </div>
            
            <div class="table-responsive">
              <table class="table table-striped" id="patients-table">
                <thead>
                  <tr>
                    <th>Patient ID</th>
                    <th>Name</th>
                    <th>Age</th>
                    <th>Sex</th>
                    <th>ART Start Date</th>
                    <th>Last VL Test</th>
                    <th>Last VL Result</th>
                    <th>Next Test Due</th>
                    <th>Status</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>VLC-2025-001</td>
                    <td>John Smith</td>
                    <td>34</td>
                    <td>M</td>
                    <td>2022-06-15</td>
                    <td>2024-10-20</td>
                    <td class="low-viral-load">150 copies/ml</td>
                    <td>2025-04-15</td>
                    <td><span class="badge bg-warning">Test Due Soon</span></td>
                    <td>
                      <div class="btn-group">
                        <button class="btn btn-sm btn-outline-primary" data-patient-id="VLC-2025-001">View</button>
                        <button class="btn btn-sm btn-outline-secondary">Edit</button>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td>VLC-2025-042</td>
                    <td>Sarah Johnson</td>
                    <td>28</td>
                    <td>F</td>
                    <td>2021-03-10</td>
                    <td>2025-02-05</td>
                    <td class="high-viral-load">4,500 copies/ml</td>
                    <td>2025-04-12</td>
                    <td><span class="badge bg-danger">EAC Required</span></td>
                    <td>
                      <div class="btn-group">
                        <button class="btn btn-sm btn-outline-primary" data-patient-id="VLC-2025-042">View</button>
                        <button class="btn btn-sm btn-outline-secondary">Edit</button>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td>VLC-2025-108</td>
                    <td>Michael Thomas</td>
                    <td>12</td>
                    <td>M</td>
                    <td>2023-09-22</td>
                    <td>2025-01-18</td>
                    <td class="high-viral-load">2,300 copies/ml</td>
                    <td>2025-04-18</td>
                    <td><span class="badge bg-info">Repeat Test</span></td>
                    <td>
                      <div class="btn-group">
                        <button class="btn btn-sm btn-outline-primary" data-patient-id="VLC-2025-108">View</button>
                        <button class="btn btn-sm btn-outline-secondary">Edit</button>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td>VLC-2025-156</td>
                    <td>Emily Davis</td>
                    <td>43</td>
                    <td>F</td>
                    <td>2020-11-05</td>
                    <td>2024-10-20</td>
                    <td class="low-viral-load">Undetectable</td>
                    <td>2025-04-20</td>
                    <td><span class="badge bg-warning">Test Due Soon</span></td>
                    <td>
                      <div class="btn-group">
                        <button class="btn btn-sm btn-outline-primary" data-patient-id="VLC-2025-156">View</button>
                        <button class="btn btn-sm btn-outline-secondary">Edit</button>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td>VLC-2025-203</td>
                    <td>David Wilson</td>
                    <td>17</td>
                    <td>M</td>
                    <td>2024-01-15</td>
                    <td>2025-03-01</td>
                    <td class="high-viral-load">5,200 copies/ml</td>
                    <td>2025-04-11</td>
                    <td><span class="badge bg-danger">EAC Required</span></td>
                    <td>
                      <div class="btn-group">
                        <button class="btn btn-sm btn-outline-primary" data-patient-id="VLC-2025-203">View</button>
                        <button class="btn btn-sm btn-outline-secondary">Edit</button>
                      </div>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
            
            <nav aria-label="Page navigation">
              <ul class="pagination justify-content-end">
                <li class="page-item disabled">
                  <a class="page-link" href="javascript:void(0)" tabindex="-1">Previous</a>
                </li>
                <li class="page-item active"><a class="page-link" href="javascript:void(0)">1</a></li>
                <li class="page-item"><a class="page-link" href="javascript:void(0)">2</a></li>
                <li class="page-item"><a class="page-link" href="javascript:void(0)">3</a></li>
                <li class="page-item">
                  <a class="page-link" href="javascript:void(0)">Next</a>
                </li>
              </ul>
            </nav>
          </div>
        </div>
      </div>

      <!-- Patient Profile (will be shown when a patient is selected) -->
      <div id="patient-profile-view" class="view-tab-container">
        <div class="d-flex align-items-center mb-3">
          <button class="btn btn-outline-secondary me-2" id="back-to-patients">
            <i class="fas fa-arrow-left"></i> Back to List
          </button>
          <h4 class="mb-0">Patient Profile</h4>
        </div>
        
        <div class="row">
          <div class="col-lg-4">
            <div class="patient-profile">
              <div class="text-center">
                <div class="patient-avatar mx-auto">
                  <i class="fas fa-user"></i>
                </div>
                <h4 id="patient-name">Sarah Johnson</h4>
                <div class="patient-id mb-2" id="patient-id">VLC-2025-042</div>
                <div class="d-flex justify-content-center gap-2">
                  <button class="btn btn-sm btn-outline-primary">
                    <i class="fas fa-edit"></i> Edit Profile
                  </button>
                  <button class="btn btn-sm btn-outline-secondary">
                    <i class="fas fa-print"></i> Print
                  </button>
                </div>
              </div>
              
              <div class="profile-section mt-4">
                <h5 class="profile-section-title">Personal Information</h5>
                <div class="row">
                  <div class="col-6 mb-2">
                    <div class="text-muted small">Age</div>
                    <div id="patient-age">28</div>
                  </div>
                  <div class="col-6 mb-2">
                    <div class="text-muted small">Sex</div>
                    <div id="patient-sex">Female</div>
                  </div>
                  <div class="col-6 mb-2">
                    <div class="text-muted small">Date of Birth</div>
                    <div id="patient-dob">1997-05-12</div>
                  </div>
                  <div class="col-6 mb-2">
                    <div class="text-muted small">Phone</div>
                    <div id="patient-phone">+211 92 123 4567</div>
                  </div>
                  <div class="col-12 mb-2">
                    <div class="text-muted small">Address</div>
                    <div id="patient-address">123 Main Street, Juba</div>
                  </div>
                </div>
              </div>
              
              <div class="profile-section">
                <h5 class="profile-section-title">Treatment Information</h5>
                <div class="row">
                  <div class="col-6 mb-2">
                    <div class="text-muted small">ART Start Date</div>
                    <div id="patient-art-start">2021-03-10</div>
                  </div>
                  <div class="col-6 mb-2">
                    <div class="text-muted small">Current Regimen</div>
                    <div id="patient-regimen">TDF/3TC/DTG</div>
                  </div>
                  <div class="col-6 mb-2">
                    <div class="text-muted small">Last Clinic Visit</div>
                    <div id="patient-last-visit">2025-03-15</div>
                  </div>
                  <div class="col-6 mb-2">
                    <div class="text-muted small">Next Appointment</div>
                    <div id="patient-next-appt">2025-04-15</div>
                  </div>
                </div>
              </div>
              
              <div class="alert-due">
                <div class="d-flex align-items-center">
                  <i class="fas fa-exclamation-triangle text-warning me-2"></i>
                  <div>
                    <strong>EAC Session 2 Due</strong>
                    <div class="small">Due date: April 12, 2025</div>
                  </div>
                </div>
                <button class="btn btn-warning btn-sm mt-2 w-100" data-bs-toggle="modal" data-bs-target="#scheduleServiceModal">
                  Schedule Session
                </button>
              </div>
            </div>
          </div>
          
          <div class="col-lg-8">
            <div class="card mb-3">
              <div class="card-header">
                <ul class="nav nav-tabs card-header-tabs">
                  <li class="nav-item">
                    <a class="nav-link active" href="#viral-load-history" data-bs-toggle="tab">Viral Load History</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="#treatment-history" data-bs-toggle="tab">Treatment History</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="#eac-history" data-bs-toggle="tab">EAC History</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="#notes" data-bs-toggle="tab">Notes</a>
                  </li>
                </ul>
              </div>
              <div class="card-body">
                <div class="tab-content">
                  <div class="tab-pane fade show active" id="viral-load-history">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                      <h6 class="mb-0">Viral Load Results</h6>
                      <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addViralLoadModal">
                        <i class="fas fa-plus"></i> Add Result
                      </button>
                    </div>
                    
                    <canvas id="viral-load-chart" height="200"></canvas>
                    
                    <div class="table-responsive mt-3">
                      <table class="table table-striped">
                        <thead>
                          <tr>
                            <th>Date</th>
                            <th>Result (copies/ml)</th>
                            <th>Status</th>
                            <th>Sample Type</th>
                            <th>Lab</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td>2025-02-05</td>
                            <td class="high-viral-load">4,500</td>
                            <td><span class="badge bg-danger">Unsuppressed</span></td>
                            <td>Plasma</td>
                            <td>Juba National Lab</td>
                          </tr>
                          <tr>
                            <td>2024-08-10</td>
                            <td class="low-viral-load">200</td>
                            <td><span class="badge bg-success">Suppressed</span></td>
                            <td>Plasma</td>
                            <td>Juba National Lab</td>
                          </tr>
                          <tr>
                            <td>2024-02-15</td>
                            <td class="low-viral-load">150</td>
                            <td><span class="badge bg-success">Suppressed</span></td>
                            <td>DBS</td>
                            <td>Juba National Lab</td>
                          </tr>
                          <tr>
                            <td>2023-08-22</td>
                            <td class="high-viral-load">3,200</td>
                            <td><span class="badge bg-danger">Unsuppressed</span></td>
                            <td>Plasma</td>
                            <td>Juba National Lab</td>
                          </tr>
                          <tr>
                            <td>2023-02-10</td>
                            <td class="low-viral-load">Undetectable</td>
                            <td><span class="badge bg-success">Suppressed</span></td>
                            <td>DBS</td>
                            <td>Juba National Lab</td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                  
                  <div class="tab-pane fade" id="treatment-history">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                      <h6 class="mb-0">Treatment History</h6>
                      <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addTreatmentModal">
                        <i class="fas fa-plus"></i> Add Entry
                      </button>
                    </div>
                    
                    <div class="timeline">
                      <div class="timeline-item">
                        <div class="timeline-dot"></div>
                        <div class="timeline-date">March 15, 2025</div>
                        <div class="timeline-content">
                          <div class="timeline-title">Regular Follow-up</div>
                          <p class="mb-1">Reported good adherence. Next appointment scheduled for April 15.</p>
                          <div class="text-muted small">Dr. James Wilson</div>
                        </div>
                      </div>
                      <div class="timeline-item">
                        <div class="timeline-dot"></div>
                        <div class="timeline-date">February 5, 2025</div>
                        <div class="timeline-content">
                          <div class="timeline-title">Viral Load Test Result</div>
                          <p class="mb-1">Result: <span class="high-viral-load fw-bold">4,500 copies/ml</span>. EAC initiated.</p>
                          <div class="text-muted small">Dr. James Wilson</div>
                        </div>
                      </div>
                      <div class="timeline-item">
                        <div class="timeline-dot"></div>
                        <div class="timeline-date">January 20, 2025</div>
                        <div class="timeline-content">
                          <div class="timeline-title">Regular Follow-up</div>
                          <p class="mb-1">Patient reports missing doses occasionally due to work schedule. Viral load test ordered.</p>
                          <div class="text-muted small">Dr. James Wilson</div>
                        </div>
                      </div>
                      <div class="timeline-item">
                        <div class="timeline-dot"></div>
                        <div class="timeline-date">October 15, 2024</div>
                        <div class="timeline-content">
                          <div class="timeline-title">Regimen Change</div>
                          <p class="mb-1">Changed from TDF/3TC/EFV to TDF/3TC/DTG due to side effects.</p>
                          <div class="text-muted small">Dr. Sarah Ahmed</div>
                        </div>
                      </div>
                    </div>
                  </div>
                  
                  <div class="tab-pane fade" id="eac-history">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                      <h6 class="mb-0">Enhanced Adherence Counseling</h6>
                      <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addEACModal">
                        <i class="fas fa-plus"></i> Add Session
                      </button>
                    </div>
                    
                    <div class="alert alert-info">
                      <div class="d-flex">
                        <div class="me-3">
                          <i class="fas fa-info-circle fa-2x"></i>
                        </div>
                        <div>
                          <h6 class="alert-heading">EAC Program Status</h6>
                          <p class="mb-0">Patient has completed 1 of 3 required EAC sessions.</p>
                          <p class="mb-0">Next session scheduled for April 12, 2025.</p>
                        </div>
                      </div>
                    </div>
                    
                    <div class="table-responsive mt-3">
                      <table class="table table-striped">
                        <thead>
                          <tr>
                            <th>Session #</th>
                            <th>Date</th>
                            <th>Counselor</th>
                            <th>Barriers Identified</th>
                            <th>Plan</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td>1</td>
                            <td>2025-03-01</td>
                            <td>Mary Johnson</td>
                            <td>Work schedule conflicts with medication timing</td>
                            <td>Set phone reminders; keep emergency doses at work</td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                  
                  <div class="tab-pane fade" id="notes">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                      <h6 class="mb-0">Clinical Notes</h6>
                      <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addNoteModal">
                        <i class="fas fa-plus"></i> Add Note
                      </button>
                    </div>
                    
                    <div class="card mb-2">
                      <div class="card-body">
                        <div class="d-flex justify-content-between">
                          <h6>Follow-up Note</h6>
                          <span class="text-muted small">2025-03-15</span>
                        </div>
                        <p>Patient expresses challenges with work schedule affecting medication adherence. Discussed strategies for consistent dosing including setting alarms and keeping emergency doses at workplace.</p>
                        <div class="text-muted small">Dr. James Wilson</div>
                      </div>
                    </div>
                    
                    <div class="card mb-2">
                      <div class="card-body">
                        <div class="d-flex justify-content-between">
                          <h6>Initial EAC Session</h6>
                          <span class="text-muted small">2025-03-01</span>
                        </div>
                        <p>Patient surprised by high viral load result. Reports missing doses 2-3 times per week due to work schedule. Discussed importance of adherence and developed strategies to improve medication schedule.</p>
                        <div class="text-muted small">Mary Johnson, Counselor</div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Data Entry View -->
      <div id="data-entry-view" class="view-tab-container">
        <div class="card">
          <div class="card-header">
            <h5 class="mb-0">Patient Data Entry</h5>
          </div>
          <div class="card-body">
            <form id="patient-data-form">
              <div class="form-section">
                <h5 class="form-section-title">Patient Information</h5>
                <div class="row">
                  <div class="col-md-6 mb-3">
                    <label for="patient-id-input" class="form-label required-field">Patient ID</label>
                    <input type="text" class="form-control" id="patient-id-input" required>
                  </div>
                  <div class="col-md-6 mb-3">
                    <label for="art-number" class="form-label">ART Number</label>
                    <input type="text" class="form-control" id="art-number">
                  </div>
                  <div class="col-md-6 mb-3">
                    <label for="first-name" class="form-label required-field">First Name</label>
                    <input type="text" class="form-control" id="first-name" required>
                  </div>
                  <div class="col-md-6 mb-3">
                    <label for="last-name" class="form-label required-field">Last Name</label>
                    <input type="text" class="form-control" id="last-name" required>
                  </div>
                  <div class="col-md-4 mb-3">
                    <label for="dob" class="form-label required-field">Date of Birth</label>
                    <input type="date" class="form-control" id="dob" required>
                  </div>
                  <div class="col-md-4 mb-3">
                    <label for="gender" class="form-label required-field">Sex</label>
                    <select class="form-select" id="gender" required>
                      <option value="" selected disabled>Select</option>
                      <option value="M">Male</option>
                      <option value="F">Female</option>
                    </select>
                  </div>
                  <div class="col-md-4 mb-3">
                    <label for="phone" class="form-label">Phone Number</label>
                    <input type="tel" class="form-control" id="phone">
                  </div>
                  <div class="col-md-12 mb-3">
                    <label for="address" class="form-label">Address</label>
                    <textarea class="form-control" id="address" rows="2"></textarea>
                  </div>
                </div>
              </div>
              
              <div class="form-section">
                <h5 class="form-section-title">Treatment Information</h5>
                <div class="row">
                  <div class="col-md-6 mb-3">
                    <label for="art-start-date" class="form-label required-field">ART Start Date</label>
                    <input type="date" class="form-control" id="art-start-date" required>
                  </div>
                  <div class="col-md-6 mb-3">
                    <label for="current-regimen" class="form-label required-field">Current Regimen</label>
                    <select class="form-select" id="current-regimen" required>
                      <option value="" selected disabled>Select</option>
                      <option value="TDF/3TC/DTG">TDF/3TC/DTG</option>
                      <option value="TDF/3TC/EFV">TDF/3TC/EFV</option>
                      <option value="AZT/3TC/NVP">AZT/3TC/NVP</option>
                      <option value="AZT/3TC/DTG">AZT/3TC/DTG</option>
                      <option value="ABC/3TC/DTG">ABC/3TC/DTG</option>
                      <option value="Other">Other</option>
                    </select>
                  </div>
                  <div class="col-md-6 mb-3">
                    <label for="last-clinic-visit" class="form-label">Last Clinic Visit</label>
                    <input type="date" class="form-control" id="last-clinic-visit">
                  </div>
                  <div class="col-md-6 mb-3">
                    <label for="next-appointment" class="form-label">Next Appointment</label>
                    <input type="date" class="form-control" id="next-appointment">
                  </div>
                </div>
              </div>
              
              <div class="form-section">
                <h5 class="form-section-title">Viral Load Information</h5>
                <div class="row">
                  <div class="col-md-4 mb-3">
                    <label for="vl-collection-date" class="form-label required-field">Sample Collection Date</label>
                    <input type="date" class="form-control" id="vl-collection-date" required>
                  </div>
                  <div class="col-md-4 mb-3">
                    <label for="vl-result-date" class="form-label">Result Date</label>
                    <input type="date" class="form-control" id="vl-result-date">
                  </div>
                  <div class="col-md-4 mb-3">
                    <label for="sample-type" class="form-label required-field">Sample Type</label>
                    <select class="form-select" id="sample-type" required>
                      <option value="" selected disabled>Select</option>
                      <option value="plasma">Plasma</option>
                      <option value="dbs">DBS</option>
                    </select>
                  </div>
                  <div class="col-md-4 mb-3">
                    <label for="vl-result" class="form-label">Result (copies/ml)</label>
                    <input type="text" class="form-control" id="vl-result">
                  </div>
                  <div class="col-md-4 mb-3">
                    <label for="vl-lab" class="form-label">Laboratory</label>
                    <input type="text" class="form-control" id="vl-lab">
                  </div>
                  <div class="col-md-4 mb-3">
                    <label for="vl-status" class="form-label">Status</label>
                    <select class="form-select" id="vl-status">
                      <option value="" selected disabled>Select</option>
                      <option value="suppressed">Suppressed</option>
                      <option value="unsuppressed">Unsuppressed</option>
                    </select>
                  </div>
                </div>
              </div>
              
              <div class="d-flex justify-content-between mt-4">
                <button type="button" class="btn btn-outline-secondary" id="reset-form">
                  <i class="fas fa-undo"></i> Reset
                </button>
                <button type="submit" class="btn btn-primary">
                  <i class="fas fa-save"></i> Save Patient Data
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>

      <!-- Import Data View -->
      <div id="import-view" class="view-tab-container">
        <div class="card mb-4">
          <div class="card-header">
            <h5 class="mb-0">Import Viral Load Data</h5>
          </div>
          <div class="card-body">
            <p class="text-muted">Upload patient viral load data from VLSM or other systems. Files should be in Excel format (.xlsx, .xls)</p>
            
            <div id="upload-dropzone" class="upload-box mb-4">
              <input type="file" id="file-upload" hidden accept=".xlsx,.xls">
              <i class="fas fa-file-upload upload-icon"></i>
              <h5>Drag and drop files here</h5>
              <p class="text-muted">or</p>
              <button type="button" class="btn btn-primary" id="browse-files">
                Browse Files
              </button>
              <p class="text-muted mt-2">Maximum file size: 10MB</p>
            </div>
            
            <div id="upload-preview" style="display: none;">
              <div class="alert alert-info">
                <div class="d-flex">
                  <div class="me-3">
                    <i class="fas fa-info-circle fa-2x"></i>
                  </div>
                  <div>
                    <h6 class="alert-heading">File Preview</h6>
                    <p class="mb-0">Review the data before importing. Ensure all required fields are correctly mapped.</p>
                  </div>
                </div>
              </div>
              
              <div class="table-responsive">
                <table class="table table-striped table-sm">
                  <thead>
                    <tr>
                      <th>Patient ID</th>
                      <th>Name</th>
                      <th>Sex</th>
                      <th>Age</th>
                      <th>Collection Date</th>
                      <th>Result Date</th>
                      <th>Result</th>
                      <th>Sample Type</th>
                      <th>Status</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>VLC-2025-042</td>
                      <td>Sarah Johnson</td>
                      <td>F</td>
                      <td>28</td>
                      <td>2025-02-01</td>
                      <td>2025-02-05</td>
                      <td>4500</td>
                      <td>Plasma</td>
                      <td><span class="badge bg-danger">Error</span></td>
                    </tr>
                    <tr>
                      <td>VLC-2025-108</td>
                      <td>Michael Thomas</td>
                      <td>M</td>
                      <td>12</td>
                      <td>2025-01-15</td>
                      <td>2025-01-18</td>
                      <td>2300</td>
                      <td>Plasma</td>
                      <td><span class="badge bg-success">Valid</span></td>
                    </tr>
                    <tr>
                      <td>VLC-2025-156</td>
                      <td>Emily Davis</td>
                      <td>F</td>
                      <td>43</td>
                      <td>2024-10-15</td>
                      <td>2024-10-20</td>
                      <td>LDL</td>
                      <td>DBS</td>
                      <td><span class="badge bg-success">Valid</span></td>
                    </tr>
                    <tr>
                      <td>INVALID</td>
                      <td>John Smith</td>
                      <td>M</td>
                      <td>34</td>
                      <td>2025-04-01</td>
                      <td>--</td>
                      <td>--</td>
                      <td>Plasma</td>
                      <td><span class="badge bg-danger">Error</span></td>
                    </tr>
                    <tr>
                      <td>VLC-2025-203</td>
                      <td>David Wilson</td>
                      <td>M</td>
                      <td>17</td>
                      <td>2025-02-25</td>
                      <td>2025-03-01</td>
                      <td>5200</td>
                      <td>Plasma</td>
                      <td><span class="badge bg-success">Valid</span></td>
                    </tr>
                  </tbody>
                </table>
              </div>
              
              <div class="alert alert-warning">
                <i class="fas fa-exclamation-triangle me-2"></i>
                <span>2 records have validation errors. Fix the errors or proceed with valid records only.</span>
              </div>
              
              <div class="d-flex justify-content-between mt-4">
                <button type="button" class="btn btn-outline-secondary" id="cancel-import">
                  <i class="fas fa-times"></i> Cancel
                </button>
                <div>
                  <button type="button" class="btn btn-outline-primary me-2" id="download-errors">
                    <i class="fas fa-download"></i> Download Error Report
                  </button>
                  <button type="button" class="btn btn-success" id="confirm-import">
                    <i class="fas fa-file-import"></i> Import Valid Records
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
        
        <div class="card">
          <div class="card-header">
            <h5 class="mb-0">Import History</h5>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th>Date</th>
                    <th>File Name</th>
                    <th>Records</th>
                    <th>Successful</th>
                    <th>Failed</th>
                    <th>Imported By</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>2025-04-01 10:32 AM</td>
                    <td>vlsm_export_2025_04_01.xlsx</td>
                    <td>24</td>
                    <td>22</td>
                    <td>2</td>
                    <td>Jane Doe</td>
                    <td>
                      <button class="btn btn-sm btn-outline-secondary">
                        <i class="fas fa-eye"></i> View
                      </button>
                    </td>
                  </tr>
                  <tr>
                    <td>2025-03-15 09:15 AM</td>
                    <td>vlsm_export_2025_03_15.xlsx</td>
                    <td>18</td>
                    <td>18</td>
                    <td>0</td>
                    <td>Jane Doe</td>
                    <td>
                      <button class="btn btn-sm btn-outline-secondary">
                        <i class="fas fa-eye"></i> View
                      </button>
                    </td>
                  </tr>
                  <tr>
                    <td>2025-03-01 11:45 AM</td>
                    <td>vlsm_export_2025_03_01.xlsx</td>
                    <td>31</td>
                    <td>29</td>
                    <td>2</td>
                    <td>John Smith</td>
                    <td>
                      <button class="btn btn-sm btn-outline-secondary">
                        <i class="fas fa-eye"></i> View
                      </button>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      
      <!-- Reports View (Placeholder) -->
      <div id="reports-view" class="view-tab-container">
        <div class="card">
          <div class="card-header">
            <h5 class="mb-0">Reports</h5>
          </div>
          <div class="card-body">
            <div class="alert alert-info">
              <i class="fas fa-info-circle me-2"></i>
              This is a prototype. Reports functionality will be implemented in the full version.
            </div>
            
            <div class="row">
              <div class="col-md-4 mb-3">
                <div class="card h-100">
                  <div class="card-body">
                    <h5 class="card-title">Viral Load Coverage Report</h5>
                    <p class="card-text">Monitor viral load testing coverage across demographic groups</p>
                    <a href="javascript:void(0)" class="btn btn-primary">Generate Report</a>
                  </div>
                </div>
              </div>
              
              <div class="col-md-4 mb-3">
                <div class="card h-100">
                  <div class="card-body">
                    <h5 class="card-title">Treatment Outcome Report</h5>
                    <p class="card-text">Analyze viral suppression rates and treatment effectiveness</p>
                    <a href="javascript:void(0)" class="btn btn-primary">Generate Report</a>
                  </div>
                </div>
              </div>
              
              <div class="col-md-4 mb-3">
                <div class="card h-100">
                  <div class="card-body">
                    <h5 class="card-title">EAC Effectiveness Report</h5>
                    <p class="card-text">Evaluate effectiveness of EAC interventions</p>
                    <a href="javascript:void(0)" class="btn btn-primary">Generate Report</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Settings View (Placeholder) -->
      <div id="settings-view" class="view-tab-container">
        <div class="card">
          <div class="card-header">
            <h5 class="mb-0">Settings</h5>
          </div>
          <div class="card-body">
            <div class="alert alert-info">
              <i class="fas fa-info-circle me-2"></i>
              This is a prototype. Settings functionality will be implemented in the full version.
            </div>
            
            <ul class="nav nav-tabs" id="settingsTabs" role="tablist">
              <li class="nav-item" role="presentation">
                <button class="nav-link active" id="general-tab" data-bs-toggle="tab" data-bs-target="#general" type="button" role="tab" aria-controls="general" aria-selected="true">General</button>
              </li>
              <li class="nav-item" role="presentation">
                <button class="nav-link" id="users-tab" data-bs-toggle="tab" data-bs-target="#users" type="button" role="tab" aria-controls="users" aria-selected="false">Users</button>
              </li>
              <li class="nav-item" role="presentation">
                <button class="nav-link" id="algorithm-tab" data-bs-toggle="tab" data-bs-target="#algorithm" type="button" role="tab" aria-controls="algorithm" aria-selected="false">Algorithm Settings</button>
              </li>
            </ul>
            <div class="tab-content p-3" id="settingsTabContent">
              <div class="tab-pane fade show active" id="general" role="tabpanel" aria-labelledby="general-tab">
                <form>
                  <div class="mb-3">
                    <label for="clinicName" class="form-label">Clinic Name</label>
                    <input type="text" class="form-control" id="clinicName" value="ART Clinic, Juba Teaching Hospital">
                  </div>
                  <div class="mb-3">
                    <label for="contactEmail" class="form-label">Contact Email</label>
                    <input type="email" class="form-control" id="contactEmail" value="clinic@example.org">
                  </div>
                  <div class="mb-3">
                    <label for="language" class="form-label">Default Language</label>
                    <select class="form-select" id="language">
                      <option selected>English</option>
                      <option>Arabic</option>
                    </select>
                  </div>
                  <button type="button" class="btn btn-primary">Save Changes</button>
                </form>
              </div>
              <div class="tab-pane fade" id="users" role="tabpanel" aria-labelledby="users-tab">
                <p>User management will be available in the full version.</p>
              </div>
              <div class="tab-pane fade" id="algorithm" role="tabpanel" aria-labelledby="algorithm-tab">
                <p>Viral load monitoring algorithm settings will be available in the full version.</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Modals -->
  <!-- New Patient Modal -->
  <div class="modal fade" id="newPatientModal" tabindex="-1" aria-labelledby="newPatientModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="newPatientModalLabel">Add New Patient</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="new-patient-form">
            <div class="row">
              <div class="col-md-6 mb-3">
                <label for="new-patient-id" class="form-label required-field">Patient ID</label>
                <input type="text" class="form-control" id="new-patient-id" required>
              </div>
              <div class="col-md-6 mb-3">
                <label for="new-art-number" class="form-label">ART Number</label>
                <input type="text" class="form-control" id="new-art-number">
              </div>
              <div class="col-md-6 mb-3">
                <label for="new-first-name" class="form-label required-field">First Name</label>
                <input type="text" class="form-control" id="new-first-name" required>
              </div>
              <div class="col-md-6 mb-3">
                <label for="new-last-name" class="form-label required-field">Last Name</label>
                <input type="text" class="form-control" id="new-last-name" required>
              </div>
              <div class="col-md-4 mb-3">
                <label for="new-dob" class="form-label required-field">Date of Birth</label>
                <input type="date" class="form-control" id="new-dob" required>
              </div>
              <div class="col-md-4 mb-3">
                <label for="new-gender" class="form-label required-field">Sex</label>
                <select class="form-select" id="new-gender" required>
                  <option value="" selected disabled>Select</option>
                  <option value="M">Male</option>
                  <option value="F">Female</option>
                </select>
              </div>
              <div class="col-md-4 mb-3">
                <label for="new-phone" class="form-label">Phone Number</label>
                <input type="tel" class="form-control" id="new-phone">
              </div>
              <div class="col-md-12 mb-3">
                <label for="new-address" class="form-label">Address</label>
                <textarea class="form-control" id="new-address" rows="2"></textarea>
              </div>
              <div class="col-md-6 mb-3">
                <label for="new-art-start-date" class="form-label required-field">ART Start Date</label>
                <input type="date" class="form-control" id="new-art-start-date" required>
              </div>
              <div class="col-md-6 mb-3">
                <label for="new-regimen" class="form-label required-field">Current Regimen</label>
                <select class="form-select" id="new-regimen" required>
                  <option value="" selected disabled>Select</option>
                  <option value="TDF/3TC/DTG">TDF/3TC/DTG</option>
                  <option value="TDF/3TC/EFV">TDF/3TC/EFV</option>
                  <option value="AZT/3TC/NVP">AZT/3TC/NVP</option>
                  <option value="AZT/3TC/DTG">AZT/3TC/DTG</option>
                  <option value="ABC/3TC/DTG">ABC/3TC/DTG</option>
                  <option value="Other">Other</option>
                </select>
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="button" class="btn btn-primary" id="save-new-patient">Save Patient</button>
        </div>
      </div>
    </div>
  </div>
  
  <!-- Add Viral Load Modal -->
  <div class="modal fade" id="addViralLoadModal" tabindex="-1" aria-labelledby="addViralLoadModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addViralLoadModalLabel">Add Viral Load Result</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="viral-load-form">
            <div class="mb-3">
              <label for="vl-sample-date" class="form-label required-field">Sample Collection Date</label>
              <input type="date" class="form-control" id="vl-sample-date" required>
            </div>
            <div class="mb-3">
              <label for="vl-test-date" class="form-label required-field">Test Result Date</label>
              <input type="date" class="form-control" id="vl-test-date" required>
            </div>
            <div class="mb-3">
              <label for="vl-test-result" class="form-label required-field">Result (copies/ml)</label>
              <input type="text" class="form-control" id="vl-test-result" required>
              <div class="form-text">Enter "LDL" for results below detectable limit</div>
            </div>
            <div class="mb-3">
              <label for="vl-sample-type" class="form-label required-field">Sample Type</label>
              <select class="form-select" id="vl-sample-type" required>
                <option value="" selected disabled>Select</option>
                <option value="plasma">Plasma</option>
                <option value="dbs">DBS</option>
              </select>
            </div>
            <div class="mb-3">
              <label for="vl-lab-name" class="form-label">Laboratory</label>
              <input type="text" class="form-control" id="vl-lab-name">
            </div>
            <div class="mb-3">
              <label for="vl-comments" class="form-label">Comments</label>
              <textarea class="form-control" id="vl-comments" rows="2"></textarea>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="button" class="btn btn-primary" id="save-viral-load">Save Result</button>
        </div>
      </div>
    </div>
  </div>
  
  <!-- Add Treatment Entry Modal -->
  <div class="modal fade" id="addTreatmentModal" tabindex="-1" aria-labelledby="addTreatmentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addTreatmentModalLabel">Add Treatment Entry</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="treatment-form">
            <div class="mb-3">
              <label for="treatment-date" class="form-label required-field">Date</label>
              <input type="date" class="form-control" id="treatment-date" required>
            </div>
            <div class="mb-3">
              <label for="treatment-type" class="form-label required-field">Entry Type</label>
              <select class="form-select" id="treatment-type" required>
                <option value="" selected disabled>Select</option>
                <option value="follow-up">Regular Follow-up</option>
                <option value="regimen-change">Regimen Change</option>
                <option value="adherence">Adherence Assessment</option>
                <option value="side-effects">Side Effects Management</option>
                <option value="other">Other</option>
              </select>
            </div>
            <div class="mb-3">
              <label for="treatment-regimen" class="form-label">Current Regimen</label>
              <select class="form-select" id="treatment-regimen">
                <option value="" selected disabled>Select</option>
                <option value="TDF/3TC/DTG">TDF/3TC/DTG</option>
                <option value="TDF/3TC/EFV">TDF/3TC/EFV</option>
                <option value="AZT/3TC/NVP">AZT/3TC/NVP</option>
                <option value="AZT/3TC/DTG">AZT/3TC/DTG</option>
                <option value="ABC/3TC/DTG">ABC/3TC/DTG</option>
                <option value="Other">Other</option>
              </select>
            </div>
            <div class="mb-3">
              <label for="treatment-provider" class="form-label required-field">Provider Name</label>
              <input type="text" class="form-control" id="treatment-provider" required>
            </div>
            <div class="mb-3">
              <label for="treatment-notes" class="form-label required-field">Notes</label>
              <textarea class="form-control" id="treatment-notes" rows="3" required></textarea>
            </div>
            <div class="mb-3">
              <label for="next-appointment-date" class="form-label">Next Appointment Date</label>
              <input type="date" class="form-control" id="next-appointment-date">
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="button" class="btn btn-primary" id="save-treatment">Save Entry</button>
        </div>
      </div>
    </div>
  </div>
  
  <!-- Add EAC Session Modal -->
  <div class="modal fade" id="addEACModal" tabindex="-1" aria-labelledby="addEACModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addEACModalLabel">Add EAC Session</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="eac-form">
            <div class="mb-3">
              <label for="eac-session-number" class="form-label required-field">Session Number</label>
              <select class="form-select" id="eac-session-number" required>
                <option value="" selected disabled>Select</option>
                <option value="1">Session 1</option>
                <option value="2">Session 2</option>
                <option value="3">Session 3</option>
              </select>
            </div>
            <div class="mb-3">
              <label for="eac-date" class="form-label required-field">Session Date</label>
              <input type="date" class="form-control" id="eac-date" required>
            </div>
            <div class="mb-3">
              <label for="eac-counselor" class="form-label required-field">Counselor Name</label>
              <input type="text" class="form-control" id="eac-counselor" required>
            </div>
            <div class="mb-3">
              <label for="eac-barriers" class="form-label required-field">Barriers to Adherence Identified</label>
              <textarea class="form-control" id="eac-barriers" rows="2" required></textarea>
            </div>
            <div class="mb-3">
              <label for="eac-plan" class="form-label required-field">Action Plan</label>
              <textarea class="form-control" id="eac-plan" rows="2" required></textarea>
            </div>
            <div class="mb-3">
              <label for="eac-next-date" class="form-label">Next Session Date</label>
              <input type="date" class="form-control" id="eac-next-date">
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="button" class="btn btn-primary" id="save-eac">Save Session</button>
        </div>
      </div>
    </div>
  </div>
  
  <!-- Add Note Modal -->
  <div class="modal fade" id="addNoteModal" tabindex="-1" aria-labelledby="addNoteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addNoteModalLabel">Add Clinical Note</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="note-form">
            <div class="mb-3">
              <label for="note-date" class="form-label required-field">Date</label>
              <input type="date" class="form-control" id="note-date" required>
            </div>
            <div class="mb-3">
              <label for="note-title" class="form-label required-field">Title</label>
              <input type="text" class="form-control" id="note-title" required>
            </div>
            <div class="mb-3">
              <label for="note-content" class="form-label required-field">Note Content</label>
              <textarea class="form-control" id="note-content" rows="5" required></textarea>
            </div>
            <div class="mb-3">
              <label for="note-author" class="form-label required-field">Author</label>
              <input type="text" class="form-control" id="note-author" required>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="button" class="btn btn-primary" id="save-note">Save Note</button>
        </div>
      </div>
    </div>
  </div>
  
  <!-- Schedule Service Modal -->
  <div class="modal fade" id="scheduleServiceModal" tabindex="-1" aria-labelledby="scheduleServiceModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="scheduleServiceModalLabel">Schedule Service</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="schedule-form">
            <div class="mb-3">
              <label for="service-type" class="form-label required-field">Service Type</label>
              <select class="form-select" id="service-type" required>
                <option value="" selected disabled>Select</option>
                <option value="viral-load">Viral Load Test</option>
                <option value="eac1">EAC Session 1</option>
                <option value="eac2" selected>EAC Session 2</option>
                <option value="eac3">EAC Session 3</option>
                <option value="repeat-test">Repeat Viral Load Test</option>
                <option value="follow-up">Regular Follow-up</option>
              </select>
            </div>
            <div class="mb-3">
              <label for="service-date" class="form-label required-field">Scheduled Date</label>
              <input type="date" class="form-control" id="service-date" value="2025-04-12" required>
            </div>
            <div class="mb-3">
              <label for="service-notes" class="form-label">Notes</label>
              <textarea class="form-control" id="service-notes" rows="3"></textarea>
            </div>
            <div class="mb-3 form-check">
              <input type="checkbox" class="form-check-input" id="send-reminder">
              <label class="form-check-label" for="send-reminder">Send SMS reminder to patient</label>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="button" class="btn btn-primary" id="save-schedule">Schedule</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
  <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
  
  <script id="app-script">
    // Initialize app
    $(document).ready(function() {
      // Setup charts
      setupDashboardCharts();
      
      // Login form submission
      $('#login-form').on('submit', function(e) {
        e.preventDefault();
        
        const username = $('#username').val();
        const password = $('#password').val();
        const role = $('#role').val();
        
        if (!username || !password || !role) {
          toastr.error('Please fill in all fields');
          return;
        }
        
        // In a real app, we would validate credentials with the server
        // For the prototype, we'll just simulate a successful login
        $('#user-role').text(role.charAt(0).toUpperCase() + role.slice(1));
        $('#login-screen').hide();
        $('#app').show();
        
        // Set initial view based on role
        if (role === 'data') {
          switchView('data-entry');
        } else if (role === 'lab') {
          switchView('import');
        } else {
          switchView('dashboard');
        }
      });
      
      // Logout button
      $('#logout-btn').click(function() {
        $('#app').hide();
        $('#login-screen').show();
        $('#username').val('');
        $('#password').val('');
        $('#role').val('');
      });
      
      // Toggle sidebar
      $('#toggle-sidebar').click(function() {
        $('.sidebar').toggleClass('sidebar-collapsed');
        $('.main-content').toggleClass('main-content-expanded');
      });
      
      // Navigation between views
      $('.sidebar-item').click(function() {
        const viewName = $(this).data('view');
        switchView(viewName);
      });
      
      // View patient profile
      $(document).on('click', '[data-patient-id]', function() {
        const patientId = $(this).data('patient-id');
        $('#patient-id').text(patientId);
        switchView('patient-profile');
      });
      
      // Back to patient list
      $('#back-to-patients').click(function() {
        switchView('patients');
      });
      
      // Reset form button
      $('#reset-form').click(function() {
        $('#patient-data-form')[0].reset();
      });
      
      // File upload functionality
      $('#browse-files').click(function() {
        $('#file-upload').click();
      });
      
      $('#file-upload').change(function() {
        if (this.files.length > 0) {
          const file = this.files[0];
          simulateFileUpload(file);
        }
      });
      
      $('#upload-dropzone').on('dragover', function(e) {
        e.preventDefault();
        $(this).addClass('border-primary');
      }).on('dragleave', function() {
        $(this).removeClass('border-primary');
      }).on('drop', function(e) {
        e.preventDefault();
        $(this).removeClass('border-primary');
        
        if (e.originalEvent.dataTransfer.files.length > 0) {
          const file = e.originalEvent.dataTransfer.files[0];
          simulateFileUpload(file);
        }
      });
      
      // Upload preview actions
      $('#cancel-import').click(function() {
        $('#upload-preview').hide();
        $('#upload-dropzone').show();
      });
      
      $('#confirm-import').click(function() {
        toastr.success('Successfully imported 3 records');
        $('#upload-preview').hide();
        $('#upload-dropzone').show();
      });
      
      $('#download-errors').click(function() {
        toastr.info('Error report downloaded');
      });
      
      // Initialize date picker for dashboard
      flatpickr('#dashboard-date-range', {
        mode: 'range',
        dateFormat: 'Y-m-d',
        defaultDate: ['2025-01-01', '2025-04-10']
      });
      
      // Initialize datatable
      $('#patients-table').DataTable({
        paging: false,
        info: false,
        searching: false
      });
      
      // Patient form submission
      $('#patient-data-form').on('submit', function(e) {
        e.preventDefault();
        toastr.success('Patient data saved successfully');
        $('#patient-data-form')[0].reset();
      });
      
      // Initialize toastr
      toastr.options = {
        closeButton: true,
        progressBar: true,
        positionClass: 'toast-top-right',
        timeOut: 3000
      };
      
      // Modal action buttons
      $('#save-new-patient').click(function() {
        toastr.success('New patient added successfully');
        $('#newPatientModal').modal('hide');
      });
      
      $('#save-viral-load').click(function() {
        toastr.success('Viral load result added successfully');
        $('#addViralLoadModal').modal('hide');
      });
      
      $('#save-treatment').click(function() {
        toastr.success('Treatment entry added successfully');
        $('#addTreatmentModal').modal('hide');
      });
      
      $('#save-eac').click(function() {
        toastr.success('EAC session saved successfully');
        $('#addEACModal').modal('hide');
      });
      
      $('#save-note').click(function() {
        toastr.success('Note added successfully');
        $('#addNoteModal').modal('hide');
      });
      
      $('#save-schedule').click(function() {
        toastr.success('Service scheduled successfully');
        $('#scheduleServiceModal').modal('hide');
      });
      
      // Set up viral load chart in patient profile
      const ctx = document.getElementById('viral-load-chart');
      if (ctx) {
        new Chart(ctx, {
          type: 'line',
          data: {
            labels: ['2023-02-10', '2023-08-22', '2024-02-15', '2024-08-10', '2025-02-05'],
            datasets: [{
              label: 'Viral Load (copies/ml)',
              data: [0, 3200, 150, 200, 4500],
              fill: false,
              borderColor: '#3b82f6',
              tension: 0.1,
              pointBackgroundColor: function(context) {
                const value = context.dataset.data[context.dataIndex];
                return value > 1000 ? '#ef4444' : '#22c55e';
              },
              pointRadius: 6
            }]
          },
          options: {
            scales: {
              y: {
                beginAtZero: true,
                title: {
                  display: true,
                  text: 'Viral Load (copies/ml)'
                }
              },
              x: {
                title: {
                  display: true,
                  text: 'Test Date'
                }
              }
            },
            plugins: {
              tooltip: {
                callbacks: {
                  label: function(context) {
                    const value = context.parsed.y;
                    return `Viral Load: ${value} copies/ml`;
                  }
                }
              },
              annotation: {
                annotations: {
                  threshold: {
                    type: 'line',
                    yMin: 1000,
                    yMax: 1000,
                    borderColor: '#ef4444',
                    borderWidth: 2,
                    borderDash: [6, 6],
                    label: {
                      content: 'Threshold (1000 copies/ml)',
                      enabled: true,
                      position: 'end'
                    }
                  }
                }
              }
            }
          }
        });
      }
    });
    
    // Function to switch between views
    function switchView(viewName) {
      $('.view-tab-container').removeClass('active');
      $(`#${viewName}-view`).addClass('active');
      
      $('.sidebar-item').removeClass('active');
      $(`.sidebar-item[data-view="${viewName}"]`).addClass('active');
      
      // Update the page title
      const titles = {
        'dashboard': 'Dashboard',
        'patients': 'Patient List',
        'data-entry': 'Data Entry',
        'import': 'Import Data',
        'reports': 'Reports',
        'settings': 'Settings',
        'patient-profile': 'Patient Profile'
      };
      
      $('#current-view-title').text(titles[viewName] || 'Dashboard');
    }
    
    // Function to setup dashboard charts
    function setupDashboardCharts() {
      // Demographics chart
      const demographicsCtx = document.getElementById('demographics-chart');
      if (demographicsCtx) {
        new Chart(demographicsCtx, {
          type: 'bar',
          data: {
            labels: ['0-4', '5-9', '10-14', '15-19', '20-24', '25-34', '35-44', '45-54', '55+'],
            datasets: [
              {
                label: 'Male',
                data: [23, 34, 56, 78, 92, 143, 105, 61, 32],
                backgroundColor: '#3b82f6',
                stack: 'Stack 0'
              },
              {
                label: 'Female',
                data: [29, 42, 61, 94, 124, 165, 82, 47, 28],
                backgroundColor: '#ec4899',
                stack: 'Stack 0'
              }
            ]
          },
          options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
              title: {
                display: false,
                text: 'Patient Demographics'
              },
              legend: {
                position: 'bottom'
              }
            },
            scales: {
              x: {
                title: {
                  display: true,
                  text: 'Age Group'
                }
              },
              y: {
                title: {
                  display: true,
                  text: 'Number of Patients'
                },
                beginAtZero: true
              }
            }
          }
        });
      }
      
      // Viral load status chart
      const viralLoadStatusCtx = document.getElementById('viral-load-status-chart');
      if (viralLoadStatusCtx) {
        new Chart(viralLoadStatusCtx, {
          type: 'doughnut',
          data: {
            labels: ['Suppressed', 'Unsuppressed', 'Due for Testing', 'No Result'],
            datasets: [{
              data: [743, 156, 237, 111],
              backgroundColor: [
                '#22c55e',
                '#ef4444',
                '#f59e0b',
                '#94a3b8'
              ],
              hoverOffset: 4
            }]
          },
          options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
              legend: {
                position: 'bottom'
              }
            }
          }
        });
      }
      
      // Rejection reasons chart
      const rejectionReasonsCtx = document.getElementById('rejection-reasons-chart');
      if (rejectionReasonsCtx) {
        new Chart(rejectionReasonsCtx, {
          type: 'pie',
          data: {
            labels: ['Improper Labeling', 'Insufficient Volume', 'Hemolyzed Sample', 'Delayed Transport', 'Other'],
            datasets: [{
              data: [8, 12, 6, 9, 3],
              backgroundColor: [
                '#3b82f6',
                '#ef4444',
                '#f59e0b',
                '#8b5cf6',
                '#94a3b8'
              ],
              hoverOffset: 4
            }]
          },
          options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
              legend: {
                position: 'bottom'
              }
            }
          }
        });
      }
    }
    
    // Function to simulate file upload for the prototype
    function simulateFileUpload(file) {
      if (!file.name.endsWith('.xlsx') && !file.name.endsWith('.xls')) {
        toastr.error('Please upload an Excel file (.xlsx or .xls)');
        return;
      }
      
      // Simulate processing
      $('#upload-dropzone').hide();
      setTimeout(() => {
        $('#upload-preview').show();
      }, 1000);
    }
  </script>
</body>
</html>