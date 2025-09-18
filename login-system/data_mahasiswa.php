<?php
session_start();
include "db.php";

// Ambil semua data mahasiswa
$sql = "SELECT * FROM mahasiswa1 ORDER BY id DESC";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>

<head>
  <meta charset="UTF-8">
  <title>Dashboard</title>
  <link rel="stylesheet" href="stlye2.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>

  <h2>Data Mahasiswa</h2>
  <!-- Notifikasi -->
  <?php if (isset($_SESSION['success'])): ?>
    <div class="alert alert-success"><?= $_SESSION['success']; ?></div>
    <?php unset($_SESSION['success']); ?>
  <?php endif; ?>

  <?php if (isset($_SESSION['error'])): ?>
    <div class="alert alert-danger"><?= $_SESSION['error']; ?></div>
    <?php unset($_SESSION['error']); ?>
  <?php endif; ?>

  <a href="tambah.php" class="btn btn-primary mb-3">Tambah Data Perserta</a>

  <table class="table table-bordered">
    <thead>
      <tr>
        <th>No</th>
        <th>ID</th>
        <th>NIM</th>
        <th>Nama</th>
        <th>Prodi</th>
        <th>Alamat</th>
        <th>Universitas</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>

      <?php
      $no = 1;
      while ($row = mysqli_fetch_assoc($result)): ?>
        <tr>
          <td><?= $no++; ?></td>
          <td><?= $row['id']; ?></td>
          <td><?= $row['nim']; ?></td>
          <td><?= $row['nama']; ?></td>
          <td><?= $row['prodi']; ?></td>
          <td><?= $row['alamat']; ?></td>
          <td><?= $row['universitas']; ?></td>
          <td>
            <?php if ($row['status'] == 'pending'): ?>
              <span class="badge bg-warning">Pending</span>
            <?php elseif ($row['status'] == 'ditolak'): ?>
              <span class="badge bg-danger">Ditolak</span>
            <?php else: ?>
              <span class="badge bg-success">Aktif/Diterima</span>
            <?php endif; ?>

          </td>
          </td>
        </tr>
      <?php endwhile; ?>
    </tbody>
  </table>

  </section>
  </div>
</body>

</html>