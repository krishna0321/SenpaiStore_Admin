<?php include("../includes/auth.php"); ?>
<?php include("../includes/header.php"); ?>
<?php include("../config/db.php"); ?>

<?php
$id = $_GET['id'];
$stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
$stmt->execute([$id]);
$product = $stmt->fetch();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $name = $_POST['name'];
  $price = $_POST['price'];
  $stock = $_POST['stock'];
  $category = $_POST['category'];
  $image = $_FILES['image']['name'] ?: $product['image'];

  if ($_FILES['image']['name']) {
    move_uploaded_file($_FILES['image']['tmp_name'], "../assets/images/" . $image);
  }

  $update = $conn->prepare("UPDATE products SET name=?, price=?, stock=?, category=?, image=? WHERE id=?");
  $update->execute([$name, $price, $stock, $category, $image, $id]);

  echo "<div class='alert alert-success'>✅ Product updated successfully!</div>";

  // Refresh product data after update
  $product['name'] = $name;
  $product['price'] = $price;
  $product['stock'] = $stock;
  $product['category'] = $category;
  $product['image'] = $image;
}
?>

<div class="content-wrapper">
  <section class="content-header">
    <div class="container-fluid d-flex justify-content-between align-items-center">
      <h1 class="m-0">✏️ Edit Product #<?= $product['id'] ?></h1>
      <a href="index.php" class="btn btn-secondary">🔙 Back to List</a>
    </div>
  </section>

  <section class="content">
    <div class="container-fluid">
      <div class="card">
        <div class="card-body">
          <form method="POST" enctype="multipart/form-data">
            <div class="form-group">
              <label>Product Name</label>
              <input type="text" name="name" class="form-control" value="<?= $product['name'] ?>" required>
            </div>
            <div class="form-group">
              <label>Price (₹)</label>
              <input type="number" name="price" class="form-control" value="<?= $product['price'] ?>" required>
            </div>
            <div class="form-group">
              <label>Stock</label>
              <input type="number" name="stock" class="form-control" value="<?= $product['stock'] ?>" required>
            </div>
            <div class="form-group">
              <label>Category</label>
              <input type="text" name="category" class="form-control" value="<?= $product['category'] ?>" required>
            </div>
            <div class="form-group">
              <label>Current Image</label><br>
              <img src="../assets/images/<?= $product['image'] ?>" width="100">
            </div>
            <div class="form-group">
              <label>Change Image</label>
              <input type="file" name="image" class="form-control-file">
            </div>
            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Update</button>
          </form>
        </div>
      </div>
    </div>
  </section>
</div>

<?php include("../includes/footer.php"); ?>