<?php
include '../Project-Landing-Page-UMKM/config/koneksi.php';

$id_pelanggan = "PL" . rand(1000, 9999);

$nama     = $_POST['nama_pelanggan'];
$telp     = $_POST['notelp'];
$alamat   = $_POST['alamat'];
$rekening = $_POST['rekening'];
$bukti    = ""; // atau upload file

// Simpan pelanggan
mysqli_query($koneksi, "INSERT INTO pelanggan 
(id_pelanggan, nama_pelanggan, notelp_pelanggan, alamat, rekening, bukti)
VALUES
('$id_pelanggan', '$nama', '$telp', '$alamat', '$rekening', '$bukti')");

// Buat transaksi_penjualan
$id_penjualan = "PJ" . rand(1000,9999);
$metode = $_POST['metode_bayar'];

// Total dari detail_penjualan (yang id_penjualannya masih NULL = keranjang)
$q_total = mysqli_query($koneksi, 
    "SELECT SUM(subtotal) AS total FROM detail_penjualan WHERE id_penjualan IS NULL");
$total = mysqli_fetch_assoc($q_total)['total'];

// Simpan transaksi
mysqli_query($koneksi,
"INSERT INTO transaksi_penjualan (id_penjualan, total_bayar, metode_bayar, id_pelanggan)
VALUES ('$id_penjualan', $total, '$metode', '$id_pelanggan')");

// Update semua item keranjang beri id_penjualan
mysqli_query($koneksi,
"UPDATE detail_penjualan SET id_penjualan='$id_penjualan' WHERE id_penjualan IS NULL");

// Selesai
echo "<script>alert('Checkout berhasil!'); window.location='nota.php?id=$id_penjualan';</script>";
?>
