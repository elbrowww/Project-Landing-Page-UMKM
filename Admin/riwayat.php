<?php
session_start();
if (!isset($_SESSION['login'])) {
  header("Location: login.php");
  exit();
}

error_reporting(E_ALL);
ini_set('display_errors', 1);
include '../config/koneksi.php';

// Handler untuk hapus pesanan
if (isset($_GET['hapus_pesanan'])) {
  $id_detail = $_GET['hapus_pesanan'];
  
  $query_hapus_pesanan = "DELETE FROM detail_penjualan WHERE id_detail = ?";
  $stmt_hapus_pesanan = $koneksi->prepare($query_hapus_pesanan);
  $stmt_hapus_pesanan->bind_param("s", $id_detail);
  
  if ($stmt_hapus_pesanan->execute()) {
    echo "<script>alert('Pesanan berhasil dihapus!'); window.location.href='riwayat.php';</script>";
  } else {
    echo "<script>alert('Gagal menghapus pesanan!'); window.location.href='riwayat.php';</script>";
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
    echo "<script>alert('Pesanan berhasil diupdate!'); window.location.href='riwayat.php';</script>";
  } else {
    echo "<script>alert('Gagal mengupdate pesanan!'); window.location.href='riwayat.php';</script>";
  }
  exit();
}


// Handler untuk update status pesanan dengan VALIDASI
if (isset($_POST['update_status_pesanan'])) {
  $id_pesanan = $_POST['id_pesanan'];
  $status_baru = $_POST['status'];
  
  // Ambil status saat ini dari database
  $query_cek_status = "SELECT status FROM transaksi_penjualan WHERE id_pesanan = ?";
  $stmt_cek = $koneksi->prepare($query_cek_status);
  $stmt_cek->bind_param("s", $id_pesanan);
  $stmt_cek->execute();
  $result_cek = $stmt_cek->get_result();
  $data_cek = $result_cek->fetch_assoc();
  $status_sekarang = $data_cek['status'];
  
  // VALIDASI STATUS
  $allowed = false;
  $error_message = '';
  
  // Jika status sekarang adalah SELESAI atau BATAL, tidak boleh diubah
  if ($status_sekarang === 'selesai') {
    $error_message = 'Pesanan yang sudah SELESAI tidak dapat diubah statusnya!';
  } elseif ($status_sekarang === 'batal') {
    $error_message = 'Pesanan yang sudah DIBATALKAN tidak dapat diubah statusnya!';
  } 
  // Jika status sekarang adalah PROSES, hanya boleh diubah ke SELESAI atau BATAL
  elseif ($status_sekarang === 'proses') {
    if ($status_baru === 'selesai' || $status_baru === 'batal') {
      $allowed = true;
    } else {
      $error_message = 'Status PROSES hanya dapat diubah ke SELESAI atau BATAL!';
    }
  }
  // Jika status sekarang adalah PENDING, boleh diubah ke semua status
  elseif ($status_sekarang === 'pending') {
    $allowed = true;
  }
  
  // Jika validasi lolos, update status
  if ($allowed) {
    $query_update_status = "UPDATE transaksi_penjualan SET status=? WHERE id_pesanan=?";
    $stmt_update_status = $koneksi->prepare($query_update_status);
    $stmt_update_status->bind_param("ss", $status_baru, $id_pesanan);
    
    if ($stmt_update_status->execute()) {
      echo "<script>
        alert('✅ Status pesanan berhasil diupdate!');
        window.location.href='riwayat.php?page=riwayat';
      </script>";
    } else {
      echo "<script>
        alert('❌ Gagal mengupdate status!');
        window.location.href='riwayat.php?page=riwayat';
      </script>";
    }
  } else {
    // Tampilkan error jika validasi gagal
    echo "<script>
      alert('⚠️ VALIDASI GAGAL\\n\\n$error_message');
      window.location.href='riwayat.php?page=riwayat';
    </script>";
  }
  exit();
};

// Query untuk mengambil data pesanan dari detail_penjualan
$query_pesanan = "SELECT * FROM detail_penjualan ORDER BY tgl_pesan DESC";
$result_pesanan = $koneksi->query($query_pesanan);

