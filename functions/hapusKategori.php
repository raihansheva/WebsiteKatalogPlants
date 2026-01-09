<?php
session_start();
require_once '../database/koneksi.php';

if (!isset($_POST['idp'])) {
    die('ID tidak terkirim');
}

$id = (int) $_POST['idp'];

$query = "DELETE FROM kategori WHERE id=$id";
mysqli_query($koneksi, $query);

header("Location: ../pages/adminCategories.php");
exit;