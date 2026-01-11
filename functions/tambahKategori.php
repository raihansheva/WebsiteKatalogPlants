<?php
session_start();
require_once '../database/koneksi.php';

$namaKategori = $_POST['nama_kategori'] ?? '';
$deskripsi    = $_POST['deskripsi'] ?? '';

if (empty($namaKategori) || empty($deskripsi)) {
    $_SESSION['errorKategori'] = "Semua field wajib diisi";
    header("Location: ../pages/adminCategories.php");
    exit;
}

$query = "INSERT INTO kategori (nama_kategori, deskripsi)
          VALUES ('$namaKategori', '$deskripsi')";

if (mysqli_query($koneksi, $query)) {
    $_SESSION['successKategori'] = "Kategori berhasil ditambahkan";
} else {
    $_SESSION['errorKategori'] = "Gagal menambahkan kategori";
}

header("Location: ../pages/adminCategories.php");
exit;
