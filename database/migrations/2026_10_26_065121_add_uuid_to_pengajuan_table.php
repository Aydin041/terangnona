<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pengajuan', function (Blueprint $table) {
            $table->uuid('uuid')->nullable()->unique()->after('id');
        });

        // Isi kode acak untuk pengajuan yang sudah ada.
        DB::table('pengajuan')->whereNull('uuid')->orderBy('id')->each(function ($baris) {
            DB::table('pengajuan')
                ->where('id', $baris->id)
                ->update(['uuid' => (string) Str::uuid()]);
        });
    }

    public function down(): void
    {
        Schema::table('pengajuan', function (Blueprint $table) {
            $table->dropUnique(['uuid']);
            $table->dropColumn('uuid');
        });
    }
};