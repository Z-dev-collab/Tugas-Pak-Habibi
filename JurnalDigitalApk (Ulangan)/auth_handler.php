<?php
require_once 'includes/config.php';

if (isset($_GET['mock_user'])) {
    $username = $_GET['mock_user'];
    $provider = $_GET['provider'];

    // In a real app, we would verify the OAuth token and find/create the user.
    // For this mock, we just fetch the user by username.
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user) {
        // Set sessions
        $_SESSION['user_id'] = $user['id_user'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['nama_lengkap'] = $user['nama_lengkap'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['foto_profil'] = $user['foto_profil'];
        $_SESSION['auth_provider'] = $provider;

        // Redirect based on role
        switch ($user['role']) {
            case 'siswa':
                redirect('siswa/dashboard.php?msg=welcome_social');
                break;
            case 'guru':
                redirect('guru/dashboard.php');
                break;
            case 'pembimbing_industri':
                redirect('pembimbing/dashboard.php');
                break;
            default:
                redirect('login.php');
        }
    } else {
        redirect('login.php?error=user_not_found');
    }
} else {
    redirect('login.php');
}
?>
