<?php
session_start();
require_once __DIR__ . '/../database/koneksi.php';

$id        = $_POST['id'] ?? '';
$nama      = $_POST['nama_kategori'] ?? '';
$deskripsi = $_POST['deskripsi'] ?? '';

if (empty($id) || empty($nama) || empty($deskripsi)) {
    $_SESSION['errorUpdateKat'] = "Nama kategori dan deskripsi wajib diisi";
    header("Location: ../pages/adminCategories.php");
    exit;
}

$query = "UPDATE kategori 
          SET nama_kategori = '$nama',
              deskripsi = '$deskripsi',
              updated_at = NOW()
          WHERE id = $id";

$result = mysqli_query($koneksi, $query);

if ($result) {
    $_SESSION['successUpdateKat'] = "Kategori berhasil diperbarui";
} else {
    $_SESSION['errorUpdateKat'] = "Gagal update kategori";
}

header("Location: ../pages/adminCategories.php");
exit;
