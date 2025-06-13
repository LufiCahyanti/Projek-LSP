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
    header("Location: dashboard_admin.php");        
    exit;        
}        
        
// Hapus kandidat 
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    $conn->query("DELETE FROM kandidat WHERE id=$id");
    header("Location: dashboard_admin.php");
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
        
    header("Location: dashboard_admin.php");        
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
    <title>Dashboard Admin</title>        
    <style>        
        table, td, th { border: 1px solid black; border-collapse: collapse; padding: 8px; }        
        textarea, input[type=text], input[type=number] { width: 100%; }        
        form.edit-mode { background: #f8f9a9; padding: 10px; }        
    </style>        
</head>        
<body>        
        
<h2>Dashboard Admin - Kelola Kandidat</h2>        
        
<h3><?= $editMode ? 'Edit Kandidat' : 'Tambah Kandidat Baru' ?></h3>        
<form method="post" enctype="multipart/form-data" class="<?= $editMode ? 'edit-mode' : '' ?>">        
    <?php if ($editMode): ?>        
        <input type="hidden" name="id" value="<?= $editData['id'] ?>">        
    <?php endif; ?>        
        
    <label>No Urut:</label><br>        
    <input type="number" name="no_urut" required value="<?= $editData['no_urut'] ?>"><br><br>        
        
    <label>Nama Ketua:</label><br>        
    <input type="text" name="ketua" required value="<?= $editData['ketua'] ?>"><br><br>        
        
    <label>Nama Wakil:</label><br>        
    <input type="text" name="wakil" required value="<?= $editData['wakil'] ?>"><br><br>        
        
    <label>Visi:</label><br>        
    <textarea name="visi" rows="3" required><?= $editData['visi'] ?></textarea><br><br>        
        
    <label>Misi:</label><br>        
    <textarea name="misi" rows="3" required><?= $editData['misi'] ?></textarea><br><br>        
        
    <label>Foto <?= $editMode ? '(Kosongkan jika tidak ingin ganti)' : '' ?>:</label><br>        
    <input type="file" name="foto" <?= $editMode ? '' : 'required' ?> accept="image/*"><br><br>        
        
    <button type="submit" name="<?= $editMode ? 'update' : 'tambah' ?>"><?= $editMode ? 'Simpan Perubahan' : 'Tambah Kandidat' ?></button>        
    <?php if ($editMode): ?>        
        <button type="button" onclick="window.location.href='dashboard_admin.php'">Batal Edit</button>        
    <?php endif; ?>        
</form>        
        
<hr>        
        
<h3>Daftar Kandidat OSIS</h3>        
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
        <td><?= $row['ketua'] ?> & <?= $row['wakil'] ?></td>        
        <td><?= nl2br(htmlspecialchars($row['visi'])) ?></td>        
        <td><?= nl2br(htmlspecialchars($row['misi'])) ?></td>        
        <td>        
            <a href="dashboard_admin.php?edit=<?= $row['id'] ?>">Edit</a> |        
            <a href="dashboard_admin.php?hapus=<?= $row['id'] ?>" onclick="return confirm('Yakin ingin menghapus kandidat ini?')">Hapus</a>        
        </td>        
    </tr>        
<?php endwhile; ?>        
</table>        
        
</body>        
</html>