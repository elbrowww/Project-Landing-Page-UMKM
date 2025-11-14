<?php
include '../Project-Landing-Page-UMKM/config/koneksi.php';

$id_menu   = $_POST['id_menu'];
$jumlah    = $_POST['jumlah'];
$id_detail = "DT" . rand(1000, 9999);

// Ambil data menu
$q = mysqli_query($koneksi, "SELECT nama_menu, harga, stok FROM menu WHERE id_menu='$id_menu'");
$m = mysqli_fetch_assoc($q);

// Cek stok (validasi sisi PHP sebelum trigger)
if ($m['stok'] < $jumlah) {
    echo "<script>alert('Stok tidak cukup!'); history.back();</script>";
    exit;
}

$subtotal = $m['harga'] * $jumlah;

// INSERT ke detail_penjualan → TRIGGER akan mengurangi stok
$sql = "INSERT INTO detail_penjualan 
(id_detail, id_penjualan, id_menu, nama_menu, jumlah, harga_satuan, subtotal)
VALUES 
('$id_detail', NULL, '$id_menu', '{$m['nama_menu']}', $jumlah, '{$m['harga']}', $subtotal)";

if (mysqli_query($koneksi, $sql)) {
    echo "<script>alert('Berhasil ditambahkan ke keranjang!'); window.location='keranjang.php';</script>";
} else {
    echo "Error: " . mysqli_error($koneksi);
}
?>
