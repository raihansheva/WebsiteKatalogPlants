<?php
$page_css = 'plant.css';
include 'layout/header.php';
?>

<section>
  <div class="area-plant-page">
    <div class="header-plant-page">
      <h1 class="title-plant-page">Plant Gallery</h1>
    </div>
    <div class="area-content-plant">
      <div class="card-plant" data-bs-toggle="modal"
        data-bs-target="#exampleModalPlant">
        <div class="area-image-plant">
          <img src="../asset/image/imagePlant1.png" class="image-plant" alt="">
        </div>
      </div>
      <div class="card-plant">
        <div class="area-image-plant">
          <img src="../asset/image/imagePlant2.png" class="image-plant" alt="">
        </div>
      </div>
      <div class="card-plant">
        <div class="area-image-plant">
          <img src="../asset/image/imagePlant3.png" class="image-plant" alt="">
        </div>
      </div>
      <div class="card-plant">
        <div class="area-image-plant">
          <img src="../asset/image/imagePlant4.png" class="image-plant" alt="">
        </div>
      </div>
      <div class="card-plant">
        <div class="area-image-plant">
          <img src="../asset/image/imagePlant5.png" class="image-plant" alt="">
        </div>
      </div>
      <div class="card-plant">
        <div class="area-image-plant">
          <img src="../asset/image/imagePlant6.png" class="image-plant" alt="">
        </div>
      </div>
      <div class="card-plant">
        <div class="area-image-plant">
          <img src="../asset/image/imagePlant7.png" class="image-plant" alt="">
        </div>
      </div>
      <div class="card-plant">
        <div class="area-image-plant">
          <img src="../asset/image/imagePlant8.png" class="image-plant" alt="">
        </div>
      </div>
    </div>
    <div
      class="modal fade"
      id="exampleModalPlant"
      tabindex="-1"
      aria-labelledby="exampleModalLabel"
      aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content rounded-4">
          <div class="modal-body p-4">
            <div class="area-detail-plant">
              <div class="area-image-detail">
                <img src="../asset/image/imagePlant8.png" class="image-detail" alt="" srcset="">
              </div>
              <div class="area-content-detail">
                <p class="name-plant">Calathea Makoyana</p>
                <p class="title-location-plant">​Asal & Penemuan</p>
                <p class="location-plant">Berasal dari Brasil Timur. Ditemukan pada era Victoria.</p>
                <div class="line-plant"></div>
                <p class="title-desk-plant">​Deskripsi</p>
                <p class="desk-plant">Disebut "Peacock Plant" (Tanaman Merak) karena motif daunnya mirip ekor merak. Bagian bawah daun berwarna ungu kemerahan.</p>
                <div class="area-breads">
                  <div class="breads-family">
                    <p class="text-breads">Marantacea</p>
                  </div>
                  <div class="breads-season">
                    <p class="text-breads">Tropis</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<?php include 'layout/footer.php'; ?>