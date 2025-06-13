<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama  = $_POST['nama'];
    $kelas = $_POST['kelas'];
    $visi  = $_POST['visi'];
    $misi  = $_POST['misi'];

    $foto_name = $_FILES['foto']['name'];
    $tmp_name  = $_FILES['foto']['tmp_name'];
    $folder    = "foto/";

    if (move_uploaded_file($tmp_name, $folder . $foto_name)) {
        $query = "INSERT INTO calon_ketua (nama, kelas, visi, misi, foto)
                  VALUES ('$nama', '$kelas', '$visi', '$misi', '$foto_name')";

        if (mysqli_query($conn, $query)) {
            echo "<div style='padding:10px; background: #d4edda; color:#155724;'>✅ Calon berhasil ditambahkan!</div>";
        } else {
            echo "<div style='padding:10px; background: #f8d7da; color:#721c24;'>❌ Gagal menambahkan: " . mysqli_error($conn) . "</div>";
        }
    } else {
        echo "<div style='padding:10px; background: #f8d7da; color:#721c24;'>❌ Gagal mengupload foto!</div>";
    }
}
?>

<!-- Form tambah calon -->
<form action="" method="post" enctype="multipart/form-data" style="max-width:600px;margin:auto;padding:20px;border:1px solid #ccc;border-radius:10px">
    <h2>Tambah Calon Ketua OSIS</h2>

    <label>Nama:</label>
    <input type="text" name="nama" required class="form-control"><br>

    <label>Kelas:</label>
    <input type="text" name="kelas" required class="form-control"><br>

    <label>Visi:</label>
    <textarea name="visi" required class="form-control"></textarea><br>

    <label>Misi:</label>
    <textarea name="misi" required class="form-control"></textarea><br>

    <label>Foto:</label>
    <input type="file" name="foto" accept="image/*" required class="form-control"><br>

    <button type="submit" class="btn btn-primary">Simpan</button>
</form>