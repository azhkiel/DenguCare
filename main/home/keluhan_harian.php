<?php
session_start();
require '../service/koneksi.php'; // koneksi ke db_dengucare

header('Content-Type: application/json');

if (!isset($_SESSION['id_warga'])) {
    echo json_encode(['status' => 'error', 'message' => 'Belum login']);
    exit();
}

$id_warga = $_SESSION['id_warga'];
$tanggal = date('Y-m-d');

// Ambil data dari POST
$suhu = $_POST['suhu'] ?? '';
$ruam = $_POST['ruam'] ?? '';
$nyeri_otot = ($_POST['nyeri_otot'] ?? '') === 'Ya';
$mual = ($_POST['mual'] ?? '') === 'Ya';
$nyeri_mata = ($_POST['nyeri_belakang_mata'] ?? '') === 'Ya';
$pendarahan = ($_POST['pendarahan'] ?? '') === 'Ya';
$gejala_lain = $_POST['keluhan_lain'] ?? '';

// Hitung skor berdasarkan gejala
$skor = 0;
if ($suhu >= 38) $skor += 1;
if ($ruam !== 'Tidak Ada') $skor += 1;
if ($nyeri_otot) $skor += 1;
if ($mual) $skor += 1;
if ($nyeri_mata) $skor += 1;
if ($pendarahan) $skor += 1;

// Hitung akurasi
$akurasi = ($skor / 6) * 100;
$anjuran = "";
if ($akurasi >= 80) {
    $anjuran = "Segera periksa ke fasilitas kesehatan terdekat. Gejala sangat mirip DBD.";
} elseif ($akurasi >= 50) {
    $anjuran = "Pantau terus kondisi tubuh dan segera cek jika memburuk.";
} else {
    $anjuran = "Kemungkinan kecil DBD. Tetap jaga kesehatan dan kebersihan lingkungan.";
}

// Cek jika data sudah diisi hari ini
$cek = mysqli_query($conn, "SELECT * FROM keluhan_harian WHERE id_warga='$id_warga' AND tanggal='$tanggal'");
if (mysqli_num_rows($cek) > 0) {
    echo json_encode(['status' => 'error', 'message' => 'Anda sudah mengisi keluhan hari ini.']);
    exit();
}

$query = "INSERT INTO keluhan_harian (id_warga, tanggal, suhu, ruam, nyeri_otot, mual, nyeri_belakang_mata, pendarahan, gejala_lain, akurasi_dbd, anjuran)
VALUES ('$id_warga', '$tanggal', '$suhu', '$ruam', '$nyeri_otot', '$mual', '$nyeri_mata', '$pendarahan', '$gejala_lain', '$akurasi', '$anjuran')";

if (mysqli_query($conn, $query)) {
    echo json_encode(['status' => 'success', 'message' => 'Terima kasih! Keluhan Anda telah disimpan.<br><br>Akurasi gejala DBD: ' . round($akurasi) . '%<br>' . $anjuran]);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Gagal menyimpan data.']);
}
?>