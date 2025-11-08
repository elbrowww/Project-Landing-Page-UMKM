<?php
include '../Project-Landing-Page-UMKM/config/koneksi.php';

if (isset($_POST['simpan'])) {
    $nama   = ['nama_pelanggan'];
    $email  = ['email_pelanggan'];
    $notelp = ['notelp_pelanggan'];
    $pesan  = ['isi_pesan'];

   
     if ($id == "") {
        // CREATE
        $stmt = $koneksi->prepare("INSERT INTO pesan_pelanggan (nama_pelanggan, email_pelanggan, notelp_pelanggan, isi_pesan) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sidss", $nama, $email, $notelp, $pesan);
     }

    $stmt->execute();
    header("Location: index.php");
    exit;
}
?>