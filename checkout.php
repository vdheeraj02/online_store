<?php
$title = 'Checkout';
require_once 'db/conn.php';
require_once 'includes/auth.php';
requireLogin();
require_once 'includes/header.php';

$userId = (int)$_SESSION['user_id'];

$orderConfirmed = false;
$orderError     = "";

/**
 * Inserts into orders
 * Inserts into order_items
 * Updates product stock
 * Clears cart
 * Returns the new order_id on success, or 0 on failure
 */
function placeOrder(
    mysqli $conn,
    int $userId,
    array $items,
    string $first_name,
    string $last_name,
    string $email,
    string $address,
    string $city,
    string $province,
    string $postal_code,
    float $total,
    string &$orderError
): int {

    if (empty($items)) {
        $orderError = "Your cart is empty.";
        return 0;
    }

    $conn->begin_transaction();

    try {
        // Insert order
        $orderSql = "
            INSERT INTO orders
              (user_id, first_name, last_name, email,
               address, city, province, postal_code,
               total_price, order_date)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())
        ";

        $orderStmt = $conn->prepare($orderSql);
        if (!$orderStmt) {
            throw new Exception("Prepare order failed: " . $conn->error);
        }
        $orderStmt->bind_param(
            'isssssssd',
            $userId,
            $first_name,
            $last_name,
            $email,
            $address,
            $city,
            $province,
            $postal_code,
            $total
        );

        if (!$orderStmt->execute()) {
            throw new Exception("Order insert failed: " . $orderStmt->error);
        }

        $orderId = $orderStmt->insert_id;

        // Insert items
        $itemSql = "
            INSERT INTO order_items (order_id, product_id, quantity, price_each)
            VALUES (?, ?, ?, ?)
        ";
        $itemStmt = $conn->prepare($itemSql);
        if (!$itemStmt) {
            throw new Exception("Prepare items failed: " . $conn->error);
        }

        // Update stock
        $stockStmt = $conn->prepare("
            UPDATE products
            SET stock = stock - ?
            WHERE id = ? AND stock >= ?
        ");
        if (!$stockStmt) {
            throw new Exception("Prepare stock failed: " . $conn->error);
        }

        foreach ($items as $it) {
            $pid   = (int)$it['id'];
            $qty   = (int)$it['quantity'];
            $price = (float)$it['price'];

            // order_items
            $itemStmt->bind_param('iiid', $orderId, $pid, $qty, $price);
            if (!$itemStmt->execute()) {
                throw new Exception("Insert order_items failed: " . $itemStmt->error);
            }

            // inventory
            $stockStmt->bind_param('iii', $qty, $pid, $qty);
            if (!$stockStmt->execute()) {
                throw new Exception("Stock update failed for product ID {$pid}: " . $stockStmt->error);
            }
            if ($stockStmt->affected_rows === 0) {
                throw new Exception("Not enough stock for product ID {$pid}.");
            }
        }

        // Clear cart
        $del = $conn->prepare("DELETE FROM cart WHERE user_id = ?");
        if (!$del) {
            throw new Exception("Prepare cart delete failed: " . $conn->error);
        }
        $del->bind_param('i', $userId);
        if (!$del->execute()) {
            throw new Exception("Cart delete failed: " . $del->error);
        }

        $conn->commit();
        return $orderId;

    } catch (Exception $e) {
        $conn->rollback();
        $orderError = "There was a problem placing your order. Please try again.";
        return 0;
    }
}

// 1. Load current cart items
$sql = "SELECT c.id AS cart_id, c.quantity, p.*
        FROM cart c
        JOIN products p ON c.product_id = p.id
        WHERE c.user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $userId);
$stmt->execute();
$result = $stmt->get_result();

$items = [];
$total = 0.0;

while ($row = $result->fetch_assoc()) {
    $row['line_total'] = $row['price'] * $row['quantity'];
    $total += $row['line_total'];
    $items[] = $row;
}
// 2. Load user info from users table (shipping details)
$first_name  = '';
$last_name   = '';
$email       = '';
$address     = '';
$city        = '';
$province    = '';
$postal_code = '';

