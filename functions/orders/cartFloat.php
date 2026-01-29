<?php
session_start();
include '../../database/koneksi.php';

$user_id = $_SESSION['user_id'] ?? null;
if (!$user_id) {
  echo json_encode(['html' => '', 'count' => 0]);
  exit;
}

$query = "
SELECT 
  tanaman.nama_tanaman,
  tanaman.foto,
  keranjang.quantity
FROM keranjang
JOIN tanaman ON keranjang.tanaman_id = tanaman.id
WHERE keranjang.user_id = '$user_id'
";

$result = mysqli_query($koneksi, $query);
$count = mysqli_num_rows($result);

$html = '';

if ($count > 0) {
  while ($row = mysqli_fetch_assoc($result)) {
    $html .= "
      <div class='cart-item'>
        <img src='/WebsiteKatalogPlants/uploads/{$row['foto']}'>
        <div>
          <p class='name'>{$row['nama_tanaman']}</p>
        </div>
      </div>
    ";
  }
} else {
  $html = "<p class='text-muted'>Keranjang kosong</p>";
}

echo json_encode([
  'html' => $html,
  'count' => $count
]);
