<?php
// Start session if it's not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Get current page name
$current_file = strtolower(basename($_SERVER['PHP_SELF']));

// Pages that do not require authentication
$auth_free_pages = ['login.php', 'register.php'];

// If user is not logged in and is trying to access a protected page
if (empty($_SESSION['admin_logged_in']) && !in_array($current_file, $auth_free_pages)) {
    // Optional: Save the page they tried to visit
    $_SESSION['redirect_after_login'] = $_SERVER['REQUEST_URI'];

    // Redirect to login page
    header("Location: ../auth/login.php");
    exit();
}
?>
