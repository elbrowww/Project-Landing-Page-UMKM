<?php
session_start();

  if (!isset($_SESSION['login'])) {
        header("Location: login.php");
        exit();
    }
   
include '../config/koneksi.php';
include '../config/CRUD.php';
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard Admin | Bu Mon</title>
   <link rel="icon" href="../asset/img/logo.png" type="image/x-icon">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-4">
  <h2 class="text-center mb-4">🍽️ Dashboard Admin - Daftar Menu</h2>

  <!-- Form Tambah / Edit -->
  <div class="card mb-4 shadow-sm">
    <div class="card-header bg-primary text-white">
      <?= isset($edit) ? 'Edit Menu' : 'Tambah Menu Baru' ?>
    </div>
    <div class="card-body">
      <form method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id_menu" value="<?= $edit['id_menu'] ?? '' ?>">

        <div class="mb-3">
          <label class="form-label">Nama Menu</label>
          <input type="text" class="form-control" name="nama_menu" required value="<?= $edit['nama_menu'] ?? '' ?>">
        </div>

        <div class="mb-3">
          <label class="form-label">Stok</label>
          <input type="number" class="form-control" name="stok_menu" required value="<?= $edit['stok_menu'] ?? '' ?>">
        </div>

        <div class="mb-3">
          <label class="form-label">Harga</label>
          <input type="number" class="form-control" name="harga_menu" required value="<?= $edit['harga_menu'] ?? '' ?>">
        </div>

        <div class="mb-3">
          <label class="form-label">Deskripsi</label>
          <textarea class="form-control" name="deskripsi" rows="3"><?= $edit['deskripsi'] ?? '' ?></textarea>
        </div>

        <div class="mb-3">
          <label class="form-label">Gambar</label>
          <?php if (!empty($edit['gambar'])): ?>
            <div class="mb-2">
              <img src="<?= $edit['gambar'] ?>" alt="Gambar Menu" width="120">
            </div>
          <?php endif; ?>
          <input type="file" class="form-control" name="gambar">
        </div>

        <button type="submit" name="simpan" class="btn btn-success">
          💾 <?= isset($edit) ? 'Update' : 'Simpan' ?>
        </button>
        <a href="index.php" class="btn btn-secondary">Batal</a>
      </form>
    </div>
  </div>

  <!-- Tabel Data Menu -->
  <div class="card shadow-sm">
    <div class="card-header bg-dark text-white">
      Daftar Menu
    </div>
    <div class="card-body table-responsive">
      <table class="table table-bordered align-middle">
        <thead class="table-dark">
          <tr>
            <th width="5%">No</th>
            <th>Nama</th>
            <th>Stok</th>
            <th>Harga</th>
            <th>Deskripsi</th>
            <th>Gambar</th>
            <th width="15%">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php 
          $no = 1;
          while ($row = $result->fetch_assoc()): ?>
          <tr>
            <td><?= $no++ ?></td>
            <td><?= htmlspecialchars($row['nama_menu']) ?></td>
            <td><?= htmlspecialchars($row['stok_menu']) ?></td>
            <td>Rp. <?= number_format($row['harga_menu'], 0, ',', '.') ?></td>
            <td><?= htmlspecialchars($row['deskripsi']) ?></td>
            <td>
  <?php if (!empty($row['gambar'])): ?>
    <img src="../asset/uploads/<?php echo $row['gambar'] ?>" alt="Gambar Menu" width="80" class="img-thumbnail">
  <?php else: ?>
    <span class="text-muted">Tidak ada gambar</span>
  <?php endif; ?>
</td>

            <td>
              <a href="?edit=<?= $row['id_menu'] ?>" class="btn btn-warning btn-sm">✏️ Edit</a>
              <a href="?hapus=<?= $row['id_menu'] ?>" class="btn btn-danger btn-sm"
                 onclick="return confirm('Yakin ingin menghapus menu ini?')">🗑️ Hapus</a>
            </td>
          </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

</body>
</html>
