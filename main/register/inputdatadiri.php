<?php
session_start();
include '../service/koneksi.php';

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $_SESSION['nik'] = $_POST['nik'];
    $_SESSION['nama_lengkap'] = $_POST['nama_lengkap'];
    $_SESSION['tempat_lahir'] = $_POST['tempat_lahir'];
    $_SESSION['tanggal_lahir'] = $_POST['tanggal_lahir'];
    $_SESSION['jenis_kelamin'] = $_POST['jenis_kelamin'];
    $_SESSION['alamat_lengkap'] = $_POST['alamat_lengkap'];
    $_SESSION['rt_id'] = $_POST['rt_id'];

    header("Location: upload_ktp.php");
    exit;
}

function getKecamatanOptions($conn) {
    $options = "<option value=''>Pilih Kecamatan</option>";
    $result = mysqli_query($conn, "SELECT id, nama_kecamatan FROM kecamatan ORDER BY nama_kecamatan ASC");
    while ($row = mysqli_fetch_assoc($result)) {
        $options .= "<option value='{$row['id']}'>{$row['nama_kecamatan']}</option>";
    }
    return $options;
}
$option_kecamatan = getKecamatanOptions($conn);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DengueCare - Input Data Diri</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
        
        select {
            appearance: none;
            background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right 0.75rem center;
            background-size: 1em;
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
    <div class="w-1/2 bg-white flex flex-col justify-center items-center text-center p-12 overflow-y-auto">
        <img src="../assets/img/Logokecil.png" alt="DengueCare Logo" 
             class="w-[200px] mb-[30px] mt-[200px] animate-slide-right">
        <h2 class="text-xl text-[#1D3557] mb-8 animate-fade-in">Input Data Diri</h2>
        
        <form method="post" class="w-[80%] max-w-[400px] animate-fade-in space-y-4">
            <input type="text" name="nik" placeholder="NIK" required
                   class="input-focus-effect w-full py-3 px-4 text-base border-2 border-gray-300 rounded-lg transition-all duration-300 focus:outline-none"
                   value="<?= isset($_SESSION['nik']) ? htmlspecialchars($_SESSION['nik']) : '' ?>">
                   
            <input type="text" name="nama_lengkap" placeholder="Nama Lengkap" required
                   class="input-focus-effect w-full py-3 px-4 text-base border-2 border-gray-300 rounded-lg transition-all duration-300 focus:outline-none"
                   value="<?= isset($_SESSION['nama_lengkap']) ? htmlspecialchars($_SESSION['nama_lengkap']) : '' ?>">
                   
            <input type="text" name="tempat_lahir" placeholder="Tempat Lahir" required
                   class="input-focus-effect w-full py-3 px-4 text-base border-2 border-gray-300 rounded-lg transition-all duration-300 focus:outline-none"
                   value="<?= isset($_SESSION['tempat_lahir']) ? htmlspecialchars($_SESSION['tempat_lahir']) : '' ?>">
                   
            <input type="date" name="tanggal_lahir" required
                   class="input-focus-effect w-full py-3 px-4 text-base border-2 border-gray-300 rounded-lg transition-all duration-300 focus:outline-none"
                   value="<?= isset($_SESSION['tanggal_lahir']) ? htmlspecialchars($_SESSION['tanggal_lahir']) : '' ?>">
                   
            <select name="jenis_kelamin" required
                    class="input-focus-effect w-full py-3 px-4 text-base border-2 border-gray-300 rounded-lg transition-all duration-300 focus:outline-none">
                <option value="">Pilih Jenis Kelamin</option>
                <option value="Laki-laki" <?= (isset($_SESSION['jenis_kelamin'])) && $_SESSION['jenis_kelamin'] === 'Laki-laki' ? 'selected' : '' ?>>Laki-laki</option>
                <option value="Perempuan" <?= (isset($_SESSION['jenis_kelamin'])) && $_SESSION['jenis_kelamin'] === 'Perempuan' ? 'selected' : '' ?>>Perempuan</option>
            </select>
            
            <input type="text" name="alamat_lengkap" placeholder="Alamat Lengkap" required
                   class="input-focus-effect w-full py-3 px-4 text-base border-2 border-gray-300 rounded-lg transition-all duration-300 focus:outline-none"
                   value="<?= isset($_SESSION['alamat_lengkap']) ? htmlspecialchars($_SESSION['alamat_lengkap']) : '' ?>">
                   
            <select id="kecamatan" name="kecamatan_id" required
                    class="input-focus-effect w-full py-3 px-4 text-base border-2 border-gray-300 rounded-lg transition-all duration-300 focus:outline-none">
                <?= $option_kecamatan ?>
            </select>
            
            <select id="kelurahan" name="kelurahan_id" required
                    class="input-focus-effect w-full py-3 px-4 text-base border-2 border-gray-300 rounded-lg transition-all duration-300 focus:outline-none">
                <option value="">Pilih Kelurahan</option>
            </select>
            
            <select id="rw" name="rw_id" required
                    class="input-focus-effect w-full py-3 px-4 text-base border-2 border-gray-300 rounded-lg transition-all duration-300 focus:outline-none">
                <option value="">Pilih RW</option>
            </select>
            
            <select id="rt" name="rt_id" required
                    class="input-focus-effect w-full py-3 px-4 text-base border-2 border-gray-300 rounded-lg transition-all duration-300 focus:outline-none">
                <option value="">Pilih RT</option>
                <?php if (isset($_SESSION['rt_id'])): ?>
                    <option value="<?= $_SESSION['rt_id'] ?>" selected>RT <?= $_SESSION['rt_id'] ?></option>
                <?php endif; ?>
            </select>
            
            <button type="submit" class="btn-hover-effect w-full py-3 px-4 mt-6 text-base bg-[#226BD2] text-white border-none rounded-lg cursor-pointer">
                Lanjut
            </button>
        </form>
    </div>

    <script>
    $(document).ready(function() {
        // Chain dropdown functionality
        $('#kecamatan').change(function() {
            var kecamatan_id = $(this).val();
            if(kecamatan_id) {
                $.post('ajax_dropdown.php', {action: 'get_kelurahan', kecamatan_id: kecamatan_id}, function(data) {
                    $('#kelurahan').html(data).prop('disabled', false);
                    $('#rw').html('<option value="">Pilih RW</option>').prop('disabled', true);
                    $('#rt').html('<option value="">Pilih RT</option>').prop('disabled', true);
                }).fail(function() {
                    alert('Gagal memuat data kelurahan');
                });
            } else {
                $('#kelurahan, #rw, #rt').html('<option value="">Pilih terlebih dahulu</option>').prop('disabled', true);
            }
        });

        $('#kelurahan').change(function() {
            var kelurahan_id = $(this).val();
            if(kelurahan_id) {
                $.post('ajax_dropdown.php', {action: 'get_rw', kelurahan_id: kelurahan_id}, function(data) {
                    $('#rw').html(data).prop('disabled', false);
                    $('#rt').html('<option value="">Pilih RT</option>').prop('disabled', true);
                }).fail(function() {
                    alert('Gagal memuat data RW');
                });
            } else {
                $('#rw, #rt').html('<option value="">Pilih terlebih dahulu</option>').prop('disabled', true);
            }
        });

        $('#rw').change(function() {
            var rw_id = $(this).val();
            if(rw_id) {
                $.post('ajax_dropdown.php', {action: 'get_rt', rw_id: rw_id}, function(data) {
                    $('#rt').html(data).prop('disabled', false);
                }).fail(function() {
                    alert('Gagal memuat data RT');
                });
            } else {
                $('#rt').html('<option value="">Pilih terlebih dahulu</option>').prop('disabled', true);
            }
        });

        // Set minimum date for birth date (18 years ago)
        const today = new Date();
        const minDate = new Date(today.getFullYear() - 18, today.getMonth(), today.getDate());
        $('input[type="date"]').attr('max', minDate.toISOString().split('T')[0]);

        // If there's RT ID in session, try to load its hierarchy
        <?php if (isset($_SESSION['rt_id'])): ?>
            // This would need additional AJAX calls to load the full hierarchy
            // For now we just show the selected RT
            $('#rt').prop('disabled', false);
        <?php endif; ?>
    });
    </script>
</body>
</html>