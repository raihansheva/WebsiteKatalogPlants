<?php

$page_css = 'plant.css';
include 'layout/header.php';
include '../database/koneksi.php';

$sqlT = "SELECT tanaman.*, kategori.nama_kategori 
        FROM tanaman
        JOIN kategori ON tanaman.kategori_id = kategori.id order BY tanaman.id ASC";
$resultT = $koneksi->query($sqlT);

$isLogin = isset($_SESSION['user_id']);
// $timeAnimate = [1000, 1300, 1200, 3000, 2000, 3000, 2200];
// $time = $timeAnimate[rand(0, count($timeAnimate) - 1)];
?>

<div class="header-plant-page">
  <h1 class="title-plant-page">Plants.</h1>
</div>
<section>
  <div class="area-plant-page">
    <div class="area-content-plant">
      <?php if ($resultT && $resultT->num_rows > 0) { ?>
        <?php while ($row = $resultT->fetch_assoc()): ?>
          <div class="card-plant">
            <div class="area-image-plant">
              <button
                class="button-cart-order"
                data-tanaman-id="<?= $row['id'] ?>"
                <?= !$isLogin ? 'data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" data-bs-title="Harus login untuk menambahkan ke keranjang" disabled' : '' ?>>
                <p>Add to cart</p>
              </button>
              <img src="../uploads/<?= $row['foto'] ?>" class="image-plant" alt="">
            </div>
            <div class="area-name-plant">
              <div class="area-name-kiri">
                <div class="area-top-name">
                  <div class="breads-family-order">
                    <p class="text-breads-order"><?= $row['nama_kategori'] ?></p>
                  </div>
                  <div class="button-status <?= $row['status'] == 'tersedia' ? 'available' : 'sold' ?>" data-status-id="<?= $row['id']; ?>">
                    <p class="status-plant <?= $row['status'] == 'tersedia' ? 'available' : 'sold' ?>"><?= $row['status'] ?></p>
                  </div>
                </div>
                <p class="name-plant-order"><?= $row['nama_tanaman'] ?></p>
                <div class="area-price-in">
                  <p class="price-plant">Rp <?= number_format($row['harga'], 0, ',', '.') ?></p>
                  <span>|</span>
                  <p class="stok-plant">Stok: <span class="stok-value" data-id="<?= $row['id']; ?>">
                      <?= $row['stok']; ?>
                    </span></p>
                </div>
              </div>
            </div>
          </div>
        <?php endwhile; ?>
      <?php } else { ?>
        <div class="area-not-found-plant">
          <div class="content-not-found-plant">
            <h2>Mohon Maaf Data Tanaman Belum Ada.</h2>
          </div>
        </div>
      <?php } ?>
    </div>
  </div>
</section>
<div class="toast-container position-fixed bottom-0 end-0 p-3">
  <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="toast-header">

      <strong class="me-auto">Floratify.</strong>
      <!-- <small></small> -->
      <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
    <div class="toast-body">
      <span id="textToast"></span>
    </div>
  </div>
</div>
<script>
  const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
  const tooltipList = [...tooltipTriggerList].map(el => new bootstrap.Tooltip(el))

  // const cartToastEl = document.getElementById('cartToast');

  const toastLiveExample = document.getElementById('liveToast');
  const cartToast = new bootstrap.Toast(toastLiveExample, {
    delay: 2000
  });

  document.querySelectorAll('.button-cart-order').forEach(button => {
    button.addEventListener('click', function() {
      const tanamanId = this.dataset.tanamanId;

      fetch('../functions/orders/tambahKeranjang.php', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
          },
          body: `tanaman_id=${tanamanId}`
        })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            const stok = document.querySelector(`.stok-value[data-id="${tanamanId}"]`);
            if (stok) stok.textContent = data.new_stok;

            const statusBox = document.querySelector(`.button-status[data-status-id="${tanamanId}"]`);
            const statusText = statusBox.querySelector('.status-plant');
            if (data.new_stok <= 0) {
              statusBox.classList.remove('available');
              statusBox.classList.add('sold');
              statusText.classList.remove('available');
              statusText.classList.add('sold');
              statusText.textContent = 'habis';
            } else {
              statusBox.classList.remove('sold');
              statusBox.classList.add('available');
              statusText.classList.remove('sold');
              statusText.classList.add('available');
              statusText.textContent = 'tersedia';
            }
            const textToast = document.getElementById('textToast');
            textToast.textContent = "✅ Berhasil ditambahkan ke keranjang";
            cartToast.show();
          } else {
            const textToast = document.getElementById('textToast');
            textToast.textContent = data.message;
            cartToast.show();
          }
        })
        .catch(() => {
          alert('Terjadi kesalahan koneksi');
        });
    });
  });
</script>




<?php include 'layout/footer.php'; ?>