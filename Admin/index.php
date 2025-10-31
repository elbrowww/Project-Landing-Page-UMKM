<?php
    session_start();

    if (!isset($_SESSION['login'])) {
        header("Location: login.php"); // arahkan ke halaman login
        exit();
    }
   
    include '../config/koneksi.php';
    include '../config/CURD.php';

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    
    <link rel="stylesheet" href="../asset/css/admin.css">

</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Dashboard Admin</h1>
            <p>Sistem Manajemen Menu Catering</p>
        </div>

        <div id="alert-container">
            <div class="alert" id="alert-box"></div>
        </div>

        <div class="stats">
            <div class="stat-card">
                <h3>Total Menu</h3>
                <div class="value"><?php echo $stats['total_menu'] ?? 0; ?></div>
            </div>
            <div class="stat-card">
                <h3>Total Terjual</h3>
                <div class="value"><?php echo $stats['total_sold'] ?? 0; ?></div>
            </div>
            <div class="stat-card">
                <h3>Total Penghasilan</h3>
                <div class="value">Rp <?php echo number_format($stats['total_revenue'] ?? 0, 0, ',', '.'); ?></div>
            </div>
            <div class="stat-card">
                <h3>Menu Terpopuler</h3>
                <div class="value" style="font-size: 20px;"><?php echo $popularMenu['name'] ?? '-'; ?></div>
            </div>
        </div>

        <div class="content">
            <div class="panel">
                <h2 id="form-title">➕ Tambah Menu Baru</h2>
                <form id="menu-form">
                    <!-- <input type="hidden" id="menu-id" name="id" value="">
                    <input type="hidden" id="action" name="action" value="add">
                    
                    <div class="form-group">
                        <label for="menu-name">Nama Menu</label>
                        <input type="text" id="menu-name" name="name" placeholder="Contoh: Nasi Goreng Special" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="menu-price">Harga (Rp)</label>
                        <input type="number" id="menu-price" name="price" placeholder="25000" required>
                    </div>
                    <div class="form-group">
                        <label for="menu-stock">Stok</label>
                        <input type="number" id="menu-stock" name="stock" placeholder="50" required>
                    </div>
                    <button type="submit" class="btn btn-primary" id="submit-btn">Tambah Menu</button>
                    <button type="button" class="btn btn-danger" id="cancel-btn" style="display: none; margin-left: 10px;" onclick="resetForm()">Batal</button> -->

                    
                    <form method="POST" enctype="multipart/form-data">

                    <div class="form-group">
                        <label for="menu-name">Nama Menu</label>
                        <input type="text" name="nama_menu" required>
                    </div>  
                    
                    <div class="form-group">
                        <label for="stok-menu">Stok:</label>
                        <input type="number" name="stok_menu" required>
                    </div>
                    
                     <div class="form-group">
                        <label for="harga-menu">Harga (Rp)</label>
                        <input type="number" name="harga_menu" required>
                    </div>
                    
                     <div class="form-group">
                        <label for="deskripsi-menu">Deskripsi:</label>
                        <textarea name="deskripsi" required></textarea>
                    </div>
                    
                     <div class="form-group">
                        <label for="gambar-menu">Gambar Menu:</label>
                        <input type="file" name="gambar" required>
                    </div>
                    
                        <button type="submit" class="btn btn-primary" id="submit-btn">Tambah Menu</button>
                        <button type="button" class="btn btn-danger" id="cancel-btn" style="display: none; margin-left: 10px;" onclick="resetForm()">Batal</button>
                  

                </form>
            </div>

            <div class="panel">
                <h2>📋 Daftar Menu</h2>
                <div class="menu-list">
                    <?php if (empty($menuItems)): ?>
                        <p style="text-align: center; color: #999;">Belum ada menu. Tambahkan menu pertama Anda!</p>
                    <?php else: ?>
                        <?php foreach ($menuItems as $menu): ?>
                            <div class="menu-item" id="menu-<?php echo $menu['id']; ?>">
                                <div class="menu-info">
                                    <h4><?php echo htmlspecialchars($menu['name']); ?></h4>
                                    <p>
                                        Kategori: <?php echo htmlspecialchars($menu['category']); ?> | 
                                        Harga: Rp <?php echo number_format($menu['price'], 0, ',', '.'); ?> | 
                                        Stok: <?php echo $menu['stock']; ?> | 
                                        Terjual: <?php echo $menu['sold']; ?>
                                    </p>
                                </div>
                                <div class="menu-actions">
                                    <button class="btn btn-success" onclick="sellMenu(<?php echo $menu['id']; ?>)">Jual</button>
                                    <button class="btn btn-edit" onclick="editMenu(<?php echo $menu['id']; ?>, '<?php echo htmlspecialchars($menu['name'], ENT_QUOTES); ?>', '<?php echo $menu['category']; ?>', <?php echo $menu['price']; ?>, <?php echo $menu['stock']; ?>)">Edit</button>
                                    <button class="btn btn-danger" onclick="deleteMenu(<?php echo $menu['id']; ?>)">Hapus</button>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>

            <div class="panel full-width">
                <div class="recommendations">
                    <h3>💡 Rekomendasi Sistem</h3>
                    <div>
                        <?php
                        $recommendations = [];
                        
                        // Low stock recommendation
                        $lowStockQuery = $pdo->query("SELECT name FROM menu WHERE stock < 10 AND stock > 0");
                        $lowStock = $lowStockQuery->fetchAll(PDO::FETCH_COLUMN);
                        if (!empty($lowStock)) {
                            $recommendations[] = "⚠️ <strong>Stok Menipis:</strong> " . implode(', ', $lowStock) . " perlu direstock segera!";
                        }
                        
                        // Not selling recommendation
                        $notSellingQuery = $pdo->query("SELECT name FROM menu WHERE sold = 0");
                        $notSelling = $notSellingQuery->fetchAll(PDO::FETCH_COLUMN);
                        if (!empty($notSelling)) {
                            $recommendations[] = "📉 <strong>Menu Kurang Laku:</strong> " . implode(', ', $notSelling) . " - Pertimbangkan promo atau perbaikan menu.";
                        }
                        
                        // Top sellers recommendation
                        $topSellersQuery = $pdo->query("SELECT name, sold FROM menu WHERE sold > 5 ORDER BY sold DESC LIMIT 3");
                        $topSellers = $topSellersQuery->fetchAll(PDO::FETCH_ASSOC);
                        if (!empty($topSellers)) {
                            $topSellersList = array_map(function($item) {
                                return $item['name'] . " ({$item['sold']} terjual)";
                            }, $topSellers);
                            $recommendations[] = "🏆 <strong>Menu Terlaris:</strong> " . implode(', ', $topSellersList) . " - Pertahankan kualitas!";
                        }
                        
                        // Revenue recommendation
                        $totalRevenue = $stats['total_revenue'] ?? 0;
                        if ($totalRevenue > 100000) {
                            $recommendations[] = "💰 <strong>Penghasilan Bagus:</strong> Total pendapatan Rp " . number_format($totalRevenue, 0, ',', '.') . ". Terus tingkatkan!";
                        }
                        
                        if (empty($recommendations)) {
                            echo '<p style="color: #92400e;">Semua berjalan lancar! Tidak ada rekomendasi khusus saat ini.</p>';
                        } else {
                            foreach ($recommendations as $rec) {
                                echo "<div class='recommendation-item'>$rec</div>";
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Handle form submission
        document.getElementById('menu-form').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            
            try {
                const response = await fetch('', {
                    method: 'POST',
                    body: formData
                });
                
                const result = await response.json();
                
                if (result.success) {
                    showAlert(result.message, 'success');
                    setTimeout(() => location.reload(), 1000);
                } else {
                    showAlert(result.message, 'error');
                }
            } catch (error) {
                showAlert('Terjadi kesalahan: ' + error.message, 'error');
            }
        });

        function showAlert(message, type) {
            const alertBox = document.getElementById('alert-box');
            alertBox.textContent = message;
            alertBox.className = 'alert alert-' + type;
            alertBox.style.display = 'block';
            
            setTimeout(() => {
                alertBox.style.display = 'none';
            }, 3000);
        }

        function editMenu(id, name, category, price, stock) {
            document.getElementById('menu-id').value = id;
            document.getElementById('action').value = 'update';
            document.getElementById('menu-name').value = name;
            document.getElementById('menu-category').value = category;
            document.getElementById('menu-price').value = price;
            document.getElementById('menu-stock').value = stock;
            
            document.getElementById('form-title').textContent = '✏️ Edit Menu';
            document.getElementById('submit-btn').textContent = 'Update Menu';
            document.getElementById('submit-btn').className = 'btn btn-success';
            document.getElementById('cancel-btn').style.display = 'inline-block';
            
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }

        function resetForm() {
            document.getElementById('menu-form').reset();
            document.getElementById('menu-id').value = '';
            document.getElementById('action').value = 'add';
            document.getElementById('form-title').textContent = '➕ Tambah Menu Baru';
            document.getElementById('submit-btn').textContent = 'Tambah Menu';
            document.getElementById('submit-btn').className = 'btn btn-primary';
            document.getElementById('cancel-btn').style.display = 'none';
        }

        async function deleteMenu(id) {
            if (!confirm('Apakah Anda yakin ingin menghapus menu ini?')) return;
            
            const formData = new FormData();
            formData.append('action', 'delete');
            formData.append('id', id);
            
            try {
                const response = await fetch('', {
                    method: 'POST',
                    body: formData
                });
                
                const result = await response.json();
                
                if (result.success) {
                    showAlert(result.message, 'success');
                    setTimeout(() => location.reload(), 1000);
                } else {
                    showAlert(result.message, 'error');
                }
            } catch (error) {
                showAlert('Terjadi kesalahan: ' + error.message, 'error');
            }
        }

        async function sellMenu(id) {
            const formData = new FormData();
            formData.append('action', 'sell');
            formData.append('id', id);
            
            try {
                const response = await fetch('', {
                    method: 'POST',
                    body: formData
                });
                
                const result = await response.json();
                
                if (result.success) {
                    showAlert(result.message, 'success');
                    setTimeout(() => location.reload(), 500);
                } else {
                    showAlert(result.message, 'error');
                }
            } catch (error) {
                showAlert('Terjadi kesalahan: ' + error.message, 'error');
            }
        }
    </script>
</body>
</html>