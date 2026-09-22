<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengaturan', function (Blueprint $table) {
            $table->id();
            $table->dateTime('deadline_pengajuan')->nullable();
            $table->timestamps();
        });

        // Baris tunggal (id=1) yang dipakai terus — bukan tabel banyak baris.
        \DB::table('pengaturan')->insert([
            'deadline_pengajuan' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('pengaturan');
    }
};