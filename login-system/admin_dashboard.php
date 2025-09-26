<?php
session_start();
include "db.php";

// Cek role admin
if ($_SESSION['role'] !== 'admin') {
  die("Akses ditolak. Halaman ini khusus untuk admin.");
}

// Cek login
if (!isset($_SESSION['nama_lengkap'])) {
  header("Location: auth.php");
  exit;
}
$nama_lengkap = $_SESSION['nama_lengkap'];

// Ambil data statistik
$pending = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM mahasiswa1 WHERE status='pending'"))['total'];
$aktif   = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM mahasiswa1 WHERE status='aktif'"))['total'];
$ditolak = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM mahasiswa1 WHERE status='ditolak'"))['total'];

// Query daftar mahasiswa
$sql = "SELECT * FROM mahasiswa1 ORDER BY id DESC";
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Admin Dashboard</title>

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom CSS -->
  <link rel="stylesheet" href="css/style2.css">
</head>

<body>
  <!-- Topbar -->
  <nav class="topbar d-flex justify-content-between align-items-center px-3">
    <button class="btn btn-light btn-sm" id="toggleSidebar">☰</button>
    <div>
      <span class="text-white me-3">👋 Hai, <?= htmlspecialchars($nama_lengkap) ?></span>
      <a href="logout.php" class="btn btn-primary">Logout</a>
    </div>
  </nav>

  <!-- Overlay -->
  <div class="overlay" id="overlay"></div>

  <!-- Sidebar -->
  <div class="sidebar" id="sidebar">
    <a href="admin_dashboard.php" class="d-flex align-items-center mb-3 text-decoration-none text-white">
      <span class="fs-4 fw-bold">SiMagangOnline</span>
    </a>
    <hr class="border-light" />
    <ul class="nav nav-pills flex-column mb-auto">
      <li class="nav-item"><a href="admin_dashboard.php" class="nav-link active">Dashboard</a></li>
      <li><a href="data_admin.php" class="nav-link">Kelola Peserta</a></li>
      <li><a href="profile.php" class="nav-link">Profil</a></li>
    </ul>
    <hr class="border-dark" />
    <div class="dropdown">
      <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
        <strong><?= htmlspecialchars($nama_lengkap) ?></strong>
      </a>
      <ul class="dropdown-menu text-small shadow">
        <li><a class="dropdown-item" href="profile.php">Settings</a></li>
        <li><a class="dropdown-item" href="profile.php">Profile</a></li>
        <li>
          <hr class="dropdown-divider" />
        </li>
        <li><a class="dropdown-item" href="logout.php"> Logout</a></li>
      </ul>
    </div>
  </div>

  <!-- Main Content -->
  <main class="content">
    <div class="container-fluid p-4">
      <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success"><?= $_SESSION['success']; ?></div>
        <?php unset($_SESSION['success']); ?>
      <?php endif; ?>

      <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger"><?= $_SESSION['error']; ?></div>
        <?php unset($_SESSION['error']); ?>
      <?php endif; ?>

      <h1 class="mb-4">Selamat Datang di Sistem Informasi Magang Online</h1>

      <!-- Statistik -->
      <div class="row mb-4">
        <div class="col-md-4">
          <div class="card text-dark bg-warning mb-3">
            <div class="card-body text-center">
              <h5 class="card-title">Jumlah Pendaftar</h5>
              <h2><?= $pending; ?></h2>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card text-white bg-success mb-3">
            <div class="card-body text-center">
              <h5 class="card-title">Diterima</h5>
              <h2><?= $aktif; ?></h2>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card text-white bg-danger mb-3">
            <div class="card-body text-center">
              <h5 class="card-title">Ditolak</h5>
              <h2><?= $ditolak; ?></h2>
            </div>
          </div>
        </div>
      </div>

      <!-- Tabel Data Mahasiswa -->
      <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
          <h5 class="mb-0">Daftar Mahasiswa Magang</h5>
        </div>
        <div class="card-body">
          <table class="table table-striped table-hover text-center align-middle">
            <thead class="table-success">
              <tr>
                <th>No</th>
                <th>NIM</th>
                <th>Nama Lengkap</th>
                <th>Prodi</th>
                <th>Alamat</th>
                <th>Status</th>
              </tr>
            </thead>

            <tbody>
              <?php if (mysqli_num_rows($result) > 0): ?>
                <?php $no = 1;
                while ($row = mysqli_fetch_assoc($result)): ?>
                  <tr>
                    <td><?= $no++; ?></td>
                    <td><?= htmlspecialchars($row['nim']); ?></td>
                    <td><?= htmlspecialchars($row['nama']); ?></td>
                    <td><?= htmlspecialchars($row['prodi']); ?></td>
                    <td><?= htmlspecialchars($row['alamat']); ?></td>
                    <td>
                      <?php if ($row['status'] == 'pending'): ?>
                        <span class="badge bg-warning text-dark">Pending</span>
                      <?php elseif ($row['status'] == 'aktif'): ?>
                        <span class="badge bg-success">Aktif</span>
                      <?php else: ?>
                        <span class="badge bg-danger">Ditolak</span>
                      <?php endif; ?>
                    </td>

                  </tr>
                <?php endwhile; ?>
              <?php else: ?>
                <tr>
                  <td colspan="7">Belum ada data mahasiswa.</td>
                </tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </main>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <!-- Custom JS -->
  <script src="js/script3.js"></script>
</body>

</html>
