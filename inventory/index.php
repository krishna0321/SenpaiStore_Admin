<?php
include("../config/db.php");
include("../includes/auth.php");
include("../includes/header.php");
?>

<div class="content-wrapper">
  <section class="content-header">
    <div class="container-fluid">
      <h1>Inventory Overview</h1>
      <p>View current stock levels of all products</p>
    </div>
  </section>

  <section class="content">
    <div class="container-fluid">
      <table class="table table-bordered table-striped">
        <thead>
          <tr>
            <th>ID</th>
            <th>Product</th>
            <!-- Removed SKU -->
            <th>Stock</th>
            <th>Status</th>
            <th>Manage</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $stmt = $conn->query("SELECT * FROM products");
          while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $status = $row['stock'] <= 5 ? "<span class='badge badge-danger'>Low</span>" : "<span class='badge badge-success'>Sufficient</span>";
            echo "<tr>
              <td>{$row['id']}</td>
              <td>{$row['name']}</td>
              <td>{$row['stock']}</td>
              <td>$status</td>
              <td><a href='manage.php?id={$row['id']}' class='btn btn-sm btn-primary'>Update</a></td>
            </tr>";
          }
          ?>
        </tbody>
      </table>
    </div>
  </section>
</div>

<?php include("../includes/footer.php"); ?>
