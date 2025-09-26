<?php
session_start();
include "db.php";

if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // pastikan aman dari SQL Injection

    $query = "UPDATE mahasiswa1 SET status='ditolak' WHERE id=$id";
    if (mysqli_query($conn, $query)) {
        $_SESSION['pesan'] = "⚠️ Status mahasiswa berhasil diubah menjadi <b>Ditolak</b>";
        $_SESSION['status'] = "warning"; // alert kuning
    } else {
        $_SESSION['pesan'] = "❌ Gagal mengubah status!";
        $_SESSION['status'] = "danger";
    }

    header("Location: data_admin.php");
    exit;
} else {
    $_SESSION['pesan'] = "❌ ID tidak ditemukan!";
    $_SESSION['status'] = "danger";
    header("Location: data_admin.php");
    exit;
}
