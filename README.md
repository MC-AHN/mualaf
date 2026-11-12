
# Mualaf Center — Sistem Manajemen Pembinaan & Administrasi Mualaf

Aplikasi web berbasis **Laravel** dan **Filament v3** dengan arsitektur *multi-tenancy* untuk pengelolaan administrasi pendaftaran, jadwal bimbingan kurikulum, pemantauan progres oleh Da'i, penerbitan sertifikat kelulusan, hingga pencatatan arsip *dropout* antara tingkat Pusat (Nasional) dan Kemenag Daerah (Cabang).

---

## Prasyarat Sistem (Local Environment)

- **PHP** >= 8.3 / 8.4 (ekstensi: `pdo_mysql`, `mbstring`, `xml`, `bcmath`, `gd`, `zip`, `intl`)
- **Composer** >= 2.x
- **Node.js** >= 20.x & **NPM**
- **MySQL** >= 8.0 / MariaDB >= 10.6

---

## Instalasi & Setup Lokal

### 1. Clone Repository

```bash
git clone https://github.com/MC-AHN/mualaf.git
cd mualaf
```

### 2. Install Dependensi Backend & Frontend

```bash
composer install
npm install
```

### 3. Konfigurasi Environment

```bash
cp .env.example .env
php artisan key:generate
```

Sesuaikan konfigurasi database MySQL pada file `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=mualaf
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Migrasi Database, Seeder & Build Aset

```bash
php artisan migrate:fresh --seed
php artisan filament:assets
npm run build
```

### 5. Jalankan Server Lokal

```bash
php artisan serve
```

Akses aplikasi melalui:

http://localhost:8000

---

## Akun Testing & Skenario RBAC

Seluruh akun dummy di bawah ini menggunakan password default: **`admin`**.

| Peran (Role) | Wilayah / Tenant | Email | Hak Akses Utama |
|---|---|---|---|
| **Super Admin** | Nasional / Sistem | `superadmin@kemenag.gov.sa` | Manajemen seluruh tenant, user, dan monitoring data nasional. |
| **Staf Pusat** | Kemenag Pusat / Nasional | `staf.pusat@kemenag.gov.sa` | Audit statistik & riwayat *dropout* seluruh cabang (read-only). |
| **Admin Cabang** | Kemenag Kota Riyadh | `admin.riyadh@kemenag.gov.sa` | Verifikasi pendaftaran, penugasan Da'i, dan persetujuan lulus/*dropout* cabang Riyadh. |
| **Da'i Pembimbing** | Kemenag Kota Riyadh | `dai.abdullah@kemenag.gov.sa` | Input progres bimbingan (Materi 1–6) dan pengajuan rekomendasi lulus/*dropout*. |
| **Staf Cabang** | Kemenag Kota Riyadh | `staf.riyadh@kemenag.gov.sa` | Monitoring data & riwayat *dropout* khusus cabang Riyadh. |
| **Admin Cabang** | Kemenag Kota Jeddah | `admin.jeddah@kemenag.gov.sa` | Manajemen mualaf & persetujuan khusus wilayah Jeddah. |
| **Da'i Pembimbing** | Kemenag Kota Jeddah | `dai.hasan@kemenag.gov.sa` | Input progres & rekomendasi mualaf binaan wilayah Jeddah. |

---
