<?php
session_start();
require("../config/db.php");

$error = "";
$success = "";

// Form submit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = trim($_POST['username'] ?? '');
  $password = trim($_POST['password'] ?? '');

  if (strlen($username) < 3) {
    $error = "Username must be at least 3 characters.";
  } elseif (strlen($password) < 4) {
    $error = "Password must be at least 4 characters.";
  } else {
    $stmt = $conn->prepare("SELECT id FROM admins WHERE username = ?");
    $stmt->execute([$username]);

    if ($stmt->rowCount() > 0) {
      $error = "Username already exists.";
    } else {
      $hashed = password_hash($password, PASSWORD_DEFAULT);
      $insert = $conn->prepare("INSERT INTO admins (username, password) VALUES (?, ?)");
      if ($insert->execute([$username, $hashed])) {
        $success = "Account created! <a href='login.php'>Login now</a>";
      } else {
        $error = "Registration failed. Try again.";
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
  <style>
  body {
      margin: 0;
      font-family: 'Segoe UI', sans-serif;
      height: 100vh;
      background: linear-gradient(to right, #0f0c29, #302b63, #24243e);
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .login-box {
      width: 400px;
      padding: 35px;
      background: rgba(255, 255, 255, 0.05);
      border-radius: 16px;
      backdrop-filter: blur(15px);
      border: 1px solid rgba(255, 255, 255, 0.08);
      box-shadow: 0 0 20px rgba(0, 242, 254, 0.2);
      color: #ffffff;
      position: relative;
    }

    .login-logo {
      text-align: center;
      font-size: 30px;
      font-weight: bold;
      margin-bottom: 20px;
      color: #00f2fe;
      letter-spacing: 1px;
    }

    .login-box-msg {
      text-align: center;
      color: #ccc;
      margin-bottom: 20px;
      font-size: 16px;
    }

    .form-control {
      background-color: rgba(255, 255, 255, 0.07);
      border: none;
      border-bottom: 2px solid #888;
      color: #fff;
      border-radius: 5px;
      transition: 0.3s;
    }

    .form-control:focus {
      background-color: rgba(255, 255, 255, 0.1);
      border-color: #00f2fe;
      box-shadow: 0 0 8px #00f2fe;
    }

    .form-control::placeholder {
      color: #aaa;
    }

    .input-group-text {
      background: transparent;
      border: none;
      color: #ff6ec4;
    }

    .btn-primary {
      background-image: linear-gradient(to right, #00f2fe, #ff6ec4);
      border: none;
      font-weight: bold;
      color: #fff;
    }

    .btn-primary:hover {
      background-image: linear-gradient(to right, #ff6ec4, #00f2fe);
    }

    .text-link {
      color: #00f2fe;
      font-size: 14px;
    }

    .text-link:hover {
      text-decoration: underline;
    }

    .alert-danger {
      background-color: rgba(255, 0, 0, 0.15);
      color: #ff6b6b;
      border: none;
      font-size: 14px;
      padding: 10px 15px;
      border-radius: 5px;
    }

    .toggle-password {
      cursor: pointer;
      color: #00f2fe;
    }

    .typing-effect:focus {
      border-color: #ff6ec4;
      box-shadow: 0 0 6px #ff6ec4;
    }

  </style>
</head>
<body>
  <div class="login-box">
    <div class="login-logo">SenpaiStore Register</div>
    <p class="login-box-msg">Create your admin account</p>

    <?php if ($error): ?>
      <div class="alert alert-danger"><i class="fas fa-exclamation-circle"></i> <?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <?php if ($success): ?>
      <div class="alert alert-success"><i class="fas fa-check-circle"></i> <?= $success ?></div>
    <?php endif; ?>

    <form method="POST" autocomplete="off">
      <div class="input-group mb-3">
        <input type="text" name="username" class="form-control" placeholder="Username" required minlength="3">
        <div class="input-group-append">
          <div class="input-group-text"><i class="fas fa-user"></i></div>
        </div>
      </div>

      <div class="input-group mb-3">
        <input type="password" name="password" class="form-control" placeholder="Password" required minlength="4">
        <div class="input-group-append">
          <div class="input-group-text"><i class="fas fa-lock"></i></div>
        </div>
      </div>

      <div class="row">
        <div class="col-6">
          <a href="login.php" class="text-link">← Back to Login</a>
        </div>
        <div class="col-6 text-right">
          <button type="submit" class="btn btn-primary btn-block">Sign Up</button>
        </div>
      </div>
    </form>
  </div>

  <script src="../assets/plugins/jquery/jquery.min.js"></script>
  <script src="../assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
