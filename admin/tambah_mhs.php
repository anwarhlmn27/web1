<?php session_start(); 
if (!isset($_SESSION['user_id'])) 
{ header("Location: login.php"); 
exit; 
} ?>
<!doctype html>
<html lang="en">
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
              <form action="../proses/crud.php" method="POST" enctype="multipart/form-data">

                  <input type="hidden" name="action" value="create">

                  <label>NIM</label><br>
                  <input type="text" name="nim" required><br>

                  <label>Nama</label><br>
                  <input type="text" name="nama" required><br>

                  <label>Program Studi</label><br>
                  <input type="text" name="prodi" required><br>

                  <label>Angkatan</label><br>
                  <input type="number" name="angkatan" required><br></br>

                  <label>Foto Mahasiswa:</label>
                  <input type="file" name="foto" accept="image/jpeg,image/png" required></br></br>


                  <button type="submit" class="btn btn-primary">Simpan</button>
              </form>
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