$u = $conn->prepare("
    SELECT first_name, last_name, email, address, city, province, postal_code
    FROM users WHERE id = ?
");
$u->bind_param('i', $userId);
$u->execute();
$uRes = $u->get_result()->fetch_assoc();

if ($uRes) {
    $first_name  = $uRes['first_name']  ?? '';
    $last_name   = $uRes['last_name']   ?? '';
    $email       = $uRes['email']       ?? '';
    $address     = $uRes['address']     ?? '';
    $city        = $uRes['city']        ?? '';
    $province    = $uRes['province']    ?? '';
    $postal_code = $uRes['postal_code'] ?? '';
}

$addressConfirmed = !empty($_SESSION['address_confirmed']);

// 3. Handle "Confirm Order (no online payment)"
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm_order']) && !empty($items)) {

    // Require address confirmation first
    if (!$addressConfirmed) {
        header('Location: shipping_confirm.php?from=checkout');
        exit;
    }

    if ($first_name === '' || $last_name === '' || $email === '') {
        $orderError = "First name, last name and email are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $orderError = "Please enter a valid email address.";
    } else {
        $newOrderId = placeOrder(
            $conn,
            $userId,
            $items,
            $first_name,
            $last_name,
            $email,
            $address,
            $city,
            $province,
            $postal_code,
            $total,
            $orderError
        );

        if ($newOrderId) {
            // Offline payment
            $orderConfirmed = true;
            $items = [];
            $total = 0.0;
            unset($_SESSION['address_confirmed']);
        }
    }
}

if (isset($_GET['paid']) && $_GET['paid'] === '1' && !empty($items)) {

    if (!$addressConfirmed) {
        header('Location: shipping_confirm.php?from=checkout');
        exit;
    }

    if ($first_name === '' || $last_name === '' || $email === '') {
        $orderError = "We couldn't find your name or email. Please update your profile.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $orderError = "We couldn't verify your email address, please check your profile.";
    } else {
        $newOrderId = placeOrder(
            $conn,
            $userId,
            $items,
            $first_name,
            $last_name,
            $email,
            $address,
            $city,
            $province,
            $postal_code,
            $total,
            $orderError
        );

        if ($newOrderId) {
            unset($_SESSION['address_confirmed']);
            header('Location: payment_success.php?order_id=' . $newOrderId);
            exit;
        }
    }
}

// Amount for PayPal
$paypalAmount = number_format($total, 2, '.', '');
?>

<style>
  .payment-wrapper {
    max-width: 420px;
    margin: 2rem auto 0 auto;
  }
  #paypal-buttons-container {
    width: 100%;
  }
  .billing-box {
    margin-top: 2.5rem;
  }
</style>

