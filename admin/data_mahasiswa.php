<?php session_start(); 
if (!isset($_SESSION['user_id'])) 
{ header("Location: login.php"); 
exit; 
} ?>
<!doctype html>
<html lang="en">
  
  <link rel="stylesheet" href="https://cdn.datatables.net/3.1.4/css/dataTables.dataTables.min.css">
  <script src="https://cdn.datatables.net/3.1.4/js/dataTables.min.js" ></script>
  
  <!--begin::Head-->
  <?php require_once '../layouts/header.php'; ?>
  <!--end::Head-->
  <!--begin::Body-->
  <body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
    <!--begin::App Wrapper-->
    <div class="app-wrapper">
      <!--begin::Header-->
      <?php 
      require_once '../layouts/navbar.php';
      ?>
      <!--end::Header-->
      <!--begin::Sidebar-->
      <?php     
        require_once '../layouts/sidebar.php'; 
      ?>
      <!--end::Sidebar-->
      <!--begin::App Main-->
      <main class="app-main">
        <!--begin::App Content Header-->
        <div class="app-content-header">
          <!--begin::Container-->
          <div class="container-fluid">
            <!--begin::Row-->
            <div class="row">
              <div class="col-sm-6">
                <h1 class="mb-0 fs-3">Data Mahasiswa</h1>
              </div>
              <div class="col-sm-6">
                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Data Mahasiswa</li>
                  </ol>
                </nav>
              </div>
            </div>
            <!--end::Row-->
          </div>
          <!--end::Container-->
        </div>
        <!--end::App Content Header-->
        <!--begin::App Content-->
        <div class="app-content">
          <!--begin::Container-->
          <div class="container-fluid">
            <!--begin::Row-->
            <div class="row">
              <!--begin::Col-->
                <!-- Form Pencarian (Method GET) -->

                <?php

                require "../koneksi/koneksi.php";
                // 1. Konfigurasi Pagination
                $batas = 5; // Jumlah data per halaman
                $halaman = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                $halaman = ($halaman > 0) ? $halaman : 1;
                $offset = ($halaman - 1) * $batas;

                // 2. Menangkap Kata Kunci Pencarian
                $keyword = isset($_GET['search']) ? trim($_GET['search']) : '';

                // Query untuk menghitung total data
                $sql_count = "SELECT COUNT(*) FROM mahasiswa WHERE nama LIKE :keyword";
                $stmt_count = $pdo->prepare($sql_count);
                $stmt_count->bindValue(':keyword', "%$keyword%");
                $stmt_count->execute();
                $total_data = $stmt_count->fetchColumn();

                // Menghitung total halaman
                $total_halaman = ceil($total_data / $batas);

                // Query utama untuk mengambil data dengan limitasi
                $sql = "SELECT * FROM mahasiswa WHERE nama LIKE :keyword ORDER BY id DESC LIMIT :limit OFFSET :offset";
                $stmt = $pdo->prepare($sql);

                // Bind parameter secara spesifik
                $stmt->bindValue(':keyword', "%$keyword%", PDO::PARAM_STR);
                $stmt->bindValue(':limit', $batas, PDO::PARAM_INT);
                $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
                $stmt->execute();
                $data_mahasiswa = $stmt->fetchAll(PDO::FETCH_ASSOC);
                ?>
                <form method="GET" action="" class="mb-3">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="Cari nama mahasiswa..." value="<?= htmlspecialchars($keyword) ?>">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="submit">Cari</button>
                        </div>
                    </div>
                </form> 
                <a href="tambah_mhs.php">Tambah Mahasiswa</a>

                <table border="1" cellpadding="8" class="table table-bordered table-striped" >
                <tr>
                    <th>No</th>
                    <th>NIM</th>
                    <th>Nama</th>
                    <th>Program Studi</th>
                    <th>Angkatan</th>
					<th>Foto</th>
                    <th>Aksi</th>
                </tr>

                <?php 
                if (count($data_mahasiswa) > 0) {
                  foreach ($data_mahasiswa as $mahasiswa) { ?>
                <tr>
                    <td><?= $mahasiswa['id']; ?></td>
                    <td><?= $mahasiswa['nim']; ?></td>
                    <td><?= $mahasiswa['nama']; ?></td>
                    <td><?= $mahasiswa['prodi']; ?></td>
                    <td><?= $mahasiswa['angkatan']; ?></td>
                    <td><img src="../<?= htmlspecialchars($mahasiswa['foto']) ?>"
                      alt="Foto"
                      width="50"></td>
                    <td>
                        <a href="edit_mhs.php?id=<?= $mahasiswa['id']; ?>">Edit</a> |
                        <a href="../proses/crud.php?action=delete&id=<?= $mahasiswa['id']; ?>"
                        onclick="return confirm('Yakin ingin menghapus data ini?')">
                        Hapus
                        </a>
                    </td>
                </tr>
                <?php } 
                } else { ?>
                    <tr><td class="text-center">Data tidak ditemukan.</td></tr>
                <?php } ?>
                </table>
                <!-- Navigasi Pagination Bootstrap -->
              <nav>
                  <ul class="pagination justify-content-center">
                      <!-- Tombol Sebelumnya -->
                      <li class="page-item <?= ($halaman <= 1) ? 'disabled' : '' ?>">
                          <a class="page-link" href="?page=<?= $halaman - 1 ?>&search=<?= htmlspecialchars($keyword) ?>">Previous</a>
                      </li>

                      <!-- Angka Halaman -->
                      <?php for ($i = 1; $i <= $total_halaman; $i++) { ?>
                          <li class="page-item <?= ($i == $halaman) ? 'active' : '' ?>">
                              <a class="page-link" href="?page=<?= $i ?>&search=<?= htmlspecialchars($keyword) ?>"><?= $i ?></a>
                          </li>
                      <?php } ?>

                      <!-- Tombol Selanjutnya -->
                      <li class="page-item <?= ($halaman >= $total_halaman) ? 'disabled' : '' ?>">
                          <a class="page-link" href="?page=<?= $halaman + 1 ?>&search=<?= htmlspecialchars($keyword) ?>">Next</a>
                      </li>
                  </ul>
              </nav>
              <!--end::Col-->
            </div>
            
            <!--end::Row-->
          </div>
          <!--end::Container-->
        </div>
        <!--end::App Content-->
      </main>
      <!--end::App Main-->
      <!--begin::Footer-->
      <?php 
        require_once '../layouts/footer.php';
      ?>

<script>
 new DataTable('#example');
</script>
