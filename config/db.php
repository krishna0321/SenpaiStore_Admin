<?php
$host = 'localhost';
$dbname = 'senpaistore_db'; // ✅ use your existing DB name
$username = 'root';
$password = ''; // leave blank for XAMPP

try {
  $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
  die("Connection failed: " . $e->getMessage());
}
?>
