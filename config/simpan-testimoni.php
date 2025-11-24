<?php

session_start();
$id_user = $_SESSION['id_user'];

error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

$nama    = $_POST['nama'];
$no_telp = $_POST['no_telp'];
$pesan   = $_POST['pesan'];


$query = "INSERT INTO testimoni (nama, no_telp, pesan, created_at, id_user)
          VALUES ('$nama', '$no_telp', '$pesan', NOW(), '$id_user')";

if ($koneksi->query($query)) {
    echo "<script>alert('Testimoni berhasil ditambahkan!'); window.location.href='/Project-Landing-Page-UMKM/Admin/testimoni.php?page=testimoni';</script>";
} else {
    echo "Error: " . $koneksi->error;
}
} 
?>
