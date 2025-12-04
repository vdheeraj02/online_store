<?php
$title = 'My Profile';

require_once 'db/conn.php';
require_once 'includes/auth.php';
requireLogin();                     
require_once 'includes/header.php';

$userId  = (int) $_SESSION['user_id'];
$errors  = [];
$success = '';

// Load current data from DB
$stmt = $conn->prepare("
    SELECT first_name, last_name, email, address, city, province, postal_code
    FROM users
    WHERE id = ?
");
$stmt->bind_param('i', $userId);
$stmt->execute();
$current = $stmt->get_result()->fetch_assoc();

$first_name  = $current['first_name']  ?? '';
$last_name   = $current['last_name']   ?? '';
$email       = $current['email']       ?? '';
$address     = $current['address']     ?? '';
$city        = $current['city']        ?? '';
$province    = $current['province']    ?? '';
$postal_code = $current['postal_code'] ?? '';

// Handle form submit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name  = trim($_POST['first_name']  ?? '');
    $last_name   = trim($_POST['last_name']   ?? '');
    $email       = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);
    $address     = trim($_POST['address']     ?? '');
    $city        = trim($_POST['city']        ?? '');
    $province    = trim($_POST['province']    ?? '');
    $postal_code = trim($_POST['postal_code'] ?? '');

    $password    = $_POST['password']         ?? '';
    $confirm     = $_POST['confirm_password'] ?? '';

    // Basic validation
    if ($first_name === '' || $last_name === '' || $email === '') {
        $errors[] = 'First name, last name, and email are required.';
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Invalid email format.';
    }

    // Email uniqueness (for other users)
    $check = $conn->prepare("SELECT id FROM users WHERE email = ? AND id <> ?");
    $check->bind_param('si', $email, $userId);
    $check->execute();
    $check->store_result();
    if ($check->num_rows > 0) {
        $errors[] = 'That email is already in use by another account.';
    }

    // password change
    $updatePassword = false;
    if ($password !== '' || $confirm !== '') {
        if ($password !== $confirm) {
            $errors[] = 'New password and confirmation do not match.';
        } elseif (strlen($password) < 6) {
            $errors[] = 'New password must be at least 6 characters.';
        } else {
            $updatePassword = true;
        }
    }

    if (empty($errors)) {
        if ($updatePassword) {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("
                UPDATE users
                SET first_name = ?, last_name = ?, email = ?, address = ?, city = ?, province = ?, postal_code = ?, password_hash = ?
                WHERE id = ?
            ");
            $stmt->bind_param(
                'ssssssssi',
                $first_name, $last_name, $email, $address, $city, $province, $postal_code, $hash, $userId
            );
        } else {
            $stmt = $conn->prepare("
                UPDATE users
                SET first_name = ?, last_name = ?, email = ?, address = ?, city = ?, province = ?, postal_code = ?
                WHERE id = ?
            ");
            $stmt->bind_param(
                'sssssssi',
                $first_name, $last_name, $email, $address, $city, $province, $postal_code, $userId
            );
        }

        if ($stmt->execute()) {
            // Update session so navbar shows new name
            $_SESSION['first_name'] = $first_name;
            $_SESSION['last_name']  = $last_name;
            $_SESSION['name']       = trim($first_name . ' ' . $last_name);

            $success = 'Profile updated successfully.';
        } else {
            $errors[] = 'There was a problem saving your changes. Please try again.';
        }
    }
}

// Province list (same as register page)
$provinceOptions = [
    'AB' => 'Alberta',
    'BC' => 'British Columbia',
    'MB' => 'Manitoba',
    'NB' => 'New Brunswick',
    'NL' => 'Newfoundland and Labrador',
    'NS' => 'Nova Scotia',
    'ON' => 'Ontario',
    'PE' => 'Prince Edward Island',
    'QC' => 'Quebec',
    'SK' => 'Saskatchewan',
    'YT' => 'Yukon',
    'NT' => 'Northwest Territories',
    'NU' => 'Nunavut',
];
?>

<h1>My Profile</h1>

<?php if ($success): ?>
  <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
<?php endif; ?>

<?php if (!empty($errors)): ?>
  <div class="alert alert-danger">
    <?php foreach ($errors as $e) echo '<div>'.htmlspecialchars($e).'</div>'; ?>
  </div>
<?php endif; ?>

<div class="profile-container">
<form method="post" class="row g-3 auth-form" novalidate>
  <!-- First / Last name -->
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

  <!-- Email -->
  <div class="col-md-12">
    <label class="form-label" for="email">Email</label>
    <input type="email" id="email" name="email"
           class="form-control"
           value="<?php echo htmlspecialchars($email); ?>" required>
  </div>

  <!-- Address -->
  <div class="col-md-12">
    <label class="form-label" for="address">Address</label>
    <input type="text" id="address" name="address"
           class="form-control"
           value="<?php echo htmlspecialchars($address); ?>">
  </div>

  <!-- City / Province / Postal -->
  <div class="col-md-4">
    <label class="form-label" for="city">City</label>
    <input type="text" id="city" name="city"
           class="form-control"
           value="<?php echo htmlspecialchars($city); ?>">
  </div>

  <div class="col-md-4">
    <label class="form-label" for="province">Province</label>
    <select id="province" name="province" class="form-select">
      <option value="">Choose...</option>
      <?php foreach ($provinceOptions as $code => $label): ?>
        <option value="<?php echo $code; ?>"
          <?php echo ($province === $code) ? 'selected' : ''; ?>>
          <?php echo htmlspecialchars($label); ?>
        </option>
      <?php endforeach; ?>
    </select>
  </div>

  <div class="col-md-4">
    <label class="form-label" for="postal_code">Postal Code</label>
    <input type="text" id="postal_code" name="postal_code"
           class="form-control"
           value="<?php echo htmlspecialchars($postal_code); ?>">
  </div>

  <!-- password change -->
  <div class="col-md-6">
    <label class="form-label" for="password">New Password </label>
    <input type="password" id="password" name="password" class="form-control">
  </div>

  <div class="col-md-6">
    <label class="form-label" for="confirm_password">Confirm New Password</label>
    <input type="password" id="confirm_password" name="confirm_password" class="form-control">
  </div>

  <div class="col-12 mt-3">
    <button type="submit" class="btn btn-success">Save Changes</button>
  </div>
</form>

<?php require 'includes/footer.php'; ?>
