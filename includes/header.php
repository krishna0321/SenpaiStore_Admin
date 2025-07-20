<?php
// Start session safely
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Prevent browser caching after logout
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");
header("Expires: 0");

// Session timeout (15 minutes)
$timeout = 900; // 900 seconds = 15 minutes
if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY']) > $timeout) {
    session_unset();
    session_destroy();
    header("Location: /SenpaiStore_Admin/auth/login.php?timeout=1");
    exit();
}
$_SESSION['LAST_ACTIVITY'] = time();

$admin_name = $_SESSION['admin_username'] ?? 'Unknown';
$current_page = basename($_SERVER['SCRIPT_NAME']);

// Highlight active nav link
function isActive($path) {
    global $current_page;
    return $current_page === $path ? 'active' : '';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>SenpaiStore Admin</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="SenpaiStore Admin Panel">
  <link rel="icon" href="/SenpaiStore_Admin/assets/img/favicon.ico" type="image/x-icon">

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="/SenpaiStore_Admin/assets/plugins/fontawesome-free/css/all.min.css">
  <!-- AdminLTE -->
  <link rel="stylesheet" href="/SenpaiStore_Admin/assets/css/adminlte.min.css">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
  <!-- Left navbar links -->
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
    </li>
    <li class="nav-item d-none d-sm-inline-block">
      <a href="/SenpaiStore_Admin/index.php" class="nav-link">Dashboard</a>
    </li>
    <li class="nav-item d-none d-sm-inline-block">
      <a href="/SenpaiStore_Admin/products/index.php" class="nav-link">Products</a>
    </li>
    <li class="nav-item d-none d-sm-inline-block">
      <a href="/SenpaiStore_Admin/orders/index.php" class="nav-link">Orders</a>
    </li>
  </ul>

  <!-- SEARCH FORM -->
  <form class="form-inline ml-3">
    <div class="input-group input-group-sm">
      <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
      <div class="input-group-append">
        <button class="btn btn-navbar" type="submit"><i class="fas fa-search"></i></button>
      </div>
    </div>
  </form>

  <!-- Right navbar -->
  <ul class="navbar-nav ml-auto">
    <!-- Notifications Dropdown -->
    <li class="nav-item dropdown">
      <a class="nav-link" data-toggle="dropdown" href="#"><i class="far fa-bell"></i><span class="badge badge-warning navbar-badge">3</span></a>
      <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
        <span class="dropdown-header">3 Notifications</span>
        <div class="dropdown-divider"></div>
        <a href="#" class="dropdown-item"><i class="fas fa-box mr-2"></i> New product added</a>
        <div class="dropdown-divider"></div>
        <a href="#" class="dropdown-item"><i class="fas fa-shopping-cart mr-2"></i> New order received</a>
        <div class="dropdown-divider"></div>
        <a href="#" class="dropdown-item"><i class="fas fa-user-plus mr-2"></i> New admin registered</a>
      </div>
    </li>

    <!-- User Profile Dropdown -->
    <li class="nav-item dropdown">
      <a class="nav-link" data-toggle="dropdown" href="#"><i class="fas fa-user-circle"></i> <?= htmlspecialchars($admin_name) ?></a>
      <div class="dropdown-menu dropdown-menu-right">
        <a href="#" class="dropdown-item"><i class="fas fa-user mr-2"></i> Profile</a>
        <a href="#" class="dropdown-item"><i class="fas fa-cogs mr-2"></i> Settings</a>
        <div class="dropdown-divider"></div>
        <a href="/SenpaiStore_Admin/auth/logout.php" class="dropdown-item"><i class="fas fa-sign-out-alt mr-2"></i> Logout</a>
      </div>
    </li>
  </ul>
</nav>
<!-- /.navbar -->

<!-- Main Sidebar -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <a href="/SenpaiStore_Admin/index.php" class="brand-link text-center">
    <span class="brand-text font-weight-light">SenpaiStore Admin</span>
  </a>
  <div class="sidebar">
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" role="menu">
        <li class="nav-item">
          <a href="/SenpaiStore_Admin/index.php" class="nav-link <?= isActive('index.php') ?>">
            <i class="nav-icon fas fa-home"></i>
            <p>Dashboard</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="/SenpaiStore_Admin/products/index.php" class="nav-link <?= isActive('index.php') === 'products/index.php' ? 'active' : '' ?>">
            <i class="nav-icon fas fa-box"></i>
            <p>Products</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="/SenpaiStore_Admin/orders/index.php" class="nav-link <?= isActive('orders/index.php') ?>">
            <i class="nav-icon fas fa-shopping-cart"></i>
            <p>Orders</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="/SenpaiStore_Admin/inventory/index.php" class="nav-link <?= isActive('inventory/index.php') ?>">
            <i class="nav-icon fas fa-warehouse"></i>
            <p>Inventory</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="/SenpaiStore_Admin/reports/index.php" class="nav-link <?= isActive('reports/index.php') ?>">
            <i class="nav-icon fas fa-chart-line"></i>
            <p>Reports</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="/SenpaiStore_Admin/auth/logout.php" class="nav-link">
            <i class="nav-icon fas fa-sign-out-alt"></i>
            <p>Logout</p>
          </a>
        </li>
      </ul>
    </nav>
  </div>
</aside>
<!-- /.sidebar -->

<!-- Content Wrapper Starts in the page files -->
