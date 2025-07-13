<?php include("../includes/auth.php"); ?>
<?php include("../includes/header.php"); ?>
<?php include("../config/db.php"); ?>

<div class="content-wrapper">
  <section class="content-header">
    <div class="container-fluid d-flex justify-content-between align-items-center">
      <h1 class="m-0">➕ Add Product</h1>
      <a href="index.php" class="btn btn-secondary">🔙 Back to List</a>
    </div>
  </section>

  <section class="content">
    <div class="container-fluid">
      <div class="card">
        <div class="card-body">
          <?php
          if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $name = $_POST['name'];
            $price = $_POST['price'];
            $stock = $_POST['stock'];
            $category = $_POST['category'];
            $image = $_FILES['image']['name'];

            if ($image) {
              move_uploaded_file($_FILES['image']['tmp_name'], "../assets/images/" . $image);
            }

            $stmt = $conn->prepare("INSERT INTO products (name, price, stock, category, image) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$name, $price, $stock, $category, $image]);

            echo "<div class='alert alert-success'>✅ Product added successfully!</div>";
          }
          ?>

          <form method="POST" enctype="multipart/form-data">
            <div class="form-group">
              <label>Product Name</label>
              <input type="text" name="name" class="form-control" required>
            </div>
            <div class="form-group">
              <label>Price (₹)</label>
              <input type="number" name="price" class="form-control" required>
            </div>
            <div class="form-group">
              <label>Stock</label>
              <input type="number" name="stock" class="form-control" required>
            </div>
            <div class="form-group">
              <label>Category</label>
              <input type="text" name="category" class="form-control" required>
            </div>
            <div class="form-group">
              <label>Product Image</label>
              <input type="file" name="image" class="form-control-file">
            </div>
            <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Save</button>
          </form>
        </div>
      </div>
    </div>
  </section>
</div>

<?php include("../includes/footer.php"); ?>