<?php
include 'auth.php';

// 1. KEAMANAN: Cek apakah sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php?pesan=belum_login");
    exit();
}

$title = "Detail Laporan";
$subtitle = "Hasil Inspeksi Quality Control";

// Ambil parameter dari URL
$id = mysqli_real_escape_string($conn, $_GET['id']);
$type = mysqli_real_escape_string($conn, $_GET['type']);
$role = $_SESSION['jabatan'];

// ============================================================
// START: PBI-039 (LOGIKA UPDATE STATUS & LOG OLEH KEPALA QC)
// ============================================================
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['proses_laporan']) && $role === 'kepala') {
    $status_baru = mysqli_real_escape_string($conn, $_POST['status']);
    $catatan_kepala = mysqli_real_escape_string($conn, $_POST['catatan_kepala']);

    // Update database
    $sql_update = "UPDATE laporancacat SET status = '$status_baru', catatan_kepala = '$catatan_kepala' WHERE id = '$id'";
    
    if (mysqli_query($conn, $sql_update)) {
        // Ambil info batch untuk detail log
        $info_query = mysqli_query($conn, "SELECT batch_number FROM laporancacat WHERE id = '$id'");
        $info = mysqli_fetch_assoc($info_query);
        $batch = $info['batch_number'];

        // Catat ke Log Aktivitas (IKKE - PBI-039)
        $details = "Kepala QC telah mengubah status laporan Batch: $batch menjadi " . strtoupper($status_baru);
        add_log($conn, "Keputusan QC", $details);

        header("Location: dashboard_kepala_qc.php?status=update_sukses");
        exit();
    }
}
// ============================================================
// END: PBI-039
// ============================================================

// 2. QUERY: Ambil Data untuk ditampilkan di UI
if ($type === 'cacat') {
    $query = "SELECT l.*, u.nama_lengkap as staff FROM laporancacat l 
              JOIN users u ON l.id_user = u.id WHERE l.id = '$id'";
} else {
    $query = "SELECT l.*, u.nama_lengkap as staff FROM laporannoncacat l 
              JOIN users u ON l.id_user = u.id WHERE l.id = '$id'";
}

$result = mysqli_query($conn, $query);
$data = mysqli_fetch_assoc($result);

