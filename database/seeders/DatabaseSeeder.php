<?php

namespace Database\Seeders;

use App\Models\MualafDropout;
use App\Models\Tenant;
use App\Models\User;
use App\Models\Mualaf;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // =========================================================================
        // 1. TENANTS / KEMENAG DAERAH & PUSAT
        // =========================================================================
        $tenantPusat = Tenant::create([
            'name' => 'Kemenag Pusat / Nasional',
            'slug' => 'pusat',
            'is_active' => true,
        ]);

        $tenantRiyadh = Tenant::create([
            'name' => 'Kemenag Kota Riyadh',
            'slug' => 'kemenag-riyadh',
            'is_active' => true,
        ]);

        $tenantJeddah = Tenant::create([
            'name' => 'Kemenag Kota Jeddah',
            'slug' => 'kemenag-jeddah',
            'is_active' => true,
        ]);

        // =========================================================================
        // 2. USER & STAF ACCOUNTS
        // =========================================================================
        // Super Admin (Sistem)
        User::create([
            'name' => 'Super Admin Sistem',
            'email' => 'superadmin@kemenag.gov.sa',
            'password' => Hash::make('admin'),
            'role' => 'superadmin',
            'tenant_id' => null,
        ]);

        // Staf Pusat (Viewer & Audit Nasional)
        User::create([
            'name' => 'Staf Auditor Pusat',
            'email' => 'staf.pusat@kemenag.gov.sa',
            'password' => Hash::make('admin'),
            'role' => 'staf',
            'tenant_id' => $tenantPusat->id,
        ]);

        // --- CABANG RIYADH ---
        $adminRiyadh = User::create([
            'name' => 'Admin Kemenag Riyadh',
            'email' => 'admin.riyadh@kemenag.gov.sa',
            'password' => Hash::make('admin'),
            'role' => 'admin',
            'tenant_id' => $tenantRiyadh->id,
        ]);

        $daiRiyadh1 = User::create([
            'name' => 'Ustadz Abdullah',
            'email' => 'dai.abdullah@kemenag.gov.sa',
            'password' => Hash::make('admin'),
            'role' => 'dai',
            'tenant_id' => $tenantRiyadh->id,
        ]);

        $daiRiyadh2 = User::create([
            'name' => 'Ustadz Ahmad',
            'email' => 'dai.ahmad@kemenag.gov.sa',
            'password' => Hash::make('admin'),
            'role' => 'dai',
            'tenant_id' => $tenantRiyadh->id,
        ]);

        User::create([
            'name' => 'Staf Auditor Riyadh',
            'email' => 'staf.riyadh@kemenag.gov.sa',
            'password' => Hash::make('admin'),
            'role' => 'staf',
            'tenant_id' => $tenantRiyadh->id,
        ]);

        // --- CABANG JEDDAH ---
        $adminJeddah = User::create([
            'name' => 'Admin Kemenag Jeddah',
            'email' => 'admin.jeddah@kemenag.gov.sa',
            'password' => Hash::make('admin'),
            'role' => 'admin',
            'tenant_id' => $tenantJeddah->id,
        ]);

        $daiJeddah1 = User::create([
            'name' => 'Ustadz Hasan',
            'email' => 'dai.hasan@kemenag.gov.sa',
            'password' => Hash::make('admin'),
            'role' => 'dai',
            'tenant_id' => $tenantJeddah->id,
        ]);

        User::create([
            'name' => 'Staf Auditor Jeddah',
            'email' => 'staf.jeddah@kemenag.gov.sa',
            'password' => Hash::make('admin'),
            'role' => 'staf',
            'tenant_id' => $tenantJeddah->id,
        ]);

        // =========================================================================
        // 3. DUMMY DATA MUALAF (10 MUALAF DARI 3 TENANT)
        // =========================================================================

        // --- TENANT RIYADH (5 Mualaf) ---
        Mualaf::create([
            'tenant_id' => $tenantRiyadh->id,
            'nomor_registrasi' => 'MLF-20261101-101',
            'nik_paspor' => '3201982716350001',
            'nama_lengkap' => 'John Michael Smith',
            'nama_hijrah' => 'Muhammad Yahya',
            'tempat_lahir' => 'London',
            'tanggal_lahir' => '1995-04-12',
            'gender' => 'male',
            'pekerjaan' => 'Software Engineer',
            'telepon' => '081234567890',
            'alamat_domisili' => 'Distrik Al-Olaya, Riyadh',
            'agama_asal' => 'Kristen Protestan',
            'tanggal_syahadat' => '2026-08-10',
            'status' => 'lulus',
            'dai_id' => $daiRiyadh1->id,
            'rekomendasi_dai' => 'lulus',
            'catatan_rekomendasi_dai' => 'Materi 1-6 telah tuntas diselesaikan dengan sangat baik.',
            'rekomendasi_dai_at' => '2026-10-15 09:00:00',
        ]);

        Mualaf::create([
            'tenant_id' => $tenantRiyadh->id,
            'nomor_registrasi' => 'MLF-20261101-102',
            'nik_paspor' => '3201982716350002',
            'nama_lengkap' => 'David Lee Wang',
            'nama_hijrah' => 'Daud Wang',
            'tempat_lahir' => 'Beijing',
            'tanggal_lahir' => '1998-09-25',
            'gender' => 'male',
            'pekerjaan' => 'Data Analyst',
            'telepon' => '081234567891',
            'alamat_domisili' => 'Distrik Al-Malaz, Riyadh',
            'agama_asal' => 'Buddha',
            'tanggal_syahadat' => '2026-09-01',
            'status' => 'proses_bimbingan',
            'dai_id' => $daiRiyadh1->id,
            'rekomendasi_dai' => 'lulus',
            'catatan_rekomendasi_dai' => 'Sudah menyelesaikan seluruh kurikulum bimbingan dasar.',
            'rekomendasi_dai_at' => '2026-11-05 14:30:00',
        ]);

        Mualaf::create([
            'tenant_id' => $tenantRiyadh->id,
            'nomor_registrasi' => 'MLF-20261101-103',
            'nik_paspor' => '3201982716350003',
            'nama_lengkap' => 'Sarah Elisabeth',
            'nama_hijrah' => 'Siti Aisyah',
            'tempat_lahir' => 'Sydney',
            'tanggal_lahir' => '2000-01-15',
            'gender' => 'female',
            'pekerjaan' => 'Desainer Grafis',
            'telepon' => '081234567892',
            'alamat_domisili' => 'Distrik Al-Sulaimaniyah, Riyadh',
            'agama_asal' => 'Katolik',
            'tanggal_syahadat' => '2026-09-15',
            'status' => 'proses_bimbingan',
            'dai_id' => $daiRiyadh2->id,
            'rekomendasi_dai' => 'none',
            'catatan_rekomendasi_dai' => null,
            'rekomendasi_dai_at' => null,
        ]);

        $mualafDropout = Mualaf::create([
            'tenant_id' => $tenantRiyadh->id,
            'nomor_registrasi' => 'MLF-20261101-104',
            'nik_paspor' => '3201982716350004',
            'nama_lengkap' => 'Robert Paulson',
            'nama_hijrah' => null,
            'tempat_lahir' => 'Chicago',
            'tanggal_lahir' => '1992-11-30',
            'gender' => 'male',
            'pekerjaan' => 'Konsultan Keuangan',
            'telepon' => '081234567893',
            'alamat_domisili' => 'Distrik Al-Nakheel, Riyadh',
            'agama_asal' => 'Ateis',
            'tanggal_syahadat' => '2026-06-01',
            'status' => 'drop_out',
            'dai_id' => $daiRiyadh2->id,
            'rekomendasi_dai' => 'dropout',
            'catatan_rekomendasi_dai' => 'Tidak hadir bimbingan lebih dari 3 bulan berturut-turut tanpa kabar.',
            'rekomendasi_dai_at' => '2026-09-10 10:00:00',
        ]);

        Mualaf::create([
            'tenant_id' => $tenantRiyadh->id,
            'nomor_registrasi' => 'MLF-20261101-105',
            'nik_paspor' => '3201982716350005',
            'nama_lengkap' => 'Alexander Schmidt',
            'nama_hijrah' => 'Ibrahim Schmidt',
            'tempat_lahir' => 'Berlin',
            'tanggal_lahir' => '1997-03-18',
            'gender' => 'male',
            'pekerjaan' => 'Arsitek',
            'telepon' => '081234567894',
            'alamat_domisili' => 'Distrik Al-Mursalat, Riyadh',
            'agama_asal' => 'Protestan',
            'tanggal_syahadat' => '2026-10-20',
            'status' => 'terdaftar',
            'dai_id' => null,
            'rekomendasi_dai' => 'none',
            'catatan_rekomendasi_dai' => null,
            'rekomendasi_dai_at' => null,
        ]);

        // --- TENANT JEDDAH (3 Mualaf) ---
        Mualaf::create([
            'tenant_id' => $tenantJeddah->id,
            'nomor_registrasi' => 'MLF-20261101-201',
            'nik_paspor' => '3201982716350006',
            'nama_lengkap' => 'Maria Garcia Rodriguez',
            'nama_hijrah' => 'Maryam Garcia',
            'tempat_lahir' => 'Madrid',
            'tanggal_lahir' => '1996-07-08',
            'gender' => 'female',
            'pekerjaan' => 'Penerjemah',
            'telepon' => '081234567895',
            'alamat_domisili' => 'Distrik Al-Shati, Jeddah',
            'agama_asal' => 'Katolik',
            'tanggal_syahadat' => '2026-07-10',
            'status' => 'lulus',
            'dai_id' => $daiJeddah1->id,
            'rekomendasi_dai' => 'lulus',
            'catatan_rekomendasi_dai' => 'Telah lulus ujian hafalan dan praktek ibadah dasar.',
            'rekomendasi_dai_at' => '2026-09-20 11:00:00',
        ]);

        Mualaf::create([
            'tenant_id' => $tenantJeddah->id,
            'nomor_registrasi' => 'MLF-20261101-202',
            'nik_paspor' => '3201982716350007',
            'nama_lengkap' => 'Kenji Sato',
            'nama_hijrah' => 'Kenzou Sato',
            'tempat_lahir' => 'Tokyo',
            'tanggal_lahir' => '1994-12-05',
            'gender' => 'male',
            'pekerjaan' => 'Fotografer',
            'telepon' => '081234567896',
            'alamat_domisili' => 'Distrik Al-Hamra, Jeddah',
            'agama_asal' => 'Shinto',
            'tanggal_syahadat' => '2026-10-01',
            'status' => 'proses_bimbingan',
            'dai_id' => $daiJeddah1->id,
            'rekomendasi_dai' => 'none',
            'catatan_rekomendasi_dai' => null,
            'rekomendasi_dai_at' => null,
        ]);

        Mualaf::create([
            'tenant_id' => $tenantJeddah->id,
            'nomor_registrasi' => 'MLF-20261101-203',
            'nik_paspor' => '3201982716350008',
            'nama_lengkap' => 'Priya Patel',
            'nama_hijrah' => null,
            'tempat_lahir' => 'Mumbai',
            'tanggal_lahir' => '2001-05-20',
            'gender' => 'female',
            'pekerjaan' => 'Perawat',
            'telepon' => '081234567897',
            'alamat_domisili' => 'Distrik Al-Bawadi, Jeddah',
            'agama_asal' => 'Hindu',
            'tanggal_syahadat' => '2026-11-01',
            'status' => 'terdaftar',
            'dai_id' => null,
            'rekomendasi_dai' => 'none',
            'catatan_rekomendasi_dai' => null,
            'rekomendasi_dai_at' => null,
        ]);

        // --- TENANT PUSAT (2 Mualaf Pendaftaran Langsung Pusat) ---
        Mualaf::create([
            'tenant_id' => $tenantPusat->id,
            'nomor_registrasi' => 'MLF-20261101-301',
            'nik_paspor' => '3201982716350009',
            'nama_lengkap' => 'Jean-Luc Picard',
            'nama_hijrah' => 'Luqman Picard',
            'tempat_lahir' => 'Paris',
            'tanggal_lahir' => '1991-08-14',
            'gender' => 'male',
            'pekerjaan' => 'Dosen / Akademisi',
            'telepon' => '081234567898',
            'alamat_domisili' => 'Kompleks Kemenag Pusat',
            'agama_asal' => 'Agnostik',
            'tanggal_syahadat' => '2026-05-10',
            'status' => 'lulus',
            'dai_id' => null,
            'rekomendasi_dai' => 'lulus',
            'catatan_rekomendasi_dai' => 'Lulus bimbingan intensif tingkat pusat.',
            'rekomendasi_dai_at' => '2026-08-01 15:00:00',
        ]);

        Mualaf::create([
            'tenant_id' => $tenantPusat->id,
            'nomor_registrasi' => 'MLF-20261101-302',
            'nik_paspor' => '3201982716350010',
            'nama_lengkap' => 'Dmitry Ivanov',
            'nama_hijrah' => 'Daud Ivanov',
            'tempat_lahir' => 'Moscow',
            'tanggal_lahir' => '1993-02-28',
            'gender' => 'male',
            'pekerjaan' => 'Teknikus Mesin',
            'telepon' => '081234567899',
            'alamat_domisili' => 'Kompleks Kemenag Pusat',
            'agama_asal' => 'Kristen Ortodoks',
            'tanggal_syahadat' => '2026-10-15',
            'status' => 'proses_bimbingan',
            'dai_id' => null,
            'rekomendasi_dai' => 'none',
            'catatan_rekomendasi_dai' => null,
            'rekomendasi_dai_at' => null,
        ]);

        // =========================================================================
        // 4. LOG ARSIP RIWAYAT DROPOUT (Untuk Deteksi NIK Nasional)
        // =========================================================================
        MualafDropout::create([
            'tenant_id' => $tenantRiyadh->id,
            'mualaf_id' => $mualafDropout->id,
            'nik_paspor' => $mualafDropout->nik_paspor,
            'nama_lengkap' => $mualafDropout->nama_lengkap,
            'dai_id' => $daiRiyadh2->id,
            'alasan_dropout' => $mualafDropout->catatan_rekomendasi_dai,
            'total_sesi_diikuti' => 2,
            'dropped_at' => '2026-09-12 08:00:00',
            'approved_by' => $adminRiyadh->id,
        ]);
    }
}