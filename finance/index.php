<?php
include("../config/db.php");
include("../includes/auth.php");
include("../includes/header.php");
?>

<div class="content-wrapper">
  <section class="content-header">
    <div class="container-fluid">
      <h1>Finance Dashboard</h1>
      <p>Overview of revenue, expenses, and profit</p>
    </div>
  </section>

  <section class="content">
    <div class="container-fluid">
      <?php
      // Total Sales
      $stmtSales = $conn->query("SELECT SUM(total_price) AS total_sales FROM orders");
      $totalSales = $stmtSales->fetch(PDO::FETCH_ASSOC)['total_sales'] ?? 0;

      // Expenses (placeholder logic - adapt as needed)
      $stmtExpenses = $conn->query("SELECT SUM(amount) AS total_expenses FROM expenses");
      $totalExpenses = $stmtExpenses->fetch(PDO::FETCH_ASSOC)['total_expenses'] ?? 0;

      // Profit
      $profit = $totalSales - $totalExpenses;
      ?>

      <div class="row">
        <div class="col-lg-4 col-6">
          <div class="small-box bg-success">
            <div class="inner">
              <h3>₹<?= number_format($totalSales, 2) ?></h3>
              <p>Total Revenue</p>
            </div>
            <div class="icon">
              <i class="fas fa-rupee-sign"></i>
            </div>
          </div>
        </div>

        <div class="col-lg-4 col-6">
          <div class="small-box bg-danger">
            <div class="inner">
              <h3>₹<?= number_format($totalExpenses, 2) ?></h3>
              <p>Total Expenses</p>
            </div>
            <div class="icon">
              <i class="fas fa-wallet"></i>
            </div>
          </div>
        </div>

        <div class="col-lg-4 col-6">
          <div class="small-box bg-info">
            <div class="inner">
              <h3>₹<?= number_format($profit, 2) ?></h3>
              <p>Net Profit</p>
            </div>
            <div class="icon">
              <i class="fas fa-chart-line"></i>
            </div>
          </div>
        </div>
      </div>

      <a href="report.php" class="btn btn-primary mt-3">View Financial Report</a>
    </div>
  </section>
</div>

<?php include("../includes/footer.php"); ?>
