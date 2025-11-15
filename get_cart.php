<?php
header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 1);

$conn = new mysqli('localhost', 'root', 'password', 'database_bu_mon');

if ($conn->connect_error) {
    echo json_encode(['cart' => []]);
    exit;
}

$id_penjualan_temp = $_GET['id_penjualan_temp'] ?? '';
if (empty($id_penjualan_temp)) {
    echo json_encode(['cart' => []]);
    exit;
}

$result = $conn->query("SELECT nama_menu, harga_satuan, jumlah, subtotal FROM detail_penjualan WHERE id_penjualan = '$id_penjualan_temp'");

$cart = [];
while ($row = $result->fetch_assoc()) {
    $cart[] = $row;
}

echo json_encode(['cart' => $cart]);
$conn->close();
?>