<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DengueCare</title>
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
            Selamat Datang di <br> 
            <span class="font-bold text-white">DengueCare!</span>
        </h1>
        <p class="text-base text-white animate-fade-in">Platform inovatif untuk mengingkatkan</p>
        <p class="text-base text-white animate-fade-in">kesadaran dan informasi mengenai DBD</p>
        <a href="#" class="mt-4 text-white font-bold no-underline animate-fade-in hover:underline">
            Pelajari lebih lanjut
        </a>
    </div>

    <!-- Right Section -->
    <div class="w-1/2 bg-white flex flex-col justify-center items-center text-center p-12">
        <img src="./assets/img/Logokecil.png" alt="DengueCare2 Logo" 
             class="w-[200px] mb-[60px] animate-slide-right">
        <h2 class="text-xl text-[#1D3557] mb-8 animate-fade-in">Masuk sebagai</h2>
        <button class="btn-hover-effect w-[80%] py-3 px-4 my-3 text-base bg-[#226BD2] text-white border-none rounded-lg cursor-pointer animate-fade-in" 
                onclick="window.location.href='Loginwarga.php'">
            Warga
        </button>
        <p class="text-base text-[#858585] animate-fade-in">atau</p>
        <button class="btn-hover-effect w-[80%] py-3 px-4 my-3 text-base bg-[#226BD2] text-white border-none rounded-lg cursor-pointer animate-fade-in" 
                onclick="window.location.href='LoginKader.php'">
            Kader Kesehatan
        </button>
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