<div class="checkout-container">

  <h1 class="mb-4">Checkout</h1>

  <?php if ($orderConfirmed): ?>
    <div class="alert alert-success">
      Your order has been <strong>confirmed</strong>! 🎉
      You can continue shopping on the <a href="products.php" class="alert-link">Products page</a>.
    </div>
  <?php elseif ($orderError): ?>
    <div class="alert alert-danger">
      <?php echo $orderError; ?>
    </div>
  <?php endif; ?>

  <?php if (empty($items)): ?>
    <div class="alert alert-info">
      Your cart is empty. <a href="products.php" class="alert-link">Browse products</a> to add some items.
    </div>
  <?php else: ?>

    <h3 class="mb-3">Order Summary</h3>

    <div class="table-responsive mb-4">
      <table class="table checkout-table align-middle mb-0">
        <thead>
          <tr>
            <th>Product</th>
            <th class="text-center">Price</th>
            <th class="text-center">Qty</th>
            <th class="text-center">Line Total</th>
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
                      class="checkout-product-img rounded"
                    >
                  <?php endif; ?>
                  <div>
                    <div class="checkout-product-name">
                      <?php echo htmlspecialchars($item['name']); ?>
                    </div>
                    <div class="checkout-product-category">
                      <?php echo htmlspecialchars($item['category']); ?>
                    </div>
                  </div>
                </div>
              </td>
              <td class="text-center">$<?php echo number_format($item['price'], 2); ?></td>
              <td class="text-center">x<?php echo (int)$item['quantity']; ?></td>
              <td class="text-center fw-bold">$<?php echo number_format($item['line_total'], 2); ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
        <tfoot>
          <tr class="checkout-total-row">
            <td colspan="3" class="text-end">Total:</td>
            <td class="text-center fw-bold">
              $<?php echo number_format($total, 2); ?>
            </td>
          </tr>
        </tfoot>
      </table>
    </div>

    <!-- Shipping Address Summary -->
    <div class="border rounded p-4 mb-4 billing-box">
      <h4 class="mb-3">Shipping &amp; Mailing Address</h4>

      <p class="mb-1"><strong><?php echo htmlspecialchars(trim($first_name . ' ' . $last_name)); ?></strong></p>
      <p class="mb-1"><?php echo htmlspecialchars($email); ?></p>

      <?php if ($address): ?>
        <p class="mb-1"><?php echo htmlspecialchars($address); ?></p>
      <?php endif; ?>

      <p class="mb-1">
        <?php echo htmlspecialchars($city); ?>
        <?php if ($province) echo ', ' . htmlspecialchars($province); ?>
        <?php if ($postal_code) echo ' ' . htmlspecialchars($postal_code); ?>
      </p>

      <?php if (!$addressConfirmed): ?>
        <div class="alert alert-warning mt-3 mb-2">
          Please confirm that this mailing address is correct before paying.
        </div>
      <?php endif; ?>

      <div class="d-flex justify-content-between mt-3">
        <a href="shipping_confirm.php" class="btn btn-outline-light">
          Edit / Confirm Address
        </a>

        <form method="post">
          <button type="submit" name="confirm_order" class="btn btn-checkout">
            Confirm Order (no online payment)
          </button>
        </form>
      </div>
    </div>

    <!-- PayPal section -->
    <h4 class="text-center mt-5 mb-3">Or pay securely with PayPal</h4>
    <div class="payment-wrapper">
      <div id="paypal-buttons-container"></div>
    </div>

  <?php endif; ?>

</div>

<?php if (!$orderConfirmed && !empty($items)): ?>
  <script src="https://www.paypal.com/sdk/js?client-id=AQvaIRBM-WWLdGJrTz6M-ol4YvxBilo4BeGa6344WJIxLrQVPeeXsdSp1v74EaClVXE9CNc1UCLggTRD&currency=CAD"></script>
  <script>
    document.addEventListener("DOMContentLoaded", function () {
      if (!window.paypal || !document.getElementById("paypal-buttons-container")) return;

      const addressConfirmed = <?php echo $addressConfirmed ? 'true' : 'false'; ?>;

      paypal.Buttons({
        style: {
          layout: 'vertical',
          color:  'gold',
          shape:  'rect',
          label:  'paypal'
        },

        // Block PayPal if address is not confirmed
        onClick: function (data, actions) {
          if (!addressConfirmed) {
            window.location.href = 'shipping_confirm.php?from=checkout';
            return actions.reject();
          }
          return actions.resolve();
        },

        createOrder: function (data, actions) {
          return actions.order.create({
            purchase_units: [{
              amount: { value: '<?php echo $paypalAmount; ?>' }
            }]
          });
        },

        onApprove: function (data, actions) {
          return actions.order.capture().then(function () {
            window.location.href = 'checkout.php?paid=1';
          });
        },

        onError: function (err) {
          console.error('PayPal error', err);
          alert('There was a problem with PayPal. Please try again.');
        }
      }).render('#paypal-buttons-container');
    });
  </script>
<?php endif; ?>

<?php require 'includes/footer.php'; ?>
