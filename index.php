
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Dapur Buk Mon - Cita Rasa Istimewa</title>

 <link rel="icon" href="asset/img/logo.png" type="image/x-icon">
 <script src="https://cdn.tailwindcss.com"></script>
 <link rel="stylesheet" href="asset/css/LandingPage.css">
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">

 <?php 
 include '../Project-Landing-Page-UMKM/config/koneksi.php';
 include '../Project-Landing-Page-UMKM/config/FormPesan.php';
 ?>

</head>
<body class="bg-gray-50 text-gray-800">

  <!-- NAVBAR -->
  <nav class="sticky-nav fixed w-full z-50 top-0 left-0">
    <div class="container mx-auto px-6 py-4 flex items-center justify-between">
      <div id="logo" class="text-2xl font-bold text-purple transition-colors duration-300">
        🍴 Dapur Buk Mon
      </div>
      <div class="hidden md:flex items-center space-x-8">
        <a class="text-purple hover:text-sky-100" href="#home">Beranda</a>
        <a class="text-purple hover:text-sky-100" href="#menu">Menu</a>
        <a class="text-purple hover:text-sky-100" href="#layanan">Layanan</a>
        <a class="text-purple hover:text-sky-100" href="#testimoni">Testimoni</a>
        <a class="text-purple hover:text-sky-100" href="#kontak">Kontak</a>
        <a class="text-purple hover:text-sky-100" href="#lokasi">Lokasi</a>
        <a href="../Project-Landing-Page-UMKM/checkout/checkout.php" 
         class="relative ml-4 flex items-center justify-center hover:scale-105 transition">
        <div class="bg-purple-100 p-2 rounded-full shadow-sm hover:bg-purple-200 transition">
          <i class="fa-solid fa-cart-shopping text-purple text-xl"></i>
        </div>
        <span id="cart-count"
              class="absolute -top-1 -right-1 bg-red-500 text-white text-[10px] font-bold px-1.5 rounded-full shadow">0</span>
      </a>
    </div>

    <!-- Tombol Menu Mobile -->
    <button id="menuBtn" class="md:hidden text-purple" aria-label="Buka menu">
      <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M4 6h16M4 12h16M4 18h16" />
      </svg>
    </button>
  </div>
      </div>
      <button id="menuBtn" class="md:hidden text-white" aria-label="Buka menu">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
        </svg>
      </button>
    </div>
    <div id="mobileMenu" class="hidden md:hidden bg-purple/90 backdrop-blur-sm px-4 py-4">
      <a class="block py-2 text-gray-700" href="#home">Beranda</a>
      <a class="block py-2 text-gray-700" href="#menu">Menu</a>
      <a class="block py-2 text-gray-700" href="#layanan">Layanan</a>
      <a class="block py-2 text-gray-700" href="#testimoni">Testimoni</a>
      <a class="block py-2 text-gray-700" href="#kontak">Kontak</a>
      <a class="block py-2 text-gray-700" href="#lokasi">Lokasi</a>
    </div>
  </nav>

  <!-- HERO -->
  <section id="home" class="gradient-bg min-h-screen flex items-center pt-24">
    <div class="container mx-auto px-6">
      <div class="grid md:grid-cols-2 gap-12 items-center">
        <div class="text-white fade-in">
          <h1 class="text-5xl md:text-6xl font-bold leading-tight mb-6">Cita Rasa Istimewa untuk Acara Anda</h1>
          <p class="text-lg text-sky-100 mb-8">Hidangan lezat dengan pelayanan terbaik untuk membuat momen spesial Anda tak terlupakan.</p>
          <div class="flex gap-4">
            <a href="#menu" class="bg-white text-sky-600 px-8 py-4 rounded-full font-semibold hover:bg-gray-100 transition">Lihat Menu</a>
            <a href="https://wa.me/6285236596617" target="_blank" class="btn-gradient text-white px-8 py-4 rounded-full font-semibold hover:opacity-90 transition">Hubungi Kami</a>
          </div>
        </div>
        <div class="hidden md:block float-animation fade-in">
          <img src="asset/img/logo.png" alt="Catering" class="rounded-3xl shadow-2xl w-full object-cover">
        </div>
      </div>
    </div>
  </section>

  <!-- Mengapa Memilih Kami -->
  <section class="py-20 bg-white">
    <div class="container mx-auto px-6">
      <h2 class="text-4xl font-bold text-center mb-12 gradient-text fade-in">Mengapa Memilih Kami?</h2>
      <div class="grid md:grid-cols-3 gap-8">
        <div class="fade-in card-hover bg-gradient-to-br from-white to-gray-50 p-8 rounded-2xl text-center">
          <div class="text-5xl mb-4">📃</div>
          <h3 class="text-2xl font-bold mb-4">Bisa Custom Order</h3>
          <p class="text-gray-600">Menu dan porsi bisa disesuaikan dengan anggaran serta selera pelanggan.</p>
        </div>
        <div class="fade-in card-hover bg-gradient-to-br from-white to-gray-50 p-8 rounded-2xl text-center">
          <div class="text-5xl mb-4">🥗</div>
          <h3 class="text-2xl font-bold mb-4">Bahan Berkualitas</h3>
          <p class="text-gray-600">Menggunakan bahan segar pilihan untuk cita rasa terbaik.</p>
        </div>
        <div class="fade-in card-hover bg-gradient-to-br from-white to-gray-50 p-8 rounded-2xl text-center">
          <div class="text-5xl mb-4">⭐</div>
          <h3 class="text-2xl font-bold mb-4">Pelayanan Prima</h3>
          <p class="text-gray-600">Layanan ramah dan profesional untuk kepuasan Anda.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- MENU -->
