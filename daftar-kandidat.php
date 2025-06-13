<?php
require_once 'db.php';

// Ambil semua data kandidat
$data = $conn->query("SELECT * FROM kandidat ORDER BY no_urut ASC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Pemilihan Ketua OSIS</title>
    <style>
        .kandidat {
            border: 1px solid #ccc;
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 20px;
            display: flex;
            gap: 20px;
            background: #f9f9f9;
        }
        .kandidat img {
            width: 150px;
            border-radius: 8px;
        }
        .keterangan {
            flex: 1;
        }
        .judul {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .tombol-voting {
            display: block;
            width: 100%;
            margin-top: 30px;
            padding: 10px;
            font-size: 16px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
        }
        .tombol-voting:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

    <h2>Daftar Kandidat Ketua OSIS</h2>

    <?php while($row = $data->fetch_assoc()): ?>
        <div class="kandidat">
            <img src="uploads/<?= $row['foto'] ?>" alt="Foto Kandidat">
            <div class="keterangan">
                <div class="judul">No. <?= $row['no_urut'] ?> - <?= $row['ketua'] ?> & <?= $row['wakil'] ?></div>
                <p><strong>Visi:</strong><br><?= nl2br(htmlspecialchars($row['visi'])) ?></p>
                <p><strong>Misi:</strong><br><?= nl2br(htmlspecialchars($row['misi'])) ?></p>
            </div>
        </div>
    <?php endwhile; ?>

    <form action="form-voting.php" method="get">
        <button class="tombol-voting" type="submit">Voting</button>
    </form>

</body>
</html>