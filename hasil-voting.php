<?php
$conn = new mysqli("localhost", "root", "", "pemilihan_ketos");

// Ambil semua data kandidat
$result = $conn->query("SELECT * FROM kandidat ORDER BY no_urut ASC");

// Siapkan array data untuk grafik
$labels = [];
$suara = [];
$warna = ['#3498db', '#e74c3c', '#2ecc71', '#f1c40f', '#9b59b6']; // Warna grafik
$index = 0;
?>

<!DOCTYPE html>
<html>
<head>
  <title>Hasil Voting Ketua OSIS</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <style>
    .bg-light {
      width: 65%;
      margin: auto;
      background: linear-gradient(to right,rgb(194, 220, 255),rgb(118, 135, 211));
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
      height: 60px;
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
      padding: 4px 14px;
      border-radius: 5px;
      cursor: pointer;
      font-weight: bold;
      margin-bottom: 5px;
    }

    .logout-btn:hover {
      background-color: #e60000;
    }

    .card-hasil { 
      transition: 0.3s;
      border: 0px solid #ccc;
      border-radius: 12px;
    }
    .card-hasil:hover {
      transform: scale(1.01); 
      box-shadow: 0 6px 12px rgba(0,0,0,0.1);
    }
    .card-img-top {
      max-height: 200px;
      object-fit: cover;
      border-radius: 8px;
    }
  </style>
</head>
<body class="bg-light">
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

<div class="container py-4"style="margin-top: 7rem;">
  <h1 class="text-center mb-4">Hasil Voting Ketua OSIS</h2>

  <div class="row row-cols-1 row-cols-md-2 g-4 mb-5" style="width: 820px; margin: auto;">
    <?php $i = 0; while($row = $result->fetch_assoc()): ?>
      <div class="col">
        <div class="card card-hasil shadow-sm p-3" style="     background: linear-gradient(to right,rgb(91, 136, 173),rgb(166, 211, 248)); ">
          <h5 class="card-title">Kandidat <?= $row['no_urut'] ?>: <?= $row['ketua'] ?> & <?= $row['wakil'] ?></h5>
          <img src="uploads/<?= $row['foto'] ?>" class="card-img-top mb-2">
          <p><strong>Visi:</strong> <?= $row['visi'] ?></p>
          <p><strong>Misi:</strong> <?= $row['misi'] ?></p>
          <p class="fw-bold text-white">Total Suara: <?= $row['suara'] ?></p>
        </div>
      </div>
      <?php 
        $labels[] = "Kandidat " . $row['no_urut'];
        $suara[] = $row['suara'];
        $i++;
      ?>
    <?php endwhile; ?>
  </div>

  <h2 class="text-center mb-3">Grafik Perolehan Suara</h4>
  <canvas id="grafikSuara" height="100"></canvas>
</div>

<script>
  const ctx = document.getElementById('grafikSuara').getContext('2d');
  const chart = new Chart(ctx, {
    type: 'bar',
    data: {
      labels: <?= json_encode($labels) ?>,
      datasets: [{
        label: 'Jumlah Suara',
        data: <?= json_encode($suara) ?>,
        backgroundColor: <?= json_encode(array_slice($warna, 0, count($labels))) ?>,
        borderColor: 'rgb(0, 0, 0)',     // Garis tebal warna gelap
      }]
    },
    options: {
      responsive: true,
      plugins: {
        legend: { display: false }
      },
      scales: {
        y: {
          beginAtZero: true,
          ticks: {
            stepSize: 1,
            color: 'rgb(0, 0, 0)',       // Warna angka sumbu Y
            font: {
              weight: 'bold'
            }
          },
          grid: {
            color: 'rgb(71, 68, 68)',       // Warna garis grid sumbu Y
            lineWidth: 1.5
          }
        },
        x: {
          ticks: {
            color: 'rgb(0, 0, 0)',
            font: {
              weight: 'bold'
            }
          },
          grid: {
            display: false
          }
        }
      }
    }
  });
</script>
</body>
</html>