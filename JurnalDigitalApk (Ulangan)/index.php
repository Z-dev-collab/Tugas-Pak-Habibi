<?php
require_once 'includes/config.php';

// Access Control
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$page = $_GET['page'] ?? 'dashboard';
$role = $_SESSION['role'];

// Define Page Titles
$pageTitle = "Jurnal Digital";
switch ($page) {
    case 'dashboard': $pageTitle = "Dashboard"; break;
    case 'absensi': $pageTitle = "Absensi GPS"; break;
    case 'jurnal': $pageTitle = "Jurnal Harian"; break;
    case 'validasi': $pageTitle = "Validasi Jurnal"; break;
    case 'profil': $pageTitle = "Profil Saya"; break;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title><?= $pageTitle ?> - Prakerind Digital</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
    
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="app-container">
        <!-- Header (Like Kampus1) -->
        <header class="header">
            <div style="display: flex; align-items: center; gap: 15px; justify-content: space-between;">
                <div style="display: flex; align-items: center; gap: 12px;">
                    <div style="width: 45px; height: 45px; border-radius: 50%; background: rgba(255,255,255,0.2); display: flex; align-items: center; justify-content: center; border: 2px solid rgba(255,255,255,0.3);">
                        <img src="<?= $_SESSION['foto_profil'] ? 'uploads/profil/'.htmlspecialchars($_SESSION['foto_profil']) : 'https://ui-avatars.com/api/?name='.urlencode($_SESSION['nama_lengkap']).'&background=random' ?>" style="width: 100%; height: 100%; border-radius: 50%; object-fit: cover;">
                    </div>
                    <div>
                        <h2 style="font-size: 18px;"><?= htmlspecialchars(explode(' ', $_SESSION['nama_lengkap'])[0]) ?></h2>
                        <p style="font-size: 12px; opacity: 0.8;"><?= ucfirst($role) ?></p>
                    </div>
                </div>
                <a href="javascript:void(0)" onclick="confirmLogout()" style="color: white; opacity: 0.8;"><i data-lucide="log-out"></i></a>
            </div>
        </header>

        <!-- Main Content Area -->
        <main class="content">
            <?php
            // Routing Logic
            if ($role === 'siswa') {
                switch ($page) {
                    case 'dashboard': include 'siswa/dashboard.php'; break;
                    case 'absensi': include 'siswa/absensi.php'; break;
                    case 'jurnal': include 'siswa/jurnal.php'; break;
                    default: include 'siswa/dashboard.php'; break;
                }
            } else if ($role === 'pembimbing_industri') {
                switch ($page) {
                    case 'dashboard': include 'pembimbing/dashboard.php'; break;
                    case 'validasi': include 'pembimbing/dashboard.php'; break; // Integrated
                    default: include 'pembimbing/dashboard.php'; break;
                }
            } else {
                echo "<div class='glass-card'><p>Modul belum tersedia untuk role ini.</p></div>";
            }
            ?>
        </main>

        <!-- Bottom Navigation (Role-Based) -->
        <nav class="bottom-nav">
            <?php if ($role === 'siswa'): ?>
                <a href="index.php?page=dashboard" class="nav-item <?= ($page == 'dashboard') ? 'active' : '' ?>">
                    <i data-lucide="layout-dashboard"></i>
                    <span>Home</span>
                </a>
                <a href="index.php?page=absensi" class="nav-item <?= ($page == 'absensi') ? 'active' : '' ?>">
                    <i data-lucide="map-pin"></i>
                    <span>Absen</span>
                </a>
                <a href="index.php?page=jurnal" class="nav-item <?= ($page == 'jurnal') ? 'active' : '' ?>">
                    <i data-lucide="book-open"></i>
                    <span>Jurnal</span>
                </a>
                <a href="index.php?page=profil" class="nav-item <?= ($page == 'profil') ? 'active' : '' ?>">
                    <i data-lucide="user"></i>
                    <span>Profil</span>
                </a>
            <?php elseif ($role === 'pembimbing_industri'): ?>
                <a href="index.php?page=dashboard" class="nav-item <?= ($page == 'dashboard') ? 'active' : '' ?>">
                    <i data-lucide="layout-dashboard"></i>
                    <span>Home</span>
                </a>
                <a href="index.php?page=validasi" class="nav-item <?= ($page == 'validasi') ? 'active' : '' ?>">
                    <i data-lucide="clipboard-list"></i>
                    <span>Validasi</span>
                </a>
                <a href="index.php?page=rekap" class="nav-item">
                    <i data-lucide="file-text"></i>
                    <span>Rekap</span>
                </a>
                <a href="index.php?page=profil" class="nav-item">
                    <i data-lucide="settings"></i>
                    <span>Setel</span>
                </a>
            <?php endif; ?>
        </nav>
    </div>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
      lucide.createIcons();

      function confirmLogout() {
          Swal.fire({
              title: 'Keluar?',
              text: "Anda akan keluar dari sesi ini.",
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#2563eb',
              cancelButtonColor: '#64748b',
              confirmButtonText: 'Ya, Keluar!',
              cancelButtonText: 'Batal',
              customClass: {
                  popup: 'rounded-2xl'
              }
          }).then((result) => {
              if (result.isConfirmed) {
                  window.location.href = 'logout.php';
              }
          })
      }
    </script>
</body>
</html>
