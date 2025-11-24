<!-- navbar.php -->
<?php

include '../config/koneksi.php';

// Ambil parameter page dari URL untuk menandai menu aktif
$page = isset($_GET['page']) ? $_GET['page'] : 'dashboard';
?>

<nav class="navbar navbar-expand-lg navbar-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="dashboard.php?page=dashboard">
      <i class="fas fa-utensils"></i> Bu Mon Admin
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav me-auto">
        <li class="nav-item">
          <a class="nav-link <?php echo ($page == 'dashboard') ? 'active' : ''; ?>" href="dashboard.php?page=dashboard">
            <i class="fa fa-bar-chart"></i> Dashboard
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?php echo ($page == 'menu') ? 'active' : ''; ?>" href="index.php?page=menu">
            <i class="fas fa-hamburger"></i> Kelola Menu
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?php echo ($page == 'riwayat') ? 'active' : ''; ?>" href="index.php?page=riwayat">
            <i class="fas fa-history"></i> Riwayat Pesanan
          </a>
        </li>
            <li class="nav-item">
          <a class="nav-link <?php echo ($page == 'bahan') ? 'active' : ''; ?>" href="bahan.php?page=bahan">
            <i class="fas fa-box"></i> Kelola Bahan
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?php echo ($page == 'pesan') ? 'active' : ''; ?>" href="pesan.php?page=pesan">
            <i class="fas fa-envelope-open"></i> Pesan
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?php echo ($page == 'testimoni') ? 'active' : ''; ?>" href="index.php?page=testimoni">
            <i class="fas fa-star"></i> Testimoni
          </a>
        </li>
      </ul>
      <ul class="navbar-nav">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
            <i class="fas fa-user-circle"></i> Admin
          </a>
          <ul class="dropdown-menu dropdown-menu-end">
            <li><a class="dropdown-item text-danger" href="../config/logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>