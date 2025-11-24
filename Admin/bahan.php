<?php

session_start();
if (!isset($_SESSION['login'])) {
  header("Location: login.php");
  exit();
}

error_reporting(E_ALL);
ini_set('display_errors', 1);
include '../config/koneksi.php';

// Handler untuk bahan
if (isset($_GET['hapus_bahan'])) {
  $id_bahan = $_GET['hapus_bahan'];
  $query_hapus_bahan = "DELETE FROM bahan WHERE id_bahan = ?";
  $stmt_hapus_bahan = $koneksi->prepare($query_hapus_bahan);
  $stmt_hapus_bahan->bind_param("s", $id_bahan);
  if ($stmt_hapus_bahan->execute()) {
    echo "<script>alert('Bahan berhasil dihapus!'); window.location.href='bahan.php?page=bahan';</script>";
  } else {
    echo "<script>alert('Gagal menghapus bahan!'); window.location.href='bahan.php?page=bahan';</script>";
  }
  exit();
}

if (isset($_POST['simpan_bahan'])) {
  $id_bahan = $_POST['id_bahan'] ?? null;
  $nama_bahan = $_POST['nama_bahan'];
  $stok = $_POST['stok'];
  $harga_beli = $_POST['harga_beli'];
  $satuan = $_POST['satuan'];


  if ($id_bahan) {
    // Edit bahan
    $query_edit = "UPDATE bahan SET nama_bahan=?, stok=?, harga_beli=?, satuan=? WHERE id_bahan=?";
    $stmt_edit = $koneksi->prepare($query_edit);
    $stmt_edit->bind_param("siiss", $nama_bahan, $stok, $harga_beli, $satuan, $id_bahan);
    if ($stmt_edit->execute()) {
      echo "<script>alert('Bahan berhasil diupdate!'); window.location.href='bahan.php?page=bahan';</script>";
    } else {
      echo "<script>alert('Gagal mengupdate bahan!'); window.location.href='bahan.php?page=bahan';</script>";
    }
  } else {
    // Tambah bahan
    $query_tambah = "INSERT INTO bahan (nama_bahan, stok, harga_beli, satuan) VALUES (?, ?, ?, ?)";
    $stmt_tambah = $koneksi->prepare($query_tambah);
    $stmt_tambah->bind_param("siis", $nama_bahan, $stok, $harga_beli, $satuan);
    if ($stmt_tambah->execute()) {
      echo "<script>alert('Bahan berhasil ditambahkan!'); window.location.href='bahan.php?page=bahan';</script>";
    } else {
      echo "<script>alert('Gagal menambahkan bahan!'); window.location.href='bahan.php?page=bahan';</script>";
    }
  }
  exit();
}

// Query untuk bahan
$query_bahan = "SELECT * FROM bahan ORDER BY nama_bahan ASC";
$result_bahan = $koneksi->query($query_bahan);

?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dashboard Admin | Bu Mon</title>
<link rel="icon" href="../asset/img/logo.png" type="image/x-icon">

<!-- Bootstrap & Font Awesome -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

<!-- Custom CSS -->
<link rel="stylesheet" href="../asset/css/admin.css">
</head>

<body>
  <!-- Include Navbar -->
  <?php include 'navbar.php'; ?>
  

  <!-- Kelola Bahan -->
<div id="page-bahan" class="page-content">
<div class="container">
  <div class="page-header d-flex justify-content-between align-items-center">
    <h3><i class="fas fa-box"></i> Daftar Bahan</h3>
    <button class="btn btn-add" data-bs-toggle="modal" data-bs-target="#tambahBahanModal">
      <i class="fas fa-plus-circle"></i> Tambah Bahan
    </button>
  </div>

  <div class="card">
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table mb-0">
          <thead>
            <tr>
              <th>No</th>
              <th>Nama Bahan</th>
              <th>Stok</th>
              <th>Harga</th>
              <th>Satuan</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php 
            $no = 1;
            if ($result_bahan && $result_bahan->num_rows > 0):
              while ($row_bahan = $result_bahan->fetch_assoc()):
            ?>
            <tr>
              <td><?= $no++ ?></td>
              <td><strong><?= htmlspecialchars($row_bahan['nama_bahan']) ?></strong></td>
              <td><span class="badge-stock"><?= htmlspecialchars($row_bahan['stok']) ?></span></td>
              <td><span class="badge-price">Rp <?= number_format($row_bahan['harga_beli'], 0, ',', '.') ?></span></td>
              <td><?= htmlspecialchars($row_bahan['satuan']) ?></td>
              <td>
                <button class="btn btn-action btn-edit" 
                        onclick="editBahan('<?= $row_bahan['id_bahan'] ?>', '<?= addslashes($row_bahan['nama_bahan']) ?>', <?= $row_bahan['stok'] ?>, <?= $row_bahan['harga_beli'] ?>, '<?= addslashes($row_bahan['satuan']) ?>')">
                  <i class="fas fa-edit"></i>
                </button>
                <a href="?page=bahan&hapus_bahan=<?= $row_bahan['id_bahan'] ?>" 
                   onclick="return confirm('Hapus bahan <?= htmlspecialchars($row_bahan['nama_bahan']) ?>?')" 
                   class="btn btn-action btn-delete">
                  <i class="fas fa-trash-alt"></i>
                </a>
              </td>
            </tr>
            <?php endwhile; else: ?>
              <tr><td colspan="6" class="no-data"><i class="fas fa-inbox"></i><p>Belum ada bahan</p></td></tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<!-- Modal Tambah/Edit Bahan -->
<div class="modal fade" id="tambahBahanModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 id="modalTitleBahan"><i class="fas fa-plus-circle"></i> Tambah Bahan Baru</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body p-4">
        <form method="POST" id="bahanForm">
          <input type="hidden" name="id_bahan" id="id_bahan">
          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label">Nama Bahan</label>
              <input type="text" class="form-control" name="nama_bahan" id="nama_bahan" required>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">Stok</label>
              <input type="number" class="form-control" name="stok" id="stok" required min="0">
            </div>
          </div>
          <div class="mb-3">
            <label class="form-label">Harga</label>
            <input type="number" class="form-control" name="harga_beli" id="harga_beli" required min="0">
          </div>
          <div class="mb-3">
            <label class="form-label">Satuan</label>
            <textarea class="form-control" name="satuan" id="satuan" rows="3"></textarea>
          </div>
          <button type="submit" name="simpan_bahan" class="btn btn-submit"><i class="fas fa-save"></i> Simpan</button>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Bootstrap & JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
// Fungsi edit bahan
function editBahan(id, nama, stok, harga, satuan) {
  document.getElementById('modalTitleBahan').innerHTML = '<i class="fas fa-edit"></i> Edit Bahan';
  document.getElementById('id_bahan').value = id;
  document.getElementById('nama_bahan').value = nama;
  document.getElementById('stok').value = stok;
  document.getElementById('harga_beli').value = harga;
  document.getElementById('satuan').value = satuan;
  
  var modal = new bootstrap.Modal(document.getElementById('tambahBahanModal'));
  modal.show();
}

// Reset form saat modal ditutup
document.getElementById('tambahBahanModal').addEventListener('hidden.bs.modal', function () {
  document.getElementById('bahanForm').reset();
  document.getElementById('id_bahan').value = '';
  document.getElementById('modalTitleBahan').innerHTML = '<i class="fas fa-plus-circle"></i> Tambah Bahan Baru';
});
</script>

</body>
</html>