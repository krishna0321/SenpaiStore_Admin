<?php
if (!isset($_SESSION)) session_start();

$current_file = basename($_SERVER['PHP_SELF']);

$auth_free_pages = ['login.php', 'register.php'];

if (!isset($_SESSION['admin_logged_in']) && !in_array($current_file, $auth_free_pages)) {
  header("Location: ../auth/login.php");
  exit();
}
?>
