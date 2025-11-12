const menus = [
  {
    nama: "Fried Chicken",
    harga: 12000,
    deskripsi: "Ayam goreng renyah dengan bumbu khas Bu Mon.",
    img: "https://upload.wikimedia.org/wikipedia/commons/5/53/Fried_Chicken_-_KFC.jpg"
  },
  {
    nama: "Nasi Goreng",
    harga: 15000,
    deskripsi: "Nasi goreng spesial dengan telur dan ayam suwir.",
    img: "https://upload.wikimedia.org/wikipedia/commons/6/6f/Nasi_goreng.jpg"
  }
];

function renderMenu() {
  const container = document.getElementById('menu-container');
  container.innerHTML = '';
  menus.forEach((menu, index) => {
    container.innerHTML += `
      <div class="col-md-4 mb-4">
        <div class="card">
          <img src="${menu.img}" alt="${menu.nama}">
          <div class="card-body text-center">
            <h5 class="card-title">${menu.nama}</h5>
            <p class="text-muted small">${menu.deskripsi}</p>
            <span class="badge bg-success">Rp ${menu.harga.toLocaleString()}</span>
            <div class="mt-2">
              <button class="btn-icon bg-warning" onclick="editMenu(${index})"><i class="fa fa-pen"></i></button>
              <button class="btn-icon bg-danger" onclick="hapusMenu(${index})"><i class="fa fa-trash"></i></button>
            </div>
          </div>
        </div>
      </div>`;
  });
}

function tambahMenu() {
  const nama = document.getElementById('menuNama').value;
  const harga = parseInt(document.getElementById('menuHarga').value);
  const deskripsi = document.getElementById('menuDeskripsi').value;
  const fileInput = document.getElementById('menuGambar');
  let img = "https://via.placeholder.com/300";

  if (fileInput.files.length > 0) {
    const file = fileInput.files[0];
    img = URL.createObjectURL(file);
  }

  if (nama && harga && deskripsi) {
    menus.push({ nama, harga, deskripsi, img });
    renderMenu();
    const modal = bootstrap.Modal.getInstance(document.getElementById('tambahMenuModal'));
    modal.hide();
    document.getElementById('formTambahMenu').reset();
  } else {
    alert("Lengkapi semua data menu!");
  }
}

function editMenu(index) {
  const menu = menus[index];
  const nama = prompt("Edit nama menu:", menu.nama);
  const harga = prompt("Edit harga:", menu.harga);
  const deskripsi = prompt("Edit deskripsi:", menu.deskripsi);
  if (nama && harga && deskripsi) {
    menus[index].nama = nama;
    menus[index].harga = parseInt(harga);
    menus[index].deskripsi = deskripsi;
    renderMenu();
  }
}

function hapusMenu(index) {
  if (confirm("Hapus menu ini?")) {
    menus.splice(index, 1);
    renderMenu();
  }
}

// Navigasi antar halaman
document.querySelectorAll(".menu-link").forEach(link => {
  link.addEventListener("click", function(e){
    e.preventDefault();
    const target = this.dataset.page;
    document.querySelectorAll("#content-area > div").forEach(div => div.style.display = "none");
    document.getElementById(target + "-page").style.display = "block";
  });
});

// Grafik penjualan
function buatChart() {
  const ctx = document.getElementById("chartPenjualan").getContext("2d");
  new Chart(ctx, {
    type: "bar",
    data: {
      labels: ["Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu", "Minggu"],
      datasets: [{
        label: "Total Penjualan (Rp)",
        data: [120000, 150000, 100000, 180000, 200000, 220000, 170000],
        backgroundColor: "#0043c2"
      }]
    },
    options: {
      scales: {
        y: {beginAtZero: true}
      }
    }
  });
}

renderMenu();
buatChart();
