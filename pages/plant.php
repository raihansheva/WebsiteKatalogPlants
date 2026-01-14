<?php
$page_css = 'plant.css';
include 'layout/header.php';
include '../database/koneksi.php';

$sqlT = "SELECT tanaman.*, kategori.nama_kategori 
        FROM tanaman
        JOIN kategori ON tanaman.kategori_id = kategori.id";
$resultT = $koneksi->query($sqlT);

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
                      <form action="../functions/orders/tambahKeranjang.php" method="POST">
                        <input type="hidden" name="tanaman_id" value="<?= $row['id']; ?>">
                        <div class="area-button-cart">
                        <button type="submit" class="button-cart">
                          <p>Add to cart</p>
                        </button>
                      </div>
                      </form>
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
                          <p class="stok-plant">Stok: <?= $row['stok'] ?></p>
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

<?php include 'layout/footer.php'; ?>