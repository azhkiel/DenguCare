<?php
session_start();
include '../service/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $ktp_dir = "../assets/foto_ktp/";
    $diri_dir = "../assets/foto_diri_ktp/";
    $allowed_ext = ['jpg', 'jpeg', 'png'];
    $max_size = 10485760; // 10MB

    // Ambil data dari session
    $nik            = $_SESSION['nik'];
    $nama_lengkap   = $_SESSION['nama_lengkap'];
    $tempat_lahir   = $_SESSION['tempat_lahir'];
    $tanggal_lahir  = $_SESSION['tanggal_lahir']; // Format: YYYY-MM-DD
    $jenis_kelamin  = $_SESSION['jenis_kelamin'];
    $alamat_lengkap = $_SESSION['alamat_lengkap'];
    $rt_id          = $_SESSION['rt_id'];
    $telepon        = $_SESSION['telepon'];
    $password       = $_SESSION['password'];

    // Tambahan info (misalnya dari session atau lookup berdasarkan RT ID)
    $kecamatan      = $_SESSION['kecamatan'];   // pastikan diset sebelumnya
    $kelurahan      = $_SESSION['kelurahan'];   // pastikan diset sebelumnya
    $rt_rw          = $_SESSION['rt_rw'];       // gabungan RT/RW, misal "01/02"

    function sanitize($string) {
        return preg_replace('/[^A-Za-z0-9_]/', '_', strtolower($string));
    }

    function formatFileName($prefix, $nama, $kecamatan, $kelurahan, $rt_rw, $ext) {
        $timestamp = date("His_dmY"); // Format: jammenitdetik_tanggalbulanTahun, misal: 143025_110425    
        $nama_sanitized = sanitize($nama);
        $kec_sanitized = sanitize($kecamatan);
        $kel_sanitized = sanitize($kelurahan);
        $rt_rw_sanitized = sanitize($rt_rw);

    return "{$prefix}_{$timestamp}_{$nama_sanitized}_{$kec_sanitized}_{$kel_sanitized}_{$rt_rw_sanitized}.{$ext}";

    }

    function handleUpload($fileInputName, $fileNameFormatted, $target_dir, $allowed_ext, $max_size) {
        $file = $_FILES[$fileInputName];
        $file_tmp = $file["tmp_name"];
        $file_size = $file["size"];
        $file_ext = strtolower(pathinfo($file["name"], PATHINFO_EXTENSION));

        if (!in_array($file_ext, $allowed_ext)) {
            $_SESSION['error'] = "Hanya file JPG, JPEG, dan PNG yang diperbolehkan untuk $fileInputName.";
            header("Location: upload_ktp.php");
            exit;
        }

        if ($file_size > $max_size) {
            $_SESSION['error'] = "Ukuran file terlalu besar untuk $fileInputName. Maksimal 10MB.";
            header("Location: upload_ktp.php");
            exit;
        }

        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        $target_file = $target_dir . $fileNameFormatted;

        if (!move_uploaded_file($file_tmp, $target_file)) {
            $_SESSION['error'] = "Gagal mengunggah file untuk $fileInputName.";
            header("Location: upload_ktp.php");
            exit;
        }

        return $fileNameFormatted;
    }

    // Format nama file
    $foto_ktp_nama = formatFileName("ktp", $nama_lengkap, $kecamatan, $kelurahan, $rt_rw, "png");
    $foto_diri_nama = formatFileName("diri", $nama_lengkap, $kecamatan, $kelurahan, $rt_rw, "png");

    // Upload file
    $foto_ktp = handleUpload("ktp", $foto_ktp_nama, $ktp_dir, $allowed_ext, $max_size);
    $foto_diri = handleUpload("foto_diri", $foto_diri_nama, $diri_dir, $allowed_ext, $max_size);

    // Simpan ke database
    $stmt = $conn->prepare("INSERT INTO warga 
        (nik, nama_lengkap, tempat_lahir, tanggal_lahir, jenis_kelamin, alamat_lengkap, rt_id, telepon, password, foto_ktp, foto_diri_ktp) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssissss", $nik, $nama_lengkap, $tempat_lahir, $tanggal_lahir, $jenis_kelamin, $alamat_lengkap, $rt_id, $telepon, $password, $foto_ktp, $foto_diri);

    if ($stmt->execute()) {
        session_unset();
        session_destroy();
        $_SESSION['success'] = "Pendaftaran berhasil!";
        header("Location: ../LoginWarga.php");
        exit;
    } else {
        $_SESSION['error'] = "Gagal menyimpan data ke database: " . $stmt->error;
        header("Location: upload_ktp.php");
        exit;
    }

    $stmt->close();
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Unggah KTP - DengueCare</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        @keyframes slideInLeft {
            from { transform: translateX(-50px); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
        
        @keyframes slideInRight {
            from { transform: translateX(50px); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
        
        .animate-fade-in {
            animation: fadeIn 1s ease-out forwards;
        }
        
        .animate-slide-left {
            animation: slideInLeft 0.8s ease-out forwards;
        }
        
        .animate-slide-right {
            animation: slideInRight 0.8s ease-out forwards;
        }
        
        .btn-hover-effect {
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        
        .btn-hover-effect:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 8px rgba(0, 0, 0, 0.15);
        }
        
        .file-upload {
            transition: all 0.3s ease;
        }
        
        .file-upload:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 8px rgba(0, 0, 0, 0.1);
        }
        
        .file-upload input[type="file"] {
            display: none;
        }
    </style>
</head>

<body class="flex h-screen w-full font-sans">
    <!-- Left Section -->
    <div class="w-1/2 bg-cover bg-center flex flex-col justify-center items-center text-center relative" 
         style="background-image: url('../assets/img/bgawal.png'); background-color: #f5f5f5;">
        <img src="../assets/img/Logobesar.png" alt="DengueCare Logo" 
             class="w-[70%] max-w-[300px] mb-[200px] animate-slide-left">
        <h1 class="text-2xl text-white mb-5 animate-fade-in">
            Selamat Datang Warga Surabaya! <br> 
            <span class="font-bold text-white">Bersama Lawan DBD</span>
        </h1>
        <p class="text-base text-white animate-fade-in">Platform inovatif untuk meningkatkan kesadaran dan informasi mengenai DBD</p>
        <a href="#" class="mt-4 text-white font-bold no-underline animate-fade-in hover:underline">
            Pelajari lebih lanjut
        </a>
    </div>

    <!-- Right Section -->
    <div class="w-1/2 bg-white flex flex-col justify-center items-center text-center p-12 overflow-y-auto">
        <img src="../assets/img/Logokecil.png" alt="DengueCare Logo" 
             class="w-[200px] mt-[100px] mb-[30px] animate-slide-right">
        <h2 class="text-xl text-[#1D3557] mb-4 animate-fade-in">Upload Foto KTP & KK</h2>
        <p class="text-base text-gray-600 mb-8 animate-fade-in">Silakan unggah foto KTP dan KK Anda dengan jelas dan sesuai contoh di bawah:</p>
        
        <?php if(isset($_SESSION['error'])): ?>
            <div class="mb-4 p-3 bg-red-100 text-red-700 rounded-lg animate-fade-in w-[80%] max-w-[400px]">
                <?php echo htmlspecialchars($_SESSION['error']); ?>
                <?php unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>
        
        <div class="flex space-x-4 mb-8 animate-fade-in">
            <div class="border-2 border-gray-200 rounded-lg p-2">
                <img src="../assets/img/contoh_ktp.png" alt="Contoh KTP" class="h-40 object-contain" />
                <p class="text-sm text-gray-600 mt-2">Contoh Foto KTP</p>
            </div>
            <div class="border-2 border-gray-200 rounded-lg p-2">
                <img src="../assets/img/contoh_diri.png" alt="Contoh KK" class="h-40 object-contain" />
                <p class="text-sm text-gray-600 mt-2">Contoh Foto Diri dengan KTP</p>
            </div>
        </div>
        
        <form action="upload_ktp.php" method="POST" enctype="multipart/form-data" class="w-[80%] max-w-[400px] animate-fade-in space-y-6">
            <div class="file-upload">
                <label for="ktp-upload" class="cursor-pointer bg-gray-100 hover:bg-gray-200 text-gray-700 py-3 px-4 rounded-lg border-2 border-dashed border-gray-300 w-full block transition-all duration-300">
                    <div class="flex flex-col items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-500 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                        </svg>
                        <span class="font-medium">Pilih Foto KTP</span>
                        <span id="ktp-preview" class="text-sm text-gray-500 mt-1">Belum ada file yang dipilih</span>
                    </div>
                </label>
                <input type="file" id="ktp-upload" name="ktp" accept="image/*" required class="hidden" onchange="previewFile('ktp-upload', 'ktp-preview')" />
            </div>
            
            <div class="file-upload">
                <label for="diri-upload" class="cursor-pointer bg-gray-100 hover:bg-gray-200 text-gray-700 py-3 px-4 rounded-lg border-2 border-dashed border-gray-300 w-full block transition-all duration-300">
                    <div class="flex flex-col items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-500 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                        </svg>
                        <span class="font-medium">Pilih Foto Diri dengan KTP</span>
                        <span id="diri-preview" class="text-sm text-gray-500 mt-1">Belum ada file yang dipilih</span>
                    </div>
                </label>
                <input type="file" id="diri-upload" name="foto_diri" accept="image/*" required class="hidden" onchange="previewFile('diri-upload', 'diri-preview')" />
            </div>
            
            <button type="submit" class="btn-hover-effect w-full py-3 px-4 text-base bg-[#226BD2] text-white border-none rounded-lg cursor-pointer">
                Lanjut
            </button>
        </form>
    </div>

    <script>
        function previewFile(inputId, previewId) {
            const input = document.getElementById(inputId);
            const preview = document.getElementById(previewId);
            const file = input.files[0];

            if (file) {
                preview.textContent = "File dipilih: " + file.name;
                preview.classList.remove('text-gray-500');
                preview.classList.add('text-green-600', 'font-medium');
            } else {
                preview.textContent = "Belum ada file yang dipilih";
                preview.classList.remove('text-green-600', 'font-medium');
                preview.classList.add('text-gray-500');
            }
        }
    </script>
</body>
</html>