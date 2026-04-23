<?php
include 'auth.php';

// Cek apakah sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php?pesan=belum_login");
    exit();
}

// Cek apakah jabatannya BUKAN manajer DAN BUKAN supervisor
if ($_SESSION['jabatan'] !== 'manajer' && $_SESSION['jabatan'] !== 'supervisor') {
    header("Location: login.php?pesan=hak_akses_ditolak");
    exit();
}

// --- LOGIKA DINAMIS PBI-028 (DIBUAT OLEH IKKE) ---

// 1. Hitung Total Semua Laporan
$res_total_cacat = mysqli_query($conn, "SELECT COUNT(*) as total FROM laporancacat");
$total_cacat = mysqli_fetch_assoc($res_total_cacat)['total'];

$res_total_non = mysqli_query($conn, "SELECT COUNT(*) as total FROM laporannoncacat");
$total_non = mysqli_fetch_assoc($res_total_non)['total'];

$total_semua = $total_cacat + $total_non;

// 2. Hitung Tingkat Cacat (Defect Rate)
$defect_rate = ($total_semua > 0) ? ($total_cacat / $total_semua) * 100 : 0;

// 3. Hitung Rata-rata Keparahan (Konversi Teks: Ringan=1, Sedang=2, Berat=3)
$query_avg = "SELECT AVG(
                CASE 
                    WHEN keparahan = 'ringan' THEN 1 
                    WHEN keparahan = 'sedang' THEN 2 
                    WHEN keparahan = 'berat' THEN 3 
                    ELSE 0 
                END
              ) as rata_rata FROM laporancacat WHERE keparahan IS NOT NULL AND keparahan != ''";
$res_avg_severity = mysqli_query($conn, $query_avg);
$avg_severity = mysqli_fetch_assoc($res_avg_severity)['rata_rata'];
$avg_display = ($avg_severity > 0) ? number_format($avg_severity, 1) : "0";

// Ambil data untuk tabel
$daftar_cacat = mysqli_query($conn, "SELECT * FROM laporancacat ORDER BY id DESC");
$daftar_non_cacat = mysqli_query($conn, "SELECT * FROM laporannoncacat ORDER BY id DESC");

