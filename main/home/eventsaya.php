<?php
session_start();
include '../service/koneksi.php';

// Check if user is logged in
if (!isset($_SESSION['id_warga'])) {
    echo "<script>window.location='LoginWarga.php';</script>";
    exit;
}

$id_warga = $_SESSION['id_warga'];

// Handle event cancellation
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['cancel'])) {
    $id_event = $_POST['cancel'];
    mysqli_query($conn, "DELETE FROM event_warga WHERE id_warga='$id_warga' AND id_event='$id_event'");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Saya - DengueCare</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        @keyframes slideInRight {
            from { transform: translateX(20px); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
        
        .animate-fade-in {
            animation: fadeIn 0.5s ease-out forwards;
        }
        
        .animate-slide-in {
            animation: slideInRight 0.5s ease-out forwards;
        }
        
        .card-hover {
            transition: all 0.3s ease;
        }
        
        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }
        
        .btn-hover {
            transition: all 0.2s ease;
        }
        
        .btn-hover:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        
        .fade-out {
            animation: fadeOut 0.3s ease-out forwards;
        }
        
        @keyframes fadeOut {
            from { opacity: 1; transform: scale(1); }
            to { opacity: 0; transform: scale(0.95); }
        }
    </style>
</head>
<body class="bg-gray-50 font-sans">
    <!-- Navigation -->
    <nav class="bg-blue-600 text-white shadow-md">
        <div class="container mx-auto px-4 py-3 flex justify-between items-center">
            <img src="../assets/img/Logoputihkecil.png" alt="DengueCare Logo" class="h-10">
            <ul class="flex space-x-6">
                <li><a href="homewarga.php" class="font-medium hover:text-blue-200 transition">Beranda</a></li>
                <li><a href="#" class="font-medium hover:text-blue-200 transition">Informasi</a></li>
                <li><a href="#" class="font-medium hover:text-blue-200 transition">Forum</a></li>
                <li><a href="#" class="font-medium hover:text-blue-200 transition">Profil</a></li>
            </ul>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container mx-auto px-4 py-8">
        <!-- Header -->
        <div class="mb-8 animate-fade-in">
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Halo! Ini 
                <span class="text-blue-600">Event yang Kamu Ikuti</span>:
            </h1>
        </div>

        <!-- Events Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" id="event-container">
            <?php
            $result = mysqli_query($conn, "
                SELECT e.* FROM list_event e
                JOIN event_warga ew ON e.id = ew.id_event
                WHERE ew.id_warga = '$id_warga'
            ");

            if (mysqli_num_rows($result) == 0): ?>
                <div class="col-span-full text-center py-12 animate-fade-in">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <p class="text-lg text-gray-600">Belum ada event yang kamu ikuti.</p>
                    <a href="homewarga.php" class="mt-4 inline-block px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition btn-hover">
                        Lihat Event Tersedia
                    </a>
                </div>
            <?php else:
                while ($e = mysqli_fetch_assoc($result)): ?>
                    <div class="bg-white rounded-xl shadow-md overflow-hidden card-hover animate-slide-in" id="event-<?= $e['id'] ?>">
                        <div class="p-6">
                            <h4 class="text-xl font-semibold text-gray-800 mb-2"><?= htmlspecialchars($e['nama_event']) ?></h4>
                            <div class="space-y-2 text-gray-600 mb-4">
                                <p class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <?= htmlspecialchars($e['tanggal']) ?>
                                </p>
                                <p class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    <?= htmlspecialchars($e['lokasi']) ?>
                                </p>
                                <p class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <?= htmlspecialchars($e['waktu']) ?>
                                </p>
                                <p class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <?= htmlspecialchars($e['biaya']) ?>
                                </p>
                            </div>
                            
                            <div class="flex space-x-2">
                                <button class="flex-1 px-4 py-2 bg-gray-400 text-white rounded-lg cursor-not-allowed" disabled>
                                    Terdaftar
                                </button>
                                <button type="button" onclick="cancelEvent(<?= $e['id'] ?>)" 
                                        class="flex-1 px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition btn-hover">
                                    Batalkan
                                </button>
                            </div>
                        </div>
                    </div>
            <?php endwhile; endif; ?>
        </div>
    </div>

    <script>
    function cancelEvent(id_event) {
        if (!confirm('Apakah Anda yakin ingin membatalkan pendaftaran event ini?')) {
            return;
        }

        const card = document.getElementById('event-' + id_event);
        if (card) {
            card.classList.add('fade-out');
            
            // Wait for animation to complete before removing
            setTimeout(() => {
                const formData = new FormData();
                formData.append('cancel', id_event);

                fetch('eventsaya.php', {
                    method: 'POST',
                    body: formData
                })
                .then(res => {
                    if (res.ok) {
                        card.remove();
                        checkEmptyContainer();
                    } else {
                        throw new Error('Gagal membatalkan event');
                    }
                })
                .catch(err => {
                    console.error('Error:', err);
                    card.classList.remove('fade-out');
                    alert('Terjadi kesalahan saat membatalkan event');
                });
            }, 300);
        }
    }

    function checkEmptyContainer() {
        const container = document.getElementById('event-container');
        const remaining = container.querySelectorAll('.animate-slide-in');
        
        if (remaining.length === 0) {
            container.innerHTML = `
                <div class="col-span-full text-center py-12 animate-fade-in">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <p class="text-lg text-gray-600">Belum ada event yang kamu ikuti.</p>
                    <a href="homewarga.php" class="mt-4 inline-block px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition btn-hover">
                        Lihat Event Tersedia
                    </a>
                </div>
            `;
        }
    }
    </script>
</body>
</html>