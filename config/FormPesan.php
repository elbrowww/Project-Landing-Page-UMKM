<?php
include '../Project-Landing-Page-UMKM/config/koneksi.php';

if (isset($_POST['simpan'])) {
    $nama   = $_POST['nama_pelanggan'];
    $email  = $_POST['email_pelanggan'];
    $notelp = $_POST['notelp_pelanggan'];
    $pesan  = $_POST['isi_pesan'];

    // CREATE
    $stmt = $koneksi->prepare("INSERT INTO pesan_pelanggan (nama_pelanggan, email_pelanggan, notelp_pelanggan, isi_pesan) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $nama, $email, $notelp, $pesan);

    if ($stmt->execute()) {
        // Jika Berhasil
        echo "<script>alert('Pesan berhasil dikirim!'); window.location.href='index.php#kontak';</script>";
    } else {
        // Jika Gagal
        echo "<script>alert('Terjadi kesalahan saat mengirim pesan.');</script>";
    }

    $stmt->close();
}
?>
