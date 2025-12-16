<?php
// buttons.php - Buttons Page aligned with ViLoCare
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
require 'config.php'; // Your database connection

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <title>ViLoCare - Buttons</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />

  <!-- Feather Icons -->
  <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>

  <style>
    body {
      background-color: #f8fafc;
    }
    .content {
      padding: 20px;
    }
  </style>
</head>

<body>
  <div class="container content">
    <!-- Page Header -->
    <div class="mb-4">
      <h1 class="h3">Buttons & Button Groups</h1>
      <a href="upgrade-to-pro.html" class="badge bg-dark text-white ms-2">
        Get more button examples
      </a>
    </div>

    <!-- Basic Buttons -->
    <div class="card mb-4">
      <div class="card-header">
        <h5 class="card-title mb-0">Basic Buttons</h5>
        <h6 class="card-subtitle text-muted">Default Bootstrap buttons style.</h6>
      </div>
      <div class="card-body text-center">
        <div class="mb-3">
          <button class="btn btn-primary me-2" data-feather="activity"></button> Primary
          <button class="btn btn-secondary me-2" data-feather="layers"></button> Secondary
          <button class="btn btn-success me-2" data-feather="check"></button> Success
          <button class="btn btn-danger me-2" data-feather="trash-2"></button> Danger
          <button class="btn btn-warning text-dark me-2" data-feather="alert-triangle"></button> Warning
          <button class="btn btn-info me-2" data-feather="info"></button> Info
        </div>
        <div>
          <button class="btn btn-primary" disabled data-feather="activity"></button> Primary
          <button class="btn btn-secondary" disabled data-feather="layers"></button> Secondary
          <button class="btn btn-success" disabled data-feather="check"></button> Success
          <button class="btn btn-danger" disabled data-feather="trash-2"></button> Danger
          <button class="btn btn-warning text-dark" disabled data-feather="alert-triangle"></button> Warning
          <button class="btn btn-info" disabled data-feather="info"></button> Info
        </div>
      </div>
    </div>

    <!-- Button Sizes -->
    <div class="card mb-4">
      <div class="card-header">
        <h5 class="card-title mb-0">Button Sizes</h5>
        <h6 class="card-subtitle text-muted">Fancy larger or smaller buttons.</h6>
      </div>
      <div class="card-body">
        <button class="btn btn-primary btn-sm me-2" data-feather="arrow-up"></button> Small
        <button class="btn btn-primary me-2" data-feather="arrow-down"></button> Medium
        <button class="btn btn-primary btn-lg" data-feather="arrow-right"></button> Large
      </div>
    </div>

    <!-- Button Groups -->
    <div class="card mb-4">
      <div class="card-header">
        <h5 class="card-title mb-0">Button Groups</h5>
        <h6 class="card-subtitle text-muted">Button group components.</h6>
      </div>
      <div class="card-body">
        <!-- Horizontal Button Group -->
        <h6 class="card-subtitle mb-2 text-muted">Horizontal button group</h6>
        <div class="btn-group btn-group-lg mb-3" role="group" aria-label="Large button group">
          <button type="button" class="btn btn-secondary" data-feather="chevron-left"></button> Left
          <button type="button" class="btn btn-secondary" data-feather="minus"></button> Middle
          <button type="button" class="btn btn-secondary" data-feather="chevron-right"></button> Right
        </div>

        <!-- Vertical Button Group -->
        <h6 class="card-subtitle mb-2 text-muted">Vertical button group</h6>
        <div class="d-flex flex-column gap-2" role="group" aria-label="Vertical button group">
          <button class="btn btn-primary" data-feather="edit">Edit</button>
          <button class="btn btn-success" data-feather="plus"></button> Add
          <button class="btn btn-danger" data-feather="x"></button> Delete
        </div>
      </div>
    </div>
  </div>

  <!-- Initialize Feather Icons -->
  <script>
    feather.replace();
  </script>

  <!-- Bootstrap JS Bundle -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>