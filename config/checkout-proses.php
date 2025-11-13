<?php
include '../Project-Landing-Page-UMKM/config/koneksi.php'; // koneksi ke database

// Ambil data dari request (JSON)
$data = json_decode(file_get_contents("php://input"), true);

if (!$data || !isset($data['cart'])) {
    echo json_encode(["status" => "error", "message" => "Data tidak valid"]);
    exit;
}

// Loop tiap item dan simpan ke tabel detail_penjualan
foreach ($data['cart'] as $item) {
    $nama_menu = $item['name'];
    $jumlah = $item['quantity'];
    $harga_satuan = $item['price'];
    $subtotal = $jumlah * $harga_satuan;

    $sql = "INSERT INTO detail_penjualan (nama_menu, jumlah, harga_satuan, subtotal)
            VALUES ('$nama_menu', '$jumlah', '$harga_satuan', '$subtotal')";

    if (!mysqli_query($conn, $sql)) {
        echo json_encode(["status" => "error", "message" => mysqli_error($conn)]);
        exit;
    }
}

echo json_encode(["status" => "success", "message" => "Pesanan berhasil disimpan"]);
?>
