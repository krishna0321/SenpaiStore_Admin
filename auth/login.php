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
    <div class="login-logo">SenpaiStore Admin</div>
    <p class="login-box-msg">Login to your dashboard</p>

    <?php if (!empty($error)): ?>
      <div class="alert alert-danger">
        <i class="fas fa-exclamation-triangle"></i> <?= htmlspecialchars($error) ?>
      </div>
    <?php endif; ?>

    <form method="POST" autocomplete="off">
      <div class="input-group mb-3">
        <input type="text" name="username" class="form-control typing-effect" placeholder="Username" required>
        <div class="input-group-append">
          <div class="input-group-text"><i class="fas fa-user"></i></div>
        </div>
      </div>

      <div class="input-group mb-3">
        <input type="password" name="password" id="password" class="form-control typing-effect" placeholder="Password" required>
        <div class="input-group-append">
          <div class="input-group-text toggle-password"><i class="fas fa-eye" id="eye-icon"></i></div>
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
  <script>
    // Toggle password visibility
    document.querySelector(".toggle-password").addEventListener("click", function () {
      const input = document.getElementById("password");
      const icon = document.getElementById("eye-icon");
      if (input.type === "password") {
        input.type = "text";
        icon.classList.remove("fa-eye");
        icon.classList.add("fa-eye-slash");
      } else {
        input.type = "password";
        icon.classList.remove("fa-eye-slash");
        icon.classList.add("fa-eye");
      }
    });

    // Typing input glow
    document.querySelectorAll('.typing-effect').forEach(input => {
      input.addEventListener('input', () => {
        input.style.borderColor = "#ff6ec4";
        input.style.boxShadow = "0 0 5px #ff6ec4";
      });
    });
  </script>
</body>
</html>
