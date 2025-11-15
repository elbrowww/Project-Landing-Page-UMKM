<?php
header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'koneksi.php';

$data = json_decode(file_get_contents("php://input"), true);

$cart = $data['cart'];
$id_penjualan = uniqid('PJ');
$nama = $data['nama_pelanggan'];

// 1. Insert penjualan
$stmt = $conn->prepare("INSERT INTO penjualan (id_penjualan, nama_pelanggan, total) VALUES (?, ?, ?)");
$total = array_sum(array_map(fn($i)=>$i['harga_satuan'] * $i['jumlah'], $cart));
$stmt->execute([$id_penjualan, $nama, $total]);


// 2. Insert detail_penjualan
foreach ($cart as $item) {

    $id_detail = uniqid('DT');

    $stmt2 = $conn->prepare("
        INSERT INTO detail_penjualan 
        (id_detail, id_penjualan, id_menu, nama_menu, jumlah, harga_satuan)
        VALUES (?, ?, ?, ?, ?, ?)
    ");

    $stmt2->execute([
        $id_detail,               // PK detail
        $id_penjualan,            // FK ke penjualan
        $item['id_menu'],         // FK ke menu (AUTO terisi)
        $item['nama_menu'],
        $item['jumlah'],
        $item['harga_satuan']
    ]);
}

echo json_encode(["success" => true, "id_penjualan" => $id_penjualan]);
?>