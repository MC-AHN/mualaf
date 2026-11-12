<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('mualaf_dai_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mualaf_id')->constrained('mualaf')->cascadeOnDelete();
            $table->foreignId('old_dai_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('new_dai_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('transferred_by')->nullable()->constrained('users')->nullOnDelete();
            $table->text('reason')->nullable();
            $table->timestamp('transferred_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mualaf_dai_histories');
    }
};
