<?php        
session_start();        
require_once 'db.php';        

// Tambah kandidat        
if (isset($_POST['tambah'])) {        
    $no_urut = $_POST['no_urut'];        
    $ketua = $_POST['ketua'];        
    $wakil = $_POST['wakil'];        
    $visi = $_POST['visi'];        
    $misi = $_POST['misi'];        
    $foto = $_FILES['foto']['name'];        
    $tmp = $_FILES['foto']['tmp_name'];        
    move_uploaded_file($tmp, "uploads/$foto");        

    $conn->query("INSERT INTO kandidat (no_urut, ketua, wakil, visi, misi, foto, suara)         
                  VALUES ('$no_urut', '$ketua', '$wakil', '$visi', '$misi', '$foto', 0)");        
    header("Location: data-kandidat.php");        
    exit;        
}        

// Hapus kandidat 
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    $conn->query("DELETE FROM kandidat WHERE id=$id");
    header("Location: data-kandidat.php");
    exit;
}

// Edit kandidat        
if (isset($_POST['update'])) {        
    $id = $_POST['id'];        
    $no_urut = $_POST['no_urut'];        
    $ketua = $_POST['ketua'];        
    $wakil = $_POST['wakil'];        
    $visi = $_POST['visi'];        
    $misi = $_POST['misi'];        

    if (!empty($_FILES['foto']['name'])) {        
        $foto = $_FILES['foto']['name'];        
        $tmp = $_FILES['foto']['tmp_name'];        
        move_uploaded_file($tmp, "uploads/$foto");        

        $old = $conn->query("SELECT foto FROM kandidat WHERE id=$id")->fetch_assoc();        
        if (file_exists("uploads/{$old['foto']}")) {        
            unlink("uploads/{$old['foto']}");        
        }        

        $conn->query("UPDATE kandidat SET no_urut='$no_urut', ketua='$ketua', wakil='$wakil', visi='$visi', misi='$misi', foto='$foto' WHERE id=$id");        
    } else {        
        $conn->query("UPDATE kandidat SET no_urut='$no_urut', ketua='$ketua', wakil='$wakil', visi='$visi', misi='$misi' WHERE id=$id");        
    }        

    header("Location: data-kandidat.php");        
    exit;        
}        

// Ambil data kandidat        
$data = $conn->query("SELECT * FROM kandidat ORDER BY no_urut ASC");        

// Ambil data jika sedang edit
$editMode = false;
$editData = [
    'id' => '',
    'no_urut' => '',
    'ketua' => '',
    'wakil' => '',
    'visi' => '',
    'misi' => '',
    'foto' => ''
];
if (isset($_GET['edit'])) {
    $editMode = true;
    $idEdit = $_GET['edit'];
    $result = $conn->query("SELECT * FROM kandidat WHERE id=$idEdit");
    if ($result && $result->num_rows > 0) {
        $editData = $result->fetch_assoc();
    }
}
?>        

