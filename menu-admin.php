<?php
session_start();

// Mengecek apakah user sudah login
if (!isset($_SESSION['email'])){
  header("Location: login_admin.php");
  exit();
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Menu Halaman</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
<style>
body {
  font-family: sans-serif;
  background: linear-gradient(to right, #74ebd5, #ACB6E5);
  display: flex;
  justify-content: center; 
  align-items: center;
  min-height: 100vh;
  margin: 0;
}

/* Navbar */
.navbar {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  height: 60px;
  background-color: rgba(0, 32, 64, 0.8);
  color: #ffffff;
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 0 2rem;
  z-index: 1000;
}

.logo img {
  vertical-align: middle;
  height: 70px;
  width: auto;
}

.nav-links a {
  color: white;
  margin: 0 10px;
  text-decoration: none;
  font-weight: 600;
  padding: 8px 12px;
  border-radius: 5px;
  transition : background-color 0.3s ease;
}

.nav-links a:hover {
  text-decoration: none;
  background-color: rgb(108, 136, 158);
}

.logout-btn {
  background-color: #ff4d4d;
  color: white;
  border: none;
  padding: 8px 14px;
  border-radius: 5px;
  cursor: pointer;
  font-weight: bold;
}

.logout-btn:hover {
  background-color: #e60000;
}

.container {
  background-color: #fff;
  border-radius: 8px;
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
  padding: 20px;
  text-align: center; 
  margin-top: 50px;
}

.menu-item {
  background-color: #4CAF50; 
  color: white;
  padding: 10px 20px;
  margin-bottom: 10px;
  width: 400px;
  border-radius: 5px;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

.menu-item:hover {
  background-color: #45a049; 
}

.menu-item:last-child { 
  background-color: #45a049; 
}

.menu-item:last-child:hover {
  background-color: #45a049; 
}

/* Responsivitas */
@media (max-width: 576px) {
  .container {
    padding: 10px;
  }
  .menu-item {
    padding: 10px 15px;
  }
}
</style>
</head>
<body>
  <!-- Navbar -->
  <header class="navbar">
    <div class="logo">
      <img src="sauce.ifc-removebg-preview.png" alt="logo" />
    </div>

    <nav class="nav-links">
      <a href="awalan.php">Beranda</a>
      <a href="menu-admin.php">Menu</a>
    </nav>       

    <!-- Logout Button -->
    <form action="logout-admin.php" method="post">
      <button type="submit" class="logout-btn">Log out</button>
    </form>
  </header>

<div class="container">
  <h1>Halaman Menu</h1>
  <div class="menu-item" onclick="window.location.href='data-kandidat.php'">DATA KANDIDAT</div>
  <div class="menu-item" onclick="window.location.href='data-pemilih.php'">DATA SISWA</div>
  <div class="menu-item" onclick="window.location.href='hasil-voting.php'">HASIL VOTING</div>
</div>

</body>
</html>