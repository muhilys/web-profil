<?php
// config.php

$host = 'localhost';
$user = 'root';
$pass = ''; // ganti jika password root MySQL kamu tidak kosong
$db   = 'portfolio_db';

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Koneksi database gagal: " . $conn->connect_error);
}
?>
