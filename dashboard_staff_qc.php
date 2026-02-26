<?php
include 'auth.php';

// Cek apakah sudah login dan apakah jabatannya 'staff'
if (!isset($_SESSION['user_id']) || $_SESSION['jabatan'] !== 'staff') {
    header("Location: login.php?pesan=belum_login");
    exit();
}

// Ambil Data Seluruh Staff
$res_cacat = mysqli_query($conn, "SELECT COUNT(*) as total FROM laporancacat");
$count_cacat = mysqli_fetch_assoc($res_cacat)['total'];

$res_non = mysqli_query($conn, "SELECT COUNT(*) as total FROM laporannoncacat");
$count_non = mysqli_fetch_assoc($res_non)['total'];

// Ambil Daftar Laporan
$daftar_cacat = mysqli_query($conn, "SELECT laporancacat.*, users.nip as nip_staff
                                     FROM laporancacat 
                                     LEFT JOIN users ON laporancacat.id_user = users.id 
                                     ORDER BY laporancacat.id DESC");

$daftar_non_cacat = mysqli_query($conn, "SELECT laporannoncacat.*, users.nip as nip_staff
                                         FROM laporannoncacat 
                                         LEFT JOIN users ON laporannoncacat.id_user = users.id 
                                         ORDER BY laporannoncacat.id DESC");

$title = "Staff QC Dashboard";
$subtitle = "QC Inspection Panel - " . $_SESSION['nama'];
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff QC Dashboard</title>
    <?php include 'ui_config.php'; ?>
</head>

<body class="font-sans bg-utama">
    <?php include 'header.php'; ?>

    <main class="bg-white rounded-t-[40px] mt-[20px] min-h-[calc(100vh-120px)] px-6 pt-12 pb-24 relative">

        <div class="grid grid-cols-2 gap-8 mb-10">
            <div class="bg-white rounded-2xl py-16 flex flex-col items-center border border-gray-100 shadow-[0_4px_15px_rgba(0,0,0,0.1)]">
                <div class="flex items-center text-sm mb-4 font-bold text-gray-800 text-left">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4 text-utama mr-2">
                        <path d="m8 2 1.88 1.88"></path>
                        <path d="M14.12 3.88 16 2"></path>
                        <path d="M9 7.13v-1a3.003 3.003 0 1 1 6 0v1"></path>
                        <path d="M12 20c-3.3 0-6-2.7-6-6v-3a4 4 0 0 1 4-4h4a4 4 0 0 1 4 4v3c0 3.3-2.7 6-6 6"></path>
                        <path d="M12 20v-9"></path>
                        <path d="M6.53 9C4.6 8.8 3 7.1 3 5"></path>
                        <path d="M6 13H2"></path>
                        <path d="M3 21c0-2.1 1.7-3.9 3.8-4"></path>
                        <path d="M20.97 5c0 2.1-1.6 3.8-3.5 4"></path>
                        <path d="M22 13h-4"></path>
                        <path d="M17.2 17c2.1.1 3.8 1.9 3.8 4"></path>
                    </svg>
                    Total Laporan <br> Cacat
                </div>
                <span class="text-5xl font-bold text-gray-600"><?= $count_cacat; ?></span>
            </div>

            <div class="bg-white rounded-2xl py-16 flex flex-col items-center border border-gray-100 shadow-[0_4px_15px_rgba(0,0,0,0.1)]">
                <div class="flex items-center text-sm mb-4 font-bold text-gray-800 text-left">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4 text-utama mr-2">
                        <circle cx="12" cy="12" r="10"></circle>
                        <path d="m9 12 2 2 4-4"></path>
                    </svg>
                    Total Laporan <br> Non-Cacat
                </div>
                <span class="text-5xl font-bold text-gray-600"><?= $count_non; ?></span>
            </div>
        </div>

        <div class="bg-utama rounded-2xl flex overflow-hidden mb-6 p-1 shadow-xl">
            <button onclick="filterStaffLaporan('cacat')" id="tab-cacat" class="tab-btn flex-1 py-3 flex items-center justify-center gap-2 text-white font-bold text-sm border-b-4 border-white">
                Laporan Cacat
            </button>
            <button onclick="filterStaffLaporan('non-cacat')" id="tab-non-cacat" class="tab-btn flex-1 py-3 flex items-center justify-center gap-2 text-white/70 font-bold text-sm border-b-4 border-transparent">
                Laporan Non-Cacat
            </button>
        </div>

        <div class="bg-white rounded-3xl overflow-hidden shadow-[0_8px_30px_rgb(0,0,0,0.12)] border border-gray-50 mb-40">
            <h2 id="table-title" class="text-center py-6 font-bold text-lg text-gray-800">Daftar Laporan Cacat</h2>
            <div class="overflow-x-auto">
                <table class="w-full text-center border-collapse">
                    <thead>
                        <tr class="bg-gray-100 border-y border-gray-100">
                            <th class="py-4 px-2 text-xs font-bold text-utama uppercase">ID</th>
                            <th class="py-4 px-2 text-xs font-bold text-utama uppercase">Batch Number</th>
                            <th class="py-4 px-2 text-xs font-bold text-utama uppercase">Staff QC</th>
                            <th id="col-dynamic" class="py-4 px-2 text-xs font-bold text-utama uppercase">Keparahan</th>
                        </tr>
                    </thead>
                    <tbody id="staff-table-body">
                        <?php while ($row_cacat = mysqli_fetch_assoc($daftar_cacat)): ?>
                            <tr class="staff-row border-b last:border-0 hover:bg-gray-50 cursor-pointer transition-colors"
                                data-type="cacat"
                                onclick="window.location.href='detail_laporan.php?id=<?= $row_cacat['id']; ?>&type=cacat'">
                                <td class="py-5 font-bold text-xs text-black"><?= $row_cacat['id']; ?></td>
                                <td class="py-5 text-xs text-black"><?= $row_cacat['batch_number']; ?></td>
                                <td class="py-5 text-xs text-black"><?= $row_cacat['nip_staff'] ?? 'ST19822031'; ?></td>
                                <td class="py-5 text-xs text-black"><?= $row_cacat['tingkat_keparahan'] ?? 'Ringan'; ?></td>
                            </tr>
                        <?php endwhile; ?>

                        <?php while ($row_non = mysqli_fetch_assoc($daftar_non_cacat)): ?>
                            <tr class="staff-row border-b last:border-0 hidden hover:bg-gray-50 cursor-pointer transition-colors"
                                data-type="non-cacat"
                                onclick="window.location.href='detail_laporan.php?id=<?= $row_non['id']; ?>&type=non-cacat'">
                                <td class="py-5 font-bold text-xs text-black"><?= $row_non['id']; ?></td>
                                <td class="py-5 text-xs text-black"><?= $row_non['batch_number']; ?></td>
                                <td class="py-5 text-xs text-black"><?= $row_non['nip_staff'] ?? 'ST19822031'; ?></td>
                                <td class="py-5 text-xs text-black">Normal</td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>

                <div id="staff-empty-state" class="hidden py-12 text-center">
                    <p class="text-gray-400 text-sm">Tidak ada data laporan ditemukan.</p>
                </div>
            </div>
            <div class="h-24"></div>
        </div>

        <div class="fixed bottom-10 left-0 right-0 flex justify-center items-center z-50">
            <div class="relative flex items-center justify-center">
                <a href="form_laporan.php?type=non-cacat" id="btnNonCacat" class="absolute opacity-0 -translate-x-0 fab-transition pointer-events-none flex flex-col items-center gap-1">
                    <div class="bg-gradient-to-br from-green-400 to-green-600 p-4 rounded-2xl shadow-lg active:scale-90">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                        </svg>
                    </div>
                    <span class="text-[10px] font-extrabold text-black">NON-CACAT</span>
                </a>

                <button onclick="toggleFab()" id="mainFab" class="z-10 bg-utama text-white w-16 h-16 rounded-2xl shadow-2xl flex items-center justify-center fab-transition hover:scale-110 active:scale-95">
                    <svg xmlns="http://www.w3.org/2000/svg" id="fabIcon" fill="none" viewBox="0 0 24 24" stroke-width="4" stroke="currentColor" class="w-8 h-8 fab-transition">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                </button>

                <a href="form_laporan.php?type=cacat" id="btnCacat" class="absolute opacity-0 translate-x-0 fab-transition pointer-events-none flex flex-col items-center gap-1">
                    <div class="bg-gradient-to-br from-orange-400 to-orange-600 p-4 rounded-2xl shadow-lg active:scale-90">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                        </svg>
                    </div>
                    <span class="text-[10px] font-extrabold text-orange-700 uppercase">Cacat</span>
                </a>
            </div>
        </div>
    </main>

    <script>
        let isOpen = false;

        function toggleFab() {
            const icon = document.getElementById('fabIcon');
            const btnNonCacat = document.getElementById('btnNonCacat');
            const btnCacat = document.getElementById('btnCacat');
            isOpen = !isOpen;

            if (isOpen) {
                icon.style.transform = 'rotate(135deg)';
                btnNonCacat.classList.replace('opacity-0', 'opacity-100');
                btnNonCacat.classList.replace('-translate-x-0', '-translate-x-24');
                btnNonCacat.classList.remove('pointer-events-none');
                btnCacat.classList.replace('opacity-0', 'opacity-100');
                btnCacat.classList.replace('translate-x-0', 'translate-x-24');
                btnCacat.classList.remove('pointer-events-none');
            } else {
                icon.style.transform = 'rotate(0deg)';
                btnNonCacat.classList.replace('opacity-100', 'opacity-0');
                btnNonCacat.classList.replace('-translate-x-24', '-translate-x-0');
                btnNonCacat.classList.add('pointer-events-none');
                btnCacat.classList.replace('opacity-100', 'opacity-0');
                btnCacat.classList.replace('translate-x-24', 'translate-x-0');
                btnCacat.classList.add('pointer-events-none');
            }
        }

        function filterStaffLaporan(type) {
            const rows = document.querySelectorAll('.staff-row');
            const tabs = document.querySelectorAll('.tab-btn');
            const title = document.getElementById('table-title');
            const dynamicCol = document.getElementById('col-dynamic');
            let count = 0;

            tabs.forEach(tab => {
                if (tab.id === `tab-${type}`) {
                    tab.classList.remove('text-white/70', 'border-transparent');
                    tab.classList.add('text-white', 'border-white');
                } else {
                    tab.classList.add('text-white/70', 'border-transparent');
                    tab.classList.remove('text-white', 'border-white');
                }
            });

            if (type === 'cacat') {
                title.innerText = "Daftar Laporan Cacat";
                dynamicCol.innerText = "Keparahan";
            } else {
                title.innerText = "Daftar Laporan Non-Cacat";
                dynamicCol.innerText = "Keterangan";
            }

            rows.forEach(row => {
                if (row.getAttribute('data-type') === type) {
                    row.classList.remove('hidden');
                    count++;
                } else {
                    row.classList.add('hidden');
                }
            });

            const emptyState = document.getElementById('staff-empty-state');
            if (count === 0) {
                emptyState.classList.remove('hidden');
            } else {
                emptyState.classList.add('hidden');
            }
        }
    </script>
</body>

</html>