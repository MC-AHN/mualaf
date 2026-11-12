<!DOCTYPE html>
<html lang="id" class="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Informasi Manajemen Mualaf - Kemenag Multi-Tenant</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
        }
    </style>
</head>

<body
    class="bg-gray-950 text-gray-100 antialiased selection:bg-amber-500 selection:text-black min-h-screen flex flex-col">

    <!-- HEADER / NAVBAR -->
    <header class="border-b border-gray-800 bg-gray-900/90 backdrop-blur sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-6 lg:px-8 py-5 flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="flex items-center gap-4">
                <div
                    class="w-12 h-12 rounded-2xl bg-amber-500 flex items-center justify-center font-extrabold text-gray-950 text-2xl shadow-lg shadow-amber-500/20">
                    M
                </div>
                <div>
                    <h1 class="text-xl font-bold tracking-tight text-white">Mualaf Center</h1>
                    <p class="text-sm text-gray-400">Sistem Informasi & Bimbingan Nasional</p>
                </div>
            </div>
            <div class="flex items-center gap-3 w-full sm:w-auto justify-end">
                <a href="/staf/login"
                    class="px-5 py-2.5 text-sm font-semibold rounded-xl bg-gray-800 hover:bg-gray-700 border border-gray-700 text-gray-200 transition">
                    Panel Pusat
                </a>
                <a href="/staf/login"
                    class="px-5 py-2.5 text-sm font-bold rounded-xl bg-amber-500 hover:bg-amber-400 text-gray-950 shadow-lg shadow-amber-500/20 transition">
                    Masuk Demo Cabang &rarr;
                </a>
            </div>
        </div>
    </header>

    <main class="flex-grow max-w-7xl mx-auto px-6 lg:px-8 py-12 space-y-16">

        <!-- HERO SECTION -->
        <section class="text-center max-w-4xl mx-auto space-y-6">
            <span
                class="inline-block px-4 py-1.5 text-sm font-semibold bg-amber-500/10 text-amber-400 border border-amber-500/20 rounded-full">
                Environment Testing & Public Portal Documentation
            </span>
            <h2 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold text-white tracking-tight leading-tight">
                Sistem Informasi Manajemen Mualaf <br>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-amber-400 to-amber-200">
                    Multi-Tenant & Audit Trail Log
                </span>
            </h2>
            <p class="text-lg sm:text-xl text-gray-300 leading-relaxed font-normal">
                Platform terintegrasi untuk tata kelola pendaftaran mualaf, penugasan Da'i pembimbing, pelacakan
                kurikulum bimbingan, hingga penerbitan sertifikat resmi antara Kemenag Pusat dan Cabang Daerah.
            </p>
        </section>

        <!-- AKUN DUMMY UNTUK TESTING -->
        <section
            class="bg-gradient-to-b from-amber-950/30 to-gray-900/50 border border-amber-500/30 rounded-3xl p-8 lg:p-10 shadow-2xl space-y-8">
            <div
                class="flex flex-col lg:flex-row lg:items-center justify-between gap-6 border-b border-amber-500/20 pb-6">
                <div>
                    <h3 class="text-2xl font-bold text-amber-400 flex items-center gap-3">
                        <span class="text-3xl">🔑</span> Akun Pengujian System (Testing Credentials)
                    </h3>
                    <p class="text-base text-gray-300 mt-2">
                        Gunakan akun seeder di bawah ini untuk menguji hak akses dan alur kerja sesuai dengan perannya
                        masing-masing.
                    </p>
                </div>
                <div
                    class="bg-gray-900 border border-amber-500/40 px-5 py-3 rounded-2xl text-amber-300 font-mono text-base font-semibold self-start lg:self-auto shadow-inner">
                    Password Semua Akun: <span class="text-white font-bold underline">admin</span>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- SUPERADMIN PUSAT -->
                <div
                    class="bg-gray-900/90 border border-gray-800 hover:border-red-500/50 rounded-2xl p-6 flex flex-col justify-between space-y-6 transition group">
                    <div class="space-y-4">
                        <div class="flex justify-between items-center">
                            <span
                                class="text-xs font-bold px-3 py-1 bg-red-500/10 text-red-400 border border-red-500/20 rounded-lg">PUSAT</span>
                            <span class="text-xs text-gray-400 font-mono">Superadmin</span>
                        </div>
                        <div>
                            <h4 class="text-lg font-bold text-white group-hover:text-red-400 transition">Superadmin
                                Pusat</h4>
                            <p class="text-sm font-mono text-gray-400 mt-1">superadmin@mualaf.go.id</p>
                        </div>
                    </div>
                    <a href="/staf/login"
                        class="w-full text-center py-3 text-sm font-semibold rounded-xl bg-gray-800 hover:bg-gray-700 text-red-400 border border-gray-700 transition">
                        Login Superadmin Pusat &rarr;
                    </a>
                </div>

                <!-- STAF PUSAT -->
                <div
                    class="bg-gray-900/90 border border-gray-800 hover:border-purple-500/50 rounded-2xl p-6 flex flex-col justify-between space-y-6 transition group">
                    <div class="space-y-4">
                        <div class="flex justify-between items-center">
                            <span
                                class="text-xs font-bold px-3 py-1 bg-purple-500/10 text-purple-400 border border-purple-500/20 rounded-lg">PUSAT</span>
                            <span class="text-xs text-gray-400 font-mono">Staf Pusat</span>
                        </div>
                        <div>
                            <h4 class="text-lg font-bold text-white group-hover:text-purple-400 transition">Staf Auditor
                                Pusat</h4>
                            <p class="text-sm font-mono text-gray-400 mt-1">staf@mualaf.go.id</p>
                        </div>
                    </div>
                    <a href="/staf/login"
                        class="w-full text-center py-3 text-sm font-semibold rounded-xl bg-gray-800 hover:bg-gray-700 text-purple-400 border border-gray-700 transition">
                        Login Staf Pusat &rarr;
                    </a>
                </div>

                <!-- ADMIN CABANG -->
                <div
                    class="bg-gray-900/90 border border-gray-800 hover:border-amber-500/50 rounded-2xl p-6 flex flex-col justify-between space-y-6 transition group">
                    <div class="space-y-4">
                        <div class="flex justify-between items-center">
                            <span
                                class="text-xs font-bold px-3 py-1 bg-amber-500/10 text-amber-400 border border-amber-500/20 rounded-lg">CABANG</span>
                            <span class="text-xs text-gray-400 font-mono">Admin</span>
                        </div>
                        <div>
                            <h4 class="text-lg font-bold text-white group-hover:text-amber-400 transition">Admin Kemenag
                                Riyadh</h4>
                            <p class="text-sm font-mono text-gray-400 mt-1">admin.riyadh@kemenag.gov.sa</p>
                        </div>
                    </div>
                    <a href="/staf/login"
                        class="w-full text-center py-3 text-sm font-bold rounded-xl bg-amber-500 hover:bg-amber-400 text-gray-950 shadow-md transition">
                        Login Admin Cabang &rarr;
                    </a>
                </div>

                <!-- DA'I PEMBIMBING -->
                <div
                    class="bg-gray-900/90 border border-gray-800 hover:border-green-500/50 rounded-2xl p-6 flex flex-col justify-between space-y-6 transition group">
                    <div class="space-y-4">
                        <div class="flex justify-between items-center">
                            <span
                                class="text-xs font-bold px-3 py-1 bg-green-500/10 text-green-400 border border-green-500/20 rounded-lg">CABANG</span>
                            <span class="text-xs text-gray-400 font-mono">Da'i</span>
                        </div>
                        <div>
                            <h4 class="text-lg font-bold text-white group-hover:text-green-400 transition">Ustadz
                                Abdullah</h4>
                            <p class="text-sm font-mono text-gray-400 mt-1">dai.abdullah@kemenag.gov.sa</p>
                        </div>
                    </div>
                    <a href="/staf/login"
                        class="w-full text-center py-3 text-sm font-semibold rounded-xl bg-gray-800 hover:bg-gray-700 text-green-400 border border-gray-700 transition">
                        Login Panel Da'i &rarr;
                    </a>
                </div>

                <!-- STAF AUDITOR CABANG -->
                <div
                    class="bg-gray-900/90 border border-gray-800 hover:border-blue-500/50 rounded-2xl p-6 flex flex-col justify-between space-y-6 transition group">
                    <div class="space-y-4">
                        <div class="flex justify-between items-center">
                            <span
                                class="text-xs font-bold px-3 py-1 bg-blue-500/10 text-blue-400 border border-blue-500/20 rounded-lg">CABANG</span>
                            <span class="text-xs text-gray-400 font-mono">Staf Cabang</span>
                        </div>
                        <div>
                            <h4 class="text-lg font-bold text-white group-hover:text-blue-400 transition">Staf Auditor
                                Riyadh</h4>
                            <p class="text-sm font-mono text-gray-400 mt-1">staf.riyadh@kemenag.gov.sa</p>
                        </div>
                    </div>
                    <a href="/staf/login"
                        class="w-full text-center py-3 text-sm font-semibold rounded-xl bg-gray-800 hover:bg-gray-700 text-blue-400 border border-gray-700 transition">
                        Login Staf Cabang &rarr;
                    </a>
                </div>
            </div>
        </section>

        <!-- PEMETAAN TUGAS PER ROLE (RBAC) -->
        <section class="space-y-8">
            <div class="space-y-2">
                <h3 class="text-3xl font-bold text-white flex items-center gap-3">
                    🛡️ Pembagian Peran & Hak Akses (RBAC)
                </h3>
                <p class="text-base text-gray-400">Setiap peran memiliki batasan kewenangan yang jelas untuk menjaga
                    keamanan dan akuntabilitas data.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- SUPERADMIN PUSAT -->
                <div class="bg-gray-900 border border-gray-800 rounded-2xl p-6 space-y-4">
                    <div class="flex items-center gap-3 text-red-400 font-bold text-lg border-b border-gray-800 pb-4">
                        <span class="w-3.5 h-3.5 rounded-full bg-red-500"></span>
                        Superadmin Pusat
                    </div>
                    <ul class="text-base text-gray-300 space-y-3 leading-relaxed">
                        <li class="flex items-start gap-2">
                            <span class="text-red-400 font-bold">•</span>
                            <span>Mengelola seluruh Tenant Cabang Daerah secara nasional.</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="text-red-400 font-bold">•</span>
                            <span>Mengatur penuh akun pengguna lintas cabang dan Staf Pusat.</span>
                        </li>
                    </ul>
                </div>

                <!-- STAF PUSAT -->
                <div class="bg-gray-900 border border-gray-800 rounded-2xl p-6 space-y-4">
                    <div
                        class="flex items-center gap-3 text-purple-400 font-bold text-lg border-b border-gray-800 pb-4">
                        <span class="w-3.5 h-3.5 rounded-full bg-purple-500"></span>
                        Staf Pusat (Auditor)
                    </div>
                    <ul class="text-base text-gray-300 space-y-3 leading-relaxed">
                        <li class="flex items-start gap-2">
                            <span class="text-purple-400 font-bold">•</span>
                            <span>Memeriksa dan mengaudit data mualaf lintas cabang daerah.</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="text-purple-400 font-bold">•</span>
                            <span>Melihat progres bimbingan dan status kelulusan tanpa hak ubah data
                                (<em>read-only</em>).</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="text-purple-400 font-bold">•</span>
                            <span>Memantau seluruh data mualaf dan jejak riwayat dropout nasional.</span>
                        </li>
                    </ul>
                </div>

                <!-- ADMIN CABANG -->
                <div class="bg-gray-900 border border-gray-800 rounded-2xl p-6 space-y-4">
                    <div class="flex items-center gap-3 text-amber-400 font-bold text-lg border-b border-gray-800 pb-4">
                        <span class="w-3.5 h-3.5 rounded-full bg-amber-500"></span>
                        Admin Cabang
                    </div>
                    <ul class="text-base text-gray-300 space-y-3 leading-relaxed">
                        <li class="flex items-start gap-2">
                            <span class="text-amber-400 font-bold">•</span>
                            <span>Mendaftarkan mualaf baru dan menetapkan Da'i pembimbing awal.</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="text-amber-400 font-bold">•</span>
                            <span>Melakukan <strong>Pengalihan Darurat (Bulk Re-assign)</strong> jika Da'i sakit atau
                                izin lama.</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="text-amber-400 font-bold">•</span>
                            <span>Menyetujui rekomendasi kelulusan/dropout dan mencetak Sertifikat resmi.</span>
                        </li>
                    </ul>
                </div>

                <!-- DA'I & STAF CABANG -->
                <div class="bg-gray-900 border border-gray-800 rounded-2xl p-6 space-y-4">
                    <div class="flex items-center gap-3 text-green-400 font-bold text-lg border-b border-gray-800 pb-4">
                        <span class="w-3.5 h-3.5 rounded-full bg-green-500"></span>
                        Da'i & Staf Cabang
                    </div>
                    <ul class="text-base text-gray-300 space-y-3 leading-relaxed">
                        <li class="flex items-start gap-2">
                            <span class="text-green-400 font-bold">•</span>
                            <span><strong class="text-white">Da'i:</strong> Mengisi progres materi bimbingan serta
                                mengajukan rekomendasi lulus atau dropout.</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="text-blue-400 font-bold">•</span>
                            <span><strong class="text-white">Staf Cabang:</strong> Mengaudit data bimbingan di wilayah
                                cabangnya (<em>read-only</em>).</span>
                        </li>
                    </ul>
                </div>
            </div>
        </section>

        <!-- ALUR PERJALANAN DATA LENGKAP -->
        <section class="space-y-8">
            <div class="space-y-2">
                <h3 class="text-3xl font-bold text-white">🔄 Alur Perjalanan Data (End-to-End)</h3>
                <p class="text-base text-gray-400">Proses bimbingan berjalan bertahap dari pendaftaran hingga
                    diterbitkannya sertifikat atau pencatatan dropout.</p>
            </div>

            <div class="space-y-6">
                <!-- TAHAP 1 -->
                <div
                    class="bg-gray-900 border border-gray-800 rounded-2xl p-8 flex flex-col md:flex-row gap-6 items-start">
                    <div
                        class="w-14 h-14 rounded-2xl bg-amber-500/10 border border-amber-500/30 text-amber-400 flex items-center justify-center font-extrabold text-2xl shrink-0">
                        1
                    </div>
                    <div class="space-y-2">
                        <div class="flex flex-wrap items-center gap-3">
                            <h4 class="text-xl font-bold text-white">Tahap Pendaftaran & Deteksi Riwayat</h4>
                            <span
                                class="px-3 py-1 text-xs font-mono font-semibold bg-blue-500/10 text-blue-400 border border-blue-500/20 rounded-lg">Status:
                                TERDAFTAR</span>
                        </div>
                        <p class="text-base text-gray-300 leading-relaxed">
                            Admin Cabang menginput identitas mualaf (NIK/Paspor, Nama, Agama Asal, Scan KTP). Sistem
                            otomatis memeriksa NIK secara nasional; jika NIK tersebut pernah tercatat <strong
                                class="text-white">dropout</strong> di masa lampau, sistem langsung menampilkan
                            peringatan riwayat kepada Admin Cabang.
                        </p>
                    </div>
                </div>

                <!-- TAHAP 2 -->
                <div
                    class="bg-gray-900 border border-gray-800 rounded-2xl p-8 flex flex-col md:flex-row gap-6 items-start">
                    <div
                        class="w-14 h-14 rounded-2xl bg-amber-500/10 border border-amber-500/30 text-amber-400 flex items-center justify-center font-extrabold text-2xl shrink-0">
                        2
                    </div>
                    <div class="space-y-2">
                        <div class="flex flex-wrap items-center gap-3">
                            <h4 class="text-xl font-bold text-white">Penetapan Pembimbing & Bimbingan</h4>
                            <span
                                class="px-3 py-1 text-xs font-mono font-semibold bg-amber-500/10 text-amber-400 border border-amber-500/20 rounded-lg">Status:
                                PROSES_BIMBINGAN</span>
                        </div>
                        <p class="text-base text-gray-300 leading-relaxed">
                            Admin Cabang menetapkan Da'i Pembimbing aktif. Status mualaf otomatis berubah menjadi <code
                                class="text-amber-400 font-mono">Proses Bimbingan</code>, dan kolom pilihan Da'i pada
                            form Edit otomatis dikunci (<em>disabled</em>) agar tidak bisa diubah secara manual tanpa
                            pencatatan riwayat.
                        </p>
                    </div>
                </div>

                <!-- TAHAP 3 -->
                <div
                    class="bg-gray-900 border-l-4 border-l-amber-500 border-y border-r border-gray-800 rounded-2xl p-8 flex flex-col md:flex-row gap-6 items-start">
                    <div
                        class="w-14 h-14 rounded-2xl bg-amber-500/10 border border-amber-500/30 text-amber-400 flex items-center justify-center font-extrabold text-2xl shrink-0">
                        3
                    </div>
                    <div class="space-y-2">
                        <div class="flex flex-wrap items-center gap-3">
                            <h4 class="text-xl font-bold text-white">Penanganan Darurat (Pengalihan Da'i & Audit Log)
                            </h4>
                            <span
                                class="px-3 py-1 text-xs font-mono font-semibold bg-yellow-500/10 text-yellow-400 border border-yellow-500/20 rounded-lg">Audit
                                Trail Active</span>
                        </div>
                        <p class="text-base text-gray-300 leading-relaxed">
                            Jika Da'i sakit, kecelakaan, atau izin dalam waktu lama, Admin Cabang menonaktifkan akun
                            Da'i tersebut, mencentang mualaf bimbingannya di tabel, lalu menjalankan <strong>Bulk
                                Action: "Alihkan ke Da'i Lain"</strong>. Seluruh riwayat perpindahan pembimbing tercatat
                            otomatis ke dalam tabel <code class="text-amber-400 font-mono">mualaf_dai_histories</code>.
                        </p>
                    </div>
                </div>

                <!-- TAHAP 4 -->
                <div
                    class="bg-gray-900 border border-gray-800 rounded-2xl p-8 flex flex-col md:flex-row gap-6 items-start">
                    <div
                        class="w-14 h-14 rounded-2xl bg-purple-500/10 border border-purple-500/30 text-purple-400 flex items-center justify-center font-extrabold text-2xl shrink-0">
                        4
                    </div>
                    <div class="space-y-2">
                        <div class="flex flex-wrap items-center gap-3">
                            <h4 class="text-xl font-bold text-white">Rekomendasi Da'i (Lulus / Dropout)</h4>
                            <span
                                class="px-3 py-1 text-xs font-mono font-semibold bg-purple-500/10 text-purple-400 border border-purple-500/20 rounded-lg">Evaluasi
                                Pembelajaran</span>
                        </div>
                        <p class="text-base text-gray-300 leading-relaxed">
                            Da'i dapat mengajukan <strong class="text-white">Rekomendasi Lulus</strong> hanya apabila
                            seluruh materi kurikulum telah selesai dituntaskan. Sebaliknya, jika mualaf berhenti di
                            tengah jalan, Da'i dapat mengajukan <strong class="text-white">Rekomendasi Dropout</strong>
                            kapan saja selama masa pembelajaran beserta alasannya.
                        </p>
                    </div>
                </div>

                <!-- TAHAP 5 -->
                <div
                    class="bg-gray-900 border border-gray-800 rounded-2xl p-8 flex flex-col md:flex-row gap-6 items-start">
                    <div
                        class="w-14 h-14 rounded-2xl bg-green-500/10 border border-green-500/30 text-green-400 flex items-center justify-center font-extrabold text-2xl shrink-0">
                        5
                    </div>
                    <div class="space-y-2">
                        <div class="flex flex-wrap items-center gap-3">
                            <h4 class="text-xl font-bold text-white">Keputusan Akhir Admin (Cetak Sertifikat / Arsip
                                Dropout)</h4>
                            <span
                                class="px-3 py-1 text-xs font-mono font-semibold bg-green-500/10 text-green-400 border border-green-500/20 rounded-lg">Status:
                                LULUS / DROP_OUT</span>
                        </div>
                        <p class="text-base text-gray-300 leading-relaxed">
                            Admin Cabang memverifikasi rekomendasi Da'i. Jika disetujui <strong
                                class="text-green-400">Lulus</strong>, sertifikat resmi langsung tersedia untuk dicetak.
                            Jika disetujui <strong class="text-red-400">Dropout</strong>, rekam jejak mualaf disimpan
                            dalam log historis nasional sebagai referensi jika mendaftar kembali di kemudian hari.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- SKENARIO UJI COBA -->
        <section class="bg-gray-900 border border-gray-800 rounded-3xl p-8 lg:p-10 space-y-6">
            <h3 class="text-2xl font-bold text-white flex items-center gap-3">
                🧪 Skenario Pengujian Mandiri (Testing Guide)
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-gray-950 p-6 rounded-2xl border border-gray-800 space-y-3">
                    <h4 class="text-lg font-bold text-amber-400">Skenario 1: Pengalihan Da'i Darurat</h4>
                    <ol class="list-decimal list-inside text-base text-gray-300 space-y-2 leading-relaxed">
                        <li>Login sebagai <strong class="text-white">Admin Cabang</strong>.</li>
                        <li>Buka menu <strong class="text-white">Kelola Pengguna Cabang</strong> &rarr; klik <strong
                                class="text-white">Non-aktifkan</strong> pada Ustadz Abdullah.</li>
                        <li>Buka menu <strong class="text-white">Pendataan Mualaf</strong> &rarr; centang mualaf
                            bimbingannya.</li>
                        <li>Pilih Bulk Action <strong class="text-white">"Alihkan ke Da'i Lain"</strong> &rarr; alihkan
                            ke Ustadz Ahmad.</li>
                    </ol>
                </div>

                <div class="bg-gray-950 p-6 rounded-2xl border border-gray-800 space-y-3">
                    <h4 class="text-lg font-bold text-amber-400">Skenario 2: Proteksi Penguncian Manual</h4>
                    <ol class="list-decimal list-inside text-base text-gray-300 space-y-2 leading-relaxed">
                        <li>Pilih mualaf yang berstatus <strong class="text-white">Proses Bimbingan</strong>.</li>
                        <li>Klik tombol <strong class="text-white">Edit</strong> pada mualaf tersebut.</li>
                        <li>Perhatikan bahwa dropdown <strong class="text-white">Penetapan Da'i</strong> terkunci rapat
                            (disabled) agar pergantian wajib lewat Bulk Action berserta alasannya.</li>
                    </ol>
                </div>
            </div>
        </section>

    </main>

    <!-- FOOTER -->
    <footer class="border-t border-gray-800 bg-gray-900/50 py-8 text-center text-sm text-gray-400">
        <p>© {{ date('Y') }} Sistem Informasi Mualaf Kemenag. Built with Laravel 11 & Filament v3.</p>
    </footer>

</body>

</html>