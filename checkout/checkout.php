<!doctype html>
<html lang="id">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>KERANJANG MAKAN</title>

  <head>
    <link rel="icon" href="favicon.png.png" type="image/x-icon" />

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <!-- <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet"> -->

    <link rel="stylesheet" href="../checkout/checkout.css">

  </head>


<body>
  <header>
    <div class="logo">
      <i class="fas fa-utensils"></i>
      <span>DAPUR BU MON</span>
    </div>
    <nav>
    </nav>
  </header>

  
 

    

  <section class="cart" id="cart">
  <h2>Keranjang Belanja</h2>
  <div class="cart-items" id="cartItems">
    <!-- Item keranjang akan ditambahkan di sini -->
  </div>



  <!-- 🔽 Form Data Pelanggan -->
 
<!-- 🔹 Form Data Pemesan -->
<div class="customer-form">
  <h3>Data Pemesan</h3>

  <div class="form-group">
    <label for="nama"><i class="fas fa-user"></i> Nama Lengkap</label>
    <input type="text" id="nama" placeholder="Masukkan nama lengkap Anda" required>
  </div>

  <div class="form-group">
    <label for="telp"><i class="fas fa-phone"></i> Nomor Telepon</label>
    <input type="tel" id="telp" placeholder="08xxxxxxxxxx" required>
  </div>

  <div class="form-group">
    <label for="alamat"><i class="fas fa-map-marker-alt"></i> Alamat Lengkap</label>
    <textarea id="alamat" rows="3" placeholder="Masukkan alamat lengkap Anda" required></textarea>
  </div>

  <div class="form-group">
    <label for="rekening"><i class="fas fa-university"></i> Pilih Rekening Pembayaran</label>
    <select id="rekening" onchange="tampilkanRekening()" required>
      <option value="">-- Pilih Rekening --</option>
      <option value="BRI">Bank BRI</option>
      <option value="BCA">Bank BCA</option>
      <option value="Mandiri">Bank Mandiri</option>
      <option value="BNI">Bank BNI</option>
    </select>
    <div id="rekeningInfo"></div>
  </div>

  <button class="checkout-btn" onclick="checkout()">
    <i class="fas fa-shopping-cart"></i> Checkout
  </button>
</div>

      <div class="cart-total" id="cartTotal">
    Total: Rp 0
  </div>
  </section>

      


  

  <footer>
    <p>© 2025 Dapur bu Mon. All Rights Reserved.</p>
  </footer>
 <script src="../checkout/script.js"></script>


</body>


</html>