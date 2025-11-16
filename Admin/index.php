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

// Handler untuk hapus pesanan
if (isset($_GET['hapus_pesanan'])) {
  $id_detail = $_GET['hapus_pesanan'];
  
  $query_hapus_pesanan = "DELETE FROM detail_penjualan WHERE id_detail = ?";
  $stmt_hapus_pesanan = $koneksi->prepare($query_hapus_pesanan);
  $stmt_hapus_pesanan->bind_param("s", $id_detail);
  
  if ($stmt_hapus_pesanan->execute()) {
    echo "<script>alert('Pesanan berhasil dihapus!'); window.location.href='index.php';</script>";
  } else {
    echo "<script>alert('Gagal menghapus pesanan!'); window.location.href='index.php';</script>";
  }
  exit();
}

// Handler untuk update pesanan
if (isset($_POST['update_pesanan'])) {
  $id_detail = $_POST['id_detail'];
  $id_menu = $_POST['id_menu'];
  $jumlah = $_POST['jumlah'];
  $harga_satuan = $_POST['harga_satuan'];
  $subtotal = $jumlah * $harga_satuan;
  
  $query_update = "UPDATE detail_penjualan SET id_menu=?, jumlah=?, harga_satuan=?, subtotal=? WHERE id_detail=?";
  $stmt_update = $koneksi->prepare($query_update);
  $stmt_update->bind_param("siiis", $id_menu, $jumlah, $harga_satuan, $subtotal, $id_detail);
  
  if ($stmt_update->execute()) {
    echo "<script>alert('Pesanan berhasil diupdate!'); window.location.href='index.php';</script>";
  } else {
    echo "<script>alert('Gagal mengupdate pesanan!'); window.location.href='index.php';</script>";
  }
  exit();
}

// Query untuk mengambil data pesanan dari detail_penjualan
$query_pesanan = "SELECT * FROM detail_penjualan ORDER BY tgl_pesan DESC";
$result_pesanan = $koneksi->query($query_pesanan);

// Hitung statistik pesanan
$query_stats = "SELECT 
  COUNT(*) as total_pesanan,
  SUM(subtotal) as total_penjualan
FROM detail_penjualan";
$result_stats = $koneksi->query($query_stats);
$stats = $result_stats->fetch_assoc();
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

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="javascript:void(0)" onclick="showPage('dashboard')">
      <i class="fas fa-utensils"></i> Bu Mon Admin
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav me-auto">
        <li class="nav-item">
          <a class="nav-link active" href="javascript:void(0)" onclick="showPage('dashboard')" id="nav-dashboard">
            <i class="fas fa-chart-line"></i> Dashboard
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="javascript:void(0)" onclick="showPage('penjualan')" id="nav-penjualan">
            <i class="fas fa-shopping-cart"></i> Pesanan Masuk
          </a>
        </li>
      <ul class="navbar-nav">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
            <i class="fas fa-user-circle"></i> Admin
          </a>
          <ul class="dropdown-menu dropdown-menu-end">
            <li><a class="dropdown-item" href="#"><i class="fas fa-user"></i> Profil</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item text-danger" href="../config/logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>

<!-- HALAMAN DASHBOARD MENU -->
<div id="page-dashboard" class="page-content">
  <div class="container">
    <div class="page-header d-flex justify-content-between align-items-center">
      <h3><i class="fas fa-list-alt"></i> Daftar Menu</h3>
      <button class="btn btn-add" data-bs-toggle="modal" data-bs-target="#tambahMenuModal">
        <i class="fas fa-plus-circle"></i> Tambah Menu
      </button>
    </div>

    <div class="card">
      <div class="card-body p-0">
        <div class="table-responsive">
          <table class="table mb-0">
            <thead>
              <tr>
                <th>No</th><th>Nama</th><th>Stok</th><th>Harga</th><th>Deskripsi</th><th>Gambar</th><th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php 
              $no = 1;
              if ($result && $result->num_rows > 0):
                while ($row = $result->fetch_assoc()):
              ?>
              <tr>
                <td><?= $no++ ?></td>
                <td><strong><?= htmlspecialchars($row['nama_menu']) ?></strong></td>
                <td><span class="badge-stock"><?= htmlspecialchars($row['stok_menu']) ?></span></td>
                <td><span class="badge-price">Rp <?= number_format($row['harga_menu'], 0, ',', '.') ?></span></td>
                <td><?= htmlspecialchars($row['deskripsi']) ?></td>
                <td>
                  <?php if ($row['gambar']): ?>
                    <img src="../asset/uploads/<?= $row['gambar'] ?>" class="menu-image" alt="">
                  <?php else: ?>
                    <span class="text-muted"><i class="fas fa-image"></i> Tidak ada</span>
                  <?php endif; ?>
                </td>
                <td>
                  <button class="btn btn-action btn-edit" 
                          onclick="editMenu('<?= $row['id_menu'] ?>', '<?= addslashes($row['nama_menu']) ?>', <?= $row['stok_menu'] ?>, <?= $row['harga_menu'] ?>, '<?= addslashes($row['deskripsi']) ?>', '<?= $row['gambar'] ?>')">
                    <i class="fas fa-edit"></i>
                  </button>
                  <a href="?hapus=<?= $row['id_menu'] ?>" onclick="return confirm('Hapus menu <?= htmlspecialchars($row['nama_menu']) ?>?')" class="btn btn-action btn-delete">
                    <i class="fas fa-trash-alt"></i>
                  </a>
                </td>
              </tr>
              <?php endwhile; else: ?>
                <tr><td colspan="7" class="no-data"><i class="fas fa-inbox"></i><p>Belum ada menu</p></td></tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- HALAMAN PENJUALAN -->
