


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

</body>

</html>