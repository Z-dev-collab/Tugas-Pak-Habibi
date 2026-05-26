<?php 
$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT * FROM jurnal_harian WHERE id_user = ? ORDER BY tanggal DESC");
$stmt->execute([$user_id]);
$journals = $stmt->fetchAll();
?>

<style>
    .fab {
        position: fixed;
        bottom: 100px;
        right: 24px;
        width: 60px;
        height: 60px;
        background: var(--primary);
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 10px 25px rgba(37, 99, 235, 0.4);
        z-index: 1000;
        text-decoration: none;
    }
    .modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.6);
        backdrop-filter: blur(5px);
        z-index: 2000;
        padding: 24px;
    }
    .modal-content {
        background: white;
        border-radius: var(--radius-lg);
        padding: 28px;
        max-width: 420px;
        margin: 40px auto;
        position: relative;
    }
</style>

<div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px;">
    <h3 style="font-size: 18px; font-weight: 700;">Riwayat Jurnal</h3>
</div>

<?php foreach($journals as $j): ?>
<div class="data-card">
    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 12px;">
        <div>
            <p style="font-size: 12px; color: var(--text-muted); font-weight: 500;"><?= date('l, d M Y', strtotime($j['tanggal'])) ?></p>
            <h4 style="margin-top: 4px;"><?= htmlspecialchars($j['kompetensi_dasar']) ?></h4>
        </div>
        <span class="badge badge-<?= ($j['status_validasi'] == 'approved') ? 'success' : (($j['status_validasi'] == 'pending') ? 'pending' : 'danger') ?>">
            <?= htmlspecialchars($j['status_validasi']) ?>
        </span>
    </div>
    <p style="font-size: 14px; line-height: 1.6; color: var(--text-main); margin-bottom: 15px;"><?= htmlspecialchars($j['kegiatan']) ?></p>
    <?php if($j['foto_kegiatan']): ?>
        <img src="uploads/jurnal/<?= htmlspecialchars($j['foto_kegiatan']) ?>" style="width: 100%; height: 180px; object-fit: cover; border-radius: var(--radius-md); margin-bottom: 15px;">
    <?php endif; ?>
    <?php if($j['catatan_pembimbing']): ?>
        <div style="background: #f8fafc; border-left: 4px solid var(--primary); padding: 12px; border-radius: 8px; font-size: 13px;">
            <p style="color: var(--text-muted); margin-bottom: 4px; font-weight: 600; font-size: 11px; text-transform: uppercase;">Catatan Pembimbing:</p>
            <p><?= htmlspecialchars($j['catatan_pembimbing']) ?></p>
        </div>
    <?php endif; ?>
</div>
<?php endforeach; ?>

<?php if(empty($journals)): ?>
    <div style="text-align: center; padding: 60px 20px;">
        <i data-lucide="book-x" style="width: 60px; height: 60px; color: #e2e8f0; margin-bottom: 20px;"></i>
        <p style="color: var(--text-muted);">Belum ada catatan kegiatan.</p>
    </div>
<?php endif; ?>

<a href="javascript:void(0)" class="fab" id="open-modal">
    <i data-lucide="plus"></i>
</a>

<!-- Modal Form -->
<div class="modal" id="journal-modal">
    <div class="modal-content">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
            <h3 style="font-size: 20px; font-weight: 700;">Tambah Jurnal</h3>
            <a href="javascript:void(0)" id="close-modal" style="color: var(--text-muted);"><i data-lucide="x"></i></a>
        </div>
        <form action="siswa/proses_jurnal.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label>Tanggal</label>
                <input type="date" name="tanggal" class="form-control" value="<?= date('Y-m-d') ?>" required>
            </div>
            <div class="form-group">
                <label>Kompetensi Dasar</label>
                <input type="text" name="kompetensi" class="form-control" placeholder="Contoh: Pemrograman Web" required>
            </div>
            <div class="form-group">
                <label>Kegiatan</label>
                <textarea name="kegiatan" class="form-control" placeholder="Apa yang anda kerjakan hari ini?" required></textarea>
            </div>
            <div class="form-group">
                <label>Foto Bukti (Opsional)</label>
                <input type="file" name="foto" class="form-control" accept="image/*">
            </div>
            <button type="submit" name="submit" class="btn-primary">
                <span>Simpan Jurnal</span>
                <i data-lucide="check" style="width: 20px;"></i>
            </button>
        </form>
    </div>
</div>

<script>
    lucide.createIcons();
    const modal = document.getElementById('journal-modal');
    document.getElementById('open-modal').onclick = () => modal.style.display = 'block';
    document.getElementById('close-modal').onclick = () => modal.style.display = 'none';
    window.onclick = (e) => { if(e.target == modal) modal.style.display = 'none'; }
</script>
