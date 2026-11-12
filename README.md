# Mualaf Center — Sistem Manajemen Pembinaan & Administrasi Mualaf

Aplikasi web berbasis **Laravel** dan **Filament v3** dengan arsitektur *multi-tenancy* untuk pengelolaan administrasi pendaftaran, jadwal bimbingan kurikulum, pemantauan progres oleh Da'i, penerbitan sertifikat kelulusan, hingga pencatatan arsip *dropout* antara tingkat Pusat (Nasional) dan Kemenag Daerah (Cabang).

---

## Prasyarat Sistem (Local Environment)

* **PHP** >= 8.3 / 8.4 (ekstensi: `pdo_mysql`, `mbstring`, `xml`, `bcmath`, `gd`, `zip`, `intl`)
* **Composer** >= 2.x
* **Node.js** >= 20.x & **NPM**
* **MySQL** >= 8.0 / MariaDB >= 10.6

---

## Instalasi & Setup Lokal

1. **Clone Repository**
   ```bash
   git clone [https://github.com/MC-AHN/mualaf.git](https://github.com/MC-AHN/mualaf.git)
   cd mualaf
Install Dependensi Backend & FrontendBashcomposer install
npm install
Konfigurasi EnvironmentBashcp .env.example .env
php artisan key:generate
Sesuaikan koneksi database MySQL pada file .env:Cuplikan kodeDB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=mualaf
DB_USERNAME=root
DB_PASSWORD=
Migrasi Database, Seeder & Build AsetBashphp artisan migrate:fresh --seed
php artisan filament:assets
npm run build
Jalankan Server LokalBashphp artisan serve
Akses halaman utama di http://localhost:8000.Akun Testing & Skenario RBACSeluruh akun dummy di bawah ini menggunakan password default: adminPeran (Role)Wilayah / TenantEmailHak Akses UtamaSuper AdminNasional / Sistemsuperadmin@kemenag.gov.saManajemen seluruh tenant, user, dan monitoring data nasional.Staf PusatKemenag Pusat / Nasionalstaf.pusat@kemenag.gov.saAudit statistik & riwayat dropout seluruh cabang (read-only).Admin CabangKemenag Kota Riyadhadmin.riyadh@kemenag.gov.saVerifikasi pendaftaran, penugasan Da'i, dan persetujuan lulus/dropout cabang Riyadh.Da'i PembimbingKemenag Kota Riyadhdai.abdullah@kemenag.gov.saInput progres bimbingan (Materi 1–6) dan pengajuan rekomendasi lulus/dropout.Staf CabangKemenag Kota Riyadhstaf.riyadh@kemenag.gov.saMonitoring data & riwayat dropout khusus cabang Riyadh.Admin CabangKemenag Kota Jeddahadmin.jeddah@kemenag.gov.saManajemen mualaf & persetujuan khusus wilayah Jeddah.Da'i PembimbingKemenag Kota Jeddahdai.hasan@kemenag.gov.saInput progres & rekomendasi mualaf binaan wilayah Jeddah.