<div id="page-penjualan" class="page-content" style="display:none;">
  <div class="container">
    <!-- Statistik Cards -->
    <div class="row mb-4">
      <div class="col-md-6 mb-3">
        <div class="stats-card">
          <div class="stats-icon bg-primary">
            <i class="fas fa-shopping-cart"></i>
          </div>
          <div class="stats-info">
            <h3><?= $stats['total_pesanan'] ?? 0 ?></h3>
            <p>Total Pesanan</p>
          </div>
        </div>
      </div>
      <div class="col-md-6 mb-3">
        <div class="stats-card">
          <div class="stats-icon bg-info">
            <i class="fas fa-money-bill-wave"></i>
          </div>
          <div class="stats-info">
            <h3>Rp <?= number_format($stats['total_penjualan'] ?? 0, 0, ',', '.') ?></h3>
            <p>Total Penjualan</p>
          </div>
        </div>
      </div>
    </div>

    <div class="page-header">
      <h3><i class="fas fa-shopping-cart"></i> Daftar Pesanan Masuk</h3>
    </div>

    <div class="card">
      <div class="card-body p-0">
        <div class="table-responsive">
          <table class="table mb-0">
            <thead>
              <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>ID Detail</th>
                <th>ID Menu</th>
                <th>ID Pesanan</th>
                <th>Jumlah</th>
                <th>Harga Satuan</th>
                <th>Subtotal</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php 
              $no = 1;
              if ($result_pesanan && $result_pesanan->num_rows > 0):
                while ($row_pesanan = $result_pesanan->fetch_assoc()):
              ?>
              <tr>
                <td><?= $no++ ?></td>
                <td><?= date('d/m/Y H:i', strtotime($row_pesanan['tgl_pesan'])) ?></td>
                <td><strong><?= htmlspecialchars($row_pesanan['id_detail']) ?></strong></td>
                <td><?= htmlspecialchars($row_pesanan['id_menu']) ?></td>
                <td><strong><?= htmlspecialchars($row_pesanan['id_pesanan']) ?></td>
                <td><span class="badge-qty"><?= htmlspecialchars($row_pesanan['jumlah']) ?></span></td>
                <td><span class="badge-price">Rp <?= number_format($row_pesanan['harga_satuan'], 0, ',', '.') ?></span></td>
                <td><span class="badge-price">Rp <?= number_format($row_pesanan['subtotal'], 0, ',', '.') ?></span></td>
                <td>
                  <button class="btn btn-action btn-edit" 
                          onclick="editPesanan('<?= $row_pesanan['id_detail'] ?>', '<?= $row_pesanan['id_menu'] ?>', <?= $row_pesanan['jumlah'] ?>, <?= $row_pesanan['harga_satuan'] ?>)">
                    <i class="fas fa-edit"></i>
                  </button>
                  <a href="?hapus_pesanan=<?= $row_pesanan['id_detail'] ?>" 
                     onclick="return confirm('Hapus pesanan dengan ID <?= htmlspecialchars($row_pesanan['id_detail']) ?>?')" 
                     class="btn btn-action btn-delete">
                    <i class="fas fa-trash-alt"></i>
                  </a>
                </td>
              </tr>
              <?php endwhile; else: ?>
                <tr>
                  <td colspan="8" class="no-data">
                    <i class="fas fa-inbox"></i>
                    <p>Belum ada pesanan masuk</p>
                  </td>
                </tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal Tambah/Edit Menu -->
