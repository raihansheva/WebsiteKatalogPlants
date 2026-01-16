<?php
session_start();
include __DIR__ . '/../database/koneksi.php';

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

if (empty($username) || empty($password)) {
    $_SESSION['error'] = "Username dan password wajib diisi";
    header("Location: ../index.php");
    exit;
}

$query = "SELECT * FROM users WHERE username = ?";
$stmt = mysqli_prepare($koneksi, $query);
mysqli_stmt_bind_param($stmt, "s", $username);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);
$user = mysqli_fetch_assoc($result);

if ($user['hak_akses'] == 'admin' && password_verify($password, $user['password'])) {
    $_SESSION['login'] = true;
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['username'] = $user['username'];

    header("Location: ../pages/dashboard.php");
    exit;
} else if ($user['hak_akses'] == 'user' && password_verify($password, $user['password'])) {
    $_SESSION['login'] = true;
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['username'] = $user['username'];
    $_SESSION['user'] = [
        'nama' => $nama,
        'username' => $username,
        'hak_akses' => 'user'
    ];
    $_SESSION['succesLogin'] = "Login berhasil";
    header("Location: ../index.php");
    exit;
} else {
    $_SESSION['error'] = "Username atau password salah";
    header("Location: ../index.php");
    exit;
}
