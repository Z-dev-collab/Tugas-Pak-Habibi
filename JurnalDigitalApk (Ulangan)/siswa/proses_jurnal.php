<?php
require_once '../includes/config.php';
checkLogin();
checkRole(['siswa']);

if (isset($_POST['submit'])) {
    $user_id = $_SESSION['user_id'];
    $tanggal = $_POST['tanggal'];
    $kompetensi = $_POST['kompetensi'];
    $kegiatan = $_POST['kegiatan'];
    
    $foto_name = null;
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
        $ext = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
        $foto_name = "JRNL_" . time() . "_" . $user_id . "." . $ext;
        move_uploaded_file($_FILES['foto']['tmp_name'], "../uploads/jurnal/" . $foto_name);
    }

    $stmt = $pdo->prepare("INSERT INTO jurnal_harian (id_user, tanggal, kegiatan, foto_kegiatan, kompetensi_dasar, status_validasi) VALUES (?, ?, ?, ?, ?, 'pending')");
    if ($stmt->execute([$user_id, $tanggal, $kegiatan, $foto_name, $kompetensi])) {
        redirect('jurnal.php?success=added');
    } else {
        redirect('jurnal.php?error=failed');
    }
}
?>
