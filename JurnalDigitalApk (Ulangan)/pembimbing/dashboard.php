<?php 
$user_id = $_SESSION['user_id'];

// Get Industry linked to this mentor
$stmt = $pdo->prepare("SELECT id_industri, nama_industri FROM industri WHERE nama_instruktur = ?");
$stmt->execute([$_SESSION['nama_lengkap']]);
$industri = $stmt->fetch();

// Get Pending Journals for students in this industry
$pending_journals = [];
if ($industri) {
    $stmt = $pdo->prepare("SELECT j.*, u.nama_lengkap 
                           FROM jurnal_harian j 
                           JOIN siswa s ON j.id_user = s.id_user 
                           JOIN users u ON s.id_user = u.id_user 
                           WHERE s.id_industri = ? AND j.status_validasi = 'pending'
                           ORDER BY j.tanggal ASC");
    $stmt->execute([$industri['id_industri']]);
    $pending_journals = $stmt->fetchAll();
}
?>

<div class="glass-card" style="background: linear-gradient(135deg, var(--primary), var(--primary-dark)); color: white; padding: 20px;">
    <p style="font-size: 11px; opacity: 0.8; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 4px;">Industri Mitra</p>
    <h3 style="font-size: 18px; font-weight: 700;"><?= $industri ? htmlspecialchars($industri['nama_industri']) : 'Belum Terhubung' ?></h3>
</div>

<h4 style="font-size: 16px; font-weight: 700; margin-bottom: 16px; display: flex; align-items: center; gap: 10px;">
    <i data-lucide="clipboard-list" style="width: 18px; color: var(--primary);"></i>
    Validasi Jurnal (<?= count($pending_journals) ?>)
</h4>

<?php foreach($pending_journals as $j): ?>
<div class="data-card">
    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 12px;">
        <div>
            <h4 style="margin-bottom: 2px; color: var(--primary);"><?= htmlspecialchars($j['nama_lengkap']) ?></h4>
            <p style="font-size: 11px; color: var(--text-muted);"><?= date('d M Y', strtotime($j['tanggal'])) ?></p>
        </div>
        <span class="badge badge-pending">Pending</span>
    </div>
    <p style="font-size: 14px; margin-bottom: 15px;"><strong>KD:</strong> <?= htmlspecialchars($j['kompetensi_dasar']) ?><br><?= htmlspecialchars($j['kegiatan']) ?></p>
    
    <form action="pembimbing/proses_validasi.php" method="POST">
        <input type="hidden" name="id_jurnal" value="<?= $j['id_jurnal'] ?>">
        <input type="text" name="catatan" class="form-control" placeholder="Tulis catatan (opsional)" style="margin-bottom: 12px; padding: 10px 15px; font-size: 13px;">
        <div style="display: flex; gap: 10px;">
            <button type="submit" name="action" value="approved" class="btn-primary" style="background: var(--success); flex: 1; padding: 12px; font-size: 14px;">
                <i data-lucide="check" style="width: 18px;"></i> Setuju
            </button>
            <button type="submit" name="action" value="rejected" class="btn-primary" style="background: var(--danger); flex: 1; padding: 12px; font-size: 14px;">
                <i data-lucide="x" style="width: 18px;"></i> Tolak
            </button>
        </div>
    </form>
</div>
<?php endforeach; ?>

<?php if(empty($pending_journals)): ?>
    <div style="text-align: center; padding: 60px 20px;">
        <div style="width: 70px; height: 70px; background: #f0fdf4; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 15px;">
            <i data-lucide="check-circle-2" style="width: 35px; height: 35px; color: var(--success);"></i>
        </div>
        <p style="color: var(--text-muted); font-size: 14px;">Semua jurnal sudah divalidasi!</p>
    </div>
<?php endif; ?>

<script>lucide.createIcons();</script>
