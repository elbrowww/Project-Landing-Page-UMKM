<?php

include '../config/koneksi.php';

// ✔ Generator ID urut
function generateID($koneksi, $table, $column, $prefix) {
    $query = "SELECT $column FROM $table ORDER BY $column DESC LIMIT 1";
    $result = mysqli_query($koneksi, $query);

    if ($row = mysqli_fetch_assoc($result)) {
        $lastID = $row[$column];
        $number = (int)substr($lastID, strlen($prefix));
        $number++;
        return $prefix . str_pad($number, 3, '0', STR_PAD_LEFT);
    } else {
        return $prefix . "001";
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nama = $_POST['nama'];
    $telp = $_POST['telp'];
    $alamat = $_POST['alamat'];
    $rekening = $_POST['rekening'];
    $total = (int)$_POST['total'];
    $status = 'pending';

    $id_menu_arr = $_POST['id_menu'] ?? [];
    $nama_menu_arr = $_POST['nama_menu'];
    $jumlah_arr = $_POST['jumlah'];
    $harga_arr = $_POST['harga_satuan'];
    $gambar_arr = $_POST['gambar'] ?? [];

    // ✔ Buat ID pesanan otomatis
    $id_pesanan = generateID($koneksi, "transaksi_penjualan", "id_pesanan", "PSN");

    mysqli_begin_transaction($koneksi);

    try {
        // Insert pesanan
        $sql_pesanan = "INSERT INTO transaksi_penjualan (id_pesanan, nama, telp, alamat, metode_pembayaran, total, tgl_pesan, status, id_user) VALUES ('$id_pesanan', '$nama', '$telp', '$alamat', '$rekening', $total, NOW(), '$status', 'US001')";
        if (!mysqli_query($koneksi, $sql_pesanan)) {
            throw new Exception(mysqli_error($koneksi));
        }

        // Detail
        foreach ($nama_menu_arr as $i => $nama_menu) {

            // ✔ ID Detail otomatis
            $id_detail = generateID($koneksi, "detail_penjualan", "id_detail", "DTL");

            $id_menu = $id_menu_arr[$i] ?? null;
            $jumlah = (int)$jumlah_arr[$i];
            $harga = (int)$harga_arr[$i];
            $subtotal = $jumlah * $harga;

            $sql_detail = "INSERT INTO detail_penjualan (id_detail, id_menu, id_pesanan, nama_menu, jumlah, harga_satuan, subtotal, tgl_pesan) VALUES ('$id_detail', '$id_menu', '$id_pesanan', '$nama_menu', $jumlah, $harga, $subtotal, NOW())";
            if (!mysqli_query($koneksi, $sql_detail)) {
                throw new Exception(mysqli_error($koneksi));
            }
        }

        mysqli_commit($koneksi);

        echo "<script>
                alert('Pesanan berhasil! Terima kasih sudah memesan di Dapur Bu Mon ❤️');
                localStorage.removeItem('cart');
                window.location.href = '../index.php';
              </script>";

    } catch (Exception $e) {

        mysqli_rollback($koneksi);
        echo "<script>alert('Error: ".$e->getMessage()."');</script>";
    }
}

?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>KERANJANG MAKAN</title>

  <link rel="icon" href="../asset/img/logo.png" type="image/x-icon">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link rel="stylesheet" href="../checkout/checkout.css">
  <script src="https://kit.fontawesome.com/a2e0e6d6df.js" crossorigin="anonymous"></script>
</head>

<body>
  <header>
    <div class="logo">
      <i class="fas fa-utensils"></i>
      <span>DAPUR BU MON</span>
    </div>
  </header>

  <section class="cart" id="cart">
    <h2>Keranjang Belanja</h2>

    <div class="cart-items" id="cartItems">
      <p>Memuat keranjang...</p>
    </div>

    <div class="cart-total" id="cartTotal">
      Total: Rp 0
    </div>

    <!-- Form Data Pemesan -->
    <form id="formCheckout" method="POST" onsubmit="return validateCheckout()">
      <div class="customer-form">
        <h3>Data Pemesan</h3>

        <div class="form-group">
          <label for="nama"><i class="fas fa-user"></i> Nama Lengkap</label>
          <input type="text" name="nama" id="nama" placeholder="Masukkan nama lengkap Anda" required>
        </div>

        <div class="form-group">
          <label for="telp"><i class="fas fa-phone"></i> Nomor Telepon</label>
          <input type="tel" name="telp" id="telp" placeholder="08xxxxxxxxxx" required>
        </div>

        <div class="form-group">
          <label for="alamat"><i class="fas fa-map-marker-alt"></i> Alamat Lengkap</label>
          <textarea name="alamat" id="alamat" rows="3" placeholder="Masukkan alamat lengkap Anda" required></textarea>
        </div>

        <div class="form-group">
          <label for="rekening"><i class="fas fa-university"></i> Pilih Metode Pembayaran</label>
          <select name="rekening" id="rekening" onchange="tampilkanRekening()" required>
            <option value="">-- Pilih Metode Pembayaran --</option>
            <option value="Cash">💵 Tunai Cash</option>
            <option value="BRI">🏦 Bank BRI</option>
            <option value="BCA">🏦 Bank BCA</option>
            <option value="Mandiri">🏦 Bank Mandiri</option>
            <option value="BNI">🏦 Bank BNI</option>
          </select>
          <div id="rekeningInfo"></div>
        </div>

        <!-- Hidden fields untuk cart -->
        <div id="hiddenCartData"></div>
        <input type="hidden" name="total" id="hiddenTotal" value="0">

        <button type="submit" class="checkout-btn">
          <i class="fas fa-shopping-cart"></i> Checkout
        </button>
      </div>
    </form>
  </section>

  <footer>
    <p>© 2025 Dapur bu Mon. All Rights Reserved.</p>
  </footer>

  <script>
    let cart = JSON.parse(localStorage.getItem("cart")) || [];
    const cartItemsContainer = document.getElementById("cartItems");
    const cartTotalElement = document.getElementById("cartTotal");

    function renderCart() {
      cartItemsContainer.innerHTML = "";
      let total = 0;

      if (cart.length === 0) {
        cartItemsContainer.innerHTML = "<p>Keranjang masih kosong.</p>";
        cartTotalElement.textContent = "Total: Rp 0";
        return;
      }

      cart.forEach((item) => {
        const subtotal = item.harga_satuan * item.jumlah;

        const div = document.createElement("div");
        div.className = "cart-item";
        div.innerHTML = `
          
              <strong>${item.nama_menu}</strong><br>
              <small>Harga: Rp ${item.harga_satuan.toLocaleString("id-ID")}</small><br>
              <small>Jumlah: ${item.jumlah}</small><br>
              <small>Subtotal: <b>Rp ${subtotal.toLocaleString("id-ID")}</b></small>
            </div>
          </div>
        `;
        cartItemsContainer.appendChild(div);

        total += subtotal;
      });

      cartTotalElement.textContent = "Total: Rp " + total.toLocaleString("id-ID");
      
      // Update hidden fields
      updateHiddenFields(total);
    }

    function updateHiddenFields(total) {
      const hiddenContainer = document.getElementById("hiddenCartData");
      hiddenContainer.innerHTML = "";
      
      cart.forEach((item, index) => {
        // ID Menu (jika ada)
        if (item.id_menu) {
          const inputIdMenu = document.createElement("input");
          inputIdMenu.type = "hidden";
          inputIdMenu.name = "id_menu[]";
          inputIdMenu.value = item.id_menu;
          hiddenContainer.appendChild(inputIdMenu);
        }
        
        // Nama Menu
        const inputNama = document.createElement("input");
        inputNama.type = "hidden";
        inputNama.name = "nama_menu[]";
        inputNama.value = item.nama_menu;
        hiddenContainer.appendChild(inputNama);
        
        // Jumlah
        const inputJumlah = document.createElement("input");
        inputJumlah.type = "hidden";
        inputJumlah.name = "jumlah[]";
        inputJumlah.value = item.jumlah;
        hiddenContainer.appendChild(inputJumlah);
        
        // Harga Satuan
        const inputHarga = document.createElement("input");
        inputHarga.type = "hidden";
        inputHarga.name = "harga_satuan[]";
        inputHarga.value = item.harga_satuan;
        hiddenContainer.appendChild(inputHarga);
      });
      
      // Update total
      document.getElementById("hiddenTotal").value = total;
    }

    function tampilkanRekening() {
      const rekening = document.getElementById("rekening").value;
      const info = document.getElementById("rekeningInfo");
      let text = "";

      switch (rekening) {
        case "BRI": 
          text = "📱 Nomor Rekening BRI: 1234-5678-999 a.n. Dapur Bu Mon kirim bukti tranfer di nomer +62 852-3659-6617"; 
          break;
        case "BCA": 
          text = "📱 Nomor Rekening BCA: 5678-1234-555 a.n. Dapur Bu Mon kirim bukti tranfer di nomer +62 852-3659-6617"; 
          break;
        case "Mandiri": 
          text = "📱 Nomor Rekening Mandiri: 1122-3344-5566 a.n. Dapur Bu Mon kirim bukti tranfer di nomer +62 852-3659-6617"; 
          break;
        case "BNI": 
          text = "📱 Nomor Rekening BNI: 9988-7766-5544 a.n. Dapur Bu Mon kirim bukti tranfer di nomer +62 852-3659-6617"; 
          break;
        case "Cash":
          text = "💰 Pembayaran tunai saat pesanan diantar";
          break;
        default: 
          text = "";
      }
      info.innerHTML = `<p style="margin-top:10px;padding:10px;background:#f0f0f0;border-radius:5px;">${text}</p>`;
    }

    function validateCheckout() {
      const telp = document.getElementById("telp").value.trim();
      
      if (!/^08[0-9]{9,12}$/.test(telp)) {
        alert("Format nomor telepon tidak valid! Harus dimulai dengan 08 dan 11-14 digit");
        return false;
      }

      if (cart.length === 0) {
        alert("Keranjang masih kosong!");
        return false;
      }

      return true;
    }

    document.addEventListener("DOMContentLoaded", renderCart);
  </script>
</body>
</html>