<?php
require_once '../includes/config.php';
checkLogin();
checkRole(['pembimbing_industri']);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_jurnal = $_POST['id_jurnal'];
    $action = $_POST['action']; // approved or rejected
    $catatan = $_POST['catatan'];

    $stmt = $pdo->prepare("UPDATE jurnal_harian SET status_validasi = ?, catatan_pembimbing = ? WHERE id_jurnal = ?");
    if ($stmt->execute([$action, $catatan, $id_jurnal])) {
        redirect('dashboard.php?success=validated');
    } else {
        redirect('dashboard.php?error=failed');
    }
}
?>
