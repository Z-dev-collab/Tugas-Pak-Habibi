-- ============================================================
-- DATABASE: JURNAL DIGITAL PRAKERIND
-- Aplikasi Jurnal Digital untuk Praktek Kerja Industri (PKL)
-- ============================================================
-- Cara Import:
-- 1. Buka phpMyAdmin (http://localhost/phpmyadmin)
-- 2. Klik tab "Import" 
-- 3. Pilih file database.sql ini
-- 4. Klik "Go" / "Kirim"
-- ============================================================

-- Hapus database lama jika ada (hati-hati di production!)
DROP DATABASE IF EXISTS db_jurnal_prakerind;

-- Buat database baru
CREATE DATABASE db_jurnal_prakerind
    DEFAULT CHARACTER SET utf8mb4
    DEFAULT COLLATE utf8mb4_unicode_ci;

USE db_jurnal_prakerind;

-- ============================================================
-- 1. TABEL USERS (Kredensial & Role)
-- Menyimpan semua akun: siswa, guru, pembimbing industri, admin
-- ============================================================
CREATE TABLE users (
    id_user INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    nama_lengkap VARCHAR(100) NOT NULL,
    email VARCHAR(100) DEFAULT NULL,
    role ENUM('siswa', 'guru', 'pembimbing_industri', 'admin') NOT NULL,
    foto_profil VARCHAR(255) DEFAULT NULL,
    google_id VARCHAR(100) DEFAULT NULL COMMENT 'Untuk login via Google OAuth',
    is_active TINYINT(1) DEFAULT 1 COMMENT '1=Aktif, 0=Nonaktif',
    last_login DATETIME DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Index untuk pencarian cepat
CREATE INDEX idx_users_role ON users(role);
CREATE INDEX idx_users_google ON users(google_id);
CREATE INDEX idx_users_email ON users(email);

-- ============================================================
-- 2. TABEL INDUSTRI (Data Mitra & Geofencing)
-- Menyimpan data perusahaan mitra PKL beserta koordinat GPS
-- ============================================================
CREATE TABLE industri (
    id_industri INT PRIMARY KEY AUTO_INCREMENT,
    nama_industri VARCHAR(100) NOT NULL,
    alamat_industri TEXT,
    kota VARCHAR(50) DEFAULT NULL,
    telepon VARCHAR(20) DEFAULT NULL,
    email VARCHAR(100) DEFAULT NULL,
    nama_instruktur VARCHAR(100) COMMENT 'Nama pembimbing di industri',
    bidang_usaha VARCHAR(100) DEFAULT NULL COMMENT 'Bidang/sektor industri',
    latitude DOUBLE NOT NULL COMMENT 'Koordinat latitude untuk geofencing',
    longitude DOUBLE NOT NULL COMMENT 'Koordinat longitude untuk geofencing',
    radius_meter INT DEFAULT 100 COMMENT 'Radius geofencing dalam meter',
    is_active TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE INDEX idx_industri_nama ON industri(nama_industri);
CREATE INDEX idx_industri_active ON industri(is_active);

-- ============================================================
-- 3. TABEL SISWA (Detail Profil & Relasi)
-- Menyimpan data detail siswa yang menjalani PKL
-- ============================================================
CREATE TABLE siswa (
    nis VARCHAR(20) PRIMARY KEY COMMENT 'Nomor Induk Siswa',
    id_user INT NOT NULL,
    id_industri INT DEFAULT NULL COMMENT 'Tempat PKL',
    id_guru INT DEFAULT NULL COMMENT 'ID User guru pembimbing sekolah',
    kelas VARCHAR(20) NOT NULL,
    jurusan VARCHAR(50) NOT NULL,
    no_hp VARCHAR(15) DEFAULT NULL,
    alamat TEXT DEFAULT NULL,
    tanggal_mulai DATE DEFAULT NULL COMMENT 'Tanggal mulai PKL',
    tanggal_selesai DATE DEFAULT NULL COMMENT 'Tanggal selesai PKL',
    status_pkl ENUM('belum_mulai', 'aktif', 'selesai') DEFAULT 'aktif',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_user) REFERENCES users(id_user) ON DELETE CASCADE,
    FOREIGN KEY (id_industri) REFERENCES industri(id_industri) ON DELETE SET NULL,
    FOREIGN KEY (id_guru) REFERENCES users(id_user) ON DELETE SET NULL
) ENGINE=InnoDB;

CREATE INDEX idx_siswa_industri ON siswa(id_industri);
CREATE INDEX idx_siswa_guru ON siswa(id_guru);
CREATE INDEX idx_siswa_status ON siswa(status_pkl);

-- ============================================================
-- 4. TABEL JURNAL HARIAN (Log Kegiatan PKL)
-- Menyimpan catatan harian kegiatan siswa selama PKL
-- ============================================================
CREATE TABLE jurnal_harian (
    id_jurnal INT PRIMARY KEY AUTO_INCREMENT,
    id_user INT NOT NULL COMMENT 'ID User siswa',
    tanggal DATE NOT NULL,
    kegiatan TEXT NOT NULL COMMENT 'Deskripsi kegiatan yang dilakukan',
    foto_kegiatan VARCHAR(255) DEFAULT NULL COMMENT 'Nama file foto bukti',
    kompetensi_dasar VARCHAR(255) DEFAULT NULL COMMENT 'KD yang relevan',
    status_validasi ENUM('pending', 'approved', 'rejected') DEFAULT 'pending',
    catatan_pembimbing TEXT DEFAULT NULL COMMENT 'Feedback dari pembimbing',
    validated_by INT DEFAULT NULL COMMENT 'ID User pembimbing yang memvalidasi',
    validated_at DATETIME DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_user) REFERENCES users(id_user) ON DELETE CASCADE,
    FOREIGN KEY (validated_by) REFERENCES users(id_user) ON DELETE SET NULL
) ENGINE=InnoDB;

-- Index untuk query yang sering digunakan
CREATE INDEX idx_jurnal_user ON jurnal_harian(id_user);
CREATE INDEX idx_jurnal_tanggal ON jurnal_harian(tanggal);
CREATE INDEX idx_jurnal_status ON jurnal_harian(status_validasi);
CREATE INDEX idx_jurnal_user_tanggal ON jurnal_harian(id_user, tanggal);

-- ============================================================
-- 5. TABEL ABSENSI (GPS Tracking & Presensi)
-- Menyimpan data kehadiran siswa dengan validasi lokasi GPS
-- ============================================================
CREATE TABLE absensi (
    id_absen INT PRIMARY KEY AUTO_INCREMENT,
    id_user INT NOT NULL,
    tanggal DATE NOT NULL,
    jam_masuk TIME DEFAULT NULL COMMENT 'Waktu check-in',
    jam_pulang TIME DEFAULT NULL COMMENT 'Waktu check-out',
    lat_checkin DOUBLE DEFAULT NULL COMMENT 'Latitude saat check-in',
    long_checkin DOUBLE DEFAULT NULL COMMENT 'Longitude saat check-in',
    lat_checkout DOUBLE DEFAULT NULL COMMENT 'Latitude saat check-out',
    long_checkout DOUBLE DEFAULT NULL COMMENT 'Longitude saat check-out',
    foto_checkin VARCHAR(255) DEFAULT NULL COMMENT 'Foto selfie saat check-in',
    status_kehadiran ENUM('hadir', 'izin', 'sakit', 'alpa') DEFAULT 'hadir',
    keterangan TEXT DEFAULT NULL COMMENT 'Alasan izin/sakit',
    is_dalam_radius TINYINT(1) DEFAULT 1 COMMENT '1=Dalam radius, 0=Di luar radius',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_user) REFERENCES users(id_user) ON DELETE CASCADE,
    -- Satu siswa hanya boleh absen 1x per hari
    UNIQUE KEY unique_absen_harian (id_user, tanggal)
) ENGINE=InnoDB;

