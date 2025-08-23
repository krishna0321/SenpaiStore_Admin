<?php
// Start session
include("../includes/session.php");

// Auth check
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: /SenpaiStore_Admin/auth/login.php');
    exit();
}

include("../includes/auth.php");
include("../includes/header.php");
?>

<div class="content-wrapper">
  <section class="content-header">
    <div class="container-fluid">
      <h1>Settings</h1>
    </div>
  </section>

  <section class="content">
    <div class="container-fluid">
      <div class="card card-primary">
        <div class="card-body">
          <p>⚙️ General settings will appear here.</p>
        </div>
      </div>
    </div>
  </section>
</div>

<?php include("../includes/footer.php"); ?>
