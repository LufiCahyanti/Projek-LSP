<?php
include '../config/db.php';
$data = $conn->query("SELECT calon.nama, COUNT(suara.id) as total FROM calon
LEFT JOIN suara ON calon.id = suara.id_calon GROUP BY calon.id");

$labels = [];
$votes = [];
while ($row = $data->fetch_assoc()) {
    $labels[] = $row['nama'];
    $votes[] = $row['total'];
}
echo json_encode(['labels' => $labels, 'votes' => $votes]);
?>