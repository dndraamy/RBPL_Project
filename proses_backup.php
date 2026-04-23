<?php
require_once 'auth.php';

// Hanya Admin yang boleh melakukan backup
if ($_SESSION['jabatan'] !== 'admin') {
    header("Location: dashboard_admin.php");
    exit();
}

// Konfigurasi Database
$host = "localhost";
$user = "root";
$pass = "";
$db   = "divqc_db";

// Nama file hasil backup
$nama_file = "Backup_Database_QC_" . date('Y-m-d_H-i-s') . ".sql";

// Lokasi penyimpanan sementara di XAMPP
// Pastikan path bin mysql benar (biasanya di C:\xampp\mysql\bin\mysqldump)
$dump_path = "C:\\xampp\\mysql\\bin\\mysqldump";
$command = "$dump_path --user=$user --password=$pass --host=$host $db";

// Header agar browser mendownload file sebagai SQL
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename="' . $nama_file . '"');

// Jalankan perintah backup
passthru($command);

// Catat ke Log Aktivitas (Integrasi Sprint 8)
add_log($conn, "Backup Data", "Admin melakukan pencadangan database sistem.");

exit();
?>