<?php
$title = "Kepala QC Dashboard";
$subtitle = "Kepala QC Inspection - KA0092863713";
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kepala QC Dashboard</title>
    <?php include 'config.php'; ?>
</head>

<body class="font-sans bg-utama">
    <?php include 'header.php'; ?>

    <main class="bg-white rounded-t-[40px] mt-[20px] min-h-[calc(100vh-120px)] px-6 pt-12 pb-10">

        <div class="space-y-4 mb-10">
            <div class="bg-white rounded-2xl p-4 flex items-center gap-4 shadow-[0_4px_15px_rgba(0,0,0,0.1)]">
                <div class="bg-utama text-white p-2 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="8" x2="21" y1="6" y2="6"></line>
                        <line x1="8" x2="21" y1="12" y2="12"></line>
                        <line x1="8" x2="21" y1="18" y2="18"></line>
                        <line x1="3" x2="3.01" y1="6" y2="6"></line>
                        <line x1="3" x2="3.01" y1="12" y2="12"></line>
                        <line x1="3" x2="3.01" y1="18" y2="18"></line>
                    </svg>
                </div>
                <div>
                    <p class="text-xs font-bold text-gray-400">Total Semua Laporan</p>
                    <p class="text-3xl font-bold text-black leading-none">10</p>
                </div>
            </div>

            <div class="bg-white rounded-2xl p-4 -ml-0.5 flex items-center gap-4 shadow-[0_4px_15px_rgba(0,0,0,0.1)]">
                <svg xmlns="http://www.w3.org/2000/svg" width="44" height="44" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="stroke-utama">
                    <circle cx="12" cy="12" r="10"></circle>
                    <line x1="12" x2="12" y1="8" y2="12"></line>
                    <line x1="12" x2="12.01" y1="16" y2="16"></line>
                </svg>
                <div>
                    <p class="text-xs font-bold text-gray-400">Laporan Cacat Masuk</p>
                    <p class="text-3xl font-bold text-black leading-none">1</p>
                </div>
            </div>

            <div class="bg-white rounded-2xl p-4 -ml-1 flex items-center gap-4 shadow-[0_4px_15px_rgba(0,0,0,0.1)]">
                <svg xmlns="http://www.w3.org/2000/svg" width="44" height="44" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="stroke-utama">
                    <path d="M12 17h.01"></path>
                    <path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7z"></path>
                    <path d="M9.1 9a3 3 0 0 1 5.82 1c0 2-3 3-3 3"></path>
                </svg>
                <div>
                    <p class="text-xs font-bold text-gray-400">Total Menunggu Tindak Lanjut</p>
                    <p class="text-3xl font-bold text-black leading-none">0</p>
                </div>
            </div>
        </div>

        <div class="flex items-center gap-2 mb-6 text-utama">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="stroke-utama">
                <circle cx="11" cy="11" r="8"></circle>
                <path d="m21 21-4.3-4.3"></path>
            </svg>
            <h2 class="text-lg font-bold">Tinjauan & Tindak Lanjut Laporan</h2>
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

            <div class="bg-white m-2 rounded-2xl overflow-hidden">
                <table class="w-full text-left text-xs">
                    <thead class="bg-gray-50 border-b">
                        <tr>
                            <th class="py-3 px-4">ID</th>
                            <th class="py-3 px-2">Batch Number</th>
                            <th class="py-3 px-2">Catatan</th>
                            <th class="py-3 px-4">Status</th>
                        </tr>
                    </thead>
                    <tbody id="table-body">
                        <tr class="row-laporan border-b last:border-0" data-type="cacat">
                            <td class="py-4 px-4 font-bold">1</td>
                            <td class="py-4 px-2">US21234</td>
                            <td class="py-4 px-2 italic text-red-500">Udang kurang fresh.</td>
                            <td class="py-4 px-4">
                                <select class="border rounded px-1 py-1 focus:outline-none bg-white">
                                    <option>Diterima</option>
                                    <option>Ditolak</option>
                                </select>
                            </td>
                        </tr>

                        <tr class="row-laporan border-b last:border-0 hidden" data-type="non-cacat">
                            <td class="py-4 px-4 font-bold">2</td>
                            <td class="py-4 px-2">US99999</td>
                            <td class="py-4 px-2 text-gray-400">Kualitas sangat baik.</td>
                            <td class="py-4 px-4 text-green-600 font-bold">OK</td>
                        </tr>
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
        function filterLaporan(type) {
            const rows = document.querySelectorAll('.row-laporan');
            const tabs = document.querySelectorAll('.tab-btn');
            let hasData = false;

            // 1. Update Tampilan Tab
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

            // 2. Filter Baris Tabel
            rows.forEach(row => {
                if (row.getAttribute('data-type') === type) {
                    row.classList.remove('hidden');
                    hasData = true;
                } else {
                    row.classList.add('hidden');
                }
            });

            // 3. Handle Empty State
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