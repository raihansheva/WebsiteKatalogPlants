<?php
$page_css = 'detailCategorie.css';
include 'layout/header.php';
include '../database/koneksi.php';

$kategori_id = $_GET['id'] ?? null;

if (!$kategori_id) {
  echo "<h3>Kategori tidak ditemukan</h3>";
  exit;
}

$sqlT = "SELECT tanaman.*, kategori.nama_kategori
         FROM tanaman
         JOIN kategori ON tanaman.kategori_id = kategori.id
         WHERE kategori.id = ?";

$stmt = $koneksi->prepare($sqlT);
$stmt->bind_param("i", $kategori_id);
$stmt->execute();
$resultT = $stmt->get_result();

$sqlKategori = "SELECT nama_kategori FROM kategori WHERE id = '$kategori_id'";
$resultKategori = $koneksi->query($sqlKategori);

$namaKategori = '';
if ($resultKategori->num_rows > 0) {
    $rowKategori = $resultKategori->fetch_assoc();
    $namaKategori = $rowKategori['nama_kategori'];
}


$isLogin = isset($_SESSION['user_id']);
?>

<section>
  <div class="area-plant-page">
    <div class="header-plant-page">
      <a class="linkBack" href="categorie.php">back</a>
      <h1 class="title-plant-page"><?= $namaKategori ?></h1>
    </div>
    <div class="area-content-plant">
      <?php if ($resultT && $resultT->num_rows > 0) { ?>
        <?php while ($row = $resultT->fetch_assoc()): ?>
          <div class="card-plant" data-bs-toggle="modal"
            data-bs-target="#exampleModalPlant<?= $row['id'] ?>">
            <div class="area-detail-plant">
                    <div class="area-image-detail">
                      <img src="../uploads/<?= $row['foto'] ?>" class="image-detail" alt="" srcset="">
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
                      <!-- <div class="area-price">
                        <div class="area-price-in">
                          <p class="price-plant">Rp <?= number_format($row['harga'], 0, ',', '.') ?></p>
                          <span>|</span>
                          <p class="stok-plant">Stok: <span class="stok-value" data-id="<?= $row['id']; ?>">
                              <?= $row['stok']; ?>
                            </span></p>
                        </div>
                        <div class="button-status <?= $row['status'] == 'tersedia' ? 'available' : 'sold' ?>" data-status-id="<?= $row['id']; ?>">
                            <p class="status-plant <?= $row['status'] == 'tersedia' ? 'available' : 'sold' ?>"><?= $row['status'] ?></p>
                        </div>
                      </div> -->
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
<!-- <div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 1100">
  <div id="cartToast" class="toast align-items-center text-bg-success border-0" role="alert">
    <div class="d-flex">
      <div class="toast-body">
        ✅ Berhasil ditambahkan ke keranjang
      </div>
      <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
    </div>
  </div>
</div> -->
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

  document.querySelectorAll('.button-cart').forEach(button => {
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