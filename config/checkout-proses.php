<?php
// Enable error reporting untuk debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Content-Type: application/json');

// Log untuk debug
file_put_contents('debug.log', "=== CHECKOUT PROCESS STARTED ===\n", FILE_APPEND);

// Include file koneksi database
$koneksi = include 'koneksi.php';

// Cek koneksi
if (!$koneksi) {
    file_put_contents('debug.log', "Database connection failed\n", FILE_APPEND);
    echo json_encode(["status" => "error", "message" => "Koneksi database gagal"]);
    exit;
}

// Ambil data dari request
$input = file_get_contents('php://input');
file_put_contents('debug.log', "Raw input: " . $input . "\n", FILE_APPEND);

$data = json_decode($input, true);

// Validasi data
if (!$data) {
    file_put_contents('debug.log', "JSON decode failed\n", FILE_APPEND);
    echo json_encode(["status" => "error", "message" => "Data JSON tidak valid"]);
    exit;
}

if (!isset($data['nama']) || !isset($data['telp']) || !isset($data['alamat']) || !isset($data['rekening']) || !isset($data['cart'])) {
    file_put_contents('debug.log', "Incomplete data\n", FILE_APPEND);
    echo json_encode(["status" => "error", "message" => "Data tidak lengkap"]);
    exit;
}

try {
    $nama = mysqli_real_escape_string($koneksi, $data['nama']);
    $telp = mysqli_real_escape_string($koneksi, $data['telp']);
    $alamat = mysqli_real_escape_string($koneksi, $data['alamat']);
    $rekening = mysqli_real_escape_string($koneksi, $data['rekening']);
    $total = floatval($data['total']);

    file_put_contents('debug.log', "Data processed - Nama: $nama, Telp: $telp\n", FILE_APPEND);

    // Mulai transaksi
    mysqli_begin_transaction($koneksi);

    // Generate ID Pelanggan
    $sql_max_id = "SELECT MAX(CAST(SUBSTRING(id_pelanggan, 2) AS UNSIGNED)) as max_id FROM pelanggan";
    $result_max = mysqli_query($koneksi, $sql_max_id);
    
    if (!$result_max) {
        throw new Exception("Query max_id failed: " . mysqli_error($koneksi));
    }
    
    $row = mysqli_fetch_assoc($result_max);
    $next_id = $row['max_id'] ? $row['max_id'] + 1 : 1;
    $id_pelanggan = 'P' . str_pad($next_id, 3, '0', STR_PAD_LEFT);

    file_put_contents('debug.log', "Generated ID Pelanggan: $id_pelanggan\n", FILE_APPEND);

    // 1. Insert data ke tabel pelanggan
    $sql_pelanggan = "INSERT INTO pelanggan (id_pelanggan, nama_pelanggan, notelp_pelanggan, alamat, rekening) 
                     VALUES ('$id_pelanggan', '$nama', '$telp', '$alamat', '$rekening')";
    
    file_put_contents('debug.log', "SQL Pelanggan: $sql_pelanggan\n", FILE_APPEND);
    
    $result_pelanggan = mysqli_query($koneksi, $sql_pelanggan);
    
    if (!$result_pelanggan) {
        throw new Exception("Gagal menyimpan data pelanggan: " . mysqli_error($koneksi));
    }

    file_put_contents('debug.log', "Pelanggan saved successfully\n", FILE_APPEND);

    // 2. Insert data ke tabel detail_penjualan
    foreach ($data['cart'] as $index => $item) {
        $nama_menu = mysqli_real_escape_string($koneksi, $item['name']);
        $harga_satuan = floatval($item['price']);
        $jumlah = intval($item['quantity']);
        $subtotal = $harga_satuan * $jumlah;
        
        // Generate ID Detail
        $sql_max_detail = "SELECT MAX(CAST(SUBSTRING(id_detail, 2) AS UNSIGNED)) as max_id FROM detail_penjualan";
        $result_max_detail = mysqli_query($koneksi, $sql_max_detail);
        
        if (!$result_max_detail) {
            throw new Exception("Query max_detail failed: " . mysqli_error($koneksi));
        }
        
        $row_detail = mysqli_fetch_assoc($result_max_detail);
        $next_id_detail = $row_detail['max_id'] ? $row_detail['max_id'] + 1 : 1;
        $id_detail = 'D' . str_pad($next_id_detail + $index, 3, '0', STR_PAD_LEFT);
        
        $sql_detail = "INSERT INTO detail_penjualan (id_detail, id_pelanggan, nama_menu, jumlah, harga_satuan, subtotal) 
                      VALUES ('$id_detail', '$id_pelanggan', '$nama_menu', '$jumlah', '$harga_satuan', '$subtotal')";
        
        file_put_contents('debug.log', "SQL Detail: $sql_detail\n", FILE_APPEND);
        
        $result_detail = mysqli_query($koneksi, $sql_detail);
        
        if (!$result_detail) {
            throw new Exception("Gagal menyimpan detail penjualan: " . mysqli_error($koneksi));
        }
        
        file_put_contents('debug.log', "Detail $id_detail saved successfully\n", FILE_APPEND);
    }
    
    // Commit transaksi
    mysqli_commit($koneksi);
    
    file_put_contents('debug.log', "Transaction committed successfully\n", FILE_APPEND);
    
    echo json_encode([
        "status" => "success", 
        "message" => "Pesanan berhasil disimpan",
        "id_pelanggan" => $id_pelanggan,
        "total" => $total
    ]);

} catch (Exception $e) {
    // Rollback transaksi jika ada error
    mysqli_rollback($koneksi);
    
    file_put_contents('debug.log', "ERROR: " . $e->getMessage() . "\n", FILE_APPEND);
    
    echo json_encode([
        "status" => "error", 
        "message" => "Gagal menyimpan pesanan: " . $e->getMessage()
    ]);
}

mysqli_close($koneksi);
file_put_contents('debug.log', "=== CHECKOUT PROCESS ENDED ===\n\n", FILE_APPEND);
?>