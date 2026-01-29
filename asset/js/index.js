function loadFloatCart() {
  fetch('/WebsiteKatalogPlants/functions/orders/cartFloat.php')
    .then(res => res.json())
    .then(data => {
      const body = document.getElementById('cart-float-body');
      const countEl = document.getElementById('cart-count');
      if (!body || !countEl) return;

      body.innerHTML = data.html;

      const count = parseInt(data.count);

      if (count > 0) {
        countEl.textContent = count;
        countEl.style.display = 'flex'; // atau inline-flex
      } else {
        countEl.style.display = 'none';
      }
    });
}


document.addEventListener('DOMContentLoaded', () => {
  loadFloatCart();

  document.getElementById('cart-toggle')?.addEventListener('click', () => {
    document.getElementById('cart-panel').classList.toggle('active');
  });

  document.getElementById('cart-close')?.addEventListener('click', () => {
    document.getElementById('cart-panel').classList.remove('active');
  });
});

document.addEventListener('cartUpdated', () => {
  loadFloatCart(); // 🔥 REALTIME CROSS FILE
});