// Query dengan JOIN ke detail_penjualan untuk mendapatkan detail menu
$query_riwayat = "
  SELECT 
    t.*,
    GROUP_CONCAT(
      CONCAT(d.nama_menu, ' (', d.jumlah, 'x)')
      ORDER BY d.id_detail
      SEPARATOR ', '
    ) as detail_menu
  FROM transaksi_penjualan t
  LEFT JOIN detail_penjualan d ON t.id_pesanan = d.id_pesanan
  GROUP BY t.id_pesanan
  ORDER BY t.tgl_pesan DESC
";
$result_riwayat = $koneksi->query($query_riwayat);

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

<!-- HALAMAN RIWAYAT PESANAN -->
<div id="page-riwayat" class="page-content" style="display:none;">
  <div class="container">
    <div class="page-header">
      <h3><i class="fas fa-history"></i> Riwayat Pesanan</h3>
    </div>

    <div class="card">
  <div class="card-body p-0">
    <div class="table-responsive">
      <table class="table mb-0">
        <thead>
          <tr>
            <th>No</th>
            <th>ID Pesanan</th>
            <th>Tanggal</th>
            <th>Nama Pelanggan</th>
            <th>No. HP</th>
            <th>Alamat</th>
            <th>Detail Menu</th>
            <th>Total Bayar</th>
            <th>Status</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php 
          $no = 1;
          if ($result_riwayat && $result_riwayat->num_rows > 0):
            while ($row_riwayat = $result_riwayat->fetch_assoc()):
              $status_class = 'status-' . strtolower($row_riwayat['status']);
          ?>
          <tr>
            <td><?= $no++ ?></td>
            <td><strong><?= htmlspecialchars($row_riwayat['id_pesanan']) ?></strong></td>
            <td><?= date('d/m/Y H:i', strtotime($row_riwayat['tgl_pesan'])) ?></td>
            <td><?= htmlspecialchars($row_riwayat['nama']) ?></td>
            <td><?= htmlspecialchars($row_riwayat['telp']) ?></td>
            <td><?= htmlspecialchars($row_riwayat['alamat']) ?></td>
            <td>
              <small><?= htmlspecialchars($row_riwayat['detail_menu'] ?? 'Tidak ada menu') ?></small>
            </td>
            <td>
              <span class="badge-price">
                Rp <?= number_format($row_riwayat['total'], 0, ',', '.') ?>
              </span>
            </td>
            <td>
              <span class="status-badge <?= $status_class ?>">
                <?= ucfirst($row_riwayat['status']) ?>
              </span>
            </td>
            <td>
              <button class="btn btn-action btn-edit" 
                      onclick="updateStatus('<?= $row_riwayat['id_pesanan'] ?>', '<?= $row_riwayat['status'] ?>')">
                <i class="fas fa-edit"></i>
              </button>
            </td>
          </tr>
          <?php 
            endwhile;
          else:
          ?>
          <tr>
            <td colspan="10" class="text-center">Tidak ada data riwayat pesanan</td>
          </tr>
          <?php endif; ?>
        </tbody>
      </table>


<!-- Modal Update Status Pesanan -->
<div class="modal fade" id="updateStatusModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5><i class="fas fa-edit"></i> Update Status Pesanan</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body p-4">
        
        <!-- Info Box Status -->
        <div class="alert alert-info mb-3">
          <i class="fas fa-info-circle"></i> <strong>Aturan Status:</strong>
          <ul class="mb-0 mt-2" style="font-size: 0.9em;">
            <li><strong>Pending</strong> → Bisa diubah ke: Proses, Selesai, Batal</li>
            <li><strong>Proses</strong> → Bisa diubah ke: Selesai, Batal</li>
            <li><strong>Selesai</strong> → <span class="text-danger">Tidak bisa diubah lagi</span></li>
            <li><strong>Batal</strong> → <span class="text-danger">Tidak bisa diubah lagi</span></li>
          </ul>
        </div>
        
        <form method="POST" id="statusForm" onsubmit="return confirmStatusChange()">
          <input type="hidden" name="id_pesanan" id="status_id_pesanan">
          
          <div class="mb-3">
            <label class="form-label">Status Pesanan</label>
            <select class="form-select" name="status" id="status_pesanan" required>
              <option value="pending">🕐 Pending</option>
              <option value="proses">⚙️ Proses</option>
              <option value="selesai">✅ Selesai</option>
              <option value="batal">❌ Batal</option>
            </select>
          </div>
          
          <div class="alert alert-warning" id="warningSelesai" style="display:none;">
            <i class="fas fa-exclamation-triangle"></i> 
            <strong>Perhatian!</strong> Status SELESAI tidak dapat diubah lagi setelah disimpan!
          </div>
          
          <div class="alert alert-danger" id="warningBatal" style="display:none;">
            <i class="fas fa-exclamation-triangle"></i> 
            <strong>Perhatian!</strong> Status BATAL tidak dapat diubah lagi setelah disimpan!
          </div>
          
          <button type="submit" name="update_status_pesanan" class="btn btn-submit w-100">
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


