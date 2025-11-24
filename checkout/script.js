let cart = [];

// 🔽 Tambahkan mulai dari sini
function showRekeningInfo() {
  const rekeningSelect = document.getElementById('rekening');
  const rekeningInfo = document.getElementById('rekeningInfo');
  const bank = rekeningSelect.value;

  let info = '';
  if (bank === 'bri') {
    info = 'BRI – 1234-5678-9012 a.n. Dapur Bu Mon';
  } else if (bank === 'bca') {
    info = 'BCA – 9876-5432-1098 a.n. Dapur Bu Mon';
  } else if (bank === 'bni') {
    info = 'BNI – 1122-3344-5566 a.n. Dapur Bu Mon';
  } else if (bank === 'mandiri') {
    info = 'Mandiri – 2233-4455-6677 a.n. Dapur Bu Mon';
  }

  rekeningInfo.textContent = info;
}
  const menuContainer = document.querySelector('.menu-container');
  const leftBtn = document.querySelector('.scroll-btn.left');
  const rightBtn = document.querySelector('.scroll-btn.right');

  function checkout() {
  const nama = document.getElementById("nama").value;
  const telp = document.getElementById("telp").value;
  const alamat = document.getElementById("alamat").value;

  if (!nama || !telp || !alamat) {
    alert("Harap lengkapi semua data pemesan sebelum checkout!");
    return;
  }

  // Lanjutkan proses checkout
  alert(`Terima kasih ${nama}! Pesananmu sedang diproses.`);
}
  
  const metode = document.getElementById("metodePembayaran");
  const rekeningTransfer = document.getElementById("rekeningTransfer");

  metode.addEventListener("change", function() {
    if (this.value === "transfer") {
      rekeningTransfer.style.display = "block";
    } else {
      rekeningTransfer.style.display = "none";
    }
  });

  function checkout() {
  // Ambil data dari form
  const nama = document.getElementById('nama').value.trim();
  const telp = document.getElementById('telp').value.trim();
  const alamat = document.getElementById('alamat').value.trim();
  const rekening = document.getElementById('rekening').value;

  // Validasi input
  if (!nama || !telp || !alamat || !rekening) {
    alert("⚠️ Harap lengkapi semua data pemesan sebelum checkout!");
    return;
  }

  // Pop-up sukses
  alert("✅ Pesanan sedang diproses!\nTerima kasih telah memesan di Dapur Bu Mon ");

  // Hapus keranjang setelah checkout
  localStorage.removeItem("cart");

  // Tunggu 2 detik, lalu kembali ke landing page
  setTimeout(() => {
    window.location.href = "../index.php"; // Ganti dengan halaman utama kamu
  }, 2000);
}