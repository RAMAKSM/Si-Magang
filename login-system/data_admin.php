<?php
session_start();
include "db.php";

// Cek apakah sudah login & role admin
if (!isset($_SESSION['username'])) {
  header("Location: login.php");
  exit;
}

// Filter pencarian
$where = "";
if (isset($_GET['cari']) && $_GET['cari'] != "") {
  $cari = mysqli_real_escape_string($conn, $_GET['cari']);
  $where = "WHERE nim LIKE '%$cari%' 
                OR nama LIKE '%$cari%' 
                OR prodi LIKE '%$cari%' 
                OR alamat LIKE '%$cari%' 
                OR universitas LIKE '%$cari%'";
}

// Query ambil data mahasiswa
$sql = "SELECT * FROM mahasiswa1 $where ORDER BY id DESC";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <title>Dashboard Data Admin</title>
  <link rel="stylesheet" href="stlye2.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="container mt-4">

  <nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4">
    <div class="container-fluid">
      <a class="navbar-brand">Si MagangOnline</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbars"
        aria-controls="navbars" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbars">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item"><a class="nav-link" href="admin_dashboard.php">Dashboard</a></li>

        </ul>
        <ul>
          <span class="navbar-text me-3">
            Halo, <?= htmlspecialchars($_SESSION['nama_lengkap']) ?> (<?= $_SESSION['role'] ?>)
          </span>
          <a class="btn btn-outline-light btn-sm" href="logout.php">Logout</a>
        </ul>
      </div>
    </div>
  </nav>




  <!-- ALERT NOTIFIKASI -->
  <?php if (isset($_SESSION['pesan'])): ?>
    <div id="alertBox" class="alert alert-<?= $_SESSION['status']; ?> alert-dismissible fade show" role="alert">
      <?= $_SESSION['pesan']; ?>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php unset($_SESSION['pesan'], $_SESSION['status']); ?>
  <?php endif; ?>


  <!-- FORM PENCARIAN -->
  <form method="get" class="mb-3">
    <div class="input-group">
      <input type="text" name="cari" class="form-control" placeholder="Cari NIM / Nama / Prodi..." value="<?= isset($_GET['cari']) ? $_GET['cari'] : '' ?>">
      <button type="submit" class="btn btn-primary">Cari</button>
    </div>
  </form>

  <!-- TABEL DATA -->
  <div class="table-responsive">
    <table class="table table-bordered table-striped align-middle">
      <thead class="table-success">
        <tr>
          <th>No</th>
          <th>NIM</th>
          <th>Nama</th>
          <th>Prodi</th>
          <th>Alamat</th>
          <th>Universitas</th>
          <th>Status</th>
          <th>Aksi</th>
          <th>Waktu Mulai</th>
          <th>Waktu Berakhir</th>
          <th>Surat Izin Magang</th>
          <th>Keputusan</th>
          <th>File</th>
        </tr>
      </thead>
      <tbody>
        <?php $no = 1;
        while ($row = mysqli_fetch_assoc($result)): ?>
          <tr>
            <td><?= $no++; ?></td>
            <td><?= $row['nim']; ?></td>
            <td><?= $row['nama']; ?></td>
            <td><?= $row['prodi']; ?></td>
            <td><?= $row['alamat']; ?></td>
            <td><?= $row['universitas']; ?></td>

            <!-- STATUS -->
            <td>
              <?php if ($row['status'] == 'pending'): ?>
                <span class="badge bg-warning text-dark">Pending</span>
              <?php elseif ($row['status'] == 'aktif'): ?>
                <span class="badge bg-success">Diterima</span>
              <?php elseif ($row['status'] == 'ditolak'): ?>
                <span class="badge bg-danger">Ditolak</span>
              <?php else: ?>
                <span class="badge bg-secondary">Tidak diketahui</span>
              <?php endif; ?>
            </td>


            <!-- AKSI EDIT HAPUS -->
            <td>
              <a href="edit.php?id=<?= $row['id']; ?>" class="btn btn-warning btn-sm mb-2">Edit</a>
              <br>
              <a href="hapus.php?id=<?= $row['id']; ?>" class="btn btn-danger btn-sm"
                onclick="return confirm('Yakin hapus data ini?')">Hapus</a>
            </td>

            <td><?= $row['waktu_mulai']; ?></td>
            <td><?= $row['waktu_berakhir']; ?></td>
            <td><?= $row['surat_izin_magang']; ?></td>

            <!-- KEPUTUSAN -->
            <td>
              <?php if ($row['status'] == 'pending'): ?>
                <a href="set_aktif.php?id=<?= $row['id']; ?>" class="btn btn-success btn-sm mb-2">Terima</a><br>
                <a href="set_ditolak.php?id=<?= $row['id']; ?>" class="btn btn-danger btn-sm">Tolak</a>

              <?php elseif ($row['status'] == 'aktif'): ?>
                <a href="set_pending.php?id=<?= $row['id']; ?>" class="btn btn-warning btn-sm mb-2">Pending</a><br>
                <a href="set_ditolak.php?id=<?= $row['id']; ?>" class="btn btn-danger btn-sm">Tolak</a>

              <?php elseif ($row['status'] == 'ditolak'): ?>
                <a href="set_pending.php?id=<?= $row['id']; ?>" class="btn btn-warning btn-sm mb-2">Pending</a><br>
                <a href="set_aktif.php?id=<?= $row['id']; ?>" class="btn btn-success btn-sm">Terima</a>
              <?php endif; ?>
            </td>


            <!-- FILE -->
            <td>
              <?php if (!empty($row['surat_izin_magang'])): ?>
                <a href="uploads/<?= $row['surat_izin_magang']; ?>" class="btn btn-primary btn-sm mb-2" download>Download</a>
                <a href="uploads/<?= $row['surat_izin_magang']; ?>" class="btn btn-info btn-sm" target="_blank">Preview</a>
              <?php else: ?>
                <span class="text-danger">Belum upload</span>
              <?php endif; ?>
            </td>
          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>

    <!-- SCRIPT -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
      // Auto-hide alert setelah 3 detik
      setTimeout(() => {
        let alertBox = document.getElementById('alertBox');
        if (alertBox) {
          let bsAlert = new bootstrap.Alert(alertBox);
          bsAlert.close();
        }
      }, 3000);
    </script>

</body>

</html>
