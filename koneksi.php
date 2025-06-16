
<?php
$host = "localhost";
$user = "root";
$pass = "";
$database = "web_bootstrap";

$conn = mysqli_connect($host, $user, $pass, $database);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>