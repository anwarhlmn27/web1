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

              $id = $_GET['id'];

              $sql = "SELECT * FROM mahasiswa WHERE id = :id";
              $stmt = $pdo->prepare($sql);
              $stmt->execute(['id' => $id]);
              $mahasiswa = $stmt->fetch();
              ?>

              <form action="../proses/crud.php" method="POST"  enctype="multipart/form-data">

                     <input type="hidden" name="action" value="update">
                     <input type="hidden" name="id" value="<?= $mahasiswa['id']; ?>">

                     <label>NIM</label><br>
                     <input type="text" name="nim"
                            value="<?= $mahasiswa['nim']; ?>" required><br><br>

                     <label>Nama</label><br>
                     <input type="text" name="nama"
                            value="<?= $mahasiswa['nama']; ?>" required><br><br>

                     <label>Program Studi</label><br>
                     <input type="text" name="prodi"
                            value="<?= $mahasiswa['prodi']; ?>" required><br><br>

                     <label>Angkatan</label><br>
                     <input type="number" name="angkatan"
                            value="<?= $mahasiswa['angkatan']; ?>" required><br><br>
                     
                     <label>Foto Mahasiswa:</label><br>
                     <input type="file" name="foto" accept="image/*" value=""><br>
                     <label>Foto Saat Ini:</label><br>
                     <img src="../<?= htmlspecialchars($mahasiswa['foto']) ?>"
                      alt="Foto Mahasiswa"
                      width="50">
                     <br><br>
                     <button type="submit" class="btn btn-primary">Update</button>
              </form>
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