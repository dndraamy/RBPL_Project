<?php
include 'auth.php';

// Cek apakah sudah login dan apakah jabatannya 'admin'
if (!isset($_SESSION['user_id']) || $_SESSION['jabatan'] !== 'admin') {
    header("Location: login.php?pesan=belum_login");
    exit();
}

$admin_name = isset($_SESSION['nama']) ? $_SESSION['nama'] : "Admin";

// --- LOGIKA AGREGASI DATA ---
$res_user = mysqli_query($conn, "SELECT COUNT(*) as total FROM users");
$total_user = mysqli_fetch_assoc($res_user)['total'];

$res_cacat = mysqli_query($conn, "SELECT COUNT(*) as total FROM laporancacat");
$res_non = mysqli_query($conn, "SELECT COUNT(*) as total FROM laporannoncacat");
$total_laporan = mysqli_fetch_assoc($res_cacat)['total'] + mysqli_fetch_assoc($res_non)['total'];

// Untuk tampilan log backup terakhir
$query_log = "SELECT timestamp FROM activity_logs 
              WHERE (details LIKE '%Backup Data%' OR details LIKE '%pencadangan%') 
              ORDER BY id DESC LIMIT 1";
$res_log = mysqli_query($conn, $query_log);
$row_log = mysqli_fetch_assoc($res_log);

// Tentukan tanggal hari ini
$today_date = date('d-m-Y');

if ($row_log) {
    $ts_db = strtotime($row_log['timestamp']); 
    $last_backup_display = date('d-m-Y', $ts_db);
    $last_backup_time = date('H.i', $ts_db) . " WIB";
    
    $today = date('d-m-Y');
    $yesterday = date('d-m-Y', strtotime('yesterday'));
    
    $is_backed_up = (trim($last_backup_display) == $today || trim($last_backup_display) == $yesterday);
} else {
    $last_backup_display = "Belum Ada";
    $last_backup_time = "-";
    $is_backed_up = false;
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <?php include 'ui_config.php'; ?>
</head>

<body class="bg-white font-sans flex min-h-screen overflow-x-hidden">

    <aside class="fixed inset-y-0 left-0 w-20 md:w-64 bg-utama text-white flex flex-col z-50 shadow-2xl">
        <div class="p-4 md:p-6 flex justify-center items-center border-b border-white/10">
            <img src="assets/logo-misaja-mitra.png" alt="Logo" class="w-12 h-12 md:w-16 md:h-16 object-contain">
        </div>

        <div class="p-4 md:p-6 mt-4">
            <nav class="space-y-8">
                <a href="dashboard_admin.php" class="flex flex-col md:flex-row items-center gap-1 md:gap-3 font-bold group">
                    <i data-lucide="home" class="w-6 h-6"></i>
                    <span class="text-[10px] md:text-base">Dashboard</span>
                </a>
                <a href="kelola_user.php" class="flex flex-col md:flex-row items-center gap-1 md:gap-3 opacity-70 hover:opacity-100 group">
                    <i data-lucide="user-plus" class="w-6 h-6"></i>
                    <span class="text-[10px] md:text-base text-center md:text-left">Kelola User</span>
                </a>
                <a href="backup_data.php" class="flex flex-col md:flex-row items-center gap-1 md:gap-3 opacity-70 hover:opacity-100 group">
                    <i data-lucide="cloud-download" class="w-6 h-6"></i>
                    <span class="text-[10px] md:text-base text-center md:text-left">BackUp</span>
                </a>
                <a href="log_aktivitas.php" class="flex flex-col md:flex-row items-center gap-1 md:gap-3 opacity-70 hover:opacity-100 group">
                    <i data-lucide="clock" class="w-6 h-6"></i>
                    <span class="text-[10px] md:text-base text-center md:text-left">Log</span>
                </a>
            </nav>
        </div>

        <div class="mt-auto p-4 md:p-6">
            <a href="login.php" class="flex flex-col md:flex-row items-center gap-1 md:gap-3 font-bold text-red-300 hover:text-red-100 transition-colors">
                <i data-lucide="log-out" class="w-6 h-6"></i>
                <span class="text-[10px] md:text-base">Logout</span>
            </a>
        </div>
    </aside>

    <div class="flex-1 flex flex-col ml-20 md:ml-64 w-full">

        <header class="flex justify-between items-center px-6 py-4 bg-white border-b sticky top-0 z-40">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-utama">Dashboard Admin</h1>
                <p class="text-xs md:text-sm text-gray-500 font-medium italic">
                    Selamat Datang, <?php echo htmlspecialchars($admin_name); ?>
                </p>
            </div>
        </header>

        <main class="p-4 md:p-6 bg-gray-50 min-h-screen">
            <div class="max-w-md mx-auto space-y-6 mt-4">

                <?php if (!$is_backed_up): ?>
                    <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded-xl shadow-sm flex items-center gap-3 animate-pulse">
                        <i data-lucide="alert-circle" class="w-6 h-6"></i>
                        <div class="text-sm font-bold">Perhatian: Backup hari ini belum dilakukan!</div>
                    </div>
                <?php else: ?>
                <?php endif; ?>

               <div class="bg-white rounded-3xl p-6 md:p-8 text-center shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 transform transition hover:scale-105">
                    <p class="text-gray-400 font-bold text-xs mb-2 uppercase tracking-widest">Total User</p>
                    <h2 class="text-4xl md:text-5xl font-bold text-black tracking-tighter"><?= $total_user; ?></h2>
                </div>

                <div class="bg-white rounded-3xl p-6 md:p-8 text-center shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 transform transition hover:scale-105">
                    <p class="text-gray-400 font-bold text-xs mb-2 uppercase tracking-widest">Total Laporan QC</p>
                    <h2 class="text-4xl md:text-5xl font-bold text-black tracking-tighter"><?= $total_laporan; ?></h2>
                </div>

                <div class="bg-white rounded-3xl p-6 md:p-8 text-center shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 transform transition hover:scale-105">
                    <p class="text-gray-400 font-bold text-xs mb-2 uppercase tracking-widest">Status Database</p>
                    <h2 class="text-xl md:text-3xl font-black text-emerald-500 uppercase">Online</h2>
                </div>

                <div class="bg-white rounded-3xl p-6 text-center shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 transform transition hover:scale-105">
                    <p class="text-gray-400 font-bold text-xs mb-2 uppercase tracking-widest">BackUp Data Terakhir</p>
                    <h2 class="text-xl md:text-2xl font-bold text-black"><?= $last_backup_display; ?></h2>
                    <p class="text-[10px] text-gray-400 uppercase font-medium">Pukul <?= $last_backup_time; ?></p>
                </div>

            </div>
        </main>
    </div>

    <script>
        lucide.createIcons();
    </script>
</body>

</html>