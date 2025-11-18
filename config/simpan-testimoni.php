<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

$nama    = $_POST['nama'];
$no_telp = $_POST['no_telp'];
$pesan   = $_POST['pesan'];


$query = "INSERT INTO testimoni (nama, no_telp, pesan, created_at)
          VALUES ('$nama', '$no_telp', '$pesan', NOW())";

if ($koneksi->query($query)) {
    echo "<script>alert('Testimoni berhasil ditambahkan!'); window.location.href='/Project-Landing-Page-UMKM/Admin/index.php?page=testimoni';</script>";
} else {
    echo "Error: " . $koneksi->error;
}
} 
?>
