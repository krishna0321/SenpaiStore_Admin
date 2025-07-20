<?php
include("../config/db.php");
include("../includes/auth.php");
include("../includes/header.php");
?>

<div class="content-wrapper">
  <section class="content-header">
    <div class="container-fluid">
      <h1>Financial Report</h1>
      <p>Select date range to view sales and expenses</p>
    </div>
  </section>

  <section class="content">
    <div class="container-fluid">
      <form method="get" class="mb-4">
        <div class="row">
          <div class="col-md-4">
            <label>Start Date:</label>
            <input type="date" name="start_date" class="form-control" required>
          </div>
          <div class="col-md-4">
            <label>End Date:</label>
            <input type="date" name="end_date" class="form-control" required>
          </div>
          <div class="col-md-4">
            <label>&nbsp;</label><br>
            <button type="submit" class="btn btn-primary">Generate Report</button>
          </div>
        </div>
      </form>

      <?php
      if (isset($_GET['start_date'], $_GET['end_date'])) {
        $start = $_GET['start_date'];
        $end = $_GET['end_date'];

        // Sales
        $stmtSales = $conn->prepare("SELECT SUM(total_price) AS total_sales FROM orders WHERE created_at BETWEEN :start AND :end");
        $stmtSales->execute(['start' => $start, 'end' => $end]);
        $totalSales = $stmtSales->fetch(PDO::FETCH_ASSOC)['total_sales'] ?? 0;

        // Expenses (placeholder)
        $stmtExpenses = $conn->prepare("SELECT SUM(amount) AS total_expenses FROM expenses WHERE date BETWEEN :start AND :end");
        $stmtExpenses->execute(['start' => $start, 'end' => $end]);
        $totalExpenses = $stmtExpenses->fetch(PDO::FETCH_ASSOC)['total_expenses'] ?? 0;

        $profit = $totalSales - $totalExpenses;

        echo "<h4>Financial Summary: <b>$start</b> to <b>$end</b></h4>";
        echo "<ul class='list-group mt-3'>";
        echo "<li class='list-group-item'>Total Revenue: <b>₹" . number_format($totalSales, 2) . "</b></li>";
        echo "<li class='list-group-item'>Total Expenses: <b>₹" . number_format($totalExpenses, 2) . "</b></li>";
        echo "<li class='list-group-item'>Net Profit: <b>₹" . number_format($profit, 2) . "</b></li>";
        echo "</ul>";
      }
      ?>
    </div>
  </section>
</div>

<?php include("../includes/footer.php"); ?>
