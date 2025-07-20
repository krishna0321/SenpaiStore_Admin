<?php
include("../includes/auth.php");
include("../config/db.php");

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id > 0) {
  $stmt = $conn->prepare("DELETE FROM orders WHERE id = ?");
  $stmt->execute([$id]);

  // Optional: Check if deletion was successful
  if ($stmt->rowCount() > 0) {
    header("Location: index.php?deleted=1");
  } else {
    header("Location: index.php?error=notfound");
  }
} else {
  header("Location: index.php?error=invalidid");
}
exit;
