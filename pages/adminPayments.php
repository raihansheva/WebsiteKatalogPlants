<?php
include '../database/koneksi.php';
$page_css = 'adminPlants.css';
include 'layout/headerAdmin.php';

$sqlT = "
SELECT 
    p.id AS pembayaran_id,
    p.order_id,
    u.nama AS nama_user,
    p.metode_pembayaran,
    p.total_bayar,
    p.status_pembayaran,
    p.created_at
FROM pembayaran p
JOIN users u ON p.user_id = u.id
ORDER BY p.created_at DESC;

";

$resultT = mysqli_query($koneksi, $sqlT);


$sqlK = "SELECT * FROM kategori";
$resultK = $koneksi->query($sqlK);
?>

<section>
    <div class="area-data-Tanaman">
        <h2 class="title-page-Tanaman">Page Data Payment</h2>

        <div class="area-tabel-tanaman table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID Payment</th>
                        <th>ID Order</th>
                        <th>Nama Pembeli</th>
                        <th>Metode Pembayaran</th>
                        <th>Total Bayar</th>
                        <th>Status</th>
                        <th>Waktu</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($resultT)) : ?>
                        <tr>
                            <td>#<?= $row['pembayaran_id']; ?></td>
                            <td><?= htmlspecialchars($row['order_id']); ?></td>
                            <td><?= htmlspecialchars($row['nama_user']); ?></td>
                            <td><?= $row['metode_pembayaran']; ?></td>
                            <td>
                                Rp <?= number_format($row['total_bayar'], 0, ',', '.'); ?>
                            </td>
                            <td>
                                <?php
                                switch ($row['status_pembayaran']) {
                                    case 'berhasil':
                                        echo '<span class="badge bg-success">berhasil</span>';
                                        break;

                                    case 'dibayar':
                                        echo '<span class="badge bg-primary">Dibayar</span>';
                                        break;

                                    case 'dikirim':
                                        echo '<span class="badge bg-info text-dark">Dikirim</span>';
                                        break;

                                    case 'selesai':
                                        echo '<span class="badge bg-success">Selesai</span>';
                                        break;

                                    case 'dibatalkan':
                                        echo '<span class="badge bg-danger">Dibatalkan</span>';
                                        break;

                                    default:
                                        echo '<span class="badge bg-secondary">Unknown</span>';
                                }
                                ?>
                            </td>
                            <td><?= date('d M Y', strtotime($row['created_at'])); ?></td>
                            <!-- <td>
                                <div class="btn btn-info btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#modalDetailOrder<?= $row['order_id']; ?>">
                                    Detail
                                </div>

                                <div class="modal fade" id="modalDetailOrder<?= $row['order_id']; ?>" tabindex="-1">
                                    <div class="modal-dialog modal-lg modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">
                                                    Detail Order #<?= $row['order_id']; ?>
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <p><strong>Nama Pembeli :</strong> <?= htmlspecialchars($row['nama_user']); ?></p>
                                                    <p><strong>Tanggal :</strong> <?= date('d M Y', strtotime($row['created_at'])); ?></p>
                                                    <p><strong>Status :</strong> <?= ucfirst($row['status']); ?></p>
                                                </div>
                                                <hr>
                                                <?php
                                                $order_id = $row['order_id'];
                                                $sqlDetail = "SELECT t.nama_tanaman, oi.quantity, oi.harga FROM order_items oi JOIN tanaman t ON oi.tanaman_id = t.id WHERE oi.order_id = '$order_id'";
                                                $resultDetail = mysqli_query($koneksi, $sqlDetail);
                                                ?>
                                                <div class="table-responsive">
                                                    <table class="table table-bordered">
                                                        <thead class="table-light">
                                                            <tr>
                                                                <th>Nama Tanaman</th>
                                                                <th>Qty</th>
                                                                <th>Harga</th>
                                                                <th>Subtotal</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php while ($item = mysqli_fetch_assoc($resultDetail)) : ?>
                                                                <tr>
                                                                    <td><?= $item['nama_tanaman']; ?></td>
                                                                    <td><?= $item['quantity']; ?></td>
                                                                    <td>Rp <?= number_format($item['harga'], 0, ',', '.'); ?></td>
                                                                    <td>
                                                                        Rp <?= number_format($item['quantity'] * $item['harga'], 0, ',', '.'); ?>
                                                                    </td>
                                                                </tr>
                                                            <?php endwhile; ?>
                                                        </tbody>
                                                    </table>
                                                </div>

                                                <hr>

                                                <h5 class="text-end">
                                                    Total : Rp <?= number_format($row['total_harga'], 0, ',', '.'); ?>
                                                </h5>

                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                    Tutup
                                                </button>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                            </td> -->
                        </tr>
                    <?php endwhile; ?>

                </tbody>
            </table>
        </div>
    </div>
</section>
<?php if (isset($_SESSION['errorTanaman']) && empty($_SESSION['just_logged_out'])): ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const modal = new bootstrap.Modal(document.getElementById('exampleModalInputTanaman'));
            modal.show();
        });
    </script>
<?php endif; ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const modalEl = document.getElementById('exampleModalInputTanaman');
        if (!modalEl) return;

        modalEl.addEventListener('hidden.bs.modal', function() {
            fetch('../functions/clear-error.php', {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            }).catch(err => {
                console.error('Failed to clear session error:', err);
            });
        });
    });
</script>
<?php include 'layout/footer.php'; ?>