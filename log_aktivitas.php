<?php
include 'auth.php';

// Cek apakah sudah login dan apakah jabatannya 'admin'
if (!isset($_SESSION['user_id']) || $_SESSION['jabatan'] !== 'admin') {
    header("Location: login.php?pesan=belum_login");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log Aktivitas</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <?php include 'ui_config.php'; ?>
</head>

<body class="font-sans bg-utama">
    <header class="px-6 pt-10 pb-4 text-white">
        <div class="flex justify-between items-center max-w-2xl mx-auto">
            <a href="dashboard_admin.php" class="flex items-center gap-2 hover:opacity-80 transition-all active:scale-95">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="19" y1="12" x2="5" y2="12"></line>
                    <polyline points="12 19 5 12 12 5"></polyline>
                </svg>
                <h1 class="text-2xl font-bold tracking-tight">Dashboard</h1>
            </a>

            <div class="flex items-center gap-4">
                <a href="login.php" class="hover:opacity-80 transition-opacity active:scale-90">
                    <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                        <polyline points="16 17 21 12 16 7"></polyline>
                        <line x1="21" x2="9" y1="12" y2="12"></line>
                    </svg>
                </a>

                <button class="hover:opacity-80 transition-opacity active:scale-90">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"></circle>
                        <circle cx="12" cy="10" r="3"></circle>
                        <path d="M7 20.662V19a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2v1.662"></path>
                    </svg>
                </button>
            </div>
        </div>
    </header>

    <main class="bg-white rounded-t-[40px] mt-[10px] min-h-[calc(100vh-120px)] px-4 pt-10 pb-10">
        <div class="max-w-2xl mx-auto">
            <h2 class="text-center text-utama text-2xl font-bold mb-8">Log Aktivitas</h2>

            <div class="mb-8 max-w-2xl mx-auto">
                <div class="relative group">
                    <input type="date" name="filter_tanggal" id="filter_tanggal"
                        value="2025-11-28"
                        class="w-full px-4 py-4 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-utama/20 shadow-[0_2px_6px_rgba(0,0,0,0.1)] text-gray-700 font-medium bg-white appearance-none cursor-pointer">

                    <div class="absolute right-4 top-1/2 -translate-y-1/2 text-utama pointer-events-none">
                        <i data-lucide="calendar" class="w-6 h-6"></i>
                    </div>
                </div>
            </div>

            <div class="bg-[#E5E5E5] rounded-[32px] p-4 space-y-3">
                <h3 class="text-utama font-bold text-lg px-2 mb-4 border-b border-gray-300 pb-2">Aktivitas Hari Ini</h3>

                <?php
                // Data dummy simulasi log
                $logs = [
                    ['user' => 'Anak Budi', 'aksi' => 'Menambahkan Laporan', 'tgl' => '28 nov 2025', 'jam' => '12 : 31'],
                    ['user' => 'Adik Budi', 'aksi' => 'Menambahkan Laporan', 'tgl' => '28 nov 2025', 'jam' => '11 : 31'],
                    ['user' => 'Bapak Budi', 'aksi' => 'Memperbarui Status', 'tgl' => '28 nov 2025', 'jam' => '14 : 31'],
                ];

                foreach ($logs as $l): ?>
                    <div class="bg-white rounded-2xl p-4 shadow-sm border border-gray-100 transition-transform active:scale-[0.99]">
                        <p class="font-bold text-gray-800 text-lg leading-tight">
                            <?= $l['user'] ?> <?= $l['aksi'] ?>
                        </p>
                        <p class="text-gray-400 text-sm mt-1 font-medium">
                            <?= $l['tgl'] ?>, <?= $l['jam'] ?>
                        </p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </main>

    <script>
        lucide.createIcons();
    </script>
</body>

</html>