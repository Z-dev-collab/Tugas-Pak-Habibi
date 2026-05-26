<?php 
require_once 'includes/config.php'; 
$provider = isset($_GET['provider']) ? $_GET['provider'] : 'google';
$brand_color = ($provider == 'google') ? '#4285F4' : '#1877F2';
$brand_name = ucfirst($provider);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login with <?php echo $brand_name; ?></title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background: #f1f5f9; display: flex; align-items: center; justify-content: center; height: 100vh; }
        .mock-card {
            width: 100%;
            max-width: 400px;
            padding: 40px;
            text-align: center;
            border-top: 5px solid <?php echo $brand_color; ?>;
        }
        .provider-logo {
            font-size: 3rem;
            color: <?php echo $brand_color; ?>;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="card mock-card fade-in-up">
        <div class="provider-logo">
            <?php if($provider == 'google'): ?>
                <img src="https://upload.wikimedia.org/wikipedia/commons/5/53/Google_%22G%22_Logo.svg" width="60">
            <?php else: ?>
                <i class="fab fa-facebook"></i>
            <?php endif; ?>
        </div>
        <h2 style="margin-bottom: 10px;">Sign in with <?php echo $brand_name; ?></h2>
        <p style="color: var(--text-muted); margin-bottom: 30px;">Choose an account to continue to <strong>Prakerind Digital</strong></p>
        
        <div style="display: flex; flex-direction: column; gap: 10px;">
            <!-- Simulation: Clicking this will log you in as a default student -->
            <a href="auth_handler.php?mock_user=siswa1&provider=<?php echo $provider; ?>" class="btn-social" style="text-align: left; padding: 15px; border: 1px solid #e2e8f0; border-radius: 12px; display: flex; align-items: center; gap: 15px; text-decoration: none; color: inherit;">
                <img src="https://ui-avatars.com/api/?name=Budi+Santoso&background=random" style="width: 40px; height: 40px; border-radius: 50%;">
                <div>
                    <p style="font-weight: 600; font-size: 0.95rem;">Budi Santoso</p>
                    <p style="font-size: 0.8rem; color: var(--text-muted);">budi.santoso@gmail.com</p>
                </div>
            </a>
            
            <a href="#" class="btn-social" style="text-align: left; padding: 15px; border: 1px solid #e2e8f0; border-radius: 12px; display: flex; align-items: center; gap: 15px; text-decoration: none; color: inherit; opacity: 0.6;">
                <i class="fas fa-user-circle" style="font-size: 2.5rem; color: #cbd5e1;"></i>
                <div>
                    <p style="font-weight: 600; font-size: 0.95rem;">Use another account</p>
                </div>
            </a>
        </div>
        
        <div style="margin-top: 40px; font-size: 0.8rem; color: var(--text-muted);">
            To continue, <?php echo $brand_name; ?> will share your name, email address, and profile picture with Prakerind Digital.
        </div>
    </div>
</body>
</html>
