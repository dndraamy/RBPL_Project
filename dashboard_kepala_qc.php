<?php
$title = "Kepala QC Dashboard";
$subtitle = "Kepala QC Inspection - KA0092863713";
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Kepala QC Dashboard</title>
    <style>
        body {
            background-color: #6d0000;
            /* Warna merah latar belakang utama */
        }

        .main-content {
            background-color: #ffffff;
            border-top-left-radius: 40px;
            border-top-right-radius: 40px;
            min-height: calc(100vh - 120px);
            margin-top: 20px;
        }

        .stat-card {
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body class="font-sans">
    <?php include 'header.php'; ?>

    <main class="main-content px-6 pt-12 pb-10">

        <div class="space-y-4 mb-10">
            <div class="stat-card bg-white rounded-2xl p-4 flex items-center gap-4">
                <div class="bg-[#6d0000] text-white p-2 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 6.75h12M8.25 12h12m-12 5.25h12M3.75 6.75h.007v.008H3.75V6.75zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zM3.75 12h.007v.008H3.75V12zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm-.375 5.25h.007v.008H3.75v-.008zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                    </svg>
                </div>
                <div>
                    <p class="text-xs font-bold text-gray-400">Total Semua Laporan</p>
                    <p class="text-3xl font-bold text-black leading-none">10</p>
                </div>
            </div>

            <div class="stat-card bg-white rounded-2xl p-4 flex items-center gap-4">
                <div class="border-2 border-[#6d0000] text-[#6d0000] p-2 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                    </svg>
                </div>
                <div>
                    <p class="text-xs font-bold text-gray-400">Laporan Cacat Masuk</p>
                    <p class="text-3xl font-bold text-black leading-none">1</p>
                </div>
            </div>

            <div class="stat-card bg-white rounded-2xl p-4 flex items-center gap-4">
                <div class="border-2 border-[#6d0000] text-[#6d0000] p-2 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9 5.25h.008v.008H12v-.008z" />
                    </svg>
                </div>
                <div>
                    <p class="text-xs font-bold text-gray-400 leading-tight">Total Menunggu Tindak<br>Lanjut</p>
                    <p class="text-3xl font-bold text-black leading-none">0</p>
                </div>
            </div>
        </div>

        <div class="flex items-center gap-2 mb-6 text-[#6d0000]">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-5 h-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
            </svg>
            <h2 class="text-xl font-bold">Tinjauan & Tindak Lanjut Laporan</h2>
        </div>

        <div class="bg-[#6d0000] rounded-3xl overflow-hidden shadow-xl">
            <div class="flex px-6 pt-4 gap-6 text-white text-sm font-bold">
                <button class="pb-2 border-b-4 border-white">Laporan Cacat</button>
                <button class="pb-2 opacity-70">Laporan Non-Cacat</button>
            </div>

            <div class="bg-white m-2 rounded-2xl overflow-hidden">
                <table class="w-full text-left">
                    <thead class="bg-gray-50 border-b border-gray-100">
                        <tr>
                            <th class="py-3 px-4 text-[10px] font-bold">ID</th>
                            <th class="py-3 px-2 text-[10px] font-bold">Batch Number</th>
                            <th class="py-3 px-2 text-[10px] font-bold">Catatan</th>
                            <th class="py-3 px-4 text-[10px] font-bold">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="border-b border-gray-50 last:border-0">
                            <td class="py-4 px-4 text-xs font-bold">1</td>
                            <td class="py-4 px-2 text-xs text-gray-600">US21234</td>
                            <td class="py-4 px-2 text-[10px] text-gray-600 leading-tight">udang kurang fresh.</td>
                            <td class="py-4 px-4">
                                <select class="text-[10px] border border-gray-300 rounded px-1 py-1 focus:outline-none bg-white">
                                    <option>Diterima</option>
                                    <option>Ditolak</option>
                                </select>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="h-40"></div>
            </div>
        </div>

    </main>

</body>

</html>