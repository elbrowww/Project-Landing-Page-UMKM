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
        <a class="relative ml-4 flex items-center justify-center hover:scale-105 transition">
        <div class="bg-purple-100 p-2 rounded-full shadow-sm hover:bg-purple-200 transition">
          <i class="fa-solid fa-cart-shopping text-purple text-xl"></i>
        </div>
        <span id="cart-count"
              class="absolute -top-1 -right-1 bg-red-500 text-white text-[10px] font-bold px-1.5 rounded-full shadow">0</span>
      </a>
    </div>

    <!-- Tombol Menu Mobile -->
    <div class="flex items-center md:hidden space-x-4">
      <!-- Icon Keranjang untuk Mobile -->
      <a class="relative flex items-center justify-center hover:scale-105 transition">
        <div class="bg-purple-100 p-2 rounded-full shadow-sm hover:bg-purple-200 transition">
          <i class="fa-solid fa-cart-shopping text-purple text-xl"></i>
        </div>
        <span id="cart-count-mobile"
              class="absolute -top-1 -right-1 bg-red-500 text-white text-[10px] font-bold px-1.5 rounded-full shadow">0</span>
      </a>
      
      <button id="menuBtn" class="text-purple" aria-label="Buka menu">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M4 6h16M4 12h16M4 18h16" />
        </svg>
      </button>
    </div>
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
      <div class="row gy-4 flex-column-reverse flex-md-row float-animation fade-in -mt-57">
        <img src="asset/img/logo.png" 
        alt="Catering" 
        class="rounded-3xl shadow-2xl inline-block object-cover">
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
          <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-gradient-to-br from-purple-100 to-purple-300 flex items-center justify-center shadow-md">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-purple-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m1-6H8a2 2 0 00-2 2v14a2 2 0 002 2h8a2 2 0 002-2V6a2 2 0 00-2-2z" />
             </svg>
            </div>


          <h3 class="text-2xl font-bold mb-4">Bisa Custom Order</h3>
          <p class="text-gray-600">Menu dan porsi bisa disesuaikan dengan anggaran serta selera pelanggan.</p>
        </div>
        <div class="fade-in card-hover bg-gradient-to-br from-white to-gray-50 p-8 rounded-2xl text-center">
        <div class="flex justify-center mb-4">
          <svg xmlns="http://www.w3.org/2000/svg" class="w-14 h-14 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M5 3v4a2 2 0 002 2h2a2 2 0 002-2V3m4 0v4a2 2 0 002 2h2a2 2 0 002-2V3M5 13v4a2 2 0 002 2h2a2 2 0 002-2v-4m4 0v4a2 2 0 002 2h2a2 2 0 002-2v-4" />
          </svg>
        </div>
        <h3 class="text-2xl font-bold mb-4">Bahan Berkualitas</h3>
          <p class="text-gray-600">Menggunakan bahan segar pilihan untuk cita rasa terbaik.</p>
        </div>
       <div class="fade-in card-hover bg-gradient-to-br from-white to-gray-50 p-8 rounded-2xl text-center">
        <div class="flex justify-center mb-4">
          <svg xmlns="http://www.w3.org/2000/svg" class="w-14 h-14 text-purple-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.974a1 1 0 00.95.69h4.178c.969 0 1.371 1.24.588 1.81l-3.387 2.46a1 1 0 00-.364 1.118l1.287 3.974c.3.921-.755 1.688-1.538 1.118l-3.387-2.46a1 1 0 00-1.175 0l-3.387 2.46c-.783.57-1.838-.197-1.538-1.118l1.287-3.974a1 1 0 00-.364-1.118l-3.387-2.46c-.783-.57-.38-1.81.588-1.81h4.178a1 1 0 00.95-.69l1.286-3.974z" />
          </svg>
        </div>
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

      <div id="menuContainer" 
