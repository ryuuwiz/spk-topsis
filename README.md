# Sistem Pendukung Keputusan untuk Seleksi Pemilihan Karyawan Teladan

Aplikasi ini adalah Sistem Pendukung Keputusan (SPK) yang dirancang untuk membantu dalam proses seleksi karyawan teladan dengan menggunakan metode TOPSIS (_Technique for Order of Preference by Similarity to Ideal Solution_). Aplikasi ini memungkinkan manajemen untuk memasukkan data karyawan (alternatif), kriteria penilaian, dan memberikan rating untuk setiap karyawan berdasarkan kriteria yang ada. Selanjutnya, sistem akan secara otomatis menghitung dan menampilkan peringkat karyawan teladan.

### Fitur Utama

- **Manajemen Kriteria**: Menambah, mengubah, dan menghapus kriteria penilaian beserta bobot dan atributnya (benefit/cost).
    
- **Manajemen Alternatif**: Mengelola data karyawan yang akan dinilai.
    
- **Manajemen Rating**: Memberikan nilai (rating) untuk setiap alternatif terhadap setiap kriteria. Terdapat fitur untuk menambahkan rating secara massal per alternatif untuk mempercepat input data.
    
- **Perhitungan TOPSIS**: Sistem secara otomatis menghitung peringkat berdasarkan metode TOPSIS.
    
- **Manajemen Pengguna**: Mengelola pengguna yang dapat mengakses sistem.
    
- **Otentikasi**: Sistem dilengkapi dengan fitur login, register, dan reset password.
    

### Teknologi yang Digunakan

- **Backend**: Laravel v12.x
    
- **Frontend**: Blade, Livewire, Volt, Tailwind CSS
    
- **Database**: SQLite
    
- **Build Tool**: Vite
    

### Panduan Instalasi

#### Persyaratan Sistem

- PHP 8.2 atau lebih tinggi
    
- Composer
    
- Node.js & NPM
    

#### Langkah-langkah Instalasi

1. Clone Repositori
    
    Clone repositori ini ke dalam direktori lokal Anda:
    
    Bash
    
    ```
    git clone https://github.com/ryuuwiz/spk-topsis.git
    cd spk-topsis
    ```
    
2. Instal Dependensi PHP
    
    Instal semua dependensi PHP yang dibutuhkan menggunakan Composer:
    
    Bash
    
    ```
    composer install
    ```
    
3. Instal Dependensi JavaScript
    
    Instal dependensi frontend menggunakan NPM:
    
    Bash
    
    ```
    npm install
    ```
    
4. Konfigurasi Lingkungan
    
    Salin file .env.example menjadi .env:
    
    Bash
    
    ```
    cp .env.example .env
    ```
    
    Karena aplikasi ini menggunakan SQLite, konfigurasi database sudah diatur secara default. Anda hanya perlu memastikan file `database.sqlite` ada. Jika tidak, buat file kosong tersebut:
    
    Bash
    
    ```
    touch database/database.sqlite
    ```
    
    Selanjutnya, generate kunci aplikasi:
    
    Bash
    
    ```
    php artisan key:generate
    ```
    
5. Migrasi dan Seeding Database
    
    Jalankan migrasi untuk membuat tabel-tabel yang dibutuhkan di dalam database SQLite. Perintah ini juga akan menjalankan seeder untuk mengisi data awal (kriteria dan alternatif).
    
    Bash
    
    ```
    php artisan migrate --seed
    ```
    
    Seeder akan membuat beberapa kriteria penilaian standar dan beberapa data alternatif karyawan fiktif.
    
6. Build Aset Frontend
    
    Jalankan perintah berikut untuk meng-compile aset CSS dan JavaScript:
    
    Bash
    
    ```
    npm run build
    ```
    
7. Jalankan Server Pengembangan
    
    Anda dapat menjalankan server pengembangan internal Laravel dengan perintah:
    
    Bash
    
    ```
    php artisan serve
    ```
    
    Aplikasi akan berjalan di `http://127.0.0.1:8000`.
    

### Struktur dan Cara Kerja Aplikasi

#### 1. Alur Kerja TOPSIS

