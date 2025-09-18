<?php
session_start();
include "db.php";

// Cek apakah user sudah login
if (!isset($_SESSION['nama_lengkap'])) {
  header("Location: auth.php");
  exit;
}
$nama_lengkap = isset($_SESSION['nama_lengkap']) ?
  $_SESSION['nama_lengkap'] : 'User';

?>

<?php if (isset($_SESSION['success'])): ?>
  <div class="alert alert-success"><?= $_SESSION['success']; ?></div>
  <?php unset($_SESSION['success']); ?>
<?php endif; ?>

<?php if (isset($_SESSION['error'])): ?>
  <div class="alert alert-danger"><?= $_SESSION['error']; ?></div>
  <?php unset($_SESSION['error']); ?>
<?php endif; ?>

<?php
$sql = "SELECT * FROM mahasiswa1 ORDER BY id DESC";
$result = mysqli_query($conn, $sql);
?>

<?php
// Query hitung data
$pending = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM mahasiswa1 WHERE status='pending'"))['total'];
$aktif = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM mahasiswa1 WHERE status='aktif'"))['total'];
$ditolak = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM mahasiswa1 WHERE status='ditolak'"))['total'];
?>



<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Dashboard</title>

  <!-- fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link
    href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,400;0,700;1,700&display=swap"
    rel="stylesheet" />

  <!-- feather Icons -->
  <script src="https://unpkg.com/feather-icons"></script>

  <!-- My Style -->
  <link rel="stylesheet" href="style2.css" />
</head>

<body>
  <!-- Navbar Start -->
  <nav class="navbar">
    <a href="#" class="navbar-logo"> Si <span>MagangOnline</span>.</a>
    <span class="welcome">Selamat datang, <?php echo ($nama_lengkap); ?></span>
    <div class="navbar-nav">
      <a href="profile.php">Profil</a>
      <a href="data_mahasiswa.php">Form Peserta</a>
      <a href="logout.php">Logout</a>

    </div>

    <div class="navbar-extra">
      <a href="#" id="search"><i data-feather="search"></i></a>
      <a href="#" id="hamburger-menu"><i data-feather="menu"></i></a>
    </div>
  </nav>
  <!-- Navbar End -->



  <!-- Hero Section Start -->
  <section class="hero" id="home">
    <main class="content">

      <h1>Selamat Datang Di Sistem Informasi Magang Online</h1>
      <p>
        Halo <b><?php echo $nama_lengkap; ?></b>, selamat datang di dashboard.
        Di sini kamu bisa mengisi form peserta, melihat status pengajuan,
        dan mengelola data magangmu dengan mudah.
      </p>

      <table>
        <div class="container mt-4">
          <div class="row">
            <!-- Menunggu Persetujuan -->
            <div class="col-md-4">
              <div class="card shadow-sm border-start border-4 border-purple">
                <div class="card-body">
                  <h6 class="text-purple">Menunggu Persetujuan</h6>
                  <h3><?= $pending; ?></h3>
                  <i class="bi bi-envelope float-end text-muted"></i>
                </div>
              </div>
            </div>

            <!-- Diterima -->
            <div class="col-md-4">
              <div class="card shadow-sm border-start border-4 border-success">
                <div class="card-body">
                  <h6 class="text-success">Diterima</h6>
                  <h3><?= $aktif; ?></h3>
                  <i class="bi bi-envelope float-end text-muted"></i>
                </div>
              </div>
            </div>

            <!-- Ditolak -->
            <div class="col-md-4">
              <div class="card shadow-sm border-start border-4 border-danger">
                <div class="card-body">
                  <h6 class="text-danger">Ditolak</h6>
                  <h3><?= $ditolak; ?></h3>
                  <i class="bi bi-envelope float-end text-muted"></i>
                </div>
              </div>
            </div>
          </div>
        </div>
      </table>
      <div>
    </main>
  </section>
  <!-- Hero Section End -->

  <!-- Feather Icons -->
  <script>
    feather.replace();
  </script>

  <!-- My javascript -->
  <script src="js/script2.js"></script>
</body>

</html>