<?php
/**
 * Database Configuration
 * Jurnal Digital Prakerind
 */

require_once 'settings.php';

define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'db_jurnal_prakerind');

try {
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Start Session if not started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Global helper functions
function redirect($path) {
    header("Location: $path");
    exit();
}

function checkLogin() {
    if (!isset($_SESSION['user_id'])) {
        header("Location: /JurnalDigitalApk/login.php");
        exit();
    }
}

function checkRole($allowed_roles) {
    if (!isset($_SESSION['role']) || !in_array($_SESSION['role'], $allowed_roles)) {
        header("Location: /JurnalDigitalApk/index.php?error=unauthorized");
        exit();
    }
}
?>
