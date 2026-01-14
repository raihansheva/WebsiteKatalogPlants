<?php
session_start();

// PATH SUDAH BENAR
include '../../database/koneksi.php';

// USER DUMMY UNTUK UAS
$user_id = $_SESSION['user_id'] ?? 1;
$tanaman_id = $_POST['tanaman_id'] ?? null;

if (!$tanaman_id) {
    die("Tanaman tidak ditemukan");
}

// CEK STOK
$cekStok = mysqli_query(
    $koneksi,
    "SELECT stok FROM tanaman WHERE id = '$tanaman_id'"
);

$dataStok = mysqli_fetch_assoc($cekStok);

if ($dataStok['stok'] <= 0) {
    echo "<script>alert('Stok habis'); window.history.back();</script>";
    exit;
}

// CEK CART
$cekCart = mysqli_query(
    $koneksi,
    "SELECT * FROM keranjang 
     WHERE user_id = '$user_id' 
     AND tanaman_id = '$tanaman_id'"
);

if (mysqli_num_rows($cekCart) > 0) {
    mysqli_query(
        $koneksi,
        "UPDATE keranjang 
         SET quantity = quantity + 1 
         WHERE user_id = '$user_id' 
         AND tanaman_id = '$tanaman_id'"
    );
} else {
    mysqli_query(
        $koneksi,
        "INSERT INTO keranjang (user_id, tanaman_id, quantity)
         VALUES ('$user_id', '$tanaman_id', 1)"
    );
}

// KURANGI STOK
mysqli_query(
    $koneksi,
    "UPDATE tanaman 
     SET stok = stok - 1 
     WHERE id = '$tanaman_id'"
);

header("Location: ../../pages/plant.php");
exit;
