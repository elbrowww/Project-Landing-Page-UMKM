<?php
include '../Project-Landing-Page-UMKM/config/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama_pelanggan']);
    $email = mysqli_real_escape_string($koneksi, $_POST['email_pelanggan']);
    $notelp = mysqli_real_escape_string($koneksi, $_POST['notelp_pelanggan']);
    $pesan = mysqli_real_escape_string($koneksi, $_POST['isi_pesan']);
    
    $query = "INSERT INTO pesan (nama_pelanggan, email_pelanggan, notelp_pelanggan, isi_pesan, tanggal_kirim) 
              VALUES ('$nama', '$email', '$notelp', '$pesan', NOW())";
    
    if (mysqli_query($koneksi, $query)) {
        echo json_encode(['success' => true, 'message' => 'Pesan berhasil dikirim']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Gagal menyimpan pesan']);
    }
}
?>