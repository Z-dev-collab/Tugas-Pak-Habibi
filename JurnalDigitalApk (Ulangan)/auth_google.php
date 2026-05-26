<?php
require_once 'includes/config.php';

/**
 * GOOGLE OAUTH CALLBACK HANDLER
 * This is where Google redirects after the user selects their account.
 */

if (isset($_GET['code'])) {
    $code = $_GET['code'];
    
    // 1. Configuration (Dikelola di includes/settings.php)
    $client_id = GOOGLE_CLIENT_ID;
    $client_secret = GOOGLE_CLIENT_SECRET;
    $redirect_uri = GOOGLE_REDIRECT_URI;

    // 2. Exchange Authorization Code for Access Token
    $token_url = 'https://oauth2.googleapis.com/token';
    $params = [
        'code' => $code,
        'client_id' => $client_id,
        'client_secret' => $client_secret,
        'redirect_uri' => $redirect_uri,
        'grant_type' => 'authorization_code'
    ];

    $ch = curl_init($token_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
    $response = curl_exec($ch);
    $data = json_decode($response, true);
    curl_close($ch);

    if (isset($data['access_token'])) {
        $access_token = $data['access_token'];

        // 3. Get User Info using the Access Token
        $info_url = 'https://www.googleapis.com/oauth2/v2/userinfo?access_token=' . $access_token;
        $info = json_decode(file_get_contents($info_url), true);

        if (isset($info['email'])) {
            $email = $info['email'];
            $name = $info['name'];
            $google_id = $info['id'];

            // 4. Find or Create User in Database
            // For now, we search by email (assuming it matches a username or we add an email column)
            // Or we check if this user has logged in with Google before.
            $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?"); // Mocking login by email prefix
            $stmt->execute([explode('@', $email)[0]]);
            $user = $stmt->fetch();

            if ($user) {
                $_SESSION['user_id'] = $user['id_user'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['nama_lengkap'] = $user['nama_lengkap'];
                $_SESSION['role'] = $user['role'];
                redirect('index.php');
            } else {
                // If user doesn't exist, redirect to register with data
                redirect('register.php?email=' . urlencode($email) . '&name=' . urlencode($name));
            }
        }
    } else {
        die("Error: Failed to get access token from Google. Make sure your Client ID and Secret are correct.");
    }
} else {
    redirect('login.php');
}
?>
