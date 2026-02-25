<?php
$title = "Staff QC Dashboard";
$subtitle = "Staff QC Inspection - ST19822031";
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff QC Dashboard</title>
    <?php include 'config.php'; ?>
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
                <span class="text-5xl font-bold text-gray-600">1</span>
            </div>

            <div class="bg-white rounded-2xl py-16 flex flex-col items-center border border-gray-100 shadow-[0_4px_15px_rgba(0,0,0,0.1)]">
                <div class="flex items-center text-sm mb-4 font-bold text-gray-800 text-left">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4 text-utama mr-2">
                        <circle cx="12" cy="12" r="10"></circle>
                        <path d="m9 12 2 2 4-4"></path>
                    </svg>
                    Total Laporan <br> Non-Cacat
                </div>
                <span class="text-5xl font-bold text-gray-600">0</span>
            </div>
        </div>

        <div class="bg-utama rounded-2xl flex overflow-hidden mb-6 p-1 shadow-xl">
            <button onclick="filterStaffLaporan('cacat')" id="tab-cacat" class="tab-btn flex-1 py-3 flex items-center justify-center gap-2 text-white font-bold text-sm border-b-4 border-white">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5">
                    <path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"></path>
                    <path d="M12 9v4"></path>
                    <path d="M12 17h.01"></path>
                </svg>
                Laporan Cacat
            </button>
            <button onclick="filterStaffLaporan('non-cacat')" id="tab-non-cacat" class="tab-btn flex-1 py-3 flex items-center justify-center gap-2 text-white/70 font-bold text-sm border-b-4 border-transparent">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5">
                    <path d="M18 6 7 17l-5-5"></path>
                    <path d="m22 10-7.5 7.5L13 16"></path>
                </svg>
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
                        <tr class="staff-row border-b last:border-0" data-type="cacat">
                            <td class="py-5 font-bold text-xs text-black">1</td>
                            <td class="py-5 text-xs text-black">US21234</td>
                            <td class="py-5 text-xs text-black">ST19822031</td>
                            <td class="py-5 text-xs text-black">Ringan</td>
                        </tr>
                        <tr class="staff-row border-b last:border-0 hidden" data-type="non-cacat">
                            <td class="py-5 font-bold text-xs text-black">2</td>
                            <td class="py-5 text-xs text-black">US99999</td>
                            <td class="py-5 text-xs text-black">ST19822031</td>
                            <td class="py-5 text-xs text-black">Normal</td>
                        </tr>
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

            // 1. Update UI Tab
            tabs.forEach(tab => {
                if (tab.id === `tab-${type}`) {
                    tab.classList.remove('text-white/70', 'border-transparent');
                    tab.classList.add('text-white', 'border-white');
                } else {
                    tab.classList.add('text-white/70', 'border-transparent');
                    tab.classList.remove('text-white', 'border-white');
                }
            });

            // 2. Update Judul dan Header Kolom
            if (type === 'cacat') {
                title.innerText = "Daftar Laporan Cacat";
                dynamicCol.innerText = "Keparahan";
            } else {
                title.innerText = "Daftar Laporan Non-Cacat";
                dynamicCol.innerText = "Keterangan";
            }

            // 3. Filter Baris Tabel
            rows.forEach(row => {
                if (row.getAttribute('data-type') === type) {
                    row.classList.remove('hidden');
                    count++;
                } else {
                    row.classList.add('hidden');
                }
            });

            // 4. Handle State Kosong
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