<?php
$page_css = 'cart.css';
include 'layout/header.php';
include '../database/koneksi.php';

$user_id = $_SESSION['user_id'] ?? null;

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

// ambil data user euy
$sqlUser = "SELECT * FROM users WHERE id = '$user_id'";
$resultDataUser = mysqli_query($koneksi, $sqlUser);
$dataUser = mysqli_fetch_assoc($resultDataUser);

?>

<div class="area-header-cart">
    <h2 class="title-cart">Keranjang Hijau.</h2>
</div>
<section>

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
        <button class="button-checkout" data-bs-toggle="modal"
            data-bs-target="#exampleModalCheckout">
            Checkout
        </button>
    </div>
    <div
        class="modal fade"
        id="exampleModalCheckout"
        tabindex="-1"
        aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4">
                <div class="modal-body p-2">
                    <div class="area-cart-modal">
                        <div class="area-form-cart-header">
                            <h2 class="title-formCart">Form Checkout</h2>
                        </div>
                        <div class="area-form-cart">
                            <form id="formCheckOut" method="post" data-user-id="<?= $dataUser['id']; ?>">
                                <div class="area-input-cart">
                                    <input type="text" name="user_id" id="" value="<?= $dataUser['id']; ?>" hidden>
                                    <label for="">Nama User : </label>
                                    <input class="input-checkout" type="text" name="nama" id="" value="<?= $dataUser['nama']; ?>" readonly>
                                </div>
                                <div class="area-input-cart">
                                    <label for="">Total Harga : </label>
                                    <input class="input-checkout" type="text" name="total_harga" id="hargaCheckout" value="Rp. <?= number_format($totalPrice, 0, ',', '.'); ?>" readonly>
                                </div>
                                <input class="input-checkout" type="text" name="status" id="" value="pending" readonly hidden>
                                <div class="area-input-cart">
                                    <label for="">Alamat : </label>
                                    <textarea class="input-checkoutTxt" type="text" name="alamat" id="address" rows="5"></textarea>
                                </div>
                                <div class="area-button-checkOut">
                                    <button class="button-checkout-final" type="submit">
                                        Checkout Sekarang
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
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
                        const hargaCheckoutEl = document.getElementById('hargaCheckout');
                        hargaCheckoutEl.value = "Rp. " + newTotal.toLocaleString('id-ID');
                        document.dispatchEvent(new Event('cartUpdated'));
                    }
                });
        });
    });


    const toastLiveExample = document.getElementById('liveToast');
    const cartToast = new bootstrap.Toast(toastLiveExample, {
        delay: 2000
    });

    const checkOutForm = document.getElementById('formCheckOut');
    checkOutForm.addEventListener('submit', function(e) {
        const modal = bootstrap.Modal.getInstance(document.getElementById('exampleModalCheckout'));
        e.preventDefault();
        const cartId = this.dataset.cartId;
        const card = document.querySelector(`[data-cart-id="${cartId}"]`);
        const formData = new FormData(checkOutForm);
        fetch('../functions/orders/checkout.php', {
                method: 'POST',
                body: new URLSearchParams(formData)
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    const textToast = document.getElementById('textToast');
                    const textAddress = document.getElementById('address');
                    textAddress.value = '';
                    textToast.textContent = "✅ Pesanan Tanaman Berhasil Dibuat!";
                    cartToast.show();
                    console.log("berhasil");
                    document.querySelectorAll('.card-cart').forEach(card => {
                        card.remove();
                    });
                    modal.hide();
                    const totalItemsEl = document.getElementById('totalItems');
                    totalItemsEl.textContent = 0;
                    
                } else {
                    const textToast = document.getElementById('textToast');
                    textToast.textContent = data.message;
                    cartToast.show();
                    console.log("gagal");
                    // card.remove();
                }
            });
    });
</script>


<?php include 'layout/footer.php'; ?>