<?php 
// 1. Parameter Konfigurasi Server
$host     = 'localhost';
$dbname   = 'db_web1';
$username = 'root';
$password = '';

// 2. Data Source Name (DSN)
$dsn = "mysql:host={$host};dbname={$dbname}";

// 3. Opsi Konfigurasi PDO
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Lempar Exception jika ada error SQL
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // Ambil data dalam bentuk Array Asosiatif
    PDO::ATTR_EMULATE_PREPARES   => false,                  // Gunakan Native Prepared Statement MySQL
];

// 4. Inisialisasi Koneksi & Exception Handling
// 4. Inisialisasi Koneksi & Exception Handling
try {
    $pdo = new PDO($dsn, $username, $password, $options);
    //echo "<p>Koneksi database berhasil.</p>";
} catch (PDOException $e) {
    // Tampilkan detail error asli ke layar
    echo "<h3>Koneksi database gagal!</h3>";
    echo "<p>Pesan Error: " . $e->getMessage() . "</p>";
    echo "<p>Terjadi di file: " . $e->getFile() . " pada baris " . $e->getLine() . "</p>";
}


?>