<?php
$title = 'Manage Products';
require_once '../db/conn.php';
require_once '../includes/auth.php';
requireAdmin();
require_once '../includes/header.php';
$result = $conn->query("SELECT * FROM products ORDER BY id ASC");
?>

<h1 class="mb-4">Manage Products</h1>

<a href="product_edit.php" class="btn btn-success mb-3">Add New Product</a>

<div class="table-responsive">
  <table class="table align-middle">
    <thead>
      <tr>
        <th>ID</th>
        <th>Product</th>
        <th>Price</th>
        <th>Stock</th>
        <th>Category</th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      <?php while ($p = $result->fetch_assoc()): ?>
        <tr>
          <td><?php echo (int)$p['id']; ?></td>
          <td><?php echo htmlspecialchars($p['name']); ?></td>
          <td>$<?php echo number_format($p['price'], 2); ?></td>
          <td><?php echo (int)$p['stock']; ?></td>
          <td><?php echo htmlspecialchars($p['category']); ?></td>
          <td>
            <a href="product_edit.php?id=<?php echo $p['id']; ?>" class="btn btn-sm btn-outline-primary">Edit</a>
          </td>
        </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>

<?php require '../includes/footer.php'; ?>
