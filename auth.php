<?php
session_start();

// 1. KONEKSI DATABASE LANGSUNG DI SINI
$host = "localhost";
$user = "root";
$pass = "";
$db   = "divqc_db";
$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// 2. LOGIKA LOGIN
if (isset($_POST['login'])) {
    $nip = mysqli_real_escape_string($conn, $_POST['nip']);
    $password = $_POST['password']; // Di DB kamu masih plain text (staff123, dll)

    $query = "SELECT * FROM users WHERE nip = '$nip' AND password = '$password' LIMIT 1";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) === 1) {
        $user = mysqli_fetch_assoc($result);

        // 3. SET SESSION
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['nama']    = $user['nama_lengkap'];
        $_SESSION['jabatan'] = $user['jabatan'];

        // 4. REDIRECT BERDASARKAN JABATAN
        if ($user['jabatan'] === 'kepala') {
            header("Location: dashboard_kepala_qc.php");
        } elseif ($user['jabatan'] === 'staff') {
            header("Location: dashboard_staff_qc.php");
        } else {
            header("Location: dashboard_umum.php");
        }
        exit();
    } else {
        // Balik ke login jika salah
        header("Location: login.php?pesan=gagal");
        exit();
    }
}
?>