Inti dari aplikasi ini adalah `TopsisService.php` yang menangani semua logika perhitungan metode TOPSIS. Berikut adalah langkah-langkah yang diimplementasikan:

1. **Memuat Data**: Mengambil data Alternatif, Kriteria, dan Rating dari database.
    
2. **Membuat Matriks Keputusan**: Mengubah data rating menjadi bentuk matriks di mana baris adalah alternatif dan kolom adalah kriteria.
    
3. **Normalisasi Matriks**: Menormalisasi matriks keputusan.
    
4. **Matriks Terbobot**: Menghitung matriks ternormalisasi terbobot dengan mengalikan hasil normalisasi dengan bobot setiap kriteria.
    
5. **Solusi Ideal**: Menentukan solusi ideal positif (nilai terbaik dari setiap kriteria) dan solusi ideal negatif (nilai terburuk dari setiap kriteria).
    
6. **Jarak Separasi**: Menghitung jarak setiap alternatif dari solusi ideal positif dan negatif.
    
7. **Kedekatan Relatif**: Menghitung nilai preferensi (skor) untuk setiap alternatif.
    
8. **Peringkat**: Mengurutkan alternatif berdasarkan skor tertinggi untuk mendapatkan peringkat akhir.
    

Hasil dari perhitungan ini ditampilkan di halaman **Dashboard**.

#### 2. Rute (Routes)

Aplikasi ini menggunakan beberapa file rute:

- `routes/web.php`: Mendefinisikan rute utama aplikasi, termasuk dashboard, dan rute resource untuk Kriteria, Alternatif, Rating, dan User.
    
- `routes/auth.php`: Menangani rute-rute untuk otentikasi seperti login, register, dan verifikasi email.
    

#### 3. Kontroler (Controllers)

Logika bisnis untuk setiap modul diatur dalam kontroler masing-masing:

- `AlternatifController.php`: Mengelola operasi CRUD untuk data alternatif.
    
- `KriteriaController.php`: Mengelola operasi CRUD untuk data kriteria.
    
- `RatingController.php`: Mengatur operasi CRUD untuk rating, termasuk penambahan rating secara massal.
    
- `UserController.php`: Mengatur operasi CRUD untuk data pengguna.
    

#### 4. Model

Model Eloquent merepresentasikan tabel-tabel dalam database:

- `Alternatif.php`
    
- `Kriteria.php`
    
- `Rating.php`
    
- `User.php`
    

#### 5. Tampilan (Views)

Tampilan aplikasi dibuat menggunakan Blade dan komponen-komponen Livewire. Struktur utama tampilan berada di `resources/views/`.

- `components/layouts/app.blade.php`: Layout utama untuk halaman-halaman setelah login.
    
- `components/layouts/auth.blade.php`: Layout untuk halaman otentikasi.
    
- `dashboard.blade.php`: Halaman utama yang menampilkan peringkat hasil perhitungan TOPSIS.
    
- Folder `alternatif`, `kriteria`, `rating`, dan `users` berisi file-file Blade untuk operasi CRUD setiap modul.
    

### Penggunaan

1. **Akses Aplikasi**: Buka aplikasi melalui URL yang didapatkan dari `php artisan serve`.
    
2. **Registrasi**: Buat akun baru melalui halaman registrasi.
    
3. **Login**: Masuk ke dalam sistem menggunakan akun yang telah dibuat.
    
4. **Kelola Kriteria**: Masuk ke menu "Kriteria" untuk menambahkan atau mengubah kriteria penilaian. Pastikan total bobot dari semua kriteria adalah 1 untuk hasil yang ideal.
    
5. **Kelola Alternatif**: Masuk ke menu "Alternatif" untuk menambahkan data karyawan yang akan dinilai.
    
6. **Input Rating**: Buka menu "Rating" dan gunakan tombol "Add Rating" untuk menambahkan nilai untuk setiap karyawan per kriteria. Fitur ini memungkinkan Anda memilih satu karyawan dan menginput semua nilai kriterianya sekaligus.
    
7. **Lihat Hasil**: Kembali ke "Dashboard" untuk melihat peringkat karyawan teladan yang telah dihitung secara otomatis.
