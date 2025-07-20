<?php include("../includes/auth.php"); ?>
<?php include("../includes/header.php"); ?>
<?php include("../config/db.php"); ?>

<?php
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0) {
  header("Location: index.php");
  exit;
}

$stmt = $conn->prepare("SELECT * FROM orders WHERE id = ?");
$stmt->execute([$id]);
$order = $stmt->fetch();

if (!$order) {
  echo "<div class='alert alert-danger m-3'>Order not found.</div>";
  include("../includes/footer.php");
  exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $customer_name = trim($_POST['customer_name'] ?? '');
  $product_name = trim($_POST['product_name'] ?? '');
  $quantity = (int)($_POST['quantity'] ?? 1);
  $total_price = (float)($_POST['total_price'] ?? 0);
  $status = trim($_POST['status'] ?? 'Pending');

  $update = $conn->prepare("UPDATE orders SET customer_name = ?, product_name = ?, quantity = ?, total_price = ?, status = ? WHERE id = ?");
  $update->execute([$customer_name, $product_name, $quantity, $total_price, $status, $id]);

  header("Location: index.php?updated=1");
  exit;
}
?>

<div class="content-wrapper">
  <section class="content-header">
    <div class="container-fluid">
      <h1>✏️ Edit Order #<?php echo $order['id']; ?></h1>
    </div>
  </section>

  <section class="content">
    <div class="container-fluid">
      <div class="card">
        <div class="card-header bg-dark">
          <h3 class="card-title text-white">Edit Order</h3>
        </div>
        <div class="card-body">
          <form method="POST">
            <div class="form-group">
              <label>Customer Name</label>
              <input type="text" name="customer_name" class="form-control" value="<?php echo htmlspecialchars($order['customer_name']); ?>" required>
            </div>
            <div class="form-group">
              <label>Product Name</label>
              <input type="text" name="product_name" class="form-control" value="<?php echo htmlspecialchars($order['product_name']); ?>" required>
            </div>
            <div class="form-group">
              <label>Quantity</label>
              <input type="number" name="quantity" class="form-control" value="<?php echo $order['quantity']; ?>" required min="1">
            </div>
            <div class="form-group">
              <label>Total Price (₹)</label>
              <input type="number" step="0.01" min="0" name="total_price" class="form-control" value="<?php echo $order['total_price']; ?>" required>
            </div>
            <div class="form-group">
              <label>Status</label>
              <select name="status" class="form-control">
                <option value="Pending" <?php if ($order['status'] === 'Pending') echo 'selected'; ?>>Pending</option>
                <option value="Shipped" <?php if ($order['status'] === 'Shipped') echo 'selected'; ?>>Shipped</option>
                <option value="Delivered" <?php if ($order['status'] === 'Delivered') echo 'selected'; ?>>Delivered</option>
                <option value="Cancelled" <?php if ($order['status'] === 'Cancelled') echo 'selected'; ?>>Cancelled</option>
              </select>
            </div>
            <button type="submit" class="btn btn-primary">Update Order</button>
            <a href="index.php" class="btn btn-secondary">Cancel</a>
          </form>
        </div>
      </div>
    </div>
  </section>
</div>

<?php include("../includes/footer.php"); ?>
