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

$stmtIns = $conn->prepare("INSERT INTO detail_penjualan (id_detail, id_penjualan, id_menu, nama_menu, jumlah, harga_satuan, subtotal) VALUES (?, ?, ?, ?, ?, ?, ?)");

foreach ($cart as $item) {
  $nama_menu = $item['nama_menu'];
  $harga_satuan = (int) $item['harga_satuan'];
  $jumlah = (int) $item['jumlah'];
  $subtotal = $harga_satuan * $jumlah;
  $id_detail = 'DTL' . rand(1000, 9999);

  // **DI SINI (sebelum insert)**: Ambil id_menu dari tabel menu berdasarkan nama_menu
  $stmtMenu = $conn->prepare("SELECT id_menu FROM menu WHERE nama_menu = ?");
  $stmtMenu->bind_param('s', $nama_menu);
  $stmtMenu->execute();
  $resultMenu = $stmtMenu->get_result();
  $id_menu = null;
  if ($row = $resultMenu->fetch_assoc()) {
    $id_menu = $row['id_menu'];
  }
  $stmtMenu->close();

  // Jika id_menu tidak ditemukan, skip atau error
  if (!$id_menu) {
    echo json_encode(['success' => false, 'message' => 'Menu tidak ditemukan: ' . $nama_menu]);
    exit;
  }

  $stmtIns->bind_param('ssssiii', $id_detail, $id_penjualan_temp, $id_menu, $nama_menu, $jumlah, $harga_satuan, $subtotal);
  if (!$stmtIns->execute()) {
    echo json_encode(['success' => false, 'message' => 'Gagal insert: ' . $stmtIns->error]);
    exit;
  }

}

$stmtIns->close();
echo json_encode(['success' => true]);
$conn->close();
?>
