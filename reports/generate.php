<?php
include("../config/db.php");
include("../includes/auth.php");
include("../includes/header.php");
?>

<div class="content-wrapper">
  <section class="content-header">
    <div class="container-fluid">
      <h1>Report Generator</h1>
      <p>Generate Sales & Order Reports</p>
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
            <button type="submit" class="btn btn-primary">Generate</button>
          </div>
        </div>
      </form>

      <?php
      if (isset($_GET['start_date'], $_GET['end_date'])) {
        $start = $_GET['start_date'];
        $end = $_GET['end_date'];

        $stmt = $conn->prepare("SELECT * FROM orders WHERE created_at BETWEEN :start AND :end");
        $stmt->execute(['start' => $start, 'end' => $end]);
        $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo "<h4>Report from <b>$start</b> to <b>$end</b></h4>";
        echo "<table class='table table-bordered mt-3'><thead><tr>
          <th>ID</th><th>Customer</th><th>Product</th><th>Qty</th><th>Total</th><th>Date</th>
        </tr></thead><tbody>";

        $total = 0;
        foreach ($orders as $row) {
          echo "<tr>
            <td>{$row['id']}</td>
            <td>{$row['customer_name']}</td>
            <td>{$row['product_name']}</td>
            <td>{$row['quantity']}</td>
            <td>₹{$row['total_price']}</td>
            <td>{$row['created_at']}</td>
          </tr>";
          $total += $row['total_price'];
        }

        echo "</tbody></table>";
        echo "<h5><b>Total Revenue:</b> ₹" . number_format($total, 2) . "</h5>";
      }
      ?>
    </div>
  </section>
</div>

<?php include("../includes/footer.php"); ?>