<?php
$conn = new mysqli("localhost", "root", "", "pemilihan_ketos");

// Proses pencarian
$keyword = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';
$sql = "SELECT p.nama, p.kelas, p.nis, k.no_urut, k.ketua, k.wakil 
        FROM pemilih p 
        JOIN kandidat k ON p.kandidat_id = k.id";

if (!empty($keyword)) {
    $sql .= " WHERE p.nama LIKE '%$keyword%' 
              OR p.nis LIKE '%$keyword%' 
              OR p.kelas LIKE '%$keyword%'";
}

$sql .= " ORDER BY p.nama ASC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
  <title>Data Pemilih</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-4">
  <h2 class="mb-4 text-center">Daftar Pemilih Ketua OSIS</h2>

  <!-- Form Pencarian -->
  <form method="GET" class="mb-4">
    <div class="input-group">
      <input type="text" name="search" class="form-control" placeholder="Cari nama/NIS/kelas..." value="<?= htmlspecialchars($keyword) ?>">
      <button class="btn btn-primary" type="submit">Cari</button>
    </div>
  </form>

  <!-- Tabel Data -->
  <div class="table-responsive">
    <table class="table table-bordered table-striped">
      <thead class="table-dark">
        <tr>
          <th>No</th>
          <th>Nama</th>
          <th>Kelas</th>
          <th>NIS</th>
          <th>Memilih Kandidat</th>
        </tr>
      </thead>
      <tbody>
        <?php if ($result->num_rows > 0): $no = 1; ?>
          <?php while($row = $result->fetch_assoc()): ?>
            <tr>
              <td><?= $no++ ?></td>
              <td><?= htmlspecialchars($row['nama']) ?></td>
              <td><?= htmlspecialchars($row['kelas']) ?></td>
              <td><?= htmlspecialchars($row['nis']) ?></td>
              <td>Kandidat <?= $row['no_urut'] ?>: <?= $row['ketua'] ?> & <?= $row['wakil'] ?></td>
            </tr>
          <?php endwhile; ?>
        <?php else: ?>
          <tr><td colspan="5" class="text-center">Belum ada data pemilih.</td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>
</body>
</html>