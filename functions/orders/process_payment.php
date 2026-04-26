<?php
session_start();
include '../../database/koneksi.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Belum login']);
    exit;
}

$user_id = $_SESSION['user_id'];
$order_id = $_POST['order_id'];
$metode = $_POST['payment_method'];
$total = $_POST['total_bayar'];

// simpan pembayaran
$sql = "INSERT INTO pembayaran (order_id, user_id, metode_pembayaran, total_bayar, status_pembayaran)
        VALUES (?, ?, ?, ?, 'berhasil')";
$stmt = $koneksi->prepare($sql);
$stmt->bind_param("iisi", $order_id, $user_id, $metode, $total);

if ($stmt->execute()) {
    // update order
    $sqlUpdate = "UPDATE orders SET status = 'dibayar' WHERE id = ?";
    $stmtUpdate = $koneksi->prepare($sqlUpdate);
    $stmtUpdate->bind_param("i", $order_id);
    $stmtUpdate->execute();

    echo json_encode([
        'success' => true,
        'message' => 'Pembayaran berhasil 🎉'
    ]);
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Pembayaran gagal'
    ]);
}
exit;
