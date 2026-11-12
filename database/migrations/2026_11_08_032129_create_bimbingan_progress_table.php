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
        Schema::create('bimbingan_progress', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mualaf_id')->constrained('mualaf')->cascadeOnDelete();
            $table->string('tanggal_bimbingan');
            $table->string('pembimbing')->nullable();
            $table->json('materi_selesai')->nullable();
            $table->text('catatan')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bimbingan_progress');
    }
};
