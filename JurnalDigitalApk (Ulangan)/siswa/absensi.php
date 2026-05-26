<?php 
$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT s.*, i.nama_industri, i.latitude as dest_lat, i.longitude as dest_lng, i.radius_meter 
                       FROM siswa s 
                       JOIN industri i ON s.id_industri = i.id_industri 
                       WHERE s.id_user = ?");
$stmt->execute([$user_id]);
$siswa = $stmt->fetch();
?>

<style>
    #map-placeholder {
        width: 100%;
        height: 200px;
        background: #f8fafc;
        border-radius: var(--radius-md);
        margin-bottom: 24px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        color: var(--text-muted);
        border: 2px dashed #e2e8f0;
    }
    .loc-detail {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 12px;
        font-size: 14px;
    }
</style>

<div class="glass-card">
    <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 20px;">
        <a href="index.php?page=dashboard" style="color: var(--text-main);"><i data-lucide="arrow-left"></i></a>
        <h3 style="font-size: 18px; font-weight: 700;">Check-in Lokasi</h3>
    </div>

    <div id="map-placeholder">
        <i data-lucide="map-pin" style="width: 48px; height: 48px; color: var(--primary); margin-bottom: 15px; opacity: 0.5;"></i>
        <p id="status-text" style="font-weight: 500;">Mencari koordinat...</p>
    </div>

    <div class="loc-detail">
        <i data-lucide="building" style="color: var(--primary); width: 18px;"></i>
        <span>Target: <strong><?= $siswa['nama_industri'] ?></strong></span>
    </div>
    <div class="loc-detail">
        <i data-lucide="navigation" id="dist-icon" style="color: var(--text-muted); width: 18px;"></i>
        <span id="distance-text">Menghitung jarak...</span>
    </div>

    <form id="absen-form" action="siswa/proses_absen.php" method="POST" style="margin-top: 25px;">
        <input type="hidden" name="lat" id="lat-input">
        <input type="hidden" name="lng" id="lng-input">
        <button type="submit" id="btn-absen" class="btn-primary" disabled>
            <i data-lucide="fingerprint" style="width: 20px;"></i>
            <span>Kirim Absensi</span>
        </button>
    </form>
</div>

<script>
    // Ensure icons are created for the dynamic content
    lucide.createIcons();
    
    const destLat = <?= $siswa['dest_lat'] ?>;
    const destLng = <?= $siswa['dest_lng'] ?>;
    const radius = <?= $siswa['radius_meter'] ?>;

    function calculateDistance(lat1, lon1, lat2, lon2) {
        const R = 6371e3; 
        const φ1 = lat1 * Math.PI/180;
        const φ2 = lat2 * Math.PI/180;
        const Δφ = (lat2-lat1) * Math.PI/180;
        const Δλ = (lon2-lon1) * Math.PI/180;
        const a = Math.sin(Δφ/2) * Math.sin(Δφ/2) + Math.cos(φ1) * Math.cos(φ2) * Math.sin(Δλ/2) * Math.sin(Δλ/2);
        const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
        return R * c; 
    }

    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(position => {
            const userLat = position.coords.latitude;
            const userLng = position.coords.longitude;
            document.getElementById('lat-input').value = userLat;
            document.getElementById('lng-input').value = userLng;
            
            const distance = calculateDistance(userLat, userLng, destLat, destLng);
            document.getElementById('status-text').innerHTML = "Lokasi Berhasil Dikunci";
            document.getElementById('distance-text').innerHTML = `Jarak: <strong>${Math.round(distance)} meter</strong>`;
            
            if (distance <= radius) {
                document.getElementById('btn-absen').disabled = false;
                document.getElementById('dist-icon').style.color = "var(--success)";
            } else {
                document.getElementById('status-text').innerHTML = "Di Luar Radius!";
                document.getElementById('status-text').style.color = "var(--danger)";
                document.getElementById('dist-icon').style.color = "var(--danger)";
            }
        }, error => {
            document.getElementById('status-text').innerHTML = "Akses Lokasi Ditolak";
        }, { enableHighAccuracy: true });
    }
</script>
