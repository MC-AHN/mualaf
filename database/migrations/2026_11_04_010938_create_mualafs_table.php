<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('mualaf', function (Blueprint $table) {
            $table->id();

            $table->foreignId('tenant_id')->constrained('tenants')->cascadeOnDelete();

            $table->string('nomor_registrasi');
            $table->string('nik_paspor');
            $table->string('nama_lengkap');
            $table->string('nama_hijrah')->nullable();
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->enum('gender', ['male', 'female']);
            $table->string('pekerjaan')->nullable();
            $table->string('telepon');
            $table->text('alamat_domisili');
            $table->string('agama_asal');
            $table->date('tanggal_syahadat');
            $table->string('nama_pembimbing')->nullable();
            $table->string('file_identitas')->nullable();
            $table->enum('status', [
                'terdaftar',
                'pending_approval_pendaftaran',
                'proses_bimbingan',
                'pending_approval_lulus',
                'lulus',
                'pending_pembatalan_lulus',
                'pending_approval_dropout',
                'drop_out',
                'meninggal',
                'pindah_domisili',
                'non_aktif_missing',
                'rejected_by_pusat',
            ])->default('terdaftar');
            $table->foreignId('dai_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->enum('rekomendasi_dai', ['none', 'lulus', 'dropout'])->default('none');
            $table->text('catatan_rekomendasi_dai')->nullable();
            $table->timestamp('rekomendasi_dai_at')->nullable();

            $table->timestamps();

            $table->unique(['tenant_id', 'nik_paspor']);
            $table->unique(['tenant_id', 'nomor_registrasi']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mualafs');
    }
};
