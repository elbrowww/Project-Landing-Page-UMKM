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


// Query data pembeli (daftar pelanggan unik dari transaksi_penjualan)
$query_pembeli = "
  SELECT nama, telp, alamat, COUNT(*) as total_pesanan
  FROM transaksi_penjualan
  GROUP BY nama, telp
  ORDER BY tgl_pesan ASC
";
$result_pembeli = $koneksi->query($query_pembeli);
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

<div id="page-pelanggan" class="page-content">
      <div class="container">
        <div class="card">
          <div class="card-header">
            <h5><i class="fas fa-users"></i> Data Pembeli</h5>
          </div>
          <div class="card-body p-0">
            <div class="table-responsive">
              <table class="table mb-0">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>No. HP</th>
                    <th>Alamat</th>
                    <th>Total Pesanan</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $no = 1;
                  if ($result_pembeli && $result_pembeli->num_rows > 0):
                    while ($row = $result_pembeli->fetch_assoc()):
                  ?>
                  <tr>
                    <td><?= $no++ ?></td>
                    <td><strong><?= htmlspecialchars($row['nama']) ?></strong></td>
                    <td><?= htmlspecialchars($row['telp']) ?></td>
                    <td><?= htmlspecialchars($row['alamat']) ?></td>
                    <td><span class="badge-qty"><?= htmlspecialchars($row['total_pesanan']) ?></span></td>
                  </tr>
                  <?php endwhile; else: ?>
                  <tr><td colspan="4" class="no-data"><i class="fas fa-inbox"></i><p>Belum ada data</p></td></tr>
                  <?php endif; ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap & JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <!-- Chart.js -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script>
    // Data untuk grafik pendapatan bulanan
    const labels = [];
    const data = [];
    <?php foreach ($pendapatan_bulanan as $item): ?>
      labels.push('<?= date('M Y', strtotime($item['bulan'] . '-01')) ?>');
      data.push(<?= $item['pendapatan'] ?>);
    <?php endforeach; ?>

    const ctx = document.getElementById('pendapatanChart').getContext('2d');
    const pendapatanChart = new Chart(ctx, {
      type: 'bar',
      data: {
        labels: labels,
        datasets: [{
          label: 'Pendapatan (Rp)',
          data: data,
          backgroundColor: 'rgba(54, 162, 235, 0.5)',
          borderColor: 'rgba(54, 162, 235, 1)',
          borderWidth: 1
        }]
      },
      options: {
        responsive: true,
        scales: {
          y: {
            beginAtZero: true,
            ticks: {
              callback: function(value) {
                return 'Rp ' + value.toLocaleString('id-ID');
              }
            }
          }
        }
      }
    });
  </script>
</body>
</html>