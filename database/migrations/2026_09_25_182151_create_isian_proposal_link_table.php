<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('isian_proposal_link', function (Blueprint $table) {
            $table->id();
            $table->foreignId('isian_proposal_id')->constrained('isian_proposal')->cascadeOnDelete();
            $table->string('judul');
            $table->string('link');
            $table->timestamps();
        });

        // Pindahkan data link_bukti_dukung lama (1 link per komponen) ke tabel baru,
        // supaya isian yang sudah pernah diisi peserta tidak hilang.
        $lama = \DB::table('isian_proposal')->whereNotNull('link_bukti_dukung')->where('link_bukti_dukung', '!=', '')->get();
        foreach ($lama as $baris) {
            \DB::table('isian_proposal_link')->insert([
                'isian_proposal_id' => $baris->id,
                'judul' => 'Bukti Dukung',
                'link' => $baris->link_bukti_dukung,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('isian_proposal_link');
    }
};