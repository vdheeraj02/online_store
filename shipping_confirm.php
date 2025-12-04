<?php
$title = 'Confirm Shipping Address';

require_once 'db/conn.php';
require_once 'includes/auth.php';
requireLogin();
require_once 'includes/header.php';

$userId = (int)$_SESSION['user_id'];
$errors = [];
$success = "";

// Load current user data
$stmt = $conn->prepare("
    SELECT first_name, last_name, email, address, city, province, postal_code
    FROM users
    WHERE id = ?
");
$stmt->bind_param('i', $userId);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

$first_name  = $user['first_name']  ?? '';
$last_name   = $user['last_name']   ?? '';
$email       = $user['email']       ?? '';
$address     = $user['address']     ?? '';
$city        = $user['city']        ?? '';
$province    = $user['province']    ?? '';
$postal_code = $user['postal_code'] ?? '';

// Handle form submit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name  = trim($_POST['first_name']  ?? '');
    $last_name   = trim($_POST['last_name']   ?? '');
    $email       = trim($_POST['email']       ?? '');
    $address     = trim($_POST['address']     ?? '');
    $city        = trim($_POST['city']        ?? '');
    $province    = trim($_POST['province']    ?? '');
    $postal_code = trim($_POST['postal_code'] ?? '');

    if ($first_name === '' || $last_name === '' || $email === '') {
        $errors[] = "First name, last name and email are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Please enter a valid email address.";
    }

    if (empty($errors)) {
        $up = $conn->prepare("
            UPDATE users
            SET first_name = ?, last_name = ?, email = ?,
                address = ?, city = ?, province = ?, postal_code = ?
            WHERE id = ?
        ");
        $up->bind_param(
            'sssssssi',
            $first_name,
            $last_name,
            $email,
            $address,
            $city,
            $province,
            $postal_code,
            $userId
        );

        if ($up->execute()) {
            // Mark that user has confirmed the address for this order
            $_SESSION['address_confirmed'] = true;

            // Back to checkout for payment
            header("Location: checkout.php");
            exit;
        } else {
            $errors[] = "Could not save your address. Please try again.";
        }
    }
}
?>

<h1 class="mb-4">Confirm Shipping &amp; Mailing Address</h1>

<?php if (!empty($errors)): ?>
  <div class="alert alert-danger">
    <?php foreach ($errors as $e): ?>
      <div><?php echo htmlspecialchars($e); ?></div>
    <?php endforeach; ?>
  </div>
<?php endif; ?>

<div class="card">
  <div class="card-body">
    <p class="text-muted mb-3">
      Please check that your mailing / shipping address is correct.  
      This address will be used for your order.
    </p>

    <form method="post" class="row g-3" novalidate>
      <div class="col-md-6">
        <label class="form-label" for="first_name">First Name</label>
        <input type="text" id="first_name" name="first_name"
               class="form-control"
               value="<?php echo htmlspecialchars($first_name); ?>" required>
      </div>

      <div class="col-md-6">
        <label class="form-label" for="last_name">Last Name</label>
        <input type="text" id="last_name" name="last_name"
               class="form-control"
               value="<?php echo htmlspecialchars($last_name); ?>" required>
      </div>

      <div class="col-md-12">
        <label class="form-label" for="email">Email</label>
        <input type="email" id="email" name="email"
               class="form-control"
               value="<?php echo htmlspecialchars($email); ?>" required>
      </div>

      <div class="col-md-12">
        <label class="form-label" for="address">Address</label>
        <input type="text" id="address" name="address"
               class="form-control"
               value="<?php echo htmlspecialchars($address); ?>">
      </div>

      <div class="col-md-4">
        <label class="form-label" for="city">City</label>
        <input type="text" id="city" name="city"
               class="form-control"
               value="<?php echo htmlspecialchars($city); ?>">
      </div>

      <div class="col-md-4">
        <label class="form-label" for="province">Province</label>
        <input type="text" id="province" name="province"
               class="form-control"
               value="<?php echo htmlspecialchars($province); ?>">
      </div>

      <div class="col-md-4">
        <label class="form-label" for="postal_code">Postal Code</label>
        <input type="text" id="postal_code" name="postal_code"
               class="form-control"
               value="<?php echo htmlspecialchars($postal_code); ?>">
      </div>

      <div class="col-12 d-flex justify-content-between mt-3">
        <a href="checkout.php" class="btn btn-outline-light">Back to Checkout</a>
        <button type="submit" class="btn btn-primary">
          Continue to Payment
        </button>
      </div>
    </form>
  </div>
</div>

<?php require 'includes/footer.php'; ?>
