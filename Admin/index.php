<?php
session_start();
if (!isset($_SESSION['login'])) {
  header("Location: login.php");
  exit();
}

error_reporting(E_ALL);
ini_set('display_errors', 1);
include '../config/koneksi.php';
include '../config/CRUD.php';

// ambil data menu
$query = "SELECT * FROM menu ORDER BY id_menu DESC";
$result = $koneksi->query($query);

// ambil data untuk edit
if (isset($_GET['edit'])) {
  $id = $_GET['edit'];
  $edit = $koneksi->query("SELECT * FROM menu WHERE id_menu='$id'")->fetch_assoc();
}

// hapus data
if (isset($_GET['hapus'])) {
  $id = $_GET['hapus'];
  $koneksi->query("DELETE FROM menu WHERE id_menu='$id'");
  header("Location: index.php");
  exit();
}

// simpan data baru atau update
if (isset($_POST['simpan'])) {
  $nama = $_POST['nama_menu'];
  $stok = $_POST['stok_menu'];
  $harga = $_POST['harga_menu'];
  $deskripsi = $_POST['deskripsi'];
  $gambar = $_FILES['gambar']['name'];

  if ($gambar) {
    $target = "../asset/uploads/" . basename($gambar);
    move_uploaded_file($_FILES['gambar']['tmp_name'], $target);
  }

  if (!empty($_POST['id_menu'])) {
    // update
    $id = $_POST['id_menu'];
    $sql = "UPDATE menu SET nama_menu='$nama', stok_menu='$stok', harga_menu='$harga', deskripsi='$deskripsi' ";
    if ($gambar) $sql .= ", gambar='$gambar' ";
    $sql .= "WHERE id_menu='$id'";
  } else {
    // tambah baru
    $sql = "INSERT INTO menu (nama_menu, stok_menu, harga_menu, deskripsi, gambar) 
            VALUES ('$nama', '$stok', '$harga', '$deskripsi', '$gambar')";
  }

  if ($koneksi->query($sql)) {
    header("Location: index.php");
    exit();
  }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dashboard Admin | Bu Mon</title>
<link rel="icon" href="../asset/img/logo.png" type="image/x-icon">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<link rel="stylesheet" href="../css/admin.css">
</head>

<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="#"><i class="fa fa-utensils"></i> Bu Mon Admin</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav me-auto">
        <li class="nav-item"><a class="nav-link active menu-link" data-page="dashboard" href="#">Dashboard</a></li>
        <li class="nav-item"><a class="nav-link menu-link" data-page="pesanan" href="#">Pesanan Masuk</a></li>
        <li class="nav-item"><a class="nav-link menu-link" data-page="testimoni" href="#">Edit Testimoni</a></li>
      </ul>

      <ul class="navbar-nav">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
            <i class="fa fa-user"></i> Admin
          </a>
          <ul class="dropdown-menu dropdown-menu-end">
            <li><a class="dropdown-item" href="#">Profil</a></li>
            <li><a class="dropdown-item text-danger" href="logout.php">Logout</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>

<!-- Konten -->
<div class="container" id="content-area">

  <!-- Dashboard -->
  <div id="dashboard-page">
    <h3 class="mb-3 mt-3"><i class="fa fa-list"></i> Dashboard Admin - Daftar Menu</h3>

    <!-- tombol tambah -->
    <button class="btn btn-custom mb-3" data-bs-toggle="modal" data-bs-target="#tambahMenuModal">
      <i class="fa fa-plus"></i> Tambah Menu
    </button>

    <!-- tabel dari database -->
    <div class="card shadow-sm">
      <div class="card-body table-responsive">
        <table class="table table-bordered align-middle">
          <thead class="table-primary">
            <tr>
              <th>No</th>
              <th>Nama</th>
              <th>Stok</th>
              <th>Harga</th>
              <th>Deskripsi</th>
              <th>Gambar</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
          <?php $no = 1; while ($row = $result->fetch_assoc()): ?>
            <tr>
              <td><?= $no++ ?></td>
              <td><?= htmlspecialchars($row['nama_menu']) ?></td>
              <td><?= htmlspecialchars($row['stok_menu']) ?></td>
              <td>Rp <?= number_format($row['harga_menu'], 0, ',', '.') ?></td>
              <td><?= htmlspecialchars($row['deskripsi']) ?></td>
              <td>
                <?php if (!empty($row['gambar'])): ?>
                  <img src="../asset/uploads/<?= $row['gambar'] ?>" width="80" class="img-thumbnail">
                <?php else: ?>
                  <span class="text-muted">Tidak ada gambar</span>
                <?php endif; ?>
              </td>
              <td>
                <a href="?edit=<?= $row['id_menu'] ?>" class="btn btn-warning btn-sm"><i class="fa fa-pen"></i></a>
                <a href="?hapus=<?= $row['id_menu'] ?>" onclick="return confirm('Hapus menu ini?')" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
              </td>
            </tr>
          <?php endwhile; ?>
          </tbody>
        </table>
      </div>
    </div>

    
  </div>

</div>

<!-- Modal Tambah Menu -->
<div class="modal fade" id="tambahMenuModal" tabindex="-1" aria-labelledby="tambahMenuModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><i class="fa fa-plus"></i> Tambah Menu Baru</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <form method="POST" enctype="multipart/form-data">
          <div class="mb-3">
            <label class="form-label">Nama Menu</label>
            <input type="text" class="form-control" name="nama_menu" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Stok</label>
            <input type="number" class="form-control" name="stok_menu" required min="0">
          </div>
          <div class="mb-3">
            <label class="form-label">Harga (Rp)</label>
            <input type="number" class="form-control" name="harga_menu" required min="0">
          </div>
          <div class="mb-3">
            <label class="form-label">Deskripsi</label>
            <textarea class="form-control" name="deskripsi" rows="3"></textarea>
          </div>
          <div class="mb-3">
            <label class="form-label">Gambar</label>
            <input type="file" class="form-control" name="gambar" accept="image/*">
          </div>
          <button type="submit" name="simpan" class="btn btn-custom">Simpan</button>
        </form>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="../js/admin.js"></script>
</body>
</html>
