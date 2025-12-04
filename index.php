<?php
$title = 'Home';
require_once 'db/conn.php';
require_once 'includes/header.php';

$result = $conn->query("SELECT * FROM products ORDER BY id DESC LIMIT 8");
$products = [];
while ($row = $result->fetch_assoc()) {
  $products[] = $row;
}
?>

<!-- HERO SLIDER SECTION -->
<div id="homeCarousel" class="carousel slide mb-5" data-bs-ride="carousel">

  <!-- Slider buttons -->
  <div class="carousel-indicators">
    <button type="button" data-bs-target="#homeCarousel" data-bs-slide-to="0" class="active"></button>
    <button type="button" data-bs-target="#homeCarousel" data-bs-slide-to="1"></button>
    <button type="button" data-bs-target="#homeCarousel" data-bs-slide-to="2"></button>
  </div>

  <!-- Slides -->
  <div class="carousel-inner">

    <div class="carousel-item active">
      <img src="img/slider1.jpg" class="d-block w-100 slider-img" alt="Slide 1">
    </div>

    <div class="carousel-item">
      <img src="img/slider2.jpg" class="d-block w-100 slider-img" alt="Slide 2">
    </div>

    <div class="carousel-item">
      <img src="img/slider3.jpg" class="d-block w-100 slider-img" alt="Slide 3">
    </div>

  </div>

  <!-- Arrows -->
  <button class="carousel-control-prev" type="button" data-bs-target="#homeCarousel" data-bs-slide="prev">
    <span class="carousel-control-prev-icon"></span>
  </button>

  <button class="carousel-control-next" type="button" data-bs-target="#homeCarousel" data-bs-slide="next">
    <span class="carousel-control-next-icon"></span>
  </button>
</div>


<!-- FEATURED PRODUCTS – FULL WIDTH -->
<section class="featured-section py-5">
  <div class="container">
    <h1 class="text-center text-white mb-4">Featured Products</h1>
  </div>

  <!-- full-width carousel -->
  <div id="featuredCarousel" class="carousel slide featured-carousel" data-bs-ride="carousel">
    <div class="carousel-inner">

      <?php for ($i = 0; $i < count($products); $i += 4): ?>
        <div class="carousel-item <?php echo $i === 0 ? 'active' : ''; ?>">
          <div class="d-flex justify-content-center gap-4 flex-wrap featured-row">
            <?php for ($j = $i; $j < $i + 4 && $j < count($products); $j++): 
              $p = $products[$j]; ?>
              
              <!-- Make the whole card clickable like products page -->
              <a href="product.php?id=<?php echo (int)$p['id']; ?>"
                 class="featured-link text-decoration-none">
                <div class="featured-item text-center">
                  <div class="featured-image-wrapper">
                    <img
                      src="<?php echo htmlspecialchars($p['image_url']); ?>"
                      alt="<?php echo htmlspecialchars($p['name']); ?>"
                      class="featured-image img-fluid"
                    >
                  </div>
                  <div class="featured-name mt-3 ">
                    <?php echo htmlspecialchars($p['name']); ?>
                  </div>
                </div>
              </a>

            <?php endfor; ?>
          </div>
        </div>
      <?php endfor; ?>

    </div>

    <button class="carousel-control-prev" type="button" data-bs-target="#featuredCarousel" data-bs-slide="prev">
      <span class="carousel-control-prev-icon featured-arrow" aria-hidden="true"></span>
      <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#featuredCarousel" data-bs-slide="next">
      <span class="carousel-control-next-icon featured-arrow" aria-hidden="true"></span>
      <span class="visually-hidden">Next</span>
    </button>
  </div>
</section>

<?php require 'includes/footer.php'; ?>
