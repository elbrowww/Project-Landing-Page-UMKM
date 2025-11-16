
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



</body>
</html>