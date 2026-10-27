<?php

session_start();

require "../koneksi/koneksi.php";

// Ambil data dari form
$email    = $_POST['email'];
$password = $_POST['password'];

// Cari user berdasarkan email
$sql = "SELECT * FROM users WHERE email = :email";

$stmt = $pdo->prepare($sql);

$stmt->execute([
    'email' => $email
]);

// Ambil data user
$user = $stmt->fetch();

// Cek user dan password
if ($user && password_verify($password, $user['password'])) {

    // Simpan data user ke session
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['nama']    = $user['nama'];
    $_SESSION['email']   = $user['email'];

    // alert berhasil login dan redirect ke dashboard
    echo "<script>
        alert('Login berhasil!');
        window.location.href = '../admin/dashboard.php';</script>"; 
    exit;

} else {
    echo "<script>
        alert('Email atau password salah!');
        window.location.href = '../index.php';</script>";
    exit;
}