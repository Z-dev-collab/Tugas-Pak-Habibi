<?php require_once 'includes/config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Login - Jurnal Digital Prakerind</title>
    
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
                <div style="width: 50px; height: 50px; border-radius: 15px; background: rgba(255,255,255,0.2); display: flex; align-items: center; justify-content: center;">
                    <i data-lucide="book-bookmark" style="width: 28px; height: 28px;"></i>
                </div>
                <div>
                    <h2>Prakerind</h2>
                    <p>Digital Journal & Monitoring</p>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="content">
            <div class="glass-card">
                <h3 style="font-size: 20px; font-weight: 700; margin-bottom: 8px;">Selamat Datang</h3>
                <p style="color: var(--text-muted); font-size: 14px; margin-bottom: 25px;">Silahkan masuk untuk melanjutkan</p>

                <?php if(isset($_GET['error'])): ?>
                    <div style="background: #fef2f2; color: #ef4444; padding: 12px; border-radius: 12px; margin-bottom: 20px; font-size: 13px; border: 1px solid #fee2e2;">
                        Username atau password salah!
                    </div>
                <?php endif; ?>

                <?php if(isset($_GET['success']) && $_GET['success'] == 'registered'): ?>
                    <div style="background: #f0fdf4; color: #15803d; padding: 12px; border-radius: 12px; margin-bottom: 20px; font-size: 13px; border: 1px solid #dcfce7;">
                        Pendaftaran berhasil! Silahkan login.
                    </div>
                <?php endif; ?>

                <form id="loginForm" action="auth_process.php" method="POST">
                    <div class="form-group">
                        <label>Username</label>
                        <input type="text" name="username" class="form-control" placeholder="Masukkan username" required>
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <div class="password-wrapper">
                            <input type="password" name="password" id="password" class="form-control" placeholder="Masukkan password" required>
                            <div class="toggle-password" onclick="togglePassword('password', this)">
                                <i data-lucide="eye" style="width: 20px;"></i>
                            </div>
                        </div>
                    </div>
                    <button type="submit" name="login" class="btn-primary" id="btnSubmit">
                        <span>Masuk Sekarang</span>
                        <i data-lucide="chevron-right" id="btnIcon" style="width: 20px; height: 20px;"></i>
                    </button>
                </form>
                
                <div class="divider">Atau masuk dengan</div>

                <div class="social-login">
                    <a href="https://accounts.google.com/o/oauth2/v2/auth?client_id=<?php echo GOOGLE_CLIENT_ID; ?>&redirect_uri=<?php echo GOOGLE_REDIRECT_URI; ?>&response_type=code&scope=email%20profile&access_type=offline&prompt=select_account" class="btn-social">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/5/53/Google_%22G%22_Logo.svg" width="20">
                        <span>Google</span>
                    </a>
                </div>
                
                <div style="margin-top: 30px; text-align: center; color: var(--text-muted); font-size: 14px;">
                    Belum punya akun? <a href="register.php" style="color: var(--primary); text-decoration: none; font-weight: 700;">Daftar</a>
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

      const loginForm = document.getElementById('loginForm');
      const btnSubmit = document.getElementById('btnSubmit');
      const btnIcon = document.getElementById('btnIcon');
      const btnText = btnSubmit.querySelector('span');

      loginForm.addEventListener('submit', function() {
          // We don't disable the button immediately to avoid form data issues in some browsers
          btnText.innerText = 'Memproses...';
          btnIcon.outerHTML = '<div class="spinner"></div>';
          
          // Optionally disable after a tiny delay
          setTimeout(() => { btnSubmit.disabled = true; }, 50);
      });

      // SweetAlert Notifications
      const urlParams = new URLSearchParams(window.location.search);
      if (urlParams.has('error')) {
          Swal.fire({
              icon: 'error',
              title: 'Login Gagal',
              text: 'Username atau password salah!',
              confirmButtonColor: '#2563eb',
              customClass: {
                  popup: 'rounded-2xl'
              }
          });
      }
      if (urlParams.get('success') === 'registered') {
          Swal.fire({
              icon: 'success',
              title: 'Pendaftaran Berhasil',
              text: 'Silahkan login dengan akun anda',
              confirmButtonColor: '#2563eb',
              customClass: {
                  popup: 'rounded-2xl'
              }
          });
      }
    </script>
</body>
</html>
