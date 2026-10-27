<?php

require "../koneksi/koneksi.php";

// Ambil data dari form
$nama     = $_POST['nama'];
$email    = $_POST['email'];
$password = $_POST['password'];//123456  

// Hash password
$password_hash = password_hash(
    $password,
    PASSWORD_DEFAULT
); //$2y$10$p730fvzSJ0UjMRs1Q.LTy.e71IjdxNS9X3/HexGHsKKK7SvslD08W 

//memastikan apakah email sudah terdaftar atau belum
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