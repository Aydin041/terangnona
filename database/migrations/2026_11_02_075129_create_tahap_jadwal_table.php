<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tahap_jadwal', function (Blueprint $table) {
            $table->id();
            $table->string('kunci', 40)->unique();
            $table->string('nama', 200);
            $table->date('mulai');
            $table->date('selesai');
            $table->string('sorot', 60)->nullable();
            $table->unsignedSmallInteger('urutan')->default(0);
            $table->timestamps();
        });

        // Nilai awal diambil dari config/jadwal.php (jadwal bawaan).
        $sekarang = now();

        foreach (config('jadwal.tahap_awal', []) as $urutan => $tahap) {
            DB::table('tahap_jadwal')->insert([
                'kunci' => $tahap['kunci'],
                'nama' => $tahap['nama'],
                'mulai' => $tahap['mulai'],
                'selesai' => $tahap['selesai'],
                'sorot' => $tahap['sorot'] ?? null,
                'urutan' => $urutan + 1,
                'created_at' => $sekarang,
                'updated_at' => $sekarang,
            ]);
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('tahap_jadwal');
    }
};