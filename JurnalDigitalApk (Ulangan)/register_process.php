<?php
require_once 'includes/config.php';

if (isset($_POST['username'])) {
    $nama_lengkap = $_POST['nama_lengkap'];
    $username = $_POST['username'];
    $nis = $_POST['nis'];
    $kelas = $_POST['kelas'];
    $jurusan = $_POST['jurusan'];
    $id_industri = $_POST['id_industri'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    try {
        $pdo->beginTransaction();

        // 1. Insert into users table
        $stmt = $pdo->prepare("INSERT INTO users (username, password, nama_lengkap, role) VALUES (?, ?, ?, 'siswa')");
        $stmt->execute([$username, $password, $nama_lengkap]);
        $id_user = $pdo->lastInsertId();

        // 2. Insert into siswa table
        $stmt = $pdo->prepare("INSERT INTO siswa (nis, id_user, id_industri, kelas, jurusan) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$nis, $id_user, $id_industri, $kelas, $jurusan]);

        $pdo->commit();
        
        // Success redirect
        header("Location: login.php?success=registered");
        exit();

    } catch (Exception $e) {
        $pdo->rollBack();
        die("Error: " . $e->getMessage());
    }
} else {
    header("Location: register.php");
    exit();
}
?>
