<?php
require_once '../includes/config.php';
checkLogin();
checkRole(['pembimbing_industri']);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_jurnal = intval($_POST['id_jurnal']);
    $action = $_POST['action']; // approved or rejected
    $catatan = trim($_POST['catatan']);

    // Validasi action hanya boleh approved atau rejected
    if (!in_array($action, ['approved', 'rejected'])) {
        redirect('../index.php?page=dashboard&error=invalid_action');
    }

    $stmt = $pdo->prepare("UPDATE jurnal_harian SET status_validasi = ?, catatan_pembimbing = ?, validated_by = ?, validated_at = NOW() WHERE id_jurnal = ?");
    if ($stmt->execute([$action, $catatan, $_SESSION['user_id'], $id_jurnal])) {
        redirect('../index.php?page=dashboard&success=validated');
    } else {
        redirect('../index.php?page=dashboard&error=failed');
    }
}
?>
