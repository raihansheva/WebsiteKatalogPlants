<?php
session_start();
include '../../database/koneksi.php';

header('Content-Type: application/json');

// Cek login
if (!isset($_SESSION['user_id'])) {
    echo json_encode([
        'success' => false,
        'message' => 'User belum login'
    ]);
    exit;
}

$user_id = $_SESSION['user_id'];

// Ambil cart user
$queryCart = "
    SELECT 
        keranjang.*, 
        tanaman.nama_tanaman,
        tanaman.harga
    FROM keranjang
    JOIN tanaman ON keranjang.tanaman_id = tanaman.id
    WHERE keranjang.user_id = $user_id
";
$resultCart = mysqli_query($koneksi, $queryCart);

if (!$resultCart || mysqli_num_rows($resultCart) == 0) {
    echo json_encode([
        'success' => false,
        'message' => 'Keranjang kosong'
    ]);
    exit;
}

// Hitung total
$total = 0;
$cartItems = [];

while ($row = mysqli_fetch_assoc($resultCart)) {
    $subtotal = $row['harga'] * $row['quantity'];
    $total += $subtotal;
    $cartItems[] = $row;
}

// Ambil alamat
$alamat = mysqli_real_escape_string($koneksi, $_POST['alamat'] ?? '');

if ($alamat == '') {
    echo json_encode([
        'success' => false,
        'message' => 'Alamat wajib diisi'
    ]);
    exit;
}

// Insert order
$insertOrder = "
    INSERT INTO orders (user_id, total_harga, alamat, status)
    VALUES ($user_id, $total, '$alamat', 'pending')
";

if (!mysqli_query($koneksi, $insertOrder)) {
    echo json_encode([
        'success' => false,
        'message' => 'Gagal membuat order'
    ]);
    exit;
}

$order_id = mysqli_insert_id($koneksi);

// Insert order items
foreach ($cartItems as $item) {
    $tanaman_id = $item['tanaman_id'];
    $harga = $item['harga'];
    $qty = $item['quantity'];
    $subtotal = $harga * $qty;

    mysqli_query($koneksi, "
        INSERT INTO order_items (order_id, tanaman_id, harga, quantity, subtotal)
        VALUES ($order_id, $tanaman_id, $harga, $qty, $subtotal)
    ");
}

// Kosongkan cart
mysqli_query($koneksi, "DELETE FROM keranjang WHERE user_id = $user_id");

// RESPONSE JSON (WAJIB echo)
echo json_encode([
    'success' => true,
    'message' => 'Checkout berhasil'
]);
exit;
