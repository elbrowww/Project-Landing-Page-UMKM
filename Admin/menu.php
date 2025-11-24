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
<?php include 'navbar.php'; ?>

<!-- POPUP DELETE -->
<div id="popupConfirm" class="popup-overlay">
  <div class="popup-box">
    <h4>Konfirmasi Hapus</h4>
    <p id="popupText"></p>

    <div class="popup-btns">
      <button class="btn btn-secondary" onclick="closePopup()">Batal</button>
      <a id="deleteLink" class="btn btn-danger">Hapus</a>
    </div>
  </div>
</div>

<!-- HALAMAN DASHBOARD MENU -->
<div id="page-menu" class="page-content">
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
                  <a href="javascript:void(0)" 
   onclick="showDeletePopup('<?= $row['id_menu'] ?>', '<?= addslashes($row['nama_menu']) ?>')" 
   class="btn btn-action btn-delete">
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
   
  // Tampilkan halaman yang dipilih
  document.getElementById('page-' + pageName).style.display = 'block';
  
  // Tambah class active ke nav-link yang dipilih
  document.getElementById('nav-' + pageName).classList.add('active');

   // Hapus class active dari semua nav-link
  document.querySelectorAll('.nav-link').forEach(link => {
    link.classList.remove('active');
  });
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

// Reset form saat modal ditutup
document.getElementById('tambahMenuModal').addEventListener('hidden.bs.modal', function () {
  document.getElementById('menuForm').reset();
  document.getElementById('id_menu').value = '';
  document.getElementById('currentImage').style.display = 'none';
  document.getElementById('modalTitle').innerHTML = '<i class="fas fa-plus-circle"></i> Tambah Menu Baru';
});

function showDeletePopup(id, nama) {
  document.getElementById('popupText').innerHTML =
    "Yakin ingin menghapus menu <b>" + nama + "</b>?";

  document.getElementById('deleteLink').href = "?hapus=" + id;

  document.getElementById('popupConfirm').style.display = "flex";
}

function closePopup() {
  document.getElementById('popupConfirm').style.display = "none";
}



</script>

</body>
</html>