<section id="menu" class="py-20 bg-gray-50">
  <div class="container mx-auto px-6">
    <h2 class="text-4xl font-bold text-center mb-6 gradient-text fade-in">Menu Pilihan Kami</h2>
    <p class="text-center text-gray-600 mb-12 fade-in">Beragam menu tersedia untuk berbagai acara</p>

    <!-- Tombol scroll kiri-kanan -->
    <div class="relative">
      <button id="scrollLeft" class="absolute left-0 top-1/2 -translate-y-1/2 bg-purple-600 text-white p-3 rounded-full shadow-md hover:bg-purple-700 z-10">
        ◀
      </button>

      <div id="menuContainer" class="flex overflow-x-auto gap-6 scroll-smooth px-10 pb-4 no-scrollbar">
        <?php
        $query = mysqli_query($koneksi, "SELECT nama_menu, deskripsi, harga_menu, gambar FROM menu");
        while ($data = mysqli_fetch_array($query)) {
        ?>
          <div class="menu-item fade-in bg-white rounded-2xl shadow-lg hover:shadow-2xl hover:scale-[1.03] transition-all duration-300 overflow-hidden min-w-[280px] max-w-[320px] flex-shrink-0 cursor-pointer">
  <div class="relative">
    <img src="asset/uploads/<?php echo $data['gambar']; ?>"
         alt="<?php echo $data['nama_menu']; ?>"
         class="w-full h-48 object-cover transition-transform duration-300 group-hover:scale-105">
  </div>
  <div class="p-6">
    <h3 class="text-xl font-bold mb-2"><?php echo $data['nama_menu']; ?></h3>
    <p class="text-gray-600 mb-4"><?php echo $data['deskripsi']; ?></p>
    <p class="text-lg font-semibold text-purple-600 mb-4">
      Rp <?php echo number_format($data['harga_menu'], 0, ',', '.'); ?>
    </p>
    <div class="text-center">
  <button 
    class="add-to-cart bg-purple-600 text-white px-6 py-3 rounded-xl hover:bg-purple-700 transition"
    data-name="<?php echo $data['nama_menu']; ?>"
    data-price="<?php echo $data['harga_menu']; ?>"
    data-image="asset/uploads/<?php echo $data['gambar']; ?>">
    Pesan Sekarang
  </button>
</div>

  </div>
</div>

        <?php } ?>
      </div>

      <button id="scrollRight" class="absolute right-0 top-1/2 -translate-y-1/2 bg-purple-600 text-white p-3 rounded-full shadow-md hover:bg-purple-700 z-10">
        ▶
      </button>
    </div>
  </div>
