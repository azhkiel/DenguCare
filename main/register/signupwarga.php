<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
session_regenerate_id(true);
include '../service/koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form
    $telepon = isset($_POST['telepon']) ? trim($_POST['telepon']) : "";
    $password = isset($_POST['password']) ? trim($_POST['password']) : "";
    $confirm_password = isset($_POST['confirm_password']) ? trim($_POST['confirm_password']) : "";

    // Validasi apakah semua field telah diisi
    if (empty($telepon) || empty($password) || empty($confirm_password)) {
        $_SESSION['error'] = 'Harap isi semua kolom!';
        header("Location: signupwarga.php");
        exit;
    }

    // Validasi format password (min 8 karakter, ada huruf dan angka)
    if (!preg_match("/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d!@#$%^&*]{8,}$/", $password)) {
        $_SESSION['error'] = 'Password harus minimal 8 karakter dan mengandung huruf dan angka!';
        header("Location: signupwarga.php");
        exit;
    }

    // Konfirmasi password
    if ($password !== $confirm_password) {
        $_SESSION['error'] = 'Konfirmasi kata sandi tidak sesuai!';
        header("Location: signupwarga.php");
        exit;
    }

    // Hash password
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // Cek apakah nomor sudah terdaftar
    $cekTelepon = $conn->prepare("SELECT * FROM warga WHERE telepon = ?");
    $cekTelepon->bind_param("s", $telepon);
    $cekTelepon->execute();
    $result = $cekTelepon->get_result();

    if ($result->num_rows > 0) {
        $_SESSION['error'] = 'Nomor telepon sudah terdaftar!';
        header("Location: signupwarga.php");
    } else {
        // Simpan ke session sebelum verifikasi OTP
        $_SESSION['telepon'] = $telepon;
        $_SESSION['password'] = $hashed_password;

        // Simulasi OTP
        $_SESSION['kode_otp'] = rand(10000, 99999);

        // Arahkan ke halaman verifikasi OTP
        header("Location: kode.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DengueCare - Daftar</title>
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
        
        .checkbox-container input[type="checkbox"] {
            width: 18px;
            height: 18px;
            margin-right: 15px;
            cursor: pointer;
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
        <img src="../assets/img/Logokecil.png" alt="DengueCare Logo" 
             class="w-[200px] mb-[60px] animate-slide-right">
        <h2 class="text-xl text-[#1D3557] mb-8 animate-fade-in">Buat Akun</h2>
        
        <?php if(isset($_SESSION['error'])): ?>
            <div class="mb-4 p-3 bg-red-100 text-red-700 rounded-lg animate-fade-in w-[80%] max-w-[400px]">
                <?php echo htmlspecialchars($_SESSION['error']); ?>
                <?php unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>
        
        <form action="signupwarga.php" method="post" class="w-[80%] max-w-[400px] animate-fade-in">
            <input type="text" name="telepon" placeholder="Nomor Telepon" required pattern="[0-9]+"
                   title="Hanya angka yang diperbolehkan"
                   class="input-focus-effect w-full py-3 px-4 my-3 text-base border-2 border-gray-300 rounded-lg transition-all duration-300 focus:outline-none"
                   value="<?php echo isset($_POST['telepon']) ? htmlspecialchars($_POST['telepon']) : '' ?>">
                   
            <input type="password" name="password" placeholder="Kata Sandi (min. 8 karakter, huruf & angka)" required
                   class="input-focus-effect w-full py-3 px-4 my-3 text-base border-2 border-gray-300 rounded-lg transition-all duration-300 focus:outline-none">
                   
            <input type="password" name="confirm_password" placeholder="Konfirmasi Kata Sandi" required
                   class="input-focus-effect w-full py-3 px-4 my-3 text-base border-2 border-gray-300 rounded-lg transition-all duration-300 focus:outline-none">

            <div class="flex items-start w-full my-3 animate-fade-in">
                <input type="checkbox" id="agree" required
                       class="w-5 h-5 mt-1 mr-3 cursor-pointer">
                <label for="agree" class="text-sm text-left text-gray-600">
                    Dengan melanjutkan, Anda menerima kebijakan privasi dan ketentuan penggunaan kami
                </label>
            </div>
                   
            <button type="submit" class="btn-hover-effect w-full py-3 px-4 my-3 text-base bg-[#226BD2] text-white border-none rounded-lg cursor-pointer">
                Lanjut
            </button>
        </form>

        <p class="text-base text-[#858585] mt-4 animate-fade-in">
            Sudah punya akun? 
            <a href="Loginwarga.php" class="text-[#226BD2] hover:underline">Masuk</a>
        </p>
    </div>

    <!-- Responsive Design -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Add any additional JavaScript interactions here
        });
    </script>
</body>

</html>