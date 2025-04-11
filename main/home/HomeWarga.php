<?php
session_start();
include "../service/koneksi.php";

// Check if user is logged in
if (!isset($_SESSION['id_warga'])) {
    echo "<script>alert('Silakan login terlebih dahulu');window.location='LoginWarga.php';</script>";
    exit;
}

$id_warga = $_SESSION['id_warga'];
$tanggal_hari_ini = date("Y-m-d");

// Check if daily complaint already submitted
$cek_keluhan = mysqli_query($conn, "SELECT * FROM keluhan_harian WHERE id_warga='$id_warga' AND tanggal='$tanggal_hari_ini'");
$sudah_isi_keluhan = mysqli_num_rows($cek_keluhan) > 0;

// Process event registration
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['daftar'])) {
    $id_event = $_POST['daftar'];
    $cek = mysqli_query($conn, "SELECT * FROM event_warga WHERE id_warga='$id_warga' AND id_event='$id_event'");
    if (mysqli_num_rows($cek) == 0) {
        mysqli_query($conn, "INSERT INTO event_warga (id_warga, id_event) VALUES ('$id_warga', '$id_event')");
    }
    header("Location: eventsaya.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beranda - DengueCare</title>
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
        
        .step { display: none; }
        .step.active { 
            display: block;
            animation: fadeIn 0.3s ease-out;
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
    </style>
</head>
<body class="bg-gray-50 font-sans">
    <!-- Navigation -->
    <?php include "../layout/navbar.php"; ?>

    <!-- Main Content -->
    <div class="container mx-auto px-4 py-8">
        <!-- Welcome Section -->
        <div class="mb-8 animate-fade-in">
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Selamat Datang, 
                <span class="text-blue-600">
                    <?= isset($_SESSION['nama_lengkap']) ? htmlspecialchars($_SESSION['nama_lengkap']) : 'Warga' ?>
                </span>!
            </h1>
            <p class="text-lg text-gray-600">Bagaimana keadaan Anda hari ini?</p>
        </div>

        <!-- Daily Complaint Form -->
        <?php if ($sudah_isi_keluhan): ?>
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-8 rounded animate-fade-in">
                <p>Anda sudah mengisi keluhan hari ini. Terima kasih!</p>
            </div>
        <?php else: ?>
            <div class="bg-white rounded-xl shadow-md p-6 mb-8 max-w-2xl mx-auto animate-slide-in">
                <h2 class="text-2xl font-semibold text-gray-800 mb-4">Form Keluhan Harian</h2>
                <form id="keluhanForm">
                    <!-- Step 1: Temperature -->
                    <div class="step active">
                        <label class="block text-gray-700 mb-2">Suhu Tubuh:</label>
                        <select name="suhu" required class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <?php for ($i = 36; $i <= 42; $i++): ?>
                                <option value="<?= $i ?>"><?= $i ?>°C</option>
                            <?php endfor; ?>
                        </select>
                    </div>

                    <!-- Step 2: Rash -->
                    <div class="step">
                        <label class="block text-gray-700 mb-2">Kapan ruam muncul setelah demam?</label>
                        <select name="ruam" required class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="Tidak Ada">Tidak Ada</option>
                            <option value="1 hari">1 hari</option>
                            <option value="2-3 hari">2-3 hari</option>
                            <option value="4-6 hari">4-6 hari</option>
                            <option value="7+ hari">7+ hari</option>
                        </select>
                    </div>

                    <!-- Step 3: Muscle Pain -->
                    <div class="step">
                        <label class="block text-gray-700 mb-2">Apakah mengalami nyeri otot?</label>
                        <select name="nyeri_otot" required class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="Ya">Ya</option>
                            <option value="Tidak">Tidak</option>
                        </select>
                    </div>

                    <!-- Step 4: Nausea -->
                    <div class="step">
                        <label class="block text-gray-700 mb-2">Apakah mengalami mual/muntah?</label>
                        <select name="mual" required class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="Ya">Ya</option>
                            <option value="Tidak">Tidak</option>
                        </select>
                    </div>

                    <!-- Step 5: Eye Pain -->
                    <div class="step">
                        <label class="block text-gray-700 mb-2">Nyeri di belakang mata?</label>
                        <select name="nyeri_belakang_mata" required class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="Ya">Ya</option>
                            <option value="Tidak">Tidak</option>
                        </select>
                    </div>

                    <!-- Step 6: Bleeding -->
                    <div class="step">
                        <label class="block text-gray-700 mb-2">Pendarahan (mimisan, gusi berdarah)?</label>
                        <select name="pendarahan" required class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="Ya">Ya</option>
                            <option value="Tidak">Tidak</option>
                        </select>
                    </div>

                    <!-- Step 7: Other Symptoms -->
                    <div class="step">
                        <label class="block text-gray-700 mb-2">Gejala lainnya:</label>
                        <textarea name="keluhan_lain" placeholder="Tulis gejala lain jika ada..." 
                                  class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"></textarea>
                    </div>

                    <!-- Form Navigation -->
                    <div class="flex justify-between mt-6">
                        <button type="button" id="prevBtn" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition btn-hover hidden">
                            Sebelumnya
                        </button>
                        <button type="button" id="nextBtn" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition btn-hover">
                            Selanjutnya
                        </button>
                        <button type="submit" id="submitBtn" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition btn-hover hidden">
                            Kirim
                        </button>
                    </div>
                </form>
                <div id="resultMessage" class="text-center py-4 hidden"></div>
            </div>
        <?php endif; ?>

        <!-- Quick Links -->
        <h3 class="text-xl font-semibold text-gray-800 mb-4 animate-fade-in">Mungkin Ada yang Perlu Anda Lihat</h3>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
            <a href="eventsaya.php" class="bg-white p-6 rounded-xl shadow-md text-center card-hover transition animate-fade-in hover:bg-blue-50">
                <div class="text-blue-600 mb-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
                <span class="font-medium">Event Saya</span>
            </a>
            
            <a href="lokasi.php" class="bg-white p-6 rounded-xl shadow-md text-center card-hover transition animate-fade-in hover:bg-blue-50">
                <div class="text-blue-600 mb-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>
                <span class="font-medium">Lokasi</span>
            </a>
            
            <div class="bg-white p-6 rounded-xl shadow-md text-center card-hover transition animate-fade-in hover:bg-blue-50">
                <div class="text-blue-600 mb-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </div>
                <span class="font-medium">Riwayat</span>
            </div>
            
            <div class="bg-white p-6 rounded-xl shadow-md text-center card-hover transition animate-fade-in hover:bg-blue-50">
                <div class="text-blue-600 mb-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <span class="font-medium">Pelaporan</span>
            </div>
        </div>

        <!-- Events Section -->
        <h3 class="text-xl font-semibold text-gray-800 mb-4 animate-fade-in">Event Tersedia</h3>
        <input type="text" id="search-bar" placeholder="Cari Event" 
               class="w-full px-4 py-2 mb-6 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 animate-fade-in">
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" id="event-grid">
            <?php
            $event = mysqli_query($conn, "SELECT * FROM list_event");
            while ($e = mysqli_fetch_assoc($event)) {
                $id_event = $e['id'];
                $cek = mysqli_query($conn, "SELECT * FROM event_warga WHERE id_warga='$id_warga' AND id_event='$id_event'");
                $terdaftar = mysqli_num_rows($cek) > 0;
            ?>
            <div class="bg-white rounded-xl shadow-md overflow-hidden card-hover animate-fade-in" data-name="<?= strtolower($e['nama_event']); ?>">
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
                    
                    <?php if ($terdaftar): ?>
                        <button class="w-full px-4 py-2 bg-gray-400 text-white rounded-lg cursor-not-allowed" disabled>
                            Terdaftar
                        </button>
                    <?php else: ?>
                        <form method="POST" action="homewarga.php">
                            <input type="hidden" name="daftar" value="<?= $e['id'] ?>">
                            <button type="submit" class="w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition btn-hover">
                                Daftar
                            </button>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>

    <script>
        // Multi-step form functionality
        const steps = document.querySelectorAll('.step');
        const nextBtn = document.getElementById('nextBtn');
        const prevBtn = document.getElementById('prevBtn');
        const submitBtn = document.getElementById('submitBtn');
        const form = document.getElementById('keluhanForm');
        const resultMessage = document.getElementById('resultMessage');
        let currentStep = 0;

        function showStep(index) {
            steps.forEach((step, i) => {
                step.classList.toggle('active', i === index);
            });
            prevBtn.style.display = index > 0 ? 'block' : 'none';
            nextBtn.style.display = index < steps.length - 1 ? 'block' : 'none';
            submitBtn.style.display = index === steps.length - 1 ? 'block' : 'none';
        }

        nextBtn.addEventListener('click', () => {
            if (currentStep < steps.length - 1) {
                currentStep++;
                showStep(currentStep);
            }
        });

        prevBtn.addEventListener('click', () => {
            if (currentStep > 0) {
                currentStep--;
                showStep(currentStep);
            }
        });

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(form);
            
            // Simulate form submission (replace with actual AJAX call)
            setTimeout(() => {
                form.style.display = 'none';
                resultMessage.innerHTML = `
                    <div class="text-green-600 mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">Terima kasih!</h3>
                    <p class="text-gray-600">Keluhan harian Anda telah berhasil dikirim.</p>
                `;
                resultMessage.classList.remove('hidden');
            }, 1000);
        });

        // Search functionality
        document.getElementById('search-bar').addEventListener('input', function() {
            const searchValue = this.value.toLowerCase();
            const eventCards = document.querySelectorAll('[data-name]');
            
            eventCards.forEach(card => {
                const eventName = card.getAttribute('data-name');
                if (eventName.includes(searchValue)) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        });

        // Initialize
        showStep(currentStep);
    </script>
</body>
</html>