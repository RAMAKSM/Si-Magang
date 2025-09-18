<?php
include "db.php";
$id = $_GET['id'];
mysqli_query($conn, "UPDATE mahasiswa1 SET status='aktif' WHERE id='$id'");
header("Location: admin_dashboard.php");
