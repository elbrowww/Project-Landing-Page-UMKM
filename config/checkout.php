<?php
include '../Project-Landing-Page-UMKM/config/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil semua data dari tabel keranjang
    $keranjang = mysqli_query($koneksi, "SELECT * FROM keranjang");

    if (mysqli_num_rows($keranjang) > 0) {
        // Optional: buat entri baru di tabel penjualan utama jika kamu punya tabel itu
        // mysqli_query($koneksi, "INSERT INTO penjualan (tanggal) VALUES (NOW())");
        // $id_penjualan = mysqli_insert_id($koneksi);

        while ($row = mysqli_fetch_assoc($keranjang)) {
            $nama_menu = $row['nama_menu'];
            $harga_menu = $row['harga_menu'];
            $jumlah = $row['jumlah'];
            $subtotal = $harga_menu * $jumlah;

            // Masukkan ke tabel detail_penjualan
            $query = "INSERT INTO detail_penjualan (nama_menu, harga_menu, jumlah, subtotal)
                      VALUES ('$nama_menu', '$harga_menu', '$jumlah', '$subtotal')";
            mysqli_query($koneksi, $query);
        }

        // Kosongkan tabel keranjang setelah checkout
        mysqli_query($koneksi, "DELETE FROM keranjang");

        echo json_encode(['status' => 'success', 'message' => 'Checkout berhasil!']);
    } else {
        echo json_encode(['status' => 'empty', 'message' => 'Keranjang masih kosong.']);
    }
} else {
    echo json_encode(['status' => 'invalid']);
}
?>
