<?php include("../includes/auth.php"); ?>
<?php include("../includes/header.php"); ?>
<?php include("../config/db.php"); ?>

<?php
$id = $_GET['id'] ?? null;

if (!$id) {
  header("Location: index.php");
  exit;
}

// Fetch current order data
$stmt = $conn->prepare("SELECT * FROM orders WHERE id = ?");
$stmt->execute([$id]);
$order = $stmt->fetch();

// Update on form submit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $customer_name = $_POST['customer_name'] ?? '';
  $product_name = $_POST['product_name'] ?? '';
  $quantity = $_POST['quantity'] ?? 1;
  $total_price = $_POST['total_price'] ?? 0;
  $status = $_POST['status'] ?? 'Pending';

  $update = $conn->prepare("UPDATE orders SET customer_name = ?, product_name = ?, quantity = ?, total_price = ?, status = ? WHERE id = ?");
  $update->execute([$customer_name, $product_name, $quantity, $total_price, $status, $id]);

  header("Location: index.php");
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
          <input type="number" name="quantity" class="form-control" value="<?php echo $order['quantity']; ?>" required>
        </div>
        <div class="form-group">
          <label>Total Price (₹)</label>
          <input type="number" step="0.01" name="total_price" class="form-control" value="<?php echo $order['total_price']; ?>" required>
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
  </section>
</div>

<?php include("../includes/footer.php"); ?>
