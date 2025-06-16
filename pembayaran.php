<?php
session_start();
$cart = $_SESSION['cart'] ?? [];
if (!$cart) {
  echo "Your cart is empty.";
  exit;
}
// Hitungan total dsb.
// Redirect ke gateway pembayaran.
// Setelah sukses, kosongkan keranjang:
// unset($_SESSION['cart']);
?>
