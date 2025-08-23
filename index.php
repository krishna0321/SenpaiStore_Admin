<?php
include("includes/auth.php");
include("includes/header.php");
require("config/db.php"); // Make sure $conn is a PDO connection

try {
    // Total Products
    $totalProducts = $conn->query("SELECT COUNT(*) FROM products")->fetchColumn();

    // Total Orders
    $totalOrders = $conn->query("SELECT COUNT(*) FROM orders")->fetchColumn();

    // Total Revenue (Delivered orders only)
    $totalRevenue = $conn->query("
        SELECT SUM(total_price) FROM orders WHERE status = 'Delivered'
    ")->fetchColumn();
    $totalRevenue = $totalRevenue ?: 0;

    // Low Stock
    $lowStock = $conn->query("SELECT COUNT(*) FROM products WHERE stock < 5")->fetchColumn();

    // List of low stock products
    $lowStockProducts = $conn->query("
        SELECT name, stock FROM products WHERE stock < 5 ORDER BY stock ASC
    ")->fetchAll(PDO::FETCH_ASSOC);

    // Monthly Sales (for current year)
    $stmt = $conn->query("
        SELECT 
            MONTH(created_at) AS month, 
            SUM(total_price) AS revenue
        FROM orders
        WHERE status = 'Delivered' 
          AND YEAR(created_at) = YEAR(CURDATE())
        GROUP BY MONTH(created_at)
        ORDER BY MONTH(created_at)
    ");
    $salesData = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Prepare arrays for Chart.js
    $months = [];
    $revenues = [];

    // Map numbers to month names
    $monthNames = [1=>'Jan',2=>'Feb',3=>'Mar',4=>'Apr',5=>'May',6=>'Jun',7=>'Jul',8=>'Aug',9=>'Sep',10=>'Oct',11=>'Nov',12=>'Dec'];

    foreach ($salesData as $row) {
        $months[] = $monthNames[(int)$row['month']];
        $revenues[] = (float)$row['revenue'];
    }

} catch (PDOException $e) {
    die("Database query failed: " . $e->getMessage());
}
?>

<div class="content-wrapper">
  <section class="content-header">
    <div class="container-fluid">
      <h1>Welcome to SenpaiStore Admin Panel</h1>
    </div>
  </section>

  <section class="content">
    <div class="container-fluid">

      <!-- DASHBOARD CARDS -->
      <div class="row">
        <!-- Products -->
        <div class="col-lg-3 col-6">
          <div class="small-box bg-info">
            <div class="inner">
              <h3><?= $totalProducts; ?></h3>
              <p>Total Products</p>
            </div>
            <div class="icon">
              <i class="fas fa-box"></i>
            </div>
            <a href="products/index.php" class="small-box-footer">View Products <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>

        <!-- Orders -->
        <div class="col-lg-3 col-6">
          <div class="small-box bg-success">
            <div class="inner">
              <h3><?= $totalOrders; ?></h3>
              <p>Total Orders</p>
            </div>
            <div class="icon">
              <i class="fas fa-shopping-cart"></i>
            </div>
            <a href="orders/index.php" class="small-box-footer">View Orders <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>

        <!-- Revenue -->
        <div class="col-lg-3 col-6">
          <div class="small-box bg-warning">
            <div class="inner">
              <h3>₹<?= number_format($totalRevenue, 2); ?></h3>
              <p>Total Revenue</p>
            </div>
            <div class="icon">
              <i class="fas fa-rupee-sign"></i>
            </div>
            <a href="finance/report.php" class="small-box-footer">Finance <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>

        <!-- Low Inventory -->
        <div class="col-lg-3 col-6">
          <div class="small-box bg-danger">
            <div class="inner">
              <h3><?= $lowStock; ?></h3>
              <p>Low Stock</p>
              <?php if ($lowStock > 0): ?>
                <ul style="margin:0; padding-left:15px; font-size:13px; color:white;">
                  <?php foreach ($lowStockProducts as $p): ?>
                    <li><?= htmlspecialchars($p['name']); ?> (<?= $p['stock']; ?>)</li>
                  <?php endforeach; ?>
                </ul>
              <?php endif; ?>
            </div>
            <div class="icon">
              <i class="fas fa-exclamation-triangle"></i>
            </div>
            <a href="inventory/manage.php" class="small-box-footer">Inventory <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
      </div>

      <!-- SALES CHART -->
      <div class="row">
        <div class="col-md-8">
          <div class="card">
            <div class="card-header"><h3 class="card-title">Monthly Sales</h3></div>
            <div class="card-body">
              <canvas id="salesChart" height="120"></canvas>
            </div>
          </div>
        </div>

        <!-- QUICK ACTIONS -->
        <div class="col-md-4">
          <div class="card card-primary">
            <div class="card-header"><h3 class="card-title">Quick Actions</h3></div>
            <div class="card-body">
              <a href="products/add.php" class="btn btn-primary btn-block">Add Product</a>
              <a href="reports/generate.php" class="btn btn-success btn-block">Generate Report</a>
              <a href="finance/report.php" class="btn btn-warning btn-block">Finance Summary</a>
              <a href="inventory/manage.php" class="btn btn-danger btn-block">Inventory</a>
            </div>
          </div>
        </div>
      </div>

    </div>
  </section>
</div>

<?php include("includes/footer.php"); ?>

<!-- Chart JS -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  const ctx = document.getElementById('salesChart').getContext('2d');
  new Chart(ctx, {
    type: 'bar',
    data: {
      labels: <?= json_encode($months); ?>,
      datasets: [{
        label: 'Sales (₹)',
        data: <?= json_encode($revenues, JSON_NUMERIC_CHECK); ?>,
        backgroundColor: 'rgba(60,141,188,0.9)',
      }]
    },
    options: {
      responsive: true,
      scales: {
        y: { beginAtZero: true }
      }
    }
  });
</script>
