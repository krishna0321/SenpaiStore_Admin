<?php
require_once '../includes/auth.php';
require_once '../config/db.php';
require_once '../includes/header.php';

$success = $error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    if (!empty($password)) {
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("UPDATE admins SET name = :name, email = :email, password = :password WHERE id = :id");
        $stmt->execute([
            'name' => $name,
            'email' => $email,
            'password' => $hashed,
            'id' => $_SESSION['admin_id']
        ]);
    } else {
        $stmt = $pdo->prepare("UPDATE admins SET name = :name, email = :email WHERE id = :id");
        $stmt->execute([
            'name' => $name,
            'email' => $email,
            'id' => $_SESSION['admin_id']
        ]);
    }
    $success = "Profile updated successfully!";
}

$stmt = $pdo->prepare("SELECT * FROM admins WHERE id = :id");
$stmt->execute(['id' => $_SESSION['admin_id']]);
$admin = $stmt->fetch();
?>

<div class="content-wrapper">
  <section class="content-header">
    <h1>Settings</h1>
  </section>

  <section class="content">
    <?php if ($success): ?>
      <div class="alert alert-success"><?= $success ?></div>
    <?php endif; ?>
    <form method="POST">
      <div class="form-group">
        <label>Full Name</label>
        <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($admin['name']) ?>" required>
      </div>
      <div class="form-group">
        <label>Email Address</label>
        <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($admin['email']) ?>" required>
      </div>
      <div class="form-group">
        <label>New Password <small>(leave blank to keep current)</small></label>
        <input type="password" name="password" class="form-control">
      </div>
      <button type="submit" class="btn btn-primary">Update Settings</button>
    </form>
  </section>
</div>

<?php require_once '../includes/footer.php'; ?>
