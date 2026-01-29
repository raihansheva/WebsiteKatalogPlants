<?php
$page_css = 'dashboard.css';
include 'layout/headerAdmin.php';
include '../database/koneksi.php';

$tahun = 2026; // bisa diganti dynamic nanti

$query = mysqli_query($koneksi, "
    SELECT 
        YEAR(created_at) AS tahun,
        MONTH(created_at) AS bulan,
        COUNT(id) AS jumlah_order
    FROM orders
    WHERE YEAR(created_at) = '$tahun'
    GROUP BY YEAR(created_at), MONTH(created_at)
    ORDER BY bulan ASC
");

$queryTotal = mysqli_query($koneksi, "SELECT COUNT(id) AS total_tanaman FROM tanaman");
$dataTotal = mysqli_fetch_assoc($queryTotal);
$totalTanaman = $dataTotal['total_tanaman'];

$queryTotalOrders = mysqli_query($koneksi, "SELECT COUNT(id) AS totalOrder FROM orders");
$dataTotalOrders = mysqli_fetch_assoc($queryTotalOrders);
$totalOrders = $dataTotalOrders['totalOrder'];

$label_bulan = [];
$jumlah_order = [];

while ($row = mysqli_fetch_assoc($query)) {
    $label_bulan[] = date('F', mktime(0, 0, 0, $row['bulan'], 1)) . ' ' . $row['tahun'];
    $jumlah_order[] = $row['jumlah_order'];
}
?>

<section>
    <div class="area-header-dashboard">
        <h2 class="title-dashboard">Dashboard</h2>
    </div>
    <div class="area-grid-dashboard">

        <div class="area-kiri">
            <h3>Statistik Penjualan</h3>

            <div class="statistik-penjualan">
                <canvas id="chartOrderBulanan"></canvas>
            </div>
        </div>

        <div class="area-kanan-1">
            <div class="card-kanan">
                <div class="area-atas">
                    <div class="lineHead"></div>
                    <p class="titleTotal">Tanaman</p>
                </div>
                <div class="area-bawah">
                    <p class="total"><?= $totalTanaman ?></p>
                </div>
            </div>
            <div class="card-kanan">
                <div class="area-atas">
                    <div class="lineHead"></div>
                    <p class="titleTotal">Pesanan</p>
                </div>
                <div class="area-bawah">
                    <p class="total"><?= $totalOrders ?></p>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>



<script>
    new Chart(document.getElementById('chartOrderBulanan'), {
        type: 'line',
        fill: true,
        data: {
            labels: <?= json_encode($label_bulan) ?>,
            datasets: [{
                label: 'Jumlah Order per Bulan',
                data: <?= json_encode($jumlah_order) ?>,
                backgroundColor: '#36b9cc'
            }]
        }
    });
</script>


<?php include 'layout/footer.php'; ?>