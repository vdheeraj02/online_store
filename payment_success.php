<?php
$title = 'Payment Successful';

require_once 'db/conn.php';
require_once 'includes/auth.php';
requireLogin();
require_once 'includes/header.php';

$userId  = (int)$_SESSION['user_id'];
$orderId = filter_input(INPUT_GET, 'order_id', FILTER_VALIDATE_INT);

// If there is no order_id
if (!$orderId) {
    echo '<div class="alert alert-warning mt-4">No order information was provided.</div>';
    require 'includes/footer.php';
    exit;
}

// 1) Load the order (and ensure it belongs to this user)
$stmt = $conn->prepare("
    SELECT id, user_id, first_name, last_name, email,
           address, city, province, postal_code,
           total_price, order_date
    FROM orders
    WHERE id = ? AND user_id = ?
");
$stmt->bind_param('ii', $orderId, $userId);
$stmt->execute();
$order = $stmt->get_result()->fetch_assoc();

if (!$order) {
    echo '<div class="alert alert-danger mt-4">We could not find this order.</div>';
    require 'includes/footer.php';
    exit;
}

// 2) Load order items
$itemStmt = $conn->prepare("
    SELECT oi.product_id, oi.quantity, oi.price_each,
           p.name, p.image_url
    FROM order_items oi
    JOIN products p ON oi.product_id = p.id
    WHERE oi.order_id = ?
");
$itemStmt->bind_param('i', $orderId);
$itemStmt->execute();
$itemsResult = $itemStmt->get_result();

$items = [];
while ($row = $itemsResult->fetch_assoc()) {
    $items[] = $row;
}
?>

<div class="mt-4">

  <h1 class="mb-3">Payment Successful</h1>

  <p class="mb-3">
    Thank you, <strong><?php echo htmlspecialchars($order['first_name']); ?></strong>!
    Your PayPal payment and order have been completed successfully.
  </p>

  <div class="alert alert-success">
    <strong>Order #<?php echo htmlspecialchars($order['id']); ?></strong> has been placed.
  </div>

  <!-- Order summary -->
  <div class="row g-4 mt-3">
    <div class="col-lg-6">
      <div class="border rounded p-3 h-100">
        <h4 class="mb-3">Order Summary</h4>
        <p class="mb-1">
          <strong>Order ID:</strong>
          <?php echo htmlspecialchars($order['id']); ?>
        </p>
        <p class="mb-1">
          <strong>Order Date:</strong>
          <?php echo htmlspecialchars($order['order_date']); ?>
        </p>
        <p class="mb-1">
          <strong>Email:</strong>
          <?php echo htmlspecialchars($order['email']); ?>
        </p>
        <p class="mb-0">
          <strong>Total Paid:</strong>
          $<?php echo number_format((float)$order['total_price'], 2); ?>
        </p>
      </div>
    </div>

    <!-- Shipping details -->
    <div class="col-lg-6">
      <div class="border rounded p-3 h-100">
        <h4 class="mb-3">Shipping Details</h4>
        <p class="mb-0">
          <?php echo htmlspecialchars($order['first_name'] . ' ' . $order['last_name']); ?><br>
          <?php if (!empty($order['address'])): ?>
            <?php echo htmlspecialchars($order['address']); ?><br>
          <?php endif; ?>

          <?php if (!empty($order['city'])): ?>
            <?php echo htmlspecialchars($order['city']); ?>
          <?php endif; ?>

          <?php if (!empty($order['province'])): ?>
            <?php echo ', ' . htmlspecialchars($order['province']); ?>
          <?php endif; ?>

          <?php if (!empty($order['postal_code'])): ?>
            <br><?php echo htmlspecialchars($order['postal_code']); ?>
          <?php endif; ?>
        </p>
      </div>
    </div>
  </div>

  <!-- Items table -->
  <div class="mt-4">
    <h4 class="mb-3">Items in this Order</h4>

    <?php if (empty($items)): ?>
      <p class="text-muted">No items were found for this order.</p>
    <?php else: ?>
      <div class="table-responsive">
        <table class="table align-middle">
          <thead>
            <tr>
              <th>Product</th>
              <th class="text-center">Price (each)</th>
              <th class="text-center">Quantity</th>
              <th class="text-center">Line Total</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($items as $it): ?>
              <?php $lineTotal = $it['price_each'] * $it['quantity']; ?>
              <tr>
                <td>
                  <div class="d-flex align-items-center gap-3">
                    <?php if (!empty($it['image_url'])): ?>
                      <img
                        src="<?php echo htmlspecialchars($it['image_url']); ?>"
                        alt="<?php echo htmlspecialchars($it['name']); ?>"
                        style="width: 60px; height: 60px; object-fit: contain;"
                        class="rounded"
                      >
                    <?php endif; ?>
                    <span><?php echo htmlspecialchars($it['name']); ?></span>
                  </div>
                </td>
                <td class="text-center">
                  $<?php echo number_format((float)$it['price_each'], 2); ?>
                </td>
                <td class="text-center">
                  x<?php echo (int)$it['quantity']; ?>
                </td>
                <td class="text-center fw-bold">
                  $<?php echo number_format($lineTotal, 2); ?>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
          <tfoot>
            <tr>
              <td colspan="3" class="text-end"><strong>Total:</strong></td>
              <td class="text-center fw-bold">
                $<?php echo number_format((float)$order['total_price'], 2); ?>
              </td>
            </tr>
          </tfoot>
        </table>
      </div>
    <?php endif; ?>
  </div>

  <a href="index.php" class="btn btn-primary mt-4">Return to Home</a>

</div>

<?php require 'includes/footer.php'; ?>

