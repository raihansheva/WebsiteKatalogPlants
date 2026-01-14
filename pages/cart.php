<?php
$page_css = 'cart.css';
include 'layout/header.php';
include '../database/koneksi.php';

$user_id = 1;

// QUERY CART
$queryCart = "
SELECT 
    keranjang.id AS cart_id,
    tanaman.id AS tanaman_id,
    tanaman.nama_tanaman,
    tanaman.harga,
    tanaman.foto,
    keranjang.quantity,
    (tanaman.harga * keranjang.quantity) AS subtotal
FROM keranjang
JOIN tanaman ON keranjang.tanaman_id = tanaman.id
WHERE keranjang.user_id = '$user_id'
";

$resultCart = mysqli_query($koneksi, $queryCart);

// INISIALISASI
$totalPrice = 0;
$totalItems = mysqli_num_rows($resultCart);

$no = 1;
?>

<section>
    <div class="area-header-cart">
        <h2>Keranjang Hijau.</h2>
    </div>

    <div class="area-cart">
        <?php if ($totalItems > 0): ?>
            <?php while ($row = mysqli_fetch_assoc($resultCart)): ?>
                <?php $totalPrice += $row['subtotal']; ?>

                <div class="card-cart" data-cart-id="<?= $row['cart_id'] ?>" data-subtotal="<?= $row['subtotal']; ?>">
                    <div class="area-no">
                        <span><?= $no++ ?></span>
                    </div>

                    <div class="area-image-cart">
                        <img class="image-cart"
                            src="../uploads/<?= $row['foto']; ?>"
                            alt="<?= $row['nama_tanaman']; ?>">
                    </div>

                    <div class="area-name-plant-cart">
                        <p class="name-plant-cart"><?= $row['nama_tanaman']; ?></p>
                        <p class="type-plant-cart">Plant</p>
                    </div>

                    <div class="area-price-plant">
                        <p class="price-cart">
                            Rp. <?= number_format($row['harga'], 0, ',', '.'); ?>
                        </p>
                    </div>

                    <div class="area-stok-plant">
                        <p class="stok-cart"><?= $row['quantity']; ?></p>
                    </div>
                    <span class="btn-remove" data-cart-id="<?= $row['cart_id']; ?>">Hapus</span>
                </div>

            <?php endwhile; ?>
        <?php else: ?>
            <!-- <p style="text-align:center;">Keranjang masih kosong</p> -->
        <?php endif; ?>
    </div>
</section>

<div class="lineC"></div>

<div class="area-checkout">
    <div class="area-total-checkout">
        <p class="text-total-checkout">
            Total: (<span id="totalItems"><?= $totalItems; ?></span> Tanaman)
        </p>
        <p class="price-total-checkout">
            Rp. <span id="totalHarga"><?= number_format($totalPrice, 0, ',', '.'); ?></span>
        </p>
    </div>

    <div class="area-button-checkout">
        <button class="button-checkout">
            Checkout
        </button>
    </div>
</div>
<script>
    document.querySelectorAll('.btn-remove').forEach(btn => {
        btn.addEventListener('click', function() {
            const cartId = this.dataset.cartId;
            const card = document.querySelector(`[data-cart-id="${cartId}"]`);
            const subtotal = parseInt(card.dataset.subtotal);

            fetch('../functions/orders/hapusKeranjang.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: `cart_id=${cartId}`
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        card.remove();
                        const totalItemsEl = document.getElementById('totalItems');
                        totalItemsEl.textContent = parseInt(totalItemsEl.textContent) - 1;
                        const totalPriceEl = document.getElementById('totalHarga');
                        const currentTotal = parseInt(totalPriceEl.textContent.replace(/\./g, ''));
                        const newTotal = currentTotal - subtotal;
                        totalPriceEl.textContent = newTotal.toLocaleString('id-ID');
                    }
                });
        });
    });
</script>


<?php include 'layout/footer.php'; ?>