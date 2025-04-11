<?php
include '../service/koneksi.php';

$filter = $_GET['filter'] ?? 'harian';

$labels = [];
$values = [];

// Contoh data dummy
if ($filter == 'harian') {
    $labels = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];
    $values = [5, 8, 2, 3, 6];
} elseif ($filter == 'mingguan') {
    $labels = ['Minggu ke-1', 'Minggu ke-2', 'Minggu ke-3'];
    $values = [15, 18, 9];
} else {
    $labels = ['Jan', 'Feb', 'Mar'];
    $values = [50, 42, 60];
}

echo json_encode(['labels' => $labels, 'values' => $values]);