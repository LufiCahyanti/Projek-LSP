<?php
session_start();
$conn = new mysqli("localhost", "root", "", "pemilihan_ketos");

$error = "";
$success = "";
$showAlert = false;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $conn->real_escape_string($_POST['nama']);
    $kelas = $conn->real_escape_string($_POST['kelas']);
    $nis = $conn->real_escape_string($_POST['nis']);
    $kandidat_id = (int) $_POST['kandidat_id'];

    $cek = $conn->query("SELECT * FROM pemilih WHERE nis = '$nis'");
    if ($cek->num_rows > 0) {
        $error = "NIS ini sudah digunakan untuk memilih!";
    } else {
        $conn->query("INSERT INTO pemilih (nama, kelas, nis, kandidat_id) VALUES ('$nama', '$kelas', '$nis', $kandidat_id)");
        $conn->query("UPDATE kandidat SET suara = suara + 1 WHERE id = $kandidat_id");
        $_SESSION['sudah_memilih'] = true;
        $success = "Terima kasih, suara Anda telah disimpan!";
        $showAlert = true;
    }
}

$result = $conn->query("SELECT * FROM kandidat ORDER BY no_urut ASC");
?>

<!DOCTYPE html>
<html>
<head>
  <title>Pemilihan Ketua OSIS</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <style>
    body {
      background: linear-gradient(to right, rgb(194, 220, 255), rgb(118, 135, 211));
      min-height: 100vh;
      padding-top: 50px;
    }
    .form-container {
      background: linear-gradient(to right, rgb(197, 240, 253), rgb(182, 215, 255));
      border-radius: 15px;
      padding: 30px;
      box-shadow: 0 10px 20px rgba(0,0,0,0.1);
      width: 850px;
      margin: auto;
    }
    .card-kandidat {
      transition: 0.3s;
      border: 1px solid #ccc;
      border-radius: 10px;
      background: linear-gradient(to right, rgb(71, 185, 189), rgb(166, 211, 248));
    }
    .card-kandidat:hover {
      transform: scale(1.02);
      box-shadow: 0 8px 16px rgba(0,0,0,0.2);
    }
    input[type="radio"] {
      transform: scale(1.3);
    }
  </style>
</head>
<body>

<div class="container py-4">
  <div class="form-container">
    <h2 class="mb-4 text-center">Form Pemilihan Ketua OSIS</h2>

    <?php if ($error): ?>
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
                <p><strong>Visi:</strong></p>
                <p><?= htmlspecialchars(trim($k['visi'])) ?></p>

                <p class="mt-3"><strong>Misi:</strong></p>
                <ol style="padding-left: 20px;">
                  <?php foreach (explode('-', $k['misi']) as $m): ?>
                    <?php if (trim($m) != ""): ?>
                      <li style="margin-bottom: 5px;"><?= htmlspecialchars(trim($m)) ?></li>
                    <?php endif; ?>
                  <?php endforeach; ?>
                </ol>
              </div>
            </div>
          </div>
        <?php endwhile; ?>
      </div>

      <div class="mt-4 text-center">
        <button type="submit" class="btn btn-primary px-4" style="width: 100%;">Kirim Suara</button>
      </div>
    </form>
  </div>
</div>

<?php if ($showAlert): ?>
<script>
  Swal.fire({
    title: 'Berhasil!',
    text: '<?= $success ?>',
    icon: 'success',
    background: 'rgb(194, 220, 255)',
    confirmButtonText: 'OK'
  }).then(() => {
    window.location.href = "awalan.php";
  });
</script>
<?php endif; ?>

</body>
</html>