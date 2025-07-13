<?php
session_start();
require("../config/db.php"); // This uses PDO

$error = "";
$success = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = trim($_POST['username'] ?? '');
  $password = trim($_POST['password'] ?? '');

  if (strlen($username) < 3 || strlen($password) < 4) {
    $error = "Username or password too short.";
  } else {
    // Check if username exists (PDO)
    $stmt = $conn->prepare("SELECT id FROM admins WHERE username = ?");
    $stmt->execute([$username]);

    if ($stmt->rowCount() > 0) {
      $error = "Username already exists.";
    } else {
      $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
      $insert = $conn->prepare("INSERT INTO admins (username, password) VALUES (?, ?)");
      if ($insert->execute([$username, $hashedPassword])) {
        $success = "Account created! You can now login.";
      } else {
        $error = "Something went wrong. Try again.";
      }
    }
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Register | SenpaiStore</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="../assets/plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="../assets/css/adminlte.min.css">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo"><b>SenpaiStore</b> Register</div>
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Create a new admin account</p>

      <?php if ($error): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
      <?php endif; ?>

      <?php if ($success): ?>
        <div class="alert alert-success"><?php echo $success; ?></div>
      <?php endif; ?>

      <form method="POST">
        <div class="input-group mb-3">
          <input type="text" name="username" class="form-control" placeholder="Username" required>
          <div class="input-group-append">
            <div class="input-group-text"><span class="fas fa-user"></span></div>
          </div>
        </div>

        <div class="input-group mb-3">
          <input type="password" name="password" class="form-control" placeholder="Password" required>
          <div class="input-group-append">
            <div class="input-group-text"><span class="fas fa-lock"></span></div>
          </div>
        </div>

        <div class="row">
          <div class="col-6">
            <a href="login.php" class="text-center">Back to Login</a>
          </div>
          <div class="col-6">
            <button type="submit" class="btn btn-primary btn-block">Sign Up</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Scripts -->
<script src="../assets/plugins/jquery/jquery.min.js"></script>
<script src="../assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../assets/js/adminlte.min.js"></script>
</body>
</html>
