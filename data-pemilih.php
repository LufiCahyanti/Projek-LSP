<?php
$conn = new mysqli("localhost", "root", "", "pemilihan_ketos");

// Proses hapus data pemilih
if (isset($_GET['hapus'])) {
    $nis_hapus = $conn->real_escape_string($_GET['hapus']);
    $cek = $conn->query("SELECT kandidat_id FROM pemilih WHERE nis = '$nis_hapus'");
    if ($cek->num_rows > 0) {
        $kandidat = $cek->fetch_assoc()['kandidat_id'];
        $conn->query("DELETE FROM pemilih WHERE nis = '$nis_hapus'");
        $conn->query("UPDATE kandidat SET suara = suara - 1 WHERE id = $kandidat");
    }
}

// Proses update data pemilih
if (isset($_POST['update'])) {
    $old_nis = $conn->real_escape_string($_POST['old_nis']);
    $nama = $conn->real_escape_string($_POST['nama']);
    $kelas = $conn->real_escape_string($_POST['kelas']);
    $nis = $conn->real_escape_string($_POST['nis']);
    $conn->query("UPDATE pemilih SET nama='$nama', kelas='$kelas', nis='$nis' WHERE nis='$old_nis'");
}

// Proses pencarian
$keyword = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';
$edit_nis = isset($_GET['edit']) ? $conn->real_escape_string($_GET['edit']) : '';

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
  <script>
    function confirmDelete(nis) {
      if (confirm('Apakah Anda yakin ingin menghapus data pemilih dengan NIS: ' + nis + '?')) {
        window.location.href = '?hapus=' + nis;
      }
    }
  </script>

  <style>
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
    padding: 3px 14px;
    border-radius: 5px;
    cursor: pointer;
    font-weight: bold;
  }

  .logout-btn:hover {
    background-color: #e60000;
  }

  </style>
</head>
<body class="bg-light" style="padding-top: 60px; background: linear-gradient(to right, #74ebd5, #ACB6E5);">
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
  
<div class="container py-4">
  <h2 class="mb-4 text-center">Data Pemilih Ketua OSIS</h2>

  <!-- Form Pencarian -->
  <form method="GET" class="mb-4">
    <div class="input-group">
      <input type="text" name="search" class="form-control" placeholder="Cari nama/NIS/kelas..." sty value="<?= htmlspecialchars($keyword) ?>">
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
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php if ($result->num_rows > 0): $no = 1; ?>
          <?php while($row = $result->fetch_assoc()): ?>
            <?php if ($edit_nis == $row['nis']): ?>
              <!-- Mode Edit -->
              <tr>
                <form method="POST">
                  <input type="hidden" name="old_nis" value="<?= $row['nis'] ?>">
                  <td><?= $no++ ?></td>
                  <td><input type="text" name="nama" class="form-control" value="<?= htmlspecialchars($row['nama']) ?>"></td>
                  <td><input type="text" name="kelas" class="form-control" value="<?= htmlspecialchars($row['kelas']) ?>"></td>
                  <td><input type="text" name="nis" class="form-control" value="<?= htmlspecialchars($row['nis']) ?>"></td>
                  <td><?= "Kandidat {$row['no_urut']}: {$row['ketua']} & {$row['wakil']}" ?></td>
                  <td>
                    <button type="submit" name="update" class="btn btn-success btn-sm">Simpan</button>
                    <a href="data-pemilih.php" class="btn btn-secondary btn-sm">Batal</a>
                  </td>
                </form>
              </tr>
            <?php else: ?>
              <!-- Mode Tampilkan -->
              <tr>
                <td><?= $no++ ?></td>
                <td><?= htmlspecialchars($row['nama']) ?></td>
                <td><?= htmlspecialchars($row['kelas']) ?></td>
                <td><?= htmlspecialchars($row['nis']) ?></td>
                <td>Kandidat <?= $row['no_urut'] ?>: <?= $row['ketua'] ?> & <?= $row['wakil'] ?></td>
                <td>
                  <a href="?edit=<?= $row['nis'] ?>" class="btn btn-warning btn-sm">Edit</a>
                  <button class="btn btn-danger btn-sm" onclick="confirmDelete('<?= $row['nis'] ?>')">Hapus</button>
                </td>
              </tr>
            <?php endif; ?>
          <?php endwhile; ?>
        <?php else: ?>
          <tr><td colspan="6" class="text-center">Belum ada data pemilih.</td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>
</body>
</html>