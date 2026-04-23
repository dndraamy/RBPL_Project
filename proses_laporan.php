<?php
include 'auth.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_user = $_SESSION['user_id'];
    $type = $_POST['type'];
    $batch_number = mysqli_real_escape_string($conn, $_POST['batch_number']);
    $jenis_udang = mysqli_real_escape_string($conn, $_POST['jenis_udang']);
    $tanggal = $_POST['tanggal'];
    $kuantitas = $_POST['kuantitas'];
    $deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);

    if ($type === 'cacat') {
        // Ambil data khusus laporan cacat
        $kriteria = mysqli_real_escape_string($conn, $_POST['kriteria_cacat']);
        $keparahan = $_POST['keparahan_cacat'];

        $query = "INSERT INTO laporancacat (id_user, batch_number, jenis_udang, tanggal, kuantitas, kriteria_cacat, keparahan, deskripsi, status) 
                  VALUES ('$id_user', '$batch_number', '$jenis_udang', '$tanggal', '$kuantitas', '$kriteria', '$keparahan', '$deskripsi', 'menunggu')";
        
        // Label untuk log
        $log_action = "Input Laporan Cacat";
    } else {
        // Ambil data khusus laporan non-cacat
        $query = "INSERT INTO laporannoncacat (id_user, batch_number, jenis_udang, tanggal, kuantitas, deskripsi) 
                  VALUES ('$id_user', '$batch_number', '$jenis_udang', '$tanggal', '$kuantitas', '$deskripsi')";
        
        // Label untuk log
        $log_action = "Input Laporan Non-Cacat";
    }

    if (mysqli_query($conn, $query)) {
        // ==========================================
        // START: PBI-038 (INTEGRASI LOGGER OLEH IKKE)
        // ==========================================
        $details = "Staff QC menginput laporan " . ($type === 'cacat' ? "cacat" : "non-cacat") . " untuk Batch: " . $batch_number;
        add_log($conn, $log_action, $details);
        // ==========================================
        // END: PBI-038
        // ==========================================

        header("Location: dashboard_staff_qc.php?pesan=sukses_simpan");
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($conn);
    }
}
?>