<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pengajuan', function (Blueprint $table) {
            $table->string('jenis_inovasi')->nullable()->after('bentuk_inovasi');
            $table->string('nama_narahubung')->nullable()->after('jenis_inovasi');
            $table->string('kontak_narahubung')->nullable()->after('nama_narahubung');
            $table->string('email_narahubung')->nullable()->after('kontak_narahubung');
        });
    }

    public function down(): void
    {
        Schema::table('pengajuan', function (Blueprint $table) {
            $table->dropColumn(['jenis_inovasi', 'nama_narahubung', 'kontak_narahubung', 'email_narahubung']);
        });
    }
};