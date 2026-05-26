<?php
require_once '../includes/config.php';
checkLogin();
checkRole(['siswa']);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $lat = floatval($_POST['lat']);
    $lng = floatval($_POST['lng']);
    $today = date('Y-m-d');
    $now = date('H:i:s');

    // Check if already checked in today
    $stmt = $pdo->prepare("SELECT * FROM absensi WHERE id_user = ? AND tanggal = ?");
    $stmt->execute([$user_id, $today]);
    
    if ($stmt->fetch()) {
        redirect('../index.php?page=dashboard&error=already_checked_in');
    }

    $stmt = $pdo->prepare("INSERT INTO absensi (id_user, tanggal, jam_masuk, lat_checkin, long_checkin, status_kehadiran) VALUES (?, ?, ?, ?, ?, 'hadir')");
    if ($stmt->execute([$user_id, $today, $now, $lat, $lng])) {
        redirect('../index.php?page=dashboard&success=checked_in');
    } else {
        redirect('../index.php?page=absensi&error=failed');
    }
}
?>
