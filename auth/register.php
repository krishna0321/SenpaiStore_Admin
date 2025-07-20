<?php
session_start();
require("../config/db.php");

$error = "";
$success = "";

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = trim($_POST['username'] ?? '');
  $password = trim($_POST['password'] ?? '');

  // Basic validation
  if (strlen($username) < 3) {
    $error = "Username must be at least 3 characters.";
  } elseif (strlen($password) < 4) {
    $error = "Password must be at least 4 characters.";
  } else {
    // Check if username already exists
    $stmt = $conn->prepare("SELECT id FROM admins WHERE username = ?");
    $stmt->execute([$username]);

    if ($stmt->rowCount() > 0) {
      $error = "Username is already taken.";
    } else {
      // Hash the password and insert new user
      $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
      $insert = $conn->prepare("INSERT INTO admins (username, password) VALUES (?, ?)");

      if ($insert->execute([$username, $hashedPassword])) {
        $success = "Account created successfully! <a href='login.php'>Login here</a>.";
      } else {
        $error = "Registration failed. Please try again.";
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

      <?php if (!empty($error)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
      <?php endif; ?>

      <?php if (!empty($success)): ?>
        <div class="alert alert-success"><?= $success ?></div>
      <?php endif; ?>

      <form method="POST" autocomplete="off">
        <div class="input-group mb-3">
          <input type="text" name="username" class="form-control" placeholder="Username" required minlength="3" autofocus>
          <div class="input-group-append">
            <div class="input-group-text"><span class="fas fa-user"></span></div>
          </div>
        </div>

        <div class="input-group mb-3">
          <input type="password" name="password" class="form-control" placeholder="Password" required minlength="4">
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
