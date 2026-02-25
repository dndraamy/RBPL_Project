<?php
if (isset($_POST['login'])) {
  $nip = $_POST['nip'];
  $password = $_POST['password'];

  $prefix = strtoupper(substr($nip, 0, 2));

  if ($prefix === 'KA') {
    header("Location: dashboard_kepala_qc.php");
    exit();
  } elseif ($prefix === 'ST') {
    header("Location: dashboard_staff_qc.php");
    exit();
  } else {
    echo "<script>alert('NIP tidak valid!');</script>";
  }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login Sistem QC - PT Misaja Mitra</title>
  <?php include 'config.php'; ?>
</head>

<body class="bg-utama min-h-screen flex items-center justify-center p-6">
  <div class="bg-white w-full max-w-sm rounded-[30px] shadow-2xl p-8 flex flex-col items-center">

    <div class="mb-4">
      <img
        src="assets/logo-misaja-mitra.png"
        alt="Logo PT Misaja Mitra"
        class="w-24 h-auto object-contain" />
    </div>

    <h1 class="text-2xl font-bold text-black text-center leading-tight">
      Login Sistem QC
    </h1>
    <p class="text-gray-400 text-sm mb-8 font-medium">PT Misaja Mitra</p>

    <form action="" method="POST" class="w-full space-y-5">
      <div class="space-y-2">
        <label class="block text-sm font-bold text-gray-700 ml-1">Nomor Induk Pegawai (NIP)</label>
        <input type="text" name="nip" required placeholder="Masukkan NIP Anda"
          class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-utama placeholder-gray-300 text-sm" />
      </div>

      <div class="space-y-2">
        <label class="block text-sm font-bold text-gray-700 ml-1">Kata Sandi</label>
        <input type="password" name="password" required placeholder="Masukkan Kata Sandi"
          class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-utama placeholder-gray-300 text-sm" />
      </div>

      <button type="submit" name="login"
        class="w-full py-4 bg-gradient-to-r from-utama to-gelap text-white font-bold rounded-2xl shadow-lg active:scale-95 transition-all mt-2 tracking-wider">
        LOGIN
      </button>

      <p class="text-center text-xs text-gray-500 mt-4">
        Lupa Kata Sandi? <a href="kontak_admin.php" class="font-bold text-utama hover:underline">Hubungi Admin</a>
      </p>
    </form>
  </div>
</body>

</html>