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

// Query statistik untuk dashboard
$query_stats_dashboard = "
  SELECT 
    SUM(jumlah) as total_terjual,
    SUM(subtotal) as total_pendapatan,
    COUNT(*) as total_pesanan
  FROM detail_penjualan
";
$result_stats_dashboard = $koneksi->query($query_stats_dashboard);
$stats_dashboard = $result_stats_dashboard->fetch_assoc();

// Query total bahan (jika tabel bahan ada)
$query_total_bahan = "SELECT COUNT(*) as total_bahan FROM bahan";
$result_total_bahan = $koneksi->query($query_total_bahan);
$total_bahan = $result_total_bahan->fetch_assoc()['total_bahan'];

// Query pendapatan bulanan (untuk grafik, ambil 6 bulan terakhir)
$query_pendapatan_bulanan = "
  SELECT 
    DATE_FORMAT(tgl_pesan, '%Y-%m') as bulan,
    SUM(subtotal) as pendapatan
  FROM detail_penjualan
  WHERE tgl_pesan >= DATE_SUB(CURDATE(), INTERVAL 6 MONTH)
  GROUP BY bulan
  ORDER BY bulan ASC
";
$result_pendapatan_bulanan = $koneksi->query($query_pendapatan_bulanan);
$pendapatan_bulanan = [];
while ($row = $result_pendapatan_bulanan->fetch_assoc()) {
  $pendapatan_bulanan[] = $row;
}

// Query menu terlaris (top 5)
$query_terlaris = "
  SELECT nama_menu, SUM(jumlah) as total_terjual
  FROM detail_penjualan
  GROUP BY nama_menu
  ORDER BY total_terjual DESC
  LIMIT 5
";
$result_terlaris = $koneksi->query($query_terlaris);

// Query data pembeli (daftar pelanggan unik dari transaksi_penjualan)
$query_pembeli = "
  SELECT nama, telp, COUNT(*) as total_pesanan
  FROM transaksi_penjualan
  GROUP BY nama, telp
  ORDER BY total_pesanan DESC
  LIMIT 10
";
$result_pembeli = $koneksi->query($query_pembeli);

// Query tracking status pesanan
$query_status = "
  SELECT status, COUNT(*) as jumlah
  FROM transaksi_penjualan
  GROUP BY status
";
$result_status = $koneksi->query($query_status);
$status_tracking = [];
while ($row = $result_status->fetch_assoc()) {
  $status_tracking[$row['status']] = $row['jumlah'];
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard | Bu Mon Admin</title>
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

  <div class="container">
    <div class="page-header">
      <h3><i class="fas fa-chart-line"></i> Dashboard</h3>
    </div>

    <!-- Statistik Cards -->
    <div class="row mb-4">
      <div class="col-md-3 mb-3">
        <div class="stats-card">
          <div class="stats-icon bg-primary">
            <i class="fas fa-shopping-cart"></i>
          </div>
          <div class="stats-info">
            <h3><?= $stats_dashboard['total_pesanan'] ?? 0 ?></h3>
            <p>Total Pesanan</p>
          </div>
        </div>
      </div>
      <div class="col-md-3 mb-3">
        <div class="stats-card">
          <div class="stats-icon bg-success">
            <i class="fas fa-utensils"></i>
          </div>
          <div class="stats-info">
            <h3><?= $stats_dashboard['total_terjual'] ?? 0 ?></h3>
            <p>Total Terjual</p>
          </div>
        </div>
      </div>
      <div class="col-md-3 mb-3">
        <div class="stats-card">
          <div class="stats-icon bg-info">
            <i class="fas fa-money-bill-wave"></i>
          </div>
          <div class="stats-info">
            <h3>Rp <?= number_format($stats_dashboard['total_pendapatan'] ?? 0, 0, ',', '.') ?></h3>
            <p>Total Pendapatan</p>
          </div>
        </div>
      </div>
      <div class="col-md-3 mb-3">
        <div class="stats-card">
          <div class="stats-icon bg-warning">
            <i class="fas fa-box"></i>
          </div>
          <div class="stats-info">
            <h3><?= $total_bahan ?? 0 ?></h3>
            <p>Total Bahan</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Tracking Status Pesanan -->
    <div class="row mb-4">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h5><i class="fas fa-tasks"></i> Tracking Status Pesanan</h5>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-md-3">
                <div class="status-card bg-secondary">
                  <h4><?= $status_tracking['pending'] ?? 0 ?></h4>
                  <p>Pending</p>
                </div>
              </div>
              <div class="col-md-3">
                <div class="status-card bg-warning">
                  <h4><?= $status_tracking['proses'] ?? 0 ?></h4>
                  <p>Proses</p>
                </div>
              </div>
              <div class="col-md-3">
                <div class="status-card bg-success">
                  <h4><?= $status_tracking['selesai'] ?? 0 ?></h4>
                  <p>Selesai</p>
                </div>
              </div>
              <div class="col-md-3">
                <div class="status-card bg-danger">
                  <h4><?= $status_tracking['batal'] ?? 0 ?></h4>
                  <p>Batal</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>


    <!-- Menu Terlaris dan Data Pembeli -->
    <div class="row">
      <div class="col-md-6">
        <div class="card">
          <div class="card-header">
            <h5><i class="fas fa-star"></i> Menu Terlaris</h5>
          </div>
          <div class="card-body p-0">
            <div class="table-responsive">
              <table class="table mb-0">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Nama Menu</th>
                    <th>Jumlah Terjual</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $no = 1;
                  if ($result_terlaris && $result_terlaris->num_rows > 0):
                    while ($row = $result_terlaris->fetch_assoc()):
                  ?>
                  <tr>
                    <td><?= $no++ ?></td>
                    <td><strong><?= htmlspecialchars($row['nama_menu']) ?></strong></td>
                    <td><span class="badge-qty"><?= htmlspecialchars($row['total_terjual']) ?></span></td>
                  </tr>
                  <?php endwhile; else: ?>
                  <tr><td colspan="3" class="no-data"><i class="fas fa-inbox"></i><p>Belum ada data</p></td></tr>
                  <?php endif; ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>

  <!-- Bootstrap & JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <!-- Chart.js -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</body>
</html>