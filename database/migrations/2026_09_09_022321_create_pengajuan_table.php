<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengajuan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('peserta_id')->constrained('peserta');
            $table->foreignId('kategori_id')->constrained('kategori');
            $table->string('nama_inovasi');
            $table->string('akronim');
            $table->string('bentuk_inovasi');
            $table->integer('tahun_implementasi');
            $table->text('deskripsi');
            $table->string('status')->default('menunggu_pemeriksaan');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengajuan');
    }
};