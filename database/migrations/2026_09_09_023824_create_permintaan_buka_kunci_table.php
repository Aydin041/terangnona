<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('permintaan_buka_kunci', function (Blueprint $table) {
            $table->id();
            $table->foreignId('juri_id')->constrained('juri');
            $table->foreignId('pengajuan_id')->constrained('pengajuan');
            $table->string('tahap'); // proposal / presentasi
            $table->foreignId('komponen_id')->nullable()->constrained('komponen_penilaian');
            $table->string('aspek')->nullable();
            $table->text('alasan');
            $table->string('status_persetujuan')->default('menunggu'); // menunggu / disetujui / ditolak
            $table->foreignId('admin_id')->nullable()->constrained('admin');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('permintaan_buka_kunci');
    }
};