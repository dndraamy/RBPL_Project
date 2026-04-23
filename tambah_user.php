<?php
include 'auth.php';

// Cek apakah sudah login dan apakah jabatannya 'admin'
if (!isset($_SESSION['user_id']) || $_SESSION['jabatan'] !== 'admin') {
    header("Location: login.php?pesan=belum_login");
    exit();
}

$title = "Tambah User";
$subtitle = "Manajemen Akses Sistem";
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah User</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <?php include 'ui_config.php'; ?>
</head>

<body class="font-sans bg-utama text-gray-800">

    <?php include 'header.php'; ?>

    <main class="bg-white rounded-t-[40px] mt-[20px] min-h-[calc(100vh-80px)] px-6 pt-10 pb-16">
        <div class="max-w-2xl mx-auto">

            <?php if (isset($_GET['status']) && $_GET['status'] == 'error_nip'): ?>
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-r-xl shadow-sm" role="alert">
                    <p class="font-bold">Gagal Menyimpan</p>
                    <p>NIP yang Anda masukkan sudah terdaftar. Silakan gunakan NIP lain.</p>
                </div>
            <?php endif; ?>

            <form action="proses_user.php?aksi=tambah" method="POST" class="space-y-5">

                <input type="text" name="nama_lengkap" placeholder="Nama Lengkap" required
                    class="w-full p-4 border border-gray-300 rounded-xl shadow-[0_2px_6px_rgba(0,0,0,0.1)] focus:outline-none focus:ring-2 focus:ring-utama transition-all">

                <input type="text" name="nip" placeholder="NIP" required
                    class="w-full p-4 border border-gray-300 rounded-xl shadow-[0_2px_6px_rgba(0,0,0,0.1)] focus:outline-none focus:ring-2 focus:ring-utama transition-all">
                
                <input type="email" name="email" placeholder="Alamat Email" required
                    class="w-full p-4 border border-gray-300 rounded-xl shadow-[0_2px_6px_rgba(0,0,0,0.1)] focus:outline-none focus:ring-2 focus:ring-utama transition-all">

                <input type="password" name="password" placeholder="Kata Sandi Awal" required
                    class="w-full p-4 border border-gray-300 rounded-xl shadow-[0_2px_6px_rgba(0,0,0,0.1)] focus:outline-none focus:ring-2 focus:ring-utama transition-all">

                <div class="relative">
                    <select name="jabatan" required class="w-full p-4 border border-gray-300 rounded-xl shadow-[0_2px_6px_rgba(0,0,0,0.1)] appearance-none text-gray-500 focus:outline-none focus:ring-2 focus:ring-utama bg-white">
                        <option disabled selected>Jabatan</option>
                        <option value="admin">Admin</option>
                        <option value="manajer">Manajer</option>
                        <option value="supervisor">Supervisor</option>
                        <option value="staff qc">Staff QC</option>
                        <option value="kepala">Kepala QC</option>
                    </select>
                    <div class="absolute inset-y-0 right-4 flex items-center pointer-events-none text-utama">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                        </svg>
                    </div>
                </div>

                <input type="tel" name="no_telp" placeholder="No Telp"
                    class="w-full p-4 border border-gray-300 rounded-xl shadow-[0_2px_6px_rgba(0,0,0,0.1)] focus:outline-none focus:ring-2 focus:ring-utama transition-all">

                <textarea name="alamat" placeholder="Alamat Lengkap" rows="3"
                    class="w-full p-4 border border-gray-300 rounded-2xl shadow-[0_2px_6px_rgba(0,0,0,0.1)] focus:outline-none focus:ring-2 focus:ring-utama resize-none transition-all"></textarea>

                <div class="pt-10 flex items-center gap-4">
                    <a href="kelola_user.php" class="bg-[#A30000] text-white w-14 h-14 min-w-[56px] rounded-full flex items-center justify-center shadow-lg hover:brightness-110 active:scale-90 transition-all">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="m15 18-6-6 6-6"></path>
                        </svg>
                    </a>

                    <button type="submit" class="flex-1 bg-sukses text-white py-4 rounded-full text-xl font-bold shadow-lg hover:brightness-110 active:scale-[0.98] transition-all tracking-wide">
                        Simpan
                    </button>
                </div>

            </form>
        </div>
    </main>

    <script>
        lucide.createIcons();
    </script>
</body>

</html>