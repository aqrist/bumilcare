# Sistem Manajemen Klinik Kehamilan BUMIL Care

## Gambaran Umum
Sistem manajemen klinik yang komprehensif dirancang khusus untuk layanan kesehatan kehamilan dan maternal. Sistem ini mengoptimalkan pengelolaan pasien, pemeriksaan medis, operasional farmasi, dan pemrosesan pembayaran.

## Fitur
- Manajemen Pasien
- Sistem Antrian
- Pemeriksaan Medis
- Pengelolaan Resep
- Operasional Farmasi
- Pemrosesan Pembayaran
- Catatan Kehamilan

## Peran Pengguna
1. **Admin**
   - Mengelola pasien
   - Mengelola antrian
   - Akses ke semua fitur

2. **Dokter**
   - Melakukan pemeriksaan
   - Membuat resep
   - Melihat riwayat pasien

3. **Perawat**
   - Mendaftarkan pasien
   - Mengelola antrian
   - Mencatat informasi dasar pasien

4. **Apoteker**
   - Memproses resep
   - Mengelola inventaris obat
   - Menyiapkan obat

5. **Kasir**
   - Memproses pembayaran
   - Membuat faktur
   - Mengelola catatan pembayaran

## Alur Aplikasi

### 1. Pendaftaran Pasien
- Mendaftarkan pasien baru
- Membuat catatan kehamilan (jika diperlukan)
- Dikelola oleh admin/perawat

### 2. Manajemen Antrian
- Membuat antrian pasien
- Menentukan dokter
- Menampilkan status antrian
- Dikelola oleh admin/perawat

### 3. Pemeriksaan Medis
- Dokter memeriksa pasien
- Mencatat detail pemeriksaan
- Membuat resep jika diperlukan
- Melihat riwayat pasien

### 4. Proses Farmasi
- Melihat resep baru
- Memproses dan menyiapkan obat
- Memperbarui status resep
- Mengelola inventaris obat

### 5. Pemrosesan Pembayaran
#### Pembayaran Pemeriksaan
- Membuat catatan pembayaran
- Memproses pembayaran
- Membuat faktur

#### Pembayaran Obat
- Membuat pembayaran resep
- Memproses pembayaran
- Membuat faktur

### 6. Catatan & Riwayat
- Riwayat medis pasien
- Catatan pemeriksaan
- Riwayat pembayaran
- Catatan perkembangan kehamilan

## Metode Pembayaran
- Tunai
- Kartu Debit
- Kartu Kredit
- Asuransi

## Pembuatan Dokumen
- Laporan pemeriksaan
- Resep obat
- Faktur pembayaran
- Catatan riwayat medis

## Keamanan
- Kontrol akses berbasis peran
- Autentikasi yang aman
- Data pasien yang terlindungi
- Pencatatan transaksi

## Persyaratan Sistem
- PHP 8.2+
- Laravel 12.x
- MySQL 8.0+
- Bootstrap 5.x
- Browser web modern

## Installation
```bash
# Clone repository
git clone [repository-url]

# Install dependencies
composer install
npm install

# Set up environment
cp .env.example .env
php artisan key:generate

# Run migrations
php artisan migrate

# Seed database
php artisan db:seed

# Start development server
php artisan serve
```

## License
[License Type]

## Support
mail to : aqrist@gmail.com