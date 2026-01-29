<div id="cart-float">
  <button id="cart-toggle">
    <i class='bx bx-cart'></i>
    <span id="cart-count" class="cart-badge">0</span>
  </button>

  <div id="cart-panel">
    <div class="cart-header">
      <h5 class="title-cart">Cart.</h5>
      <i id="cart-close" class='bx bx-x iconClose'></i>
    </div>

    <div id="cart-float-body" class="cart-body">
      <p class="text-muted">Keranjang kosong</p>
    </div>

    <div class="cart-footer">
      <!-- <a href="/WebsiteKatalogPlants/pages/cart.php" class="btn-cart">
        Lihat Keranjang
      </a> -->
    </div>
  </div>
</div>

<footer>
  <div class="area-footer">
    <p class="text-footer">© 2026 Floratify. All rights reserved.</p>
  </div>
</footer>
<script src="/WebsiteKatalogPlants/asset/js/index.js"></script>
<?php if (isset($_SESSION['error']) && empty($_SESSION['just_logged_out'])): ?>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const modal = new bootstrap.Modal(document.getElementById('exampleModal'));
      modal.show();
    });
  </script>
<?php endif; ?>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    const modalEl = document.getElementById('exampleModal');
    if (!modalEl) return;

    modalEl.addEventListener('hidden.bs.modal', function() {
      fetch('/WebsiteKatalogPlants/functions/clear-error.php', {
        method: 'POST',
        headers: {
          'X-Requested-With': 'XMLHttpRequest'
        }
      }).catch(err => {
        console.error('Failed to clear session error:', err);
      });
    });
  });

</script>
<script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
<script src="https://unpkg.com/imagesloaded@5/imagesloaded.pkgd.min.js"></script>
<script src="https://unpkg.com/masonry-layout@4/dist/masonry.pkgd.min.js"></script>
<script>
  AOS.init();
  // Inisialisasi Masonry setelah semua gambar dimuat
  const grid = document.querySelector('.area-content-plant');
  imagesLoaded(grid, function() {
    new Masonry(grid, {
      itemSelector: '.card-plant',
      columnWidth: '.card-plant',
      percentPosition: true,
      gutter: 20
    });
  });
</script>

</body>

</html>