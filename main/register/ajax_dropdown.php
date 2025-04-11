<?php
include '../service/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    header('Content-Type: text/html; charset=UTF-8');

    if ($_POST['action'] === 'get_kelurahan') {
        $kecamatan_id = intval($_POST['kecamatan_id']);
        $result = mysqli_query($conn, "SELECT id, nama_kelurahan FROM kelurahan WHERE kecamatan_id = $kecamatan_id ORDER BY nama_kelurahan ASC");
        echo "<option value=''>Pilih Kelurahan</option>";
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<option value='{$row['id']}'>{$row['nama_kelurahan']}</option>";
        }
        exit;
    }

    if ($_POST['action'] === 'get_rw') {
        $kelurahan_id = intval($_POST['kelurahan_id']);
        $result = mysqli_query($conn, "SELECT id, nomor_rw FROM rw WHERE kelurahan_id = $kelurahan_id ORDER BY nomor_rw ASC");
        echo "<option value=''>Pilih RW</option>";
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<option value='{$row['id']}'>{$row['nomor_rw']}</option>";
        }
        exit;
    }

    if ($_POST['action'] === 'get_rt') {
        $rw_id = intval($_POST['rw_id']);
        $result = mysqli_query($conn, "SELECT id, nomor_rt FROM rt WHERE rw_id = $rw_id ORDER BY nomor_rt ASC");
        echo "<option value=''>Pilih RT</option>";
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<option value='{$row['id']}'>{$row['nomor_rt']}</option>";
        }
        exit;
    }
}
?>
