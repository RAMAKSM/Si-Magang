<?php
session_start();
include "db.php";

if (isset($_POST['simpan'])) {
  $nim    = $_POST['nim'];
  $nama   = $_POST['nama'];
  $prodi  = $_POST['prodi'];
  $alamat = $_POST['alamat'];
  $universitas = $_POST['universitas'];
  $waktu_mulai = $_POST['waktu_mulai'];
  $waktu_berakhir = $_POST['waktu_berakhir'];

  // --- Upload file ---
  $surat_izin_magang = "";
  if (isset($_FILES['surat_izin_magang']) && $_FILES['surat_izin_magang']['error'] == 0) {
    $target_dir = "uploads/"; // folder penyimpanan
    if (!is_dir($target_dir)) {
      mkdir($target_dir, 0777, true); // buat folder kalau belum ada
    }

    $filename = time() . "_" . basename($_FILES["surat_izin_magang"]["name"]);
    $target_file = $target_dir . $filename;

    if (move_uploaded_file($_FILES["surat_izin_magang"]["tmp_name"], $target_file)) {
      $surat_izin_magang = $filename;
    }
  }

  // --- Simpan ke database ---
  $sql = "INSERT INTO mahasiswa1 (nim, nama, prodi, alamat, universitas, waktu_mulai, waktu_berakhir, surat_izin_magang) 
            VALUES ('$nim','$nama','$prodi','$alamat','$universitas','$waktu_mulai','$waktu_berakhir','$surat_izin_magang')";
  $query = mysqli_query($conn, $sql);

  if ($query) {
    $_SESSION['success'] = "Data mahasiswa berhasil ditambahkan!";
    header("Location: data_mahasiswa.php");
    exit;
  } else {
    $_SESSION['error'] = "Gagal simpan data: " . mysqli_error($conn);
    header("Location: data_mahasiswa.php");
    exit;
  }
}
?>


<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <title>Tambah Mahasiswa</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="p-4">
  <h2>Tambah Mahasiswa</h2>
  <form method="post" enctype="multipart/form-data">
    <div class="mb-2">
      <label>NIM</label>
      <input type="text" name="nim" class="form-control" required>
    </div>
    <div class="mb-2">
      <label>Nama</label>
      <input type="text" name="nama" class="form-control" required>
    </div>
    <div class="mb-2">
      <label>Prodi</label>
      <input type="text" name="prodi" class="form-control" required>
    </div>
    <div class="mb-2">
      <label>Alamat</label>
      <textarea name="alamat" class="form-control" required></textarea>
    </div>
    <div class="mb-2">
      <label>Universitas</label>
      <textarea name="universitas" class="form-control" required></textarea>
    </div>
    <div class="mb-2">
      <label>Waktu Mulai</label>
      <input type="date" name="waktu_mulai" class="form-control" required>
    </div>
    <div class="mb-2">
      <label>Waktu Berakhir</label>
      <input type="date" name="waktu_berakhir" class="form-control" required>
    </div>
    <div class="mb-2">
      <label>Surat Izin Magang (PDF/JPG)</label>
      <input type="file" name="surat_izin_magang" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
    </div>
    <button type="submit" name="simpan" class="btn btn-success">Simpan</button>
    <a href="data_mahasiswa.php" class="btn btn-secondary">Kembali</a>
  </form>

</body>

</html>