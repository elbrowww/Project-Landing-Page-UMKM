<?php
// proses_testimoni.php
session_start();
require_once 'koneksi.php'; // Sesuaikan dengan file koneksi Anda

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $koneksi->real_escape_string($_POST['nama']);
    $email = $koneksi->real_escape_string($_POST['email']);
    $rating = intval($_POST['rating']);
    $pesan = $koneksi->real_escape_string($_POST['pesan']);
    
    // Validasi input
    if (empty($nama) || empty($email) || empty($pesan) || $rating < 1 || $rating > 5) {
        $_SESSION['error'] = "Semua field harus diisi dengan benar!";
        header('Location: index.php#testimoni');
        exit;
    }
    
    // Insert ke database
    $sql = "INSERT INTO testimoni (nama, email, rating, pesan, status, created_at) 
            VALUES ('$nama', '$email', $rating, '$pesan', 'pending', NOW())";
    
    if ($conn->query($sql) === TRUE) {
        $_SESSION['success'] = "Testimoni berhasil dikirim! Menunggu persetujuan admin.";
    } else {
        $_SESSION['error'] = "Terjadi kesalahan: " . $koneksi->error;
    }
    
    header('Location: index.php#testimoni');
    exit;
} else {
    header('Location: index.php');
    exit;
}
?>