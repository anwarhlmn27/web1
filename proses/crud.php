<?php

require "../koneksi/koneksi.php";

$action = $_POST['action'] ?? $_GET['action'] ?? '';

if ($action == 'create') {

    $nim      = $_POST['nim'];
    $nama     = $_POST['nama'];
    $prodi    = $_POST['prodi'];
    $angkatan = $_POST['angkatan'];

    $file = $_FILES['foto'] ?? null;
    // 1. Validasi error upload & ukuran file (maks 2MB)
    if (!$file || $file['error'] !== UPLOAD_ERR_OK) {
        die("Upload gagal.");
    }
    if ($file['size'] > 2 * 1024 * 1024) {
        die("Ukuran file maksimal 2 MB.");
    }

    // 2. Cek MIME type & ekstensi
    $allowed = ['image/jpeg' => 'jpg', 'image/png' => 'png'];
    $mime = mime_content_type($file['tmp_name']);

    if (!isset($allowed[$mime])) {
        die("Format file tidak diperbolehkan.");
    }

    // 3. Simpan file
    $uploadDir = __DIR__ . '/../uploads/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    $fileName = uniqid('foto_',true) . '.' . $allowed[$mime];
    $path = 'uploads/' . $fileName;

    if (!move_uploaded_file($file['tmp_name'], $uploadDir . $fileName)) {
        die("File gagal disimpan.");
    }

    $sql = "INSERT INTO mahasiswa(nim, nama, prodi, angkatan, foto)
            VALUES (:nim, :nama, :prodi, :angkatan, :foto)";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'nim' => $nim, 'nama' => $nama,
        'prodi' => $prodi, 
        'angkatan' => $angkatan,
        'foto' => $path
    ]);

    echo "<script>
            alert('Data mahasiswa berhasil ditambahkan!');
            window.location='../admin/data_mahasiswa.php';
          </script>";

} elseif ($action == 'update') {

    $id       = $_POST['id'];
    $nim      = $_POST['nim'];
    $nama     = $_POST['nama'];
    $prodi    = $_POST['prodi'];
    $angkatan = $_POST['angkatan'];
    $file = $_FILES['foto'] ?? null;

    $stmt = $pdo->prepare("SELECT foto FROM mahasiswa WHERE id = :id");
    $stmt->execute(['id' => $id]);
    $path = $stmt->fetchColumn();

    if ($path === false) {
        die("Data mahasiswa tidak ditemukan.");
    }

    if ($file && $file['error'] !== UPLOAD_ERR_NO_FILE) {
        if ($file['error'] !== UPLOAD_ERR_OK) {
            die("Upload gagal.");
        }
        if ($file['size'] > 2 * 1024 * 1024) {
            die("Ukuran file maksimal 2 MB.");
        }

        $allowed = ['image/jpeg' => 'jpg', 'image/png' => 'png'];
        $mime = mime_content_type($file['tmp_name']);

        if (!isset($allowed[$mime])) {
            die("Format file tidak diperbolehkan.");
        }

        $uploadDir = __DIR__ . '/../uploads/';
        if (!is_dir($uploadDir) && !mkdir($uploadDir, 0755, true)) {
            die("Folder upload gagal dibuat.");
        }

        $fileName = uniqid('foto_', true) . '.' . $allowed[$mime];
        $path = 'uploads/' . $fileName;

        if (!move_uploaded_file($file['tmp_name'], $uploadDir . $fileName)) {
            die("File gagal disimpan.");
        }
    }

    $sql = "UPDATE mahasiswa SET nim = :nim, nama = :nama,
                prodi = :prodi, angkatan = :angkatan, foto = :foto
            WHERE id = :id";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'id' => $id, 
        'nim' => $nim, 
        'nama' => $nama,
        'prodi' => $prodi, 
        'angkatan' => $angkatan, 
        'foto' => $path
    ]);

    echo "<script>
            alert('Data mahasiswa berhasil diubah!');
            window.location='../admin/data_mahasiswa.php';
          </script>";

} elseif ($action == 'delete') {

    $id = $_GET['id'];

    $sql = "DELETE FROM mahasiswa WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => $id]);

    echo "<script>
            alert('Data mahasiswa berhasil dihapus!');
            window.location='../admin/data_mahasiswa.php';
          </script>";

} else {

    echo "<script>
            alert('Aksi tidak dikenal!');
            window.location='../admin/data_mahasiswa.php';
          </script>";
}