class="flex overflow-x-auto gap-6 scroll-smooth px-10 pb-4 no-scrollbar">
        <?php
        $query = mysqli_query($koneksi, "SELECT id_menu, nama_menu, stok_menu, deskripsi, harga_menu, gambar FROM menu");
        while ($data = mysqli_fetch_array($query)) {
        ?>
          
          <div class="menu-item fade-in bg-white rounded-2xl shadow-lg hover:shadow-2xl 
          hover:scale-[1.03] transition-all duration-300 overflow-hidden 
          min-w-[240px] max-w-[260px] md:min-w-[280px] md:max-w-[320px] flex-shrink-0 cursor-pointer mx-auto">



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
      <from method='POST'action='save_cart.php'></from>
  <button 
  class="add-to-cart bg-purple-600 text-white px-6 py-3 rounded-xl hover:bg-purple-700 transition disabled:bg-gray-400 disabled:cursor-not-allowed"
  data-id="<?php echo $data['id_menu']; ?>"
  data-name="<?php echo $data['nama_menu']; ?>"
  data-price="<?php echo $data['harga_menu']; ?>"
  data-image="asset/uploads/<?php echo $data['gambar']; ?>"
  data-stok="<?php echo $data['stok_menu']; ?>"
  <?php echo $data['stok_menu'] == 0 ? 'disabled' : ''; ?>>
  <?php echo $data['stok_menu'] == 0 ? 'Stok Habis' : 'Tambah Keranjang'; ?>
</button>
<?php if($data['stok_menu'] > 0): ?>
  <p class="text-xs text-gray-500 mt-2">Stok tersedia: <?php echo $data['stok_menu']; ?></p>
<?php else: ?>
  <p class="text-xs text-red-500 mt-2">Stok habis</p>
<?php endif; ?>
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
<!-- POPUP MENU TIDAK TERSEDIA -->
<div id="modalStok" class="fixed top-4 left-1/2 transform -translate-x-1/2 hidden z-50">
  <div class="bg-purple-600 text-white w-80 p-4 rounded-xl shadow-xl text-center animate-fade">
    <p id="modalStokText" class="text-sm font-medium">Menu tidak tersedia.</p>
  </div>
</div>

<!-- POPUP MENU BERHASIL -->
<div id="modalSuccess" class="fixed top-4 left-1/2 transform -translate-x-1/2 hidden z-50">
  <div class="bg-purple-600 text-white w-80 p-4 rounded-xl shadow-xl text-center animate-fade">
    <p id="modalSuccessText" class="text-sm font-medium">Berhasil ditambahkan ke keranjang.</p>
  </div>
</div>

<!-- POPUP KERANJANG KOSONG -->
<div id="modalKeranjangKosong" class="fixed top-4 left-1/2 transform -translate-x-1/2 hidden z-50">
  <div class="bg-red-600 text-white w-80 p-4 rounded-xl shadow-xl text-center animate-fade">
    <p class="text-sm font-medium">⚠️ Maaf, keranjang Anda masih kosong. Tidak dapat mengirim pesan sekarang!</p>
  </div>
</div>

  <!-- LAYANAN -->
<section id="layanan" class="py-20 bg-white">
    <div class="container mx-auto px-6">
        <h2 class="text-4xl font-bold text-center mb-16 gradient-text fade-in">
            Layanan Kami
        </h2>

        <div class="grid md:grid-cols-2 gap-12 items-center">

            <!-- Logo dengan efek hover -->
<div class="fade-in">
    
        <img src="asset/img/logo.png" alt="Chef Profesional"
             class="rounded-2xl shadow-2xl group-hover:shadow-purple-300 
                    group-hover:scale-105 transition-all duration-300 cursor-pointer">
</div>

            <!-- List Layanan -->
            <div class="fade-in space-y-8">

                <!-- Acara Pernikahan -->
                <div class="flex items-start gap-4">
                    <div class="bg-purple-100 text-purple-600 w-12 h-12 rounded-full 
                                flex items-center justify-center text-2xl flex-shrink-0">
                        <!-- gambar cincin  nikah -->
                        <svg width="26" height="26" fill="none" stroke="currentColor" stroke-width="2"
                             stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="9" cy="15" r="6"></circle>
                            <circle cx="17" cy="9" r="6"></circle>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold mb-2">Acara Pernikahan</h3>
                        <p class="text-gray-600">
                            Layanan catering lengkap untuk hari spesial Anda dengan berbagai pilihan menu
                        </p>
                    </div>
                </div>

                <!-- Acara Kantor -->
                <div class="flex items-start gap-4">
                    <div class="bg-purple-100 text-purple-600 w-12 h-12 rounded-full 
                                flex items-center justify-center text-2xl flex-shrink-0">
                        <!-- gambar tas kerja -->
                        <svg width="26" height="26" fill="none" stroke="currentColor" stroke-width="2"
                             stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="7" width="18" height="14" rx="2" ry="2"></rect>
                            <path d="M8 7V5a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold mb-2">Acara Kantor</h3>
                        <p class="text-gray-600">
                            Solusi catering untuk meeting, seminar, dan acara perusahaan
                        </p>
                    </div>
                </div>

                <!-- Acara Ulang Tahun -->
                <div class="flex items-start gap-4">
                    <div class="bg-purple-100 text-purple-600 w-12 h-12 rounded-full 
                                flex items-center justify-center text-2xl flex-shrink-0">
                        <!-- balon -->
                        <svg width="26" height="26" fill="none" stroke="currentColor" stroke-width="2"
                             stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 2C8 2 5 5 5 9c0 5 7 11 7 11s7-6 7-11c0-4-3-7-7-7z"></path>
                            <line x1="12" y1="22" x2="12" y2="15"></line>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold mb-2">Acara Ulang Tahun</h3>
                        <p class="text-gray-600">
                            Paket spesial untuk merayakan momen berharga bersama keluarga
                        </p>
                    </div>
                </div>

                <!-- Acara Sekolah -->
                <div class="flex items-start gap-4">
                    <div class="bg-purple-100 text-purple-600 w-12 h-12 rounded-full 
                                flex items-center justify-center text-2xl flex-shrink-0">
                        <!-- bangunan -->
                        <svg width="26" height="26" fill="none" stroke="currentColor" stroke-width="2"
                             stroke-linecap="round" stroke-linejoin="round">
                            <path d="M3 12l9-9 9 9"></path>
                            <path d="M9 21V12h6v9"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold mb-2">Acara Sekolah</h3>
                        <p class="text-gray-600">
                            Catering untuk acara sekolah, wisuda, dan kegiatan pendidikan
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>



<?php
// Ambil testimoni dari database
$query_testimoni = "SELECT * FROM testimoni ORDER BY created_at DESC";
$result_testimoni = $koneksi->query($query_testimoni);
?>

<section id="testimoni" class="py-20 gradient-bg">
    <div class="container mx-auto px-6">
        <h2 class="text-4xl font-bold text-center mb-4 text-white fade-in">Apa Kata Mereka?</h2>
        <p class="text-center text-purple-100 mb-16 fade-in">Testimoni pelanggan yang puas dengan layanan kami</p>

        <?php if ($result_testimoni->num_rows > 0): ?>
        <div class="relative">
            <!-- Tombol Scroll KIRI untuk Testimoni -->
            <button id="btnTestimoniLeft" onclick="scrollTestimoniLeft()" class="absolute left-0 top-1/2 -translate-y-1/2 bg-purple-600 text-white p-3 rounded-full shadow-md hover:bg-purple-700 z-10 transition">
                ◀
            </button>

            <div class="overflow-x-auto overflow-y-hidden px-4 md:px-12 no-scrollbar">
              <div id="testimoniSlider" class="
             flex 
             justify-center md:justify-start 
             gap-4 md:gap-6 
             transition-transform duration-500 ease-in-out 
             mx-auto
             w-max
              ">


                    <?php while ($row = $result_testimoni->fetch_assoc()): ?>
                        <?php
                            $icon = "👤";
                            $bg = "bg-purple-200";
                        ?>

                        <div class="fade-in bg-white p-6 md:p-8 rounded-2xl shadow-xl card-hover 
                        min-w-[260px] max-w-[260px] 
                        md:min-w-[320px] md:max-w-[320px] 
                        flex-shrink-0 mx-auto">

                            <div class="flex items-center mb-4">
                                <div class="w-12 h-12 <?= $bg ?> rounded-full flex items-center justify-center text-xl mr-4">
                                    <?= $icon ?>
                                </div>
                                <div>
                                    <h4 class="font-bold"><?= htmlspecialchars($row['nama']) ?></h4>
                                    <!-- HAPUS BAGIAN STARS YANG ERROR -->
                                </div>
                            </div>
                            <p class="text-gray-600">
                                "<?= htmlspecialchars($row['pesan']) ?>"
                            </p>
                        </div>

                    <?php endwhile; ?>

                </div>
            </div>

            <!-- Tombol Scroll KANAN untuk Testimoni -->
            <button id="btnTestimoniRight" onclick="scrollTestimoniRight()" class="absolute right-0 top-1/2 -translate-y-1/2 bg-purple-600 text-white p-3 rounded-full shadow-md hover:bg-purple-700 z-10 transition">
                ▶
            </button>
        </div>

        <?php else: ?>
        <!-- Bagian ini TIDAK akan ditampilkan jika ada testimoni -->
        <div class="w-full text-center">
            <p class="text-white text-lg">Belum ada testimoni.</p>
        </div>
        <?php endif; ?>

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
                      <!--tlepon-->
                        <div class="w-12 h-12 bg-purple-100 flex items-center justify-center rounded-xl">
                           <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 5a2 2 0 012-2h2l3 7-3 2c1.5 2.5 3.5 4.5 6 6l2-3 7 3v2a2 2 0 01-2 2h-1C8 20 4 16 4 9V7a2 2 0 01-1-2z" />
                           </svg>
                         </div>

                        <div>
                            <p class="font-semibold">Telepon/WhatsApp</p>
                            <a href="https://wa.me/6285236596617" target="_blank" class="text-gray-600 hover:text-gray-800 font-medium">+62 852-3659-6617</a>
                        </div>
                    </div>

                    <!--email-->
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-purple-100 flex items-center justify-center rounded-xl">
                          <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                               d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8m-18 8h18a2 2 0 002-2V6a2 2 0 00-2-2H3a2 2 0 00-2 2v8a2 2 0 002 2z" />
                           </svg>
                        </div>

                        <div>
                            <p class="font-semibold">Email</p>
                            <p class="text-gray-600">dwalan@gmail.com</p>
                        </div>
                    </div>
                    
                    <!--alamat-->
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-purple-100 flex items-center justify-center rounded-xl">
                          <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 11a4 4 0 100-8 4 4 0 000 8zm0 0c-4.418 0-8 3.134-8 7v1h16v-1c0-3.866-3.582-7-8-7z" />
                          </svg>
                         </div>

                        <div>
                            <p class="font-semibold">Alamat</p>
                            <p class="text-gray-600">Merjoyo, Purwosari,Kediri,Jawa Timur</p>
                        </div>
                    </div>
                    <!--jam Operasional-->
                    <div class="flex items-center gap-4">
                       <div class="w-12 h-12 bg-purple-100 flex items-center justify-center rounded-xl">
                          <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                           <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                               d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                          </svg>
                        </div>

                        <div>
                            <p class="font-semibold">Jam Operasional</p>
                            <p class="text-gray-600">Senin - Minggu: 08.00 - 20.00 WIB</p>
                        </div>
                    </div>
                </div>
            </div>
       <div class="fade-in">
    <div class="bg-white border border-gray-300 rounded-2xl p-10">

        <h3 class="text-2xl font-bold mb-6 text-center text-gray-800">Kirim Pesan</h3>

        <form id="contactForm" class="space-y-6 max-w-4xl mx-auto">

            <!-- 2 KOLOM -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <!-- Nama -->
                <div>
                    <label class="block text-sm font-semibold mb-1">Nama Lengkap</label>
                    <input type="text" id="nama" name="nama_pelanggan" required class="w-full px-4 py-3 rounded-xl border border-gray-400 bg-white focus:ring-2 focus:ring-gray-300 focus:border-gray-500 outline-none"placeholder="Masukkan nama Anda">
                </div>

                <!-- Email -->
                <div>
                    <label class="block text-sm font-semibold mb-1">Email</label>
                    <input type="email" id="email" name="email_pelanggan" required class="w-full px-4 py-3 rounded-xl border border-gray-400 bg-white focus:ring-2 focus:ring-gray-300 focus:border-gray-500 outline-none"placeholder="email@contoh.com">
                </div>
            </div>

            <!-- GRID 1 KOLOM -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <!-- No Telepon -->
            <div class="md:col-span-2">
               <label class="block text-sm font-semibold mb-2">No. Telepon</label>
              <input type="tel" id="notelp" name="notelp_pelanggan" required class="w-full px-4 py-3 rounded-xl border border-gray-400 bg-white  focus:ring-2 focus:ring-gray-300 focus:border-gray-500 outline-none" placeholder="+62 812-xxxx-xxxx">
            </div>
            </div>

            <!-- Pesan-->
            <div>
                <label class="block text-sm font-semibold mb-1">Pesan</label>
                <textarea 
                    id="pesan" name="isi_pesan" rows="5" required
                    class="w-full px-4 py-3 rounded-xl border border-gray-400 bg-white 
                    focus:ring-2 focus:ring-gray-300 focus:border-gray-500 outline-none"
                    placeholder="Ceritakan kebutuhan acara Anda..."></textarea>
            </div>

            <!-- Tombol -->
            <div class="flex justify-center">
                <button 
                    type="submit"
                    class="px-10 py-3 rounded-lg border border-purple-400 text-purple-400 font-semibold
                    hover:bg-purple-400 hover:text-black transition">
                    Kirim Pesan
                </button>
            </div>

        </form>

    </div>
</div>


</section>

<script>

  // Debug: Override alert untuk menemukan sumbernya
const originalAlert = window.alert;
window.alert = function(msg) {
    console.log('Alert dipanggil dari:', new Error().stack);
    console.log('Pesan alert:', msg);

};

// Script untuk mengirim form ke database
document.getElementById('contactForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    // Nonaktifkan tombol submit untuk mencegah double submit
    const submitBtn = this.querySelector('button[type="submit"]');
    submitBtn.disabled = true;
    submitBtn.textContent = 'Mengirim...';
    
    // Ambil nilai dari form
    const nama = document.getElementById('nama').value;
    const email = document.getElementById('email').value;
    const notelp = document.getElementById('notelp').value;
    const pesan = document.getElementById('pesan').value;
    
    // Kirim ke database
    try {
        const formData = new FormData();
        formData.append('nama_pelanggan', nama);
        formData.append('email_pelanggan', email);
        formData.append('notelp_pelanggan', notelp);
        formData.append('isi_pesan', pesan);
        
        const response = await fetch('simpan_pesan.php', {
            method: 'POST',
            body: formData
        });
        
        const result = await response.json();
        
        if (result.success) {
            // Reset form
            this.reset();
            
            // Tampilkan pesan sukses (ganti alert dengan custom notification)
            showNotification('Pesan berhasil dikirim!', 'success');
        } else {
            showNotification('Gagal mengirim pesan: ' + result.message, 'error');
        }
    } catch (error) {
        console.error('Error:', error);
        showNotification('Terjadi kesalahan saat mengirim pesan', 'error');
    } finally {
        // Aktifkan kembali tombol submit
        submitBtn.disabled = false;
        submitBtn.textContent = 'Kirim Pesan';
    }
});

