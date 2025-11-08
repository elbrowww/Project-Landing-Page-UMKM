// =======================
// DATA PRODUK DEFAULT
// =======================
localStorage.clear();
const defaultProducts = [
  {
    id: 1,
    title: 'Nasi Tumpeng Komplit',
    price: 350000,
    img: 'https://images.unsplash.com/photo-1543339343-7f212261a86b?auto=format&fit=crop&w=800&q=60'
  },
  {
    id: 2,
    title: 'Ayam Goreng Spesial',
    price: 25000,
    img: 'https://images.unsplash.com/photo-1626880053916-52c79f9a0c0e?auto=format&fit=crop&w=800&q=60'
  },
  {
    id: 3,
    title: 'Ayam Bakar Madu',
    price: 30000,
    img: 'https://images.unsplash.com/photo-1616892606622-c35d97d4c206?auto=format&fit=crop&w=800&q=60'
  },
  {
    id: 4,
    title: 'Ayam Geprek Pedas',
    price: 22000,
    img: 'https://images.unsplash.com/photo-1625944299837-142f9b2d8d8b?auto=format&fit=crop&w=800&q=60'
  },
  {
    id: 5,
    title: 'Sate Ayam Bumbu Kacang',
    price: 28000,
    img: 'https://images.unsplash.com/photo-1596765793466-22485559d3e8?auto=format&fit=crop&w=800&q=60'
  }
];

// =======================
// STATE
// =======================
let products = JSON.parse(localStorage.getItem('products')) || defaultProducts;
let cart = JSON.parse(localStorage.getItem('cart')) || {};

// =======================
// ELEMENTS
// =======================
const productsEl = document.getElementById('products');
const cartList = document.getElementById('cart-list');
const cartCount = document.getElementById('cart-count');
const cartTotalEl = document.getElementById('cart-total');

// =======================
// FORMAT UANG
// =======================
function money(n) {
  const num = typeof n === 'number' ? n : parseInt(n, 10);
  if (isNaN(num)) return 'Rp 0';
  return 'Rp ' + num.toLocaleString('id-ID');
}

// =======================
// RENDER PRODUK
// =======================
function renderProducts() {
  productsEl.innerHTML = '';
  products.forEach(p => {
    const div = document.createElement('div');
    div.className = 'card';
    div.innerHTML = `
      <img class="thumb" src="${p.img}" alt="${p.title}" />
      <div class="meta">
        <div class="title">${p.title}</div>
        <div class="muted">Pesanan spesial untuk Anda</div>
        <div class="price">${money(p.price)}</div>
        <div class="actions">
          <button class="btn" onclick="viewDetail(${p.id})">Lihat</button>
          <button class="primary" onclick="addToCart(${p.id})">Tambah</button>
        </div>
      </div>
    `;
    productsEl.appendChild(div);
  });
}

// =======================
// RENDER KERANJANG
// =======================
function renderCart() {
  cartList.innerHTML = '';
  const ids = Object.keys(cart);

  if (ids.length === 0) {
    cartList.innerHTML = '<div class="muted">Keranjang kosong, saatnya pesan makanan!</div>';
    cartCount.innerText = '0';
    cartTotalEl.innerText = money(0);
    return;
  }

  let total = 0;
  ids.forEach(idString => {
    const id = parseInt(idString, 10);
    const q = cart[idString];
    const p = products.find(x => x.id === id);
    if (!p) return;

    total += p.price * q;

    const el = document.createElement('div');
    el.className = 'cart-item';
    el.innerHTML = `
      <img src="${p.img}" style="width:56px;height:44px;border-radius:8px;object-fit:cover" alt="${p.title}">
      <div style="flex:1">
        <div style="font-weight:600">${p.title}</div>
        <div class="muted">${money(p.price)} × ${q} = <strong>${money(p.price * q)}</strong></div>
      </div>
      <div class="qty">
        <button class="btn" onclick="changeQty(${p.id}, -1)">-</button>
        <div style="min-width:24px;text-align:center">${q}</div>
        <button class="btn" onclick="changeQty(${p.id}, 1)">+</button>
      </div>
    `;
    cartList.appendChild(el);
  });

  cartCount.innerText = Object.values(cart).reduce((s, n) => s + n, 0);
  cartTotalEl.innerText = money(total);
}

// =======================
// SIMPAN KE LOCAL STORAGE
// =======================
function save() {
  localStorage.setItem('products', JSON.stringify(products));
  localStorage.setItem('cart', JSON.stringify(cart));
}

// =======================
// AKSI
// =======================
function addToCart(id) {
  const idString = String(id);
  const product = products.find(x => x.id === id);
  cart[idString] = (cart[idString] || 0) + 1;
  save();
  renderCart();

  if (product) {
    alert(`${product.title} ditambahkan ke keranjang!`);
  } else {
    alert(`Produk dengan ID ${id} ditambahkan ke keranjang!`);
  }
}

function changeQty(id, delta) {
  const idString = String(id);
  if (!cart[idString]) return;

  cart[idString] += delta;
  if (cart[idString] <= 0) {
    delete cart[idString];
  }

  save();
  renderCart();
}

function viewDetail(id) {
  const product = products.find(p => p.id === id);
  if (product) {
    alert(`Detail Produk:\n\n${product.title}\nHarga: ${money(product.price)}`);
  }
}

// =======================
// EVENT LISTENER
// =======================
document.addEventListener('DOMContentLoaded', () => {
  renderProducts();
  renderCart();

  document.getElementById('btn-clear').addEventListener('click', () => {
    localStorage.clear();
    location.reload();
  });

  document.getElementById('open-cart').addEventListener('click', () => {
    document.getElementById('cart-panel').classList.toggle('open');
  });

  document.getElementById('clear-cart').addEventListener('click', () => {
    cart = {};
    save();
    renderCart();
  });

  document.getElementById('checkout').addEventListener('click', () => {
    alert('Terima kasih sudah memesan! Pesanan Anda sedang diproses.');
    cart = {};
    save();
    renderCart();
  });
});