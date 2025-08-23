<?php
session_start();

// Check if logged in
if (empty($_SESSION['admin_logged_in'])) {
    header('Location: ../auth/login.php');
    exit();
}

// Optional: session timeout
$timeout = 900; // 15 minutes
if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > $timeout)) {
    session_unset();
    session_destroy();
    header('Location: ../auth/login.php?timeout=1');
    exit();
}
$_SESSION['LAST_ACTIVITY'] = time();

// Your admin data — since it's hardcoded, you can set here as well:
$admin = [
    'name' => 'Admin',
    'username' => $_SESSION['admin_username'],
    'email' => 'admin@example.com',
    'role' => 'Administrator',
];

// Include your header.php and footer.php as needed
require_once '../includes/header.php';
?>

<div class="content-wrapper">
  <section class="content-header">
    <h1>My Profile</h1>
  </section>

  <section class="content">
    <div class="card card-primary card-outline">
      <div class="card-body">
        <h4>Name: <?= htmlspecialchars($admin['name']) ?></h4>
        <h4>Username: <?= htmlspecialchars($admin['username']) ?></h4>
        <h4>Email: <?= htmlspecialchars($admin['email']) ?></h4>
        <h4>Role: <?= htmlspecialchars($admin['role']) ?></h4>
      </div>
    </div>
  </section>
</div>

<?php require_once '../includes/footer.php'; ?>
/