<?php include("../includes/auth.php"); ?>
<?php include("../includes/header.php"); ?>
<?php include("../config/db.php"); ?>

<?php
function getStatusClass($status) {
  switch (strtolower($status)) {
    case 'pending': return 'warning';
    case 'shipped': return 'info';
    case 'delivered': return 'success';
    case 'cancelled': return 'danger';
    default: return 'secondary';
  }
}

$search = trim($_GET['search'] ?? '');
$status = trim($_GET['status'] ?? '');
$sql = "SELECT * FROM orders";
$params = [];

$conditions = [];
if ($search !== '') {
  $conditions[] = "customer_name LIKE ?";
  $params[] = "%$search%";
}
if ($status !== '') {
  $conditions[] = "status = ?";
  $params[] = $status;
}
if ($conditions) {
  $sql .= " WHERE " . implode(" AND ", $conditions);
}
$sql .= " ORDER BY id DESC";
$stmt = $conn->prepare($sql);
$stmt->execute($params);
?>

<div class="content-wrapper">
  <section class="content-header">
    <div class="container-fluid d-flex justify-content-between align-items-center">
      <h1 class="m-0">🧾 Orders</h1>
    </div>
  </section>

  <section class="content">
    <div class="container-fluid">
      <form method="GET" class="mb-3 d-flex justify-content-end">
        <input type="text" name="search" placeholder="Search by customer" value="<?= htmlspecialchars($search) ?>" class="form-control w-25">
        <select name="status" class="form-control w-auto ml-2" onchange="this.form.submit()">
          <option value="">All Statuses</option>
          <option value="Pending" <?= $status === 'Pending' ? 'selected' : '' ?>>Pending</option>
          <option value="Shipped" <?= $status === 'Shipped' ? 'selected' : '' ?>>Shipped</option>
          <option value="Delivered" <?= $status === 'Delivered' ? 'selected' : '' ?>>Delivered</option>
          <option value="Cancelled" <?= $status === 'Cancelled' ? 'selected' : '' ?>>Cancelled</option>
        </select>
        <button class="btn btn-dark ml-2"><i class="fas fa-search"></i></button>
      </form>

      <div class="card">
        <div class="card-header bg-dark">
          <h3 class="card-title text-white">📋 Order List</h3>
        </div>
        <div class="card-body p-0">
          <div class="table-responsive">
            <table class="table table-bordered table-hover table-striped mb-0 text-center">
              <thead class="thead-light">
                <tr>
                  <th>ID</th>
                  <th>Customer</th>
                  <th>Product</th>
                  <th>Qty</th>
                  <th>Total Price (₹)</th>
                  <th>Status</th>
                  <th>Placed On</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                <?php
                if ($stmt->rowCount() === 0) {
                  echo "<tr><td colspan='8'>No orders found.</td></tr>";
                } else {
                  while ($row = $stmt->fetch()) {
                    $badge = getStatusClass($row['status']);
                    $date = date("d M Y, h:i A", strtotime($row['created_at']));
                    echo "<tr>
                      <td>{$row['id']}</td>
                      <td>{$row['customer_name']}</td>
                      <td>{$row['product_name']}</td>
                      <td>{$row['quantity']}</td>
                      <td>₹{$row['total_price']}</td>
                      <td><span class='badge badge-$badge'>{$row['status']}</span></td>
                      <td>$date</td>
                      <td>
                        <a href='edit.php?id={$row['id']}' class='btn btn-sm btn-warning'><i class='fas fa-edit'></i></a>
                        <a href='delete.php?id={$row['id']}' class='btn btn-sm btn-danger' onclick='return confirm(\"Are you sure?\")'><i class='fas fa-trash'></i></a>
                      </td>
                    </tr>";
                  }
                }
                ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

<?php include("../includes/footer.php"); ?>