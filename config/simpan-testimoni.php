<?php
include 'koneksi.php';

$nama = $_POST['nama'];
$email = $_POST['email'] ?? '';
$no_telp = $_POST['no_telp'] ?? '';
$gender = $_POST['gender'];
$rating = $_POST['rating'];
$pesan = $_POST['pesan'];

$query = "INSERT INTO testimoni (nama, email, no_telp, gender, rating, pesan, status, created_at)
          VALUES ('$nama', '$email', '$no_telp', '$gender', '$rating', '$pesan', '$status', NOW())";

if ($koneksi->query($query)) {
    echo "<script>alert('Terima kasih! Testimoni Anda berhasil dikirim.'); window.location.href='index.php#testimoni';</script>";
} else {
    echo "Error: " . $koneksi->error;
}
?>
