<?php
header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 1);

$conn = new mysqli('localhost', 'root', '', 'database_bu_mon');
if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Koneksi DB gagal']);
    exit;
}

$result = $conn->query("SELECT id_menu, nama_menu, harga_menu, stok_menu, deskripsi, gambar FROM menu");

$menus = [];
while ($row = $result->fetch_assoc()) {
    $menus[] = $row;
}

echo json_encode(['success' => true, 'menus' => $menus]);
$conn->close();
?>
