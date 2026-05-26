<?php
require_once 'includes/config.php';

if (isset($_POST['username'])) {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    // Debugging
    file_put_contents('login_debug.log', date('Y-m-d H:i:s') . " - Attempt: $username\n", FILE_APPEND);

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        file_put_contents('login_debug.log', date('Y-m-d H:i:s') . " - Success: $username\n", FILE_APPEND);
        // Set sessions
        $_SESSION['user_id'] = $user['id_user'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['nama_lengkap'] = $user['nama_lengkap'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['foto_profil'] = $user['foto_profil'];

        // Redirect to main index router
        redirect('index.php');
    } else {
        file_put_contents('login_debug.log', date('Y-m-d H:i:s') . " - Failed: $username (User found: " . ($user ? 'Yes' : 'No') . ")\n", FILE_APPEND);
        redirect('login.php?error=invalid');
    }
} else {
    file_put_contents('login_debug.log', date('Y-m-d H:i:s') . " - Post username not set\n", FILE_APPEND);
    redirect('login.php');
}
?>
