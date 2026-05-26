<?php
require_once '../includes/config.php';
checkLogin();
checkRole(['siswa']);

if (isset($_POST['submit'])) {
    $user_id = $_SESSION['user_id'];
    $tanggal = $_POST['tanggal'];
    $kompetensi = trim($_POST['kompetensi']);
    $kegiatan = trim($_POST['kegiatan']);
    
    $foto_name = null;
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
        // Pastikan folder upload ada
        $upload_dir = "../uploads/jurnal/";
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0755, true);
        }
        $ext = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
        $foto_name = "JRNL_" . time() . "_" . $user_id . "." . $ext;
        move_uploaded_file($_FILES['foto']['tmp_name'], $upload_dir . $foto_name);
    }

    $stmt = $pdo->prepare("INSERT INTO jurnal_harian (id_user, tanggal, kegiatan, foto_kegiatan, kompetensi_dasar, status_validasi) VALUES (?, ?, ?, ?, ?, 'pending')");
    if ($stmt->execute([$user_id, $tanggal, $kegiatan, $foto_name, $kompetensi])) {
        redirect('../index.php?page=jurnal&success=added');
    } else {
        redirect('../index.php?page=jurnal&error=failed');
    }
}
?>
