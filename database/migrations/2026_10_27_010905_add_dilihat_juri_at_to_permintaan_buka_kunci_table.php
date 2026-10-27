<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('permintaan_buka_kunci', function (Blueprint $table) {
            $table->timestamp('dilihat_juri_at')->nullable()->after('status_persetujuan');
        });

        // Permintaan lama yang sudah diproses dianggap sudah dilihat,
        // supaya penolakan lama tidak tiba-tiba muncul sebagai pemberitahuan baru.
        DB::table('permintaan_buka_kunci')
            ->where('status_persetujuan', '!=', 'menunggu')
            ->update(['dilihat_juri_at' => now()]);
    }

    public function down(): void
    {
        Schema::table('permintaan_buka_kunci', function (Blueprint $table) {
            $table->dropColumn('dilihat_juri_at');
        });
    }
};