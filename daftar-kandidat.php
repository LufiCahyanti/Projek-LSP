<?php    
require_once 'db.php';    
    
// Ambil semua data kandidat    
$data = $conn->query("SELECT * FROM kandidat ORDER BY no_urut ASC");    
?>    
    
<!DOCTYPE html>    
<html>    
<head>    
    <title>Daftar Kandidat</title>    
    <style>    
        body {
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(to right,rgb(234, 245, 255), #00f2fe);
            padding: 40px 20px;
        }

        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 40px;
            font-size: 45px;
            margin-top: -25px;
        }

        .kandidat {
            border: 1px solid #ccc;
            border-radius: 10px;
            padding: 20px;
            margin: 0 auto 30px;
            display: flex;
            gap: 25px;
            background: #fff;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            max-width: 900px;
            background: linear-gradient(to right,rgb(223, 223, 255),rgb(243, 225, 255));      

        }

        .kandidat img {
            width: 220px; 
            height: auto;
            border-radius: 10px;
            object-fit: cover;
        }

        .keterangan {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .judul {
            font-size: 20px;
            font-weight: bold;
            color: #222;
            margin-bottom: 15px;
        }

        p {
            margin-bottom: 10px;
            color: #333;
        }

        .tombol-voting {
            display: block;
            width: 100%;
            margin: 40px auto 0;
            padding: 14px;
            margin-top: -7px;
            font-size: 18px;
            font-weight: bold;
            background-color:rgb(11, 103, 207);
            color: white;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            max-width: 950px;
        }

        .tombol-voting:hover {
            background-color:rgb(13, 66, 126);
        }
    </style>    
</head>    
<body>    
    
    <h1>Kandidat Ketua OSIS</h2>    
    
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