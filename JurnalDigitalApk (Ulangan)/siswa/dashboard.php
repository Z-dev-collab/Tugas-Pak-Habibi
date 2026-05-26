<?php 
// No need for config or checkLogin as they are in index.php
$user_id = $_SESSION['user_id'];

// Get Student Data
$stmt = $pdo->prepare("SELECT s.*, i.nama_industri, i.nama_instruktur, i.latitude, i.longitude, i.radius_meter 
                       FROM siswa s 
                       JOIN industri i ON s.id_industri = i.id_industri 
                       WHERE s.id_user = ?");
$stmt->execute([$user_id]);
$siswa = $stmt->fetch();

// Get Attendance for today
$today = date('Y-m-d');
$stmt = $pdo->prepare("SELECT * FROM absensi WHERE id_user = ? AND tanggal = ?");
$stmt->execute([$user_id, $today]);
$absen_today = $stmt->fetch();

// Get Recent Journals
$stmt = $pdo->prepare("SELECT * FROM jurnal_harian WHERE id_user = ? ORDER BY tanggal DESC LIMIT 3");
$stmt->execute([$user_id]);
$journals = $stmt->fetchAll();

// Hitung statistik dari database (bukan hardcoded)
$stmt = $pdo->prepare("SELECT COUNT(*) as total FROM absensi WHERE id_user = ? AND status_kehadiran = 'hadir'");
$stmt->execute([$user_id]);
$total_hadir = $stmt->fetch()['total'];

$stmt = $pdo->prepare("SELECT COUNT(*) as total FROM jurnal_harian WHERE id_user = ? AND status_validasi = 'approved'");
$stmt->execute([$user_id]);
$total_jurnal_valid = $stmt->fetch()['total'];
?>

<style>
    .stats-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
        margin-bottom: 24px;
    }
    .stat-item {
        background: white;
        padding: 20px;
        border-radius: var(--radius-md);
        box-shadow: var(--shadow-sm);
        border: 1px solid #f1f5f9;
        position: relative;
        overflow: hidden;
    }
    .stat-item h3 { font-size: 22px; margin-top: 10px; }
    .stat-item p { font-size: 11px; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px; }
    
    .journal-row {
        display: flex;
        align-items: center;
        gap: 15px;
        padding: 15px 0;
        border-bottom: 1px solid #f1f5f9;
    }
    .journal-row:last-child { border-bottom: none; }
</style>

<!-- Stats Grid -->
<div class="stats-grid">
    <div class="stat-item">
        <p>Total Hadir</p>
        <h3><?= $total_hadir ?> Hari</h3>
        <i data-lucide="calendar-check" style="color: var(--primary); position: absolute; right: 10px; bottom: 10px; opacity: 0.1; width: 50px; height: 50px;"></i>
    </div>
    <div class="stat-item">
        <p>Jurnal Valid</p>
        <h3><?= $total_jurnal_valid ?></h3>
        <i data-lucide="file-check" style="color: var(--success); position: absolute; right: 10px; bottom: 10px; opacity: 0.1; width: 50px; height: 50px;"></i>
    </div>
</div>

<!-- Attendance Status Card -->
<div class="glass-card" style="padding: 20px;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
        <h4 style="font-size: 16px; font-weight: 700;">Absensi Hari Ini</h4>
        <span class="badge badge-<?= $absen_today ? 'success' : 'warning' ?>">
            <?= $absen_today ? 'Hadir' : 'Belum Absen' ?>
        </span>
    </div>
    <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 20px;">
        <i data-lucide="map-pin" style="color: var(--danger); width: 20px;"></i>
        <span style="font-size: 14px; color: var(--text-muted);"><?= htmlspecialchars($siswa['nama_industri']) ?></span>
    </div>
    
    <?php if (!$absen_today): ?>
        <a href="index.php?page=absensi" class="btn-primary">
            <i data-lucide="fingerprint" style="width: 20px;"></i>
            <span>Check In Sekarang</span>
        </a>
    <?php else: ?>
        <div style="text-align: center; background: #f0fdf4; padding: 12px; border-radius: 12px; border: 1px solid #dcfce7;">
            <p style="font-size: 13px; color: #15803d; font-weight: 600;">
                <i data-lucide="check-circle" style="width: 16px; vertical-align: middle;"></i> 
                Absen masuk: <?= htmlspecialchars($absen_today['jam_masuk']) ?>
            </p>
        </div>
    <?php endif; ?>
</div>

<!-- Recent Journal -->
<div style="display: flex; justify-content: space-between; align-items: center; margin: 10px 0 15px;">
    <h4 style="font-size: 16px; font-weight: 700; display: flex; align-items: center; gap: 8px;">
        <i data-lucide="book-open" style="width: 18px; color: var(--primary);"></i>
        Jurnal Terbaru
    </h4>
    <a href="index.php?page=jurnal" style="font-size: 12px; font-weight: 600; color: var(--primary); text-decoration: none;">Lihat Semua</a>
</div>

<div class="glass-card" style="padding: 0 20px;">
    <?php foreach($journals as $j): ?>
    <div class="journal-row">
        <div style="flex: 1;">
            <p style="font-weight: 600; font-size: 14px;"><?= htmlspecialchars(substr($j['kegiatan'], 0, 35)) ?>...</p>
            <p style="font-size: 12px; color: var(--text-muted);"><?= date('d M Y', strtotime($j['tanggal'])) ?></p>
        </div>
        <span class="badge badge-<?= ($j['status_validasi'] == 'approved') ? 'success' : (($j['status_validasi'] == 'pending') ? 'pending' : 'danger') ?>">
            <?= htmlspecialchars($j['status_validasi']) ?>
        </span>
    </div>
    <?php endforeach; ?>
    <?php if(empty($journals)): ?>
        <p style="text-align: center; color: var(--text-muted); padding: 20px; font-size: 14px;">Belum ada jurnal.</p>
    <?php endif; ?>
</div>
