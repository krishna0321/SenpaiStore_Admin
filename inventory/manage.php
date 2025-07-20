<?php
include("../config/db.php");
include("../includes/auth.php");
include("../includes/header.php");

if (!isset($_GET['id'])) {
  echo "<script>window.location.href='index.php';</script>";
  exit;
}

$id = $_GET['id'];
$stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
$stmt->execute([$id]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $new_stock = $_POST['stock'];
  $update = $conn->prepare("UPDATE products SET stock = ? WHERE id = ?");
  $update->execute([$new_stock, $id]);
  echo "<script>alert('Stock updated successfully');window.location.href='index.php';</script>";
}
?>

<div class="content-wrapper">
  <section class="content-header">
    <div class="container-fluid">
      <h1>Manage Inventory</h1>
      <p>Update stock for <strong><?= htmlspecialchars($product['name']) ?></strong></p>
    </div>
  </section>

  <section class="content">
    <div class="container-fluid">
      <form method="POST">
        <div class="form-group">
          <label>Current Stock:</label>
          <input type="number" name="stock" value="<?= $product['stock'] ?>" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success">Update Stock</button>
        <a href="index.php" class="btn btn-secondary">Back</a>
      </form>
    </div>
  </section>
</div>

<?php include("../includes/footer.php"); ?>
