<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('komponen_penilaian', function (Blueprint $table) {
            $table->integer('jumlah_kata_maksimal')->nullable()->after('bobot');
        });
    }

    public function down(): void
    {
        Schema::table('komponen_penilaian', function (Blueprint $table) {
            $table->dropColumn('jumlah_kata_maksimal');
        });
    }
};