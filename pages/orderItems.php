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

<section>
    <div class="area-order">
        <div class="header-order">
            <h2 class="title-order">Order Items</h2>
        </div>
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
                                    <button class="button-payment">
                                        Pay Now
                                    </button>
                                </div>

                            </div>
                            <div class="area-order-items" id="areaOrderItems<?= $order['id']; ?>" style="display: none;">
                                <?php
                                $stmtItem->bind_param("i", $order['id']);
                                $stmtItem->execute();
                                $items = $stmtItem->get_result();
                                ?>

                                <?php if ($items->num_rows > 0): ?>
                                    <?php while ($item = $items->fetch_assoc()): ?>
                                        <div class="order-item">
                                            <div class="area-image-item">
                                                <img
                                                    src="../uploads/<?= $item['foto']; ?>"
                                                    class="image-item"
                                                    alt="">
                                            </div>
                                            <div class="area-info-item">
                                                <p class="item-name"><?= $item['nama_tanaman']; ?></p>
                                                <p class="item-quantity">
                                                    Qty: <?= $item['quantity']; ?>
                                                </p>
                                            </div>
                                        </div>
                                    <?php endwhile; ?>
                                <?php else: ?>
                                    <p class="empty-item">Tidak ada item di order ini</p>
                                <?php endif; ?>
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
</script>

<?php include 'layout/footer.php'; ?>