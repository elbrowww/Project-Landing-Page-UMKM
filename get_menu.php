<?php
// get_menu.php
header('Content-Type: application/json');

// Include koneksi database yang sudah ada
include 'config/koneksi.php';

try {
    // Query untuk mengambil semua menu
    $query = "SELECT id_menu, nama_menu, stok_menu, deskripsi, harga_menu, gambar 
              FROM menu 
              ORDER BY nama_menu ASC";
    
    $result = mysqli_query($koneksi, $query);
    
    if (!$result) {
        throw new Exception(mysqli_error($koneksi));
    }
    
    $menus = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $menus[] = [
            'id_menu' => $row['id_menu'],
            'nama_menu' => $row['nama_menu'],
            'stok_menu' => $row['stok_menu'],
            'deskripsi' => $row['deskripsi'],
            'harga_menu' => $row['harga_menu'],
            'gambar' => 'asset/uploads/' . $row['gambar']
        ];
    }
    
    echo json_encode($menus);
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'error' => true,
        'message' => 'Gagal mengambil data menu: ' . $e->getMessage()
    ]);
}
?>
