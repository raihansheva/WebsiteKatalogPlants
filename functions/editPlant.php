<?php
session_start();
require_once '../database/koneksi.php';

$id           = $_POST['id'] ?? '';
$kategori_id  = $_POST['kategori_id'] ?? '';
$nama         = $_POST['nama_tanaman'] ?? '';
$asal         = $_POST['asal_tanaman'] ?? '';
$deskripsi    = $_POST['deskripsi'] ?? '';
$musim        = $_POST['musim'] ?? '';

if (empty($id) || empty($kategori_id) || empty($nama) || empty($asal) || empty($deskripsi) || empty($musim)) {
    $_SESSION['errorPlant'] = "Semua field wajib diisi";
    header("Location: ../pages/adminPlant.php");
    exit;
}

$queryOld = "SELECT foto FROM tanaman WHERE id = $id";
$resultOld = mysqli_query($koneksi, $queryOld);
$dataOld = mysqli_fetch_assoc($resultOld);

$fotoLama = $dataOld['foto'];
$fotoBaru = $fotoLama;

if (!empty($_FILES['foto']['name'])) {
    $namaFile = time() . '_' . $_FILES['foto']['name'];
    $tmpFile  = $_FILES['foto']['tmp_name'];
    $path     = "../uploads/" . $namaFile;

    if (move_uploaded_file($tmpFile, $path)) {
        if (!empty($fotoLama) && file_exists("../uploads/" . $fotoLama)) {
            unlink("../uploads/" . $fotoLama);
        }
        $fotoBaru = $namaFile;
    } else {
        $_SESSION['errorPlant'] = "Gagal upload foto";
        header("Location: ../pages/adminPlant.php");
        exit;
    }
}

$query = "UPDATE tanaman SET
            kategori_id = '$kategori_id',
            nama_tanaman = '$nama',
            asal_tanaman = '$asal',
            deskripsi_tanaman = '$deskripsi',
            musim = '$musim',
            foto = '$fotoBaru',
            updated_at = NOW()
          WHERE id = $id";

mysqli_query($koneksi, $query);

$_SESSION['successPlant'] = "Data tanaman berhasil diperbarui";
header("Location: ../pages/adminPlant.php");
exit;
