let cart = [];

function showMenuDetail(name, price, image, description, ingredients) {
  document.getElementById('modalTitle').textContent = name;
  document.getElementById('modalPrice').textContent = `Rp ${price.toLocaleString('id-ID')}`;
  document.getElementById('modalImage').src = image;
  document.getElementById('modalDescription').textContent = description;

  const ingredientsList = document.getElementById('modalIngredients');
  ingredientsList.innerHTML = '';
  ingredients.forEach(item => {
    const li = document.createElement('li');
    li.textContent = item;
    ingredientsList.appendChild(li);
  });

  document.getElementById('modalAddBtn').onclick = function() {
    addToCart(name, price);
    closeModal();
  };

  document.getElementById('menuModal').style.display = 'flex';
}

function closeModal() {
  document.getElementById('menuModal').style.display = 'none';
}

function addToCart(name, price) {
  const existing = cart.find(item => item.name === name);
  if (existing) {
    existing.quantity++;
  } else {
    cart.push({ name, price, quantity: 1 });
  }
  updateCart();
}

function removeFromCart(name) {
  cart = cart.filter(item => item.name !== name);
  updateCart();
}

function updateQuantity(name, change) {
  const item = cart.find(i => i.name === name);
  if (item) {
    item.quantity += change;
    if (item.quantity <= 0) {
      removeFromCart(name);
    }
    updateCart();
  }
}

function updateCart() {
  const cartItems = document.getElementById('cartItems');
  const cartTotal = document.getElementById('cartTotal');
  cartItems.innerHTML = '';

  let total = 0;

  cart.forEach(item => {
    const itemTotal = item.price * item.quantity;
    total += itemTotal;

    const div = document.createElement('div');
    div.classList.add('cart-item');
    div.innerHTML = `
      <span class="item-name">${item.name}</span>
      <div class="item-controls">
        <button class="quantity-btn" onclick="updateQuantity('${item.name}', -1)">-</button>
        <span>${item.quantity}</span>
        <button class="quantity-btn" onclick="updateQuantity('${item.name}', 1)">+</button>
        <button class="remove-btn" onclick="removeFromCart('${item.name}')">Hapus</button>
      </div>
      <span>Rp ${itemTotal.toLocaleString('id-ID')}</span>
    `;
    cartItems.appendChild(div);
  });

  cartTotal.textContent = `Total: Rp ${total.toLocaleString('id-ID')}`;
}
function scrollMenu(direction) {
  const container = document.querySelector('.menu-container');
  const scrollAmount = 300;

  if (direction === 'left') {
    container.scrollLeft -= scrollAmount;
  } else {
    container.scrollLeft += scrollAmount;
  }
}
function scrollMenu(direction) {
  const container = document.querySelector('.menu-container');
  const scrollAmount = 300;

  if (direction === 'left') {
    container.scrollLeft -= scrollAmount;
  } else {
    container.scrollLeft += scrollAmount;
  }
}

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

  // Geser ke kiri
  leftBtn.addEventListener('click', () => {
    menuContainer.scrollBy({
      left: -300, // jumlah pixel geser ke kiri
      behavior: 'smooth'
    });
  });

  // Geser ke kanan
  rightBtn.addEventListener('click', () => {
    menuContainer.scrollBy({
      left: 300, // jumlah pixel geser ke kanan
      behavior: 'smooth'
    });
  });
