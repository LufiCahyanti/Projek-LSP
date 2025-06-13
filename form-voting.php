<?php
session_start();
$conn = new mysqli("localhost", "root", "", "pemilihan_ketos");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $conn->real_escape_string($_POST['nama']);
    $kelas = $conn->real_escape_string($_POST['kelas']);
    $nis = $conn->real_escape_string($_POST['nis']);
    $kandidat_id = (int) $_POST['kandidat_id'];

    // Cek apakah sudah pernah memilih berdasarkan NIS
    $cek = $conn->query("SELECT * FROM pemilih WHERE nis = '$nis'");
    if ($cek->num_rows > 0) {
        $error = "NIS ini sudah digunakan untuk memilih!";
    } else {
        // Simpan pemilih dan tambahkan suara
        $conn->query("INSERT INTO pemilih (nama, kelas, nis, kandidat_id) VALUES ('$nama', '$kelas', '$nis', $kandidat_id)");
        $conn->query("UPDATE kandidat SET suara = suara + 1 WHERE id = $kandidat_id");
        $_SESSION['sudah_memilih'] = true;
        $success = "Terima kasih, suara Anda telah disimpan!";
    }
}

// Ambil data kandidat untuk ditampilkan
$result = $conn->query("SELECT * FROM kandidat ORDER BY no_urut ASC");
?>

<!DOCTYPE html>
<html>
<head>
  <title>Pemilihan Ketua OSIS</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .card-kandidat { transition: 0.3s; }
    .card-kandidat:hover { transform: scale(1.02); }
    input[type="radio"] { transform: scale(1.3); }
  </style>
</head>
<body class="bg-light">
<div class="container py-4">
  <h2 class="mb-4 text-center">Form Pemilihan Ketua OSIS</h2>

  <?php if (isset($_SESSION['sudah_memilih'])): ?>
    <div class="alert alert-success">Anda sudah memilih. Terima kasih!
        <form action="halaman-awal.html" method="get">
        <button class="tombol-awalan" style="background-color: rgb(23, 131, 255); color: #fff;" type="submit">Ok</button>
    </form>
    </div>
  <?php elseif (isset($success)): ?>
    <div class="alert alert-success"><?= $success ?></div>
  <?php else: ?>
    <?php if (isset($error)): ?>
      <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>

    <form method="POST">
      <div class="mb-3">
        <label class="form-label">Nama Lengkap</label>
        <input type="text" name="nama" class="form-control" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Kelas</label>
        <input type="text" name="kelas" class="form-control" required>
      </div>

      <div class="mb-3">
        <label class="form-label">NIS</label>
        <input type="text" name="nis" class="form-control" required>
      </div>

      <h5 class="mb-3">Pilih Kandidat:</h5>
      <div class="row row-cols-1 row-cols-md-2 g-4">
        <?php while($k = $result->fetch_assoc()): ?>
          <div class="col">
            <div class="card card-kandidat p-3">
              <div class="d-flex align-items-center mb-2">
                <input type="radio" name="kandidat_id" value="<?= $k['id'] ?>" required class="me-2">
                <h5 class="card-title mb-0">Kandidat <?= $k['no_urut'] ?>: <?= $k['ketua'] ?> & <?= $k['wakil'] ?></h5>
              </div>
              <img src="uploads/<?= $k['foto'] ?>" class="card-img-top" style="max-height: 200px; object-fit: cover;">
              <div class="card-body">
                <p><strong>Visi:</strong> <?= $k['visi'] ?></p>
                <p><strong>Misi:</strong> <?= $k['misi'] ?></p>
              </div>
            </div>
          </div>
        <?php endwhile; ?>
      </div>

      <div class="mt-4 text-center">
        <button type="submit" class="btn btn-primary px-4">Kirim Suara</button>
      </div>
    </form>
  <?php endif; ?>
</div>
</body>
</html>