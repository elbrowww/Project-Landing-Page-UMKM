<?php

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Jika ada request POST (AJAX)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json');
    
    $action = $_POST['action'] ?? '';

    try {
        switch ($action) {

            // ✅ Tambah menu
            case 'add':
                $stmt = $pdo->prepare(
                    "INSERT INTO menu (nama_menu, stok_menu, harga_menu, deskripsi, gambar) 
                     VALUES (?, ?, ?, ?, ?)"
                );
                $stmt->execute([
                    $_POST['nama_menu'], 
                    $_POST['stok_menu'], 
                    $_POST['harga_menu'], 
                    $_POST['deskripsi'],
                    $_POST['gambar']
                ]);
                echo json_encode(['success' => true, 'message' => 'Menu berhasil ditambahkan!']);
                break;

            // ✅ Update menu
            case 'update':
                $stmt = $pdo->prepare(
                    "UPDATE menu 
                     SET nama_menu=?, stok_menu=?, harga_menu=?, deskripsi=?, gambar=? 
                     WHERE id_menu=?"
                );
                $stmt->execute([
                    $_POST['nama_menu'], 
                    $_POST['stok_menu'], 
                    $_POST['harga_menu'], 
                    $_POST['deskripsi'],
                    $_POST['gambar'],
                    $_POST['id_menu']
                ]);
                echo json_encode(['success' => true, 'message' => 'Menu berhasil diperbarui!']);
                break;

            // ✅ Delete
            case 'delete':
                $stmt = $pdo->prepare("DELETE FROM menu WHERE id_menu=?");
                $stmt->execute([$_POST['id_menu']]);
                echo json_encode(['success' => true, 'message' => 'Menu dihapus!']);
                break;

            default:
                echo json_encode(['success' => false, 'message' => 'Aksi tidak ditemukan']);
        }

    } catch(PDOException $e) {
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
    exit;
}

// ✅ Ambil semua menu
$stmt = $pdo->query("SELECT id_menu, nama_menu, stok_menu, harga_menu, deskripsi, gambar FROM menu ORDER BY id_menu DESC");
$menuItems = $stmt->fetchAll(PDO::FETCH_ASSOC);



?>