</section>

  <!-- LAYANAN -->
   <section id="layanan" class="py-20 bg-white">
        <div class="container mx-auto px-6">
            <h2 class="text-4xl font-bold text-center mb-16 gradient-text fade-in">Layanan Kami</h2>
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <div class="fade-in">
                    <img src="asset/img/logo.png"
                        alt="Layanan" class="rounded-2xl shadow-2xl">
                </div>
                <div class="fade-in space-y-6">
                    <div class="flex items-start gap-4">
                        <div
                            class="gradient-bg text-white w-12 h-12 rounded-full flex items-center justify-center text-xl flex-shrink-0">
                            🎉</div>
                        <div>
                            <h3 class="text-xl font-bold mb-2">Acara Pernikahan</h3>
                            <p class="text-gray-600">Layanan catering lengkap untuk hari spesial Anda dengan berbagai
                                pilihan menu</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div
                            class="gradient-bg text-white w-12 h-12 rounded-full flex items-center justify-center text-xl flex-shrink-0">
                            🏢</div>
                        <div>
                            <h3 class="text-xl font-bold mb-2">Acara Kantor</h3>
                            <p class="text-gray-600">Solusi catering untuk meeting, seminar, dan acara perusahaan</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div
                            class="gradient-bg text-white w-12 h-12 rounded-full flex items-center justify-center text-xl flex-shrink-0">
                            🎂</div>
                        <div>
                            <h3 class="text-xl font-bold mb-2">Acara Ulang Tahun</h3>
                            <p class="text-gray-600">Paket spesial untuk merayakan momen berharga bersama keluarga</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div
                            class="gradient-bg text-white w-12 h-12 rounded-full flex items-center justify-center text-xl flex-shrink-0">
                            🎓</div>
                        <div>
                            <h3 class="text-xl font-bold mb-2">Acara Sekolah</h3>
                            <p class="text-gray-600">Catering untuk acara sekolah, wisuda, dan kegiatan pendidikan</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

  <!-- TESTIMONI -->
  <section id="testimoni" class="py-20 gradient-bg">
        <div class="container mx-auto px-6">
            <h2 class="text-4xl font-bold text-center mb-4 text-white fade-in">Apa Kata Mereka?</h2>
            <p class="text-center text-purple-100 mb-16 fade-in">Testimoni pelanggan yang puas dengan layanan kami</p>
            <div class="grid md:grid-cols-3 gap-8">
                <div class="fade-in bg-white p-8 rounded-2xl shadow-xl card-hover">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-purple-200 rounded-full flex items-center justify-center text-xl mr-4">
                            👨</div>
                        <div>
                            <h4 class="font-bold">Budi Santoso</h4>
                            <div class="text-yellow-400">⭐⭐⭐⭐⭐</div>
                        </div>
                    </div>
                    <p class="text-gray-600">"Makanannya enak banget! Semua tamu acara pernikahan saya puas.
                        Pelayanannya juga ramah dan profesional."</p>
                </div>
                <div class="fade-in bg-white p-8 rounded-2xl shadow-xl card-hover">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-pink-200 rounded-full flex items-center justify-center text-xl mr-4">👩
                        </div>
                        <div>
                            <h4 class="font-bold">Siti Rahmawati</h4>
                            <div class="text-yellow-400">⭐⭐⭐⭐⭐</div>
                        </div>
                    </div>
                    <p class="text-gray-600">"Harga terjangkau dengan kualitas premium. Pasti langganan terus untuk
                        acara-acara kantor kami!"</p>
                </div>
                <div class="fade-in bg-white p-8 rounded-2xl shadow-xl card-hover">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-blue-200 rounded-full flex items-center justify-center text-xl mr-4">👨
                        </div>
                        <div>
                            <h4 class="font-bold">Ahmad Hidayat</h4>
                            <div class="text-yellow-400">⭐⭐⭐⭐⭐</div>
                        </div>
                    </div>
                    <p class="text-gray-600">"Respon cepat, pengiriman tepat waktu, dan yang paling penting makanannya
                        lezat! Highly recommended!"</p>
                </div>
            </div>
        </div>
    </section>


  <!-- KONTAK -->
   <section id="kontak" class="py-20 bg-white">
        <div class="container mx-auto px-6">
            <h2 class="text-4xl font-bold text-center mb-16 gradient-text fade-in">Hubungi Kami</h2>
            <div class="grid md:grid-cols-2 gap-12">
                <div class="fade-in">
                    <h3 class="text-2xl font-bold mb-6">Informasi Kontak</h3>
                    <div class="space-y-4">
                        <div class="flex items-center gap-4">
                            <div class="gradient-bg text-white w-12 h-12 rounded-full flex items-center justify-center">
                                📱</div>
                            <div>
                                <p class="font-semibold">Telepon/WhatsApp</p>
                                <p class="text-gray-600">+62 812-3456-7890</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-4">
                            <div class="gradient-bg text-white w-12 h-12 rounded-full flex items-center justify-center">
                                📧</div>
                            <div>
                                <p class="font-semibold">Email</p>
                                <p class="text-gray-600">dwalan@gmail.com</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-4">
                            <div class="gradient-bg text-white w-12 h-12 rounded-full flex items-center justify-center">
                                📍</div>
                            <div>
                                <p class="font-semibold">Alamat</p>
                                <p class="text-gray-600">Merjoyo,Kec.purwosari,Kab.kediri,JAWA TIMUR</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-4">
                            <div class="gradient-bg text-white w-12 h-12 rounded-full flex items-center justify-center">
                                🕐</div>
                            <div>
                                <p class="font-semibold">Jam Operasional</p>
                                <p class="text-gray-600">Senin - Minggu: 08.00 - 20.00 WIB</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="fade-in">
                    <form method="POST" action="config/FormPesan.php" class="space-y-4">
                        <div>
                            <label class="block text-sm font-semibold mb-2">Nama Lengkap</label>
                            <input type="text" name="nama_pelanggan"
                                class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-purple-500 focus:outline-none transition"
                                placeholder="Masukkan nama Anda">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold mb-2">Email</label>
                            <input type="email" name="email_pelanggan"
                                class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-purple-500 focus:outline-none transition"
                                placeholder="email@contoh.com">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold mb-2">No. Telepon</label>
                            <input type="tel" name="notelp_pelanggan"
                                class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-purple-500 focus:outline-none transition"
                                placeholder="+62 812-xxxx-xxxx">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold mb-2">Pesan</label>
                            <textarea name="isi_pesan" rows="4" 
                                class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-purple-500 focus:outline-none transition"
                                placeholder="Ceritakan kebutuhan acara Anda..."></textarea>
                        </div>
                        <button type="submit" name="simpan"
                            class="w-full gradient-bg text-white py-4 rounded-lg font-semibold hover:opacity-90 transition">Kirim
                            Pesan</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!--lokasi kami-->
    <section id="lokasi" class="py-20 bg-gray-50">
      <div class="container mx-auto px-6">
        <h2 class="text-4xl font-bold text-center mb-12 gradient-text fade-in">LOKASI KAMI</h2>
        <div class="grid md:grid-cols-2 gap-8 items-center">

          <!--map-->
          <div class="fade-in">
            <div class="overflow-hidden rounded-2xl shadow-2xl border-4 border-purple-200">
              <iframe
              src="https://www.google.com/maps?q=-7.164886,112.651695&hl=id&z=15&output=embed"
              width="100%"
              height="350"
              style="border:0;"
              allowfullscreen=""
              loading="lazy">
            </iframe>
            </div>
          </div>
          <!--info lokasi-->
          <div class="fade-in space-y-6 text-center md:text-left">
            <h3 class="text-2xl font-bold text-purple-700">Alamat kami</h3>
          <p class=" text-gray-700 text-lg leading-relaxed">
            📍<strong >DAPUR BUK MON</strong><br>
            Merjoyo, Purwosari, Kediri, Jawa Timur.
            </p>
            <div class="flex flex-col items-center md:items-start">
              <img src="https://api.qrserver.com/v1/create-qr-code/?size=180x180&data=https://goo.gl/maps/7i99mAiHYk2v7FnY8"
              alt="QR Code lokasi"
              class="w-40 h-40 border-4 border-purple-300 rounded-xl shadow-md hover:scale-105 transition">
              <a href="https://goo.gl/maps/7i99mAiHYk2v7FnY8"
              target="_blank"
              class="mt-4 inline-block gradient-bg text-white px-6 py-3 rounded-full font-semibold hover:opacity-90 transition">
            BUKA DI GOOGLE MAPS
            </a>
            </div>
          </p>
          </div>
        </div>
      </div>
    </section>

