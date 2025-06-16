<?php
session_start();
$cart = $_SESSION['cart'] ?? [];
$total = 0;
?>
<!DOCTYPE html><html><head><title>Cart</title></head><body>
<h2>Your Cart</h2>
<?php if (!$cart): ?>
  <p>Your cart is empty</p>
<?php else: ?>
  <ul>
  <?php foreach ($cart as $item): 
    $total += $item['price']; ?>
    <li><?= htmlspecialchars($item['name']) ?> — $<?= $item['price'] ?></li>
  <?php endforeach; ?>
  </ul>
  <p><strong>Total: $<?= $total ?></strong></p>
  <a href="checkout.php">Proceed to Checkout</a>
<?php endif; ?>
</body></html>
