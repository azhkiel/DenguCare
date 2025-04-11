<?php
session_start();
include '../service/koneksi.php';

// Check connection
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Initialize variables with proper defaults
$defaultProfilePic = "../assets/default-profile.jpg";
$user_id = $_SESSION['user_id'] ?? 1; // Fallback to 1 if session not set (for testing)

// Get user data
$query = "SELECT * FROM warga WHERE id = $user_id";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result) or die("Data pengguna tidak ditemukan.");

// Set default profile picture if none exists
$currentProfilePic = !empty($user['profile_pic']) ? $user['profile_pic'] : $defaultProfilePic;

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize inputs
    $nama_lengkap = mysqli_real_escape_string($conn, $_POST['nama_lengkap']);
    $telepon = mysqli_real_escape_string($conn, $_POST['telepon']);
    $alamat_lengkap = mysqli_real_escape_string($conn, $_POST['alamat_lengkap']);
    $profile_pic = $currentProfilePic; // Use current picture as default

    // Handle file upload
    if (isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = '../assets/uploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
        
        // Bersihkan nama user untuk dijadikan nama file
        $cleanName = preg_replace('/[^a-z0-9]/', '-', strtolower($user['nama_lengkap']));
        
        // Jika nama sama dengan file default, tambahkan timestamp
        if ($cleanName === 'default-profile') {
            $cleanName .= '-' . time();
        }
        
        // Generate nama file unik dengan menambahkan random string
        $fileName = $cleanName . '-' . bin2hex(random_bytes(4)) . '.png';
        $targetFile = $uploadDir . $fileName;
        
        // Validasi tipe file
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        $fileType = $_FILES['profile_pic']['type'];
        
        if (in_array($fileType, $allowedTypes)) {
            // Hapus file lama jika bukan default
            if ($currentProfilePic !== $defaultProfilePic && file_exists($currentProfilePic)) {
                unlink($currentProfilePic);
            }
            
            // Proses upload file baru
            if (move_uploaded_file($_FILES['profile_pic']['tmp_name'], $targetFile)) {
                // Jika bukan PNG, konversi ke PNG
                if ($fileType !== 'image/png') {
                    try {
                        $image = null;
                        switch ($fileType) {
                            case 'image/jpeg':
                                $image = imagecreatefromjpeg($targetFile);
                                break;
                            case 'image/gif':
                                $image = imagecreatefromgif($targetFile);
                                break;
                        }
                        
                        if ($image !== null) {
                            // Simpan sebagai PNG dan hapus file asli
                            imagepng($image, $targetFile);
                            imagedestroy($image);
                        }
                    } catch (Exception $e) {
                        // Jika gagal konversi, hapus file yang diupload
                        unlink($targetFile);
                        $error_message = "Gagal mengkonversi gambar: " . $e->getMessage();
                    }
                }
                
                // Update path profile pic jika semua berhasil
                if (file_exists($targetFile)) {
                    $profile_pic = $targetFile;
                }
            } else {
                $error_message = "Gagal mengupload file.";
            }
        } else {
            $error_message = "Format file tidak didukung. Hanya JPEG, PNG, atau GIF yang diperbolehkan.";
        }
    }

    // Update database
    $updateQuery = "UPDATE warga SET 
                    nama_lengkap = '$nama_lengkap', 
                    telepon = '$telepon', 
                    alamat_lengkap = '$alamat_lengkap', 
                    profile_pic = '$profile_pic' 
                    WHERE id = $user_id";

    if (mysqli_query($conn, $updateQuery)) {
        $_SESSION['success_message'] = "Profil berhasil diperbarui!";
        header("Location: profil.php");
        exit();
    } else {
        $error_message = "Gagal memperbarui data: " . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profil - DengueCare</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <style>
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
        .animate-fade-in-up {
            animation: fadeInUp 0.6s ease-out forwards;
        }
        .profile-pic-upload:hover .edit-overlay {
            opacity: 1;
        }
    </style>
</head>

<body class="bg-gray-50 font-sans">
    <!-- Navbar -->
    <?php include "../layout/navbar.php"; ?>
    <!-- Main Content -->
    <div class="container mx-auto px-4 py-8 max-w-4xl">
        <div class="bg-white rounded-xl shadow-md overflow-hidden p-6 animate-fade-in-up">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Edit Profil</h2>
            
            <?php if (isset($error_message)): ?>
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded animate-shake">
                    <p><?= htmlspecialchars($error_message) ?></p>
                </div>
            <?php endif; ?>

            <form action="" method="POST" enctype="multipart/form-data" class="space-y-6">
                <!-- Profile Picture -->
                <div class="space-y-2">
                    <label class="block text-gray-700 font-medium">Foto Profil</label>
                    <div class="profile-pic-upload relative w-32 h-32 rounded-full overflow-hidden border-4 border-blue-100 cursor-pointer transition-all duration-300 hover:border-blue-300 hover:shadow-lg">
                        <img 
                            src="<?= htmlspecialchars($currentProfilePic) ?>" 
                            alt="Foto Profil" 
                            id="profilePicPreview"
                            class="w-full h-full object-cover"
                        >
                        <div class="edit-overlay absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center opacity-0 transition-opacity duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                        </div>
                        <input 
                            type="file" 
                            id="profile_pic" 
                            name="profile_pic" 
                            accept="image/*" 
                            class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                            onchange="previewProfilePic(event)"
                        >
                    </div>
                </div>

                <!-- Name -->
                <div class="space-y-2">
                    <label for="nama_lengkap" class="block text-gray-700 font-medium">Nama Lengkap</label>
                    <input 
                        type="text" 
                        id="nama_lengkap" 
                        name="nama_lengkap" 
                        value="<?= htmlspecialchars($user['nama_lengkap']) ?>" 
                        required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                    >
                </div>

                <!-- Phone -->
                <div class="space-y-2">
                    <label for="telepon" class="block text-gray-700 font-medium">Nomor Telepon</label>
                    <input 
                        type="tel" 
                        id="telepon" 
                        name="telepon" 
                        value="<?= htmlspecialchars($user['telepon']) ?>" 
                        required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                    >
                </div>

                <!-- Address -->
                <div class="space-y-2">
                    <label for="alamat_lengkap" class="block text-gray-700 font-medium">Alamat Lengkap</label>
                    <textarea 
                        id="alamat_lengkap" 
                        name="alamat_lengkap" 
                        rows="3" 
                        required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                    ><?= htmlspecialchars($user['alamat_lengkap']) ?></textarea>
                </div>

                <!-- Submit Button -->
                <div class="pt-4">
                    <button 
                        type="submit" 
                        class="px-6 py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-200 transform hover:-translate-y-1 shadow-md hover:shadow-lg"
                    >
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Profile picture preview
        function previewProfilePic(event) {
            const preview = document.getElementById('profilePicPreview');
            const file = event.target.files[0];
            
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    // Add slight zoom effect on change
                    preview.style.transform = 'scale(1.1)';
                    setTimeout(() => {
                        preview.style.transform = 'scale(1)';
                    }, 300);
                }
                reader.readAsDataURL(file);
            }
        }

        // Form validation
        document.querySelector('form').addEventListener('submit', function(e) {
            const nama = document.getElementById('nama_lengkap').value.trim();
            const telepon = document.getElementById('telepon').value.trim();
            const alamat = document.getElementById('alamat_lengkap').value.trim();
            
            if (!nama || !telepon || !alamat) {
                e.preventDefault();
                alert('Harap lengkapi semua bidang!');
                return false;
            }
            
            // Simple phone number validation
            if (!/^[0-9]{10,15}$/.test(telepon)) {
                e.preventDefault();
                alert('Nomor telepon harus antara 10-15 digit angka');
                return false;
            }
        });
    </script>
</body>
</html>