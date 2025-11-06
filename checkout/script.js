const produkSelect = document.getElementById('produk');
const hargaSpan = document.getElementById('harga');
const jumlahInput = document.getElementById('jumlah');
const plusBtn = document.getElementById('plus');
const minusBtn = document.getElementById('minus');

function updateHarga() {
  const selected = produkSelect.options[produkSelect.selectedIndex];
  const harga = selected.getAttribute('data-harga');
  hargaSpan.textContent = harga ? harga : 0;
}

plusBtn.addEventListener('click', () => {
  jumlahInput.value = parseInt(jumlahInput.value) + 1;
});

minusBtn.addEventListener('click', () => {
  if (parseInt(jumlahInput.value) > 1) jumlahInput.value -= 1;
});
