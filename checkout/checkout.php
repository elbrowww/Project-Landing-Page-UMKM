<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>KERANJANG MAKAN</title>

  <link rel="icon" href="favicon.png" type="image/x-icon" />
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

    <!-- Rincian keranjang -->
    <div class="cart-items" id="cartItems">
      <p>Memuat keranjang...</p>
    </div>

    <!-- Total -->
    <div class="cart-total" id="cartTotal">
      Total: Rp 0
    </div>

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
        <label for="rekening"><i class="fas fa-university"></i> Pilih Metode Pembayaran</label>
        <select id="rekening" onchange="tampilkanRekening()" required>
          <option value="">-- Pilih Metode Pembayaran --</option>
          <option value="Cash"> Tunai Cash</option>
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
  </section>

  <footer>
    <p>© 2025 Dapur bu Mon. All Rights Reserved.</p>
  </footer>

  <!-- Script untuk membaca data keranjang -->
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
        const subtotal = item.price * item.quantity;
        total += subtotal;

        const div = document.createElement("div");
        div.className = "cart-item";
        div.innerHTML = `
          <div class="item-info" style="display:flex;align-items:center;gap:10px;">
            <img src="${item.image}" alt="${item.name}" 
                 style="width:60px;height:60px;object-fit:cover;border-radius:10px;">
            <div>
              <strong>${item.name}</strong><br>
              <small>Harga: Rp ${item.price.toLocaleString("id-ID")}</small><br>
              <small>Jumlah: ${item.quantity}</small><br>
              <small>Subtotal: <b>Rp ${subtotal.toLocaleString("id-ID")}</b></small>
            </div>
          </div>
        `;
        cartItemsContainer.appendChild(div);
      });

      cartTotalElement.textContent = `Total: Rp ${total.toLocaleString("id-ID")}`;
    }

    function tampilkanRekening() {
      const rekening = document.getElementById("rekening").value;
      const info = document.getElementById("rekeningInfo");
      let text = "";

      switch (rekening) {
        case "BRI": text = "Nomor Rekening BRI: 1234-5678-999 a.n. Dapur Bu Mon"; break;
        case "BCA": text = "Nomor Rekening BCA: 5678-1234-555 a.n. Dapur Bu Mon"; break;
        case "Mandiri": text = "Nomor Rekening Mandiri: 1122-3344-5566 a.n. Dapur Bu Mon"; break;
        case "BNI": text = "Nomor Rekening BNI: 9988-7766-5544 a.n. Dapur Bu Mon"; break;
        default: text = "";
      }
      info.innerHTML = `<p>${text}</p>`;
    }

function checkout() {
  const nama = document.getElementById("nama").value.trim();
  const telp = document.getElementById("telp").value.trim();
  const alamat = document.getElementById("alamat").value.trim();
  const rekening = document.getElementById("rekening").value.trim();

  if (!nama || !telp || !alamat || !rekening) {
    alert("Harap isi semua data pemesan!");
    return;
  }

  if (cart.length === 0) {
    alert("Keranjang masih kosong!");
    return;
  }

  // Validasi nomor telepon
  if (!/^08[0-9]{9,12}$/.test(telp)) {
    alert("Format nomor telepon tidak valid! Harus diawali 08 dan 10-13 digit.");
    return;
  }

  const pesanan = {
    nama,
    telp,
    alamat,
    rekening,
    cart,
    total: cart.reduce((sum, item) => sum + item.price * item.quantity, 0),
  };

  // Kirim data ke PHP menggunakan fetch()
  fetch("../Project-Landing-Page-UMKM/config/checkout-proses.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify(pesanan),
  })
    .then((res) => res.json())
    .then((data) => {
      if (data.status === "success") {
        alert(`✅ Pesanan berhasil disimpan!\nID Pelanggan: ${data.id_pelanggan}\nTotal: Rp ${data.total.toLocaleString("id-ID")}\n\nTerima kasih telah memesan di Dapur Bu Mon ❤️`);
        
        // Hapus keranjang setelah checkout berhasil
        localStorage.removeItem("cart");
        cart = [];
        renderCart();

        // Tunggu 2 detik, lalu kembali ke landing page
        setTimeout(() => {
          window.location.href = "../index.php";
        }, 2000);
      } else {
        alert("❌ Gagal menyimpan pesanan: " + data.message);
      }
    })
    .catch((error) => {
      console.error("Error:", error);
      alert("❌ Terjadi kesalahan saat mengirim pesanan.");
    });
}

    document.addEventListener("DOMContentLoaded", renderCart);
  </script>
</body>
</html>
