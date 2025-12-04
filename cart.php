<?php
$title = 'Your Cart';
require_once 'db/conn.php';
require_once 'includes/auth.php';
requireLogin(); // must be logged in
require_once 'includes/header.php';

// Handle actions: add, update, remove
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    // ADD TO CART (from product.php)
    if ($action === 'add' && isset($_POST['product_id'], $_POST['quantity'])) {
        $userId    = (int) $_SESSION['user_id'];
        $productId = filter_input(INPUT_POST, 'product_id', FILTER_VALIDATE_INT);
        $qty       = max(1, (int) $_POST['quantity']);

        if ($productId) {
            // Check product & stock
            $stmt = $conn->prepare("SELECT stock FROM products WHERE id = ?");
            $stmt->bind_param('i', $productId);
            $stmt->execute();
            $product = $stmt->get_result()->fetch_assoc();

            if ($product) {
                $stock = (int) $product['stock'];

                if ($stock > 0) {
                    if ($qty > $stock) {
                        $qty = $stock;
                    }

                    // Check if item is already in cart
                    $stmt = $conn->prepare("
                        SELECT id, quantity
                        FROM cart
                        WHERE user_id = ? AND product_id = ?
                    ");
                    $stmt->bind_param('ii', $userId, $productId);
                    $stmt->execute();
                    $existing = $stmt->get_result()->fetch_assoc();

                    if ($existing) {
                        // Update quantity (do not exceed stock)
                        $newQty = (int) $existing['quantity'] + $qty;
                        if ($newQty > $stock) {
                            $newQty = $stock;
                        }

                        $upd = $conn->prepare("UPDATE cart SET quantity = ? WHERE id = ?");
                        $upd->bind_param('ii', $newQty, $existing['id']);
                        $upd->execute();
                    } else {
                        // Insert new row
                        $ins = $conn->prepare("
                            INSERT INTO cart (user_id, product_id, quantity)
                            VALUES (?, ?, ?)
                        ");
                        $ins->bind_param('iii', $userId, $productId, $qty);
                        $ins->execute();
                    }
                }
            }
        }

        header('Location: cart.php');
        exit;
    }

    // UPDATE QUANTITY (from cart page)
    if ($action === 'update' && isset($_POST['item_id'], $_POST['quantity'])) {
        $itemId = (int) $_POST['item_id'];
        $qty    = max(1, (int) $_POST['quantity']);

        $stmt = $conn->prepare("UPDATE cart SET quantity = ? WHERE id = ? AND user_id = ?");
        $stmt->bind_param('iii', $qty, $itemId, $_SESSION['user_id']);
        $stmt->execute();

        header('Location: cart.php');
        exit;
    }
    // REMOVE ITEM
    if ($action === 'remove' && isset($_POST['item_id'])) {
        $itemId = (int) $_POST['item_id'];
        $stmt = $conn->prepare("DELETE FROM cart WHERE id = ? AND user_id = ?");
        $stmt->bind_param('ii', $itemId, $_SESSION['user_id']);
        $stmt->execute();

        header('Location: cart.php');
        exit;
    }
}

// Load current cart
$sql = "SELECT c.id AS cart_id, c.quantity, p.*
        FROM cart c
        JOIN products p ON c.product_id = p.id
        WHERE c.user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();

$items = [];
$total = 0;
while ($row = $result->fetch_assoc()) {
    $row['line_total'] = $row['price'] * $row['quantity'];
    $total += $row['line_total'];
    $items[] = $row;
}
?>

<div class="cart-container">
  <h1 class="mb-4">Your Cart</h1>

  <?php if (empty($items)): ?>
    <div class="alert alert-info">
      Your cart is empty. <a href="products.php" class="alert-link">Browse products</a>.
    </div>
  <?php else: ?>

    <div class="table-responsive mb-3">
      <table class="table cart-table align-middle mb-0">
        <thead>
          <tr>
            <th>Product</th>
            <th class="text-center">Price</th>
            <th class="text-center" style="width: 250px;">Quantity</th>
            <th class="text-center">Total</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($items as $item): ?>
            <tr>
              <td>
                <div class="d-flex align-items-center gap-3">
                  <?php if (!empty($item['image_url'])): ?>
                    <img
                      src="<?php echo htmlspecialchars($item['image_url']); ?>"
                      alt="<?php echo htmlspecialchars($item['name']); ?>"
                      class="cart-product-img rounded"
                    >
                  <?php endif; ?>
                  <div>
                    <a href="product.php?id=<?php echo $item['id']; ?>" class="text-white cart-product-name">
                      <?php echo htmlspecialchars($item['name']); ?>
                    </a>
                    <div class="cart-product-category">
                      <?php echo htmlspecialchars($item['category']); ?>
                    </div>
                  </div>
                </div>
              </td>

              <td class="text-center">
                $<?php echo number_format($item['price'], 2); ?>
              </td>

              <td class="text-center">
                <form method="post" class="d-inline-block auto-update-form">
                  <input type="hidden" name="action" value="update">
                  <input type="hidden" name="item_id" value="<?php echo $item['cart_id']; ?>">

                  <input
                    type="number"
                    name="quantity"
                    class="form-control cart-qty-input auto-update-input"
                    min="1"
                    max="<?php echo (int) $item['stock']; ?>"
                    value="<?php echo (int) $item['quantity']; ?>"
                  >
                </form>
              </td>

              <td class="text-center fw-bold">
                $<?php echo number_format($item['line_total'], 2); ?>
              </td>

              <td class="text-center">
                <form method="post" onsubmit="return confirm('Remove this item?');" class="d-inline-block">
                  <input type="hidden" name="action" value="remove">
                  <input type="hidden" name="item_id" value="<?php echo $item['cart_id']; ?>">
                  <button class="btn btn-sm btn-outline-danger" type="submit">Remove</button>
                </form>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
        <tfoot>
          <tr class="cart-total-row">
            <td colspan="3" class="text-end">Total:</td>
            <td class="text-center fw-bold">
              $<?php echo number_format($total, 2); ?>
            </td>
            <td></td>
          </tr>
        </tfoot>
      </table>
    </div>

    <div class="d-flex justify-content-between mt-4">
      <a href="products.php" class="btn btn-outline-light btn-shopping">Continue Shopping</a>
      <a href="checkout.php" class="btn btn-checkout">Proceed to Checkout</a>
    </div>

  <?php endif; ?>
</div>

<?php require 'includes/footer.php'; ?>
