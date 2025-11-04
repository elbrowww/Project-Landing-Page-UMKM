<?php 
$koneksi = mysqli_connect("localhost", "root", "", "umkm3");

if (!$koneksi) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}
?>