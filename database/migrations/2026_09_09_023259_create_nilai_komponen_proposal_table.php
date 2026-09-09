<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('nilai_komponen_proposal', function (Blueprint $table) {
            $table->id();
            $table->foreignId('submission_id')->constrained('submission_proposal');
            $table->foreignId('komponen_id')->constrained('komponen_penilaian');
            $table->integer('nilai')->nullable();
            $table->text('komentar')->nullable();
            $table->boolean('terkunci')->default(false);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('nilai_komponen_proposal');
    }
};