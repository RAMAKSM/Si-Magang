<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Dashboard</title>

  <!-- fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link
    href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,400;0,700;1,
700&display=swap"
    rel="stylesheet" />
  />

  <!-- feather Icons -->
  <script src="https://unpkg.com/feather-icons"></script>

  <!-- My Style -->
  <link rel="stylesheet" href="style2.css" />
</head>

<body>

  <div class="container">
    <ul>
      <li><a href="auth.php">Pendaftaran</a></li>
    </ul>
  </div>
  <!-- Navbar Start -->
  <nav class="navbar">
    <a href="#" class="navbar-logo">Si<span>MagangOnline</span>.</a>
    <div class="navbar-nav">
      <a href="auth.php">Pendaftaran</a>
      <a href="#about">Tentang Kami</a>
      <a href="#contact">Kontak</a>
    </div>

    <div class="navbar-extra">
      <a href="#" id="hamburger-menu"><i data-feather="menu"></i></a>
    </div>
  </nav>
  <!-- Navbar end -->

  <section class="hero" id="home">
    <main class="content">
      <h1>Mari Bergabung Bersama<span> Kami </span></h1>
      <p>
        Siap memulai langkah awal menuju karier impianmu? Dengan bergabung
        bersama kami adalah kesempatan emas untuk belajar langsung dari para
        profesional, terlibat dalam proyek nyata, dan mengasah keterampilan di
        dunia kerja sesungguhnya. Dapatkan pengalaman berharga, bimbingan
        langsung, dan jaringan profesional yang akan membuka banyak peluang di
        masa depan....
      </p>
      <a href="auth.php" class="cta">Daftar</a>
    </main>
  </section>
  <script>
    feather.replace();
  </script>

  <!-- My javascript -->
  <script src="js/script2.js"></script>
</body>

</html>