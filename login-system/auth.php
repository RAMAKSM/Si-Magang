<?php
session_start();
include "db.php";

// REGISTER
if (isset($_POST['register'])) {
    $nama_lengkap = $conn->real_escape_string($_POST['nama_lengkap']);
    $username     = $conn->real_escape_string($_POST['username']);
    $email        = $conn->real_escape_string($_POST['email']);
    $password     = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // default role mahasiswa
    $role = "mahasiswa";

    $sql = "INSERT INTO users (nama_lengkap, username, email, password, role) 
            VALUES ('$nama_lengkap','$username','$email','$password','$role')";
    if ($conn->query($sql)) {
        echo "<script>alert('Registrasi berhasil, silakan login!');</script>";
    } else {
        echo "<script>alert('Gagal registrasi: " . $conn->error . "');</script>";
    }
}

// LOGIN
if (isset($_POST['login'])) {
    $username = $conn->real_escape_string($_POST['username']);
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username='$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        if (password_verify($password, $row['password'])) {
            $_SESSION['username']     = $row['username'];
            $_SESSION['nama_lengkap'] = $row['nama_lengkap'];
            $_SESSION['role']         = $row['role'];

            // Arahkan sesuai role
            if ($row['role'] == 'admin') {
                header("Location: admin_dashboard.php");
            } else {
                header("Location: dashboard.php");
            }
            exit;
        } else {
            echo "<script>alert('Password salah!');</script>";
        }
    } else {
        echo "<script>alert('Username tidak ditemukan!');</script>";
    }
}





?>
<!DOCTYPE html>
<html>

<head>
    <title>Login & Register</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

    <div class="container">

        <!-- Login Form -->
        <div id="signIn" class="form-box">
            <h2>Login</h2>
            <form method="POST">
                <input type="text" name="username" placeholder="Username" required><br>
                <input type="password" name="password" placeholder="Password" required><br>
                <button type="submit" name="login">Login</button>
            </form>
            <p>Belum punya akun? <button id="signUpButton">Register</button></p>
        </div>

        <!-- Register Form -->
        <div id="signup" class="form-box" style="display:none;">
            <h2>Register</h2>
            <form method="POST">
                <input type="text" name="nama_lengkap" placeholder="Nama Lengkap" required><br>
                <input type="text" name="username" placeholder="Username" required><br>
                <input type="email" name="email" placeholder="Email" required><br>
                <input type="password" name="password" placeholder="Password" required><br>
                <button type="submit" name="register">Register</button>
            </form>
            <p>Sudah punya akun? <button id="signInButton">Login</button></p>
        </div>

    </div>

    <script src="js/script.js"></script>
</body>

</html>