<!-- FOOTER -->
  <footer class="gradient-bg text-white py-10">
    <div class="container mx-auto px-6 text-center">
      <div class="mb-6">
        <h3 class="text-2xl font-bold">Dapur Buk Mon</h3>
        <p class="text-sky-100">Solusi catering terbaik untuk setiap acara spesial Anda</p>
      </div>
      <p class="text-sm opacity-90">© 2025 Dapur Buk Mon. All rights reserved.</p>
    </div>
  </footer>

  <!-- Tombol WhatsApp Mengambang -->
  <a href="https://wa.me/6285236596617" target="_blank" class="wa-float" aria-label="Chat WhatsApp">
    💬
  </a>
 
  <script src="asset/js/HalamanUser.js"></script>

  <script>
  const container = document.getElementById('menuContainer');
  const scrollLeftBtn = document.getElementById('scrollLeft');
  const scrollRightBtn = document.getElementById('scrollRight');

  scrollLeftBtn.addEventListener('click', () => {
    container.scrollBy({ left: -300, behavior: 'smooth' });
  });

  scrollRightBtn.addEventListener('click', () => {
    container.scrollBy({ left: 300, behavior: 'smooth' });
  });

  
document.addEventListener("DOMContentLoaded", () => {
  console.log("✅ Script aktif");

  const buttons = document.querySelectorAll(".add-to-cart");
  console.log("Jumlah tombol:", buttons.length);

  buttons.forEach((btn) => {
    btn.addEventListener("click", (e) => {
      e.preventDefault();

      const item = {
        name: btn.dataset.name,
        price: parseInt(btn.dataset.price),
        image: btn.dataset.image,
        quantity: 1,
      };

      let cart = JSON.parse(localStorage.getItem("cart")) || [];

      const existing = cart.find((i) => i.name === item.name);
      if (existing) {
        existing.quantity++;
      } else {
        cart.push(item);
      }

      localStorage.setItem("cart", JSON.stringify(cart));
      updateCartCount();

      // Notifikasi kecil
      const notif = document.createElement("div");
      notif.textContent = `${item.name} ditambahkan ke keranjang 🛒`;
      notif.className =
        "fixed bottom-6 right-6 bg-purple-600 text-white px-4 py-2 rounded-lg shadow-lg z-[9999]";
      document.body.appendChild(notif);
      setTimeout(() => notif.remove(), 1500);
    });
  });

  updateCartCount();
});

