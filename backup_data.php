<?php
include 'auth.php';

// Cek apakah sudah login dan apakah jabatannya 'admin'
if (!isset($_SESSION['user_id']) || $_SESSION['jabatan'] !== 'admin') {
    header("Location: login.php?pesan=belum_login");
    exit();
}

// Logika membaca file backup asli di folder
$folder_backup = "backups/";
if (!is_dir($folder_backup)) { mkdir($folder_backup, 0777, true); }

$files = glob($folder_backup . "*.sql");
// Urutkan berdasarkan waktu file terbaru (Descending)
array_multisort(array_map('filemtime', $files), SORT_DESC, $files);

// Data untuk Status Terakhir
$last_made = "Belum ada";
$last_size = "0 MB";

if (!empty($files)) {
    $last_made = date("d-m-Y, H:i", filemtime($files[0])) . " WIB";
    $last_size = round(filesize($files[0]) / 1024 / 1024, 2) . " MB";
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Back-Up Data</title>
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
                    <i data-lucide="log-out" class="w-6 h-6"></i>
                </a>
                <button class="hover:opacity-80 transition-opacity active:scale-90">
                    <i data-lucide="user-circle" class="w-8 h-8"></i>
                </button>
            </div>
        </div>
    </header>

    <main class="bg-white rounded-t-[40px] mt-[10px] min-h-[calc(100vh-120px)] px-4 pt-10 pb-10 shadow-2xl">
        <div class="max-w-2xl mx-auto">
            <h2 class="text-center text-utama text-2xl font-bold mb-8">Back-Up Data</h2>

            <div class="bg-[#E5E5E5] rounded-[32px] p-6 mb-8 shadow-inner">
                <h3 class="text-utama font-bold text-xl mb-4 border-b border-gray-400 pb-2">Status Back Up</h3>

                <div class="space-y-2 mb-6">
                    <div class="flex justify-between items-center">
                        <span class="font-bold text-gray-700">Terakhir Dibuat :</span>
                        <span class="<?= empty($files) ? 'text-gray-400' : 'text-emerald-500' ?> font-bold"><?= $last_made ?></span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="font-bold text-gray-700">Ukuran File :</span>
                        <span class="text-gray-400 font-bold"><?= $last_size ?></span>
                    </div>
                </div>

                <div class="flex justify-center">
                    <a href="proses_backup.php" class="bg-[#CC0000] text-white px-8 py-3 rounded-2xl flex items-center gap-2 font-bold hover:brightness-110 active:scale-95 transition-all shadow-md">
                        <i data-lucide="download" class="w-5 h-5"></i>
                        <span>Buat Back Up Baru</span>
                    </a>
                </div>
            </div>

            <div class="bg-[#E5E5E5] rounded-[32px] p-4 space-y-3 shadow-inner">
                <h3 class="text-utama font-bold text-lg px-2 mb-2">Riwayat Back Up</h3>

                <?php if (!empty($files)): ?>
                    <?php foreach ($files as $file): 
                        $nama_file = basename($file);
                        $ukuran = round(filesize($file) / 1024 / 1024, 2) . " MB";
                        $waktu = date("d M Y, H:i", filemtime($file));
                    ?>
                        <div class="bg-white rounded-2xl p-4 shadow-sm border border-gray-100 flex justify-between items-center transition-transform active:scale-[0.98] cursor-pointer hover:bg-gray-50">
                            <div>
                                <p class="font-bold text-gray-800 text-md leading-tight"><?= $nama_file ?></p>
                                <p class="text-gray-400 text-sm font-medium">
                                    <?= $waktu ?> WIB | <?= $ukuran ?>
                                </p>
                            </div>
                            <a href="<?= $file ?>" download class="text-utama hover:scale-110 transition-transform">
                                <i data-lucide="file-down" class="w-5 h-5"></i>
                            </a>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="text-center py-6 text-gray-400 italic">
                        Belum ada riwayat backup database.
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </main>

    <script>
        lucide.createIcons();
    </script>
</body>

</html>