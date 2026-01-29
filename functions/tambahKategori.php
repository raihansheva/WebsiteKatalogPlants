<?php
session_start();
require_once '../database/koneksi.php';


$nama = $_REQUEST['nama_kategori'];
$deskripsi = $_REQUEST['deskripsi'];

if (empty($nama) || empty($deskripsi)) {
    $_SESSION['errorKategori'] = "Username dan password wajib diisi";
    header("Location: ../pages/adminCategories.php");
    exit;
}

$query = "INSERT INTO kategori (nama_kategori, deskripsi, created_at, updated_at) 
          VALUES ('$nama', '$deskripsi' , now() , now())";
$result = mysqli_query($koneksi, $query);

header("Location: ../pages/adminCategories.php");
exit;