function updateCartCount() {
  const cart = JSON.parse(localStorage.getItem("cart")) || [];
  const count = cart.reduce((sum, i) => sum + i.quantity, 0);
  const badge = document.getElementById("cart-count");
  if (badge) badge.textContent = count;
}
</script>

</script>

<!-- ================= MINI CART (keranjang muncul dari kanan) ================= -->
<div id="cartSidebar" class="fixed top-0 right-0 w-80 h-full bg-white shadow-2xl transform translate-x-full transition-transform duration-300 z-50 overflow-y-auto">
  <div class="p-4 border-b flex justify-between items-center">
    <h2 class="text-xl font-bold text-purple-700">Keranjang</h2>
    <button id="closeCart" class="text-gray-500 hover:text-red-500 text-xl">&times;</button>
  </div>
  <div id="cartItems" class="p-4 space-y-4"></div>
  <div class="p-4 border-t">
    <div class="flex justify-between font-semibold text-lg mb-4">
      <span>Total:</span>
      <span id="cartTotal">Rp 0</span>
    </div>
    <button class="w-full bg-purple-600 text-white py-3 rounded-lg hover:bg-purple-700 transition">Checkout</button>
  </div>
</div>

<!-- POPUP KONFIRMASI PESAN -->
<div id="orderPopup" class="hidden fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50">
  <div class="bg-white rounded-lg p-6 w-80">
    <h3 class="text-lg font-semibold mb-2" id="popupItemName"></h3>
    <p class="text-gray-600 mb-4" id="popupItemPrice"></p>
    <div class="flex justify-center items-center gap-4 mb-4">
      <button id="minusQty" class="text-purple-600 text-xl font-bold">-</button>
      <span id="popupQty" class="text-lg font-semibold">1</span>
      <button id="plusQty" class="text-purple-600 text-xl font-bold">+</button>
    </div>
    <div class="flex justify-between items-center font-semibold mb-4">
      <span>Total:</span>
      <span id="popupTotal">Rp 0</span>
    </div>
    <div class="flex justify-end gap-2">
      <button id="cancelPopup" class="px-3 py-2 border rounded-lg">Lanjut Belanja</button>
      <button id="addToCartPopup" class="bg-purple-600 text-white px-3 py-2 rounded-lg">Lihat Keranjang</button>
    </div>
  </div>
