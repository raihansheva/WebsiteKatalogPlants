<footer>
  <div class="area-footer">
    <p class="text-footer">© 2026 Floratify. All rights reserved.</p>
  </div>
</footer>
<script src="asset/js/index.js"></script>
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