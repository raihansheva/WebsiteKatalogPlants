<?php
session_start();
include '../../database/koneksi.php';

$tanaman_id = $_POST['tanaman_id'] ?? null;

$user_id = $_SESSION['user_id'];

$cek = mysqli_query(
  $koneksi,
  "SELECT stok FROM tanaman WHERE id = '$tanaman_id'"
);
$data = mysqli_fetch_assoc($cek);

if ($data['stok'] <= 0) {
  echo json_encode([
    'success' => false,
    'message' => '❌ Stok habis'
  ]);
  exit;
}

mysqli_query(
  $koneksi,
  "INSERT INTO keranjang (user_id, tanaman_id, quantity)
   VALUES ('$user_id', '$tanaman_id', 1)
   ON DUPLICATE KEY UPDATE quantity = quantity + 1"
);

mysqli_query(
  $koneksi,
  "UPDATE tanaman SET stok = stok - 1 WHERE id = '$tanaman_id'"
);

mysqli_query(
  $koneksi,
  "UPDATE tanaman 
   SET status = CASE 
       WHEN stok - 1 <= 0 THEN 'Habis'
       ELSE 'Tersedia'
     END
   WHERE id = '$tanaman_id'"
);

$new = mysqli_fetch_assoc(
  mysqli_query(
    $koneksi,
    "SELECT stok FROM tanaman WHERE id = '$tanaman_id'"
  )
);

echo json_encode([
  'success' => true,
  'tanaman_id' => $tanaman_id,
  'new_stok' => $new['stok'],
  'status' => $new['stok'] > 0 ? 'Tersedia' : 'Habis'
]);
