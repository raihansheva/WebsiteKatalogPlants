<?php
session_start();
require_once '../database/koneksi.php';

$nama = $_POST['nama'] ?? '';
$email    = $_POST['email'] ?? '';
$username    = $_POST['username'] ?? '';
$password    = $_POST['password'] ?? '';
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);
if (empty($nama) || empty($email) || empty($username) || empty($password)) {
    $_SESSION['errorRegis'] = "Semua field wajib diisi";
    header("Location: ../pages/index.php");
    exit;
}

$query = "INSERT INTO users (nama, email, username, password, hak_akses)
          VALUES ('$nama', '$email' , '$username' , '$hashedPassword' , 'user')";

if (mysqli_query($koneksi, $query)) {
    $_SESSION['user'] = [
        'nama' => $nama,
        'username' => $username,
        'hak_akses' => 'user'
    ];

    $_SESSION['successRegis'] = "Kategori berhasil ditambahkan";
} else {
    $_SESSION['errorRegis'] = "Gagal menambahkan kategori";
}


header("Location: ../pages/index.php");
exit;