</div>

<!-- MINI POPUP DI BAWAH KERANJANG -->
<div id="bottomPopup" class="hidden fixed bottom-0 right-0 w-80 bg-white shadow-2xl border-t border-gray-300 z-40 p-4">
  <div class="flex justify-between items-center">
    <div>
      <p class="font-semibold text-purple-700" id="popupItemName"></p>
      <p class="text-sm text-gray-500" id="popupItemPrice"></p>
    </div>
    <div class="flex items-center gap-2">
      <button id="minusQty" class="text-purple-600 font-bold text-lg">-</button>
      <span id="popupQty" class="text-lg font-semibold">1</span>
      <button id="plusQty" class="text-purple-600 font-bold text-lg">+</button>
    </div>
  </div>

  <div class="flex justify-between items-center mt-3">
    <span class="font-semibold">Total:</span>
    <span id="popupTotal" class="font-bold text-purple-700">Rp 0</span>
  </div>

  <div class="flex justify-end gap-2 mt-3">
    <button id="cancelPopup" class="border px-3 py-1 rounded-lg text-sm">Batal</button>
    <button id="addToCartPopup" class="bg-purple-600 text-white px-3 py-1 rounded-lg text-sm">Tambah</button>
  </div>
</div>

<!-- POPUP DI BAWAH IKON KERANJANG -->
<div id="cartPopup" class="hidden fixed top-16 right-6 w-72 bg-white shadow-2xl rounded-xl border border-gray-200 p-4 z-50">
  <div class="flex justify-between items-start">
    <div>
      <p class="font-semibold text-purple-700" id="popupName"></p>
      <p class="text-sm text-gray-500" id="popupPrice"></p>
    </div>
    <button id="popupClose" class="text-gray-500 hover:text-red-500 text-xl leading-none">&times;</button>
  </div>

  <div class="flex justify-between items-center mt-3">
    <div class="flex items-center gap-2">
      <button id="popupMinus" class="text-purple-600 font-bold text-lg">-</button>
      <span id="popupQty" class="text-lg font-semibold">1</span>
      <button id="popupPlus" class="text-purple-600 font-bold text-lg">+</button>
    </div>
    <div class="text-right">
      <span class="text-sm font-semibold">Total:</span>
      <p id="popupTotal" class="text-purple-700 font-bold text-lg">Rp 0</p>
    </div>
  </div>

  <div class="flex justify-end gap-2 mt-4">
    <button id="popupCancel" class="border border-gray-300 px-3 py-1 rounded-lg text-sm">Batal</button>
    <button id="popupAdd" class="bg-purple-600 text-white px-3 py-1 rounded-lg text-sm hover:bg-purple-700">Tambah ke Keranjang</button>
  </div>
