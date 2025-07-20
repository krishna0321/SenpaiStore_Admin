<?php
require_once '../includes/auth.php';
require_once '../config/db.php';
require_once '../includes/header.php';

// Get current admin data
$stmt = $pdo->prepare("SELECT * FROM admins WHERE id = :id");
$stmt->execute(['id' => $_SESSION['admin_id']]);
$admin = $stmt->fetch();
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
        <h4>Role: <?= htmlspecialchars($admin['role'] ?? 'Administrator') ?></h4>
      </div>
    </div>
  </section>
</div>

<?php require_once '../includes/footer.php'; ?>
