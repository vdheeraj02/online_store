<?php
$title = 'Login';
require_once 'db/conn.php';
require_once 'includes/header.php';

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email    = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'] ?? '';

    // use first_name and last_name instead of old name column
    $stmt = $conn->prepare("
        SELECT id, first_name, last_name, password_hash, is_admin
        FROM users
        WHERE email = ?
    ");
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($user = $result->fetch_assoc()) {
        if (password_verify($password, $user['password_hash'])) {

            // For Building a full name
            $fullName = trim(($user['first_name'] ?? '') . ' ' . ($user['last_name'] ?? ''));

            // Set session
            $_SESSION['user_id']     = $user['id'];
            $_SESSION['first_name']  = $user['first_name'];
            $_SESSION['last_name']   = $user['last_name'];
            $_SESSION['name']        = $fullName;        // keep compatibility with header.php
            $_SESSION['is_admin']    = (int)$user['is_admin'];

            // Redirect based on role
            if (!empty($_SESSION['is_admin'])) {
                header('Location: admin/index.php');   // admin dashboard
            } else {
                header('Location: index.php');         // normal user
            }
            exit;
        } else {
            $errors[] = 'Email or password is incorrect.';
        }
    } else {
        $errors[] = 'Email or password is incorrect.';
    }
}
?>

<h1>Login</h1>

<?php if (isset($_GET['success']) && $_GET['success'] === 'registered'): ?>
  <div class="alert alert-success">Registration successful. Please log in.</div>
<?php endif; ?>

<?php if (!empty($errors)): ?>
  <div class="alert alert-danger">
      <?php foreach ($errors as $e) echo '<div>'.htmlspecialchars($e).'</div>'; ?>
  </div>
<?php endif; ?>

<form method="post" class="col-md-4 needs-validation auth-form" novalidate>
  <div class="mb-3">
    <label class="form-label" for="email">Email</label>
    <input type="email" id="email" name="email" class="form-control" required>
  </div>
  <div class="mb-3">
    <label class="form-label" for="password">Password</label>
    <input type="password" id="password" name="password" class="form-control" required>
  </div>
  <button type="submit" class="btn btn-primary">Login</button>
</form>

<?php require 'includes/footer.php'; ?>
