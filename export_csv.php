<?php
// Tahan semua output liar (HTML/spasi kosong) agar tidak bocor ke file CSV
ob_start();

// 1. Panggil koneksi database
require_once 'auth.php';

// BERSIHKAN SEMUA OUTPUT YANG BOCOR DARI FILE LAIN SEBELUMNYA
ob_end_clean();

// 2. Tangkap parameter 'type' dari URL
$type = isset($_GET['type']) ? $_GET['type'] : '';

if ($type == 'cacat') {
    // ---- EXPORT LAPORAN CACAT ----
    $filename = "Laporan_Cacat_QC_" . date('Y-m-d') . ".csv";
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    
    $output = fopen('php://output', 'w');
    // Header khusus cacat (ada Kriteria Cacat & Keparahan)
    fputcsv($output, array('ID Laporan', 'Batch Number', 'Tanggal', 'Jenis Udang', 'Kuantitas Total', 'Kriteria Cacat', 'Keparahan', 'Status', 'Catatan Kepala QC'));

    $query = "SELECT id, batch_number, tanggal, jenis_udang, kuantitas, kriteria_cacat, keparahan, status, catatan_kepala FROM laporancacat ORDER BY tanggal DESC";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            fputcsv($output, $row);
        }
    }
    fclose($output);
    exit();

} elseif ($type == 'non-cacat') {
    // ---- EXPORT LAPORAN NON-CACAT ----
    $filename = "Laporan_NonCacat_QC_" . date('Y-m-d') . ".csv";
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    
    $output = fopen('php://output', 'w');
    // Header khusus non-cacat (ada Ukuran Sampel)
    fputcsv($output, array('ID Laporan', 'Batch Number', 'Tanggal', 'Jenis Udang', 'Kuantitas Total', 'Ukuran Sampel', 'Status', 'Catatan Kepala QC'));

    $query = "SELECT id, batch_number, tanggal, jenis_udang, kuantitas, ukuran_sampel, status, catatan_kepala FROM laporannoncacat ORDER BY tanggal DESC";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            fputcsv($output, $row);
        }
    }
    fclose($output);
    exit();

} else {
    // Kalau tidak ada parameter yang valid
    echo "Tipe laporan tidak ditemukan. Silakan kembali ke dashboard.";
}
?>