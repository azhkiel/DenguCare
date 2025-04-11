<?php
session_start();
include "../service/koneksi.php";

// Ambil data rumah dari database
$query = "SELECT * FROM rumah WHERE status_pemeriksaan = 'Sudah'";
$result = mysqli_query($conn, $query);

$rumahData = [];
while ($row = mysqli_fetch_assoc($result)) {
    $rumahData[] = [
        'lat' => $row['latitude'],
        'lng' => $row['longitude'],
        'alamat' => $row['alamat'],
        'status' => $row['status_pemeriksaan']
    ];
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Lokasi</title>
    <link rel="stylesheet" href="lokasi.css">
</head>
<body>
    <!-- Navbar -->
    <div class="navbar">
        <img src="logo.png" alt="Logo" class="logo">
        <ul class="nav-links">
            <li><a href="homewarga.html">Beranda</a></li>
            <li><a href="eventsaya.php">Event Saya</a></li>
            <li><a href="lokasi.php" class="active">Lokasi</a></li>
        </ul>
    </div>

    <!-- Konten Utama -->
    <div class="container">
        <h2 class="highlight">Cek Lokasi & Status Rumah</h2>
        <p class="subtitle">Berikut adalah peta wilayah Surabaya dan status rumah yang sudah diperiksa.</p>

        <div id="map"></div>

        <div id="statusRumah">
            <h3>Status Pengecekan Rumah</h3>
            <ul>
                <?php foreach ($rumahData as $rumah): ?>
                    <li><?= htmlspecialchars($rumah['alamat']) ?> - 
                        <span style="color: green;"><?= $rumah['status'] ?></span>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>

    <!-- Google Maps -->
    <script>
        function initMap() {
            const surabaya = { lat: -7.2575, lng: 112.7521 };
            const map = new google.maps.Map(document.getElementById("map"), {
                zoom: 12,
                center: surabaya,
            });

            const rumahList = <?php echo json_encode($rumahData); ?>;

            rumahList.forEach(rumah => {
                const marker = new google.maps.Marker({
                    position: { lat: parseFloat(rumah.lat), lng: parseFloat(rumah.lng) },
                    map,
                    title: rumah.alamat
                });

                const info = new google.maps.InfoWindow({
                    content: `<strong>${rumah.alamat}</strong><br>Status: ${rumah.status}`
                });

                marker.addListener("click", () => {
                    info.open(map, marker);
                });
            });
        }
    </script>
    <script async defer
        src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&callback=initMap">
    </script>
</body>
</html>