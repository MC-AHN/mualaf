<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('mualaf_dropouts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained('tenants')->cascadeOnDelete();
            $table->foreignId('mualaf_id')->nullable()->constrained('mualaf')->nullOnDelete();
            $table->string('nik_paspor')->index();
            $table->string('nama_lengkap');
            $table->foreignId('dai_id')->nullable()->constrained('users')->nullOnDelete();
            $table->text('alasan_dropout');
            $table->integer('total_sesi_diikuti')->default(0);
            $table->timestamp('dropped_at')->useCurrent();
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });

        Schema::table('mualaf', function (Blueprint $table) {
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::table('mualaf', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::dropIfExists('mualaf_dropouts');
    }
};