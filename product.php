<?php
$title = 'Product Details';
require_once 'db/conn.php';
require_once 'includes/auth.php';  
require_once 'includes/header.php';

// 1. Get product by ID
$productId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!$productId) {
    echo '<div class="alert alert-danger">Invalid product.</div>';
    require 'includes/footer.php';
    exit;
}

// Load product
$stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
$stmt->bind_param('i', $productId);
$stmt->execute();
$productResult = $stmt->get_result();
$product = $productResult->fetch_assoc();

if (!$product) {
    echo '<div class="alert alert-danger">Product not found.</div>';
    require 'includes/footer.php';
    exit;
}

// 2. Handle review submission
$reviewErrors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'add_review') {

    if (!isLoggedIn()) {
        header('Location: login.php?error=login_required');
        exit;
    }

    $rating  = (int)($_POST['rating'] ?? 0);
    $comment = trim($_POST['comment'] ?? '');

    if ($rating < 1 || $rating > 5) {
        $reviewErrors[] = 'Rating must be between 1 and 5 stars.';
    }
    if ($comment === '') {
        $reviewErrors[] = 'Please write a short review.';
    }

    if (empty($reviewErrors)) {
        $userId = (int)$_SESSION['user_id'];

        $stmt = $conn->prepare("
            INSERT INTO reviews (user_id, product_id, rating, comment, created_at)
            VALUES (?, ?, ?, ?, NOW())
        ");
        $stmt->bind_param('iiis', $userId, $productId, $rating, $comment);
        $stmt->execute();

        header("Location: product.php?id=" . $productId . "#reviews");
        exit;
    }
}

// 3. Load reviews 
$statStmt = $conn->prepare("
    SELECT COUNT(*) AS review_count, AVG(rating) AS avg_rating
    FROM reviews
    WHERE product_id = ?
");
$statStmt->bind_param('i', $productId);
$statStmt->execute();
$statsResult = $statStmt->get_result()->fetch_assoc();

$reviewCount = (int)($statsResult['review_count'] ?? 0);
$avgRating   = $reviewCount > 0 ? round($statsResult['avg_rating'], 1) : null;

$revStmt = $conn->prepare("
    SELECT r.*,
           CONCAT(u.first_name, ' ', u.last_name) AS user_name
    FROM reviews r
    JOIN users u ON r.user_id = u.id
    WHERE r.product_id = ?
    ORDER BY r.created_at DESC
");
$revStmt->bind_param('i', $productId);
$revStmt->execute();
$reviews = $revStmt->get_result();
?>

<!-- Small CSS block for stars -->
<style>
  .star-rating {
    display: flex;
    align-items: center;
    gap: 0.5rem;
  }
  .star-rating .stars {
    display: flex;
    gap: 0.1rem;
  }
  .star-rating .star {
    font-size: 1.8rem;
    cursor: pointer;
    color: #cccccc !important;          /* empty star */
    transition: color 0.15s ease-in-out, transform 0.1s;
    user-select: none;
  }
  .star-rating .star.filled {
    color: #ffc107 !important;          /* golden filled star */
  }
  .star-rating .star:hover {
    transform: translateY(-1px);
  }
</style>

<!-- PRODUCT DETAIL LAYOUT -->
<div class="row g-4">
  <!-- LEFT: Image -->
  <div class="col-lg-6 text-center">
    <?php if (!empty($product['image_url'])): ?>
      <img src="<?php echo htmlspecialchars($product['image_url']); ?>"
           alt="<?php echo htmlspecialchars($product['name']); ?>"
           class="img-fluid"
           style="max-height: 450px; object-fit: contain;">
    <?php endif; ?>
  </div>

  <!-- RIGHT: Info + Add to Cart -->
  <div class="col-lg-6">
    <h1 class="mb-3">
      <?php echo htmlspecialchars($product['name']); ?>
    </h1>

    <!-- PRICE -->
    <h3 class="mb-3" style="color:#054890; font-weight:700;">
      $<?php echo number_format($product['price'], 2); ?>
    </h3>

    <p class="mb-2">
      <strong>Category:</strong>
      <?php echo htmlspecialchars($product['category']); ?>
    </p>

    <p class="mb-3">
      <?php echo nl2br(htmlspecialchars($product['description'])); ?>
    </p>

    <p class="mb-3">
      <strong>In stock:</strong>
      <?php echo (int)$product['stock']; ?>
    </p>

    <!-- Add to Cart form -->
    <form method="post" action="cart.php" class="d-flex align-items-center gap-3">
      <input type="hidden" name="action" value="add">
      <input type="hidden" name="product_id" value="<?php echo $productId; ?>">

      <div class="d-flex align-items-center gap-2">
        <label for="quantity" class="mb-0"><strong>Quantity</strong></label>
        <input type="number"
               id="quantity"
               name="quantity"
               class="form-control"
               style="width: 90px;"
               min="1"
               max="<?php echo (int)$product['stock']; ?>"
               value="1">
      </div>

      <button type="submit" class="btn btn-success">
        Add to Cart
      </button>
    </form>
  </div>
</div>

<!-- 4. REVIEWS SECTION -->
<hr class="my-5">

<section id="reviews">
  <div class="d-flex justify-content-between align-items-baseline mb-3">
    <h2 class="mb-0">Customer Reviews</h2>

    <?php if ($reviewCount > 0): ?>
      <div class="text-muted">
        Average rating:
        <strong><?php echo $avgRating; ?>/5</strong>
        (<?php echo $reviewCount; ?> review<?php echo $reviewCount > 1 ? 's' : ''; ?>)
      </div>
    <?php else: ?>
      <div class="text-muted">
        No reviews yet
      </div>
    <?php endif; ?>
  </div>

  <?php if (!empty($reviewErrors)): ?>
    <div class="alert alert-danger">
      <?php foreach ($reviewErrors as $err): ?>
        <div><?php echo htmlspecialchars($err); ?></div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>

  <!-- Review form with STAR RATING -->
  <div class="card mb-4">
    <div class="card-body">
      <?php if (isLoggedIn()): ?>
        <h5 class="card-title mb-3">Leave a review</h5>

        <form method="post" class="row g-3">
          <input type="hidden" name="action" value="add_review">
          <input type="hidden" name="rating" id="rating-input" value="0">

          <div class="mb-3">
            <label class="form-label d-block">Your rating</label>

            <div class="star-rating">
              <div class="stars">
                <?php for ($i = 1; $i <= 5; $i++): ?>
                  <span class="star" data-value="<?php echo $i; ?>">★</span>
                <?php endfor; ?>
              </div>
              <span id="rating-label" class="ms-2 small text-muted"></span>
            </div>
          </div>

          <div class="col-12">
            <label for="comment" class="form-label">Your review</label>
            <textarea id="comment"
                      name="comment"
                      rows="3"
                      class="form-control"
                      required></textarea>
          </div>

          <div class="col-12">
            <button type="submit" class="btn btn-primary">
              Submit Review
            </button>
          </div>
        </form>

      <?php else: ?>
        <p class="mb-0">
          <strong>Want to review this product?</strong>
          <a href="login.php">Log in</a> or
          <a href="register.php">create an account</a>.
        </p>
      <?php endif; ?>
    </div>
  </div>

  <!-- Reviews list -->
  <?php if ($reviewCount > 0): ?>
    <?php while ($rev = $reviews->fetch_assoc()): ?>
      <div class="card mb-3">
        <div class="card-body">
          <div class="d-flex justify-content-between">
            <div>
              <strong><?php echo htmlspecialchars($rev['user_name']); ?></strong>
              <span class="text-warning ms-2">
                <?php
                  $stars = (int)$rev['rating'];
                  for ($i = 0; $i < $stars; $i++) echo '★';
                  for ($i = $stars; $i < 5; $i++) echo '☆';
                ?>
              </span>
            </div>
            <small class="text-muted">
              <?php echo htmlspecialchars($rev['created_at']); ?>
            </small>
          </div>

          <p class="mt-2 mb-0">
            <?php echo nl2br(htmlspecialchars($rev['comment'])); ?>
          </p>
        </div>
      </div>
    <?php endwhile; ?>
  <?php else: ?>
    <p class="text-muted">Be the first one to review this product.</p>
  <?php endif; ?>

</section>

<!-- Star widget JS -->
<script>
document.addEventListener("DOMContentLoaded", function () {
    const stars = document.querySelectorAll(".star-rating .star");
    const ratingInput = document.getElementById("rating-input");
    const label = document.getElementById("rating-label");

    if (!stars.length || !ratingInput) return;

    let selectedRating = 0;

    const labels = {
        1: "Poor",
        2: "Fair",
        3: "Good",
        4: "Very good",
        5: "Excellent"
    };

    function paintStars(rating) {
        stars.forEach(star => {
            const starVal = parseInt(star.dataset.value);
            star.classList.toggle("filled", starVal <= rating);
        });
    }

    stars.forEach(star => {
        star.addEventListener("mouseenter", () => {
            const value = parseInt(star.dataset.value);
            paintStars(value);
            label.textContent = `${value} ★ – ${labels[value]}`;
        });

        star.addEventListener("click", () => {
            selectedRating = parseInt(star.dataset.value);
            ratingInput.value = selectedRating;  
            paintStars(selectedRating);
            label.textContent = `${selectedRating} ★ – ${labels[selectedRating]}`;
        });
    });

    document.querySelector(".star-rating").addEventListener("mouseleave", () => {
        paintStars(selectedRating);
        label.textContent = selectedRating
          ? `${selectedRating} ★ – ${labels[selectedRating]}` 
          : "";
    });
});
</script>

<?php require 'includes/footer.php'; ?>