// Fungsi untuk menampilkan notifikasi custom (bukan alert)
function showNotification(message, type) {
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 p-4 rounded-lg shadow-lg z-50 transform transition-all duration-300 ${
        type === 'success' ? 'bg-green-500' : 'bg-red-500'
    } text-white`;
    notification.textContent = message;
    
    document.body.appendChild(notification);
    
    // Animasi muncul
    setTimeout(() => {
        notification.style.transform = 'translateX(0)';
    }, 10);
    
    // Hapus setelah 3 detik
    setTimeout(() => {
        notification.style.transform = 'translateX(400px)';
        setTimeout(() => {
            notification.remove();
        }, 300);
    }, 3000);
}
</script>

    <!--lokasi kami-->
<section id="lokasi" class="py-20 bg-gray-50">
  <div class="container mx-auto px-6">
    <h2 class="text-4xl font-bold text-center mb-12 gradient-text fade-in">LOKASI KAMI</h2>
    <div class="grid md:grid-cols-2 gap-8 items-center">

      <!--map - menggunakan koordinat exact dari screenshot-->
      <div class="fade-in">
        <div class="overflow-hidden rounded-2xl shadow-2xl border-4 border-purple-200">
          <iframe
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3953.083333333333!2d112.119213!3d-7.617010!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zN8KwMzcnMDEuMiJTIDExMsKwMDcnMDkuMiJF!5e0!3m2!1sid!2sid!4v1700000000000!5m2!1sid!2sid"
            width="100%"
            height="400"
            style="border:0;"
            allowfullscreen=""
            loading="lazy"
            referrerpolicy="no-referrer-when-downgrade"
            title="Lokasi Dapur Buk Mon di Merjoyo, Kediri">
          </iframe>
        </div>
      </div>
      
      <!--info lokasi-->
      <div class="fade-in space-y-6 text-center md:text-left">
        <h3 class="text-2xl font-bold text-purple-700">Alamat Kami</h3>

        <p class="text-gray-700 text-lg leading-relaxed">
          📍<strong>DAPUR BUK MON</strong><br>
          94M9+SWM MerjoyoKabupaten Kediri, Jawa Timur
        <br>
         
        </p>
        
        <div class="space-y-4">
          <div class="flex items-center text-gray-600">
            <svg class="w-5 h-5 mr-3 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
              <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
            </svg>
            <span>Lokasi: Merjoyo, Kabupaten Kediri</span>
          </div>
          
          <div class="flex items-center text-gray-600">
            <svg class="w-5 h-5 mr-3 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
              <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
            </svg>
            <span>Buka setiap hari 08:00 - 22:00 WIB</span>
          </div>
        </div>

        <div class="flex flex-col items-center md:items-start space-y-4">
          <div class="text-center">
            <p class="text-sm text-gray-600 mb-2">Scan QR Code untuk akses cepat</p>
            <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=https://goo.gl/maps/7i99mAiHYk2v7FnY8?g_st=aw"
              alt="QR Code lokasi Dapur Buk Mon Merjoyo Kediri"
              class="w-32 h-32 border-4 border-purple-300 rounded-xl shadow-md hover:scale-105 transition mx-auto">
          </div>
          
          <a href="https://goo.gl/maps/7i99mAiHYk2v7FnY8?g_st=aw"
            target="_blank"
            class="inline-flex items-center justify-center gradient-bg text-white px-6 py-3 rounded-full font-semibold hover:opacity-90 transition pulse-btn">
            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
              <path fill-rule="evenodd" d="M12.586 4.586a2 2 0 112.828 2.828l-3 3a2 2 0 01-2.828 0 1 1 0 00-1.414 1.414 4 4 0 005.656 0l3-3a4 4 0 00-5.656-5.656l-1.5 1.5a1 1 0 101.414 1.414l1.5-1.5zm-5 5a2 2 0 012.828 0 1 1 0 101.414-1.414 4 4 0 00-5.656 0l-3 3a4 4 0 105.656 5.656l1.5-1.5a1 1 0 10-1.414-1.414l-1.5 1.5a2 2 0 11-2.828-2.828l3-3z" clip-rule="evenodd"/>
            </svg>
            BUKA DI GOOGLE MAPS
          </a>
        </div>
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
      <p class="text-sm opacity-90">
  <a href="Admin/login.php" class="hover:underline hover:text-sky-200 transition">
    © 2025 Dapur Buk Mon. All rights reserved.
  </a>
</p>

    </div>
  </footer>

  <!-- Tombol WhatsApp Mengambang -->
  <a href="https://wa.me/6285236596617" target="_blank" class="wa-float" aria-label="Chat WhatsApp">
    
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

  
// =========================
// FUNGSI KERANJANG BELANJA
// =========================

// Ambil elemen
const cartIcon = document.querySelector('.fa-cart-shopping');
const cartCount = document.getElementById('cart-count');
const cartCountMobile = document.getElementById('cart-count-mobile');
let cart =  [];


// POPUP / SIDEBAR KERANJANG
const cartSidebar = document.createElement('div');
cartSidebar.id = "cartSidebar";
cartSidebar.className = "fixed top-0 right-0 w-80 h-full bg-white shadow-2xl transform translate-x-full transition-transform duration-300 z-50 overflow-y-auto";

cartSidebar.innerHTML = `
  <div class="p-4 border-b flex justify-between items-center bg-purple-600 text-white">
    <h2 class="text-xl font-bold">Keranjang</h2>
    <button id="closeCart" class="text-white text-2xl">&times;</button>
  </div>
  <div id="cart-items" class="p-4 space-y-4"></div>
  <div class="p-4 border-t">
    <p class="font-semibold">Total: <span id="cart-total">Rp 0</span></p>
    <button id="checkout-btn" class="w-full bg-purple-600 text-white mt-4 py-2 rounded-lg font-semibold hover:bg-purple-700 disabled:bg-gray-400">Pesan Sekarang</button>
    <button id="kosongKeranjang-btn" class="w-full bg-red-600 text-white mt-4 py-2 rounded-lg font-semibold hover:bg-red-700 ">Kosongkan Keranjang</button>
  </div>
`;
document.body.appendChild(cartSidebar);

// Tombol buka/tutup keranjang - untuk desktop
cartIcon.addEventListener('click', () => {
  cartSidebar.classList.remove('translate-x-full');
});

// Tombol buka/tutup keranjang - untuk mobile
document.querySelectorAll('.fa-cart-shopping').forEach(icon => {
  icon.addEventListener('click', () => {
    cartSidebar.classList.remove('translate-x-full');
  });
});

document.getElementById('closeCart').addEventListener('click', () => {
  cartSidebar.classList.add('translate-x-full');
});

// TAMBAH MENU KE KERANJANG

// Ambil menu dari database
document.querySelectorAll('.add-to-cart').forEach(button => {
  button.addEventListener('click', async () => {

    const id_menu = button.dataset.id;
    const nama_menu = button.dataset.name;
    const harga_satuan = parseInt(button.dataset.price);
    const image = button.dataset.image;

    // CEK STOK KE DATABASE
    const response = await fetch(`check_stock.php?id_menu=${id_menu}`);
    const stockData = await response.json();

    if (!stockData.success) {
      showModalStok("Gagal mengambil stok menu.");
      return;
    }

    const stokTersedia = stockData.stok;

    //CARI ITEM DI CART
    const existingItem = cart.find(item => item.id_menu === id_menu);

    const jumlahSetelahTambah = existingItem ? existingItem.jumlah + 1 : 1;

    // Cek stok sebelum menambah ke keranjang
if (jumlahSetelahTambah > stokTersedia) {
  showModalStok(`Stok tidak mencukupi! Stok tersedia: ${stokTersedia}`);
  return;
}

    //LANJUT TAMBAH CART
    if (existingItem) {
      existingItem.jumlah++;
    } else {
      cart.push({ id_menu, nama_menu, harga_satuan, image, jumlah: 1 });
    }

    saveCart();
    renderCart();
// Tampilkan pop-up sukses
showModalSuccess(`${nama_menu} berhasil ditambahkan ke keranjang.`);
  });
});

// Increase decrease setelah render
function setupQtyButtons() {
  document.querySelectorAll('.increase').forEach(btn => {
    btn.addEventListener('click', async () => {
      const index = btn.dataset.index;
      const item = cart[index];

      // cek stok
      const response = await fetch(`check_stock.php?id_menu=${item.id_menu}`);
      const stockData = await response.json();
      const stokTersedia = stockData.stok;

      if (item.jumlah + 1 > stokTersedia) {
        alert(`Stok tidak cukup! Stok hanya ${stokTersedia}`);
        return;
      }

      item.jumlah++;
      saveCart();
      renderCart();
    });
  });

  document.querySelectorAll('.decrease').forEach(btn => {
    btn.addEventListener('click', () => {
      const index = btn.dataset.index;

      if (cart[index].jumlah > 1) {
        cart[index].jumlah--;
      } else {
        cart.splice(index, 1);
      }

      saveCart();
      renderCart();
    });
  });
}

// Simpan database
function saveCart() {
  localStorage.setItem("cart", JSON.stringify(cart));
  fetch('save_cart.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({ cart: cart, id_penjualan_temp: "TEMP001" })
  })
  .then(res => res.json())
  .then(data => console.log(data));

  cart = cart.map(item => ({
    ...item,
    id_menu: String(item.id_menu)
  }));
}

document.addEventListener("DOMContentLoaded", () => {
  cart = JSON.parse(localStorage.getItem("cart")) || [];
  renderCart();
});


// Render ulang
function renderCart() {
  const container = document.getElementById('cart-items');
  const totalElement = document.getElementById('cart-total');
  const checkoutBtn = document.getElementById('checkout-btn');

  container.innerHTML = '';
  let total = 0;
  let totalItems = 0;

  cart.forEach((item, index) => {
    const subtotal = item.harga_satuan * item.jumlah;
    total += subtotal;
    totalItems += item.jumlah;

    const itemDiv = document.createElement('div');
    itemDiv.className = 'flex items-center justify-between border-b pb-2';
    itemDiv.innerHTML = `
      <div class="flex items-center gap-3">
        <img src="${item.image}" alt="${item.nama_menu}" class="w-12 h-12 rounded-lg object-cover">
        <div>
          <p class="font-semibold">${item.nama_menu}</p>
          <p class="text-sm text-gray-500">Rp ${item.harga_satuan.toLocaleString('id-ID')}</p>
        </div>
      </div>
      <div class="flex items-center gap-2">
        <button class="decrease bg-gray-200 px-2 rounded" data-index="${index}">-</button>
        <span class="font-semibold">${item.jumlah}</span>
        <button class="increase bg-gray-200 px-2 rounded" data-index="${index}">+</button>
      </div>
    `;
    container.appendChild(itemDiv);
  });

  totalElement.textContent = `Rp ${total.toLocaleString('id-ID')}`;
  cartCount.textContent = totalItems;
  cartCountMobile.textContent = totalItems;
  // checkoutBtn.disabled = cart.length === 0;

  setupQtyButtons();
}

// Render awal
renderCart();



// Checkout
document.addEventListener('click', (e) => {
  if (e.target.id === 'checkout-btn') {
    if (cart.length === 0) {
      // Tampilkan pop-up keranjang kosong
      showModalKeranjangKosong();
    } else {
      const total = cart.reduce((sum, item) => sum + item.harga_satuan * item.jumlah, 0);
      window.location.href = "checkout/checkout.php";
    }
  }
});

// Kosongkan Keranjang
document.addEventListener('click', (e) => {
  if (e.target.id === 'kosongKeranjang-btn') {
  cart = []; // kosongkan array
  localStorage.removeItem('cart'); // hapus dari localStorage

  renderCart(); 
}
});

renderCart(); 
function showModalStok(pesan) {
  const modal = document.getElementById('modalStok');
  document.getElementById('modalStokText').innerText = pesan;

  modal.classList.remove('hidden');

  // Auto close setelah 2.5 detik
  setTimeout(() => {
    modal.classList.add('hidden');
  }, 2500);
}
function showModalSuccess(pesan) {
  const m = document.getElementById('modalSuccess');
  document.getElementById('modalSuccessText').innerText = pesan;

  m.classList.remove('hidden');

  setTimeout(() => {
    m.classList.add('hidden');  
  }, 2000);
}

// Fungsi untuk menampilkan pop-up keranjang kosong
function showModalKeranjangKosong() {
  const modal = document.getElementById('modalKeranjangKosong');
  
  modal.classList.remove('hidden');

  // Auto close setelah 3 detik
  setTimeout(() => {
    modal.classList.add('hidden');
  }, 3000);
}
</script>