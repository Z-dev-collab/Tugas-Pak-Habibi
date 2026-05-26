# 📚 Rekap Tugas Pemrograman Web - Semester 2
Repository ini berisi seluruh kumpulan tugas dan proyek individu mata pelajaran **Pemrograman Web dan Perangkat Bergerak (PWPB)** selama Semester 2 yang diampu oleh **Pak Habibi**.

---

## 🧑‍💻 Profil Siswa
* **Nama Lengkap:** ZOHARYADI TRI ADMAJA (Zo)
* **Kelas:** 11 RPL B
* **Jurusan:** Rekayasa Perangkat Lunak (RPL)
* **Sekolah:** SMK Ibnu Sina Batam

---

## 📂 Daftar Rekap Tugas & Proyek (Semester 2)

Berikut adalah project yang telah diselesaikan selama semester ini dan disatukan di dalam folder `TugasPakHB`:

1. **JurnalDigitalApk (Ulangan)**
   * **Deskripsi:** Aplikasi Jurnal Digital untuk mencatat aktivitas prakerind/magang siswa SMK Ibnu Sina Batam.
   * **Fitur Utama:** Autentikasi Login/Register, Integrasi Google OAuth (Google Login), Manajemen data siswa/pembimbing, dan upload file.
   * **Teknologi:** PHP Native, MySQL, Bootstrap.

2. **siswa (Tugas 6 Data Siswa)**
   * **Deskripsi:** Proyek implementasi CRUD (Create, Read, Update, Delete) pertama menggunakan framework Laravel untuk memanajemen data siswa.
   * **Teknologi:** Framework Laravel, Blade Templates, Bootstrap/Tailwind.

3. **BREEZE (Tugas 7)**
   * **Deskripsi:** Tugas eksplorasi sistem autentikasi modern menggunakan starter kit ekosistem Laravel (Laravel Breeze).
   * **Teknologi:** Framework Laravel, Laravel Breeze.

---

## 🛠️ Panduan Menjalankan Proyek di Lokal (Localhost)

### 1. Proyek PHP Native (JurnalDigitalApk)
1. Pastikan folder induk berada di direktori `C:\xampp\htdocs\`.
2. Aktifkan **Apache** dan **MySQL** pada XAMPP Control Panel.
3. Buat database baru bernama `db_jurnal_prakerind` di **phpMyAdmin**, lalu import file `database.sql` yang tersedia di dalam folder proyek.
4. Akses melalui browser: `http://localhost/TugasPakHB/JurnalDigitalApk%20(Ulangan)/`

### 2. Proyek Framework Laravel (Tugas 6 & 7)
1. Buka terminal (VS Code/Git Bash) lalu masuk ke folder project Laravel yang diinginkan, contoh:
   ```bash
   cd "siswa (Tugas 6 Data Siswa)"
