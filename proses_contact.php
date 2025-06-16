<?php
include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $pesan = $_POST['pesan'];

    $query = "INSERT INTO kontak (nama, email, pesan) VALUES ('$nama', '$email', '$pesan')";
    $result = mysqli_query($conn, $query);

    if ($result) {
        echo "<script>alert('Pesan berhasil dikirim!'); window.location.href='index.php#contact';</script>";
    } else {
        echo "<script>alert('Gagal mengirim pesan.'); window.location.href='index.php#contact';</script>";
    }
}
?>