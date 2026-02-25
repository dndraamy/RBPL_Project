<?php
if (isset($_POST['login'])) {
  $nip = $_POST['nip'];
  $password = $_POST['password'];

  // Ambil 2 karakter pertama dan ubah ke huruf besar semua
  $prefix = strtoupper(substr($nip, 0, 2));

  if ($prefix === 'KA') {
    // Jika awalan KA (Kepala)
    header("Location: dashboard_kepala_qc.php");
    exit();
  } elseif ($prefix === 'ST') {
    // Jika awalan ST (Staff)
    header("Location: dashboard_staff_qc.php");
    exit();
  } else {
    // Jika NIP tidak dikenal
    echo "<script>alert('NIP tidak valid!');</script>";
  }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <script src="https://cdn.tailwindcss.com"></script>
  <title>Login Sistem QC - PT Misaja Mitra</title>
</head>

<body class="bg-[#740001] min-h-screen flex items-center justify-center p-6">
  <div
    class="bg-white w-full max-w-sm rounded-[30px] shadow-2xl p-8 flex flex-col items-center">
    <div class="mb-4">
      <img
        src="assets/logo-misaja-mitra.png"
        alt="Logo PT Misaja Mitra"
        class="w-24 h-auto object-contain" />
    </div>

    <h1 class="text-2xl font-bold text-black text-center leading-tight">
      Login Sistem QC
    </h1>
    <p class="text-gray-500 text-sm mb-8">PT Misaja Mitra</p>

    <form action="" method="POST" class="w-full space-y-5">
      <div class="space-y-2">
        <label class="block text-sm font-medium text-gray-800 ml-1">Nomor Induk Pegawai (NIP)</label>
        <input type="text" name="nip" required placeholder="Contoh: ST123 atau KA456"
          class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-red-800 placeholder-gray-300 text-sm" />
      </div>

      <div class="space-y-2">
        <label class="block text-sm font-medium text-gray-800 ml-1">Kata Sandi</label>
        <input type="password" name="password" required placeholder="Masukkan Kata Sandi"
          class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-red-800 placeholder-gray-300 text-sm" />
      </div>

      <button type="submit" name="login"
        class="w-full py-4 bg-gradient-to-r from-[#cc0000] to-[#600000] text-white font-bold rounded-2xl shadow-lg active:scale-[0.98] transition-transform mt-2 tracking-wider">
        LOGIN
      </button>
    </form>
  </div>
</body>

</html>