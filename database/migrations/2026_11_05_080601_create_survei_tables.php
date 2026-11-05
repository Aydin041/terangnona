<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Waktu buka dan tutup survei, diatur Admin di halaman Pengaturan.
        Schema::table('pengaturan', function (Blueprint $table) {
            $table->dateTime('survei_dibuka_pada')->nullable();
            $table->dateTime('survei_ditutup_pada')->nullable();
        });

        // Data partisipasi: siapa yang sudah mengisi. Tidak memuat jawaban dan tidak memuat waktu.
        Schema::create('survei_partisipasi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('peserta_id')->unique()->constrained('peserta')->cascadeOnDelete();
        });

        // Data jawaban: sengaja TANPA kolom peserta, tanpa relasi apa pun ke peserta,
        // tanpa waktu, dan dengan ID acak (bukan angka urut) agar tidak bisa dicocokkan
        // dengan urutan pengisian.
        Schema::create('survei_jawaban', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->unsignedTinyInteger('nilai');
            $table->json('aspek');
            $table->text('saran');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('survei_jawaban');
        Schema::dropIfExists('survei_partisipasi');

        Schema::table('pengaturan', function (Blueprint $table) {
            $table->dropColumn(['survei_dibuka_pada', 'survei_ditutup_pada']);
        });
    }
};