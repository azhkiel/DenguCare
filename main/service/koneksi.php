<?php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "dengue";

$conn = new mysqli($host, $user, $pass, $dbname,3307);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>