$title = "Supervisor/Manajer";
$subtitle = "QC Overview - Monitoring Mode";
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supervisor Dashboard</title>
    <?php include 'ui_config.php'; ?>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="font-sans bg-utama">
    <?php include 'header.php'; ?>

    <main class="bg-white rounded-t-[40px] mt-[20px] min-h-[calc(100vh-120px)] px-4 pt-10 pb-10">

        <div class="grid grid-cols-3 gap-3 mb-8">
            <div class="bg-white rounded-2xl p-3 flex flex-col items-center shadow-[0_4px_15px_rgba(0,0,0,0.1)] border border-gray-50">
                <div class="flex items-center gap-1 mb-2">
                    <div class="bg-utama rounded-full p-1.5">
                        <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM2 11a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4z" />
                        </svg>
                    </div>
                    <span class="text-[9px] leading-tight font-bold text-gray-700">Total Semua<br>Laporan</span>
                </div>
                <span class="text-2xl font-bold text-gray-700"><?= $total_semua; ?></span>
            </div>

            <div class="bg-white rounded-2xl p-3 flex flex-col items-center shadow-[0_4px_15px_rgba(0,0,0,0.1)] border border-gray-50">
                <div class="flex items-center gap-1 mb-2">
                    <div class="bg-utama rounded-full p-1.5">
                        <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <span class="text-[9px] leading-tight font-bold text-gray-700">Tingkat Cacat<br>(Defect Rate)</span>
                </div>
                <span class="text-2xl font-bold text-gray-700"><?= round($defect_rate); ?>%</span>
            </div>

            <div class="bg-white rounded-2xl p-3 flex flex-col items-center shadow-[0_4px_15px_rgba(0,0,0,0.1)] border border-gray-50">
                <div class="flex items-center gap-1 mb-2">
                    <div class="bg-utama rounded-full p-1.5">
                        <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                        </svg>
                    </div>
                    <span class="text-[9px] leading-tight font-bold text-gray-700">Rata-rata<br>Keparahan</span>
                </div>
                <span class="text-2xl font-bold text-gray-700"><?= $avg_display; ?></span>
            </div>
        </div>

        <div class="bg-white rounded-[30px] p-6 shadow-[0_4px_25px_rgba(0,0,0,0.08)] mb-8 border border-gray-50">
            <div class="flex items-center justify-between mb-6">
                <label class="font-bold text-black">Filter Status:</label>
                <select id="filter-status-select" onchange="updateView(this.value)" class="border border-gray-300 rounded-lg px-3 py-2 text-sm w-2/3 focus:outline-none bg-gray-50">
                    <option value="semua">Semua Laporan</option>
                    <option value="cacat">Cacat</option>
                    <option value="non-cacat">Non-Cacat</option>
                </select>
            </div>

            <div class="space-y-3">
                <a href="export_csv.php?type=cacat" id="btn-csv-cacat" class="w-full bg-utama text-white font-bold py-3 px-4 rounded-xl flex items-center gap-3 shadow-md active:scale-95 transition-transform cursor-pointer text-sm">
                    <div class="bg-white text-utama p-1 rounded">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" />
                        </svg>
                    </div>
                    Generate Cacat CSV
                </a>
                <a href="export_csv.php?type=non-cacat" id="btn-csv-non-cacat" class="w-full bg-utama text-white font-bold py-3 px-4 rounded-xl flex items-center gap-3 shadow-md active:scale-95 transition-transform cursor-pointer text-sm">
                    <div class="bg-white text-utama p-1 rounded">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" />
                        </svg>
                    </div>
                    Generate Non-Cacat CSV
                </a>
            </div>
        </div>

        <div class="bg-utama rounded-3xl overflow-hidden shadow-xl">
            <div class="flex px-6 pt-4 gap-6 text-white text-sm font-bold">
                <button onclick="filterLaporan('cacat')" id="tab-cacat" class="tab-btn pb-2 border-b-4 border-white">
                    Laporan Cacat
                </button>
                <button onclick="filterLaporan('non-cacat')" id="tab-non-cacat" class="tab-btn pb-2 opacity-70 border-b-4 border-transparent">
                    Laporan Non-Cacat
                </button>
            </div>

            <div class="bg-white m-2 rounded-2xl overflow-hidden shadow-sm border border-gray-100">
                <table class="w-full text-left text-xs table-fixed">
                    <thead class="bg-gray-50 border-b">
                        <tr>
                            <th class="py-3 px-4 w-12 text-center">ID</th>
                            <th class="py-3 px-2 w-24">Batch</th>
                            <th class="py-3 px-2">Deskripsi</th>
                            <th class="py-3 px-4 w-15 text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody id="table-body">
                        <?php while ($row = mysqli_fetch_assoc($daftar_cacat)): ?>
                            <tr class="row-laporan border-b last:border-0 hover:bg-gray-50 cursor-pointer transition-colors"
                                data-type="cacat"
                                onclick="window.location.href='detail_laporan.php?id=<?= $row['id']; ?>&type=cacat'">
                                <td class="py-4 px-4 font-bold text-utama text-center"><?= $row['id']; ?></td>
                                <td class="py-4 px-2 font-medium truncate"><?= $row['batch_number']; ?></td>
                                <td class="py-4 px-2 text-gray-500 italic truncate"><?= $row['deskripsi'] ?: '-'; ?></td>
                                <td class="py-4 px-3 text-center">
                                    <?php
                                    $status_class = "text-orange-600";
                                    if ($row['status'] == 'diterima') $status_class = "text-green-600";
                                    if ($row['status'] == 'ditolak') $status_class = "text-red-600";
                                    ?>
                                    <span class="inline-block px-2 py-1 rounded-md text-[10px] font-semibold tracking-wide <?= $status_class ?>">
                                        <?= strtoupper($row['status']); ?>
                                    </span>
                                </td>
                            </tr>
                        <?php endwhile; ?>

                        <?php while ($row = mysqli_fetch_assoc($daftar_non_cacat)): ?>
                            <tr class="row-laporan border-b last:border-0 hidden hover:bg-gray-50 cursor-pointer transition-colors"
                                data-type="non-cacat"
                                onclick="window.location.href='detail_laporan.php?id=<?= $row['id']; ?>&type=non-cacat'">
                                <td class="py-4 px-4 font-bold text-utama text-center"><?= $row['id']; ?></td>
                                <td class="py-4 px-2 font-medium truncate"><?= $row['batch_number']; ?></td>
                                <td class="py-4 px-2 text-gray-500 italic truncate"><?= $row['deskripsi'] ?: '-'; ?></td>
                                <td class="py-4 px-4 text-center">
                                    <span class="px-3 py-1 rounded-md text-[9px] font-black uppercase text-gray-400">
                                        PASSED
                                    </span>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>

                <div id="empty-state" class="hidden py-10 text-center text-gray-400">
                    Tidak ada data untuk kategori ini.
                </div>
                <div class="h-20"></div>
            </div>
        </div>
    </main>

    <script>
        function updateView(selectedValue) {
            const btnCacat = document.getElementById('btn-csv-cacat');
            const btnNonCacat = document.getElementById('btn-csv-non-cacat');

            if (selectedValue === 'cacat') {
                btnCacat.classList.remove('hidden');
                btnNonCacat.classList.add('hidden');
                filterLaporan('cacat');
            } else if (selectedValue === 'non-cacat') {
                btnCacat.classList.add('hidden');
                btnNonCacat.classList.remove('hidden');
                filterLaporan('non-cacat');
            } else {
                btnCacat.classList.remove('hidden');
                btnNonCacat.classList.remove('hidden');
                filterLaporan('cacat');
            }
        }

        function filterLaporan(type) {
            const rows = document.querySelectorAll('.row-laporan');
            const tabs = document.querySelectorAll('.tab-btn');
            let hasData = false;

            tabs.forEach(tab => {
                if (tab.id === `tab-${type}`) {
                    tab.classList.remove('opacity-70', 'border-transparent');
                    tab.classList.add('border-white');
                    tab.style.opacity = "1";
                } else {
                    tab.classList.add('opacity-70', 'border-transparent');
                    tab.classList.remove('border-white');
                }
            });

            rows.forEach(row => {
                if (row.getAttribute('data-type') === type) {
                    row.classList.remove('hidden');
                    hasData = true;
                } else {
                    row.classList.add('hidden');
                }
            });

            const emptyState = document.getElementById('empty-state');
            if (!hasData) {
                emptyState.classList.remove('hidden');
            } else {
                emptyState.classList.add('hidden');
            }
        }
    </script>
</body>
</html>