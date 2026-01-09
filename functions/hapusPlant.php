<?php
session_start();
require_once '../database/koneksi.php';

if (!isset($_POST['idp'])) {
    die('ID tidak terkirim');
}

$id = (int) $_POST['idp'];

$queryFoto = "SELECT foto FROM tanaman WHERE id = $id";
$resultFoto = mysqli_query($koneksi, $queryFoto);
$data = mysqli_fetch_assoc($resultFoto);

if ($data && !empty($data['foto'])) {
    $pathFoto = "../uploads/" . $data['foto'];
    if (file_exists($pathFoto)) {
        unlink($pathFoto);
    }
}

$query = "DELETE FROM tanaman WHERE id = $id";
mysqli_query($koneksi, $query);

header("Location: ../pages/adminPlant.php");
exit;
