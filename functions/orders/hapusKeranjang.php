<?php
include '../../database/koneksi.php';

$cart_id = $_POST['cart_id'];

$getCart = mysqli_query(
    $koneksi,
    "SELECT tanaman_id, quantity FROM keranjang WHERE id = '$cart_id'"
);
$data = mysqli_fetch_assoc($getCart);

mysqli_query(
    $koneksi,
    "UPDATE tanaman 
     SET stok = stok + {$data['quantity']}
     WHERE id = '{$data['tanaman_id']}'"
);

mysqli_query(
    $koneksi,
    "UPDATE tanaman 
     SET status = CASE 
         WHEN stok > 0 THEN 'tersedia'
         ELSE 'habis'
     END
     WHERE id = '{$data['tanaman_id']}'"
);

mysqli_query(
    $koneksi,
    "DELETE FROM keranjang WHERE id = '$cart_id'"
);

echo json_encode([
    'success' => true
]);
