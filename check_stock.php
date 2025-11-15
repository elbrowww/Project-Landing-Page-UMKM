<?php
header('Content-Type: application/json');
$conn = new mysqli("localhost", "root", "", "database_bu_mon");

if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => 'DB Error']);
    exit;
}

$id_menu = $_GET['id_menu'] ?? '';

$stmt = $conn->prepare("SELECT stok_menu FROM menu WHERE id_menu = ?");
$stmt->bind_param("s", $id_menu);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

echo json_encode([
    'success' => true,
    'stok' => (int)$row['stok_menu']
]);
?>
