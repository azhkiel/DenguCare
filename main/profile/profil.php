<?php
session_start();
include '../service/koneksi.php';
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Ambil data pengguna dari database berdasarkan ID
$query = "SELECT * FROM warga WHERE id = 1";
$result = mysqli_query($conn, $query);

$user = null;
if ($result && mysqli_num_rows($result) > 0) {
    $user = mysqli_fetch_assoc($result);
} else {
    echo "Data pengguna tidak ditemukan.";
    exit();
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil - DengueCare</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#114FA8',
                        secondary: '#226BD2',
                    },
                    animation: {
                        'fade-in': 'fadeIn 0.5s ease-in',
                        'fade-in-up': 'fadeInUp 0.5s ease-out',
                        'pulse-slow': 'pulse 3s infinite',
                    }
                }
            }
        }
    </script>
    <style type="text/css">
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body class="font-sans bg-gray-50">
    <!-- Navbar -->
     <?php include "../layout/navbar.php";?>
    <!-- Konten Profil -->
    <div class="max-w-4xl mx-auto py-8 px-6 animate-fade-in-up">
        <div class="mb-8">
            <?php if ($user): ?>
                <div class="flex items-center gap-4 mb-6">
                    <div class="relative w-24 h-24 rounded-full overflow-hidden group cursor-pointer transition-all duration-300 hover:shadow-lg">
                        <img src="<?= !empty($user['profile_pic']) ? htmlspecialchars($user['profile_pic']) : '../assets/img/default-profile.jpg'; ?>" 
                             alt="Foto Profil" 
                             class="w-full h-full object-cover transition-opacity duration-300 group-hover:opacity-50">
                        <a href="edit-profile.php" class="absolute inset-0 flex items-center justify-center bg-black bg-opacity-50 opacity-0 group-hover:opacity-100 transition-opacity duration-300 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" 
                            class="w-8 h-8 text-gray-500 hover:text-blue-600 transition-colors duration-200 cursor-pointer">
                        <path d="M21.731 2.269a2.625 2.625 0 00-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 000-3.712zM19.513 8.199l-3.712-3.712-8.4 8.4a5.25 5.25 0 00-1.32 2.214l-.8 2.685a.75.75 0 00.933.933l2.685-.8a5.25 5.25 0 002.214-1.32l8.4-8.4z" />
                        <path d="M5.25 5.25a3 3 0 00-3 3v10.5a3 3 0 003 3h10.5a3 3 0 003-3V13.5a.75.75 0 00-1.5 0v5.25a1.5 1.5 0 01-1.5 1.5H5.25a1.5 1.5 0 01-1.5-1.5V8.25a1.5 1.5 0 011.5-1.5h5.25a.75.75 0 000-1.5H5.25z" />
                        </svg>
                        </a>
                    </div>
                    <div class="flex flex-col justify-center">
                        <h2 class="text-2xl font-bold text-gray-800"><?= htmlspecialchars($user['nama_lengkap']) ?></h2>
                        <p class="text-gray-600">NIK: <?= htmlspecialchars($user['nik']) ?></p>
                    </div>
                </div>
                <p class="text-gray-700 mb-2">Nomor Telepon: <?= htmlspecialchars($user['telepon']) ?></p>
                <p class="text-gray-700">Alamat: <?= nl2br(htmlspecialchars($user['alamat_lengkap'])) ?></p>
            <?php else: ?>
                <p class="text-red-500">Data pengguna tidak ditemukan.</p>
            <?php endif; ?>
        </div>

        <div class="my-6 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 rounded animate-pulse-slow">
            <p class="font-bold">KONDISI RUMAH AMAN</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mt-8">
            <!-- Save Button -->
            <div class="flex items-center p-4 bg-white border border-gray-200 rounded-lg cursor-pointer transition-all duration-300 hover:bg-gray-50 hover:shadow-md hover:-translate-y-1">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6 mr-3 text-blue-600">
                    <path d="M5.566 4.657A4.505 4.505 0 016.75 4.5h10.5c.41 0 .806.055 1.183.157A3 3 0 0015.75 3h-7.5a3 3 0 00-2.684 1.657zM2.25 12a3 3 0 013-3h13.5a3 3 0 013 3v6a3 3 0 01-3 3H5.25a3 3 0 01-3-3v-6zM5.25 7.5c-.41 0-.806.055-1.184.157A3 3 0 016.75 6h10.5a3 3 0 012.683 1.657A4.505 4.505 0 0018.75 7.5H5.25z" />
                </svg>
                <span class="font-bold text-gray-800">Simpan</span>
            </div>

            <!-- Logout Button -->
            <div class="flex items-center p-4 bg-white border border-gray-200 rounded-lg cursor-pointer transition-all duration-300 hover:bg-gray-50 hover:shadow-md hover:-translate-y-1">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6 mr-3 text-red-600">
                    <path fill-rule="evenodd" d="M7.5 3.75A1.5 1.5 0 006 5.25v13.5a1.5 1.5 0 001.5 1.5h6a1.5 1.5 0 001.5-1.5V15a.75.75 0 011.5 0v3.75a3 3 0 01-3 3h-6a3 3 0 01-3-3V5.25a3 3 0 013-3h6a3 3 0 013 3V9A.75.75 0 0115 9V5.25a1.5 1.5 0 00-1.5-1.5h-6zm10.72 4.72a.75.75 0 011.06 0l3 3a.75.75 0 010 1.06l-3 3a.75.75 0 11-1.06-1.06l1.72-1.72H9a.75.75 0 010-1.5h10.94l-1.72-1.72a.75.75 0 010-1.06z" clip-rule="evenodd" />
                </svg>
                <span class="font-bold text-gray-800">Keluar</span>
            </div>
        </div>
    </div>

    <script>
        // Add additional animations on scroll
        document.addEventListener('DOMContentLoaded', () => {
            const elements = document.querySelectorAll('.animate-fade-in-up');
            
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('animate-fadeInUp');
                        observer.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.1 });

            elements.forEach(element => {
                observer.observe(element);
            });
        });
    </script>
</body>

</html>