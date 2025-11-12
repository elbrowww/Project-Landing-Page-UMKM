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

// ambil data menu
$query = "SELECT * FROM menu ORDER BY id_menu DESC";
$result = $koneksi->query($query);

// ambil data untuk edit
$edit = null;
if (isset($_GET['edit'])) {
  $id = $_GET['edit'];
  $edit = $koneksi->query("SELECT * FROM menu WHERE id_menu='$id'")->fetch_assoc();
}

// hapus data
if (isset($_GET['hapus'])) {
  $id = $_GET['hapus'];
  $koneksi->query("DELETE FROM menu WHERE id_menu='$id'");
  header("Location: index.php");
  exit();
}

// simpan data baru atau update
if (isset($_POST['simpan'])) {
  $nama = $_POST['nama_menu'];
  $stok = $_POST['stok_menu'];
  $harga = $_POST['harga_menu'];
  $deskripsi = $_POST['deskripsi'];
  $gambar = $_FILES['gambar']['name'];

  if ($gambar) {
    $target = "../asset/uploads/" . basename($gambar);
    move_uploaded_file($_FILES['gambar']['tmp_name'], $target);
  }

  if (!empty($_POST['id_menu'])) {
    // update
    $id = $_POST['id_menu'];
    $sql = "UPDATE menu SET nama_menu='$nama', stok_menu='$stok', harga_menu='$harga', deskripsi='$deskripsi'";
    if ($gambar) $sql .= ", gambar='$gambar'";
    $sql .= " WHERE id_menu='$id'";
  } else {
    // tambah baru
    $sql = "INSERT INTO menu (nama_menu, stok_menu, harga_menu, deskripsi, gambar) 
            VALUES ('$nama', '$stok', '$harga', '$deskripsi', '$gambar')";
  }

  if ($koneksi->query($sql)) {
    header("Location: index.php");
    exit();
  }
}
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
    <a class="navbar-brand" href="#">
      <i class="fas fa-utensils"></i> Bu Mon Admin
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav me-auto">
        <li class="nav-item"><a class="nav-link active" href="#"><i class="fas fa-chart-line"></i> Dashboard</a></li>
        <li class="nav-item"><a class="nav-link" href="#"><i class="fas fa-shopping-cart"></i> Pesanan Masuk</a></li>
        <li class="nav-item"><a class="nav-link" href="#"><i class="fas fa-comments"></i> Testimoni</a></li>
      </ul>
      <ul class="navbar-nav">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
            <i class="fas fa-user-circle"></i> Admin
          </a>
          <ul class="dropdown-menu dropdown-menu-end">
            <li><a class="dropdown-item" href="#"><i class="fas fa-user"></i> Profil</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item text-danger" href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>

<!-- Konten -->
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
                        onclick="editMenu(<?= $row['id_menu'] ?>, '<?= addslashes($row['nama_menu']) ?>', <?= $row['stok_menu'] ?>, <?= $row['harga_menu'] ?>, '<?= addslashes($row['deskripsi']) ?>', '<?= $row['gambar'] ?>')">
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

<!-- Modal -->
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
<script src="script.js"></script>

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

</body>
</html>