CREATE INDEX idx_absen_user ON absensi(id_user);
CREATE INDEX idx_absen_tanggal ON absensi(tanggal);
CREATE INDEX idx_absen_user_tanggal ON absensi(id_user, tanggal);
CREATE INDEX idx_absen_status ON absensi(status_kehadiran);

-- ============================================================
-- 6. TABEL NOTIFIKASI (Pemberitahuan)
-- Menyimpan notifikasi untuk semua pengguna
-- ============================================================
CREATE TABLE notifikasi (
    id_notif INT PRIMARY KEY AUTO_INCREMENT,
    id_user INT NOT NULL COMMENT 'Penerima notifikasi',
    judul VARCHAR(100) NOT NULL,
    pesan TEXT NOT NULL,
    tipe ENUM('info', 'success', 'warning', 'danger') DEFAULT 'info',
    is_read TINYINT(1) DEFAULT 0 COMMENT '0=Belum dibaca, 1=Sudah dibaca',
    link VARCHAR(255) DEFAULT NULL COMMENT 'URL tujuan saat diklik',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_user) REFERENCES users(id_user) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE INDEX idx_notif_user ON notifikasi(id_user);
CREATE INDEX idx_notif_read ON notifikasi(id_user, is_read);

-- ============================================================
-- 7. TABEL PENGATURAN (App Settings)
-- Menyimpan konfigurasi global aplikasi
-- ============================================================
CREATE TABLE pengaturan (
    id_setting INT PRIMARY KEY AUTO_INCREMENT,
    setting_key VARCHAR(50) UNIQUE NOT NULL,
    setting_value TEXT NOT NULL,
    keterangan VARCHAR(255) DEFAULT NULL,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ============================================================
-- 8. TABEL LOG AKTIVITAS (Audit Trail)
-- Mencatat semua aktivitas penting di sistem
-- ============================================================
CREATE TABLE log_aktivitas (
    id_log INT PRIMARY KEY AUTO_INCREMENT,
    id_user INT DEFAULT NULL,
    aksi VARCHAR(100) NOT NULL COMMENT 'Jenis aksi: login, logout, create_jurnal, dll',
    detail TEXT DEFAULT NULL COMMENT 'Detail tambahan',
    ip_address VARCHAR(45) DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_user) REFERENCES users(id_user) ON DELETE SET NULL
) ENGINE=InnoDB;

