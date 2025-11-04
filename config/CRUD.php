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
    $targetDir = __DIR__ . "/../asset/uploads/";  // 🔹 gunakan path absolut agar Linux tidak bingung
    if (!file_exists($targetDir)) mkdir($targetDir, 0777, true);

    $filename = time() . "_" . basename($_FILES["gambar"]["name"]);
    $targetFile = $targetDir . $filename;

    if (move_uploaded_file($_FILES["gambar"]["tmp_name"], $targetFile)) {
        $gambar = "/../asset/uploads/" . $filename; // 🔹 simpan path relatif agar mudah ditampilkan di <img>
    } else {
        echo "<p style='color:red;'>❌ Gagal upload gambar ke $targetFile</p>";
    }
}


    if ($id == "") {
        // CREATE
        $stmt = $conn->prepare("INSERT INTO menuu (nama_menu, stok_menu, harga_menu, deskripsi, gambar) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sidss", $nama, $stok, $harga, $deskripsi, $gambar);
    } else {
        // UPDATE
        if ($gambar != "") {
            $stmt = $conn->prepare("UPDATE menuu SET nama_menu=?, stok_menu=?, harga_menu=?, deskripsi=?, gambar=? WHERE id_menu=?");
            $stmt->bind_param("sidssi", $nama, $stok, $harga, $deskripsi, $gambar, $id);
        } else {
            $stmt = $conn->prepare("UPDATE menuu SET nama_menu=?, stok_menu=?, harga_menu=?, deskripsi=? WHERE id_menu=?");
            $stmt->bind_param("sid si", $nama, $stok, $harga, $deskripsi, $id);
        }
    }

    $stmt->execute();
    header("Location: index.php");
    exit;
}

// ==== PROSES HAPUS ====
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    $conn->query("DELETE FROM menuu WHERE id_menu=$id");
    header("Location: index.php");
    exit;
}

// ==== TAMPILKAN DATA UNTUK EDIT ====


if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $result = $conn->query("SELECT * FROM menuu WHERE id_menu=$id");
    $edit = $result->fetch_assoc();
}

// ==== TAMPILKAN SEMUA DATA ====
$result = $conn->query("SELECT * FROM menuu ORDER BY id_menu DESC");
?>