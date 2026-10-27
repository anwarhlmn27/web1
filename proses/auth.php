<?php

session_start();

require "../koneksi/koneksi.php";


// ==========================================
// FUNCTION REGISTER
// ==========================================

function register($pdo)
{
    $nama     = $_POST['nama'];
    $email    = $_POST['email'];
    $password = $_POST['password'];

    // Hash password
    $password_hash = password_hash(
        $password,
        PASSWORD_DEFAULT
    );

    $cek = $pdo->prepare("SELECT * FROM users WHERE email = :email");
    $cek->execute(['email' => $email]);

    if ($cek->rowCount() > 0) {
        echo "<script>alert('Email sudah terdaftar, silahkan daftar dengan email lain!');
            window.location.href = '../register.php';
            </script>";
        exit();
    }

    try{
    // SQL INSERT
    $sql = "INSERT INTO users (nama, email, password)
            VALUES (:nama, :email, :password)";

    // Prepare
    $stmt = $pdo->prepare($sql);

    // Execute
    $stmt->execute([
        'nama'     => $nama,
        'email'    => $email,
        'password' => $password_hash
    ]);
    echo "<script>
        alert('Register berhasil!');
        window.location.href = '../index.php';</script>";
    }
    catch(PDOException $e){
        error_log($e->getMessage());
    echo "<script>alert('Register gagal!');
        window.location.href = '../register.php';
        </script>";
    }
}


// ==========================================
// FUNCTION LOGIN
// ==========================================

function login($pdo)
{
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
}


// ==========================================
// FUNCTION LOGOUT
// ==========================================

function logout()
{
    session_start();

    session_destroy();

    echo "<script>
        alert('Logout berhasil!');
        window.location.href = '../index.php';</script>";
    exit;
}


// ==========================================
// MENENTUKAN FUNCTION YANG DIJALANKAN
// ==========================================

$action = $_POST['action'] ?? $_GET['action'] ?? '';

if ($action == 'register') {

    register($pdo);

} elseif ($action == 'login') {

    login($pdo);

} elseif ($action == 'logout') {

    logout();

} else {

    echo "<script>alert('Aksi tidak dikenal.');</script>";
}