CREATE INDEX idx_log_user ON log_aktivitas(id_user);
CREATE INDEX idx_log_aksi ON log_aktivitas(aksi);
CREATE INDEX idx_log_tanggal ON log_aktivitas(created_at);


-- ============================================================
-- ============================================================
--                    DATA AWAL (SEED DATA)
-- ============================================================
-- ============================================================
-- Password default untuk semua akun: "password"
-- Hash bcrypt: $2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi

-- ============================================================
-- DATA USERS
-- ============================================================
INSERT INTO users (username, password, nama_lengkap, email, role) VALUES 
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Administrator', 'admin@jurnaldigital.id', 'admin'),
('siswa1', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Budi Santoso', 'budi@siswa.id', 'siswa'),
('siswa2', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Siti Nurhaliza', 'siti@siswa.id', 'siswa'),
('siswa3', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Ahmad Rizky', 'ahmad@siswa.id', 'siswa'),
('guru1', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Pak Heru Setiawan', 'heru@guru.id', 'guru'),
('guru2', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Bu Dewi Lestari', 'dewi@guru.id', 'guru'),
('pembimbing1', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Ibu Maya Sari', 'maya@industri.id', 'pembimbing_industri'),
('pembimbing2', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Bapak Andi Wijaya', 'andi@industri.id', 'pembimbing_industri');

-- ============================================================
-- DATA INDUSTRI (Mitra PKL)
-- ============================================================
INSERT INTO industri (nama_industri, alamat_industri, kota, telepon, nama_instruktur, bidang_usaha, latitude, longitude, radius_meter) VALUES 
('PT. Teknologi Jaya', 'Jl. Digital No. 123, Blok A Lt. 3', 'Jakarta Selatan', '021-55512345', 'Ibu Maya Sari', 'Teknologi Informasi', -6.200000, 106.816666, 100),
('CV. Kreatif Nusantara', 'Jl. Kreatif Raya No. 45', 'Bandung', '022-44412345', 'Bapak Andi Wijaya', 'Desain Grafis & Multimedia', -6.914744, 107.609810, 150),
('PT. Solusi Digital Indonesia', 'Jl. Inovasi No. 88, Gedung SDI Lt. 5', 'Surabaya', '031-33312345', 'Pak Rudi Hartono', 'Software Development', -7.275930, 112.751370, 120);

-- ============================================================
-- DATA SISWA
-- ============================================================
INSERT INTO siswa (nis, id_user, id_industri, id_guru, kelas, jurusan, tanggal_mulai, tanggal_selesai, status_pkl) VALUES 
('12345', 2, 1, 5, 'XII-RPL-1', 'Rekayasa Perangkat Lunak', '2026-01-06', '2026-06-30', 'aktif'),
('12346', 3, 1, 5, 'XII-RPL-1', 'Rekayasa Perangkat Lunak', '2026-01-06', '2026-06-30', 'aktif'),
('12347', 4, 2, 6, 'XII-MM-2', 'Multimedia', '2026-01-06', '2026-06-30', 'aktif');

-- ============================================================
-- DATA JURNAL HARIAN (Contoh)
-- ============================================================
INSERT INTO jurnal_harian (id_user, tanggal, kegiatan, kompetensi_dasar, status_validasi, catatan_pembimbing, validated_by, validated_at) VALUES 
(2, '2026-05-19', 'Membuat halaman login dengan HTML, CSS, dan JavaScript. Mengimplementasikan validasi form dan responsive design.', 'Pemrograman Web - Frontend Development', 'approved', 'Bagus! Lanjutkan dengan fitur lainnya.', 7, '2026-05-19 16:30:00'),
(2, '2026-05-20', 'Melanjutkan pembuatan halaman dashboard. Integrasi API dan menampilkan data dinamis menggunakan AJAX.', 'Pemrograman Web - AJAX & API Integration', 'approved', 'Kerja bagus, code sudah rapi.', 7, '2026-05-20 17:00:00'),
(2, '2026-05-21', 'Membuat fitur upload file dan manajemen gambar. Testing browser compatibility.', 'Pemrograman Web - File Handling', 'pending', NULL, NULL, NULL),
(2, '2026-05-22', 'Implementasi fitur authentication dengan session PHP dan password hashing.', 'Pemrograman Web - Security', 'pending', NULL, NULL, NULL),
(2, '2026-05-23', 'Bug fixing dan optimasi performa. Dokumentasi kode program.', 'Pemrograman Web - Debugging', 'rejected', 'Dokumentasi masih kurang detail, tolong lengkapi lagi.', 7, '2026-05-23 15:00:00'),
(3, '2026-05-19', 'Membantu tim frontend dalam pembuatan komponen UI menggunakan framework CSS.', 'Desain Antarmuka - UI Components', 'approved', 'Good job!', 7, '2026-05-19 16:45:00'),
(3, '2026-05-20', 'Membuat mockup design untuk fitur baru menggunakan Figma.', 'Desain Antarmuka - Prototyping', 'pending', NULL, NULL, NULL);

-- ============================================================
-- DATA ABSENSI (Contoh)
-- ============================================================
INSERT INTO absensi (id_user, tanggal, jam_masuk, jam_pulang, lat_checkin, long_checkin, status_kehadiran, is_dalam_radius) VALUES 
(2, '2026-05-19', '07:45:00', '16:00:00', -6.200120, 106.816700, 'hadir', 1),
(2, '2026-05-20', '07:50:00', '16:15:00', -6.200050, 106.816620, 'hadir', 1),
(2, '2026-05-21', '08:00:00', '16:00:00', -6.200200, 106.816580, 'hadir', 1),
(2, '2026-05-22', '07:55:00', NULL, -6.200100, 106.816650, 'hadir', 1),
(2, '2026-05-23', NULL, NULL, NULL, NULL, 'izin', 0),
(3, '2026-05-19', '07:30:00', '16:00:00', -6.200300, 106.816550, 'hadir', 1),
(3, '2026-05-20', '07:40:00', '16:10:00', -6.200150, 106.816690, 'hadir', 1),
(3, '2026-05-21', NULL, NULL, NULL, NULL, 'sakit', 0);

-- ============================================================
-- DATA NOTIFIKASI (Contoh)
-- ============================================================
INSERT INTO notifikasi (id_user, judul, pesan, tipe, is_read, link) VALUES 
(2, 'Jurnal Disetujui', 'Jurnal tanggal 19 Mei 2026 telah disetujui oleh pembimbing.', 'success', 1, 'index.php?page=jurnal'),
(2, 'Jurnal Ditolak', 'Jurnal tanggal 23 Mei 2026 ditolak. Silakan perbaiki.', 'danger', 0, 'index.php?page=jurnal'),
(2, 'Pengingat Jurnal', 'Jangan lupa mengisi jurnal hari ini!', 'warning', 0, 'index.php?page=jurnal'),
(7, 'Jurnal Baru', 'Siswa Budi Santoso mengirim jurnal baru untuk divalidasi.', 'info', 0, 'index.php?page=validasi');

-- ============================================================
-- DATA PENGATURAN
-- ============================================================
INSERT INTO pengaturan (setting_key, setting_value, keterangan) VALUES 
('nama_sekolah', 'SMK Negeri 1 Digital', 'Nama sekolah'),
('tahun_ajaran', '2025/2026', 'Tahun ajaran aktif'),
('semester', 'Genap', 'Semester aktif'),
('jam_masuk_default', '08:00', 'Jam masuk default'),
('jam_pulang_default', '16:00', 'Jam pulang default'),
('batas_telat_menit', '30', 'Batas keterlambatan dalam menit'),
('geofence_default_radius', '100', 'Radius geofencing default (meter)'),
('max_upload_size_mb', '5', 'Ukuran maksimal upload foto (MB)'),
('maintenance_mode', '0', '1=Maintenance, 0=Normal');

-- ============================================================
-- DATA LOG AKTIVITAS (Contoh)
-- ============================================================
INSERT INTO log_aktivitas (id_user, aksi, detail, ip_address) VALUES 
(1, 'login', 'Admin login ke sistem', '127.0.0.1'),
(2, 'login', 'Siswa login ke sistem', '127.0.0.1'),
(2, 'create_jurnal', 'Membuat jurnal baru tanggal 2026-05-19', '127.0.0.1'),
(2, 'checkin', 'Check-in absensi di PT. Teknologi Jaya', '127.0.0.1'),
(7, 'validasi_jurnal', 'Menyetujui jurnal ID #1', '127.0.0.1');


-- ============================================================
-- ============================================================
--                    VIEWS (UNTUK QUERY CEPAT)
-- ============================================================
-- ============================================================

-- View: Rekap lengkap siswa dengan data industri dan guru
CREATE OR REPLACE VIEW v_siswa_lengkap AS
SELECT 
    s.nis,
    u.id_user,
    u.nama_lengkap AS nama_siswa,
    u.username,
    u.foto_profil,
    s.kelas,
    s.jurusan,
    s.status_pkl,
    s.tanggal_mulai,
    s.tanggal_selesai,
    i.nama_industri,
    i.alamat_industri,
    i.nama_instruktur,
    g.nama_lengkap AS nama_guru
FROM siswa s
JOIN users u ON s.id_user = u.id_user
LEFT JOIN industri i ON s.id_industri = i.id_industri
LEFT JOIN users g ON s.id_guru = g.id_user;

-- View: Rekap absensi per siswa
CREATE OR REPLACE VIEW v_rekap_absensi AS
SELECT 
    u.id_user,
    u.nama_lengkap,
    s.kelas,
    COUNT(CASE WHEN a.status_kehadiran = 'hadir' THEN 1 END) AS total_hadir,
    COUNT(CASE WHEN a.status_kehadiran = 'izin' THEN 1 END) AS total_izin,
    COUNT(CASE WHEN a.status_kehadiran = 'sakit' THEN 1 END) AS total_sakit,
    COUNT(CASE WHEN a.status_kehadiran = 'alpa' THEN 1 END) AS total_alpa,
    COUNT(a.id_absen) AS total_hari
FROM users u
JOIN siswa s ON u.id_user = s.id_user
LEFT JOIN absensi a ON u.id_user = a.id_user
GROUP BY u.id_user, u.nama_lengkap, s.kelas;

-- View: Rekap jurnal per siswa
CREATE OR REPLACE VIEW v_rekap_jurnal AS
SELECT 
    u.id_user,
    u.nama_lengkap,
    s.kelas,
    COUNT(j.id_jurnal) AS total_jurnal,
    COUNT(CASE WHEN j.status_validasi = 'approved' THEN 1 END) AS jurnal_approved,
    COUNT(CASE WHEN j.status_validasi = 'pending' THEN 1 END) AS jurnal_pending,
    COUNT(CASE WHEN j.status_validasi = 'rejected' THEN 1 END) AS jurnal_rejected
FROM users u
JOIN siswa s ON u.id_user = s.id_user
LEFT JOIN jurnal_harian j ON u.id_user = j.id_user
GROUP BY u.id_user, u.nama_lengkap, s.kelas;

-- ============================================================
-- SELESAI! Database siap digunakan.
-- ============================================================
-- Akun untuk testing:
-- ┌──────────────┬────────────────────┬────────────────────────┬──────────┐
-- │ Username     │ Password           │ Nama Lengkap           │ Role     │
-- ├──────────────┼────────────────────┼────────────────────────┼──────────┤
-- │ admin        │ password           │ Administrator          │ admin    │
-- │ siswa1       │ password           │ Budi Santoso           │ siswa    │
-- │ siswa2       │ password           │ Siti Nurhaliza         │ siswa    │
-- │ siswa3       │ password           │ Ahmad Rizky            │ siswa    │
-- │ guru1        │ password           │ Pak Heru Setiawan      │ guru     │
-- │ guru2        │ password           │ Bu Dewi Lestari        │ guru     │
-- │ pembimbing1  │ password           │ Ibu Maya Sari          │ p.industri│
-- │ pembimbing2  │ password           │ Bapak Andi Wijaya      │ p.industri│
-- └──────────────┴────────────────────┴────────────────────────┴──────────┘