if (!$data) {
    die("Data tidak ditemukan");
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail #<?= $data['id'] ?></title>
    <?php include 'ui_config.php'; ?>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-utama font-sans antialiased">
    <?php include 'header.php'; ?>

    <main class="bg-white rounded-t-[40px] mt-4 min-h-screen px-5 pt-8 pb-24 shadow-2xl relative">

        <div class="flex items-center justify-between mb-8">
            <div class="flex items-center gap-3">
                <?php
                $back_link = 'dashboard_staff_qc.php'; 
                if ($role === 'kepala') { $back_link = 'dashboard_kepala_qc.php'; } 
                elseif ($role === 'manajer' || $role === 'supervisor') { $back_link = 'dashboard_manajer_supervisor.php'; }
                ?>

                <a href="<?= $back_link ?>" class="bg-gray-100 text-utama w-10 h-10 rounded-xl flex items-center justify-center active:scale-90 transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                        <path d="m15 18-6-6 6-6" />
                    </svg>
                </a>
                <h2 class="text-xl font-bold text-black">Detail #<?= $data['id'] ?></h2>
            </div>

            <?php if ($type === 'cacat'): ?>
                <span class="px-3 py-1.5 rounded-lg text-[10px] font-black uppercase tracking-widest
                <?= $data['status'] == 'diterima' ? 'bg-green-100 text-green-600' : ($data['status'] == 'ditolak' ? 'bg-red-100 text-red-600' : 'bg-orange-100 text-orange-600') ?>">
                    <?= $data['status'] ?>
                </span>
            <?php endif; ?>
        </div>

        <div class="space-y-6">
            <div class="grid grid-cols-2 gap-4 bg-gray-50 p-5 rounded-3xl">
                <div class="border-b border-gray-200 pb-3">
                    <p class="text-[10px] text-gray-400 font-bold uppercase mb-1">Batch Number</p>
                    <p class="text-sm font-bold text-black"><?= $data['batch_number'] ?></p>
                </div>
                <div class="border-b border-gray-200 pb-3">
                    <p class="text-[10px] text-gray-400 font-bold uppercase mb-1">Tanggal</p>
                    <p class="text-sm font-bold text-black"><?= date('d/m/y', strtotime($data['tanggal'])) ?></p>
                </div>
                <div>
                    <p class="text-[10px] text-gray-400 font-bold uppercase mb-1">Jenis Udang</p>
                    <p class="text-sm font-bold text-black"><?= $data['jenis_udang'] ?></p>
                </div>
                <div>
                    <p class="text-[10px] text-gray-400 font-bold uppercase mb-1">Kuantitas</p>
                    <p class="text-sm font-bold text-black"><?= number_format($data['kuantitas']) ?> ekor</p>
                </div>
            </div>

            <?php if ($type === 'cacat'): ?>
                <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-2xl">
                    <p class="text-[10px] text-red-400 font-bold uppercase">Tingkat Keparahan</p>
                    <p class="text-md font-bold text-red-800"><?= $data['keparahan'] ?></p>
                </div>

                <div class="pt-2">
                    <h3 class="text-[10px] font-bold text-gray-400 uppercase mb-2">Deskripsi Temuan</h3>
                    <div class="bg-gray-50 p-4 rounded-2xl border border-dashed border-gray-200">
                        <p class="text-sm text-gray-600 italic">"<?= $data['deskripsi'] ?: 'Tidak ada catatan.' ?>"</p>
                    </div>
                </div>

                <div class="mt-4 pt-6 border-t-2 border-gray-100">
                    <h3 class="text-sm font-bold text-black mb-4 flex items-center gap-2">Tinjauan Kepala QC</h3>

                    <?php if ($role === 'kepala'): ?>
                        <form action="" method="POST" class="space-y-4">
                            <input type="hidden" name="proses_laporan" value="1">
                            <div>
                                <label class="text-[10px] font-bold text-gray-400 uppercase ml-2">Keputusan Status</label>
                                <div class="grid grid-cols-2 gap-3 mt-1">
                                    <label class="cursor-pointer">
                                        <input type="radio" name="status" value="diterima" class="peer hidden" <?= $data['status'] == 'diterima' ? 'checked' : '' ?> required>
                                        <div class="text-center p-3 rounded-2xl border-2 border-gray-100 peer-checked:border-green-500 peer-checked:bg-green-50 text-gray-400 peer-checked:text-green-600 font-bold text-sm transition-all">Terima</div>
                                    </label>
                                    <label class="cursor-pointer">
                                        <input type="radio" name="status" value="ditolak" class="peer hidden" <?= $data['status'] == 'ditolak' ? 'checked' : '' ?> required>
                                        <div class="text-center p-3 rounded-2xl border-2 border-gray-100 peer-checked:border-red-500 peer-checked:bg-red-50 text-gray-400 peer-checked:text-red-600 font-bold text-sm transition-all">Tolak</div>
                                    </label>
                                </div>
                            </div>
                            <div>
                                <label class="text-[10px] font-bold text-gray-400 uppercase ml-2">Catatan/Instruksi</label>
                                <textarea name="catatan_kepala" rows="3" class="w-full mt-1 p-4 bg-gray-50 border border-gray-200 rounded-2xl text-sm focus:outline-none focus:border-utama transition-all" placeholder="Tulis instruksi..."><?= $data['catatan_kepala'] ?></textarea>
                            </div>
                            <button type="submit" class="w-full bg-utama text-white font-bold py-4 rounded-2xl shadow-lg active:scale-95 transition-all">Simpan Keputusan</button>
                        </form>
                    <?php else: ?>
                        <div class="bg-gray-50 p-4 rounded-2xl border border-gray-100">
                            <p class="text-[10px] text-gray-400 font-bold uppercase mb-1">Instruksi Kepala</p>
                            <p class="text-sm text-gray-700 font-medium"><?= $data['catatan_kepala'] ?: 'Belum ada catatan.' ?></p>
                        </div>
                    <?php endif; ?>
                </div>

            <?php else: ?>
                <div class="bg-blue-50 p-4 rounded-2xl text-center border border-blue-100">
                    <p class="text-sm font-bold text-blue-600">STATUS: Produk Aman / Normal</p>
                </div>
            <?php endif; ?>

            <div class="mt-8 pt-6 border-t border-gray-100 flex items-center gap-3">
                <div class="w-10 h-10 bg-utama text-white flex items-center justify-center rounded-full font-bold">
                    <?= substr($data['staff'], 0, 1) ?>
                </div>
                <div>
                    <p class="text-[10px] text-gray-400 font-bold uppercase leading-none mb-1">Dilaporkan Oleh</p>
                    <p class="text-sm font-bold text-black"><?= $data['staff'] ?></p>
                </div>
            </div>
        </div>
    </main>
</body>
</html>