// Fungsi edit pesanan
function editPesanan(id_detail, id_menu, jumlah, harga_satuan) {
  document.getElementById('edit_id_detail').value = id_detail;
  document.getElementById('edit_id_menu').value = id_menu;
  document.getElementById('edit_jumlah').value = jumlah;
  document.getElementById('edit_harga_satuan').value = harga_satuan;
  
  var modal = new bootstrap.Modal(document.getElementById('editPesananModal'));
  modal.show();
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

// Fungsi update status pesanan
// Fungsi update status pesanan dengan validasi
function updateStatus(id_pesanan, current_status) {
  document.getElementById('status_id_pesanan').value = id_pesanan;
  
  // Reset semua option dulu
  const statusSelect = document.getElementById('status_pesanan');
  const allOptions = statusSelect.querySelectorAll('option');
  allOptions.forEach(opt => {
    opt.disabled = false;
    opt.style.display = 'block';
  });
  
  // Validasi berdasarkan status saat ini
  if (current_status === 'selesai') {
    // Jika sudah selesai, tidak bisa diubah ke status lain
    alert('⚠️ Pesanan yang sudah SELESAI tidak dapat diubah statusnya!');
    return; // Jangan buka modal
  }
  
  if (current_status === 'batal') {
    // Jika sudah dibatalkan, tidak bisa diubah
    alert('⚠️ Pesanan yang sudah DIBATALKAN tidak dapat diubah statusnya!');
    return;
  }
  
  if (current_status === 'proses') {
    // Jika dalam proses, hanya bisa jadi selesai atau batal
    // Disable option pending dan proses
    statusSelect.querySelector('option[value="pending"]').disabled = true;
    statusSelect.querySelector('option[value="pending"]').style.display = 'none';
    statusSelect.querySelector('option[value="proses"]').disabled = true;
    statusSelect.querySelector('option[value="proses"]').style.display = 'none';
  }
  
  if (current_status === 'pending') {
    // Jika pending, bisa diubah ke semua status
    // Tidak ada pembatasan
  }
  
  // Set nilai default ke status saat ini
  statusSelect.value = current_status;
  
  // Buka modal
  var modal = new bootstrap.Modal(document.getElementById('updateStatusModal'));
  modal.show();
};

// Cek URL parameter untuk navigasi
window.addEventListener('DOMContentLoaded', function() {
  const urlParams = new URLSearchParams(window.location.search);
  const page = urlParams.get('page');
  if (page) {
    showPage(page);
  }
});

// Tampilkan warning saat pilih status selesai atau batal
document.getElementById('status_pesanan').addEventListener('change', function() {
  const warningSelesai = document.getElementById('warningSelesai');
  const warningBatal = document.getElementById('warningBatal');
  
  // Sembunyikan semua warning dulu
  warningSelesai.style.display = 'none';
  warningBatal.style.display = 'none';
  
  // Tampilkan warning sesuai pilihan
  if (this.value === 'selesai') {
    warningSelesai.style.display = 'block';
  } else if (this.value === 'batal') {
    warningBatal.style.display = 'block';
  }
});

// Konfirmasi sebelum submit
function confirmStatusChange() {
  const status = document.getElementById('status_pesanan').value;
  
  if (status === 'selesai') {
    return confirm('⚠️ KONFIRMASI\n\nAnda yakin ingin mengubah status menjadi SELESAI?\n\nStatus ini TIDAK DAPAT diubah lagi setelah disimpan!');
  }
  
  if (status === 'batal') {
    return confirm('⚠️ KONFIRMASI\n\nAnda yakin ingin MEMBATALKAN pesanan ini?\n\nStatus ini TIDAK DAPAT diubah lagi setelah disimpan!');
  }
  
  return true;
}
</script>

</body>
</html>