</div>

<div id="cartPopup" class="hidden fixed top-16 right-6 w-72 bg-white shadow-2xl rounded-xl border border-gray-200 p-4 z-50">
  <div class="flex justify-between items-start">
    <div>
      <p class="font-semibold text-purple-700" id="popupName"></p>
      <p class="text-sm text-gray-500" id="popupPrice"></p>
    </div>
    <button id="popupClose" class="text-gray-500 hover:text-red-500 text-xl leading-none">&times;</button>
  </div>

  <div class="flex justify-between items-center mt-3">
    <div class="flex items-center gap-2">
      <button id="popupMinus" class="text-purple-600 font-bold text-lg">−</button>
      <span id="popupQty" class="text-lg font-semibold">1</span>
      <button id="popupPlus" class="text-purple-600 font-bold text-lg">+</button>
    </div>
    <div class="text-right">
      <span class="text-sm font-semibold">Total:</span>
      <p id="popupTotal" class="text-purple-700 font-bold text-lg">Rp 0</p>
    </div>
  </div>

  <div class="flex justify-end gap-2 mt-4">
    <button id="popupCancel" class="border border-gray-300 px-3 py-1 rounded-lg text-sm">Batal</button>
    <button id="popupAdd" class="bg-purple-600 text-white px-3 py-1 rounded-lg text-sm hover:bg-purple-700">Tambah ke Keranjang</button>
  </div>
</div>

<!-- === POPUP KERANJANG DI KANAN ATAS === -->
<div id="cartPopup" class="fixed top-20 right-4 bg-white shadow-2xl rounded-lg p-4 w-72 border z-50 hidden">
  <h3 class="text-lg font-semibold mb-2 text-purple-700">Keranjang</h3>
  <div id="popupItems" class="space-y-2 max-h-60 overflow-y-auto"></div>
  <div class="flex justify-between mt-3 font-semibold">
    <span>Total:</span>
    <span id="popupTotal">Rp 0</span>
  </div>
</div>

<div id="cartPopup" class="hidden fixed top-16 right-6 w-72 bg-white shadow-2xl rounded-xl border border-gray-200 p-4 z-50">
  <div class="flex justify-between items-start">
    <div>
      <p class="font-semibold text-purple-700" id="popupName"></p>
      <p class="text-sm text-gray-500" id="popupPrice"></p>
    </div>
    <button id="popupClose" class="text-gray-500 hover:text-red-500 text-xl leading-none">&times;</button>
  </div>

  <div class="flex justify-between items-center mt-3">
    <div class="flex items-center gap-2">
      <button id="popupMinus" class="text-purple-600 font-bold text-lg">−</button>
      <span id="popupQty" class="text-lg font-semibold">1</span>
      <button id="popupPlus" class="text-purple-600 font-bold text-lg">+</button>
    </div>
    <div class="text-right">
      <span class="text-sm font-semibold">Total:</span>
      <p id="popupTotal" class="text-purple-700 font-bold text-lg">Rp 0</p>
    </div>
  </div>

  <div class="flex justify-end gap-2 mt-4">
    <button id="popupCancel" class="border border-gray-300 px-3 py-1 rounded-lg text-sm">Batal</button>
    <button id="popupAdd" class="bg-purple-600 text-white px-3 py-1 rounded-lg text-sm hover:bg-purple-700">Tambah ke Keranjang</button>
  </div>
