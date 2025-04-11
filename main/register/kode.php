<?php
session_start();

include '../service/koneksi.php';

// Periksa apakah kode OTP sudah dibuat
if (!isset($_SESSION['kode_otp'])) {
    header("Location: signupwarga.php");
    exit;
}

// Handle OTP verification
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $input_otp = $_POST['otp'];

    if ($input_otp == $_SESSION['kode_otp']) {
        header("Location: inputdatadiri.php");
        exit;
    } else {
        $_SESSION['error_message'] = "Kode OTP salah, silakan coba lagi!";
        header("Location: kod.php");
        exit;
    }
}

// Cek apakah ada error dari proses sebelumnya
$error_message = isset($_SESSION['error_message']) ? $_SESSION['error_message'] : "";
unset($_SESSION['error_message']);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Kode OTP</title>
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
        
        .input-focus-effect:focus {
            box-shadow: 0 0 0 3px rgba(34, 107, 210, 0.3);
            border-color: #226BD2;
        }
        
        .otp-popup {
            animation: fadeIn 0.5s ease-out;
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
            Halo Warga Surabaya! <br> 
            <span class="font-bold text-white">Ayo Peduli DBD</span>
        </h1>
        <p class="text-base text-white animate-fade-in">Platform inovatif untuk meningkatkan kesadaran dan informasi mengenai DBD</p>
        <a href="#" class="mt-4 text-white font-bold no-underline animate-fade-in hover:underline">
            Pelajari lebih lanjut
        </a>
    </div>

    <!-- Right Section -->
    <div class="w-1/2 bg-white flex flex-col justify-center items-center text-center p-12">
        <img src="..    /assets/img/Logokecil.png" alt="DengueCare Logo" 
             class="w-[200px] mb-[60px] animate-slide-right">
        <h2 class="text-xl text-[#1D3557] mb-4 animate-fade-in">Verifikasi Kode OTP</h2>
        <p class="text-base text-gray-600 mb-8 animate-fade-in">Kode telah dikirim ke WhatsApp Anda!</p>
        
        <?php if (!empty($error_message)): ?>
            <div class="mb-4 p-3 bg-red-100 text-red-700 rounded-lg animate-fade-in w-[80%] max-w-[400px]">
                <?php echo htmlspecialchars($error_message); ?>
            </div>
        <?php endif; ?>
        
        <form action="kode_html.php" method="POST" class="w-[80%] max-w-[400px] animate-fade-in">
            <div class="relative mb-6">
                <input type="text" name="otp" required
                       class="input-focus-effect w-full py-3 px-4 text-base border-2 border-gray-300 rounded-lg transition-all duration-300 focus:outline-none"
                       placeholder="Masukkan 6 digit kode OTP">
            </div>
            
            <button type="submit" class="btn-hover-effect w-full py-3 px-4 text-base bg-[#226BD2] text-white border-none rounded-lg cursor-pointer">
                Verifikasi
            </button>
        </form>

        <p class="text-base text-[#858585] mt-6 animate-fade-in">
            Tidak menerima kode? 
            <a href="resend_otp.php" class="text-[#226BD2] hover:underline">Kirim Lagi</a>
        </p>
    </div>

    <!-- OTP Popup (hidden by default) -->
    <div id="otpPopup" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
        <div class="bg-white p-8 rounded-lg shadow-lg max-w-md w-full mx-4 otp-popup">
            <h3 class="text-xl font-bold text-[#1D3557] mb-4">Kode Verifikasi Anda</h3>
            <p class="text-gray-600 mb-6">Silakan gunakan kode berikut untuk verifikasi:</p>
            <div class="bg-blue-50 p-4 rounded-lg mb-6">
                <p class="text-2xl font-bold text-center text-[#226BD2]"><?php echo $_SESSION['kode_otp']; ?></p>
            </div>
            <button onclick="closeOtpPopup()" class="btn-hover-effect w-full py-2 px-4 text-base bg-[#226BD2] text-white border-none rounded-lg cursor-pointer">
                Tutup
            </button>
        </div>
    </div>

    <script>
        // Show OTP popup after page loads
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(() => {
                document.getElementById('otpPopup').classList.remove('hidden');
            }, 500);
        });

        function closeOtpPopup() {
            document.getElementById('otpPopup').classList.add('hidden');
        }

        // Auto focus OTP input
        const otpInput = document.querySelector('input[name="otp"]');
        if (otpInput) {
            otpInput.focus();
        }
    </script>
</body>

</html>