<div class="modal fade" id="tambahMenuModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 id="modalTitle"><i class="fas fa-plus-circle"></i> Tambah Menu Baru</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body p-4">
        <form method="POST" enctype="multipart/form-data" id="menuForm">
          <input type="hidden" name="id_menu" id="id_menu">
          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label">Nama Menu</label>
              <input type="text" class="form-control" name="nama_menu" id="nama_menu" required>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">Stok</label>
              <input type="number" class="form-control" name="stok_menu" id="stok_menu" required min="0">
            </div>
          </div>
          <div class="mb-3">
            <label class="form-label">Harga</label>
            <input type="number" class="form-control" name="harga_menu" id="harga_menu" required min="0">
          </div>
          <div class="mb-3">
            <label class="form-label">Deskripsi</label>
            <textarea class="form-control" name="deskripsi" id="deskripsi" rows="3"></textarea>
          </div>
          <div class="mb-3">
            <label class="form-label">Gambar</label>
            <input type="file" class="form-control" name="gambar" id="gambar" accept="image/*">
            <div id="currentImage" style="display:none; margin-top:10px;">
              <p>Gambar saat ini:</p>
              <img id="previewImage" src="" style="max-width:150px;border-radius:10px;">
            </div>
          </div>
          <button type="submit" name="simpan" class="btn btn-submit"><i class="fas fa-save"></i> Simpan</button>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal Edit Pesanan -->
<div class="modal fade" id="editPesananModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5><i class="fas fa-edit"></i> Edit Pesanan</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body p-4">
        <form method="POST" id="pesananForm">
          <input type="hidden" name="id_detail" id="edit_id_detail">
          <div class="mb-3">
            <label class="form-label">ID Menu</label>
            <input type="text" class="form-control" name="id_menu" id="edit_id_menu" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Jumlah</label>
            <input type="number" class="form-control" name="jumlah" id="edit_jumlah" required min="1">
          </div>
          <div class="mb-3">
            <label class="form-label">Harga Satuan</label>
            <input type="number" class="form-control" name="harga_satuan" id="edit_harga_satuan" required min="0">
          </div>
          <button type="submit" name="update_pesanan" class="btn btn-submit">
            <i class="fas fa-save"></i> Update Pesanan
          </button>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Bootstrap & JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<?php if ($edit): ?>
<script>
editMenu(
  <?= $edit['id_menu'] ?>,
  '<?= addslashes($edit['nama_menu']) ?>',
  <?= $edit['stok_menu'] ?>,
  <?= $edit['harga_menu'] ?>,
  '<?= addslashes($edit['deskripsi']) ?>',
  '<?= $edit['gambar'] ?>'
);
</script>
<?php endif; ?>

<script>
// Fungsi untuk menampilkan halaman
function showPage(pageName) {
  // Sembunyikan semua halaman
  document.querySelectorAll('.page-content').forEach(page => {
    page.style.display = 'none';
  });
  
  // Hapus class active dari semua nav-link
  document.querySelectorAll('.nav-link').forEach(link => {
    link.classList.remove('active');
  });
  
  // Tampilkan halaman yang dipilih
  document.getElementById('page-' + pageName).style.display = 'block';
  
  // Tambah class active ke nav-link yang dipilih
  document.getElementById('nav-' + pageName).classList.add('active');
}

// Fungsi edit menu
function editMenu(id, nama, stok, harga, deskripsi, gambar) {
  document.getElementById('modalTitle').innerHTML = '<i class="fas fa-edit"></i> Edit Menu';
  document.getElementById('id_menu').value = id;
  document.getElementById('nama_menu').value = nama;
  document.getElementById('stok_menu').value = stok;
  document.getElementById('harga_menu').value = harga;
  document.getElementById('deskripsi').value = deskripsi;
  
  if (gambar) {
    document.getElementById('currentImage').style.display = 'block';
    document.getElementById('previewImage').src = '../asset/uploads/' + gambar;
  } else {
    document.getElementById('currentImage').style.display = 'none';
  }
  
  var modal = new bootstrap.Modal(document.getElementById('tambahMenuModal'));
  modal.show();
}

// Fungsi edit pesanan
function editPesanan(id_detail, id_menu, jumlah, harga_satuan) {
  document.getElementById('edit_id_detail').value = id_detail;
  document.getElementById('edit_id_menu').value = id_menu;
  document.getElementById('edit_jumlah').value = jumlah;
  document.getElementById('edit_harga_satuan').value = harga_satuan;
  
  var modal = new bootstrap.Modal(document.getElementById('editPesananModal'));
  modal.show();
}

// Reset form saat modal ditutup
document.getElementById('tambahMenuModal').addEventListener('hidden.bs.modal', function () {
  document.getElementById('menuForm').reset();
  document.getElementById('id_menu').value = '';
  document.getElementById('currentImage').style.display = 'none';
  document.getElementById('modalTitle').innerHTML = '<i class="fas fa-plus-circle"></i> Tambah Menu Baru';
});
</script>

</body>
</html>