</div>

<!-- ================= MINI CART (keranjang muncul dari kanan) ================= -->
<div id="cartSidebar" class="fixed top-0 right-0 w-80 h-full bg-white shadow-2xl transform translate-x-full transition-transform duration-300 z-50 overflow-y-auto">
  <div class="p-4 border-b flex justify-between items-center">
    <h2 class="text-xl font-bold text-purple-700">Keranjang</h2>
    <button id="closeCart" class="text-gray-500 hover:text-red-500 text-xl">&times;</button>
  </div>
  <div id="cartItems" class="p-4 space-y-4"></div>
  <div class="p-4 border-t">
    <div class="flex justify-between font-semibold text-lg mb-4">
      <span>Total:</span>
      <span id="cartTotal">Rp 0</span>
    </div>
    <button class="w-full bg-purple-600 text-white py-3 rounded-lg hover:bg-purple-700 transition">Checkout</button>
  </div>
</div>

<script>
// ==================== LOGIKA KERANJANG ====================
const cartBtn = document.querySelector('.fa-cart-shopping')?.parentElement;
const cartSidebar = document.getElementById('cartSidebar');
const closeCart = document.getElementById('closeCart');
const cartCount = document.getElementById('cart-count');
const cartItemsContainer = document.getElementById('cartItems');
const cartTotal = document.getElementById('cartTotal');

let cart = [];

// Buka & Tutup Sidebar Keranjang
if (cartBtn) {
  cartBtn.addEventListener('click', e => {
    e.preventDefault();
    cartSidebar.classList.remove('translate-x-full');
  });
}
if (closeCart) {
  closeCart.addEventListener('click', () => {
    cartSidebar.classList.add('translate-x-full');
  });
}

// Tombol "Pesan Sekarang"
document.querySelectorAll('.menu-item button').forEach(btn => {
  btn.addEventListener('click', e => {
    e.preventDefault();
    const card = e.target.closest('.menu-item');
    if (!card) return;
    const name = card.querySelector('h3')?.textContent || 'Menu';
    const priceText = card.querySelector('.text-purple-600')?.textContent || '0';
    const price = parseInt(priceText.replace(/[^\d]/g, '')) || 0;

    addToCart(name, price);
  });
});

function addToCart(name, price) {
  const existing = cart.find(item => item.name === name);
  if (existing) {
    existing.qty++;
  } else {
    cart.push({ name, price, qty: 1 });
  }
  updateCart();
}

function updateCart() {
  cartItemsContainer.innerHTML = '';
  let total = 0;
  cart.forEach((item, index) => {
    total += item.price * item.qty;

    const div = document.createElement('div');
    div.classList.add('flex','justify-between','items-center','border-b','pb-2');
    div.innerHTML = `
      <div>
        <p class="font-semibold">${item.name}</p>
        <p class="text-sm text-gray-500">Rp ${item.price.toLocaleString()}</p>
      </div>
      <div class="flex items-center gap-2">
        <button class="text-purple-600 font-bold" onclick="changeQty(${index}, -1)">-</button>
        <span>${item.qty}</span>
        <button class="text-purple-600 font-bold" onclick="changeQty(${index}, 1)">+</button>
      </div>
    `;
    cartItemsContainer.appendChild(div);
  });

  cartTotal.textContent = 'Rp ' + total.toLocaleString();
  if (cartCount) cartCount.textContent = cart.reduce((a,b) => a+b.qty, 0);
}

function changeQty(index, amount) {
  cart[index].qty += amount;
  if (cart[index].qty <= 0) cart.splice(index, 1);
  updateCart();
}
</script>

</body>
</html>
