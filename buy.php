<?php
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])) {
    $id = intval($_POST['product_id']);

    $stmt = $conn->prepare("SELECT * FROM product WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    $result = $stmt->get_result();
    if ($product = $result->fetch_assoc()) {
        echo "<h1>Checkout</h1>";
        echo "<p>Produk: <strong>{$product['name']}</strong></p>";
        echo "<p>Harga: <strong>\${$product['price']}</strong></p>";
        echo "<p>Deskripsi: {$product['description']}</p>";
    } else {
        echo "Produk tidak ditemukan.";
    }

    $stmt->close();
} else {
    echo "Permintaan tidak valid.";
}
?>
