<?php

$page_css = 'plant.css';
include 'layout/header.php';
include '../database/koneksi.php';

$sqlT = "SELECT tanaman.*, kategori.nama_kategori 
        FROM tanaman
        JOIN kategori ON tanaman.kategori_id = kategori.id";
$resultT = $koneksi->query($sqlT);

$isLogin = isset($_SESSION['user_id']);
?>

<section>
  <div class="area-plant-page">
    <div class="header-plant-page">
      <h1 class="title-plant-page">Plant Gallery</h1>
    </div>
    <div class="area-content-plant">
      <?php if ($resultT && $resultT->num_rows > 0) { ?>
        <?php while ($row = $resultT->fetch_assoc()): ?>
          <div class="card-plant" data-bs-toggle="modal"
            data-bs-target="#exampleModalPlant<?= $row['id'] ?>">
            <div class="area-image-plant">
              <img src="../uploads/<?= $row['foto'] ?>" class="image-plant" alt="">
            </div>

          </div>
          <div
            class="modal fade"
            id="exampleModalPlant<?= $row['id'] ?>"
            tabindex="-1"
            aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
              <div class="modal-content rounded-4">
                <div class="modal-body p-4">
                  <div class="area-detail-plant">
                    <div class="area-image-detail">
                      <img src="../uploads/<?= $row['foto'] ?>" class="image-detail" alt="" srcset="">
                      <!-- <form action="../functions/orders/tambahKeranjang.php" method="POST">
                        <input type="hidden" name="tanaman_id" value="<?= $row['id']; ?>">
                        
                      </form> -->
                      <div class="area-button-cart">
                        <button
                          class="button-cart"
                          data-tanaman-id="<?= $row['id'] ?>"
                          <?= !$isLogin ? 'data-bs-toggle="tooltip"
    data-bs-placement="bottom"
    data-bs-custom-class="custom-tooltip"
    data-bs-title="Harus login untuk menambahkan ke keranjang" disabled' : '' ?>>
                          <p>Add to cart</p>
                        </button>
                      </div>
                    </div>
                    <div class="area-content-detail">
                      <p class="name-plant"><?= $row['nama_tanaman'] ?></p>
                      <p class="title-location-plant">​Asal & Penemuan</p>
                      <p class="location-plant"><?= $row['asal_tanaman'] ?></p>
                      <div class="line-plant"></div>
                      <p class="title-desk-plant">​Deskripsi</p>
                      <p class="desk-plant"><?= $row['deskripsi_tanaman'] ?></p>
                      <div class="area-breads">
                        <div class="breads-family">
                          <p class="text-breads"><?= $row['nama_kategori'] ?></p>
                        </div>
                        <div class="breads-season">
                          <p class="text-breads"><?= $row['musim'] ?></p>
                        </div>
                      </div>
                      <div class="area-price">
                        <div class="area-price-in">
                          <p class="price-plant">Rp <?= number_format($row['harga'], 0, ',', '.') ?></p>
                          <span>|</span>
                          <p class="stok-plant">Stok: <span class="stok-value" data-id="<?= $row['id']; ?>">
                              <?= $row['stok']; ?>
                            </span></p>
                        </div>
                        <div class="button-status">
                          <p class="status-plant"><?= $row['status'] ?></p>
                        </div>
                      </div>
                    </div>
                  </div>
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
<script>
  const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
  const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
  document.querySelectorAll('.button-cart').forEach(button => {
    button.addEventListener('click', function() {
      const tanamanId = this.dataset.tanamanId;

      fetch('../functions/orders/tambahKeranjang.php', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
          },
          body: `tanaman_id=${tanamanId}`,
        }).then(response => response.json())
        .then(data => {
          if (data.success) {
            const stok = document.querySelector(`.stok-value[data-id="${tanamanId}"]`);
            stok.textContent = data.new_stok;
          } else {}
        });
    });
  });
</script>
<?php include 'layout/footer.php'; ?>