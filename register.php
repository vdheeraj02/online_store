<?php
$title = 'Register';
require_once 'db/conn.php';
require_once 'includes/header.php';

$errors = [];

// Form values 
$first_name = $last_name = $username = $email = '';
$address = $city = $province = $postal_code = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $first_name   = trim($_POST['first_name'] ?? '');
    $last_name    = trim($_POST['last_name'] ?? '');
    $username     = trim($_POST['username'] ?? '');
    $email        = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);
    $address      = trim($_POST['address'] ?? '');
    $city         = trim($_POST['city'] ?? '');
    $province     = trim($_POST['province'] ?? '');
    $postal_code  = trim($_POST['postal_code'] ?? '');
    $pass         = $_POST['password'] ?? '';
    $confirm      = $_POST['confirm_password'] ?? '';

    // Basic validation
    if ($first_name === '' || $last_name === '' || $email === '' || $pass === '' || $confirm === '') {
        $errors[] = 'First name, Last name, Email and Password fields are required.';
    }

    if ($address === '' || $city === '' || $province === '' || $postal_code === '') {
        $errors[] = 'Address, City, Province and Postal Code are required.';
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Invalid email format.';
    }

    if ($pass !== $confirm) {
        $errors[] = 'Passwords do not match.';
    }

    // Build "name" for DB from first + last 
    $full_name = trim($first_name . ' ' . $last_name);
    if ($full_name === '' && $username !== '') {
        $full_name = $username;
    }

    if (empty($errors)) {
        // Check duplicate email
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $errors[] = 'Email is already registered.';
        } else {
            $hashed = password_hash($pass, PASSWORD_DEFAULT);

            $stmt = $conn->prepare("
                INSERT INTO users (first_name, last_name, email, address, city, province, postal_code, password_hash)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)
            ");
            $stmt->bind_param(
                'ssssssss',
                $first_name,
                $last_name,
                $email,
                $address,
                $city,
                $province,
                $postal_code,
                $hashed
            );


            if ($stmt->execute()) {
                header('Location: login.php?success=registered');
                exit;
            } else {
                $errors[] = 'Registration failed. Please try again.';
            }
        }
    }
}
?>

<h1>Sign Up</h1>

<?php if (!empty($errors)): ?>
  <div class="alert alert-danger">
    <?php foreach ($errors as $e): ?>
      <div><?php echo htmlspecialchars($e); ?></div>
    <?php endforeach; ?>
  </div>
<?php endif; ?>

<!-- Keep the dark card styling via .auth-form -->
<form method="post" novalidate class="auth-form">

  <div class="row g-3">

    <!-- Row 1: First / Last Name -->
    <div class="col-md-6">
      <label class="form-label" for="first_name">First Name</label>
      <input
        type="text"
        id="first_name"
        name="first_name"
        class="form-control"
        value="<?php echo htmlspecialchars($first_name); ?>"
        required
      >
    </div>

    <div class="col-md-6">
      <label class="form-label" for="last_name">Last Name</label>
      <input
        type="text"
        id="last_name"
        name="last_name"
        class="form-control"
        value="<?php echo htmlspecialchars($last_name); ?>"
        required
      >
    </div>

    <!-- Row 2: Email -->
   

    <div class="col-12">
      <label class="form-label" for="email">Email Address</label>
      <input
        type="email"
        id="email"
        name="email"
        class="form-control"
        value="<?php echo htmlspecialchars($email); ?>"
        required
      >
    </div>

    <!-- Row 3: Password / Confirm -->
    <div class="col-md-6">
      <label class="form-label" for="password">Password</label>
      <input
        type="password"
        id="password"
        name="password"
        class="form-control"
        required
      >
    </div>

    <div class="col-md-6">
      <label class="form-label" for="confirm_password">Confirm Password</label>
      <input
        type="password"
        id="confirm_password"
        name="confirm_password"
        class="form-control"
        required
      >
    </div>

    <!-- Row 4: Address -->
    <div class="col-12">
      <label class="form-label" for="address">Address</label>
      <input
        type="text"
        id="address"
        name="address"
        class="form-control"
        value="<?php echo htmlspecialchars($address); ?>"
        required
      >
    </div>

    <!-- Row 5: City / Province / Postal Code -->
    <div class="col-md-4">
      <label class="form-label" for="city">City</label>
      <input
        type="text"
        id="city"
        name="city"
        class="form-control"
        value="<?php echo htmlspecialchars($city); ?>"
        required
      >
    </div>

    <div class="col-md-4">
      <label class="form-label" for="province">Province</label>
      <select
        id="province"
        name="province"
        class="form-select"
        required
      >
        <option value="" disabled <?php echo $province === '' ? 'selected' : ''; ?>>Choose...</option>
        <?php
          $provinces = [
            'Alberta', 'British Columbia', 'Manitoba', 'New Brunswick',
            'Newfoundland and Labrador', 'Nova Scotia', 'Ontario',
            'Prince Edward Island', 'Quebec', 'Saskatchewan',
            'Northwest Territories', 'Nunavut', 'Yukon'
          ];
          foreach ($provinces as $prov):
        ?>
          <option
            value="<?php echo htmlspecialchars($prov); ?>"
            <?php echo ($province === $prov) ? 'selected' : ''; ?>
          >
            <?php echo htmlspecialchars($prov); ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>

    <div class="col-md-4">
      <label class="form-label" for="postal_code">Postal Code</label>
      <input
        type="text"
        id="postal_code"
        name="postal_code"
        class="form-control"
        value="<?php echo htmlspecialchars($postal_code); ?>"
        required
      >
    </div>

    <!-- Submit button -->
    <div class="col-12 mt-2">
      <button type="submit" class="btn btn-success">
        Create Account
      </button>
    </div>

  </div>
</form>

<?php require 'includes/footer.php'; ?>
