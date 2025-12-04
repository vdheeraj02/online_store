<?php
$title = 'Edit Product';
require_once '../db/conn.php';
require_once '../includes/auth.php';
requireAdmin();
require_once '../includes/header.php';

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$editing = $id > 0;

$name = $desc = $image = $category = '';
$price = '';
$stock = 0;
$errors = [];

if ($editing) {
    $stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $prod = $stmt->get_result()->fetch_assoc();
    if (!$prod) {
        echo '<div class="alert alert-danger">Product not found.</div>';
        require '../includes/footer.php';
        exit;
    }
    $name = $prod['name'];
    $desc = $prod['description'];
    $image = $prod['image_url'];
    $category = $prod['category'];
    $price = $prod['price'];
    $stock = $prod['stock'];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $desc = trim($_POST['description'] ?? '');
    $image = trim($_POST['image_url'] ?? '');
    $category = trim($_POST['category'] ?? '');
    $price = (float) ($_POST['price'] ?? 0);
    $stock = (int) ($_POST['stock'] ?? 0);

    if ($name === '' || $price <= 0) {
        $errors[] = 'Name and price are required.';
    }

    if (empty($errors)) {
        if ($editing) {
            $stmt = $conn->prepare("UPDATE products
                                    SET name=?, description=?, price=?, image_url=?, category=?, stock=?
                                    WHERE id=?");
            $stmt->bind_param('ssdssii', $name, $desc, $price, $image, $category, $stock, $id);
            $stmt->execute();
        } else {
            $stmt = $conn->prepare("INSERT INTO products
                                    (name, description, price, image_url, category, stock)
                                    VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param('ssdssi', $name, $desc, $price, $image, $category, $stock);
            $stmt->execute();
            $id = $stmt->insert_id;
            $editing = true;
        }

        header('Location: products.php');
        exit;
    }
}
?>

<h1 class="mb-4"><?php echo $editing ? 'Edit Product' : 'Add New Product'; ?></h1>

<?php if (!empty($errors)): ?>
  <div class="alert alert-danger">
    <?php foreach ($errors as $e) echo '<div>'.htmlspecialchars($e).'</div>'; ?>
  </div>
<?php endif; ?>

<form method="post" class="col-md-8 needs-validation" novalidate>
  <div class="mb-3">
    <label class="form-label" for="name">Product Name</label>
    <input type="text" id="name" name="name" class="form-control" required
           value="<?php echo htmlspecialchars($name); ?>">
  </div>
  <div class="mb-3">
    <label class="form-label" for="description">Description</label>
    <textarea id="description" name="description" class="form-control" rows="4"><?php
      echo htmlspecialchars($desc);
    ?></textarea>
  </div>
  <div class="mb-3">
    <label class="form-label" for="image_url">Image URL</label>
    <input type="text" id="image_url" name="image_url" class="form-control"
           value="<?php echo htmlspecialchars($image); ?>">
  </div>
  <div class="mb-3">
    <label class="form-label" for="category">Category</label>
    <input type="text" id="category" name="category" class="form-control"
           value="<?php echo htmlspecialchars($category); ?>">
  </div>
  <div class="row">
    <div class="col-md-4 mb-3">
      <label class="form-label" for="price">Price</label>
      <input type="number" step="0.01" id="price" name="price" class="form-control" required
             value="<?php echo htmlspecialchars($price); ?>">
    </div>
    <div class="col-md-4 mb-3">
      <label class="form-label" for="stock">Stock</label>
      <input type="number" id="stock" name="stock" class="form-control" min="0"
             value="<?php echo (int)$stock; ?>">
    </div>
  </div>
  <button type="submit" class="btn btn-primary">
    <?php echo $editing ? 'Save Changes' : 'Create Product'; ?>
  </button>
  <a href="products.php" class="btn btn-outline-secondary">Cancel</a>
</form>

<?php require '../includes/footer.php'; ?>
