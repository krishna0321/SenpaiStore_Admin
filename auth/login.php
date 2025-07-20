<?php
session_start();
require("../config/db.php");

header('X-Frame-Options: DENY');

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = trim($_POST['username'] ?? '');
  $password = trim($_POST['password'] ?? '');

  if ($username && $password) {
    $stmt = $conn->prepare("SELECT * FROM admins WHERE username = ?");
    $stmt->execute([$username]);
    $admin = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($admin && password_verify($password, $admin['password'])) {
      $_SESSION['admin_logged_in'] = true;
      $_SESSION['admin_username'] = $admin['username'];
      header("Location: ../index.php");
      exit();
    } else {
      $error = "Invalid username or password.";
    }
  } else {
    $error = "Please fill in both fields.";
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>SenpaiStore Admin Login</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="../assets/plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="../assets/css/adminlte.min.css">
  <style>
    body {
      margin: 0;
      padding: 0;
      font-family: "Segoe UI", sans-serif;
      background: linear-gradient(135deg, #0f2027, #203a43, #2c5364);
      background: linear-gradient(to right, #0f2027, #203a43, #2c5364);
      height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .login-box {
      width: 400px;
      background: rgba(255, 255, 255, 0.1);
      border-radius: 16px;
      padding: 30px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
      backdrop-filter: blur(10px);
      -webkit-backdrop-filter: blur(10px);
      border: 1px solid rgba(255, 255, 255, 0.2);
      color: #fff;
    }

    .login-logo {
      font-size: 28px;
      font-weight: 700;
      text-align: center;
      margin-bottom: 25px;
      color: #00ccff;
      letter-spacing: 1px;
    }

    .login-box-msg {
      text-align: center;
      font-size: 16px;
      margin-bottom: 25px;
      color: #ccc;
    }

    .form-control {
      background-color: rgba(255, 255, 255, 0.07);
      border: none;
      border-bottom: 1px solid #888;
      color: #fff;
      border-radius: 4px;
    }

    .form-control:focus {
      background-color: rgba(255, 255, 255, 0.1);
      border-color: #00ccff;
      box-shadow: none;
    }

    .form-control::placeholder {
      color: #aaa;
    }

    .input-group-text {
      background-color: transparent;
      border: none;
      color: #00ccff;
    }

    .btn-primary {
      background-color: #00ccff;
      border: none;
      font-weight: 600;
    }

    .btn-primary:hover {
      background-color: #00a3cc;
    }

    .text-link {
      color: #00ccff;
      font-size: 14px;
      display: block;
      margin-top: 10px;
      text-align: left;
    }

    .text-link:hover {
      text-decoration: underline;
    }

    .alert-danger {
      background: rgba(255, 0, 0, 0.1);
      color: #ff6b6b;
      border: none;
      font-size: 14px;
      padding: 10px 15px;
      border-radius: 4px;
    }
  </style>
</head>
<body>
  <div class="login-box">
    <div class="login-logo">SenpaiStore Admin</div>
    <p class="login-box-msg">Login to continue</p>

    <?php if (!empty($error)): ?>
      <div class="alert alert-danger">
        <i class="fas fa-exclamation-circle"></i> <?= htmlspecialchars($error) ?>
      </div>
    <?php endif; ?>

    <form method="POST" autocomplete="off">
      <div class="input-group mb-3">
        <input type="text" name="username" class="form-control" placeholder="Enter your username" required autofocus>
        <div class="input-group-append">
          <div class="input-group-text"><span class="fas fa-user"></span></div>
        </div>
      </div>

      <div class="input-group mb-3">
        <input type="password" name="password" class="form-control" placeholder="Enter your password" required>
        <div class="input-group-append">
          <div class="input-group-text"><span class="fas fa-lock"></span></div>
        </div>
      </div>

      <div class="row">
        <div class="col-6">
          <a href="register.php" class="text-link">Register</a>
        </div>
        <div class="col-6 text-right">
          <button type="submit" class="btn btn-primary btn-block">Sign In</button>
        </div>
      </div>
    </form>
  </div>

  <script src="../assets/plugins/jquery/jquery.min.js"></script>
  <script src="../assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../assets/js/adminlte.min.js"></script>
</body>
</html>
