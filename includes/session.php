<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();

    // Optional: prevent browser cache for logged-in pages
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Pragma: no-cache");
    header("Expires: 0");
}
