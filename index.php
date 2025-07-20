<?php include("includes/auth.php"); ?>
<?php include("includes/header.php"); ?>

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
              <h3>23</h3> <!-- Replace with DB count later -->
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
              <h3>9</h3> <!-- Replace with DB count later -->
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
              <h3>₹50,000</h3>
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
              <h3>3</h3> <!-- Replace with DB count -->
              <p>Low Stock</p>
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
      labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
      datasets: [{
        label: 'Sales (₹)',
        data: [5000, 7000, 4500, 6000, 8000, 9000],
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
