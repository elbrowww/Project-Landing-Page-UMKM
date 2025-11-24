<?php
session_start();
if (!isset($_SESSION['login'])) {
  header("Location: login.php");
  exit();
}

error_reporting(E_ALL);
ini_set('display_errors', 1);
include '../config/koneksi.php';


// Handler untuk hapus testimoni
if (isset($_GET['hapus_testimoni'])) {
  $id_testimoni = $_GET['hapus_testimoni'];
  
  $query_hapus = "DELETE FROM testimoni WHERE id_testimoni = ?";
  $stmt_hapus = $koneksi->prepare($query_hapus);
  $stmt_hapus->bind_param("i", $id_testimoni);
  
  if ($stmt_hapus->execute()) {
    echo "<script>alert('Testimoni berhasil dihapus!'); window.location.href='testimoni.php?page=testimoni';</script>";
  } else {
    echo "<script>alert('Gagal menghapus testimoni!'); window.location.href='testimoni.php?page=testimoni';</script>";
  }
  exit();
}

// Query untuk testimoni
$query_testimoni = "SELECT * FROM testimoni ORDER BY created_at DESC";
$result_testimoni = $koneksi->query($query_testimoni);
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

<!-- HALAMAN TESTIMONI -->
<div id="page-testimoni" class="page-content">
  <div class="container">
    
  <div class="page-header d-flex justify-content-between align-items-center mb-3">
    <h3><i class="fas fa-star"></i> Kelola Testimoni</h3>

  <button class="btn btn-primary" id="btnTambahTestimoni">
    <i class="fas fa-plus"></i> Tambah Testimoni
  </button>
</div>


    <div class="row">
      <?php 
      if ($result_testimoni && $result_testimoni->num_rows > 0):
        while ($row_testi = $result_testimoni->fetch_assoc()):
      ?>
      <div class="col-md-6 mb-3">
        <div class="testimoni-card">
          <div class="d-flex justify-content-between align-items-start mb-2">
            <div>
              <h5 class="mb-1"><?= htmlspecialchars($row_testi['nama']) ?></h5>
              <div class="rating-stars">
                <?php for($i = 1; $i <= 5; $i++): ?>
                  
                <?php endfor; ?>
              </div>
            </div>
  
          </div>
          
          <p class="mb-2"><?= htmlspecialchars($row_testi['pesan']) ?></p>
          
          <div class="text-muted small mb-3">
            <i class="fas fa-clock"></i> <?= date('d/m/Y H:i', strtotime($row_testi['created_at'])) ?>
          </div>
          
          <div class="d-flex gap-2">
            <a href="?hapus_testimoni=<?= $row_testi['id_testimoni'] ?>" 
               onclick="return confirm('Hapus testimoni dari <?= htmlspecialchars($row_testi['nama']) ?>?')"
               class="btn btn-sm btn-danger">
              <i class="fas fa-trash"></i> Hapus
            </a>
          </div>
        </div>
      </div>
      <?php endwhile; else: ?>
        <div class="col-12">
          <div class="no-data">
            <i class="fas fa-inbox"></i>
            <p>Belum ada testimoni</p>
          </div>
        </div>
      <?php endif; ?>
    </div>
  </div>
</div>

<!-- MODAL TAMBAH TESTIMONI -->
<div id="modalTestimoni" class="modal fade" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">

      <form method="POST" action="../config/simpan-testimoni.php">
        <div class="modal-header">
          <h5 class="modal-title"><i class="fas fa-plus-circle"></i> Tambah Testimoni</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">
          
          <div class="mb-3">
            <label class="form-label">Nama</label>
            <input type="text" name="nama" class="form-control" required>
          </div>

          <div class="mb-3">
            <label class="form-label">No. Telepon</label>
            <input type="text" name="no_telp" class="form-control">
          </div>

          <div class="mb-3">
            <label class="form-label">Pesan</label>
            <textarea name="pesan" class="form-control" rows="3" required></textarea>
          </div>

          <input type="hidden" name="status" value="approved">

        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary">Simpan</button>
        </div>

      </form>
      </div>
      <script>
    // Tambahkan script ini di bagian bawah halaman
    document.getElementById('btnTambahTestimoni').addEventListener('click', function() {
      var modal = new bootstrap.Modal(document.getElementById('modalTestimoni'));
      modal.show();
    });
      </script>
    </div>
  </div>
</div>



<!-- Bootstrap & JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

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
}

function showDeletePopup(id, nama) {
  document.getElementById('popupText').innerHTML =
    "Yakin ingin menghapus menu <b>" + nama + "</b>?";

  document.getElementById('deleteLink').href = "?hapus=" + id;

  document.getElementById('popupConfirm').style.display = "flex";
}

function closePopup() {
  document.getElementById('popupConfirm').style.display = "none";
}

// Cek URL parameter untuk navigasi
window.addEventListener('DOMContentLoaded', function() {
  const urlParams = new URLSearchParams(window.location.search);
  const page = urlParams.get('page');
  if (page) {
    showPage(page);
  }
});
</script>

</body>
</html>