<?php
include 'auth.php';

$title = "Detail Laporan";
$subtitle = "Hasil Inspeksi Quality Control";

$id = mysqli_real_escape_string($conn, $_GET['id']);
$type = mysqli_real_escape_string($conn, $_GET['type']);
$role = $_SESSION['jabatan'];

// --- LOGIKA UPDATE STATUS & CATATAN (Hanya untuk Kepala QC) ---
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['proses_laporan']) && $role === 'kepala') {
    $status_baru = mysqli_real_escape_string($conn, $_POST['status']);
    $catatan_kepala = mysqli_real_escape_string($conn, $_POST['catatan_kepala']);

    $sql_update = "UPDATE laporancacat SET status = '$status_baru', catatan_kepala = '$catatan_kepala' WHERE id = '$id'";
    if (mysqli_query($conn, $sql_update)) {
        header("Location: dashboard_kepala_qc.php?status=update_sukses");
        exit();
    }
}

// Ambil Data
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
</head>

<body class="bg-utama font-sans antialiased">
    <?php include 'header.php'; ?>

    <main class="bg-white rounded-t-[40px] mt-4 min-h-screen px-5 pt-8 pb-24 shadow-2xl relative">

        <div class="flex items-center justify-between mb-8">
            <div class="flex items-center gap-3">
                <a href="<?= $role === 'kepala' ? 'dashboard_kepala_qc.php' : 'dashboard_staff_qc.php' ?>" class="bg-gray-100 text-utama w-10 h-10 rounded-xl flex items-center justify-center active:scale-90 transition-all">
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
                <div class="border-b border-gray-200 sm:border-0 pb-3 sm:pb-0">
                    <p class="text-[10px] text-gray-400 font-bold uppercase mb-1">Jenis Udang</p>
                    <p class="text-sm font-bold text-black"><?= $data['jenis_udang'] ?></p>
                </div>
                <div>
                    <p class="text-[10px] text-gray-400 font-bold uppercase mb-1">Kuantitas</p>
                    <p class="text-sm font-bold text-black"><?= number_format($data['kuantitas']) ?> ekor</p>
                </div>
            </div>

            <?php if ($type === 'cacat'): ?>
                <div class="flex flex-col gap-3">
                    <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-2xl">
                        <p class="text-[10px] text-red-400 font-bold uppercase">Tingkat Keparahan</p>
                        <p class="text-md font-bold text-red-800"><?= $data['tingkat_keparahan'] ?? $data['keparahan'] ?></p>
                    </div>
                </div>

                <div class="pt-2">
                    <h3 class="text-[10px] font-bold text-gray-400 uppercase mb-2">Deskripsi Temuan</h3>
                    <div class="bg-gray-50 p-4 rounded-2xl border border-dashed border-gray-200">
                        <p class="text-sm text-gray-600 italic">"<?= $data['deskripsi'] ?: 'Tidak ada catatan.' ?>"</p>
                    </div>
                </div>

                <div class="mt-4 pt-6 border-t-2 border-gray-100">
                    <h3 class="text-sm font-bold text-black mb-4 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-utama">
                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" />
                        </svg>
                        Tinjauan Kepala QC
                    </h3>

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
                                <label class="text-[10px] font-bold text-gray-400 uppercase ml-2">Catatan/Instruksi Kepala</label>
                                <textarea name="catatan_kepala" rows="3" class="w-full mt-1 p-4 bg-gray-50 border border-gray-200 rounded-2xl text-sm focus:outline-none focus:border-utama transition-all" placeholder="Tulis instruksi..."><?= $data['catatan_kepala'] ?></textarea>
                            </div>
                            <button type="submit" class="w-full bg-utama text-white font-bold py-4 rounded-2xl shadow-lg active:scale-95 transition-all">Simpan Keputusan</button>
                        </form>
                    <?php else: ?>
                        <div class="space-y-4">
                            <div class="bg-gray-50 p-4 rounded-2xl border border-gray-100">
                                <p class="text-[10px] text-gray-400 font-bold uppercase mb-1">Status Akhir</p>
                                <p class="text-sm font-bold <?= $data['status'] == 'diterima' ? 'text-green-600' : 'text-red-600' ?>">
                                    <?= strtoupper($data['status']) ?>
                                </p>
                            </div>
                            <div class="bg-gray-50 p-4 rounded-2xl border border-gray-100">
                                <p class="text-[10px] text-gray-400 font-bold uppercase mb-1">Instruksi Kepala</p>
                                <p class="text-sm text-gray-700 font-medium"><?= $data['catatan_kepala'] ?: 'Belum ada catatan dari kepala.' ?></p>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>

            <?php else: ?>
                <div class="bg-blue-50 p-4 rounded-2xl text-center border border-blue-100">
                    <p class="text-sm font-bold text-blue-600">STATUS: Produk Aman / Normal</p>
                </div>
                <div class="pt-2">
                    <h3 class="text-[10px] font-bold text-gray-400 uppercase mb-2">Keterangan Tambahan</h3>
                    <div class="bg-gray-50 p-4 rounded-2xl border border-dashed border-gray-200">
                        <p class="text-sm text-gray-600 italic">"<?= $data['deskripsi'] ?: 'Laporan pemeriksaan rutin, kualitas produk sesuai standar.' ?>"</p>
                    </div>
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