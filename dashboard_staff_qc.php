<?php
$title = "Staff QC Dashboard";
$subtitle = "Staff QC Inspection - ST19822031";
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Staff QC Dashboard</title>
    <style>
        body {
            background-color: #740001;
            /* Warna merah header */
        }

        .main-container {
            background-color: #f8f9fa;
            border-top-left-radius: 40px;
            border-top-right-radius: 40px;
            min-height: calc(100vh - 100px);
        }

        /* Style tambahan untuk transisi yang lebih smooth */
        .fab-transition {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
    </style>
</head>

<body class="font-sans">
    <?php include 'header.php'; ?>

    <main class="main-container px-6 pt-10 pb-24 relative">

        <div class="grid grid-cols-2 gap-4 mb-8">
            <div class="bg-white p-6 rounded-2xl shadow-lg flex flex-col items-center border border-gray-100">
                <div class="flex items-center gap-2 mb-4 text-xs font-bold text-gray-800 uppercase text-center leading-tight">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M11 17a1 1 0 001.447.894l4-2A1 1 0 0017 15V9.236a1 1 0 00-1.447-.894l-4 2a1 1 0 00-.553.894V17zM15.211 6.276a1 1 0 000-1.788l-4.764-2.382a1 1 0 00-.894 0L4.789 4.488a1 1 0 000 1.788l4.764 2.382a1 1 0 00.894 0l4.764-2.382zM4.447 8.342A1 1 0 003 9.236V15a1 1 0 00.553.894l4 2A1 1 0 009 17v-5.764a1 1 0 00-.553-.894l-4-2z" />
                    </svg>
                    Total Laporan <br> Cacat
                </div>
                <span class="text-6xl font-bold text-gray-600">1</span>
            </div>
            <div class="bg-white p-6 rounded-2xl shadow-lg flex flex-col items-center border border-gray-100">
                <div class="flex items-center gap-2 mb-4 text-xs font-bold text-gray-800 uppercase text-center leading-tight">
                    <svg class="w-4 h-4 text-black" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                    Total Laporan <br> Non-Cacat
                </div>
                <span class="text-6xl font-bold text-gray-600">0</span>
            </div>
        </div>

        <div class="bg-[#b30000] rounded-xl flex overflow-hidden mb-6 p-1 shadow-md">
            <button class="flex-1 py-3 flex items-center justify-center gap-2 text-white font-bold text-sm border-b-4 border-white">
                <span class="bg-white text-red-700 rounded-full w-5 h-5 flex items-center justify-center text-[10px]">!</span>
                Laporan Cacat
            </button>
            <button class="flex-1 py-3 flex items-center justify-center gap-2 text-white/70 font-bold text-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                </svg>
                Laporan Non-Cacat
            </button>
        </div>

        <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
            <h2 class="text-center py-6 font-bold text-lg text-gray-800">Daftar Laporan Cacat</h2>

            <div class="overflow-x-auto">
                <table class="w-full text-center border-collapse">
                    <thead>
                        <tr class="bg-gray-50 border-y border-gray-100">
                            <th class="py-4 px-2 text-[10px] font-bold text-red-700 uppercase">ID</th>
                            <th class="py-4 px-2 text-[10px] font-bold text-red-700 uppercase">Batch Number</th>
                            <th class="py-4 px-2 text-[10px] font-bold text-red-700 uppercase">Staff QC</th>
                            <th class="py-4 px-2 text-[10px] font-bold text-red-700 uppercase">Keparahan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="border-b border-gray-50">
                            <td class="py-5 font-bold text-sm text-gray-800">1</td>
                            <td class="py-5 text-sm text-gray-600">US21234</td>
                            <td class="py-5 text-sm text-gray-600">ST19822031</td>
                            <td class="py-5 text-sm text-gray-600 italic">ringan</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="h-20"></div>
        </div>

        <div class="fixed bottom-10 left-0 right-0 flex justify-center items-center z-50">
            <div class="relative flex items-center justify-center">

                <a href="form_laporan.php?type=non-cacat"
                    id="btnNonCacat"
                    class="absolute opacity-0 -translate-x-0 fab-transition pointer-events-none flex flex-col items-center gap-1">
                    <div class="bg-gradient-to-br from-green-400 to-green-600 p-4 rounded-2xl shadow-lg active:scale-90">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                        </svg>
                    </div>
                    <span class="text-[10px] font-extrabold text-green-700">NON-CACAT</span>
                </a>

                <button onclick="toggleFab()"
                    id="mainFab"
                    class="z-10 bg-[#740001] text-white w-16 h-16 rounded-2xl shadow-2xl flex items-center justify-center fab-transition hover:scale-110 active:scale-95">
                    <svg xmlns="http://www.w3.org/2000/svg" id="fabIcon" fill="none" viewBox="0 0 24 24" stroke-width="4" stroke="currentColor" class="w-8 h-8 fab-transition">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                </button>

                <a href="form_laporan.php?type=cacat"
                    id="btnCacat"
                    class="absolute opacity-0 translate-x-0 fab-transition pointer-events-none flex flex-col items-center gap-1">
                    <div class="bg-gradient-to-br from-orange-400 to-orange-600 p-4 rounded-2xl shadow-lg active:scale-90">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                        </svg>
                    </div>
                    <span class="text-[10px] font-extrabold text-orange-700 font-bold uppercase">Cacat</span>
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
                // Efek saat dibuka:
                // 1. Putar icon + menjadi X (135 derajat)
                icon.style.transform = 'rotate(135deg)';

                // 2. Geser tombol Hijau ke kiri (-90px) dan munculkan
                btnNonCacat.classList.remove('opacity-0', '-translate-x-0', 'pointer-events-none');
                btnNonCacat.classList.add('opacity-100', '-translate-x-24');

                // 3. Geser tombol Oranye ke kanan (90px) dan munculkan
                btnCacat.classList.remove('opacity-0', 'translate-x-0', 'pointer-events-none');
                btnCacat.classList.add('opacity-100', 'translate-x-24');
            } else {
                // Efek saat ditutup:
                // 1. Kembalikan icon ke posisi awal
                icon.style.transform = 'rotate(0deg)';

                // 2. Sembunyikan kembali tombol Hijau ke tengah
                btnNonCacat.classList.add('opacity-0', '-translate-x-0', 'pointer-events-none');
                btnNonCacat.classList.remove('opacity-100', '-translate-x-24');

                // 3. Sembunyikan kembali tombol Oranye ke tengah
                btnCacat.classList.add('opacity-0', 'translate-x-0', 'pointer-events-none');
                btnCacat.classList.remove('opacity-100', 'translate-x-24');
            }
        }
    </script>

</body>

</html>