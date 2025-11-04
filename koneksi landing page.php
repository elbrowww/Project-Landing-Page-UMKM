<?php 
$koneksi = mysqli_connect("localhost", "root", "", "database_bu_mon");

if (!$koneksi) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}
?>