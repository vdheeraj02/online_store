<?php
require_once '../db/conn.php';
require_once '../includes/auth.php';
requireAdmin();
require_once '../includes/header.php';

// Fetch latest 4 products
$result = $conn->query("SELECT * FROM products ORDER BY id ASC LIMIT 4");
?>

<div class="full-width-wrapper py-4">

  <!-- HEADER AREA -->
  <div class="row align-items-center mb-5">

    <!-- LOGO -->
    <div class="col-lg-4 text-center">
      <img src="/online_store/img/logo.png"
           alt="Gigabyte Logo"
           class="img-fluid"
           style="max-width: 260px;">
    </div>

    <!-- TEXT + BUTTON -->
    <div class="col-lg-8">

      <h1 class="fw-bold mb-3">
        Welcome to the <span class="text-primary">GIGABYTE</span> Admin Dashboard
      </h1>

      <a href="products.php" class="btn btn-primary btn-lg px-4">
        Manage Products
      </a>
      <a href="orders.php" class="btn btn-secondary btn-lg px-4 ms-3">
        Orders
      </a>

    </div>
  </div>

  <!-- LATEST PRODUCTS -->
  <h3 class="fw-bold mb-4">Latest Products</h3>

  <!-- Grid wrapper for gaps & alignment -->
  <div class="latest-products-grid">
    <?php while ($p = $result->fetch_assoc()): ?>
      <?php
        $imgSrc = $p['image_url'];

        if (!empty($imgSrc)) {
          if (!preg_match('#^https?://#', $imgSrc) && strpos($imgSrc, '/') !== 0) {
              
              $imgSrc = '/online_store/' . ltrim($imgSrc, '/');
          } elseif (strpos($imgSrc, '/') === 0
                    && strpos($imgSrc, '/online_store/') !== 0
                    && !preg_match('#^https?://#', $imgSrc)) {
              $imgSrc = '/online_store' . $imgSrc;
          }
        }
      ?>

      <a href="/online_store/product.php?id=<?php echo $p['id']; ?>"
         class="admin-product-card text-decoration-none text-light">

        <!-- IMAGE -->
        <?php if (!empty($imgSrc)): ?>
          <img
            src="<?php echo htmlspecialchars($imgSrc); ?>"
            alt="Product Image"
            class="admin-product-image"
          >
        <?php else: ?>
          <div class="admin-product-image d-flex justify-content-center align-items-center text-muted">
            No Image
          </div>
        <?php endif; ?>

        <!-- TEXT -->
        <div class="admin-product-body">
          <h4 class="mb-2">
            <?php echo htmlspecialchars($p['name']); ?>
          </h4>
          <div class="price-text">
            $<?php echo number_format($p['price'], 2); ?>
          </div>
        </div>

      </a>
    <?php endwhile; ?>
  </div>

</div>

<?php require_once '../includes/footer.php'; ?>
