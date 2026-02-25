<?php

$title = "Isi Formulir";
$subtitle = "Lorem ipsum";


// 1. Ambil type dari URL, defaultnya 'cacat' jika tidak ada
$type = isset($_GET['type']) ? $_GET['type'] : 'cacat';

// 2. Tentukan variabel berdasarkan type
if ($type === 'non-cacat') {
    $judulForm = "Laporan Non-Cacat";
    $gradasiWarna = "from-[#cc0000] to-[#600000]"; // Merah
    $placeholderKuantitas = "Total Kuantitas (ekor)";
    $placeholderDeskripsi = "Catatan Laporan (Opsional)";
    $isCacat = false;
} else {
    $judulForm = "Laporan Cacat";
    $gradasiWarna = "from-[#cc0000] to-[#600000]"; // Merah
    $placeholderKuantitas = "Kuantitas Cacat (ekor)";
    $placeholderDeskripsi = "Deskripsi Tambahan Cacat";
    $isCacat = true;
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title><?php echo $judulForm; ?></title>
    <style>
        body {
            background-color: #6d0000;
        }

        .form-container {
            background-color: #ffffff;
            border-top-left-radius: 40px;
            border-top-right-radius: 40px;
            min-height: calc(100vh - 80px);
        }

        .input-shadow {
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        }

        .bg-simpan {
            background: linear-gradient(to right, #00b894, #006b54);
        }
    </style>
</head>

<body class="font-sans text-gray-800">

    <?php include 'header.php'; ?>

    <main class="form-container px-6 pt-10 pb-16">
        <div class="flex items-center gap-4 mb-8">
            <button onclick="window.history.back()" class="bg-[#9c0000] text-white w-12 h-12 rounded-full flex items-center justify-center shadow-lg active:scale-90 transition-transform">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor" class="w-6 h-6 mr-1">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                </svg>
            </button>

            <div class="flex-1 bg-gradient-to-r <?php echo $gradasiWarna; ?> text-white py-3 px-6 rounded-full text-center font-bold text-lg shadow-md uppercase tracking-wider">
                <?php echo $judulForm; ?>
            </div>
        </div>

        <form action="proses_simpan.php" method="POST" class="space-y-5">
            <input type="text" name="batch_number" placeholder="Nomor Batch/Produksi" class="w-full p-4 border border-gray-300 rounded-xl input-shadow focus:outline-none focus:ring-2 focus:ring-red-800">

            <div class="relative">
                <select name="jenis_udang" class="w-full p-4 border border-gray-300 rounded-xl input-shadow appearance-none text-gray-500 focus:outline-none focus:ring-2 focus:ring-red-800 bg-white">
                    <option disabled selected>Jenis Udang</option>
                    <option value="vaname">Udang Vaname</option>
                    <option value="windu">Udang Windu</option>
                </select>
                <div class="absolute inset-y-0 right-4 flex items-center pointer-events-none text-red-900">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                    </svg>
                </div>
            </div>

            <input type="date" name="tanggal" class="w-full p-4 border border-gray-300 rounded-xl input-shadow text-gray-500 bg-white">

            <input type="number" name="kuantitas" placeholder="<?php echo $placeholderKuantitas; ?>" class="w-full p-4 border border-gray-300 rounded-xl input-shadow focus:outline-none focus:ring-2 focus:ring-red-800">

            <?php if ($isCacat): ?>
                <div class="relative">
                    <select name="kriteria_cacat" class="w-full p-4 border border-gray-300 rounded-xl input-shadow appearance-none text-gray-500 focus:outline-none focus:ring-2 focus:ring-red-800 bg-white">
                        <option disabled selected>Kriteria Cacat</option>
                        <option>Udang Rusak Fisik</option>
                        <option>Perubahan Warna</option>
                    </select>
                    <div class="absolute inset-y-0 right-4 flex items-center pointer-events-none text-red-900">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                        </svg>
                    </div>
                </div>

                <div class="relative">
                    <select name="keparahan_cacat" class="w-full p-4 border border-gray-300 rounded-xl input-shadow appearance-none text-gray-500 focus:outline-none focus:ring-2 focus:ring-red-800 bg-white">
                        <option disabled selected>Keparahan Cacat</option>
                        <option>Ringan</option>
                        <option>Sedang</option>
                        <option>Berat</option>
                    </select>
                    <div class="absolute inset-y-0 right-4 flex items-center pointer-events-none text-red-900">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                        </svg>
                    </div>
                </div>
            <?php endif; ?>

            <textarea name="deskripsi" placeholder="<?php echo $placeholderDeskripsi; ?>" rows="5" class="w-full p-4 border border-gray-300 rounded-2xl input-shadow focus:outline-none focus:ring-2 focus:ring-red-800 resize-none mb-4"></textarea>

            <div class="flex justify-center pt-4">
                <button type="submit" class="w-full max-w-xs py-4 bg-simpan text-white font-bold text-xl rounded-full shadow-lg active:scale-95 transition-transform tracking-wide">
                    Simpan
                </button>
            </div>
        </form>
    </main>
</body>

</html>