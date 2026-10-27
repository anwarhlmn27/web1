<!doctype html>
<html lang="en">
  <?php 
    require_once '../layouts/header.php';
  ?>
  <body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
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
      <main class="app-main">
        <div class="app-content-header">
          <div class="container-fluid">
            <div class="row">
              <div class="col-sm-6">
                <h1 class="mb-0 fs-3">Data Tables</h1>
              </div>
              <div class="col-sm-6">
                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item"><a href="#">Tables</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Data</li>
                  </ol>
                </nav>
              </div>
            </div>
          </div>
        </div>
        <div class="app-content">
          <div class="container-fluid">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Users</h3>
                <div class="card-tools">
                  <div class="input-group input-group-sm" style="width: 16rem">
                    <span class="input-group-text">
                      <i class="bi bi-search" aria-hidden="true"></i>
                    </span>
                    <input
                      id="table-filter"
                      type="search"
                      class="form-control"
                      placeholder="Filter rows&hellip;"
                      aria-label="Filter rows"
                    />
                  </div>
                </div>
              </div>
              <div class="card-body">
                <div class="d-flex gap-2 mb-3">
                  <button id="export-csv" type="button" class="btn btn-sm btn-outline-secondary">
                    <i class="bi bi-filetype-csv me-1" aria-hidden="true"></i>
                    Export CSV
                  </button>
                  <button id="export-json" type="button" class="btn btn-sm btn-outline-secondary">
                    <i class="bi bi-filetype-json me-1" aria-hidden="true"></i>
                    Export JSON
                  </button>
                  <button id="print-table" type="button" class="btn btn-sm btn-outline-secondary">
                    <i class="bi bi-printer me-1" aria-hidden="true"></i>
                    Print
                  </button>
                </div>
                <div id="users-table"></div>
              </div>
              <div class="card-footer text-secondary small">
                Powered by
                <a href="https://tabulator.info/" target="_blank" rel="noopener">Tabulator</a>
                &mdash; vanilla JS, no jQuery required.
              </div>
            </div>
          </div>
        </div>
      </main>
      <!--begin::Footer-->
      <footer class="app-footer">
        <!--begin::To the end-->
        <div class="float-end d-none d-sm-inline">Anything you want</div>
        <!--end::To the end-->
        <!--begin::Copyright-->
        <strong>
          Copyright &copy; 2014-2026&nbsp;
          <a href="https://adminlte.io" class="text-decoration-none">AdminLTE.io</a>.
        </strong>
        All rights reserved.
        <!--end::Copyright-->
      </footer>
      <!--end::Footer-->
    </div>
    <!--begin::Third Party Plugin(OverlayScrollbars)-->
    <script
      src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/browser/overlayscrollbars.browser.es6.min.js"
      crossorigin="anonymous"
    ></script>
    <!--end::Third Party Plugin(OverlayScrollbars)--><!--begin::Required Plugin(popperjs for Bootstrap 5)-->
    <script
      src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
      crossorigin="anonymous"
    ></script>
    <!--end::Required Plugin(popperjs for Bootstrap 5)--><!--begin::Required Plugin(Bootstrap 5)-->
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.min.js"
      crossorigin="anonymous"
    ></script>
    <!--end::Required Plugin(Bootstrap 5)--><!--begin::Required Plugin(AdminLTE)-->
    <script src="../js/adminlte.js"></script>
    <!--end::Required Plugin(AdminLTE)-->
    <!--begin::OverlayScrollbars Configure-->
    <script>
      const SELECTOR_SIDEBAR_WRAPPER = '.sidebar-wrapper';
      const Default = {
        scrollbarTheme: 'os-theme-light',
        scrollbarAutoHide: 'leave',
        scrollbarClickScroll: true,
      };
      document.addEventListener('DOMContentLoaded', function () {
        const sidebarWrapper = document.querySelector(SELECTOR_SIDEBAR_WRAPPER);

        // Disable OverlayScrollbars on mobile devices to prevent touch interference
        const isMobile = window.innerWidth <= 992;

        if (
          sidebarWrapper &&
          OverlayScrollbarsGlobal?.OverlayScrollbars !== undefined &&
          !isMobile
        ) {
          OverlayScrollbarsGlobal.OverlayScrollbars(sidebarWrapper, {
            scrollbars: {
              theme: Default.scrollbarTheme,
              autoHide: Default.scrollbarAutoHide,
              clickScroll: Default.scrollbarClickScroll,
            },
          });
        }
      });
    </script>
    <!--end::OverlayScrollbars Configure-->

    <!--begin::Color Mode Toggle-->
    <!-- The light/dark/auto switcher ships in adminlte.js as the ColorMode
     module (since 4.1) — no page script needed. Only the no-flash snippet
     in <head> stays inline, because it must run before first paint. -->
    <!--end::Color Mode Toggle-->

    <script
      src="https://cdn.jsdelivr.net/npm/tabulator-tables@6.4.0/dist/js/tabulator.min.js"
      crossorigin="anonymous"
    ></script>
    <script>
      const statusBadge = (cell) => {
        const value = cell.getValue();
        const map = { Active: 'success', Invited: 'info', Suspended: 'secondary' };
        const color = map[value] || 'secondary';
        return `<span class="badge text-bg-${color}">${value}</span>`;
      };

      document.addEventListener('DOMContentLoaded', () => {
        const data = [
          {
            id: 1,
            name: 'Olivia Bennett',
            email: 'olivia@example.com',
            role: 'Admin',
            status: 'Active',
            joined: '2024-03-12',
          },
          {
            id: 2,
            name: 'Liam Carter',
            email: 'liam@example.com',
            role: 'Editor',
            status: 'Active',
            joined: '2024-04-08',
          },
          {
            id: 3,
            name: 'Emma Dawson',
            email: 'emma@example.com',
            role: 'Viewer',
            status: 'Invited',
            joined: '2024-06-21',
          },
          {
            id: 4,
            name: 'Noah Evans',
            email: 'noah@example.com',
            role: 'Editor',
            status: 'Suspended',
            joined: '2024-07-15',
          },
          {
            id: 5,
            name: 'Ava Foster',
            email: 'ava@example.com',
            role: 'Admin',
            status: 'Active',
            joined: '2024-08-30',
          },
          {
            id: 6,
            name: 'Ethan Grant',
            email: 'ethan@example.com',
            role: 'Viewer',
            status: 'Active',
            joined: '2024-09-14',
          },
          {
            id: 7,
            name: 'Sophia Hayes',
            email: 'sophia@example.com',
            role: 'Editor',
            status: 'Active',
            joined: '2024-10-02',
          },
          {
            id: 8,
            name: 'Mason Ingram',
            email: 'mason@example.com',
            role: 'Viewer',
            status: 'Invited',
            joined: '2024-11-19',
          },
          {
            id: 9,
            name: 'Isabella Jones',
            email: 'isabella@example.com',
            role: 'Admin',
            status: 'Active',
            joined: '2025-01-05',
          },
          {
            id: 10,
            name: 'Lucas Klein',
            email: 'lucas@example.com',
            role: 'Viewer',
            status: 'Suspended',
            joined: '2025-02-18',
          },
          {
            id: 11,
            name: 'Mia Lopez',
            email: 'mia@example.com',
            role: 'Editor',
            status: 'Active',
            joined: '2025-03-22',
          },
          {
            id: 12,
            name: 'Logan Moore',
            email: 'logan@example.com',
            role: 'Viewer',
            status: 'Active',
            joined: '2025-04-09',
          },
          {
            id: 13,
            name: 'Charlotte Nelson',
            email: 'charlotte@example.com',
            role: 'Admin',
            status: 'Active',
            joined: '2025-04-27',
          },
          {
            id: 14,
            name: 'Henry Owens',
            email: 'henry@example.com',
            role: 'Editor',
            status: 'Invited',
            joined: '2025-05-11',
          },
          {
            id: 15,
            name: 'Amelia Price',
            email: 'amelia@example.com',
            role: 'Viewer',
            status: 'Active',
            joined: '2025-05-17',
          },
        ];

        const table = new Tabulator('#users-table', {
          data: data,
          layout: 'fitColumns',
          pagination: true,
          paginationSize: 10,
          paginationSizeSelector: [10, 25, 50, 100],
          movableColumns: true,
          columns: [
            { title: '#', field: 'id', width: 60, headerSort: true },
            { title: 'Name', field: 'name', headerFilter: 'input' },
            { title: 'Email', field: 'email', headerFilter: 'input' },
            {
              title: 'Role',
              field: 'role',
              headerFilter: 'list',
              headerFilterParams: { values: ['', 'Admin', 'Editor', 'Viewer'] },
              width: 120,
            },
            {
              title: 'Status',
              field: 'status',
              formatter: statusBadge,
              headerFilter: 'list',
              headerFilterParams: { values: ['', 'Active', 'Invited', 'Suspended'] },
              width: 130,
              hozAlign: 'center',
            },
            { title: 'Joined', field: 'joined', sorter: 'date', width: 130 },
          ],
        });

        document.getElementById('table-filter').addEventListener('input', (e) => {
          const value = e.target.value;
          if (value) {
            table.setFilter([
              [
                { field: 'name', type: 'like', value: value },
                { field: 'email', type: 'like', value: value },
              ],
            ]);
          } else {
            table.clearFilter();
          }
        });

        document
          .getElementById('export-csv')
          .addEventListener('click', () => table.download('csv', 'users.csv'));
        document
          .getElementById('export-json')
          .addEventListener('click', () => table.download('json', 'users.json'));
        document
          .getElementById('print-table')
          .addEventListener('click', () => table.print(false, true));
      });
    </script>
  </body>
</html>

<?php 
              require "../koneksi/koneksi.php";

                $sql = "SELECT * FROM mahasiswa ORDER BY id DESC";
                $stmt = $pdo->prepare($sql);
                $stmt->execute();
                $dataMahasiswa = $stmt->fetchAll();

                ?>
