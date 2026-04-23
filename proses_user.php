<?php
// Ganti require_once 'config.php' jadi auth agar fungsi add_log terbaca
require_once 'auth.php'; 

$aksi = isset($_GET['aksi']) ? $_GET['aksi'] : '';

if ($aksi == 'tambah') {
    $nip = $_POST['nip'];
    $nama_lengkap = $_POST['nama_lengkap'];
    $password = $_POST['password']; 
    $jabatan = $_POST['jabatan'];
    $email = $_POST['email'];
    $no_telp = $_POST['no_telp'];
    $alamat = $_POST['alamat'];

    $cek_nip = mysqli_query($conn, "SELECT id FROM users WHERE nip = '$nip'");
    if (mysqli_num_rows($cek_nip) > 0) {
        header("Location: tambah_user.php?status=error_nip");
        exit();
    }

    $query = "INSERT INTO users (nip, nama_lengkap, password, jabatan, email, no_telp, alamat) 
              VALUES ('$nip', '$nama_lengkap', '$password', '$jabatan', '$email', '$no_telp', '$alamat')";
    
    if (mysqli_query($conn, $query)) {
        // CATAT LOG TAMBAH USER (PBI-040)
        add_log($conn, "Tambah User", "Menambahkan user baru: $nama_lengkap (NIP: $nip)");
        
        header("Location: kelola_user.php?status=sukses_tambah");
    } else {
        header("Location: kelola_user.php?status=gagal_tambah");
    }
    exit();
}

elseif ($aksi == 'hapus') {
    $id = $_GET['id'];
    
    if ($id == $_SESSION['user_id']) {
        header("Location: kelola_user.php?status=error_hapus_diri_sendiri");
        exit();
    }

    // Ambil nama user dulu untuk keperluan log sebelum dihapus
    $user_data = mysqli_query($conn, "SELECT nama_lengkap FROM users WHERE id = '$id'");
    $u = mysqli_fetch_assoc($user_data);
    $nama_terhapus = $u['nama_lengkap'];

    $query = "DELETE FROM users WHERE id = '$id'";
    if (mysqli_query($conn, $query)) {
        // CATAT LOG HAPUS USER (PBI-040)
        add_log($conn, "Hapus User", "Menghapus user: $nama_terhapus (ID: $id)");
        
        header("Location: kelola_user.php?status=sukses_hapus");
    } else {
        header("Location: kelola_user.php?status=gagal_hapus");
    }
    exit();
}
?>