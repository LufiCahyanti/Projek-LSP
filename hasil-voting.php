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
    .card-hasil { transition: 0.3s; }
    .card-hasil:hover { transform: scale(1.01); }
  </style>
</head>
<body class="bg-light">
<div class="container py-4">
  <h2 class="text-center mb-4">Hasil Voting Ketua OSIS</h2>

  <div class="row row-cols-1 row-cols-md-2 g-4 mb-5">
    <?php while($row = $result->fetch_assoc()): ?>
      <div class="col">
        <div class="card card-hasil shadow-sm p-3">
          <h5 class="card-title">Kandidat <?= $row['no_urut'] ?>: <?= $row['ketua'] ?> & <?= $row['wakil'] ?></h5>
          <img src="uploads/<?= $row['foto'] ?>" class="card-img-top mb-2" style="max-height: 200px; object-fit: cover;">
          <p><strong>Visi:</strong> <?= $row['visi'] ?></p>
          <p><strong>Misi:</strong> <?= $row['misi'] ?></p>
          <p class="fw-bold text-primary">Total Suara: <?= $row['suara'] ?></p>
        </div>
      </div>
      <?php 
        $labels[] = "Kandidat " . $row['no_urut'];
        $suara[] = $row['suara'];
      ?>
    <?php endwhile; ?>
  </div>

  <h4 class="text-center mb-3">Grafik Perolehan Suara</h4>
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
        backgroundColor: <?= json_encode(array_slice($warna, 0, count($labels))) ?>
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
          ticks: { stepSize: 1 }
        }
      }
    }
  });
</script>
</body>
</html>