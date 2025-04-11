<?php
session_start();
include './service/koneksi.php';

// Redirect if already logged in
if(isset($_SESSION['id'])) {
    header("Location: index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate inputs
    $nama_lengkap = trim($_POST['nama_lengkap'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if (empty($nama_lengkap) || empty($password)) {
        $_SESSION['error'] = 'Nama lengkap dan password harus diisi!';
        header("Location: LoginKader.php");
        exit();
    }

    // Prepared statement with password hashing (recommended)
    $stmt = $conn->prepare("SELECT id, password FROM kader WHERE nama_lengkap = ?");
    $stmt->bind_param("s", $nama_lengkap);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        
        // Verify password (assuming you're using plain text for now - NOT recommended for production)
        // In production, use password_verify() against hashed passwords
        if ($password === $user['password']) {
            $_SESSION['id'] = $user['id'];
            $_SESSION['nama_lengkap'] = $nama_lengkap;
            header("Location: index.php");
            exit();
        }
    }

    $_SESSION['error'] = 'Nama lengkap atau password salah!';
    header("Location: LoginKader.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DengueCare - Login</title>
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
    </style>
</head>

<body class="flex h-screen w-full font-sans">
    <!-- Left Section -->
    <div class="w-1/2 bg-cover bg-center flex flex-col justify-center items-center text-center relative" 
         style="background-image: url('./assets/img/bgawal.png'); background-color: #f5f5f5;">
        <img src="./assets/img/Logobesar.png" alt="DengueCare Logo" 
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
    <div class="w-1/2 bg-white flex flex-col justify-center items-center text-center p-12">
        <img src="./assets/img/Logokecil.png" alt="DengueCare Logo" 
             class="w-[200px] mb-[60px] animate-slide-right">
        <h2 class="text-xl text-[#1D3557] mb-8 animate-fade-in">Masuk ke Halaman Utama</h2>
        
        <form action="LoginKader.php" method="post" class="w-[80%] max-w-[400px] animate-fade-in">
            <input type="text" name="nama_lengkap" placeholder="Masukkan Username" required
                   class="input-focus-effect w-full py-3 px-4 my-3 text-base border-2 border-gray-300 rounded-lg transition-all duration-300 focus:outline-none">
            <input type="password" name="password" placeholder="Masukkan Kata Sandi" required
                   class="input-focus-effect w-full py-3 px-4 my-3 text-base border-2 border-gray-300 rounded-lg transition-all duration-300 focus:outline-none">
            <button type="submit" class="btn-hover-effect w-full py-3 px-4 my-3 text-base bg-[#226BD2] text-white border-none rounded-lg cursor-pointer">
                Masuk
            </button>
        </form>

        <p class="text-base text-[#858585] mt-4 animate-fade-in">Lupa Kata Sandi? Hubungi Pihak Terkait</p>
    </div>

    <!-- Responsive Design -->
    <script>
        // This script can be used to add more interactive animations if needed
        document.addEventListener('DOMContentLoaded', () => {
            // Add any additional JavaScript interactions here
        });
    </script>
</body>

</html>