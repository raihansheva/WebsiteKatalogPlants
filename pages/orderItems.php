<?php
$page_css = 'order.css';
include 'layout/header.php';
include '../database/koneksi.php';

$user_id = $_SESSION['user_id'] ?? null;

$sqlOrder = "SELECT * FROM orders WHERE user_id = ? ORDER BY created_at DESC";
$stmt = $koneksi->prepare($sqlOrder);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$orders = $stmt->get_result();

$sqlItem = "SELECT oi.*, t.nama_tanaman, t.foto 
            FROM order_items oi 
            JOIN tanaman t ON oi.tanaman_id = t.id 
            WHERE oi.order_id = ?";
$stmtItem = $koneksi->prepare($sqlItem);



?>

<div class="header-order">
    <h2 class="title-order">Order Items</h2>
</div>
<section>
    <div class="area-order">
        <div class="area-content-order">
            <div class="content-order">
                <?php if ($orders->num_rows > 0): ?>
                    <?php while ($order = $orders->fetch_assoc()): ?>
                        <div class="card-order">
                            <div class="area-order-info">
                                <div class="area-header-info">
                                    <div class="area-info-kiri">
                                        <p class="order-id">Order ID: <?= $order['id']; ?></p>
                                        <p class="order-date">
                                            Date: <?= date('d M Y, H:i', strtotime($order['created_at'])); ?>
                                        </p>
                                    </div>
                                    <div class="area-info-kanan">
                                        <div class="button-status">
                                            <p class="order-status">
                                                <?= ucfirst($order['status']); ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="area-action-button">
                                    <button class="button-items" data-order-id="<?= $order['id']; ?>">
                                        View Items
                                    </button>
                                    <button class="button-payment" data-bs-toggle="modal"
                                        data-bs-target="#exampleModalPayment<?= $order['id']; ?>">
                                        Pay Now
                                    </button>
                                </div>
                                <div
                                    class="modal fade"
                                    id="exampleModalPayment<?= $order['id']; ?>"
                                    tabindex="-1"
                                    aria-labelledby="exampleModalLabel"
                                    aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content rounded-4" style="background-color: #F7F7F8;">
                                            <div class="modal-body p-2">
                                                <div class="area-cart-modal">
                                                    <div class="area-form-cart-header">
                                                        <h2 class="title-payCard">Payment</h2>
                                                    </div>
                                                    <div class="area-form-card">
                                                        <form id="formCheckOut" method="post" data-user-id="<?= $dataUser['id']; ?>">
                                                            <div class="card-method">
                                                                <div class="area-method">
                                                                    <div class="area-method-kiri">
                                                                        <div class="area-image-method">
                                                                            <img
                                                                                src="../asset/image/Mastercard_logo.webp"
                                                                                alt="Credit Card"
                                                                                class="image-method">
                                                                        </div>
                                                                        <label for="credit_card_<?= $order['id']; ?>">
                                                                            Credit Card
                                                                        </label>
                                                                    </div>
                                                                    <div class="area-method-kanan">
                                                                        <input
                                                                            type="radio"
                                                                            name="payment_method"
                                                                            value="credit_card"
                                                                            id="credit_card_<?= $order['id']; ?>"
                                                                            required>
                                                                    </div>
                                                                </div>
                                                                <div class="area-method">
                                                                    <div class="area-method-kiri">
                                                                        <div class="area-image-method">
                                                                            <img
                                                                                src="../asset/image/DANA__1_Logo.jpg"
                                                                                alt="Credit Card"
                                                                                class="image-method">
                                                                        </div>
                                                                        <label for="credit_card_<?= $order['id']; ?>">
                                                                            Dana
                                                                        </label>
                                                                    </div>
                                                                    <div class="area-method-kanan">
                                                                        <input
                                                                            type="radio"
                                                                            name="payment_method"
                                                                            value="credit_card"
                                                                            id="credit_card_<?= $order['id']; ?>"
                                                                            required>
                                                                    </div>
                                                                </div>
                                                                <div class="area-method">
                                                                    <div class="area-method-kiri">
                                                                        <div class="area-image-method">
                                                                            <img
                                                                                src="../asset/image/PayPal.svg.png"
                                                                                alt="Credit Card"
                                                                                class="image-method">
                                                                        </div>
                                                                        <label for="credit_card_<?= $order['id']; ?>">
                                                                            Paypal
                                                                        </label>
                                                                    </div>
                                                                    <div class="area-method-kanan">
                                                                        <input
                                                                            type="radio"
                                                                            name="payment_method"
                                                                            value="credit_card"
                                                                            id="credit_card_<?= $order['id']; ?>"
                                                                            required>
                                                                    </div>
                                                                </div>
                                                                <div class="area-method">
                                                                    <div class="area-method-kiri">
                                                                        <div class="area-image-method">
                                                                            <img
                                                                                src="../asset/image/QRIS_Logo.svg.png"
                                                                                alt="Credit Card"
                                                                                class="image-method">
                                                                        </div>
                                                                        <label for="credit_card_<?= $order['id']; ?>">
                                                                            Qris
                                                                        </label>
                                                                    </div>
                                                                    <div class="area-method-kanan">
                                                                        <input
                                                                            type="radio"
                                                                            name="payment_method"
                                                                            value="credit_card"
                                                                            id="credit_card_<?= $order['id']; ?>"
                                                                            required>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="line-payment"></div>
                                                            <div class="area-struk">
                                                                <div class="area-total-bayar">
                                                                    <p class="text-total-bayar">
                                                                        Harga Total Barang :
                                                                    </p>
                                                                    <p class="price-total-bayar">
                                                                        Rp. <span id="priceTotal"><?= number_format($order['total_harga'], 0, ',', '.'); ?></span>
                                                                    </p>
                                                                </div>
                                                                <div class="area-total-bayar">
                                                                    <p class="text-total-bayar">
                                                                        Biaya Pengiriman :
                                                                    </p>
                                                                    <p class="price-total-bayar">
                                                                        Rp. <span id="priceShip"><?= number_format(10000, 0, ',', '.'); ?></span>
                                                                    </p>
                                                                </div>
                                                                <div class="area-total-bayar">
                                                                    <p class="text-total-bayar">
                                                                        Total Pembayaran :
                                                                    </p>
                                                                    <p class="price-total-bayar">
                                                                        Rp. <span class="priceTotalFinal" data-idPrice="<?= $order['id']; ?>"></span>
                                                                    </p>
                                                                </div>
                                                            </div>
                                                            <div class="area-button-payment-final">
                                                                <button class="button-payment-final" type="submit">
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
                            <div class="area-order-items" id="areaOrderItems<?= $order['id']; ?>" style="display: none;">
                                <div class="order-item">
                                    <div class="area-luar-image">
                                        <?php
                                        $stmtItem->bind_param("i", $order['id']);
                                        $stmtItem->execute();
                                        $items = $stmtItem->get_result();
                                        ?>

                                        <?php if ($items->num_rows > 0): ?>
                                            <?php while ($item = $items->fetch_assoc()): ?>
                                                <div class="area-image-item">
                                                    <img
                                                        src="../uploads/<?= $item['foto']; ?>"
                                                        class="image-item"
                                                        alt="">
                                                </div>
                                            <?php endwhile; ?>
                                        <?php else: ?>
                                            <p class="empty-item">Tidak ada item di order ini</p>
                                        <?php endif; ?>
                                    </div>
                                    <div class="area-info-item">
                                        <?php
                                        $stmtItem->bind_param("i", $order['id']);
                                        $stmtItem->execute();
                                        $items = $stmtItem->get_result();
                                        ?>

                                        <?php if ($items->num_rows > 0): ?>
                                            <?php while ($item = $items->fetch_assoc()): ?>
                                                <div class="card-order-items">
                                                    <div class="area-name-qty">
                                                        <p class="item-name"><?= $item['nama_tanaman']; ?></p>
                                                        <p class="item-quantity">
                                                            Qty: <?= $item['quantity']; ?>
                                                        </p>
                                                    </div>
                                                    <div class="area-price">
                                                        <p class="item-price"><span>Rp.</span> <?= number_format($item['harga'], 0, ',', '.'); ?></p>
                                                    </div>
                                                </div>
                                            <?php endwhile; ?>
                                        <?php else: ?>
                                            <p class="empty-item">Tidak ada item di order ini</p>
                                        <?php endif; ?>

                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p>Belum ada order.</p>
                <?php endif; ?>

            </div>
        </div>
    </div>
</section>
<script>
    document.querySelectorAll('.button-items').forEach(button => {
        button.addEventListener('click', () => {
            const orderId = button.getAttribute('data-order-id');
            const itemsArea = document.getElementById('areaOrderItems' + orderId);
            if (itemsArea.style.display === 'none') {
                itemsArea.style.display = 'flex';
                button.textContent = 'Hide Items';
            } else {
                itemsArea.style.display = 'none';
                button.textContent = 'View Items';
            }
        });
    });

    document.querySelectorAll('.priceTotalFinal').forEach(el => {
        const modal = el.closest('.modal');
        const priceTotal = parseInt(
            modal.querySelector('#priceTotal').textContent.replace(/[^\d]/g, '')
        ) || 0;
        const priceShip = parseInt(
            modal.querySelector('#priceShip').textContent.replace(/[^\d]/g, '')
        ) || 0;
        const totalPayment = priceTotal + priceShip;
        el.textContent = new Intl.NumberFormat('id-ID').format(totalPayment);
    });
</script>

<?php include 'layout/footer.php'; ?>