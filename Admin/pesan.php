<?php
session_start();
if (!isset($_SESSION['login'])) {
  header("Location: login.php");
  exit();
}

error_reporting(E_ALL);
ini_set('display_errors', 1);
include '../config/koneksi.php';

// Handler untuk update status pesan
if (isset($_POST['update_status'])) {
  $id_pesan = $_POST['id_pesan'];
  $status = $_POST['status'];
  
  $query_update = "UPDATE pesan SET status=? WHERE id_pesan=?";
  $stmt = $koneksi->prepare($query_update);
  $stmt->bind_param("si", $status, $id_pesan);
  
  if ($stmt->execute()) {
    echo "<script>alert('Status berhasil diupdate!'); window.location.href='pesan.php';</script>";
  } else {
    echo "<script>alert('Gagal update status!'); window.location.href='pesan.php';</script>";
  }
  exit();
}

// Handler untuk hapus pesan
if (isset($_GET['hapus'])) {
  $id_pesan = $_GET['hapus'];
  
  $query_hapus = "DELETE FROM pesan WHERE id_pesan = ?";
  $stmt = $koneksi->prepare($query_hapus);
  $stmt->bind_param("i", $id_pesan);
  
  if ($stmt->execute()) {
    echo "<script>alert('Pesan berhasil dihapus!'); window.location.href='pesan.php';</script>";
  } else {
    echo "<script>alert('Gagal menghapus pesan!'); window.location.href='pesan.php';</script>";
  }
  exit();
}

// Query untuk mengambil semua pesan
$query = "SELECT * FROM pesan ORDER BY tanggal_kirim DESC";
$result = mysqli_query($koneksi, $query);

// Hitung jumlah pesan baru
$count_baru = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM pesan WHERE status='baru'"));
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Kelola Pesan | Bu Mon</title>
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

<!-- HALAMAN PESAN PELANGGAN -->
<div class="page-content">
  <div class="container">
    <div class="page-header d-flex justify-content-between align-items-center">
      <h3><i class="fas fa-envelope"></i> Pesan Pelanggan</h3>
      <?php if ($count_baru > 0): ?>
      <span class="badge bg-danger fs-6">
        <i class="fas fa-bell"></i> <?= $count_baru ?> Pesan Baru
      </span>
      <?php endif; ?>
    </div>

    <!-- Tabel Pesan -->
    <div class="card">
      <div class="card-body p-0">
        <div class="table-responsive">
          <table class="table mb-0">
            <thead>
              <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Email</th>
                <th>No. Telp</th>
                <th>Pesan</th>
                <th>Tanggal</th>
                <th>Status</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody id="pesanTable">
              <?php 
              $no = 1;
              if ($result && $result->num_rows > 0):
                while ($row = $result->fetch_assoc()):
                  $status_class = [
                    'baru' => 'status-pending',
                    'dibaca' => 'status-proses',
                    'diproses' => 'status-selesai'
                  ];
                  $class = $status_class[$row['status']] ?? 'status-pending';
              ?>
              <tr class="pesan-row" data-status="<?= $row['status'] ?>">
                <td><?= $no++ ?></td>
                <td><strong><?= htmlspecialchars($row['nama_pelanggan']) ?></strong></td>
                <td><?= htmlspecialchars($row['email_pelanggan']) ?></td>
                <td><?= htmlspecialchars($row['notelp_pelanggan']) ?></td>
                <td>
                  <div class="text-truncate" style="max-width: 200px;">
                    <?= htmlspecialchars(substr($row['isi_pesan'], 0, 50)) ?>...
                  </div>
                </td>
                <td><?= date('d/m/Y H:i', strtotime($row['tanggal_kirim'])) ?></td>
                <td>
                  <span class="status-badge <?= $class ?>">
                    <?= ucfirst($row['status']) ?>
                  </span>
                </td>
                <td>
                  <button class="btn btn-action btn-info" 
                          onclick="lihatDetail(<?= htmlspecialchars(json_encode($row)) ?>)">
                    <i class="fas fa-eye"></i>
                  </button>
                  <button class="btn btn-action btn-edit" 
                          onclick="updateStatus(<?= $row['id_pesan'] ?>, '<?= $row['status'] ?>')">
                    <i class="fas fa-edit"></i>
                  </button>
                  <a href="javascript:void(0)" 
                     onclick="showDeletePopup(<?= $row['id_pesan'] ?>, '<?= addslashes($row['nama_pelanggan']) ?>')" 
                     class="btn btn-action btn-delete">
                    <i class="fas fa-trash-alt"></i>
                  </a>
                </td>
              </tr>
              <?php endwhile; else: ?>
                <tr>
                  <td colspan="8" class="no-data">
                    <i class="fas fa-inbox"></i>
                    <p>Belum ada pesan</p>
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

