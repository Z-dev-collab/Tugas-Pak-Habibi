<?php 
require_once 'includes/config.php'; 

// Fetch Industries for selection
$stmt = $pdo->query("SELECT id_industri, nama_industri FROM industri");
$industries = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Daftar - Jurnal Digital Prakerind</title>
    
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
        <!-- Header -->
        <header class="header">
            <div style="display: flex; align-items: center; gap: 15px;">
                <a href="login.php" style="color: white; margin-right: 5px;"><i data-lucide="chevron-left"></i></a>
                <div>
                    <h2>Registrasi</h2>
                    <p>Buat akun siswa baru</p>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="content">
            <div class="glass-card">
                <form id="registerForm" action="register_process.php" method="POST">
                    <div class="form-group">
                        <label>Nama Lengkap</label>
                        <input type="text" name="nama_lengkap" class="form-control" placeholder="Nama sesuai KTP/Kartu Pelajar" required>
                    </div>
                    
                    <div class="form-group">
                        <label>Username</label>
                        <input type="text" name="username" class="form-control" placeholder="Pilih username unik" required>
                    </div>

                    <div class="form-group">
                        <label>NIS (Nomor Induk Siswa)</label>
                        <input type="text" name="nis" class="form-control" placeholder="Masukkan NIS anda" required>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                        <div class="form-group">
                            <label>Kelas</label>
                            <input type="text" name="kelas" class="form-control" placeholder="Contoh: XII-RPL-1" required>
                        </div>
                        <div class="form-group">
                            <label>Jurusan</label>
                            <input type="text" name="jurusan" class="form-control" placeholder="Contoh: RPL" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Tempat Industri (Mitra)</label>
                        <select name="id_industri" class="form-control" required>
                            <option value="">-- Pilih Industri --</option>
                            <?php foreach($industries as $i): ?>
                                <option value="<?php echo $i['id_industri']; ?>"><?php echo $i['nama_industri']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Password</label>
                        <div class="password-wrapper">
                            <input type="password" name="password" id="password" class="form-control" placeholder="Minimal 6 karakter" required>
                            <div class="toggle-password" onclick="togglePassword('password', this)">
                                <i data-lucide="eye" style="width: 20px;"></i>
                            </div>
                        </div>
                    </div>

                    <button type="submit" name="register" class="btn-primary" id="btnSubmit">
                        <span>Daftar Akun</span>
                        <i data-lucide="user-plus" id="btnIcon" style="width: 20px; height: 20px;"></i>
                    </button>
                </form>

                <div class="divider">Atau daftar dengan</div>

                <div class="social-login">
                    <a href="https://accounts.google.com/o/oauth2/v2/auth?client_id=<?php echo GOOGLE_CLIENT_ID; ?>&redirect_uri=<?php echo GOOGLE_REDIRECT_URI; ?>&response_type=code&scope=email%20profile&access_type=offline&prompt=select_account" class="btn-social">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/5/53/Google_%22G%22_Logo.svg" width="20">
                        <span>Google</span>
                    </a>
                </div>

                <div style="margin-top: 30px; text-align: center; color: var(--text-muted); font-size: 14px;">
                    Sudah punya akun? <a href="login.php" style="color: var(--primary); text-decoration: none; font-weight: 700;">Masuk</a>
                </div>
            </div>
        </main>
    </div>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
      lucide.createIcons();

      function togglePassword(id, el) {
          const input = document.getElementById(id);
          const icon = el.querySelector('i');
          if (input.type === 'password') {
              input.type = 'text';
              icon.setAttribute('data-lucide', 'eye-off');
          } else {
              input.type = 'password';
              icon.setAttribute('data-lucide', 'eye');
          }
          lucide.createIcons();
      }

      const registerForm = document.getElementById('registerForm');
      const btnSubmit = document.getElementById('btnSubmit');
      const btnIcon = document.getElementById('btnIcon');
      const btnText = btnSubmit.querySelector('span');

      registerForm.addEventListener('submit', function() {
          btnSubmit.disabled = true;
          btnText.innerText = 'Memproses...';
          btnIcon.outerHTML = '<div class="spinner"></div>';
      });
    </script>
</body>
</html>
