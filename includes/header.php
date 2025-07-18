<?php
if (!isset($_SESSION)) session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>SenpaiStore Admin</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700">
  <link rel="stylesheet" href="/SenpaiStore_Admin/assets/plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="/SenpaiStore_Admin/assets/css/adminlte.min.css">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
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
</nav>

<!-- Sidebar -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <a href="/SenpaiStore_Admin/index.php" class="brand-link">
    <span class="brand-text font-weight-light">SenpaiStore</span>
  </a>
  <div class="sidebar">
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column">
        <li class="nav-item"><a href="/SenpaiStore_Admin/index.php" class="nav-link"><i class="nav-icon fas fa-home"></i><p>Dashboard</p></a></li>
        <li class="nav-item"><a href="/SenpaiStore_Admin/products/index.php" class="nav-link"><i class="nav-icon fas fa-box"></i><p>Products</p></a></li>
        <li class="nav-item"><a href="/SenpaiStore_Admin/orders/index.php" class="nav-link"><i class="nav-icon fas fa-shopping-cart"></i><p>Orders</p></a></li>
        <li class="nav-item"><a href="/SenpaiStore_Admin/auth/logout.php" class="nav-link"><i class="nav-icon fas fa-sign-out-alt"></i><p>Logout</p></a></li>
      </ul>
    </nav>
  </div>
</aside>
