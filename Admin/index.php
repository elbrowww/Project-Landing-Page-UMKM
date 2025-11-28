<?php
session_start();
if (!isset($_SESSION['login'])) {
  header("Location: login.php");
  exit();
}

error_reporting(E_ALL);
ini_set('display_errors', 1);
include '../config/koneksi.php';

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

// Query total bahan
$query_total_bahan = "SELECT COUNT(*) as total_bahan FROM bahan";
$result_total_bahan = $koneksi->query($query_total_bahan);
$total_bahan = $result_total_bahan->fetch_assoc()['total_bahan'];

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

// Query menu terlaris dengan gambar
$query_terlaris = "
  SELECT d.nama_menu, SUM(d.jumlah) as total_terjual, m.gambar
  FROM detail_penjualan d
  LEFT JOIN menu m ON d.id_menu = m.id_menu
  GROUP BY d.nama_menu, m.gambar
  ORDER BY total_terjual DESC
  LIMIT 10
";
$result_terlaris = $koneksi->query($query_terlaris);
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard | Bu Mon Admin</title>
  <link rel="icon" href="../asset/img/logo.png" type="image/x-icon">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../asset/css/dashboard.css">
  
  
</head>

<body>
  <?php include 'navbar.php'; ?>

  <div class="container">
    <!-- Header -->
    <div class="dashboard-header">
      <h2><i class="fas fa-chart-line me-2"></i>Dashboard</h2>
      <p>Selamat datang di dashboard Bu Mon Admin</p>
    </div>

    <!-- Statistics Cards -->
    <div class="row g-4 mb-4">
      <div class="col-lg-3 col-md-6">
        <div class="stats-card">
          <div class="stats-card-header">
            <div class="stats-icon" style="background: linear-gradient(135deg, #6366f1, #8b5cf6);">
              <i class="fas fa-shopping-cart"></i>
            </div>
          </div>
          <div class="stats-value"><?= number_format($stats_dashboard['total_pesanan'] ?? 0) ?></div>
          <div class="stats-label">Total Pesanan</div>
        </div>
      </div>

      <div class="col-lg-3 col-md-6">
        <div class="stats-card">
          <div class="stats-card-header">
            <div class="stats-icon" style="background: linear-gradient(135deg, #10b981, #059669);">
              <i class="fas fa-utensils"></i>
            </div>
          </div>
          <div class="stats-value"><?= number_format($stats_dashboard['total_terjual'] ?? 0) ?></div>
          <div class="stats-label">Total Terjual</div>
        </div>
      </div>

      <div class="col-lg-3 col-md-6">
        <div class="stats-card">
          <div class="stats-card-header">
            <div class="stats-icon" style="background: linear-gradient(135deg, #06b6d4, #0891b2);">
              <i class="fas fa-money-bill-wave"></i>
            </div>
          </div>
          <div class="stats-value">Rp <?= number_format($stats_dashboard['total_pendapatan'] ?? 0, 0, ',', '.') ?></div>
          <div class="stats-label">Total Pendapatan</div>
        </div>
      </div>

      <div class="col-lg-3 col-md-6">
        <div class="stats-card">
          <div class="stats-card-header">
            <div class="stats-icon" style="background: linear-gradient(135deg, #f59e0b, #d97706);">
              <i class="fas fa-box"></i>
            </div>
          </div>
          <div class="stats-value"><?= number_format($total_bahan ?? 0) ?></div>
          <div class="stats-label">Total Bahan</div>
        </div>
      </div>
    </div>

    <!-- Tracking Status Pesanan -->
    <div class="status-section">
      <div class="section-title">
        <i class="fas fa-tasks"></i>
        Tracking Status Pesanan
      </div>
      <div class="status-grid">
        <div class="status-card pending">
          <div class="status-number"><?= $status_tracking['pending'] ?? 0 ?></div>
          <div class="status-label">Pending</div>
        </div>
        <div class="status-card proses">
          <div class="status-number"><?= $status_tracking['proses'] ?? 0 ?></div>
          <div class="status-label">Proses</div>
        </div>
        <div class="status-card selesai">
          <div class="status-number"><?= $status_tracking['selesai'] ?? 0 ?></div>
          <div class="status-label">Selesai</div>
        </div>
        <div class="status-card batal">
          <div class="status-number"><?= $status_tracking['batal'] ?? 0 ?></div>
          <div class="status-label">Batal</div>
        </div>
      </div>
    </div>

    <!-- Menu Terlaris Slider -->
    <div class="menu-section">
      <div class="section-title">
        <i class="fas fa-fire"></i>
        Menu Terlaris
      </div>
      
      <?php if ($result_terlaris && $result_terlaris->num_rows > 0): ?>
        <div class="slider-container">
          <button class="slider-btn prev" onclick="slideMenu('prev')">
            <i class="fas fa-chevron-left"></i>
          </button>
          
          <div class="slider-wrapper" id="menuSlider">
            <?php while ($row = $result_terlaris->fetch_assoc()): ?>
              <div class="menu-card">
                <div class="menu-image-wrapper">
                  <?php if ($row['gambar'] && file_exists("../asset/uploads/" . $row['gambar'])): ?>
                    <img src="../asset/uploads/<?= htmlspecialchars($row['gambar']) ?>" 
                         alt="<?= htmlspecialchars($row['nama_menu']) ?>">
                  <?php else: ?>
                    <i class="fas fa-utensils no-image"></i>
                  <?php endif; ?>
                </div>
                <div class="menu-info">
                  <h5 title="<?= htmlspecialchars($row['nama_menu']) ?>">
                    <?= htmlspecialchars($row['nama_menu']) ?>
                  </h5>
                  <div class="menu-sales">
                    <span class="menu-sales-label">Terjual</span>
                    <span class="menu-sales-value"><?= number_format($row['total_terjual']) ?></span>
                  </div>
                </div>
              </div>
            <?php endwhile; ?>
          </div>
          
          <button class="slider-btn next" onclick="slideMenu('next')">
            <i class="fas fa-chevron-right"></i>
          </button>
        </div>
      <?php else: ?>
        <div class="no-data">
          <i class="fas fa-inbox"></i>
          <p>Belum ada data menu terlaris</p>
        </div>
      <?php endif; ?>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  
  <script>
    let currentSlide = 0;
    const slider = document.getElementById('menuSlider');
    const cards = slider?.querySelectorAll('.menu-card');
    const totalCards = cards?.length || 0;
    
    // Menentukan jumlah card yang terlihat berdasarkan lebar layar
    function getVisibleCards() {
      const width = window.innerWidth;
      if (width >= 1200) return 4;
      if (width >= 992) return 3;
      if (width >= 768) return 2;
      return 1;
    }
    
    function slideMenu(direction) {
      if (!slider || totalCards === 0) return;
      
      const visibleCards = getVisibleCards();
      const maxSlide = Math.max(0, totalCards - visibleCards);
      
      if (direction === 'next' && currentSlide < maxSlide) {
        currentSlide++;
      } else if (direction === 'prev' && currentSlide > 0) {
        currentSlide--;
      }
      
      const cardWidth = cards[0].offsetWidth;
      const gap = 20;
      const offset = currentSlide * (cardWidth + gap);
      
      slider.style.transform = `translateX(-${offset}px)`;
      updateButtons();
    }
    
    function updateButtons() {
      const visibleCards = getVisibleCards();
      const maxSlide = Math.max(0, totalCards - visibleCards);
      
      const prevBtn = document.querySelector('.slider-btn.prev');
      const nextBtn = document.querySelector('.slider-btn.next');
      
      if (prevBtn) prevBtn.disabled = currentSlide === 0;
      if (nextBtn) nextBtn.disabled = currentSlide >= maxSlide;
    }
    
    // Reset slide saat resize
    window.addEventListener('resize', () => {
      currentSlide = 0;
      if (slider) slider.style.transform = 'translateX(0)';
      updateButtons();
    });
    
    // Initialize
    updateButtons();
  </script>
</body>
</html>