<!-- Modal Detail Pesan -->
<div class="modal fade" id="detailPesanModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5><i class="fas fa-envelope-open"></i> Detail Pesan</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body p-4" id="detailContent">
        <!-- Content will be loaded here -->
      </div>
    </div>
  </div>
</div>

<!-- Modal Update Status -->
<div class="modal fade" id="updateStatusModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5><i class="fas fa-edit"></i> Update Status Pesan</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body p-4">
        <form method="POST">
          <input type="hidden" name="id_pesan" id="status_id_pesan">
          <div class="mb-3">
            <label class="form-label">Status Pesan</label>
            <select class="form-select" name="status" id="status_pesan" required>
              <option value="baru">Baru</option>
              <option value="dibaca">Sudah Dibaca</option>
              <option value="diproses">Diproses</option>
            </select>
          </div>
          <button type="submit" name="update_status" class="btn btn-submit">
            <i class="fas fa-save"></i> Update Status
          </button>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Bootstrap & JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
// Filter pesan berdasarkan status
function filterPesan(status) {
  const rows = document.querySelectorAll('.pesan-row');
  const buttons = document.querySelectorAll('.btn-group button');
  
  // Update active button
  buttons.forEach(btn => {
    btn.classList.remove('active');
  });
  event.target.classList.add('active');

}

// Lihat detail pesan
function lihatDetail(data) {
  const telp = data.notelp_pelanggan.replace(/[^0-9]/g, '');
  
  document.getElementById('detailContent').innerHTML = `
    <div class="row mb-3">
      <div class="col-md-6">
        <div class="card bg-light">
          <div class="card-body">
            <small class="text-muted">ID Pesan</small>
            <h6 class="mb-0">#${data.id_pesan}</h6>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="card bg-light">
          <div class="card-body">
            <small class="text-muted">Tanggal</small>
            <h6 class="mb-0">${new Date(data.tanggal_kirim).toLocaleString('id-ID')}</h6>
          </div>
        </div>
      </div>
    </div>
    
    <div class="card bg-light mb-3">
      <div class="card-body">
        <small class="text-muted">Nama Pelanggan</small>
        <h6>${data.nama_pelanggan}</h6>
      </div>
    </div>
    
    <div class="row mb-3">
      <div class="col-md-6">
        <div class="card bg-light">
          <div class="card-body">
            <small class="text-muted">Email</small>
            <h6 class="mb-0 small">${data.email_pelanggan}</h6>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="card bg-light">
          <div class="card-body">
            <small class="text-muted">No. Telepon</small>
            <h6 class="mb-0">${data.notelp_pelanggan}</h6>
          </div>
        </div>
      </div>
    </div>
    
    <div class="card bg-light mb-3">
      <div class="card-body">
        <small class="text-muted">Isi Pesan</small>
        <p class="mb-0 mt-2">${data.isi_pesan}</p>
      </div>
    </div>
    
    <div class="d-flex gap-2">
      <a href="https://wa.me/${telp}" target="_blank" class="btn btn-success flex-fill">
        <i class="fab fa-whatsapp"></i> Balas via WhatsApp
      </a>
      <a href="mailto:${data.email_pelanggan}" class="btn btn-primary flex-fill">
        <i class="fas fa-envelope"></i> Balas via Email
      </a>
    </div>
  `;
  
  var modal = new bootstrap.Modal(document.getElementById('detailPesanModal'));
  modal.show();
  
  // Auto update status jika masih baru
  if (data.status === 'baru') {
    updateStatusAuto(data.id_pesan, 'dibaca');
  }
}

// Update status otomatis
function updateStatusAuto(id, status) {
  const formData = new FormData();
  formData.append('id_pesan', id);
  formData.append('status', status);
  formData.append('update_status', true);
  
  fetch('', {
    method: 'POST',
    body: formData
  });
}

// Update status manual
function updateStatus(id, current_status) {
  document.getElementById('status_id_pesan').value = id;
  document.getElementById('status_pesan').value = current_status;
  
  var modal = new bootstrap.Modal(document.getElementById('updateStatusModal'));
  modal.show();
}

// Show delete popup
function showDeletePopup(id, nama) {
  document.getElementById('popupText').innerHTML = 
    "Yakin ingin menghapus pesan dari <b>" + nama + "</b>?";
  document.getElementById('deleteLink').href = "?hapus=" + id;
  document.getElementById('popupConfirm').style.display = "flex";
}

// Close popup
function closePopup() {
  document.getElementById('popupConfirm').style.display = "none";
}
</script>

</body>
</html>