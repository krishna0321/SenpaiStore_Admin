<?php include("../includes/auth.php"); ?>
<?php include("../includes/header.php"); ?>
<?php include("../config/db.php"); ?>

<div class="content-wrapper">
  <section class="content-header">
    <div class="container-fluid d-flex justify-content-between align-items-center">
      <h1 class="m-0">🧾 Orders</h1>
      <!-- Optional Add Order Button -->
      <!-- <a href="add.php" class="btn btn-primary">
        <i class="fas fa-plus"></i> Add Order
      </a> -->
    </div>
  </section>

  <section class="content">
    <div class="container-fluid">
      <div class="card">
        <div class="card-header bg-dark">
          <h3 class="card-title text-white">📋 Order List</h3>
        </div>
        <div class="card-body p-0">
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
              $stmt = $conn->query("SELECT * FROM orders ORDER BY id DESC");
              while ($row = $stmt->fetch()) {
                echo "<tr>
                  <td>{$row['id']}</td>
                  <td>{$row['customer_name']}</td>
                  <td>{$row['product_name']}</td>
                  <td>{$row['quantity']}</td>
                  <td>₹{$row['total_price']}</td>
                  <td>{$row['status']}</td>
                  <td>{$row['created_at']}</td>
                  <td>
                    <a href='edit.php?id={$row['id']}' class='btn btn-sm btn-warning'><i class='fas fa-edit'></i></a>
                    <a href='delete.php?id={$row['id']}' class='btn btn-sm btn-danger' onclick='return confirm(\"Are you sure?\")'><i class='fas fa-trash'></i></a>
                  </td>
                </tr>";
              }
              ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </section>
</div>

<?php include("../includes/footer.php"); ?>