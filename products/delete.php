<?php
include("../includes/auth.php");
include("../config/db.php");

$id = $_GET['id'] ?? null;

if ($id) {
  $stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
  $stmt->execute([$id]);
}

header("Location: index.php");
exit();