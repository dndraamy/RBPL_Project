<?php
include 'auth.php';
require_once 'auth.php';

if (!isset($_SESSION['user_id']) || $_SESSION['jabatan'] !== 'admin') {
    header("Location: login.php?pesan=belum_login");
    exit();
}

$query_users = mysqli_query($conn, "SELECT * FROM users ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola User</title>
    <script src="https://unpkg.com/lucide@latest"></script>
    <script src="https://cdn.tailwindcss.com"></script>
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
            <h2 class="text-center text-utama text-2xl font-bold mb-4">Kelola User</h2>

            <?php if (isset($_GET['status'])): ?>
                <?php if ($_GET['status'] == 'sukses_tambah'): ?>
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-3 mb-6 rounded-r text-sm">Pengguna berhasil ditambahkan.</div>
                <?php elseif ($_GET['status'] == 'sukses_hapus'): ?>
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-3 mb-6 rounded-r text-sm">Pengguna berhasil dihapus.</div>
                <?php elseif ($_GET['status'] == 'error_hapus_diri_sendiri'): ?>
                    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-3 mb-6 rounded-r text-sm">Gagal! Anda tidak bisa menghapus akun Anda sendiri yang sedang aktif.</div>
                <?php endif; ?>
            <?php endif; ?>

            <div class="flex items-center gap-4 mb-8">
                <div class="relative flex-1">
                    <input type="text" placeholder="Cari Pengguna.."
                        class="w-full pl-4 pr-10 py-3 rounded-2xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-utama/20 transition-all shadow-sm">
                    <div class="absolute right-4 top-1/2 -translate-y-1/2 text-black transition-colors group-focus-within:text-utama">
                        <i data-lucide="search" class="w-6 h-6"></i>
                    </div>
                </div>
                <a href="tambah_user.php" class="bg-utama text-white px-6 py-3 rounded-2xl flex items-center gap-2 font-bold hover:opacity-90 active:scale-95 transition-all shadow-md">
                    <i data-lucide="user-plus" class="w-5 h-5"></i>
                    <span>Tambah</span>
                </a>
            </div>

            <div class="bg-[#E5E5E5] rounded-[32px] p-4 space-y-3">
                <h3 class="text-utama font-bold text-lg px-2 mb-4">Daftar Pengguna Aktif</h3>

                <?php if (mysqli_num_rows($query_users) > 0): ?>
                    <?php while ($u = mysqli_fetch_assoc($query_users)): ?>
                        <div class="bg-white rounded-2xl p-4 shadow-sm border border-gray-100 transition-transform active:scale-[0.98] flex justify-between items-center">
                            <div>
                                <p class="font-bold text-gray-800 text-lg leading-tight"><?= htmlspecialchars($u['nama_lengkap']) ?></p>
                                <p class="text-gray-500 text-sm">
                                    NIP: <?= htmlspecialchars($u['nip']) ?> | <?= htmlspecialchars($u['email']) ?> <br>
                                    <span class="text-gray-400 font-semibold"><?= strtoupper(htmlspecialchars($u['jabatan'])) ?></span>
                                </p>
                            </div>
                            
                            <a href="proses_user.php?aksi=hapus&id=<?= $u['id'] ?>" onclick="return confirm('Yakin ingin menghapus pengguna <?= htmlspecialchars($u['nama_lengkap']) ?>?')" class="text-red-500 bg-red-50 p-2 rounded-xl hover:bg-red-100 transition-colors">
                                <i data-lucide="trash-2" class="w-5 h-5"></i>
                            </a>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p class="text-center text-gray-500 py-4">Belum ada pengguna terdaftar.</p>
                <?php endif; ?>
            </div>
        </div>
    </main>

    <script>
        lucide.createIcons();
    </script>

</body>

</html>