<?php
session_start();
include '../../database/koneksi.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$order_id = $_POST['order_id'];
$metode = $_POST['payment_method'];
$total = $_POST['total_bayar'];

// 1. Simpan pembayaran
$sql = "INSERT INTO pembayaran (order_id, user_id, metode_pembayaran, total_bayar, status_pembayaran)
        VALUES (?, ?, ?, ?, 'berhasil')";
$stmt = $koneksi->prepare($sql);
$stmt->bind_param("iisi", $order_id, $user_id, $metode, $total);
$stmt->execute();

// 2. Update status order
$sqlUpdate = "UPDATE orders SET status = 'dibayar' WHERE id = ?";
$stmtUpdate = $koneksi->prepare($sqlUpdate);
$stmtUpdate->bind_param("i", $order_id);
$stmtUpdate->execute();

// 3. Redirect
header("Location: ../pages/order.php?payment=success");
exit;
