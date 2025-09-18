<?php
include "db.php";

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $sql = "UPDATE mahasiswa1 SET status='ditolak' WHERE id=$id";
    if (mysqli_query($conn, $sql)) {
        header("Location: admin_dashboard.php");
        exit;
    } else {
        echo "Gagal update status!";
    }
}
