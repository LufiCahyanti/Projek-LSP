<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Halaman Awal Pemilihan</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">

  <style>
    body {
      background: linear-gradient(to right,rgb(194, 220, 255),rgb(118, 135, 211));
      min-height: 100vh;
      margin: 0;
      display: flex;
      justify-content: center;
      align-items: center;
      font-family: 'Segoe UI', sans-serif;
    }

        /* Navbar */
    .navbar {
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      height: 60px;
      background-color: rgba(0, 32, 64, 0.8);
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 0 2rem;
      z-index: 10;
    }

    .logo img{
     vertical-align: middle;
     height: 80px;
     margin: auto;
    }

    .nav-links a {
      color: white;
      margin: 0 10px;
      text-decoration: none;
      padding: 8px;
      border-radius: 3px;
    }

    .nav-links a:hover {
      background-color: rgb(189, 213, 241);
      color: #2a302e;
    }

    .navbar-right {
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .search-form {
      display: flex;
      align-items: center;
      background-color: white;
      border-radius: 20px;
      padding: 2px 8px;
    }

    .search {
      border: none;
      outline: none;
      padding: 6px;
      border-radius: 20px;
      font-size: 14px;
      color: #333;
      
    }

    .search-btn {
      background: none;
      border: none;
      cursor: pointer;
      font-size: 16px;
      margin-left: 4px;
      color: black;
    }

    .icon-admin {
      color: rgb(255, 255, 255);
      font-size: 18px;
      text-decoration: none;
    }


    .card {
      background-color:rgb(222, 224, 255);
      border-radius: 15px;
      padding: 30px;
      box-shadow: 0 10px 20px rgba(0,0,0,0.15);
      text-align: center;
      width: 80%;
      max-width: 500px;
      margin-top: 55px;
    }

    .card h1 {
      font-size: 2rem;
      margin-bottom: 25px;
      font-weight: bold;
      color: #003366;
    }

    .logo-img {
      display: block;
      margin: 0 auto 20px auto;
      width: 190px;
      height: auto;
    }

    .card p {
      font-size: 1.1rem;
      color: #444;
      margin-bottom: 25px;
    }

    .btn-mulai {
      padding: 10px 30px;
      font-size: 1.1rem;
      background-color: #007bff;
      border: none;
      color: white;
      border-radius: 50px;
      transition: background-color ;
      text-decoration: none;
    }

    .btn-mulai:hover {
      background-color: #0056b3;
      color: #fff;
    }
  </style>
</head>
<body>

      <!-- Navbar -->
  <header class="navbar">
    <div class="logo">
      <img src="sauce.ifc-removebg-preview.png" alt="logo" style="height: 60px; width: auto;">
    </div>

    <div class="navbar-right">
      <a href="login_admin.php" class="icon-admin" title="Login Admin">
        <i class="fas fa-user"></i>
      </a>
    </div>
  </header>


<div class="card">
  <h1>PEMILIHAN KETUA DAN WAKIL KETUA OSIS</h1>
  <img src="sauce.ifc-removebg-preview.png" alt="Logo OSIS" class="logo-img">
  <p>Silahkan klik tombol <strong>mulai</strong> untuk memulai pemilihan ketua dan wakil ketua OSIS.</p>
  <a href="form-voting.php" class="btn btn-mulai">Mulai</a>
</div>

</body>
</html>