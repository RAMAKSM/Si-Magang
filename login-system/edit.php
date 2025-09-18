<?php
session_start();
include "db.php";

// Cek apakah admin sudah login
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
  header("Location: auth.php");
  exit;
}

// Ambil ID dari URL
if (!isset($_GET['id'])) {
  header("Location: admin_dashboard.php");
  exit;
}
$id = intval($_GET['id']);

// Ambil data mahasiswa berdasarkan ID
$sql = "SELECT * FROM mahasiswa1 WHERE id = $id";
$result = mysqli_query($conn, $sql);
$mahasiswa = mysqli_fetch_assoc($result);

if (!$mahasiswa) {
  echo "Data tidak ditemukan!";
  exit;
}

// Proses update data
if (isset($_POST['update'])) {
  $nim           = $_POST['nim'];
  $nama          = $_POST['nama'];
  $prodi         = $_POST['prodi'];
  $alamat        = $_POST['alamat'];
  $universitas   = $_POST['universitas'];
  $waktu_mulai   = $_POST['waktu_mulai'];
  $waktu_berakhir = $_POST['waktu_berakhir'];
  $status        = $_POST['status'];

  $sql_update = "UPDATE mahasiswa1 
                   SET nim='$nim', nama='$nama', prodi='$prodi', alamat='$alamat', 
                       universitas='$universitas', waktu_mulai='$waktu_mulai', 
                       waktu_berakhir='$waktu_berakhir', status='$status'
                   WHERE id=$id";

  if (mysqli_query($conn, $sql_update)) {
    $_SESSION['success'] = "Data mahasiswa berhasil diperbarui!";
    header("Location: admin_dashboard.php");
    exit;
  } else {
    $_SESSION['error'] = "Gagal update data: " . mysqli_error($conn);
    header("Location: admin_dashboard.php");
    exit;
  }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <title>Edit Data Mahasiswa</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="container mt-4">

  <h2>Edit Data Mahasiswa</h2>

  <form method="post">
    <div class="mb-2">
      <label>NIM</label>
      <input type="text" name="nim" class="form-control" value="<?= $mahasiswa['nim']; ?>" required>
    </div>
    <div class="mb-2">
      <label>Nama</label>
      <input type="text" name="nama" class="form-control" value="<?= $mahasiswa['nama']; ?>" required>
    </div>
    <div class="mb-2">
      <label>Prodi</label>
      <input type="text" name="prodi" class="form-control" value="<?= $mahasiswa['prodi']; ?>" required>
    </div>
    <div class="mb-2">
      <label>Alamat</label>
      <textarea name="alamat" class="form-control" required><?= $mahasiswa['alamat']; ?></textarea>
    </div>
    <div class="mb-2">
      <label>Universitas</label>
      <input type="text" name="universitas" class="form-control" value="<?= $mahasiswa['universitas']; ?>" required>
    </div>
    <div class="mb-2">
      <label>Waktu Mulai</label>
      <input type="date" name="waktu_mulai" class="form-control" value="<?= $mahasiswa['waktu_mulai']; ?>" required>
    </div>
    <div class="mb-2">
      <label>Waktu Berakhir</label>
      <input type="date" name="waktu_berakhir" class="form-control" value="<?= $mahasiswa['waktu_berakhir']; ?>" required>
    </div>
    <div class="mb-2">
      <label>Status</label>
      <select name="status" class="form-control" required>
        <option value="pending" <?= $mahasiswa['status'] == 'pending' ? 'selected' : ''; ?>>Pending</option>
        <option value="aktif" <?= $mahasiswa['status'] == 'aktif' ? 'selected' : ''; ?>>Diterima</option>
        <option value="ditolak" <?= $mahasiswa['status'] == 'ditolak' ? 'selected' : ''; ?>>Ditolak</option>
      </select>
    </div>
    <button type="submit" name="update" class="btn btn-primary">Simpan Perubahan</button>
    <a href="admin_dashboard.php" class="btn btn-secondary">Kembali</a>
  </form>

</body>

</html>