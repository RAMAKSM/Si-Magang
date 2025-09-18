<?php
session_start();
include "db.php";

// Cek apakah sudah login & role admin

// Ambil data mahasiswa dengan filter pencarian

// Cek apakah ada pencarian
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
  <title>Dashboard Admin</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="container mt-4">

  <h2>Selamat datang, <?= $_SESSION['username']; ?> (Admin)</h2>
  <a href="logout.php" class="btn btn-danger mb-3">Logout</a>

  <form method="get" class="mb-3">
    <div class="input-group">
      <input type="text" name="cari" class="form-control" placeholder="Cari NIM / Nama / Prodi..." value="<?= isset($_GET['cari']) ? $_GET['cari'] : '' ?>">
      <button type="submit" class="btn btn-primary">Cari</button>
    </div>
  </form>

  <table class="table table-bordered">
    <thead>
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

          <td>
            <?php if ($row['status'] == 'pending'): ?>
              <a href="set_aktif.php?id=<?= $row['id']; ?>" class="btn btn-success btn-sm">Aktif</a>
            <?php else: ?>
              <a href="set_pending.php?id=<?= $row['id']; ?>" class="btn btn-secondary btn-sm">Pending</a>
            <?php endif; ?>
          </td>
          <td>
            <a href="edit.php?id=<?= $row['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
            <a href="hapus.php?id=<?= $row['id']; ?>" class="btn btn-danger btn-sm"
              onclick="return confirm('Yakin hapus data ini?')">Hapus</a>
          </td>
          <td><?= $row['waktu_mulai']; ?></td>
          <td><?= $row['waktu_berakhir']; ?></td>
          <td><?= $row['surat_izin_magang']; ?></td>

          <td>
            <?php if ($row['status'] == 'pending'): ?>
              <a href="set_aktif.php?id=<?= $row['id']; ?>" class="btn btn-success btn-sm">Aktif/Diterima</a>
              <a href="set_ditolak.php?id=<?= $row['id']; ?>" class="btn btn-danger btn-sm">Tolak</a>

            <?php elseif ($row['status'] == 'aktif'): ?>
              <a href="set_pending.php?id=<?= $row['id']; ?>" class="btn btn-secondary btn-sm">Pending</a>
              <a href="set_ditolak.php?id=<?= $row['id']; ?>" class="btn btn-danger btn-sm">Diterima</a>

            <?php elseif ($row['status'] == 'ditolak'): ?>
              <a href="set_pending.php?id=<?= $row['id']; ?>" class="btn btn-secondary btn-sm">Pending</a>
              <a href="set_tolak.php?id=<?= $row['id']; ?>" class="btn btn-success btn-sm">Ditolak</a>
            <?php endif; ?>
          </td>

          <td>
            <?php if (!empty($row['surat_izin_magang'])): ?>
              <!-- Tombol Download -->
              <a href="uploads/<?= $row['surat_izin_magang']; ?>"
                class="btn btn-primary btn-sm" download>Download</a>
              <!-- Tombol Preview -->
              <a href="uploads/<?= $row['surat_izin_magang']; ?>"
                class="btn btn-info btn-sm" target="_blank">Preview</a>
            <?php else: ?>
              <span class="text-danger">Belum upload</span>
            <?php endif; ?>
          </td>



        </tr>
      <?php endwhile; ?>
    </tbody>
  </table>

</body>

</html>