<?php
include 'auth.php';

// Pastikan hanya Admin yang bisa akses proses ini
if ($_SESSION['jabatan'] !== 'admin') {
    header("Location: login.php?pesan=hak_akses_ditolak");
    exit();
}

// Set nama file: Backup_QC_Tanggal_Jam.csv
$filename = "Backup_Sistem_QC_" . date('d-m-Y_H-i') . ".csv";

// Header untuk memaksa browser mengunduh file
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=' . $filename);

// Buka stream output
$output = fopen('php://output', 'w');

// --- BAGIAN 1: DATA LAPORAN CACAT ---
fputcsv($output, array('DATA LAPORAN CACAT'));
fputcsv($output, array('ID', 'No Batch', 'Jenis Udang', 'Tanggal', 'Jumlah', 'Kriteria Cacat', 'Tingkat Keparahan', 'Status'));

$query_cacat = "SELECT id, batch_number, jenis_udang, tanggal, kuantitas, kriteria_cacat, keparahan, status FROM laporancacat ORDER BY id ASC";
$result_cacat = mysqli_query($conn, $query_cacat);
while ($row = mysqli_fetch_assoc($result_cacat)) {
    fputcsv($output, $row);
}

// Kasih jarak baris kosong
fputcsv($output, array(''));
fputcsv($output, array(''));

// --- BAGIAN 2: DATA LAPORAN NON-CACAT ---
fputcsv($output, array('DATA LAPORAN NON-CACAT'));
fputcsv($output, array('ID', 'No Batch', 'Jenis Udang', 'Tanggal', 'Jumlah', 'Keterangan'));

$query_non = "SELECT id, batch_number, jenis_udang, tanggal, kuantitas, deskripsi FROM laporannoncacat ORDER BY id ASC";
$result_non = mysqli_query($conn, $query_non);
while ($row = mysqli_fetch_assoc($result_non)) {
    fputcsv($output, $row);
}

// Catat ke Log Aktivitas (PBI-037)
add_log($conn, "Backup Data", "Berhasil melakukan backup data ke format Excel/CSV lewat hosting.");

fclose($output);
exit();
?>