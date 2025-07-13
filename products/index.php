<?php include("../includes/auth.php"); ?>
<?php include("../includes/header.php"); ?>
<?php include("../config/db.php"); ?>

<div class="content-wrapper">
  <!-- Header Section -->
  <section class="content-header">
    <div class="container-fluid d-flex justify-content-between align-items-center">
      <h1 class="m-0">🛒 Products</h1>
      <a href="add.php" class="btn btn-primary">
        <i class="fas fa-plus"></i> Add Product
      </a>
    </div>
  </section>

  <!-- Main Content -->
  <section class="content">
    <div class="container-fluid">

      <!-- Filter & Sort Dropdowns -->
      <div class="mb-3 d-flex align-items-center">
        <strong class="me-3">Filter by Category:</strong>
        <select id="categoryFilter" class="form-select form-select-sm me-3" style="width:auto;">
          <option value="all" <?= (!isset($_GET['category']) || $_GET['category'] == 'all') ? 'selected' : '' ?>>All</option>
          <option value="Clothing" <?= (isset($_GET['category']) && $_GET['category'] == 'Clothing') ? 'selected' : '' ?>>Clothing</option>
          <option value="Accessories" <?= (isset($_GET['category']) && $_GET['category'] == 'Accessories') ? 'selected' : '' ?>>Accessories</option>
          <option value="Toys" <?= (isset($_GET['category']) && $_GET['category'] == 'Toys') ? 'selected' : '' ?>>Toys</option>
          <option value="Stationery" <?= (isset($_GET['category']) && $_GET['category'] == 'Stationery') ? 'selected' : '' ?>>Stationery</option>
          <option value="Posters" <?= (isset($_GET['category']) && $_GET['category'] == 'Posters') ? 'selected' : '' ?>>Posters</option>
        </select>

        <strong class="me-3">Sort by ID:</strong>
        <select id="sortOrder" class="form-select form-select-sm" style="width:auto;">
          <option value="desc" <?= (!isset($_GET['sort']) || $_GET['sort'] == 'desc') ? 'selected' : '' ?>>Descending</option>
          <option value="asc" <?= (isset($_GET['sort']) && $_GET['sort'] == 'asc') ? 'selected' : '' ?>>Ascending</option>
        </select>
      </div>

      <!-- Product Table -->
      <div class="card">
        <div class="card-header bg-dark">
          <h3 class="card-title text-white">Product List</h3>
        </div>
        <div class="card-body p-0">
          <table class="table table-bordered table-hover table-striped mb-0 text-center">
            <thead class="thead-light">
              <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Price (₹)</th>
                <th>Stock</th>
                <th>Category</th>
                <th>Image</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $sort = (isset($_GET['sort']) && strtolower($_GET['sort']) == 'asc') ? 'ASC' : 'DESC';

              if (isset($_GET['category']) && $_GET['category'] != 'all') {
                $category = $_GET['category'];
                $stmt = $conn->prepare("SELECT * FROM products WHERE category = ? ORDER BY id $sort");
                $stmt->execute([$category]);
              } else {
                $stmt = $conn->query("SELECT * FROM products ORDER BY id $sort");
              }

              while ($row = $stmt->fetch()) {
                echo "<tr>
                  <td>{$row['id']}</td>
                  <td>{$row['name']}</td>
                  <td>₹{$row['price']}</td>
                  <td>{$row['stock']}</td>
                  <td>{$row['category']}</td>
                  <td><img src='../assets/images/{$row['image']}' width='60' height='60' style='object-fit:cover;'></td>
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

<script>
  const categoryFilter = document.getElementById('categoryFilter');
  const sortOrder = document.getElementById('sortOrder');

  function applyFilters() {
    const category = categoryFilter.value;
    const sort = sortOrder.value;
    let url = 'index.php?';

    if (category !== 'all') {
      url += 'category=' + encodeURIComponent(category) + '&';
    }
    url += 'sort=' + encodeURIComponent(sort);
    window.location.href = url;
  }

  categoryFilter.addEventListener('change', applyFilters);
  sortOrder.addEventListener('change', applyFilters);
</script>

<?php include("../includes/footer.php"); ?>
