<?php
$page_css = 'categorie.css';
include 'layout/header.php';
include '../database/koneksi.php';


$sqlKat = "SELECT * FROM kategori";
$resultKat = $koneksi->query($sqlKat);

$sql = "SELECT 
    tanaman.*,
    kategori.nama_kategori
FROM tanaman
JOIN kategori ON tanaman.kategori_id = kategori.id";
$result = $koneksi->query($sql);

?>

<div class="header-categorie">
    <h2 class="title-categorie">Categorie</h2>
</div>
<section>
    <div class="area-categorie">
        <div class="area-content-categorie">
            <?php if ($resultKat && $resultKat->num_rows > 0): ?>
                <?php while ($rowKat = $resultKat->fetch_assoc()): ?>
                    <a href="detailCategorie.php?id=<?= $rowKat['id'] ?>" class="link-categorie">
                        <div class="card-categorie">
                            <?= $rowKat['nama_kategori'] ?>
                        </div>
                    </a>
                <?php endwhile; ?>
            <?php else: ?>
                <p class="text-no-data">No categories available.</p>
            <?php endif; ?>
        </div>
</section>


<?php include 'layout/footer.php'; ?>