<!DOCTYPE html>
<html>
<head>
  <title>DATA Kandidat</title>
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background: linear-gradient(to right, #74ebd5, #ACB6E5);
      margin: 0;
      padding: 100px 20px 20px;
    }

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
    .nav-links a:visited,
    .nav-links a:focus,
    .nav-links a:hover,
    .nav-links a:active {
      text-decoration: none;
      outline: none;
    }
    
    .nav-links a:hover {
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
      margin-bottom: 10px;
    }

    .logout-btn:hover {
      background-color: #e60000;
    }

    h1, h2, h3 {
      text-align: center;
      color: #333;
    }

    form {
      background-color: #ffffff;
      padding: 20px;
      margin: 20px auto;
      border-radius: 15px;
      box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
      max-width: 700px;
    }

    form.edit-mode {
      background: #fffcc7;
    }

    label {
      font-weight: bold;
      display: block;
      margin-top: 10px;
    }

    input[type="text"],
    input[type="number"],
    input[type="file"],
    textarea {
      width: 100%;
      padding: 10px;
      margin-top: 5px;
      border-radius: 8px;
      border: 1px solid #ccc;
      box-sizing: border-box;
    }

    textarea {
      resize: vertical;
    }

    button {
      background-color: #007bff;
      color: white;
      border: none;
      padding: 10px 20px;
      margin-top: 15px;
      border-radius: 8px;
      cursor: pointer;
    }

    button[type="button"] {
      background-color: #6c757d;
      margin-left: 10px;
    }

    button:hover {
      opacity: 0.9;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 30px;
      background: #ffffff;
      border-radius: 15px;
      overflow: hidden;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    th, td {
      border: 1px solid #ddd;
      padding: 12px;
      text-align: center;
      vertical-align: middle;
    }

    th {
      background-color: #007bff;
      color: white;
    }

    tr:nth-child(even) {
      background-color: #f2f2f2;
    }

    td.visi, td.misi {
      max-width: 250px;
      word-wrap: break-word;
      white-space: pre-wrap;
      text-align: left;
    }

    td.aksi {
      white-space: nowrap;
    }

    img {
      border-radius: 10px;
      max-height: 100px;
    }

    a {
      text-decoration: none;
      color: #007bff;
      margin: 0 5px;
    }

    a:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>

<header class="navbar">
  <div class="logo">
    <img src="sauce.ifc-removebg-preview.png" alt="logo" />
  </div>
  <nav class="nav-links">
    <a href="awalan.php">Beranda</a>
    <a href="menu-admin.php">Menu</a>
  </nav>
  <logout-btn action="logout-admin.php" method="post">
    <button type="submit" class="logout-btn">Log out</button>
  </logout-btn>
</header>

<h1>Dashboard Admin - Kelola Kandidat</h1>

<h3><?= $editMode ? 'Edit Kandidat' : 'Tambah Kandidat Baru' ?></h3>
<form method="post" enctype="multipart/form-data" class="<?= $editMode ? 'edit-mode' : '' ?>">
  <?php if ($editMode): ?>
    <input type="hidden" name="id" value="<?= $editData['id'] ?>">
  <?php endif; ?>

  <label>No Urut:</label>
  <input type="number" name="no_urut" required value="<?= $editData['no_urut'] ?>">

  <label>Nama Ketua:</label>
  <input type="text" name="ketua" required value="<?= $editData['ketua'] ?>">

  <label>Nama Wakil:</label>
  <input type="text" name="wakil" required value="<?= $editData['wakil'] ?>">

  <label>Visi:</label>
  <textarea name="visi" rows="3" required><?= $editData['visi'] ?></textarea>

  <label>Misi:</label>
  <textarea name="misi" rows="3" required><?= $editData['misi'] ?></textarea>

  <label>Foto <?= $editMode ? '(Kosongkan jika tidak ingin ganti)' : '' ?>:</label>
  <input type="file" name="foto" <?= $editMode ? '' : 'required' ?> accept="image/*">

  <button type="submit" name="<?= $editMode ? 'update' : 'tambah' ?>">
    <?= $editMode ? 'Simpan Perubahan' : 'Tambah Kandidat' ?>
  </button>
  <?php if ($editMode): ?>
    <button type="button" onclick="window.location.href='data-kandidat.php'">Batal Edit</button>
  <?php endif; ?>
</form>

<h1>Data Kandidat Ketua OSIS</h1>
<table>
  <tr>
    <th>No Urut</th>
    <th>Foto</th>
    <th>Ketua & Wakil</th>
    <th>Visi</th>
    <th>Misi</th>
    <th>Aksi</th>
  </tr>

  <?php while ($row = $data->fetch_assoc()): ?>
    <tr>
      <td><?= $row['no_urut'] ?></td>
      <td><img src="uploads/<?= $row['foto'] ?>" width="80"></td>
      <td><strong><?= $row['ketua'] ?></strong><br>& <?= $row['wakil'] ?></td>
      <td class="visi"><?= nl2br(htmlspecialchars($row['visi'])) ?></td>
      <td class="misi"><?= nl2br(htmlspecialchars($row['misi'])) ?></td>
      <td class="aksi">
        <a href="data-kandidat.php?edit=<?= $row['id'] ?>" 
           style="background-color: #4CAF50; color: white; padding: 6px 12px; border-radius: 5px; text-decoration: none;">Edit</a>
        <a href="data-kandidat.php?hapus=<?= $row['id'] ?>" 
           onclick="return confirm('Yakin ingin menghapus kandidat ini?')" 
           style="background-color: #f44336; color: white; padding: 6px 12px; border-radius: 5px; text-decoration: none;">Hapus</a>
      </td>
    </tr>
  <?php endwhile; ?>
</table>

</body>
</html>