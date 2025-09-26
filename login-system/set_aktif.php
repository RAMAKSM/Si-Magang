<?php
session_start();
include "db.php";

if (isset($_GET['id'])) {
  $id = mysqli_real_escape_string($conn, $_GET['id']); // aman dari SQL Injection

  $query = "UPDATE mahasiswa1 SET status='aktif' WHERE id='$id'";
  if (mysqli_query($conn, $query)) {
    $_SESSION['pesan'] = "✅ Status mahasiswa berhasil diubah menjadi <b>Diterima</b>";
    $_SESSION['status'] = "success"; // warna hijau
  } else {
    $_SESSION['pesan'] = "❌ Gagal mengubah status!";
    $_SESSION['status'] = "danger"; // warna merah
  }

  header("Location: data_admin.php");
  exit;
} else {
  $_SESSION['pesan'] = "❌ ID tidak ditemukan!";
  $_SESSION['status'] = "danger";
  header("Location: data_admin.php");
  exit;
}
