<?php
header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 1);

$servername = "localhost";
$username = "root";  // Ganti sesuai setup Anda
$password = "";
$dbname = "database_bu_mon";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  echo json_encode(['success' => false, 'message' => 'Koneksi DB gagal: '.$conn->connect_error]);
  exit;
}

$data = json_decode(file_get_contents('php://input'), true);
$cart = $data['cart'] ?? [];
$id_penjualan_temp = $data['id_penjualan_temp'] ?? '';

if (empty($cart) || empty($id_penjualan_temp)) {
  echo json_encode(['success' => false, 'message' => 'Data keranjang atau ID penjualan kosong']);
  exit;
}

// Hapus data lama
$stmtDel = $conn->prepare("DELETE FROM detail_penjualan WHERE id_penjualan = ?");
$stmtDel->bind_param('s', $id_penjualan_temp);
$stmtDel->execute();
$stmtDel->close();

$stmtIns = $conn->prepare("INSERT INTO detail_penjualan (id_detail, id_penjualan, nama_menu, jumlah, harga_satuan, subtotal) VALUES (?, ?, ?, ?, ?, ?)");

foreach ($cart as $item) {
  $id_menu = $item['id_menu'];
  $nama_menu = $item['nama_menu'];
  $harga_satuan = (int) $item['harga_satuan'];
  $jumlah = (int) $item['jumlah'];
  $subtotal = $harga_satuan * $jumlah;
  $id_detail = 'DTL' . rand(1000, 9999);

  $stmtIns->bind_param('sssiii', $id_detail, $id_penjualan_temp, $nama_menu, $jumlah, $harga_satuan, $subtotal);
  $stmtIns->execute();

  // Update stok menu (kurangi sesuai jumlah)
  $conn->query("UPDATE menu SET stok_menu = stok_menu - $jumlah WHERE id_menu = '$id_menu'");
}


$stmtIns->close();
echo json_encode(['success' => true]);
$conn->close();
?>
