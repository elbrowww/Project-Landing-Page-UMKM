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
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="checkout.css">

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

  <section class="hero" id="home">
    <div class="hero-text">
      <h1>Pesan <span>Makanan Favoritmu</span></h1>
      <p>Pilih menu terbaik kami dan nikmati makanan sehat setiap hari!</p>
    </div>
  </section>

 

    

  <!-- Modal untuk detail menu -->
  <div class="modal" id="menuModal">
    <div class="modal-content">
      <span class="close-modal" onclick="closeModal()">&times;</span>
      <img class="modal-image" id="modalImage" src="" alt="">
      <h3 class="modal-title" id="modalTitle"></h3>
      <p class="modal-price" id="modalPrice"></p>
      <p class="modal-description" id="modalDescription"></p>
      <div class="modal-details">
        <h4>Komposisi:</h4>
        <ul id="modalIngredients"></ul>
      </div>
      <button class="modal-add-btn" id="modalAddBtn">Tambah ke Keranjang</button>
    </div>
  </div>

<section class="cart" id="cart">
  <h2>Keranjang Belanja</h2>
  <div class="cart-items" id="cartItems">
    <!-- Item keranjang akan ditambahkan di sini -->
  </div>

  <div class="cart-total" id="cartTotal">
    Total: Rp 0
  </div>

  <!-- 🔽 Form Data Pelanggan -->
  <div class="customer-info">
    <h3>Data Pemesan</h3>

    <label for="nama">Nama Lengkap:</label>
    <input type="text" id="nama" placeholder="Masukkan nama Anda" required>

    <label for="telp">Nomor Telepon:</label>
    <input type="tel" id="telp" placeholder="08xxxxxxxxxx" required>

    <label for="email">Email:</label>
    <input type="email" id="email" placeholder="contoh@email.com" required>

    <label for="alamat">Alamat Lengkap:</label>
    <textarea id="alamat" rows="3" placeholder="Masukkan alamat lengkap Anda" required></textarea>
  </div>

  <!-- 🔽 Pilihan Rekening -->
  <div class="rekening-container">
    <label for="rekening">Pilih Rekening Pembayaran:</label>
    <select id="rekening" onchange="tampilkanRekening()">
      <option value="">-- Pilih Rekening --</option>
      <option value="BRI">Bank BRI</option>
      <option value="BCA">Bank BCA</option>
      <option value="Mandiri">Bank Mandiri</option>
      <option value="BNI">Bank BNI</option>
    </select>
    <div id="rekeningInfo"></div>
  </div>

  <button class="checkout-btn" onclick="checkout()">Checkout</button>
</section>


  <footer>
    <p>© 2025 Dapur bu Mon. All Rights Reserved.</p>
  </footer>
 <script src="../checkout/script.js"></script>


</body>


</html>