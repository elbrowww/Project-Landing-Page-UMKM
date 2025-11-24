<?php
include '../config/koneksi.php';

// ==== PROSES TAMBAH / EDIT ====
if (isset($_POST['simpan'])) {
    $id         = $_POST['id_menu'];
    $nama       = $_POST['nama_menu'];
    $stok       = $_POST['stok_menu'];
    $harga      = $_POST['harga_menu'];
    $deskripsi  = $_POST['deskripsi'];
    $gambar     = "";

    // Upload gambar jika ada
    if (!empty($_FILES['gambar']['name'])) {
        $targetDir = __DIR__ . "/../asset/uploads/";
        if (!file_exists($targetDir)) mkdir($targetDir, 0777, true);

        $filename = basename($_FILES["gambar"]["name"]);
        $targetFile = $targetDir . $filename;

        if (move_uploaded_file($_FILES["gambar"]["tmp_name"], $targetFile)) {
            $gambar = $filename;
        }
    }

    if ($id == "") {
        // ==== CREATE ====
        $stmt = $koneksi->prepare("INSERT INTO menu (nama_menu, stok_menu, harga_menu, deskripsi, gambar) 
                                   VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sidss", $nama, $stok, $harga, $deskripsi, $gambar);

    } else {
        // ==== UPDATE ====
        if ($gambar != "") {
            // Update + gambar
            $stmt = $koneksi->prepare("UPDATE menu 
                                       SET nama_menu=?, stok_menu=?, harga_menu=?, deskripsi=?, gambar=?
                                       WHERE id_menu=?");
            $stmt->bind_param("sidsss", $nama, $stok, $harga, $deskripsi, $gambar, $id);

        } else {
            // Update tanpa gambar
            $stmt = $koneksi->prepare("UPDATE menu 
                                       SET nama_menu=?, stok_menu=?, harga_menu=?, deskripsi=?
                                       WHERE id_menu=?");
            $stmt->bind_param("sidss", $nama, $stok, $harga, $deskripsi, $id);
        }
    }

    $stmt->execute();
    header("Location: menu.php");
    exit;
}


// ==== PROSES HAPUS ====
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    $koneksi->query("DELETE FROM menu WHERE id_menu='$id'");
    header("Location: menu.php");
    exit;
}


// ==== AMBIL DATA UNTUK FORM EDIT ====
$edit = [
    'id_menu' => '',
    'nama_menu' => '',
    'stok_menu' => '',
    'harga_menu' => '',
    'deskripsi' => '',
    'gambar' => ''
];

if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $result = $koneksi->query("SELECT * FROM menu WHERE id_menu='$id'");
    $edit = $result->fetch_assoc();
}


// ==== TAMPILKAN SEMUA DATA ====
$result = $koneksi->query("SELECT * FROM menu ORDER BY id_menu DESC");
?>