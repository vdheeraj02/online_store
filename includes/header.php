<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($title)) {
    $title = 'Electronics';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>GIGABYTE <?php echo htmlspecialchars($title); ?></title>

  <!-- Professional Inter Font -->
  <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">

  <!-- Favicon -->
  <link rel="icon" href="/online_store/img/img.ico" type="image/x-icon">

  <!-- CSS -->
  <link rel="stylesheet" href="/online_store/css/bootstrap.min.css">
  <link rel="stylesheet" href="/online_store/css/styles.css">

  <!-- Extra CSS for profile hover effect -->
  <style>
    .profile-link {
        color: #0d6efd;
        text-decoration: none;
        font-weight: 600;
        cursor: pointer;
    }
    .profile-link:hover {
        color: #0b5ed7;
        text-decoration: underline;
    }
  </style>
</head>

<body>
<header>
  <!-- GIGABYTE-style navbar -->
  <nav class="navbar navbar-expand-lg">
    <div class="container-fluid">

      <!-- Brand -->
      <a class="navbar-brand fw-bold" href="/online_store/index.php">
          GIGABYTE
      </a>

      <!-- Mobile toggle -->
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
              data-bs-target="#mainNavbar" aria-controls="mainNavbar"
              aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <!-- Navigation -->
      <div class="collapse navbar-collapse" id="mainNavbar">

        <ul class="navbar-nav me-auto mb-2 mb-lg-0">

          <li class="nav-item">
            <a class="nav-link" href="/online_store/index.php">Home</a>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="/online_store/products.php">Products</a>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="/online_store/cart.php">Cart</a>
          </li>

          <?php if (!empty($_SESSION['is_admin'])): ?>
            <li class="nav-item">
              <a class="nav-link" href="/online_store/admin/index.php">Admin</a>
            </li>
          <?php endif; ?>
        </ul>

        <!-- Right side buttons -->
        <div class="d-flex align-items-center gap-3">

          <?php if (!isset($_SESSION['user_id'])): ?>

            <a href="/online_store/register.php"
               class="header-link header-link--signup">
              Sign Up
            </a>

            <a href="/online_store/login.php"
               class="header-link header-link--login ms-1">
              Login
            </a>

          <?php else: ?>

              <span class="user-greeting">
                  Hello,
                  <a href="/online_store/profile.php"
                     class="profile-link"
                     data-bs-toggle="tooltip"
                     data-bs-placement="bottom"
                     title="Update your profile info">
                       <?php echo htmlspecialchars($_SESSION['name']); ?>
                  </a>
              </span>

              <a href="/online_store/logout.php"
                  class="header-link header-link--logout ms-1">
                 Logout
              </a>

          <?php endif; ?>

        </div>
      </div>
    </div>
  </nav>
</header>

<main class="container my-4">
