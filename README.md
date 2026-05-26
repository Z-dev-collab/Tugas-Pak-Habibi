# 📚 Portofolio & Rekap Tugas Pemrograman Web - Semester 2
Repository ini berisi seluruh kumpulan tugas, praktik, dan proyek individu mata pelajaran **Pemrograman Web dan Perangkat Bergerak (PWPB)** selama Semester 2 yang diampu oleh **Pak Habibi**.

---

## 🧑‍💻 Profil Siswa
* **Nama Lengkap:** ZOHARYADI TRI ADMAJA (zo)
* **Kelas:** 11 RPL B
* **Jurusan:** Rekayasa Perangkat Lunak (RPL)
* **Sekolah:** SMK Ibnu Sina Batam

---

## 📂 Rekap Tugas & Proyek (Semester 2)

Berikut adalah detail seluruh tugas yang telah diselesaikan dan disatukan di dalam folder `TugasPakHB`:

### 🔹 Bagian 1: Fondasi Web & PHP Native
* **Tugas 1: Pengenalan & Review HTML/CSS**
  * *Deskripsi:* Pembuatan struktur halaman web statis dan slicing layout sederhana menggunakan CSS Dasar.
* **Tugas 2: Dasbor & Form Handling JavaScript**
  * *Deskripsi:* Implementasi validasi form login/input menggunakan JavaScript client-side.
* **Tugas 3: Dasar Pemrograman PHP**
  * *Deskripsi:* Latihan logika dasar PHP (Variabel, Percabangan `if-else`, Perulangan `for/while`, dan Array).
* **Tugas 4: Integrasi PHP dan Database MySQL**
  * *Deskripsi:* Membuat koneksi database statis dan menampilkan data (Read) dari MySQL ke tabel HTML.
* **Tugas 5: Sistem Autentikasi PHP Native Sederhana**
  * *Deskripsi:* Membuat fitur Login dan Logout menggunakan Session PHP standar.

### 🔹 Bagian 2: Proyek Ujian & Framework Modern
* **JurnalDigitalApk (Ulangan Semester)**
  * *Deskripsi:* Aplikasi Jurnal Digital untuk mencatat aktivitas prakerind/magang siswa SMK Ibnu Sina Batam.
  * *Fitur Utama:* Autentikasi Login/Register, Integrasi Google OAuth (Google Login), Manajemen data siswa/pembimbing, dan upload file laporan.
  * *Teknologi:* PHP Native, MySQL, Bootstrap CSS.
* **siswa (Tugas 6 Data Siswa)**
  * *Deskripsi:* Proyek implementasi CRUD (Create, Read, Update, Delete) pertama menggunakan framework Laravel untuk memanajemen data siswa.
  * *Teknologi:* Framework Laravel, Blade Templates, Migration, Eloquent ORM.
* **BREEZE (Tugas 7)**
  * *Deskripsi:* Tugas eksplorasi sistem autentikasi modern dan secure menggunakan starter kit resmi ekosistem Laravel (Laravel Breeze).
  * *Teknologi:* Framework Laravel, Laravel Breeze, Tailwind CSS.

---

## 🛠️ Panduan Menjalankan Proyek di Lokal (Localhost)

### 1. Menjalankan Proyek PHP Native & Tugas Dasar (Tugas 1 - 5 & Ulangan)
1. Pastikan folder induk `TugasPakHB` berada di dalam direktori `C:\xampp\htdocs\`.
2. Aktifkan **Apache** dan **MySQL** pada XAMPP Control Panel.
3. Khusus proyek **JurnalDigitalApk**: Buat database baru bernama `db_jurnal_prakerind` di **phpMyAdmin**, lalu import file `database.sql` yang tersedia di dalam foldernya.
4. Akses tugas lewat browser dengan alamat:
   * Tugas 1: `http://localhost/TugasPakHB/nama_folder_tugas1/`
   * Jurnal Digital: `http://localhost/TugasPakHB/JurnalDigitalApk%20(Ulangan)/`

### 2. Menjalankan Proyek Framework Laravel (Tugas 6 & 7)
1. Buka terminal (VS Code / Git Bash) lalu masuk ke folder project Laravel yang diinginkan, contoh:
   ```bash
   cd "siswa (Tugas 6 Data Siswa)"
