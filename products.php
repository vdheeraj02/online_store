<?php
$title = 'Products';
require_once 'db/conn.php';
require_once 'includes/header.php';

$search   = trim($_GET['q'] ?? '');
$category = trim($_GET['category'] ?? '');

// Build query
$sql    = "SELECT * FROM products WHERE 1=1";
$params = [];
$types  = '';

if ($search !== '') {
    $sql .= " AND (name LIKE ? OR description LIKE ?)";
    $like = "%$search%";
    $params[] = $like;
    $params[] = $like;
    $types   .= 'ss';
}

if ($category !== '') {
    $sql .= " AND category = ?";
    $params[] = $category;
    $types   .= 's';
}

$stmt = $conn->prepare($sql);
if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$result = $stmt->get_result();

// Get distinct categories for dropdown
$catResult = $conn->query("SELECT DISTINCT category FROM products ORDER BY category");
?>

<h1 class="mb-3">All Products</h1>

<form method="get" class="row g-2 mb-4">
  <div class="col-md-4">
    <input type="text"
           name="q"
           class="form-control"
           placeholder="Search products..."
           value="<?php echo htmlspecialchars($search); ?>">
  </div>

  <div class="col-md-3">
    <select name="category" class="form-select">
      <option value="">All Categories</option>
      <?php while ($cat = $catResult->fetch_assoc()): ?>
        <option value="<?php echo htmlspecialchars($cat['category']); ?>"
          <?php if ($category === $cat['category']) echo 'selected'; ?>>
          <?php echo htmlspecialchars($cat['category']); ?>
        </option>
      <?php endwhile; ?>
    </select>
  </div>

  <div class="col-md-2">
    <button type="submit" class="btn btn-primary w-100">Filter</button>
  </div>
</form>

<div class="row g-4">
  <?php while ($p = $result->fetch_assoc()): ?>
    <div class="col-md-3 mb-4">
      <div class="card h-100 product-card">
        <a href="product.php?id=<?php echo $p['id']; ?>" class="product-link">
          <img src="<?php echo htmlspecialchars($p['image_url']); ?>"
               class="card-img-top"
               alt="<?php echo htmlspecialchars($p['name']); ?>">

          <div class="card-body d-flex flex-column">
            <h5 class="card-title">
              <?php echo htmlspecialchars($p['name']); ?>
            </h5>

            <div class="fw-bold mb-2">
              $<?php echo number_format($p['price'], 2); ?>
            </div>
          </div>
        </a>
      </div>
    </div>
  <?php endwhile; ?>
</div>

<?php require 'includes/footer.php'; ?>
