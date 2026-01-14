<?php
session_start();
require_once '../database/koneksi.php';

$kategoriID   = $_POST['kategori_id'] ?? '';
$nama         = $_POST['nama_tanaman'] ?? '';
$asalTanaman  = $_POST['asal_tanaman'] ?? '';
$deskripsi    = $_POST['deskripsi'] ?? '';
$harga        = $_POST['harga'] ?? '';
$stok        = $_POST['stok'] ?? '';
$status        = $_POST['status'] ?? '';
$musim        = $_POST['musim'] ?? '';
$foto         = $_FILES['foto'] ?? null;

if (
    empty($kategoriID) || empty($nama) || empty($asalTanaman) ||
    empty($deskripsi) || empty($musim) || empty($harga) || empty($stok) || empty($status) || !$foto
) {
    $_SESSION['errorTanaman'] = "Semua field wajib diisi";
    header("Location: ../pages/adminPlant.php");
    exit;
}

$uploadDir = "../uploads/";

$namaFile = time() . "_" . basename($foto['name']);
$targetFile = $uploadDir . $namaFile;

if (!move_uploaded_file($foto['tmp_name'], $targetFile)) {
    $_SESSION['errorTanaman'] = "Gagal upload foto";
    header("Location: ../pages/adminPlant.php");
    exit;
}

$kategoriID  = (int)$kategoriID;
$nama        = mysqli_real_escape_string($koneksi, $nama);
$asalTanaman = mysqli_real_escape_string($koneksi, $asalTanaman);
$deskripsi   = mysqli_real_escape_string($koneksi, $deskripsi);
$musim       = mysqli_real_escape_string($koneksi, $musim);
$harga       = (float)$harga;
$stok        = (int)$stok;
$status      = mysqli_real_escape_string($koneksi, $status);

$query = "INSERT INTO tanaman 
    (kategori_id, nama_tanaman, asal_tanaman, deskripsi_tanaman,harga, stok, status,  musim, foto,  created_at, updated_at)
    VALUES 
    ($kategoriID, '$nama', '$asalTanaman', '$deskripsi', $harga, $stok, '$status', '$musim', '$namaFile',  NOW(), NOW())";

$result = mysqli_query($koneksi, $query);

if ($result) {
    $_SESSION['successTanaman'] = "Tanaman berhasil ditambahkan";
} else {
    $_SESSION['errorTanaman'] = "Gagal menyimpan data";
}

header("Location: ../pages/adminPlant.php");
exit;
