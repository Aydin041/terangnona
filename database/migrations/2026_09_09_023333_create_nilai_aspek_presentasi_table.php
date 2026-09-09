<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('nilai_aspek_presentasi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('submission_id')->constrained('submission_presentasi');
            $table->string('aspek');
            $table->integer('nilai')->nullable();
            $table->text('catatan')->nullable();
            $table->boolean('terkunci')->default(false);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('nilai_aspek_presentasi');
    }
};