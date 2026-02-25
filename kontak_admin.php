<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bantuan Login - PT Misaja Mitra</title>
    <?php include 'config.php'; ?>
</head>

<body class="bg-latar min-h-screen flex items-center justify-center p-6">
    <div class="bg-white w-full max-w-sm rounded-[30px] shadow-xl p-8 text-center">
        <div class="bg-utama/10 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-6">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-utama" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
            </svg>
        </div>

        <h2 class="text-xl font-bold text-black mb-2">Lupa Kata Sandi?</h2>
        <p class="text-gray-500 text-sm mb-8">Untuk alasan keamanan, silakan hubungi Admin IT PT Misaja Mitra untuk melakukan reset kata sandi Anda.</p>

        <div class="space-y-3">
            <a href="https://wa.me/6281234567890" class="flex items-center justify-center gap-3 w-full py-4 bg-[#25D366] text-white font-bold rounded-2xl shadow-lg active:scale-95 transition-all">
                <span>WhatsApp Admin</span>
            </a>

            <a href="login.php" class="block w-full py-4 text-gray-400 font-semibold text-sm hover:text-utama transition-colors">
                Kembali ke Login
            </a>
        </div>
    </div>
</body>

</html>