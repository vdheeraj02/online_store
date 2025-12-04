<?php
$title = 'Orders';
require_once '../db/conn.php';
require_once '../includes/auth.php';
requireAdmin();
require_once '../includes/header.php';

$sql = "SELECT * FROM orders ORDER BY order_date ASC";
$result = $conn->query($sql);
?>

<h1 class="mb-4">Orders</h1>

<div class="table-responsive">
  <table class="table align-middle">
    <thead>
      <tr>
        <th>Order ID</th>
        <th>User</th>
        <th>Email</th>
        <th>Total</th>
        <th>Date</th>
      </tr>
    </thead>
    <tbody>
      <?php while ($o = $result->fetch_assoc()): ?>
        <tr>
          <td><?php echo (int)$o['id']; ?></td>
          <td><?php echo htmlspecialchars($o['first_name'] . ' ' . $o['last_name']); ?></td>
          <td><?php echo htmlspecialchars($o['email']); ?></td>
          <td>$<?php echo number_format($o['total_price'], 2); ?></td>
          <td><?php echo htmlspecialchars($o['order_date']); ?></td>
        </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>

<?php require '../includes/footer.php'; ?>
