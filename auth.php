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
    $password = $_POST['password'];

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
        } elseif ($user['jabatan'] === 'manajer') {
            header("Location: dashboard_manajer_supervisor.php");
        } elseif ($user['jabatan'] === 'supervisor') {
            header("Location: dashboard_manajer_supervisor.php");
        } elseif ($user['jabatan'] === 'admin') {
            header("Location: dashboard_admin.php");
        } else {
            header("Location: login.php");
        }
        exit();
    } else {
        // Balik ke login jika salah
        header("Location: login.php?pesan=gagal");
        exit();
    }
}

// ==========================================
// START: PBI-037 (GLOBAL LOGGER BY IKKE)
// Fungsi untuk mencatat setiap aktivitas penting
// ==========================================
function add_log($conn, $action, $details) {
    // Ambil user_id dari session yang sedang aktif
    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
        $action = mysqli_real_escape_string($conn, $action);
        $details = mysqli_real_escape_string($conn, $details);
        
        $sql = "INSERT INTO activity_logs (user_id, action, details) 
                VALUES ('$user_id', '$action', '$details')";
        mysqli_query($conn, $sql);
    }
}
// ==========================================
// END: PBI-037
// ==========================================
?>